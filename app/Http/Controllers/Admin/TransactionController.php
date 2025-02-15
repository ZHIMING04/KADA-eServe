<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Savings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['member', 'savings'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('admin.transactions.index', compact('transactions'));
    }

    public function show($transactionId)
    {
        $transaction = Transaction::with(['member'])
            ->where('transaction_id', $transactionId)
            ->firstOrFail();
            
        return view('admin.transactions.show', compact('transaction'));
    }

    public function approve($transactionId)
    {
        try {
            DB::beginTransaction();
            
            $transaction = Transaction::where('transaction_id', $transactionId)->firstOrFail();
            
            // Update transaction status
            $transaction->status = 'approved';
            $transaction->approved_at = now();
            $transaction->save();

            // Handle different transaction types
            if ($transaction->type === 'savings') {
                // Handle savings transaction
                $savings = Savings::where('no_anggota', $transaction->member_id)->firstOrFail();
                $savingsType = $transaction->savings_type;
                
                if (isset($savings->$savingsType)) {
                    $savings->$savingsType += $transaction->amount;
                    
                    // Recalculate total amount
                    $savings->total_amount = $savings->share_capital +
                        $savings->subscription_capital +
                        $savings->member_deposit +
                        $savings->welfare_fund +
                        $savings->fixed_savings;
                        
                    $savings->save();
                }
            } elseif ($transaction->type === 'loan') {
                // Handle loan payment transaction
                $loan = DB::table('loans')
                    ->where('loan_id', $transaction->loan_id)
                    ->first();

                if ($loan) {
                    // Calculate new loan balance
                    $newBalance = $loan->loan_balance - $transaction->amount;
                    
                    // Update loan balance
                    DB::table('loans')
                        ->where('loan_id', $transaction->loan_id)
                        ->update([
                            'loan_balance' => $newBalance,
                            'updated_at' => now()
                        ]);

                    // If loan is fully paid
                    if ($newBalance <= 0) {
                        DB::table('loans')
                            ->where('loan_id', $transaction->loan_id)
                            ->update([
                                'status' => 'completed',
                                'updated_at' => now()
                            ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('admin.transactions.index')
                ->with('success', 'Transaksi telah diluluskan');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Transaction approval failed: ' . $e->getMessage());
            
            return redirect()->route('admin.transactions.index')
                ->with('error', 'Ralat semasa meluluskan transaksi: ' . $e->getMessage());
        }
    }

    public function reject($transactionId)
    {
        $transaction = Transaction::where('transaction_id', $transactionId)->firstOrFail();
        
        $transaction->status = 'rejected';
        $transaction->save();

        return redirect()->route('admin.transactions.index')
            ->with('success', 'Transaksi telah ditolak');
    }
} 