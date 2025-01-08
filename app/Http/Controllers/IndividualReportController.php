<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IndividualReport;


class IndividualReportController extends Controller
{
    public function display()
    {
        return view('individualReport.report');
    }
}

