<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AnnualReport;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class AnnualReportController extends Controller
{
    // User view: Display annual reports
    public function index()
    {
        $reports = AnnualReport::orderBy('year', 'desc')->get();
        return view('auth.annual-report', compact('reports'));
    }

    // Admin view: Display annual reports with management options
    public function adminIndex()
    {
        $reports = AnnualReport::all(); // Fetch all reports from the database
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

    // Store the uploaded report
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'year' => 'required|integer|between:2000,' . date('Y'),
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // Max 5MB for images
            'file_path' => 'required|mimes:pdf|max:102400', // Max 100MB for PDFs
        ]);

            // Store the uploaded files
            $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
            $pdfPath = $request->file('file_path')->store('pdfs', 'public');

        // Save the paths to the database
        AnnualReport::create([
            'title' => $request->title,
            'description' => $request->description,
            'year' => $request->year,
            'thumbnail' => $thumbnailPath,
            'file_path' => $pdfPath,
        ]);

        return redirect()->back()->with('success', 'Report uploaded successfully!');
    }

    // Admin: Show form to edit a report
    public function edit($id)
    {
        $report = AnnualReport::findOrFail($id);
        return view('admin.annual-reports.edit', compact('report'));
    }

    // Admin: Update a report
    public function update(Request $request, $id)
    {
        $report = AnnualReport::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'year' => 'required|integer|between:2000,' . date('Y'),
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            'file_path' => 'required|mimes:pdf|max:102400',
        ]);

        // Store files in public/storage/thumbnails and public/storage/pdfs
        $thumbnailPath = $request->file('thumbnail')->storeAs('public/thumbnails', time() . '_' . $request->file('thumbnail')->getClientOriginalName());
        $pdfPath = $request->file('file_path')->storeAs('public/pdfs', time() . '_' . $request->file('file_path')->getClientOriginalName());

        // Remove 'public/' from paths before saving to database
        $thumbnailPath = str_replace('public/', '', $thumbnailPath);
        $pdfPath = str_replace('public/', '', $pdfPath);

        // Delete old files
        Storage::delete('public/' . $report->thumbnail);
        Storage::delete('public/' . $report->file_path);

        $report->update([
            'title' => $request->title,
            'description' => $request->description,
            'year' => $request->year,
            'thumbnail' => $thumbnailPath,
            'file_path' => $pdfPath
        ]);

        return redirect()->route('admin.annual-reports.index')->with('success', 'Report updated successfully!');
    }

    // Admin: Delete a report
    public function destroy($id)
    {
        $report = AnnualReport::findOrFail($id);
        Storage::delete('public/' . $report->file_path); // Delete the file
        $report->delete();

        return redirect()->route('admin.annual-reports.index')->with('success', 'Report deleted successfully!');
    }

    public function upload(Request $request) {
        // Validate the request
        $request->validate([
            'thumbnail' => 'required|file|mimes:jpg,png|max:5120', // Adjust validation for thumbnail
            'file' => 'required|file|mimes:pdf|max:10240', // Adjust validation for PDF
        ]);

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail');
            $thumbnailPath = 'thumbnails'; // Define the destination path for thumbnails

            // Generate a unique name for the thumbnail
            $thumbnailName = time() . '_' . $thumbnail->getClientOriginalName();
            
            // Attempt to move the thumbnail
            if ($thumbnail->move($thumbnailPath, $thumbnailName)) {
                // Handle PDF upload
                if ($request->hasFile('file')) {
                    $pdf = $request->file('file');
                    $pdfPath = 'pdfs'; // Define the destination path for PDFs

                    // Generate a unique name for the PDF
                    $pdfName = time() . '_' . $pdf->getClientOriginalName();

                    // Attempt to move the PDF
                    if ($pdf->move($pdfPath, $pdfName)) {
                        return response()->json(['message' => 'File Upload Success'], 200); // Success response
                    } else {
                        return response()->json(['message' => 'Failed to upload PDF file'], 500); // Error response for PDF
                    }
                } else {
                    return response()->json(['message' => 'PDF file is missing'], 500); // Error response for PDF
                }
            } else {
                return response()->json(['message' => 'Failed to upload thumbnail'], 500); // Error response for thumbnail
            }
        } else {
            return response()->json(['message' => 'Thumbnail file is missing'], 500); // Error response for thumbnail
        }
    }
}
