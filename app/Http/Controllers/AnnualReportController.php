<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use App\View\AnnualReport; 

class AnnualReportController extends Controller
{
    public function index()
    {
        //Fetch data from the AnnualReport class
        // $data = AnnualReport::getReportData(); 

        // Simply return the view without fetching data
        return view('annual_report.index');

        //Pass data to a view
        // return view('annual_report.index', $data);
    }
}
