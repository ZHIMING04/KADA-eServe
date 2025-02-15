<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Member;
use App\Models\User;
use App\Models\WorkingInfo;
use App\Models\Savings;
use App\Models\Family;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Silber\Bouncer\BouncerFacade as Bouncer;
use App\Models\Loan;
use Illuminate\Support\Facades\Hash;
use App\Notifications\MembershipApproved;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\App;
use App\Notifications\MembershipRejected;
use App\Mail\RegistrationRejected;
use Illuminate\Support\Facades\Mail;


class MemberController extends Controller
{
    public function index()
    {
        // Get approved members with specific attributes
        $members = Member::where('status', 'approved')
            ->select([
                'id',
                'no_anggota',
                'name',
                'ic',
                'phone',
                'email',
                'address',
                'city',
                'postcode',
                'state',
                'status',
                'created_at'
            ])
            ->get();

        return view('admin.members', [
            'members' => $members,
            'currentDividendRate' => Setting::where('key', 'dividend_rate')->value('value') ?? 0
        ]);
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
        // Field translations
        $fieldTranslations = [
            'no_anggota' => 'No. Anggota',
            'name' => 'Nama',
            'email' => 'Email',
            'ic' => 'No. KP',
            'phone' => 'No. Telefon',
            'address' => 'Alamat',
            'city' => 'Bandar',
            'postcode' => 'Poskod',
            'state' => 'Negeri'
        ];

        // Get the members data
        $membersData = Member::query();
        
        // If specific IDs are selected
        if ($request->has('selected_ids')) {
            $selectedIds = explode(',', $request->selected_ids);
            $membersData->whereIn('id', $selectedIds);
        }

        // Get selected fields
        $selectedFields = $request->has('selected_fields') 
            ? explode(',', $request->selected_fields)
            : ['no_anggota', 'name', 'email', 'ic', 'phone']; // Default fields

        $membersData = $membersData->get();

        // Generate PDF
        $pdf = PDF::loadView('admin.exports.members-pdf', [
            'membersData' => $membersData,
            'selectedFields' => $selectedFields,
            'fieldTranslations' => $fieldTranslations
        ]);

        // Change stream() to download() and provide a filename
        return $pdf->download('senarai-ahli-' . now()->format('Y-m-d') . '.pdf');
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
        
        if ($member->payment_proof) {
            try {
                // Get base path based on environment
                $basePath = App::environment('local') 
                    ? 'KADA-eServe/public/uploads/payment_proofs/'
                    : 'public/uploads/payment_proofs/';
                    
                $fileName = basename($member->payment_proof);
                $publicPath = 'uploads/payment_proofs/' . $fileName;
                
                // Check both possible paths
                if (file_exists(public_path($publicPath)) || 
                    file_exists(base_path('../' . $publicPath))) {
                    
                    // Generate URL that works in both environments
                    $member->payment_proof_url = url($publicPath);
                } else {
                    $member->payment_proof_url = null;
                }
            } catch (\Exception $e) {
                $member->payment_proof_url = null;
            }
        }
        
        $workingInfo = WorkingInfo::where('no_anggota', $member->id)->first();
        $savings = Savings::where('no_anggota', $member->id)->first();
        $familyMembers = Family::where('no_anggota', $member->id)->get();

        return view('admin.registrations.show', compact('member', 'workingInfo', 'savings', 'familyMembers'));
    }

    public function approve($id)
    {
        try {
            DB::beginTransaction();
            
            // Find the member registration
            $member = Member::findOrFail($id);
            
            // Check if member is already approved
            if ($member->status === 'approved') {
                throw new \Exception('Member is already approved.');
            }

            // Get the user from guest_id
            $user = User::findOrFail($member->guest_id);

            // Remove guest role first
            Bouncer::retract('guest')->from($user);

            // Assign member role if not already assigned
            if (!$user->isA('member')) {
                Bouncer::assign('member')->to($user);
            }

            // Force refresh user roles cache
            Bouncer::refresh();
            
            // Update member status
            $member->update([
                'status' => 'approved',
                'approved_at' => now()
            ]);

            // Send approval notification
            $member->notify(new MembershipApproved());

            DB::commit();

            // Clear user's cached permissions
            if (auth()->id() === $user->id) {
                auth()->user()->fresh();
            }

            // Redirect to members list with success message
            return redirect()->route('admin.members.index')
                            ->with('success', 'Ahli berjaya diluluskan dan emel pemberitahuan telah dihantar');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Member approval error: ' . $e->getMessage());
            
            // Redirect back with error message
            return redirect()->back()
                            ->with('error', 'Ralat: ' . $e->getMessage());
        }
    }

