<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Resignation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResignationApprovedMail;
use App\Mail\ResignationRejectedMail;
use App\Mail\ResignationStatusMail;
use App\Models\User;
use App\Models\MemberRegister;
use Illuminate\Support\Facades\Log;
use App\Notifications\ResignationApprovedNotification;
use App\Notifications\ResignationRejectedNotification;
use App\Models\Transaction;

class ListController extends Controller
{
    public function index(Request $request)
    {
        // Start with a subquery to get the latest records
        $latestRecords = DB::table('member_register')
            ->select('email', DB::raw('MAX(updated_at) as latest_update'))
            ->groupBy('email');

        $query = Member::query()
            ->joinSub($latestRecords, 'latest_records', function ($join) {
                $join->on('member_register.email', '=', 'latest_records.email')
                     ->on('member_register.updated_at', '=', 'latest_records.latest_update');
            })
            ->with('resignations');

        // Search by name
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Get all members with pagination
        $members = $query->orderBy('member_register.created_at', 'desc')->paginate(10);

        // Separate members with pending resignations
        $pendingResignations = $members->filter(function ($member) {
            return $member->resignations()->where('status', 'pending')->exists();
        });

        // Get the rest of the members without pending resignations
        $otherMembers = $members->diff($pendingResignations);

        // Merge the two collections, with pending resignations first
        $sortedMembers = $pendingResignations->merge($otherMembers);

        // Create a new paginator for the sorted members
        $sortedMembers = new \Illuminate\Pagination\LengthAwarePaginator(
            $sortedMembers->forPage($request->get('page', 1), 10),
            $sortedMembers->count(),
            10,
            $request->get('page', 1),
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('admin.list.lists', compact('sortedMembers'));
    }

    public function view($id)
    {
        // Fetch the member and their resignation request
        $member = Member::with('resignation')->findOrFail($id);
        $resignation = $member->resignation; // Get the resignation record

        return view('admin.list.view', compact('member', 'resignation'));
    }

    public function approve($id)
    {
        $resignation = Resignation::findOrFail($id);
        $member = Member::findOrFail($resignation->member_id);

        // Update the resignation status
        $resignation->update(['status' => 'approved', 'is_active' => false]);
        
        // Update member status to 'resigned'
        $member->update(['status' => 'resigned']); // Change 'berhenti' to 'resigned'

        // Stop the member's savings from auto-updating
        $this->stopMemberSavings($member);

        // Send notification
        $resignation->member->notify(new ResignationApprovedNotification());

        return redirect()->route('admin.list.index')->with('success', 'Permohonan berhenti ahli telah diluluskan.');
    }

    private function stopMemberSavings($member)
    {
        // No need to update savings table
        // The member's 'resigned' status is sufficient
        // SettingController already checks for member status when updating dividends
        
        Log::info("Member ID {$member->id} savings stopped due to resignation status");
    }

    public function reject($id)
    {
        $resignation = Resignation::findOrFail($id);
        $member = Member::findOrFail($resignation->member_id);

        // Update the resignation status
        $resignation->update(['status' => 'rejected', 'is_active' => false]);

        // Send notification
        $resignation->member->notify(new ResignationRejectedNotification());

        return redirect()->route('admin.list.index')->with('success', 'Permohonan berhenti ahli telah ditolak.');
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            // Validate the request
            $validated = $request->validate([
                'status' => 'required|in:approved,pending,rejected,resigned,deceased',
            ]);

            // Find the member
            $member = Member::findOrFail($id);
            
            // Update member status
            $member->status = $validated['status'];
            $member->save();

            // If status is changed to resigned, invalidate any pending transactions
            if ($validated['status'] === 'resigned') {
                // You might want to update any pending transactions here
                Transaction::where('member_id', $member->id)
                    ->where('status', 'pending')
                    ->update(['status' => 'cancelled']);
            }

            // Send email notification (implement email logic here)
            // Example: Mail::to($member->email)->send(new ResignationStatusMail($member));

            return response()->json([
                'success' => true,
                'message' => 'Status berjaya dikemaskini',
                'status' => $validated['status'],
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ahli tidak dijumpai'
            ], 404);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Pengesahan tidak berjaya'
            ], 422);
        } catch (\Exception $e) {
            Log::error('Ralat semasa mengemaskini status', [
                'error' => $e->getMessage(),
                'member_id' => $id
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Ralat semasa mengemaskini status'
            ], 500);
        }
    }

    public function showUpdateForm($id)
    {
        $resignation = Resignation::findOrFail($id);
        return view('admin.resignations.update', compact('resignation'));
    }

    public function resign($id)
    {
        // Fetch the member and their latest resignation request
        $member = Member::findOrFail($id);
        
        // Get the latest pending resignation if exists
        $latestResignation = Resignation::where('member_id', $member->id)
            ->where('status', 'pending')
            ->latest()
            ->first();

        // Fetch previous resignations for the member (only approved/rejected)
        $previousResignations = Resignation::where('member_id', $member->id)
            ->whereIn('status', ['approved', 'rejected'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.list.resign', compact('latestResignation', 'member', 'previousResignations'));
    }

    public function resignedMembers()
    {
        // Fetch all members who have resigned
        $resignedMembers = Member::whereHas('resignation', function($query) {
            $query->where('is_active', false);
        })->get();

        return view('admin.list.resigned_members', compact('resignedMembers'));
    }

    // Separate method for handling specific resignation
    public function checkResignation($id)
    {
        try {
            $resignation = Resignation::with('member')->findOrFail($id);
            $member = $resignation->member;
            
            // Fetch previous resignations (only approved/rejected)
            $previousResignations = Resignation::where('member_id', $member->id)
                ->whereIn('status', ['approved', 'rejected'])
                ->orderBy('created_at', 'desc')
                ->get();

            return view('admin.list.resign', compact('resignation', 'member', 'previousResignations'));
        } catch (\Exception $e) {
            return redirect()->route('admin.list.index')
                ->with('error', 'Permohonan berhenti menjadi anggota ini tidak ditemui.');
        }
    }

    public function getResignationReasons($id)
    {
        try {
            // Find the resignation record with exact ID
            $resignation = Resignation::find($id);
            
            if (!$resignation) {
                return response()->json([
                    'error' => 'Rekod tidak dijumpai'
                ], 404);
            }

            // Get reasons directly from database columns
            $reasons = [];
            
            // Only add non-null reasons
            if ($resignation->reason1) {
                $reasons['reason1'] = $resignation->reason1;
            }
            if ($resignation->reason2) {
                $reasons['reason2'] = $resignation->reason2;
            }
            if ($resignation->reason3 && $resignation->reason3 !== 'NULL') {
                $reasons['reason3'] = $resignation->reason3;
            }
            if ($resignation->reason4 && $resignation->reason4 !== 'NULL') {
                $reasons['reason4'] = $resignation->reason4;
            }
            if ($resignation->reason5 && $resignation->reason5 !== 'NULL') {
                $reasons['reason5'] = $resignation->reason5;
            }

            // Log the found data for debugging
            \Log::info('Resignation reasons found:', [
                'resignation_id' => $id,
                'reasons' => $reasons
            ]);

            return response()->json($reasons, 200);

        } catch (\Exception $e) {
            \Log::error('Error in getResignationReasons: ' . $e->getMessage(), [
                'resignation_id' => $id
            ]);

            return response()->json([
                'error' => 'Gagal mendapatkan data. Sila cuba lagi.'
            ], 500);
        }
    }
}