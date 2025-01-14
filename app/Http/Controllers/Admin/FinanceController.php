<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Loan;

class FinanceController extends Controller
{
    public function index()
    {
        $loans = Loan::with(['member', 'loanType', 'bank'])->get();
        return view('admin.finance', compact('loans'));
    }

    public function show($loanId)
    {
        $loan = Loan::with(['member', 'loanType', 'bank', 'guarantors'])
            ->findOrFail($loanId);
        return view('admin.finance.show', compact('loan'));
    }
} 