<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\NewMemberCredentials;
use App\Models\User;
use App\Models\Member;
use App\Models\WorkingInfo;
use App\Models\Savings;
use App\Models\Loan;
use App\Models\Guarantor;
use App\Models\Bank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Bouncer;
use App\Models\Setting;
use App\Mail\VerifyNewEmail;

class MemberDataEntryController extends Controller
{
    public function create()
    {
        $banks = \App\Models\Bank::all();
        
        // Fetch the interest rate from the settings table
        $interestRate = \App\Models\Setting::where('key', 'interest_rate')->value('value') ?? '5.00';

        return view('admin.data-entry.create', compact('banks', 'interestRate'));
    }

    public function store(Request $request)
    {
        try {
            // Log the incoming request data for debugging
            \Log::info('Store method called', $request->all());

            // Set default value for has_loan if not present
            $request->merge([
                'has_loan' => $request->input('loan_choice') == '1'
            ]);

            // First calculate the loan values if has_loan is true and loan amount exists
            if ($request->boolean('has_loan') && $request->filled('loan_amount') && $request->filled('loan_period')) {
                $monthlyRate = ($request->interest_rate / 100) / 12;
                if ($monthlyRate > 0) {  // Prevent division by zero
                    $monthlyPayment = ($request->loan_amount * $monthlyRate * pow(1 + $monthlyRate, $request->loan_period)) / 
                                     (pow(1 + $monthlyRate, $request->loan_period) - 1);
                    $totalRepayment = $monthlyPayment * $request->loan_period;

                    $request->merge([
                        'monthly_repayment' => round($monthlyPayment, 2),
                        'loan_total_repayment' => round($totalRepayment, 2)
                    ]);
                }
            }

            // Then do validation with custom messages
            $messages = [
                'required' => 'Ruangan :attribute diperlukan.',
                'email' => 'Ruangan :attribute mesti alamat emel yang sah.',
                'numeric' => 'Ruangan :attribute mesti nombor.',
                'date' => 'Ruangan :attribute mesti tarikh yang sah.',
                'max' => 'Ruangan :attribute tidak boleh melebihi :max aksara.',
                'unique' => ':attribute telah digunakan.',
                'in' => 'Pilihan :attribute tidak sah.',
            ];

            $attributes = [
                'name' => 'Nama',
                'email' => 'Emel',
                'no_anggota' => 'No. Anggota',
                'ic' => 'No. KP',
                'phone' => 'No. Telefon',
                'address' => 'Alamat',
                'city' => 'Bandar',
                'postcode' => 'Poskod',
                'state' => 'Negeri',
                'gender' => 'Jantina',
                'DOB' => 'Tarikh Lahir',
                'agama' => 'Agama',
                'bangsa' => 'Bangsa',
                'no_pf' => 'No. PF',
                'salary' => 'Gaji',
                'office_address' => 'Alamat Pejabat',
                'office_city' => 'Bandar Pejabat',
                'office_postcode' => 'Poskod Pejabat',
                'office_state' => 'Negeri Pejabat',
                'jawatan' => 'Jawatan',
                'gred' => 'Gred',
                'fees.entrance' => 'Yuran Masuk',
                'fees.share_capital' => 'Modal Saham',
                'fees.subscription_capital' => 'Modal Langganan',
                'fees.member_deposit' => 'Deposit Ahli',
                'fees.welfare_fund' => 'Tabung Kebajikan',
                'fees.fixed_savings' => 'Simpanan Tetap',
            ];

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'no_anggota' => 'required|string|max:255',
                'ic' => 'required|string|max:255',
                'phone' => 'required',
                'address' => 'required',
                'city' => 'required',
                'postcode' => 'required',
                'state' => 'required',
                'gender' => 'required',
                'DOB' => 'required|date',
                'agama' => 'required',
                'bangsa' => 'required',
                'no_pf' => 'required',
                'salary' => 'required',
                'office_address' => 'required',
                'office_city' => 'required',
                'office_postcode' => 'required',
                'office_state' => 'required',
                'jawatan' => 'required',
                'gred' => 'required',
                'fees.entrance' => 'required|numeric',
                'fees.share_capital' => 'required|numeric',
                'fees.subscription_capital' => 'required|numeric',
                'fees.member_deposit' => 'required|numeric',
                'fees.welfare_fund' => 'required|numeric',
                'fees.fixed_savings' => 'required|numeric',
                
                // Make family fields optional
                'family.*.name' => 'nullable|string|max:255',
                'family.*.ic' => 'nullable|string|max:12',
                'family.*.relationship' => 'nullable|string|in:Isteri,Suami,Anak,Ibu,Bapa,Adik-beradik',
                
                // Make loan fields conditional
                'loan_type_id' => $request->boolean('has_loan') ? 'required' : 'nullable',
                'bank_name' => $request->boolean('has_loan') ? 'required' : 'nullable',
                'date_apply' => $request->boolean('has_loan') ? 'required|date' : 'nullable',
                'loan_amount' => $request->boolean('has_loan') ? 'required|numeric' : 'nullable',
                'loan_total_repayment' => $request->boolean('has_loan') ? 'required|numeric' : 'nullable',
                'loan_balance' => $request->boolean('has_loan') ? 'required|numeric' : 'nullable',
                'interest_rate' => $request->boolean('has_loan') ? 'required|numeric' : 'nullable',
                'monthly_repayment' => $request->boolean('has_loan') ? 'required|numeric' : 'nullable',
                'monthly_gross_salary' => $request->boolean('has_loan') ? 'required|numeric' : 'nullable',
                'monthly_net_salary' => $request->boolean('has_loan') ? 'required|numeric' : 'nullable',
                'loan_period' => $request->boolean('has_loan') ? 'required|numeric' : 'nullable',
                'guarantor1_name' => $request->boolean('has_loan') ? 'required' : 'nullable',
                'guarantor1_pf' => $request->boolean('has_loan') ? 'required' : 'nullable',
                'guarantor1_ic' => $request->boolean('has_loan') ? 'required' : 'nullable',
                'guarantor1_phone' => $request->boolean('has_loan') ? 'required' : 'nullable',
                'guarantor1_no_anggota' => $request->boolean('has_loan') ? 'required' : 'nullable',
                'guarantor2_name' => $request->boolean('has_loan') ? 'required' : 'nullable',
                'guarantor2_pf' => $request->boolean('has_loan') ? 'required' : 'nullable',
                'guarantor2_ic' => $request->boolean('has_loan') ? 'required' : 'nullable',
                'guarantor2_phone' => $request->boolean('has_loan') ? 'required' : 'nullable',
                'guarantor2_no_anggota' => $request->boolean('has_loan') ? 'required' : 'nullable',
            ], $messages, $attributes);

