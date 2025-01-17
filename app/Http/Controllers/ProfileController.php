<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use App\Models\WorkingInfo;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */

    public function show(): View
    {
        $member = DB::table('member_register')->where('guest_id', auth()->id())->first();

        $workingInfo = WorkingInfo::where('no_anggota', $member->id)->first();
 
        return view('profile.show', compact('member','workingInfo'));
    }

    public function edit(Request $request): View
    {   
        $member = DB::table('member_register')->where('guest_id', auth()->id())->first();

        $workingInfo = WorkingInfo::where('no_anggota', $member->id)->first();
 
        return view('profile.edit', compact('member','workingInfo'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request):RedirectResponse
    {
        $member = DB::table('member_register')->where('guest_id', auth()->id())->first();
        $request->validate([
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'postcode' => 'required|string|max:5',
            'state' => 'required|string|max:255',
            'office_address' => 'required|string|max:255',
            'office_city' => 'required|string|max:255',
            'office_postcode' => 'required|string|max:5',
            'office_state' => 'required|string|max:255',
        ]);

        DB::table('member_register')->where('guest_id', auth()->id())->update([
            'address' => $request->address,
            'city' => $request->city,
            'postcode' => $request->postcode,
            'state' => $request->state,
        
            'office_address' => $request->office_address,
            'office_city' => $request->office_city,
            'office_postcode' => $request->office_postcode,
            'office_state' => $request->office_state,
        ]);

        return Redirect::route('profile.edit')->with('status', 'Profile updated successfully.');
    }
}