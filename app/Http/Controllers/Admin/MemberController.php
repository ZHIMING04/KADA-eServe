<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{
    public function index()
    {
        $members = DB::table('member_register')
            ->select('id', 'no_anggota', 'name', 'email', 'ic', 'phone')
            ->get();

        return view('admin.members', compact('members'));
    }

    public function show($id)
    {
        $member = DB::table('member_register')
            ->where('id', $id)
            ->first();

        // Get related information
        $workingInfo = DB::table('working_info')
            ->where('no_anggota', $member->id)
            ->first();

        $family = DB::table('family')
            ->where('no_anggota', $member->id)
            ->get();

        $savings = DB::table('savings')
            ->where('no_anggota', $member->id)
            ->first();

        return view('admin.members.show', compact('member', 'workingInfo', 'family', 'savings'));
    }
} 