<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AnnualReport;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class AnnualReportController extends Controller
{
    // User view: Display annual reports
    public function index()
    {
        $reports = AnnualReport::orderBy('year', 'desc')->get();
        
        foreach($reports as $report) {
            Log::info('File paths:', [
                'year' => $report->year,
                'thumbnail' => $report->thumbnail,
                'pdf' => $report->file_path
            ]);
        }
        
        return view('auth.annual-report', compact('reports'));
    }

    // Admin view: Display annual reports with management options
    public function adminIndex()
    {
        // Debugging: Let's see what's in the database
        $reports = AnnualReport::select('id', 'year', 'title', 'created_at')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.annual-reports.index', compact('reports'));
    }

    // Show the upload form for users
    public function createUser()
    {
        return view('user.annual-reports.create'); // User view for the upload form
    }

    // Show the upload form for admins
    public function create()
    {
        return view('admin.annual-reports.create');
    }

    // Store new report (Upload)
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            // Validate the request
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'year' => 'required|integer|between:2000,' . date('Y'),
                'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // Required for new uploads
                'file_path' => 'required|mimes:pdf|max:102400', // Required for new uploads
            ]);

            // Handle thumbnail upload
            if ($request->hasFile('thumbnail')) {
                $thumbnailFile = $request->file('thumbnail');
                $thumbnailName = time() . '_' . $thumbnailFile->getClientOriginalName();
                $thumbnailFile->move(public_path('uploads/thumbnails'), $thumbnailName);
                $thumbnailPath = 'uploads/thumbnails/' . $thumbnailName;
            }

            // Handle PDF upload
            if ($request->hasFile('file_path')) {
                $pdfFile = $request->file('file_path');
                $pdfName = time() . '_' . $pdfFile->getClientOriginalName();
                $pdfFile->move(public_path('uploads/pdfs'), $pdfName);
                $pdfPath = 'uploads/pdfs/' . $pdfName;
            }

            // Create database record
            AnnualReport::create([
                'title' => $request->title,
                'description' => $request->description,
                'year' => $request->year,
                'thumbnail' => $thumbnailPath ?? null,
                'file_path' => $pdfPath ?? null,
            ]);

            DB::commit();
            return redirect()->route('admin.annual-reports.index')
                ->with('success', 'Laporan Tahunan berjaya dimuat naik!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Muat naik gagal: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal memuat naik laporan tahunan. Sila cuba lagi.');
        }
    }

    // Admin: Show form to edit a report
    public function edit($id)
    {
        $report = AnnualReport::findOrFail($id);
        return view('admin.annual-reports.edit', compact('report'));
    }

    // Update existing report (Edit)
    public function update(Request $request, AnnualReport $report)
    {
        try {
            // Validate the request
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'year' => 'required|integer|between:2000,' . date('Y'),
                'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
                'file_path' => 'nullable|mimes:pdf|max:102400',
            ]);

            // Check if any changes were made
            $hasChanges = false;
            
            if ($report->title !== $request->title || 
                $report->description !== $request->description || 
                $report->year != $request->year || 
                $request->hasFile('thumbnail') || 
                $request->hasFile('file_path')) {
                $hasChanges = true;
            }

            // If no changes were made, return with warning message
            if (!$hasChanges) {
                return back()->with('warning', 'Tiada perubahan dilakukan. Sila lakukan kemas kini yang diperlukan.');
            }

            // Start transaction
            DB::beginTransaction();

            // Update basic fields
            $report->title = $validated['title'];
            $report->description = $validated['description'];
            $report->year = $validated['year'];

            // Handle thumbnail upload if provided
            if ($request->hasFile('thumbnail')) {
                // Delete old thumbnail if exists
                if ($report->thumbnail && file_exists(public_path($report->thumbnail))) {
                    unlink(public_path($report->thumbnail));
                }
                $thumbnailFile = $request->file('thumbnail');
                $thumbnailName = time() . '_' . $thumbnailFile->getClientOriginalName();
                $thumbnailFile->move(public_path('uploads/thumbnails'), $thumbnailName);
                $report->thumbnail = 'uploads/thumbnails/' . $thumbnailName;
            }

            // Handle PDF upload if provided
            if ($request->hasFile('file_path')) {
                // Delete old PDF if exists
                if ($report->file_path && file_exists(public_path($report->file_path))) {
                    unlink(public_path($report->file_path));
                }
                $pdfFile = $request->file('file_path');
                $pdfName = time() . '_' . $pdfFile->getClientOriginalName();
                $pdfFile->move(public_path('uploads/pdfs'), $pdfName);
                $report->file_path = 'uploads/pdfs/' . $pdfName;
            }

            // Save all changes
            $report->save();

            DB::commit();

            return redirect()->route('admin.annual-reports.index')
                ->with('update_success', 'Laporan Tahunan berjaya dikemas kini!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Update failed: ' . $e->getMessage());
            return redirect()->back()
                ->with('update_error', 'Gagal mengemas kini laporan tahunan. Sila cuba lagi.');
        }
    }

    // Admin: Delete a report
    public function destroy($id)
    {
        $report = AnnualReport::findOrFail($id);
        $report->delete();
        
        return redirect()->route('admin.annual-reports.index')
            ->with('delete_success', 'Laporan Tahunan berjaya dipadam!');
    }

    public function search(Request $request)
    {
        $searchYear = $request->input('year');
        
        if ($searchYear) {
            $report = AnnualReport::where('year', $searchYear)->first();
            
            if ($report && $report->file_path) {
                // Return file path for JavaScript to open
                return response()->json([
                    'success' => true,
                    'file_path' => $report->file_path
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Tiada laporan untuk tahun ' . $searchYear
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Sila masukkan tahun'
        ]);
    }
}
