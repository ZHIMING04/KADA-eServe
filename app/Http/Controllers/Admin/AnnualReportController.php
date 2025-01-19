<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AnnualReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnnualReportController extends Controller
{
    public function index()
    {
        $reports = AnnualReport::orderBy('year', 'desc')->get();
        return view('admin.annual_reports.index', compact('reports'));
    }

    public function create()
    {
        return view('admin.annual_reports.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pdf' => 'required|mimes:pdf|max:10240'
        ]);

        try {
            $imagePath = $request->file('image')->store('annual-reports/images', 'public');
            $pdfPath = $request->file('pdf')->store('annual-reports/pdfs', 'public');

            AnnualReport::create([
                'title' => $request->title,
                'description' => $request->description,
                'year' => $request->year,
                'image_path' => $imagePath,
                'pdf_path' => $pdfPath
            ]);

            return redirect()
                ->route('admin.annual-reports.index')
                ->with('success', 'Annual report uploaded successfully.');
            
        } catch (\Exception $e) {
            // Clean up uploaded files if they exist
            if (isset($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
            if (isset($pdfPath)) {
                Storage::disk('public')->delete($pdfPath);
            }

            return back()
                ->withInput()
                ->withErrors(['error' => 'Failed to upload annual report. Please try again.']);
        }
    }

    public function destroy(AnnualReport $annualReport)
    {
        // Delete the files
        if ($annualReport->image_path) {
            Storage::disk('public')->delete($annualReport->image_path);
        }
        if ($annualReport->pdf_path) {
            Storage::disk('public')->delete($annualReport->pdf_path);
        }

        $annualReport->delete();

        return redirect()->route('admin.annual-reports.index')
            ->with('success', 'Annual report deleted successfully.');
    }
} 