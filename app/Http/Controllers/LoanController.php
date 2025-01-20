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
        // Add dd() to debug the incoming request
        // dd($request->all());

        \Log::info('Loan application submitted', $request->all());

        $validated = $request->validate([
            // Loan Details
            'loan_type_id' => 'required|exists:loan_types,loan_type_id',
            'bank_id' => 'required',
            'bank_account' => [
                'required',
                'string',
                'max:20',
                'regex:/^[0-9-]+$/' // Only numbers and hyphens allowed
            ],
            'loan_amount' => [
                'required',
                'numeric',
                'min:1000', // Minimum loan amount
                'max:100000' // Maximum loan amount
            ],
            'loan_period' => [
                'required',
                'integer',
                'min:1',
                'max:60' // Maximum 60 months
            ],
            'monthly_gross_salary' => [
                'required',
                'numeric',
                'min:0',
                'gt:monthly_net_salary' // Must be greater than net salary
            ],
            'monthly_net_salary' => [
                'required',
                'numeric',
                'min:0'
            ],
            'date_apply' => [
                'required',
                'date',
                'before_or_equal:today'
            ],

            // First Guarantor
            'guarantor1_name' => [
                'required',
                'string',
                'max:255',
                'different:guarantor2_name' // Must be different from guarantor 2
            ],
            'guarantor1_ic' => [
                'required',
                'string',
                'max:20',
                'regex:/^[0-9-]+$/',
                'different:guarantor2_ic'
            ],
            'guarantor1_phone' => [
                'required',
                'string',
                'max:15',
                'regex:/^[0-9-]+$/',
                'different:guarantor2_phone'
            ],
            'guarantor1_address' => [
                'required',
                'string',
                'max:500',
                'different:guarantor2_address'
            ],
            'guarantor1_relationship' => [
                'required',
                'in:parent,spouse,sibling,relative,friend'
            ],

            // Second Guarantor
            'guarantor2_name' => [
                'required',
                'string',
                'max:255',
                'different:guarantor1_name'
            ],
            'guarantor2_ic' => [
                'required',
                'string',
                'max:20',
                'regex:/^[0-9-]+$/',
                'different:guarantor1_ic'
            ],
            'guarantor2_phone' => [
                'required',
                'string',
                'max:15',
                'regex:/^[0-9-]+$/',
                'different:guarantor1_phone'
            ],
            'guarantor2_address' => [
                'required',
                'string',
                'max:500',
                'different:guarantor1_address'
            ],
            'guarantor2_relationship' => [
                'required',
                'in:parent,spouse,sibling,relative,friend'
            ],

            // Terms and Conditions
            'terms_agreed' => 'required|accepted'
        ], [
            // Custom error messages
            'required' => 'Ruangan :attribute perlu diisi',
            'numeric' => 'Ruangan :attribute mestilah nombor',
            'min' => 'Ruangan :attribute mestilah sekurang-kurangnya :min',
            'max' => 'Ruangan :attribute tidak boleh melebihi :max',
            'date' => 'Ruangan :attribute mestilah tarikh yang sah',
            'regex' => 'Format :attribute tidak sah',
            'different' => ':attribute mestilah berbeza dengan :other',
            'gt' => ':attribute mestilah lebih besar daripada :value',
            'accepted' => 'Anda perlu bersetuju dengan terma dan syarat',
            'before_or_equal' => ':attribute mestilah tarikh hari ini atau sebelumnya',
            
            // Custom attribute names
            'loan_type_id.required' => 'Sila pilih jenis pembiayaan',
            'bank_id.required' => 'Sila pilih bank',
            'bank_account.regex' => 'Nombor akaun bank tidak sah',
            'guarantor1_ic.regex' => 'Nombor KP penjamin 1 tidak sah',
            'guarantor2_ic.regex' => 'Nombor KP penjamin 2 tidak sah',
            'guarantor1_phone.regex' => 'Nombor telefon penjamin 1 tidak sah',
            'guarantor2_phone.regex' => 'Nombor telefon penjamin 2 tidak sah'
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

                // Create bank record without checking if it exists
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
            4 => 'Alliance Islamic Bank Malaysia Berhad',
            5 => 'Al Rajhi Banking & Investment Corporation (Malaysia) Berhad',
            6 => 'AmBank (M) Berhad',
            7 => 'Bank Islam Malaysia Berhad',
            8 => 'Bank Kerjasama Rakyat Malaysia Berhad',
            9 => 'Bank Muamalat Malaysia Berhad',
            10 => 'Bank of China (Malaysia) Berhad',
            11 => 'Bank Pertanian Malaysia Berhad (Agrobank)',
            12 => 'Bank Simpanan Nasional',
            13 => 'CIMB Bank Berhad',
            14 => 'CIMB Islamic Bank Berhad',
            15 => 'Citibank Berhad',
            16 => 'Hong Leong Bank Berhad',
            17 => 'Hong Leong Islamic Bank Berhad',
            18 => 'HSBC Amanah Malaysia Berhad',
            19 => 'HSBC Bank Malaysia Berhad',
            20 => 'Industrial and Commercial Bank of China (Malaysia) Berhad'
        ];

        // Add debugging
        \Log::info('Bank ID received:', ['bank_id' => $bankId]);
        \Log::info('Bank name found:', ['bank_name' => $banks[$bankId] ?? 'Unknown Bank']);

        return $banks[$bankId] ?? 'Unknown Bank';
    }

    public function success()
    {
        return view('loan.success')->with('success', 'Permohonan pinjaman anda telah berjaya dihantar!');
    }

}
