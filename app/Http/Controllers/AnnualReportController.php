<?php

namespace App\Http\Controllers;

use App\Models\AnnualReport;

class AnnualReportController extends Controller
{
    public function index()
    {
        $reports = AnnualReport::orderBy('year', 'desc')->get();
        return view('annual-reports.index', compact('reports'));
    }
}
