<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\Member;
use App\Models\LoanType;
use App\Models\Bank;
use App\Models\Guarantor;
use Illuminate\Support\Facades\DB;
use App\Models\Setting;
use Bouncer;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{
    public function index()
    {
        return view('loan.create');
    }

    public function create()
    {
        $member = Auth::user()->member;

        // Check if the member is active
        if (!$member->isActive()) {
            return redirect()->route('profile.edit')->with('error', 'Anda tidak boleh memohon pinjaman kerana permohonan berhenti anda telah diluluskan.');
        }

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

        // Modified to get latest interest rate
        $interestRate = Setting::where('key', 'interest_rate')
            ->latest()
            ->first()
            ->value ?? 5.00;

        $validated = $request->validate([
            'loan_type_id' => [
                'required',
                'exists:loan_types,loan_type_id'
            ],
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
                'min:1000',
                'max:100000'
            ],
            'loan_period' => [
                'required',
                'integer',
                'min:1',
                'max:60'
            ],
            'monthly_gross_salary' => [
                'required',
                'numeric',
                'min:0',
                'gt:monthly_net_salary'
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
                'different:guarantor2_name'
            ],
            'guarantor1_pf' => [
                'required',
                'string',
                'max:20',
                'different:guarantor2_pf',
                function ($attribute, $value, $fail) {
                    $member = Member::where('no_pf', $value)->first();
                    
                    if (!$member) {
                        $fail('No. PF penjamin tidak dijumpai dalam sistem.');
                        return;
                    }

                    if (!$member->user || !$member->user->isA('member')) {
                        $fail('Penjamin mestilah ahli yang berdaftar.');
                        return;
                    }

                    // Get the current user's member record
                    $currentMember = DB::table('member_register')
                        ->where('guest_id', auth()->id())
                        ->first();

                    if (!$currentMember) {
                        $fail('Maklumat ahli tidak dijumpai.');
                        return;
                    }

                    // Check if guarantor is the same as applicant
                    if ($member->id === $currentMember->id) {
                        $fail('Anda tidak boleh menjadi penjamin untuk pinjaman anda sendiri.');
                    }
                }
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
            'guarantor2_pf' => [
                'required',
                'string',
                'max:20',
                'different:guarantor1_pf',
                function ($attribute, $value, $fail) {
                    $member = Member::where('no_pf', $value)->first();
                    
                    if (!$member) {
                        $fail('No. PF penjamin tidak dijumpai dalam sistem.');
                        return;
                    }

                    if (!$member->user || !$member->user->isA('member')) {
                        $fail('Penjamin mestilah ahli yang berdaftar.');
                        return;
                    }

                    // Get the current user's member record
                    $currentMember = DB::table('member_register')
                        ->where('guest_id', auth()->id())
                        ->first();

                    if (!$currentMember) {
                        $fail('Maklumat ahli tidak dijumpai.');
                        return;
                    }

                    // Check if guarantor is the same as applicant
                    if ($member->id === $currentMember->id) {
                        $fail('Anda tidak boleh menjadi penjamin untuk pinjaman anda sendiri.');
                    }
                }
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
            // Custom error messages for required fields
            'loan_type_id.required' => 'Sila pilih jenis pembiayaan',
            'bank_id.required' => 'Sila pilih bank',
            'bank_account.required' => 'Sila masukkan nombor akaun bank',
            'loan_amount.required' => 'Sila masukkan jumlah pinjaman',
            'loan_period.required' => 'Sila masukkan tempoh pinjaman',
            'monthly_gross_salary.required' => 'Sila masukkan gaji kasar bulanan',
            'monthly_net_salary.required' => 'Sila masukkan gaji bersih bulanan',
            'guarantor1_name.required' => 'Sila masukkan nama penjamin pertama',
            'guarantor1_pf.required' => 'Sila masukkan No. PF penjamin pertama',
            'guarantor1_phone.required' => 'Sila masukkan nombor telefon penjamin pertama',
            'guarantor1_address.required' => 'Sila masukkan alamat penjamin pertama',
            'guarantor1_relationship.required' => 'Sila pilih hubungan dengan penjamin pertama',
            'guarantor2_name.required' => 'Sila masukkan nama penjamin kedua',
            'guarantor2_pf.required' => 'Sila masukkan No. PF penjamin kedua',
            'guarantor2_phone.required' => 'Sila masukkan nombor telefon penjamin kedua',
            'guarantor2_address.required' => 'Sila masukkan alamat penjamin kedua',
            'guarantor2_relationship.required' => 'Sila pilih hubungan dengan penjamin kedua',
            
            // Other validation messages
            'numeric' => 'Ruangan :attribute mestilah nombor',
            'min' => 'Ruangan :attribute mestilah sekurang-kurangnya :min',
            'max' => 'Ruangan :attribute tidak boleh melebihi :max',
            'date' => 'Ruangan :attribute mestilah tarikh yang sah',
            'regex' => 'Format :attribute tidak sah',
            'different' => ':attribute mestilah berbeza dengan :other',
            'gt' => ':attribute mestilah lebih besar daripada :value',
            'accepted' => 'Anda perlu bersetuju dengan terma dan syarat',
            'before_or_equal' => ':attribute mestilah tarikh hari ini atau sebelumnya',
            
            // Format-specific messages
            'bank_account.regex' => 'Nombor akaun bank tidak sah',
            'guarantor1_phone.regex' => 'Nombor telefon penjamin 1 tidak sah',
            'guarantor2_phone.regex' => 'Nombor telefon penjamin 2 tidak sah'
        ]);

        try {
            $loan = DB::transaction(function () use ($validated, $interestRate) {
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
                    'interest_rate' => $interestRate,
                    'monthly_repayment' => $this->calculateMonthlyRepayment(
                        $validated['loan_amount'], 
                        $interestRate, 
                        $validated['loan_period']
                    ),
                    'monthly_gross_salary' => $validated['monthly_gross_salary'],
                    'monthly_net_salary' => $validated['monthly_net_salary'],
                    'loan_period' => $validated['loan_period'],
                    'status' => 'pending',
                    'loan_balance' => $this->calculateTotalLoanRepayment(
                        $validated['loan_amount'], 
                        $interestRate, 
                        $validated['loan_period']
                    ),
                    'loan_total_repayment' => $this->calculateTotalLoanRepayment(
                        $validated['loan_amount'], 
                        $interestRate, 
                        $validated['loan_period']
                    )

                ]);

                // Create guarantors
                foreach ([1, 2] as $order) {
                    Guarantor::create([
                        'loan_id' => $loan->loan_id,
                        'name' => $validated["guarantor{$order}_name"],
                        'no_pf' => $validated["guarantor{$order}_pf"],
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

    public function calculateMonthlyRepayment($principal, $interestRate, $period)
    {
        $monthlyRate = ($interestRate / 100) / 12;
        
        $monthlyPayment = $principal * 
            ($monthlyRate * pow(1 + $monthlyRate, $period)) / 
            (pow(1 + $monthlyRate, $period) - 1);
            
        return round($monthlyPayment, 2);
    }

    private function calculateTotalLoanRepayment($principal, $interestRate, $period)
    {
        return round(($this->calculateMonthlyRepayment($principal, $interestRate, $period) * $period),2);
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

    public function checkMemberRole(Request $request)
    {
        $noPF = $request->input('no_pf');
        
        $member = DB::table('member_register')
            ->where('no_pf', $noPF)
            ->first();

        if (!$member) {
            return response()->json([
                'isValid' => false,
                'message' => 'No. PF tidak dijumpai dalam sistem.'
            ]);
        }

        $user = User::find($member->guest_id);
        
        if (!$user || !$user->isA('member')) {
            return response()->json([
                'isValid' => false,
                'message' => 'Penjamin mestilah ahli yang berdaftar.'
            ]);
        }

        return response()->json([
            'isValid' => true
        ]);
    }

    public function validateGuarantorPF($pf)
    {
        // Get current user's PF number
        $currentUserPF = DB::table('member_register')
            ->where('guest_id', auth()->id())
            ->value('no_pf');

        // Check if guarantor is using their own PF
        if ($pf === $currentUserPF) {
            return response()->json([
                'valid' => false,
                'message' => 'Anda tidak boleh menggunakan No. PF anda sendiri sebagai penjamin.'
            ]);
        }

        // Check if PF exists in member_register and is a member
        $guarantor = DB::table('member_register')
            ->where('no_pf', $pf)
            ->first();

        if (!$guarantor) {
            return response()->json([
                'valid' => false,
                'message' => 'No. PF penjamin tidak dijumpai dalam sistem.'
            ]);
        }

        // Check if guarantor is a registered member
        $user = User::find($guarantor->guest_id);
        if (!$user || !$user->isA('member')) {
            return response()->json([
                'valid' => false,
                'message' => 'Penjamin mestilah ahli yang berdaftar.'
            ]);
        }

        return response()->json(['valid' => true]);
    }

}
