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
        $member = Member::with(['savings', 'workingInfo', 'familymembers'])
                        ->where('guest_id', auth()->id())
                        ->first();

        return view('memberStatus.display', compact('member'));
    }
}