    public function reject(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'rejection_reason' => 'required|string|min:10',
        ], [
            'rejection_reason.required' => 'Sila nyatakan sebab penolakan.',
            'rejection_reason.min' => 'Sebab penolakan mestilah sekurang-kurangnya 10 aksara.',
        ]);

        DB::beginTransaction();
        try {
            // Find the member
            $member = Member::findOrFail($id);
            
            // Get the user from guest_id
            $user = User::findOrFail($member->guest_id);

            // Update member status
            $member->update([
                'status' => 'rejected',
                'rejection_reason' => $request->rejection_reason,
                'rejected_at' => now()
            ]);

            // Ensure user still has guest role
            if (!$user->isA('guest')) {
                Bouncer::assign('guest')->to($user);
            }

            // Force refresh user roles cache
            Bouncer::refresh();

            // Send email using the new Mail class
            $member->notify(new MembershipRejected($request->rejection_reason));

            DB::commit();

            return redirect()->route('admin.registrations.pending')
                ->with('success', 'Pendaftaran ditolak dan e-mel pemberitahuan telah dihantar.');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Rejection error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Ralat: ' . $e->getMessage());
        }
    }

    public function getMemberLoans($memberId)
    {
        $loans = Loan::where('member_id', $memberId)
            ->where('loan_amount', '>', 0)
            ->where('status', 'approved')
            ->get(['loan_id', 'loan_type_id', 'loan_amount']);
        
        return response()->json($loans);
    }

    public function addTransaction(Request $request, $memberId)
    {
        try {
            $validated = $request->validate([
                'type' => 'required|in:savings,loan',
                'savings_type' => 'required_if:type,savings',
                'loan_id' => 'required_if:type,loan|exists:loans,loan_id',
                'amount' => 'required|numeric|min:0'
            ]);

            DB::beginTransaction();

            if ($validated['type'] === 'savings') {
                $savings = Savings::where('no_anggota', $memberId)->firstOrFail();
                $savingsType = $validated['savings_type'];
                
                // Update the specific savings type
                $savings->$savingsType += $validated['amount'];
                
                // Recalculate total
                $savings->total_amount = $savings->share_capital + 
                                       $savings->subscription_capital + 
                                       $savings->member_deposit + 
                                       $savings->welfare_fund + 
                                       $savings->fixed_savings;
                
                $savings->save();
            } else {
                $loan = Loan::where('loan_id', $validated['loan_id'])->firstOrFail();
                $loan->loan_balance -= $validated['amount'];
                $loan->save();
            }
            
            $transactionId = 'TRX' . date('YmdHis') . rand(1000, 9999);
            Log::info('Generated transaction ID: ' . $transactionId);

            // Create transaction record

            $transaction = new Transaction();
            $transaction->transaction_id = $transactionId;
            $transaction->member_id = $memberId;
            $transaction->type = $validated['type'];
            $transaction->amount = $validated['amount'];
            $transaction->savings_type = $validated['type'] === 'savings' ? $validated['savings_type'] : null;
            $transaction->loan_id = $validated['type'] === 'loan' ? $validated['loan_id'] : null;
            $transaction->payment_method = null;
            $transaction->payment_proof = null;
            $transaction->status = 'approved';
            $transaction->payment_method = 'online';

            $transaction->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berjaya disimpan'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Transaction Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Ralat: ' . $e->getMessage()
            ], 422);
        }
    }

    public function batchDelete(Request $request)
    {
        try {
            if (!$request->has('selected_members')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sila pilih ahli terlebih dahulu'
                ]);
            }

            $selectedIds = $request->selected_members;
            
            // Delete the members
            Member::whereIn('id', $selectedIds)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Ahli berjaya dipadamkan'
            ]);
        } catch (\Exception $e) {
            \Log::error('Batch Delete Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Ralat: ' . $e->getMessage()
            ]);
        }
    }

    public function batchTransaction(Request $request)
    {
        try {
            $validated = $request->validate([
                'member_ids' => 'required|array',
                'member_ids.*' => 'exists:member_register,id',
                'type' => 'required|in:savings',
                'savings_type' => 'required_if:type,savings',
                'amount' => 'required|numeric|min:0'
            ]);

            DB::beginTransaction();

            foreach ($validated['member_ids'] as $memberId) {
                if ($validated['type'] === 'savings') {
                    $member = Member::findOrFail($memberId);
                    $savings = Savings::where('no_anggota', $member->id)->firstOrFail();
                    $savingsType = $validated['savings_type'];
                    
                    // Update the specific savings type
                    $savings->$savingsType += $validated['amount'];
                    
                    // Recalculate total
                    $savings->total_amount = $savings->share_capital + 
                                           $savings->subscription_capital + 
                                           $savings->member_deposit + 
                                           $savings->welfare_fund + 
                                           $savings->fixed_savings;
                    
                    $savings->save();


                    $transactionId = 'TRX' . date('YmdHis') . rand(1000, 9999);
                    Log::info('Generated transaction ID: ' . $transactionId);
                    // Create transaction record

                    $transaction = new Transaction();
                    $transaction->transaction_id = $transactionId;
                    $transaction->member_id = $memberId;
                    $transaction->type = $validated['type'];
                    $transaction->amount = $validated['amount'];
                    $transaction->savings_type = $validated['type'] === 'savings' ? $validated['savings_type'] : null;
                    $transaction->loan_id = $validated['type'] === 'loan' ? $validated['loan_id'] : null;
                    $transaction->payment_method = null;
                    $transaction->payment_proof = null;
                    $transaction->status = 'approved';
                    $transaction->payment_method = 'online';
                    $transaction->save();
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berkumpulan berjaya disimpan'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Batch Transaction Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Ralat: ' . $e->getMessage()
            ], 422);
        }
    }
} 