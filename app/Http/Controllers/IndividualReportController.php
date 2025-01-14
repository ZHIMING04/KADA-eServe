<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import the Auth facade
use App\Models\IndividualReport;
use App\Models\Member;
use App\Models\Loan;


class IndividualReportController extends Controller
{
    public function display()
    {
        //  // Retrieve the authenticated user
        //  $user = Auth::user();

        //  // Retrieve member details from the members table using the authenticated user's ID
        //  $member = Member::where('guest_id', $user->id)->first();
 
        //  // Check if the member exists
        //  if (!$member) {
        //      return redirect()->back()->with('error', 'Member not found.');
        //  }
 
        //  // Retrieve loan details for the member
        //  $loans = Loan::where('no_anggota', $member->no_anggota)->get();
 // return view('individualReport.report', compact('member', 'loans'));
         return view('individualReport.report');
    }
}

