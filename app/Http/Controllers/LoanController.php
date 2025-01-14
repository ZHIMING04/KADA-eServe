<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\Member;
use App\Models\LoanType;
use App\Models\Bank;
use App\Models\Guarantor;
use Illuminate\Support\Facades\DB;

class LoanController extends Controller
{
    public function index()
    {
        return view('loan.create');
    }

    public function create()
    {
        $member = Member::where('guest_id', auth()->id())->first();
        $loanTypes = LoanType::all();
        $banks = Bank::all();

        return view('loan.create', [
            'member' => $member,
            'loanTypes' => $loanTypes,
            'banks' => $banks
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // Loan Details
            'loan_type_id' => 'required|exists:loan_types,loan_type_id',
            'bank_id' => 'required|exists:banks,bank_id',
            'loan_amount' => 'required|numeric|min:0',
            'loan_period' => 'required|integer|min:1|max:60',
            'monthly_gross_salary' => 'required|numeric|min:0',
            'monthly_net_salary' => 'required|numeric|min:0',
            'purpose' => 'required|string|max:500',

            // First Guarantor
            'guarantor1_name' => 'required|string|max:255',
            'guarantor1_ic' => 'required|string|max:20',
            'guarantor1_phone' => 'required|string|max:15',
            'guarantor1_address' => 'required|string|max:500',
            'guarantor1_relationship' => 'required|in:parent,spouse,sibling,relative,friend',

            // Second Guarantor
            'guarantor2_name' => 'required|string|max:255',
            'guarantor2_ic' => 'required|string|max:20',
            'guarantor2_phone' => 'required|string|max:15',
            'guarantor2_address' => 'required|string|max:500',
            'guarantor2_relationship' => 'required|in:parent,spouse,sibling,relative,friend',

            // Terms Agreement
            'terms_agreed' => 'required|accepted'
        ]);

        try {
            DB::transaction(function () use ($validated) {
                // Create loan record
                $loan = Loan::create([
                    'loan_id' => 'LOAN-' . time(),
                    'member_id' => auth()->id(),
                    'loan_type_id' => $validated['loan_type_id'],
                    'bank_id' => $validated['bank_id'],
                    'date_apply' => now(),
                    'loan_amount' => $validated['loan_amount'],
                    'loan_period' => $validated['loan_period'],
                    'monthly_gross_salary' => $validated['monthly_gross_salary'],
                    'monthly_net_salary' => $validated['monthly_net_salary'],
                    'purpose' => $validated['purpose'],
                    'interest_rate' => 5.00,
                    'monthly_repayment' => $this->calculateMonthlyRepayment(
                        $validated['loan_amount'], 
                        5.00, 
                        $validated['loan_period']
                    ),
                    'status' => 'pending'
                ]);

                // Create first guarantor
                Guarantor::create([
                    'loan_id' => $loan->loan_id,
                    'name' => $validated['guarantor1_name'],
                    'ic' => $validated['guarantor1_ic'],
                    'phone' => $validated['guarantor1_phone'],
                    'address' => $validated['guarantor1_address'],
                    'relationship' => $validated['guarantor1_relationship'],
                    'guarantor_order' => 1
                ]);

                // Create second guarantor
                Guarantor::create([
                    'loan_id' => $loan->loan_id,
                    'name' => $validated['guarantor2_name'],
                    'ic' => $validated['guarantor2_ic'],
                    'phone' => $validated['guarantor2_phone'],
                    'address' => $validated['guarantor2_address'],
                    'relationship' => $validated['guarantor2_relationship'],
                    'guarantor_order' => 2
                ]);
            });

            return redirect()->route('loan.success')
                ->with('success', 'Permohonan pinjaman anda telah berjaya dihantar!');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Ralat semasa memproses permohonan. Sila cuba lagi.'])
                        ->withInput();
        }
    }

    private function calculateMonthlyRepayment($principal, $interestRate, $period)
    {
        // Monthly interest rate
        $monthlyRate = ($interestRate / 100) / 12;
        
        // Calculate monthly payment using loan amortization formula
        $monthlyPayment = $principal * 
            ($monthlyRate * pow(1 + $monthlyRate, $period)) / 
            (pow(1 + $monthlyRate, $period) - 1);
            
        return round($monthlyPayment, 2);
    }
}
