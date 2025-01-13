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
        // Add this line at the start to debug incoming data
        Log::info('Form data:', $request->all());

        try {
            DB::transaction(function () use ($request) {
                // 1. Insert member data with guest_id
                $member = Member::create([
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
                    'guest_id' => auth()->id()
                ]);

                // 2. Insert working info
                DB::table('working_info')->insert([
                    'jawatan' => $request->jawatan,
                    'gred' => $request->gred,
                    'no_pf' => $request->no_pf,
                    'salary' => $request->salary,
                    'no_anggota' => $member->id,
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
                    'no_anggota' => $member->id,
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
                            'no_anggota' => $member->id,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            });

            return redirect()->route('guest.success')
                ->with('success', 'Pendaftaran anda telah berjaya dihantar!');

        } catch (\Exception $e) {
            Log::error('Registration Error: ' . $e->getMessage());
            return back()
                ->withInput()
                ->withErrors(['error' => 'Registration error: ' . $e->getMessage()]);
        }
    }

   
}

