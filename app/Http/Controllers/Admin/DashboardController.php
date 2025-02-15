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
            
            // Modified member data query to include only approved members
            $memberData = Member::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
                ->where('status', 'approved')
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
            // Modified for approved members only
            $total = Member::where('status', 'approved')
                ->whereYear('created_at', $year)
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
        ->where('status', 'approved')
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
             // Modified savings data query with proper joins and status filter
             $savingsData = DB::table('savings')
                 ->join('member_register', 'savings.no_anggota', '=', 'member_register.id')
                 ->where(function($query) {
                     $query->where('member_register.status', '=', 'approved');
                 })  // Explicit filter for approved members only
                 ->whereYear('savings.created_at', $year)
                 ->selectRaw('
                     MONTH(savings.created_at) as month,
                     SUM(CASE WHEN member_register.status = "approved" THEN COALESCE(entrance_fee, 0) ELSE 0 END) as entrance_fee,
                     SUM(CASE WHEN member_register.status = "approved" THEN COALESCE(share_capital, 0) ELSE 0 END) as share_capital,
                     SUM(CASE WHEN member_register.status = "approved" THEN COALESCE(subscription_capital, 0) ELSE 0 END) as subscription_capital,
                     SUM(CASE WHEN member_register.status = "approved" THEN COALESCE(member_deposit, 0) ELSE 0 END) as member_deposit,
                     SUM(CASE WHEN member_register.status = "approved" THEN COALESCE(welfare_fund, 0) ELSE 0 END) as welfare_fund,
                     SUM(CASE WHEN member_register.status = "approved" THEN COALESCE(fixed_savings, 0) ELSE 0 END) as fixed_savings,
                     SUM(CASE WHEN member_register.status = "approved" THEN 
                         COALESCE(entrance_fee, 0) + 
                         COALESCE(share_capital, 0) + 
                         COALESCE(subscription_capital, 0) + 
                         COALESCE(member_deposit, 0) + 
                         COALESCE(welfare_fund, 0) + 
                         COALESCE(fixed_savings, 0)
                     ELSE 0 END) as amount
                 ')
                 ->groupBy('month')
                 ->orderBy('month')
                 ->get();

             // For Loan Statistics
             $loanData = DB::table('loans')
                 ->join('member_register', 'loans.member_id', '=', 'member_register.id')
                 ->join('loan_types', 'loans.loan_type_id', '=', 'loan_types.loan_type_id')
                 ->where('member_register.status', 'approved')
                 ->selectRaw('MONTH(loans.created_at) as month, 
                             COUNT(*) as count,
                             SUM(loans.loan_amount) as total_amount,
                             loans.status')
                 ->whereYear('loans.created_at', $year)
                 ->groupBy('month', 'loans.status')
                 ->orderBy('month')
                 ->get();

             // Process loan data for different statuses
             $loanChartData = collect(range(1, 12))->map(function($month) use ($loanData) {
                 $monthData = $loanData->where('month', $month);
                 return [
                     'month' => $month,
                     'pending' => $monthData->where('status', 'pending')->first()->count ?? 0,
                     'approved' => $monthData->where('status', 'approved')->first()->count ?? 0,
                     'rejected' => $monthData->where('status', 'rejected')->first()->count ?? 0,
                     'total_amount' => $monthData->sum('total_amount') ?? 0
                 ];
             });

             // Fill in the actual data while preserving zeros for months without data
             $savings = collect($monthlyData)->map(function($default, $month) use ($savingsData) {
                 $monthData = $savingsData->firstWhere('month', $month);
                 return [
                     'month' => (int)$month,
                     'amount' => $monthData ? (float)$monthData->amount : 0.0
                 ];
             })->values();

             // Transform the data for the chart
             $savingsChartData = $savings->pluck('amount')->toArray();
             $savingsChartLabels = $savings->map(function($item) use ($year) {
                 $monthNames = [
                     1 => 'Jan', 2 => 'Feb', 3 => 'Mac', 4 => 'Apr',
                     5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Ogo',
                     9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Dis'
                 ];
                 return $monthNames[$item['month']] . ' ' . $year;
             })->toArray();
         } else {
             // Monthly period query with proper joins
             $savingsData = DB::table('savings')
                 ->join('member_register', 'savings.no_anggota', '=', 'member_register.id')
                 ->where(function($query) {
                     $query->where('member_register.status', '=', 'approved');
                 })  // Explicit filter for approved members only
                 ->whereYear('savings.created_at', $year)
                 ->whereMonth('savings.created_at', $month)
                 ->selectRaw('
                     SUM(CASE WHEN member_register.status = "approved" THEN COALESCE(entrance_fee, 0) ELSE 0 END) as entrance_fee,
                     SUM(CASE WHEN member_register.status = "approved" THEN COALESCE(share_capital, 0) ELSE 0 END) as share_capital,
                     SUM(CASE WHEN member_register.status = "approved" THEN COALESCE(subscription_capital, 0) ELSE 0 END) as subscription_capital,
                     SUM(CASE WHEN member_register.status = "approved" THEN COALESCE(member_deposit, 0) ELSE 0 END) as member_deposit,
                     SUM(CASE WHEN member_register.status = "approved" THEN COALESCE(welfare_fund, 0) ELSE 0 END) as welfare_fund,
                     SUM(CASE WHEN member_register.status = "approved" THEN COALESCE(fixed_savings, 0) ELSE 0 END) as fixed_savings,
                     SUM(CASE WHEN member_register.status = "approved" THEN 
                         COALESCE(entrance_fee, 0) + 
                         COALESCE(share_capital, 0) + 
                         COALESCE(subscription_capital, 0) + 
                         COALESCE(member_deposit, 0) + 
                         COALESCE(welfare_fund, 0) + 
                         COALESCE(fixed_savings, 0)
                     ELSE 0 END) as total
                 ')
                 ->first();

             $savings = [[
                 'month' => (int)$month,
                 'amount' => (float)($savingsData->total ?? 0)
             ]];

             $loanData = DB::table('loans')
                 ->join('member_register', 'loans.member_id', '=', 'member_register.id')
                 ->join('loan_types', 'loans.loan_type_id', '=', 'loan_types.loan_type_id')
                 ->where('member_register.status', 'approved')
                 ->whereYear('loans.created_at', $year)
                 ->whereMonth('loans.created_at', $month)
                 ->select(
                     DB::raw('COUNT(*) as count'),
                     DB::raw('SUM(loan_amount) as total_amount'),
                     'loans.status'
                 )
                 ->groupBy('loans.status')
                 ->get();

             // Prepare data for charts
             $savingsChartData = $period === 'annually' 
                 ? $savingsData->pluck('total_amount')->toArray()
                 : [$savingsData->total ?? 0];

             $loanChartData = $period === 'annually'
                 ? $loanChartData->values()->toArray()
                 : [[
                     'pending' => $loanData->where('status', 'pending')->first()->count ?? 0,
                     'approved' => $loanData->where('status', 'approved')->first()->count ?? 0,
                     'rejected' => $loanData->where('status', 'rejected')->first()->count ?? 0,
                     'total_amount' => $loanData->sum('total_amount') ?? 0
                 ]];
         }

        // Add total for display in stats card
        $totalSavingsDisplay = Savings::join('member_register', 'savings.no_anggota', '=', 'member_register.id')
            ->where('member_register.status', 'approved')
            ->whereYear('savings.created_at', $year)
            ->sum('savings.total_amount');

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
            // Modified loan applications data
            $loanApplicationsData = Loan::join('member_register', 'loans.member_id', '=', 'member_register.id')
                ->where('member_register.status', 'approved')
                ->selectRaw('MONTH(loans.created_at) as month, COUNT(*) as total')
                ->whereYear('loans.created_at', $year)
                ->groupBy('month')
                ->orderBy('month')
                ->get();

            // Modified loan approvals data
            $loanApprovalsData = Loan::join('member_register', 'loans.member_id', '=', 'member_register.id')
                ->where('member_register.status', 'approved')
                ->where('loans.status', 'approved')
                ->whereYear('loans.created_at', $year)
                ->selectRaw('MONTH(loans.created_at) as month, COUNT(*) as total')
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

        // Calculate total savings for display
        $totalSavings = DB::table('savings')
            ->join('member_register', 'savings.no_anggota', '=', 'member_register.id')
            ->where('member_register.status', 'approved')
            ->whereYear('savings.created_at', $year)
            ->sum(DB::raw('
                COALESCE(entrance_fee, 0) + 
                COALESCE(share_capital, 0) + 
                COALESCE(subscription_capital, 0) + 
                COALESCE(member_deposit, 0) + 
                COALESCE(welfare_fund, 0) + 
                COALESCE(fixed_savings, 0)
            '));

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
            // Modified loan applications data
            $loanApplicationsData = Loan::join('member_register', 'loans.member_id', '=', 'member_register.id')
                ->where('member_register.status', 'approved')
                ->selectRaw('MONTH(loans.created_at) as month, COUNT(*) as total')
                ->whereYear('loans.created_at', $year)
                ->groupBy('month')
                ->orderBy('month')
                ->get();

            // Modified loan approvals data
            $loanApprovalsData = Loan::join('member_register', 'loans.member_id', '=', 'member_register.id')
                ->where('member_register.status', 'approved')
                ->where('loans.status', 'approved')
                ->whereYear('loans.created_at', $year)
                ->selectRaw('MONTH(loans.created_at) as month, COUNT(*) as total')
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
            'memberChartLabels',
            'loanChartData'
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




