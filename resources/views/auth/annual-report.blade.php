<x-app-layout>
    <div class="container my-5">
        <h2 class="mb-4">Laporan Tahunan KADA</h2>
        <div class="row">
            @forelse ($reports as $report)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        @if($report->thumbnail)
                            <img src="{{ asset('storage/' . $report->thumbnail) }}" class="card-img-top" alt="Report Thumbnail">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $report->title }}</h5>
                            <p class="card-text">{{ Str::limit($report->description, 100) }}</p>
                            <p class="text-muted">Tahun: {{ $report->year }}</p>
                            <a href="{{ asset('storage/' . $report->file_path) }}" 
                               class="btn btn-success" 
                               target="_blank">
                                Muat Turun PDF
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info">
                        Tiada laporan tahunan pada masa ini.
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>