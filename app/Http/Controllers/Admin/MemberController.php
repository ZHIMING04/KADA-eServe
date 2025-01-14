<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Member;
use App\Models\User;
use App\Models\WorkingInfo;
use App\Models\Savings;
use App\Models\Family;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Silber\Bouncer\BouncerFacade as Bouncer;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::whereHas('user', function($query) {
                $query->whereIs('member');
            })
            ->select([
                'id',
                'no_anggota',
                'name',
                'email',
                'ic',
                'phone'
            ])
            ->orderBy('no_anggota')
            ->get();

        return view('admin.members', compact('members'));
    }

    public function show($id)
    {
        $member = Member::findOrFail($id);
        $workingInfo = WorkingInfo::where('no_anggota', $member->id)->first();
        $savings = Savings::where('no_anggota', $member->id)->first();
        $familyMembers = Family::where('no_anggota', $member->id)->get();

        return view('admin.member-details', compact('member', 'workingInfo', 'savings', 'familyMembers'));
    }

    public function batchAction(Request $request)
    {
        try {
            if (!$request->has('selected_members')) {
                return redirect()->back()->with('error', 'Sila pilih ahli terlebih dahulu');
            }

            $selectedIds = $request->selected_members;
            $action = $request->action;

            switch ($action) {
                case 'delete':
                    // First remove member role from associated users
                    $members = Member::whereIn('id', $selectedIds)->get();
                    foreach ($members as $member) {
                        if ($member->user) {
                            Bouncer::retract('member')->from($member->user);
                        }
                    }
                    
                    // Then delete the members
                    Member::whereIn('id', $selectedIds)->delete();
                    $message = 'Ahli berjaya dipadamkan';
                    break;
                
                default:
                    return redirect()->back()->with('error', 'Tindakan tidak sah');
            }

            // Refresh bouncer cache
            Bouncer::refresh();

            return redirect()->back()->with('success', $message);
        } catch (\Exception $e) {
            \Log::error('Batch Action Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Ralat: ' . $e->getMessage());
        }
    }

    public function export(Request $request)
    {
        try {
            $ids = explode(',', $request->selected_ids);
            $fields = $request->fields ?? ['no_anggota', 'name', 'email']; // Default fields if none selected
            
            $membersData = Member::whereIn('id', $ids)->get();
            
            if ($membersData->isEmpty()) {
                return back()->with('error', 'No members selected for export');
            }

            $pdf = PDF::loadView('admin.exports.members-pdf', [
                'membersData' => $membersData,
                'fields' => $fields
            ])->setPaper('a4', 'landscape');

            return $pdf->download('members-export-' . now()->format('Y-m-d-His') . '.pdf');

        } catch (\Exception $e) {
            \Log::error('Export Error: ' . $e->getMessage());
            return back()->with('error', 'Error generating PDF: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $member = Member::findOrFail($id);
        $member->delete();
        
        return redirect()->route('admin.members.index')
                        ->with('success', 'Member deleted successfully');
    }

    public function pendingRegistrations()
    {
        // Get pending registrations using the existing Member model
        $registrations = Member::where('status', 'pending')
                             ->orderBy('created_at', 'desc')
                             ->get();

        return view('admin.registrations.pending', compact('registrations'));
    }

    public function promote(User $user)
    {
        try {
            // Remove guest role
            Bouncer::retract('guest')->from($user);
            
            // Assign member role
            Bouncer::assign('member')->to($user);
            
            // Refresh bouncer cache
            Bouncer::refresh();

            return redirect()->route('admin.registrations.pending')
                ->with('success', 'User has been promoted to member successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.registrations.pending')
                ->with('error', 'Failed to promote user: ' . $e->getMessage());
        }
    }

    public function showRegistration($id)
    {
        $member = Member::findOrFail($id);
        $workingInfo = WorkingInfo::where('no_anggota', $member->id)->first();
        $savings = Savings::where('no_anggota', $member->id)->first();
        $familyMembers = Family::where('no_anggota', $member->id)->get();

        return view('admin.registrations.show', compact('member', 'workingInfo', 'savings', 'familyMembers'));
    }

    public function approve($id)
    {
        try {
            DB::transaction(function () use ($id) {
                // Find the member
                $member = Member::findOrFail($id);
                
                // Update member status
                $member->update([
                    'status' => 'approved'
                ]);

                // Find associated user
                $user = User::where('email', $member->email)->first();
                
                if ($user) {
                    // Remove guest role
                    Bouncer::retract('guest')->from($user);
                    
                    // Assign member role
                    Bouncer::assign('member')->to($user);
                    
                    // Refresh bouncer cache
                    Bouncer::refresh();
                }
            });

            return redirect()->route('admin.registrations.pending')
                ->with('success', 'Pendaftaran telah diluluskan dan pengguna telah dinaikkan pangkat ke ahli.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Ralat semasa meluluskan pendaftaran: ' . $e->getMessage());
        }
    }

    public function reject($id)
    {
        try {
            DB::transaction(function () use ($id) {
                // Find the member
                $member = Member::findOrFail($id);
                
                // Update member status
                $member->update([
                    'status' => 'rejected'
                ]);
            });

            return redirect()->route('admin.registrations.pending')
                ->with('success', 'Pendaftaran telah ditolak.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Ralat semasa menolak pendaftaran: ' . $e->getMessage());
        }
    }
} 