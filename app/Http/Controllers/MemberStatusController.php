<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import the Auth facade
use App\Models\Member;
use Illuminate\Support\Facades\DB;

class MemberStatusController extends Controller
{
    public function display()
    {
        // Get the latest member record based on updated_at
        $member = Member::with(['savings' => function($query) {
            $query->latest(); // This ensures we get the latest savings record
        }, 'workingInfo', 'familyMembers'])
            ->where('email', auth()->user()->email)
            ->orderBy('updated_at', 'desc')
            ->first();

        return view('memberStatus.display', compact('member'));
    }
}
