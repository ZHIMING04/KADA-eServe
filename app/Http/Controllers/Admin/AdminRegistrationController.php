<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class AdminRegistrationController extends Controller
{
    public function pending()
    {
        $pendingRegistrations = DB::table('member_register')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.registrations.pending', [
            'registrations' => $pendingRegistrations
        ]);
    }

    public function show($id)
    {
        $member = DB::table('member_register')
            ->where('id', $id)
            ->first();

        $workingInfo = DB::table('working_info')
            ->where('no_anggota', $member->id)
            ->first();

        $savings = DB::table('savings')
            ->where('no_anggota', $member->id)
            ->first();

        $familyMembers = DB::table('family')
            ->where('no_anggota', $member->id)
            ->get();

        return view('admin.registrations.show', compact('member', 'workingInfo', 'savings', 'familyMembers'));
    }
} 