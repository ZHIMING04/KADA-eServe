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

            // Update member's savings based on transaction type
            if ($transaction->type === 'savings') {
                // Get the savings record instead of member
                $savings = Savings::where('no_anggota', $transaction->member_id)->firstOrFail();
                $savingsType = $transaction->savings_type;
                
                // Update the specific savings type
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