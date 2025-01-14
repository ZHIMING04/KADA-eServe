@extends('layouts.admin')

@section('title', 'Pendaftaran Menunggu')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-6">Pendaftaran Menunggu Kelulusan</h1>
        
        @if($pendingRegistrations->isEmpty())
            <p class="text-gray-600">Tiada pendaftaran yang menunggu kelulusan.</p>
        @else
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. KP</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tarikh Mohon</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($pendingRegistrations as $registration)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $registration->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $registration->ic }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $registration->created_at->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.members.show', $registration->id) }}" 
                                           class="text-blue-600 hover:text-blue-900">Lihat</a>
                                    </div>
                                </td>
                                <td>
                                <form action="{{ route('admin.promote', $registration->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        Promote to Member
                                    </button>
                                </form>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection 