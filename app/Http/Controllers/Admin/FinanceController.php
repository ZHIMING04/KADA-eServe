<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Loan;
use Illuminate\Support\Facades\DB;

class FinanceController extends Controller
{
    public function index()
    {
        $loans = Loan::with('member')->get();
        return view('admin.finance', compact('loans'));
    }

    public function show($loanId)
    {
        $loan = Loan::with(['member', 'loanType', 'bank', 'guarantors'])
            ->findOrFail($loanId);
        return view('admin.finance.show', compact('loan'));
    }

    public function edit($loanId)
    {
        $loan = Loan::with(['member', 'loanType', 'bank', 'guarantors'])
            ->findOrFail($loanId);
        return view('admin.finance.edit', compact('loan'));
    }

    public function update(Request $request, $loanId)
    {
        $loan = Loan::findOrFail($loanId);
        
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'notes' => 'nullable|string|max:500',
            // Add other fields as needed
        ]);

        $loan->update($validated);

        return redirect()->route('admin.loans.show', $loan)
            ->with('success', 'Loan details updated successfully');
    }

    public function destroy($loanId)
    {
        $loan = Loan::findOrFail($loanId);
        $loan->delete();

        return redirect()->route('admin.loans.index')
            ->with('success', 'Loan deleted successfully');
    }

    public function approve($loanId)
    {
        try {
            $loan = Loan::findOrFail($loanId);
            
            if ($loan->status !== 'pending') {
                return redirect()->back()
                    ->with('error', 'Hanya permohonan yang dalam status menunggu boleh diluluskan.');
            }

            $loan->update([
                'status' => 'approved'
            ]);

            return redirect()->route('admin.finance.index')
                ->with('success', 'Permohonan pinjaman telah diluluskan.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Ralat semasa meluluskan pinjaman: ' . $e->getMessage());
        }
    }

    public function reject($loanId)
    {
        try {
            $loan = Loan::findOrFail($loanId);
            
            if ($loan->status !== 'pending') {
                return redirect()->back()
                    ->with('error', 'Hanya permohonan yang dalam status menunggu boleh ditolak.');
            }

            $loan->update([
                'status' => 'rejected'
            ]);

            return redirect()->route('admin.finance.index')
                ->with('success', 'Permohonan pinjaman telah ditolak.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Ralat semasa menolak pinjaman: ' . $e->getMessage());
        }
    }

    public function export()
    {
        $loans = Loan::with(['member', 'loanType', 'bank'])
            ->get();
            
        // Implement your export logic here
        // You might want to use Laravel Excel or create a CSV
        
        return response()->download('path/to/exported/file');
    }
} 