<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Loan;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $userGrowth = $this->calculateUserGrowth();
        
        // Get pending loan applications
        $pendingLoans = Loan::where('status', 'pending')->count();
        $totalSavings = $this->calculateTotalSaving();
        $totalLoanApplications = $this->calculateTotalLoanApplications();
        return view('admin.dashboard', compact(
            'totalUsers', 
            'userGrowth',
            'pendingLoans',
            'totalSavings',
            'totalLoanApplications',
        ));
    }

    private function calculateUserGrowth()
    {
        $currentMonth = User::whereMonth('created_at', now()->month)->count();
        $lastMonth = User::whereMonth('created_at', now()->subMonth()->month)->count();
        
        if ($lastMonth === 0) return 0;
        
        return round((($currentMonth - $lastMonth) / $lastMonth) * 100);
    }

    private function calculateTotalSaving()
    {
        return 100;

    }

    private function calculateTotalLoanApplications()
    {
        return 100;
    }
}
