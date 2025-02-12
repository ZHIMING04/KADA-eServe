@extends('layouts.admin')

@section('title', 'Maklumat Permohonan Berhenti')

@section('content')
    <!-- Back button and header -->
    <div class="mb-6">
        <a href="{{ route('admin.list.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Senarai Pemohon
        </a>
    </div>

    <!-- Current Resignation Details -->
    <div class="mb-6 flex gap-4">
        @if($latestResignation && $latestResignation->status === 'pending')
            <form action="{{ route('admin.resignation.approve', $latestResignation->id) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="px-6 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">
                    Lulus Permohonan
                </button>
            </form>
            
            <form action="{{ route('admin.resignation.reject', $latestResignation->id) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="px-6 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">
                    Tolak Permohonan
                </button>
            </form>
        @endif
    </div>

    @if($latestResignation && $latestResignation->status === 'pending')
        <!-- Member Information Cards -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Personal Information -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4 text-gray-800 border-b pb-2">Maklumat Peribadi</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <p class="text-sm text-gray-600">No. Ahli</p>
                        <p class="font-medium">{{ $member->no_anggota }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-sm text-gray-600">Nama</p>
                        <p class="font-medium">{{ $member->name }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-sm text-gray-600">No. KP</p>
                        <p class="font-medium">{{ $member->ic }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-sm text-gray-600">No. Telefon</p>
                        <p class="font-medium">{{ $member->phone }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-sm text-gray-600">Jantina</p>
                        <p class="font-medium">{{ $member->gender }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-sm text-gray-600">Tarikh Lahir</p>
                        <p class="font-medium">{{ $member->DOB }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-sm text-gray-600">Agama</p>
                        <p class="font-medium">{{ $member->agama }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-sm text-gray-600">Bangsa</p>
                        <p class="font-medium">{{ $member->bangsa }}</p>
                    </div>
                </div>

                <h3 class="text-lg font-semibold mt-6 mb-3 text-gray-800 border-b pb-2">Alamat Rumah</h3>
                <div class="space-y-2">
                    <p class="font-medium">{{ $member->address }}</p>
                    <p class="font-medium">{{ $member->postcode }} {{ $member->city }}</p>
                    <p class="font-medium">{{ $member->state }}</p>
                </div>
            </div>

            <!-- Working Information -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4 text-gray-800 border-b pb-2">Maklumat Pekerjaan</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <p class="text-sm text-gray-600">No. PF</p>
                        <p class="font-medium">{{ $member->no_pf }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-sm text-gray-600">Jawatan</p>
                        <p class="font-medium">{{ $member->workingInfo->jawatan }}</p>
                    </div>
                </div>

                <h3 class="text-lg font-semibold mt-6 mb-3 text-gray-800 border-b pb-2">Alamat Pejabat</h3>
                <div class="space-y-2">
                    <p class="font-medium">{{ $member->office_address }}</p>
                    <p class="font-medium">{{ $member->office_postcode }} {{ $member->office_city }}</p>
                    <p class="font-medium">{{ $member->office_state }}</p>
                </div>
            </div>

            <!-- Resignation Reasons -->
            <div class="bg-white rounded-lg shadow-md p-6 lg:col-span-2">
                <h2 class="text-xl font-semibold mb-4 text-gray-800 border-b pb-2">
                    @if($latestResignation && $latestResignation->status === 'pending')
                        Sebab-sebab Berhenti (Permohonan Terkini)
                    @else
                        Sebab-sebab Berhenti
                    @endif
                </h2>
                <div class="space-y-4">
                    @if($latestResignation)
                        @if($latestResignation->reason1)
                            <div class="p-4 bg-gray-50 rounded-lg">
                                <p class="text-sm text-gray-600">Sebab 1:</p>
                                <p class="font-medium">{{ $latestResignation->reason1 }}</p>
                            </div>
                        @endif

                        @if($latestResignation->reason2)
                            <div class="p-4 bg-gray-50 rounded-lg">
                                <p class="text-sm text-gray-600">Sebab 2:</p>
                                <p class="font-medium">{{ $latestResignation->reason2 }}</p>
                            </div>
                        @endif

                        @if($latestResignation->reason3)
                            <div class="p-4 bg-gray-50 rounded-lg">
                                <p class="text-sm text-gray-600">Sebab 3:</p>
                                <p class="font-medium">{{ $latestResignation->reason3 }}</p>
                            </div>
                        @endif

                        @if($latestResignation->reason4)
                            <div class="p-4 bg-gray-50 rounded-lg">
                                <p class="text-sm text-gray-600">Sebab 4:</p>
                                <p class="font-medium">{{ $latestResignation->reason4 }}</p>
                            </div>
                        @endif

                        @if($latestResignation->reason5)
                            <div class="p-4 bg-gray-50 rounded-lg">
                                <p class="text-sm text-gray-600">Sebab 5:</p>
                                <p class="font-medium">{{ $latestResignation->reason5 }}</p>
                            </div>
                        @endif
                    @else
                        <div class="p-4 bg-blue-50 rounded-lg">
                            <p class="text-sm text-blue-600">Tiada permohonan berhenti terkini.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @else
        <div class="mb-6">
            <span class="text-gray-500">Tiada permohonan berhenti yang aktif.</span>
        </div>
    @endif

    <!-- Previous Resignation History -->
    <div class="mt-6">
        <h1 class="text-xl font-semibold text-blue-600 mb-2">Sejarah Permohonan Berhenti</h1>
        
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="overflow-hidden rounded-lg shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead style="background: rgb(236, 72, 153)">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">No. Ahli</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Nama</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">No. KP</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">No. Telefon</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Tarikh Permohonan</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($previousResignations as $prevResignation)
                        @if($prevResignation->status === 'approved' || $prevResignation->status === 'rejected')
                            <tr class="{{ $prevResignation->status === 'pending' ? 'bg-yellow-100' : '' }}">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $prevResignation->member->no_anggota }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $prevResignation->member->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $prevResignation->member->ic }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $prevResignation->member->phone }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $prevResignation->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    @if($prevResignation->status === 'approved')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Diluluskan
                                        </span>
                                    @elseif($prevResignation->status === 'rejected')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Ditolak
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <button 
                                        class="text-blue-600 hover:text-blue-800" 
                                        onclick="openModal('{{ $prevResignation->id }}')">
                                        Lihat Sebab
                                    </button>
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4">
                                <div class="rounded-md bg-blue-50 p-4">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zm-1 5a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-blue-800">Tiada sejarah permohonan berhenti.</p>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal for Viewing Reasons -->
    <div id="reasonModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-lg w-full mx-auto">
                <!-- Modal Header -->
                <div class="flex justify-between items-center p-4 border-b">
                    <h3 class="text-lg font-semibold text-gray-900">Senarai Sebab Berhenti</h3>
                    <button type="button" onclick="closeModal()" class="text-gray-400 hover:text-gray-500">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                
                <!-- Modal Content -->
                <div class="p-4">
                    <div id="reasonContent" class="space-y-3">
                        <!-- Reasons will be inserted here -->
                    </div>
                </div>
                
                <!-- Modal Footer -->
                <div class="flex justify-end p-4 border-t">
                    <button type="button" 
                        class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200"
                        onclick="closeModal()">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        async function openModal(resignationId) {
            const modal = document.getElementById('reasonModal');
            const reasonContent = document.getElementById('reasonContent');
            
            // Show loading state
            reasonContent.innerHTML = '<div class="text-center py-4">Sedang memuatkan sebab-sebab...</div>';
            modal.classList.remove('hidden');

            try {
                const response = await fetch(`/admin/resignation/${resignationId}/reasons`);
                
                if (!response.ok) {
                    throw new Error('Gagal mendapatkan data. Sila cuba lagi.');
                }

                const reasons = await response.json();
                reasonContent.innerHTML = ''; // Clear loading state

                // Display each reason if it exists
                if (reasons.reason1) {
                    reasonContent.innerHTML += `
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <p class="text-sm text-gray-600">Sebab 1:</p>
                            <p class="font-medium">${reasons.reason1}</p>
                        </div>`;
                }

                if (reasons.reason2) {
                    reasonContent.innerHTML += `
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <p class="text-sm text-gray-600">Sebab 2:</p>
                            <p class="font-medium">${reasons.reason2}</p>
                        </div>`;
                }

                if (reasons.reason3) {
                    reasonContent.innerHTML += `
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <p class="text-sm text-gray-600">Sebab 3:</p>
                            <p class="font-medium">${reasons.reason3}</p>
                        </div>`;
                }

                if (reasons.reason4) {
                    reasonContent.innerHTML += `
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <p class="text-sm text-gray-600">Sebab 4:</p>
                            <p class="font-medium">${reasons.reason4}</p>
                        </div>`;
                }

                if (reasons.reason5) {
                    reasonContent.innerHTML += `
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <p class="text-sm text-gray-600">Sebab 5:</p>
                            <p class="font-medium">${reasons.reason5}</p>
                        </div>`;
                }

                // If no reasons found
                if (!reasons.reason1 && !reasons.reason2 && !reasons.reason3 && 
                    !reasons.reason4 && !reasons.reason5) {
                    reasonContent.innerHTML = `
                        <div class="p-4 bg-blue-50 rounded-lg">
                            <p class="text-sm text-blue-600">Tiada sebab yang direkodkan.</p>
                        </div>`;
                }

            } catch (error) {
                reasonContent.innerHTML = `
                    <div class="p-4 bg-red-50 rounded-lg">
                        <p class="text-sm text-red-600">Error: ${error.message}</p>
                    </div>`;
            }
        }

        function closeModal() {
            document.getElementById('reasonModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('reasonModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        // Close modal on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });
    </script>
@endsection 