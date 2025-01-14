<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Loan;
use App\Models\Member;
use App\Models\Savings;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get total users (members)
        $totalUsers = Member::whereHas('user', function($query) {
            $query->whereIs('member');
        })->count();

        // Calculate user growth (you can modify this calculation as needed)
        $lastMonthUsers = Member::whereHas('user', function($query) {
            $query->whereIs('member');
        })
        ->whereMonth('created_at', '=', now()->subMonth()->month)
        ->count();

        $currentMonthUsers = Member::whereHas('user', function($query) {
            $query->whereIs('member');
        })
        ->whereMonth('created_at', '=', now()->month)
        ->count();

        $userGrowth = $lastMonthUsers > 0 
            ? (($currentMonthUsers - $lastMonthUsers) / $lastMonthUsers) * 100 
            : 0;

        // Get pending loans count
        $pendingLoans = Loan::where('status', 'pending')->count();

        // Get total savings for approved members
        $totalSavings = Savings::whereHas('member', function($query) {
            $query->whereHas('user', function($q) {
                $q->whereIs('member');
            });
        })->sum('total_amount');

        // Get active loans count
        $totalLoanApplications = Loan::where('status', 'approved')->count();

        // Get monthly savings data for the last 6 months
        $savingsTrend = Savings::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('YEAR(created_at) as year'),
            DB::raw('SUM(total_amount) as total')
        )
            ->whereDate('created_at', '>=', now()->subMonths(6))
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        // Get member demographics by age
        $demographics = Member::whereHas('user', function($query) {
            $query->whereIs('member');
        })
        ->select(
            DB::raw('
                CASE 
                    WHEN TIMESTAMPDIFF(YEAR, DOB, CURDATE()) BETWEEN 18 AND 30 THEN "18-30"
                    WHEN TIMESTAMPDIFF(YEAR, DOB, CURDATE()) BETWEEN 31 AND 40 THEN "31-40"
                    WHEN TIMESTAMPDIFF(YEAR, DOB, CURDATE()) BETWEEN 41 AND 50 THEN "41-50"
                    ELSE "51+"
                END as age_group'
            ),
            DB::raw('COUNT(*) as total')
        )
        ->groupBy('age_group')
        ->get();

        // Get recent activities by combining loans and member registrations
        $recentLoans = Loan::select(
            'created_at as date',
            'member_id',
            DB::raw("'Permohonan Pinjaman' as type"),
            'status'
        )->latest();

        $recentRegistrations = Member::select(
            'created_at as date',
            'id as member_id',
            DB::raw("'Pendaftaran Ahli' as type"),
            'status'
        )->latest();

        $recentSavings = Savings::select(
            'created_at as date',
            'no_anggota as member_id',
            DB::raw("'Simpanan Baru' as type"),
            DB::raw("'completed' as status")
        )->latest();

        $recentActivities = $recentLoans->union($recentRegistrations)
            ->union($recentSavings)
            ->orderBy('date', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($activity) {
                $member = Member::find($activity->member_id);
                return (object)[
                    'date' => $activity->date,
                    'name' => $member ? $member->name : 'Unknown',
                    'email' => $member ? $member->email : 'Unknown',
                    'type' => $activity->type,
                    'status' => $activity->status
                ];
            });

        return view('admin.dashboard', compact(
            'totalUsers',
            'userGrowth',
            'pendingLoans',
            'totalSavings',
            'totalLoanApplications',
            'savingsTrend',
            'demographics',
            'recentActivities'
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
