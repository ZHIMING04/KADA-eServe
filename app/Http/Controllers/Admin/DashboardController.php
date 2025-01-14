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
        
        // Calculate total savings (modify based on your data structure)
        $totalSavings = $this->calculateTotalSaving();
        
        // Get total loan applications
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
        
        return round((($currentMonth - $lastMonth) / $lastMonth) * 100, 1);
    }

    private function calculateTotalSaving()
    {
        // Implement your total savings calculation logic here
        // Example: return User::sum('savings_amount');
        return 2500000; // Placeholder value - replace with actual calculation
    }

    private function calculateTotalLoanApplications()
    {
        return Loan::where('status', 'approved')->count();
    }
}
