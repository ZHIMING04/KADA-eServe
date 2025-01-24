@extends('layouts.admin')

@section('content')
<div class="container py-6">
    <h1 class="text-2xl font-semibold text-blue-600 mb-4">MUAT NAIKAN LAPORAN TAHUNAN</h1>
    <form id="uploadForm" action="{{ route('admin.annual-reports.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="space-y-6 mb-6">
            <!-- Title Input -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Tajuk</label>
                <input 
                    type="text" 
                    id="title" 
                    name="title" 
                    required 
                    class="mt-1 block w-full h-12 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                >
            </div>

            <!-- Description Input -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Penerangan</label>
                <textarea 
                    id="description" 
                    name="description" 
                    rows="3" 
                    required 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                ></textarea>
            </div>

            <!-- Year Input -->
            <div>
                <label for="year" class="block text-sm font-medium text-gray-700">Tahun</label>
                <select 
                    id="year" 
                    name="year" 
                    required 
                    class="mt-1 block w-full h-12 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                >
                    @for($i = date('Y'); $i >= 2000; $i--)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>

            <!-- Thumbnail Input -->
            <div>
                <label for="thumbnail" class="block text-sm font-medium text-gray-700">Imej Muka Depan</label>
                <input 
                    type="file" 
                    id="thumbnail" 
                    name="thumbnail" 
                    accept="image/*" 
                    required 
                    class="mt-1 block w-full h-12 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                >
            </div>

            <!-- PDF File Input -->
            <div>
                <label for="file_path" class="block text-sm font-medium text-gray-700">PDF File</label>
                <input 
                    type="file" 
                    id="file_path" 
                    name="file_path" 
                    accept=".pdf" 
                    required 
                    class="mt-1 block w-full h-12 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                >
            </div>

            <!-- Submit Button -->
            <div class="flex justify-center mt-6">
                <button 
                    type="submit" 
                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                >   Muat Naik Laporan
                </button>
            </div>
        </div>
    </form>

    <a href="{{ route('admin.annual-reports.index') }}" class="btn">Back to List</a>
</div>
@endsection

