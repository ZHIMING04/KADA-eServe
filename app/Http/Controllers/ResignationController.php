<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resignation;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Notifications\ResignationApprovedNotification;
use App\Notifications\ResignationRejectedNotification;
use App\Models\User;

class ResignationController extends Controller
{
    public function showForm()
    {
        // Get latest member record
        $latestMember = Member::where('guest_id', Auth::user()->member->guest_id)
            ->latest()
            ->first();

        // Only check active resignations for the latest member record
        $activeResignation = Resignation::where('member_id', $latestMember->id)
            ->where('is_active', true)
            ->whereIn('status', ['pending', 'approved'])
            ->first();

        if ($activeResignation) {
            $message = $activeResignation->status === 'pending' 
                ? 'Permohonan anda sedang diproses. Sila tunggu sehingga keputusan dimaklumkan.'
                : 'Permohonan berhenti anda telah diluluskan.';
            
            return redirect()->route('profile.edit')
                ->withErrors(['warning' => $message]);
        }

        $workingInfo = DB::table('working_info')->where('no_anggota', $latestMember->id)->first();
        $latestMember->working_info = $workingInfo;
        
        return view('resignation.form', ['member' => $latestMember, 'workingInfo' => $workingInfo]);
    }

    public function submit(Request $request)
    {
        // Get latest member record
        $latestMember = Member::where('guest_id', Auth::user()->member->guest_id)
            ->latest()
            ->first();

        // Check for active resignations for the latest member record
        $activeResignation = Resignation::where('member_id', $latestMember->id)
            ->where('is_active', true)
            ->whereIn('status', ['pending', 'approved'])
            ->first();

        if ($activeResignation) {
            return redirect()->route('profile.edit')
                ->withErrors(['warning' => 'Permohonan anda sedang diproses. Sila tunggu sehingga keputusan dimaklumkan.']);
        }

        $request->validate([
            'reason1' => 'required|string|max:255',
            'reason2' => 'required|string|max:255',
            'reason3' => 'nullable|string|max:255',
            'reason4' => 'nullable|string|max:255',
            'reason5' => 'nullable|string|max:255',
        ]);
        
        $resignation = new Resignation();
        $resignation->member_id = $latestMember->id; // Use latest member's ID
        $resignation->reason1 = $request->reason1;
        $resignation->reason2 = $request->reason2;
        $resignation->reason3 = $request->reason3;
        $resignation->reason4 = $request->reason4;
        $resignation->reason5 = $request->reason5;
        $resignation->status = 'pending';
        $resignation->is_active = true;
        $resignation->save();

        return redirect()->route('profile.edit')->with('success', 'Permohonan berhenti telah berjaya dihantar.');
    }

    public function show($id)
    {
        $member = Member::findOrFail($id);
        $resignation = $member->resignation;
        
        if (!$resignation) {
            return redirect()->back()->with('error', 'Tiada permohonan berhenti.');
        }

        return view('admin.list.resign', compact('member', 'resignation'));
    }

    public function approve(Request $request, $id)
    {
        try {
            $resignation = Resignation::findOrFail($id);
            $member = Member::find($resignation->member_id);
            
            // Update both resignation and member status
            $resignation->update(['status' => 'approved']);
            $member->update(['status' => 'resigned']);
            
            // Send email notification
            $user = $member->user;
            if ($user) {
                $user->notify(new ResignationApprovedNotification());
            }
            
            return redirect()->route('admin.list.lists')
                ->with('success', 'Permohonan berhenti telah diluluskan dan email pemberitahuan telah dihantar.');
                
        } catch (\Exception $e) {
            return redirect()->route('admin.list.lists')
                ->with('error', 'Ralat semasa memproses permohonan. Sila cuba lagi.');
        }
    }

    public function reject(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            
            $resignation = Resignation::findOrFail($id);
            $member = Member::find($resignation->member_id);
            
            // Update resignation status and set is_active to false
            $resignation->update([
                'status' => 'rejected',
                'is_active' => false  // Set to false when rejected
            ]);
            
            // Send email notification
            $user = $member->user;
            if ($user) {
                $user->notify(new ResignationRejectedNotification());
            }
            
            DB::commit();
            
            return redirect()->route('admin.list.lists')
                ->with('success', 'Permohonan berhenti telah ditolak dan email pemberitahuan telah dihantar.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Resignation rejection error: ' . $e->getMessage());
            return redirect()->route('admin.list.lists')
                ->with('error', 'Ralat semasa memproses permohonan. Sila cuba lagi.');
        }
    }

    public function view($id)
    {
        $resignation = Resignation::with('member')->findOrFail($id);
        return view('admin.resignations.view', compact('resignation'));
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'resignation_id' => 'required|exists:resignations,id',
            'status' => 'required|string|in:pending,approved,rejected',
        ]);

        $resignation = Resignation::find($request->resignation_id);
        $resignation->update(['status' => $request->status]);

        // If the status is approved, update the member's status
        if ($request->status === 'approved') {
            $member = Member::find($resignation->member_id);
            $member->update(['status' => 'Berhenti']); // or whatever status you want to set
        }

        return redirect()->route('admin.list.lists')->with('success', 'Status updated successfully.');
    }
}
