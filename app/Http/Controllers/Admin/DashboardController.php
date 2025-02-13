<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Loan;
use App\Models\Member;
use App\Models\Savings;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;



class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $dashboardData = $this->getDashboardData($request);
        
        if (!$dashboardData) {
            return back()->with('error', 'Error loading dashboard data');
        }

        return view('admin.dashboard', $dashboardData);
        
    }

    public function getDashboardData(Request $request)
    {
        $period = $request->input('period', 'annually');
        $year = $request->input('year', date('Y'));
        $month = $period === 'monthly' ? $request->input('month', date('m')) : null;

        if ($period === 'annually') {
            // Initialize array with zeros for all months
            $monthlyData = array_fill(1, 12, 0);
            
            // Get member data for each month in the selected year
            $memberData = Member::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
                ->whereYear('created_at', $year)
                ->groupBy('month')
                ->orderBy('month')
                ->get();

            // Fill in the actual data while preserving zeros for months without data
            $totalMembers = collect($monthlyData)->map(function($default, $month) use ($memberData) {
                $monthData = $memberData->firstWhere('month', $month);
                return [
                    'month' => (int)$month,
                    'total' => $monthData ? (int)$monthData->total : 0
                ];
            })->values();

            // Transform the data for the chart
            $memberChartData = $totalMembers->pluck('total')->toArray();
            $memberChartLabels = $totalMembers->map(function($item) {
                $monthNames = [
                    1 => 'Jan', 2 => 'Feb', 3 => 'Mac', 4 => 'Apr',
                    5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Ogo',
                    9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Dis'
                ];
                return $monthNames[$item['month']] . ' ' . date('Y');
            })->toArray();
        } else {
            // Get monthly data for specific month
            $total = Member::whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->count();

            $monthNames = [
                1 => 'Jan', 2 => 'Feb', 3 => 'Mac', 4 => 'Apr',
                5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Ogo',
                9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Dis'
            ];
            
            $memberChartData = [$total];
            $memberChartLabels = [$monthNames[(int)$month] . ' ' . $year];
            $totalMembers = [[
                'month' => (int)$month,
                'total' => $total
            ]];
        }
    
    
            //************* Get member demographics by age *************//
            
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

        //**************** member demographics ****************//

        //Get total approved members count

        $totalApprovedMembers = Member::where('status', 'approved')
            ->whereYear('created_at', $year)
            ->count();

        //end of total approved members count

         //*************** Get total savings ****************//

         if ($period === 'annually') {
             // Initialize array with zeros for all months
             $monthlyData = array_fill(1, 12, 0);
             
             // Get savings data for each month in the selected year
             $savingsData = Savings::selectRaw('MONTH(created_at) as month, SUM(total_amount) as amount')
                 ->whereYear('created_at', $year)
                 ->groupBy('month')
                 ->orderBy('month')
                 ->get();

             // Fill in the actual data while preserving zeros for months without data
             $totalSavings = collect($monthlyData)->map(function($default, $month) use ($savingsData) {
                 $monthData = $savingsData->firstWhere('month', $month);
                 return [
                     'month' => (int)$month,
                     'amount' => $monthData ? (float)$monthData->amount : 0.0
                 ];
             })->values();

             // Transform the data for the chart
             $savingsChartData = $totalSavings->pluck('amount')->toArray();
             $savingsChartLabels = $totalSavings->map(function($item) {
                 $monthNames = [
                     1 => 'Januari', 2 => 'Februari', 3 => 'Mac', 4 => 'April',
                     5 => 'Mei', 6 => 'Jun', 7 => 'Julai', 8 => 'Ogos',
                     9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Disember'
                 ];
                 return $monthNames[$item['month']];
             })->toArray();
         } else {
             // Get total savings for specific month
             $totalSavingsQuery = Savings::whereYear('created_at', $year);
             if ($period === 'monthly') {
                 $totalSavingsQuery->whereMonth('created_at', $month);
             }
             $amount = $totalSavingsQuery->sum('total_amount');
             
             // Only include data if there's a non-zero amount for monthly view
             if ($amount > 0) {
                 $savingsChartData = [$amount];
                 $monthName = [
                     1 => 'Januari', 2 => 'Februari', 3 => 'Mac', 4 => 'April',
                     5 => 'Mei', 6 => 'Jun', 7 => 'Julai', 8 => 'Ogos',
                     9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Disember'
                 ][$month];
                 $savingsChartLabels = [$monthName . ' ' . $year];
                 
                 $totalSavings = [[
                     'month' => (int)$month,
                     'amount' => (float)$amount
                 ]];
             } else {
                 $savingsChartData = [];
                 $savingsChartLabels = [];
                 $totalSavings = [];
             }
         }

        // Add total for display in stats card
        $totalSavingsDisplay = collect($totalSavings)->sum('amount');

        //****************** Get member registration count ****************//

        $pendingMembers = Member::where('status', 'pending')
            ->whereYear('created_at', $year)
            ->count();

       
        // Calculate member growth percentage
        $previousMonthApprovedMembers = Member::where('status', 'approved')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', now()->subMonth()->month)
            ->count();

        $memberGrowthPercentage = $previousMonthApprovedMembers > 0 
            ? (($totalApprovedMembers - $previousMonthApprovedMembers) / $previousMonthApprovedMembers) * 100 
            : 0;

       
        // **************** Get total loan applications (all statuses) ****************** //
        
        $LoanApplicationsQuery = Loan::whereYear('created_at', $year);
        if ($period === 'monthly') {
            $LoanApplicationsQuery->whereMonth('created_at', $month);
        }
        $LoanApplications = $LoanApplicationsQuery
            ->selectRaw('COUNT(*) as total, MONTH(created_at) as month')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // ***************** Get total approved loan applications ***************** //

        $LoanApprovalsQuery = Loan::where('status', 'approved')->whereYear('created_at', $year);
        if ($period === 'monthly') {
            $LoanApprovalsQuery->whereMonth('created_at', $month);
        }
        $LoanApprovals = $LoanApprovalsQuery
            ->selectRaw('COUNT(*) as total, MONTH(created_at) as month')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Fix totalMembers calculation
        $totalMemberRegis = Member::whereYear('created_at', $year);
        $totalMembers = $totalMemberRegis->count(); // Define it here first
        
        if($period === 'monthly') {
            $totalMemberRegis->whereMonth('created_at', $month);
            $totalMembers = $totalMemberRegis->count(); // Update if monthly
        }
        
        // Get recent activities
        $recentActivities = $this->getRecentActivities($year, $month, $period);

        // **************** Get loan applications and approvals data ****************** //
        if ($period === 'annually') {
            // Initialize array with zeros for all months
            $monthlyData = array_fill(1, 12, 0);
            
            // Get loan applications data
            $loanApplicationsData = Loan::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
                ->whereYear('created_at', $year)
                ->groupBy('month')
                ->orderBy('month')
                ->get();

            // Get loan approvals data
            $loanApprovalsData = Loan::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
                ->where('status', 'approved')
                ->whereYear('created_at', $year)
                ->groupBy('month')
                ->orderBy('month')
                ->get();

            // Fill in the actual data while preserving zeros for months without data
            $LoanApplications = collect($monthlyData)->map(function($default, $month) use ($loanApplicationsData) {
                $monthData = $loanApplicationsData->firstWhere('month', $month);
                return [
                    'month' => (int)$month,
                    'total' => $monthData ? (int)$monthData->total : 0
                ];
            })->values();

            $LoanApprovals = collect($monthlyData)->map(function($default, $month) use ($loanApprovalsData) {
                $monthData = $loanApprovalsData->firstWhere('month', $month);
                return [
                    'month' => (int)$month,
                    'total' => $monthData ? (int)$monthData->total : 0
                ];
            })->values();
        } else {
            // Get monthly data for specific month
            $totalApplications = Loan::whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->count();

            $totalApprovals = Loan::where('status', 'approved')
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->count();

            // Create single-item collections for the specific month
            $monthName = [
                1 => 'Jan', 2 => 'Feb', 3 => 'Mac', 4 => 'Apr',
                5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Ogo',
                9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Dis'
            ][$month] . ' ' . $year;

            $LoanApplications = collect([
                [
                    'month' => (int)$month,
                    'total' => $totalApplications
                ]
            ]);

            $LoanApprovals = collect([
                [
                    'month' => (int)$month,
                    'total' => $totalApprovals
                ]
            ]);

            // Update chart data arrays
            $loanApplicationsData = [$totalApplications];
            $loanApprovalsData = [$totalApprovals];
            $loanLabels = [$monthName];
        }

        return compact(
            'totalApprovedMembers',
            'pendingMembers',
            'memberGrowthPercentage',
            'totalSavings',
            'totalSavingsDisplay',
            'savingsChartData',
            'savingsChartLabels',
            'LoanApplications',
            'LoanApprovals',
            'recentActivities',
            'totalMembers',
            'demographics',
            'memberChartData',
            'memberChartLabels'
        );
    }

    private function calculateUserGrowth()
    {
        $currentMonth = User::whereMonth('created_at', now()->month)->count();
        $lastMonth = User::whereMonth('created_at', now()->subMonth()->month)->count();
        
        return $lastMonth > 0 ? round((($currentMonth - $lastMonth) / $lastMonth) * 100, 1) : 0;
    }

    private function getRecentActivities($year, $month, $period)
    {
        $recentLoans = Loan::whereYear('created_at', $year);
        $recentRegistrations = Member::whereYear('created_at', $year);
        $recentSavings = Savings::whereYear('created_at', $year);

        if ($period === 'monthly') {
            $recentLoans->whereMonth('created_at', $month);
            $recentRegistrations->whereMonth('created_at', $month);
            $recentSavings->whereMonth('created_at', $month);
        }

        $recentLoans = $recentLoans->select('created_at as date', 'member_id', DB::raw("'Permohonan Pinjaman' as type"), 'status');
        $recentRegistrations = $recentRegistrations->select('created_at as date', 'id as member_id', DB::raw("'Pendaftaran Ahli' as type"), 'status');
        $recentSavings = $recentSavings->select('created_at as date', 'no_anggota as member_id', DB::raw("'Simpanan Baru' as type"), DB::raw("'completed' as status"));

        return $recentLoans->union($recentRegistrations)
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
    }

    public function getSavingsData(Request $request)
    {
        $period = $request->input('period', 'annually');
        $year = $request->input('year', date('Y'));
        $month = $request->input('month', date('m'));

        if ($period === 'annually') {
            // Get annual data
            $monthlyData = array_fill(1, 12, 0);
            
            $savingsData = Savings::selectRaw('MONTH(created_at) as month, SUM(total_amount) as amount')
                ->whereYear('created_at', $year)
                ->groupBy('month')
                ->orderBy('month')
                ->get();

            $savings = collect($monthlyData)->map(function($default, $month) use ($savingsData) {
                $monthData = $savingsData->firstWhere('month', $month);
                return [
                    'month' => (int)$month,
                    'amount' => $monthData ? (float)$monthData->amount : 0.0
                ];
            })->values();

            return response()->json(['savings' => $savings]);
        } else {
            // Get monthly data
            $total = Savings::whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->sum('total_amount');

            return response()->json(['total' => $total]);
        }
    }

}




