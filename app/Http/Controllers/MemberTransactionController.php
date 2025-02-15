<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Transaction;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class MemberTransactionController extends Controller
{
    public function create()
    {
        // Check if user is resigned
        $member = Member::where('guest_id', Auth::id())->first();
        
        if ($member && $member->status === 'resigned') {
            return redirect()->route('profile.edit')
                ->with('error', 'Anda tidak boleh membuat transaksi kerana permohonan berhenti anda telah diluluskan.');
        }

        return view('memberTransaction.make-transaction');
    }

    public function store(Request $request)
    {
        try {
            // Check if user is resigned before allowing transaction
            $member = Member::where('guest_id', Auth::id())->first();
            
            if ($member && $member->status === 'resigned') {
                return redirect()->route('profile.edit')
                    ->with('error', 'Anda tidak boleh membuat transaksi kerana permohonan berhenti anda telah diluluskan.');
            }

            Log::info('Starting transaction process', $request->all());

            // Get the authenticated user's member record from member_register table
            $member = Member::where('guest_id', Auth::id())->first();
            
            if (!$member) {
                throw new \Exception('Member record not found for user');
            }

            Log::info('Found member', ['member_id' => $member->id]);

            // Basic validation
            $validated = $request->validate([
                'type' => 'required|in:savings,loan',
                'amount' => 'required|numeric|min:0',
                'payment_method' => 'required|in:online,cash,auto_transfer',
            ]);

            Log::info('Basic validation passed');

            // Additional validation based on transaction type
            if ($request->type === 'savings') {
                $request->validate([
                    'savings_type' => 'required|in:share_capital,subscription_capital,member_deposit,welfare_fund,fixed_savings',
                ]);
            } else {
                $request->validate([
                    'loan_id' => 'required|exists:loans,loan_id',
                ]);
            }

            Log::info('Additional validation passed');

            // Handle file upload for online payment
            $paymentProofPath = null;
            if ($request->payment_method === 'online' && $request->hasFile('payment_proof')) {
                $request->validate([
                    'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048'
                ]);

                $file = $request->file('payment_proof');
                
                // Ensure the file is valid
                if ($file && $file->isValid()) {
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    
                    // Make sure the directory exists
                    $path = public_path('uploads/payment_proofs');
                    if (!file_exists($path)) {
                        mkdir($path, 0777, true);
                    }
                    
                    // Move the file
                    $file->move($path, $fileName);
                    $paymentProofPath = 'uploads/payment_proofs/' . $fileName;
                    
                    Log::info('File uploaded successfully', ['path' => $paymentProofPath]);
                } else {
                    throw new \Exception('Invalid file upload');
                }
            }

            // Generate transaction ID
            $transactionId = 'TRX' . date('YmdHis') . rand(1000, 9999);
            Log::info('Generated transaction ID: ' . $transactionId);

            // Create transaction record
            $transaction = new Transaction();
            $transaction->transaction_id = $transactionId;
            $transaction->member_id = $member->id;
            $transaction->type = $request->type;
            $transaction->savings_type = $request->type === 'savings' ? $request->savings_type : null;
            $transaction->loan_id = $request->type === 'loan' ? $request->loan_id : null;
            $transaction->amount = $request->amount;
            $transaction->payment_method = $request->payment_method;
            $transaction->payment_proof = $paymentProofPath;
            $transaction->status = 'pending';

            Log::info('About to save transaction', [
                'transaction_data' => $transaction->toArray()
            ]);

            $transaction->save();

            Log::info('Transaction saved successfully');

            return redirect()->route('member.dashboard')
                ->with('success', 'Transaksi anda telah berjaya dihantar dan sedang menunggu pengesahan!');

        } catch (\Exception $e) {
            // If there was an error and we uploaded a file, delete it
            if (isset($paymentProofPath) && file_exists(public_path($paymentProofPath))) {
                unlink(public_path($paymentProofPath));
            }

            Log::error('Transaction creation failed: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            // Return with more detailed error message for debugging
            return back()
                ->withInput()
                ->withErrors(['error' => 'Ralat semasa memproses transaksi: ' . $e->getMessage()]);
        }
    }

    public function index()
    {
        $transactions = Transaction::where('member_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('memberTransaction.index', compact('transactions'));
    }

    public function getMemberLoans()
    {
        try {
            Log::info('getMemberLoans started');
            
            $member = Member::where('guest_id', Auth::id())->first();
            Log::info('Auth ID:', ['id' => Auth::id()]);
            Log::info('Member lookup result:', ['member' => $member]);
            
            if (!$member) {
                Log::warning('Member not found for user', ['user_id' => Auth::id()]);
                return response()->json([
                    'error' => 'Member not found'
                ], 404);
            }

            $loans = Loan::where('member_id', $member->id)
                ->where('status', 'approved')
                ->select('loan_id', 'loan_amount', 'loan_balance')
                ->get();

            Log::info('Loans query result:', [
                'member_id' => $member->id,
                'loans_count' => $loans->count(),
                'loans' => $loans->toArray()
            ]);

            return response()->json($loans);
        } catch (\Exception $e) {
            Log::error('Error in getMemberLoans:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'error' => 'Failed to fetch loans: ' . $e->getMessage()
            ], 500);
        }
    }
} 