            $result = DB::transaction(function () use ($request) {
                $tempPassword = Str::random(8);

                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($tempPassword),
                ]);

                // Assign member role using Bouncer
                Bouncer::assign('member')->to($user);

                // 1. Insert member data into member_register table
                $member = DB::table('member_register')->insertGetId([
                    'guest_id' => $user->id,
                    'no_anggota' => $request->no_anggota,
                    'name' => $request->name,
                    'email' => $request->email,
                    'ic' => $request->ic,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'city' => $request->city,
                    'postcode' => $request->postcode,
                    'state' => $request->state,
                    'gender' => $request->gender,
                    'DOB' => $request->DOB,
                    'agama' => $request->agama,
                    'bangsa' => $request->bangsa,
                    'no_pf' => $request->no_pf,
                    'salary' => $request->salary,
                    'office_address' => $request->office_address,
                    'office_city' => $request->office_city,
                    'office_postcode' => $request->office_postcode,
                    'office_state' => $request->office_state,
                    'status' => 'approved',  // Set status to approved for admin registration
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                // 2. Insert working info
                DB::table('working_info')->insert([
                    'jawatan' => $request->jawatan,
                    'gred' => $request->gred,
                    'no_pf' => $request->no_pf,
                    'salary' => $request->salary,
                    'no_anggota' => $member,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // 3. Insert savings/fees
                DB::table('savings')->insert([
                    'entrance_fee' => $request->input('fees.entrance'),
                    'share_capital' => $request->input('fees.share_capital'),
                    'subscription_capital' => $request->input('fees.subscription_capital'),
                    'member_deposit' => $request->input('fees.member_deposit'),
                    'welfare_fund' => $request->input('fees.welfare_fund'),
                    'fixed_savings' => $request->input('fees.fixed_savings'),
                    'total_amount' => array_sum([
                        $request->input('fees.entrance'),
                        $request->input('fees.share_capital'),
                        $request->input('fees.subscription_capital'),
                        $request->input('fees.member_deposit'),
                        $request->input('fees.welfare_fund'),
                        $request->input('fees.fixed_savings'),
                    ]),
                    'no_anggota' => $member,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // 4. Insert family members if any
                if ($request->has('family')) {
                    foreach ($request->family as $familyMember) {
                        if (!empty($familyMember['name']) || !empty($familyMember['ic']) || !empty($familyMember['relationship'])) {
                            DB::table('family')->insert([
                                'relationship' => $familyMember['relationship'],
                                'name' => $familyMember['name'],
                                'ic' => $familyMember['ic'],
                                'no_anggota' => $member,
                                'created_at' => now(),
                                'updated_at' => now()
                            ]);
                        }
                    }
                }

                // 5. If has loan, create loan-related records
                if ($request->boolean('has_loan')) {
                    // Only process loan data if has_loan is true
                    $bank = Bank::firstOrCreate(
                        ['bank_name' => $request->bank_name],
                        [
                            'bank_account' => $request->bank_account ?? '-',
                            'created_at' => $request->date_apply,
                            'updated_at' => $request->date_apply
                        ]
                    );

                    $loanId = 'LOAN-' . time() . '-' . $member;
                    
                    DB::table('loans')->insert([
                        'loan_id' => $loanId,
                        'member_id' => $member,
                        'loan_type_id' => $request->loan_type_id,
                        'bank_id' => $bank->bank_id,
                        'date_apply' => $request->date_apply,
                        'loan_amount' => $request->loan_amount,
                        'loan_period' => $request->loan_period,
                        'monthly_gross_salary' => $request->monthly_gross_salary,
                        'monthly_net_salary' => $request->monthly_net_salary,
                        'interest_rate' => $request->interest_rate,
                        'monthly_repayment' => $request->monthly_repayment,
                        'loan_total_repayment' => $request->loan_total_repayment,
                        'loan_balance' => $request->loan_balance,
                        'status' => 'approved',
                        'created_at' => $request->date_apply,
                        'updated_at' => $request->date_apply
                    ]);

                    // Create guarantors
                    foreach ([1, 2] as $order) {
                        DB::table('guarantors')->insert([
                            'loan_id' => $loanId,
                            'name' => $request->input("guarantor{$order}_name"),
                            'no_pf' => $request->input("guarantor{$order}_pf"),
                            'ic' => $request->input("guarantor{$order}_ic"),
                            'phone' => $request->input("guarantor{$order}_phone"),
                            'no_anggota' => $request->input("guarantor{$order}_no_anggota"),
                            'guarantor_order' => $order,
                            'created_at' => $request->date_apply,
                            'updated_at' => $request->date_apply
                        ]);
                    }
                }

                return [
                    'member_id' => $member,
                    'user' => $user,
                    'tempPassword' => $tempPassword
                ];
            });

            // Only send credentials email
            Mail::to($result['user']->email)->send(new NewMemberCredentials($result['user'], $result['tempPassword']));

            return redirect()->route('admin.members.index')
                ->with('success', 'Ahli berjaya didaftarkan. Maklumat log masuk telah dihantar ke emel ahli.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed: ' . json_encode($e->errors()));
            return back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', 'Sila semak semua ruangan yang diperlukan.');
        } catch (\Exception $e) {
            \Log::error('Member data entry failed: ' . $e->getMessage());
            return back()
                ->withInput()
                ->with('error', 'Ralat semasa memproses data: ' . $e->getMessage());
        }
    }
} 