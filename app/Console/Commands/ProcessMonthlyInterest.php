<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Setting;
use App\Models\Loan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProcessMonthlyInterest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monthly:interest';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process monthly interest for loans and savings';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            DB::beginTransaction();

            // Get latest rates from settings table
            $rates = [];
            $interestRate = DB::table('settings')
                ->where('key', 'interest_rate')
                ->orderBy('created_at', 'desc')
                ->first();
            
            $dividendRate = DB::table('settings')
                ->where('key', 'dividend_rate')
                ->orderBy('created_at', 'desc')
                ->first();

            $rates['interest_rate'] = floatval($interestRate->value);
            $rates['dividend_rate'] = floatval($dividendRate->value);

            // Log the rates being used
            Log::info('Using rates:', [
                'interest_rate' => $rates['interest_rate'],
                'dividend_rate' => $rates['dividend_rate']
            ]);

            // Process loans interest
            $approvedLoans = DB::table('loans')
                ->where('status', 'approved')
                ->get();

            foreach ($approvedLoans as $loan) {
                $interest = $loan->loan_amount * ($rates['interest_rate'] / 100 / 12); // Monthly interest
                
                // Update loan amount with interest
                DB::table('loans')
                    ->where('loan_id', $loan->loan_id)
                    ->update([
                        'loan_amount' => DB::raw("loan_amount + $interest")
                    ]);

                // Record the interest transaction
                DB::table('transactions')->insert([
                    'member_id' => $loan->member_id,
                    'type' => 'loan',
                    'loan_id' => $loan->loan_id,
                    'amount' => $interest,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            // Process savings dividend (only for fixed_savings)
            $savingsRecords = DB::table('savings')->get();

            foreach ($savingsRecords as $record) {
                $dividend = $record->fixed_savings * ($rates['dividend_rate'] / 100 / 12); // Monthly dividend
                
                DB::table('savings')
                    ->where('id', $record->id)
                    ->update([
                        'fixed_savings' => DB::raw("fixed_savings + $dividend"),
                        'total_amount' => DB::raw("total_amount + $dividend")
                    ]);

                // Record the dividend transaction
                DB::table('transactions')->insert([
                    'member_id' => $record->no_anggota,
                    'type' => 'savings',
                    'savings_type' => 'fixed_savings',
                    'amount' => $dividend,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            DB::commit();
            Log::info('Monthly interest/dividend process completed successfully');
            $this->info('Monthly interest/dividend process completed successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Monthly interest/dividend process failed: ' . $e->getMessage());
            $this->error('Monthly interest/dividend process failed: ' . $e->getMessage());
        }
    }
}
