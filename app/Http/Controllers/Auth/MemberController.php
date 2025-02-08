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
        return view('guest.register');
    }

    public function store(Request $request)
    {
        // Updated validation rules
        $validated = $request->validate([
            // Personal Information
            'no_anggota' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'ic' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'postcode' => 'required|string|max:5',
            'state' => 'required|string',

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

            // 1. Insert member data into member_register table
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
            if (isset($paymentProofPath) && file_exists(public_path($paymentProofPath))) {
                unlink(public_path($paymentProofPath));
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

