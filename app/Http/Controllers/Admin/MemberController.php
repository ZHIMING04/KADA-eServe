<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Member;
use App\Models\WorkingInfo;
use App\Models\Savings;
use App\Models\Family;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::all();
        return view('admin.members', compact('members'));
    }

    public function show($id)
    {
        $member = Member::findOrFail($id);
        $workingInfo = WorkingInfo::where('no_anggota', $member->id)->first();
        $savings = Savings::where('no_anggota', $member->id)->first();
        $familyMembers = Family::where('no_anggota', $member->id)->get();

        return view('admin.member-details', compact('member', 'workingInfo', 'savings', 'familyMembers'));
    }

    public function batchDelete(Request $request)
    {
        try {
            $ids = explode(',', $request->selected_ids);
            Member::whereIn('id', $ids)->delete();
            
            return redirect()->back()->with('success', 'Members deleted successfully');
        } catch (\Exception $e) {
            \Log::error('Batch Delete Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error deleting members: ' . $e->getMessage());
        }
    }

    public function export(Request $request)
    {
        try {
            $ids = explode(',', $request->selected_ids);
            $fields = $request->fields ?? ['no_anggota', 'name', 'email']; // Default fields if none selected
            
            $membersData = Member::whereIn('id', $ids)->get();
            
            if ($membersData->isEmpty()) {
                return back()->with('error', 'No members selected for export');
            }

            $pdf = PDF::loadView('admin.exports.members-pdf', [
                'membersData' => $membersData,
                'fields' => $fields
            ])->setPaper('a4', 'landscape');

            return $pdf->download('members-export-' . now()->format('Y-m-d-His') . '.pdf');

        } catch (\Exception $e) {
            \Log::error('Export Error: ' . $e->getMessage());
            return back()->with('error', 'Error generating PDF: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $member = Member::findOrFail($id);
        $member->delete();
        
        return redirect()->route('admin.members.index')
                        ->with('success', 'Member deleted successfully');
    }
} 