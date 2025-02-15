<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Member;

class MemberController extends Controller
{
    public function index()
    {
        return view('guest/register');
    }

    public function create()
    {
        // Check if user has existing application
        $existingApplication = Member::where('email', auth()->user()->email)
            ->whereIn('status', ['pending', 'approved'])
            ->first();

        if ($existingApplication) {
            $message = $existingApplication->status === 'pending' 
                ? 'Anda mempunyai permohonan yang sedang diproses.'
                : 'Anda telah menjadi ahli yang diluluskan.';

            return redirect()->route('guest.dashboard')
                ->with('warning', $message);
        }

        // Continue with existing code for form display
        return view('guest.register');
    }

    public function store(Request $request)
    {
        // Double check for existing application
        $existingApplication = Member::where('email', $request->email)
            ->whereIn('status', ['pending', 'approved'])
            ->first();

        if ($existingApplication) {
            return redirect()->route('guest.dashboard')
                ->with('warning', 'Anda mempunyai permohonan yang sedang diproses.');
        }

        // Custom validation rules for existing records
        $uniqueWithStatus = function($attribute, $value, $fail) use ($request) {
            $exists = DB::table('member_register')
                ->where($attribute, $value)
                ->whereIn('status', ['pending', 'approved'])
                ->exists();
            
            if ($exists) {
                $messages = [
                    'no_anggota' => 'Nombor anggota telah digunakan dan masih aktif/tengah proses',
                    'ic' => 'Nombor kad pengenalan telah digunakan dan masih aktif/tengah proses',
                    'email' => 'Alamat emel telah digunakan dan masih aktif/tengah proses'
                ];
                $fail($messages[$attribute] ?? 'Field telah digunakan dan masih aktif/tengah proses');
            }
        };

        // Validate request
        $validated = $request->validate([
            // Personal Information
            'no_anggota' => [
                'required',
                'string',
                'max:255',
                $uniqueWithStatus
            ],
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                $uniqueWithStatus
            ],
            'ic' => [
                'required',
                'string',
                'size:12',
                'regex:/^[0-9]+$/',
                $uniqueWithStatus
            ],
            'phone' => [
                'required',
                'string',
                'regex:/^[0-9]+$/',
                'min:10',
                'max:11'
            ],
            // Address fields
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'postcode' => [
                'required',
                'string',
                'size:5',
                'regex:/^[0-9]+$/'
            ],
            'state' => [
                'required',
                'string',
                'in:Johor,Kedah,Kelantan,Melaka,Negeri Sembilan,Pahang,Perak,Perlis,Pulau Pinang,Sabah,Sarawak,Selangor,Terengganu,Wilayah Persekutuan Kuala Lumpur,Wilayah Persekutuan Labuan,Wilayah Persekutuan Putrajaya'
            ],
            // Work & Personal Information
            'gender' => 'required|in:Lelaki,Perempuan',
            'DOB' => 'required|date',
            'agama' => 'required|string|max:255',
            'bangsa' => 'required|string|max:255',
            'jawatan' => 'required|string|max:255',
            'gred' => 'required|string|max:255',
            'no_pf' => 'required|string|max:255',
            'salary' => 'required|numeric|min:0',
            'office_address' => 'required|string',
            'office_city' => 'required|string|max:255',
            'office_postcode' => 'required|string|max:5',
            'office_state' => 'required|string',

            // Family Members (if any)
            'family' => 'nullable|array',
            'family.*.name' => 'required|string|max:255',
            'family.*.ic' => 'required|string|max:255',
            'family.*.relationship' => 'required|string|max:255',

            // Fees and Savings
            'fees' => 'required|array',
            'fees.entrance' => 'required|numeric|min:0',
            'fees.share_capital' => 'required|numeric|min:0',
            'fees.subscription_capital' => 'required|numeric|min:0',
            'fees.member_deposit' => 'required|numeric|min:0',
            'fees.welfare_fund' => 'required|numeric|min:0',
            'fees.fixed_savings' => 'required|numeric|min:0',

            // Add payment validation rules
            'payment_method' => 'required|in:cash,online',
            'payment_proof' => 'required_if:payment_method,online|file|image|mimes:jpeg,png,gif|max:5120',
        ], [
            // Custom error messages
            'no_anggota.required' => 'Sila masukkan nombor anggota',
            'name.required' => 'Sila masukkan nama',
            'email.required' => 'Sila masukkan alamat emel',
            'email.email' => 'Alamat emel tidak sah',
            'ic.required' => 'Sila masukkan nombor kad pengenalan',
            'ic.size' => 'Nombor kad pengenalan mestilah 12 nombor',
            'ic.regex' => 'Nombor kad pengenalan mestilah nombor sahaja',
            'phone.required' => 'Sila masukkan nombor telefon',
            'phone.regex' => 'Nombor telefon mestilah nombor sahaja',
            'phone.min' => 'Nombor telefon mestilah sekurang-kurangnya 10 nombor',
            'phone.max' => 'Nombor telefon tidak boleh melebihi 11 nombor',
            // Address error messages
            'address.required' => 'Sila masukkan alamat',
            'city.required' => 'Sila masukkan bandar',
            'postcode.required' => 'Sila masukkan poskod',
            'postcode.size' => 'Poskod mestilah 5 nombor',
            'postcode.regex' => 'Poskod mestilah nombor sahaja',
            'state.required' => 'Sila pilih negeri',
            'state.in' => 'Negeri tidak sah',
        ]);

        try {
            DB::beginTransaction();
            
            // Handle payment proof upload if online payment
            $paymentProofPath = null;
            if ($request->payment_method === 'online' && $request->hasFile('payment_proof')) {
                $proofFile = $request->file('payment_proof');
                $proofName = time() . '_' . $proofFile->getClientOriginalName();
                $proofFile->move(public_path('uploads/payment_proofs'), $proofName);
                $paymentProofPath = 'uploads/payment_proofs/' . $proofName;
            }

            // Insert member data with status
            $member = DB::table('member_register')->insertGetId([
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
                'guest_id' => auth()->id(),
                'payment_method' => $request->payment_method,
                'payment_proof' => $paymentProofPath,
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now()
            ]);

            Log::info('Member inserted with ID: ' . $member);

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

            // Add this before processing family members
            Log::info('Family data:', ['family' => $request->family]);

            // 4. Insert family members if any
            if ($request->has('family')) {
                foreach ($request->family as $familyMember) {
                    DB::table('family')->insert([
                        'relationship' => $familyMember['relationship'],
                        'name' => $familyMember['name'],
                        'ic' => $familyMember['ic'],
                        'no_anggota' => $member,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            DB::commit();
            Log::info('Transaction committed successfully');

            return redirect()->route('guest.success')
                ->with('success', 'Pendaftaran anda telah berjaya dihantar!');

        } catch (\Exception $e) {
            // If there's an error and we uploaded a file, clean it up
            if (isset($paymentProofPath)) {
                $fullPath = 'public/' . $paymentProofPath;
                if (file_exists($fullPath)) {
                    unlink($fullPath);
                }
            }
            
            DB::rollBack();
            Log::error('Registration Error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return back()
                ->withInput()
                ->withErrors(['error' => 'Ralat pendaftaran: ' . $e->getMessage()]);
        }
    }

   
}

