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
        // Ensure loan types exist
        if (LoanType::count() === 0) {
            LoanType::insert([
                ['loan_type_id' => 1, 'loan_type' => 'Al-Bai', 'created_at' => now()],
                ['loan_type_id' => 2, 'loan_type' => 'Al-Inah', 'created_at' => now()],
                ['loan_type_id' => 3, 'loan_type' => 'Skim Khas', 'created_at' => now()],
                ['loan_type_id' => 4, 'loan_type' => 'Karnival Muslim Istimewa', 'created_at' => now()],
                ['loan_type_id' => 5, 'loan_type' => 'Baik Pulih Kenderaan', 'created_at' => now()],
                ['loan_type_id' => 6, 'loan_type' => 'Cukai Jalan', 'created_at' => now()]
            ]);
        }

        $member = DB::table('member_register')
            ->where('guest_id', auth()->id())
            ->first();

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
        \Log::info('Loan application submitted', $request->all());

        $validated = $request->validate([
            // Loan Details
            'loan_type_id' => 'required|exists:loan_types,loan_type_id',
            'bank_id' => 'required',
            'bank_account' => 'required|string|max:20',
            'loan_amount' => 'required|numeric|min:0',
            'loan_period' => 'required|integer|min:1|max:60',
            'monthly_gross_salary' => 'required|numeric|min:0',
            'monthly_net_salary' => 'required|numeric|min:0',
            'date_apply' => 'required|date',

            // First Guarantor
            'guarantor1_name' => 'required|string|max:255',
            'guarantor1_ic' => 'required|string|max:20',
            'guarantor1_phone' => 'required|string|max:15',
            'guarantor1_address' => 'required|string',
            'guarantor1_relationship' => 'required|in:parent,spouse,sibling,relative,friend',

            // Second Guarantor
            'guarantor2_name' => 'required|string|max:255',
            'guarantor2_ic' => 'required|string|max:20',
            'guarantor2_phone' => 'required|string|max:15',
            'guarantor2_address' => 'required|string',
            'guarantor2_relationship' => 'required|in:parent,spouse,sibling,relative,friend',

            'terms_agreed' => 'required|accepted'
        ]);

        try {
            $loan = DB::transaction(function () use ($validated) {
                \Log::info('Starting loan creation transaction');
                
                $member = DB::table('member_register')
                    ->where('guest_id', auth()->id())
                    ->first();

                if (!$member) {
                    \Log::error('Member not found for user ID: ' . auth()->id());
                    throw new \Exception('Member not found');
                }

                \Log::info('Member found', ['member_id' => $member->id]);

                // Create bank record
                $bank = Bank::create([
                    'bank_name' => $this->getBankName($validated['bank_id']),
                    'bank_account' => $validated['bank_account']
                ]);

                // Create loan record
                $loan = Loan::create([
                    'loan_id' => 'LOAN-' . time(),
                    'member_id' => $member->id,
                    'loan_type_id' => $validated['loan_type_id'],
                    'bank_id' => $bank->bank_id,
                    'date_apply' => $validated['date_apply'],
                    'loan_amount' => $validated['loan_amount'],
                    'interest_rate' => 5.00,
                    'monthly_repayment' => $this->calculateMonthlyRepayment(
                        $validated['loan_amount'], 
                        5.00, 
                        $validated['loan_period']
                    ),
                    'monthly_gross_salary' => $validated['monthly_gross_salary'],
                    'monthly_net_salary' => $validated['monthly_net_salary'],
                    'loan_period' => $validated['loan_period'],
                    'status' => 'pending'
                ]);

                // Create guarantors
                foreach ([1, 2] as $order) {
                    Guarantor::create([
                        'loan_id' => $loan->loan_id,
                        'name' => $validated["guarantor{$order}_name"],
                        'ic' => $validated["guarantor{$order}_ic"],
                        'phone' => $validated["guarantor{$order}_phone"],
                        'address' => $validated["guarantor{$order}_address"],
                        'relationship' => $validated["guarantor{$order}_relationship"],
                        'guarantor_order' => $order
                    ]);
                }

                return $loan;
            });

            \Log::info('Loan created successfully', ['loan_id' => $loan->loan_id]);
            
            return redirect()->route('loan.success')
                ->with('success', 'Permohonan pinjaman anda telah berjaya dihantar!');

        } catch (\Exception $e) {
            \Log::error('Loan application error: ' . $e->getMessage());
            return back()
                ->withErrors(['error' => 'Ralat semasa memproses permohonan. Sila cuba lagi.'])
                ->withInput();
        }
    }

    private function calculateMonthlyRepayment($principal, $interestRate, $period)
    {
        $monthlyRate = ($interestRate / 100) / 12;
        
        $monthlyPayment = $principal * 
            ($monthlyRate * pow(1 + $monthlyRate, $period)) / 
            (pow(1 + $monthlyRate, $period) - 1);
            
        return round($monthlyPayment, 2);
    }

    private function getBankName($bankId)
    {
        $banks = [
            1 => 'Affin Bank Berhad',
            2 => 'Affin Islamic Bank Berhad',
            3 => 'Alliance Bank Malaysia Berhad',
            // ... add all banks ...
            30 => 'United Overseas Bank (Malaysia) Berhad'
        ];

        return $banks[$bankId] ?? 'Unknown Bank';
    }

    public function success()
    {
        return view('loan.success')->with('success', 'Permohonan pinjaman anda telah berjaya dihantar!');
    }
}
