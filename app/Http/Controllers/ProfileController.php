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
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyNewEmail;
use App\Service\SmsService;
use Worksome\VerifyByPhone\Contracts\PhoneVerificationService;


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


    public function updateEmail(Request $request)
    {
        $request->validate([
            'new-email' => 'required|email',
        ]);

        $member = DB::table('member_register')->where('guest_id', auth()->id())->first();
        $newEmail = $request->input('new-email');

        // Send verification email
        Mail::to($newEmail)->send(new VerifyNewEmail($member, $newEmail));

        // Store the new email in the session for later verification
        session(['new_email' => $newEmail]);

        return back()->with('status', 'verification-sent');
    }


    public function verifyNewEmail(Request $request)
    {
        $member = DB::table('member_register')->where('guest_id', auth()->id())->first();
        $newEmail = session('new_email');

        // Check if new email is set in the session
        if (!$newEmail) {
            return response()->json(['status' => 'error', 'message' => 'No new email found in session.']);
        }

        // Update the email in the database
        DB::table('member_register')->where('guest_id', auth()->id())->update(['email' => $newEmail]);

        // Clear the session
        session()->forget('new_email');

        return response()->json(['status' => 'success', 'message' => 'Email updated successfully.']);
    }


}