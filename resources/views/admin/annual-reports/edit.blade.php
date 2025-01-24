@extends('layouts.admin')

@section('title', 'Edit Laporan Tahunan')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <!-- Purple Header Section - matched with index -->
    <div class="text-white p-4 rounded-lg mb-6" style="background: linear-gradient(135deg, #8e5cbf 0%, #6c3baa 100%);">
        <div class="flex items-center gap-3">
            <div class="header-icon">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 2h12a2 2 0 012 2v16a2 2 0 01-2 2H6a2 2 0 01-2-2V4a2 2 0 012-2zM6 6h12M6 10h12M6 14h12M6 18h12"/>
                </svg>
            </div>
            <div>
                <h1 class="text-xl font-semibold">Edit Laporan Tahunan</h1>
                <p class="text-sm text-white/80">Kemaskini laporan tahunan</p>
            </div>
        </div>
    </div>

    @if(session('warning'))
        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('warning') }}</span>
        </div>
    @endif

    @if(session('update_error'))
        <div class="bg-red-100 border border-red-500 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('update_error') }}</span>
        </div>
    @endif

    <!-- Form Section - matched with index card size -->
    <div class="bg-white rounded-lg shadow-sm p-4">
        <h2 class="text-lg font-semibold text-blue-600 mb-4">KEMASKINI FAIL</h2>
        
        <form method="POST" action="{{ route('admin.annual-reports.update', $report->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="space-y-6 mb-6">
                <!-- Title Input -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Tajuk</label>
                    <input type="text" 
                           id="title" 
                           name="title" 
                           value="{{ old('title', $report->title) }}" 
                           required 
                           class="mt-1 block w-full h-12 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 pl-2">
                </div>

                <!-- Description Input -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Penerangan</label>
                    <textarea id="description" 
                              name="description" 
                              rows="3" 
                              required 
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 pl-2 pt-2">{{ old('description', $report->description) }}</textarea>
                </div>

                <!-- Year Input -->
                <div>
                    <label for="year" class="block text-sm font-medium text-gray-700">Tahun</label>
                    <select id="year" 
                            name="year" 
                            required 
                            class="mt-1 block w-full h-12 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 pl-2">
                        @for($i = date('Y'); $i >= 2000; $i--)
                            <option value="{{ $i }}" {{ (old('year', $report->year) == $i) ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>

                <!-- Thumbnail Input -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Thumbnail (Imej)</label>
                    @if($report->thumbnail)
                        <div class="mb-2">
                            <a href="{{ asset($report->thumbnail) }}" target="_blank" class="text-blue-600 hover:underline">Lihat Thumbnail Semasa</a>
                        </div>
                    @endif
                    <input type="file" 
                           name="thumbnail" 
                           accept="image/*"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2">
                    <p class="text-sm text-gray-500 mt-1">Biarkan kosong jika tidak mahu menukar thumbnail</p>
                </div>

                <!-- PDF File Input -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">Fail Laporan (PDF)</label>
                    @if($report->file_path)
                        <div class="mb-2">
                            <a href="{{ asset($report->file_path) }}" target="_blank" class="text-blue-600 hover:underline">Lihat PDF Semasa</a>
                        </div>
                    @endif
                    <input type="file" 
                           name="file_path" 
                           accept=".pdf"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2">
                    <p class="text-sm text-gray-500 mt-1">Biarkan kosong jika tidak mahu menukar fail PDF</p>
                </div>

                <div class="flex items-center gap-4">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                        Kemaskini Laporan
                    </button>
                    <a href="{{ route('admin.annual-reports.index') }}" class="text-gray-600 hover:text-gray-800">
                        Batal
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection 