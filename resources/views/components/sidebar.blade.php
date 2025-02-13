<aside class="w-64 bg-white shadow-xl">
    <div class="p-6">
        <h2 class="text-2xl font-bold gradient-text">KADA Admin</h2>
    </div>
    <nav class="mt-6">
        <div class="px-4 space-y-2">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 text-gray-600 rounded-lg hover:bg-gray-100 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-100 text-gray-700' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <span class="mx-4 font-medium">Dashboard</span>
            </a>
            <a href="{{ route('admin.list.index') }}" class="flex items-center px-4 py-3 text-gray-600 rounded-lg hover:bg-gray-100 {{ request()->routeIs('admin.list.*') ? 'bg-gray-100 text-gray-700' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                </svg>
                <span class="mx-4 font-medium">Senarai</span>
            </a>
            <a href="{{ route('admin.members.index') }}" class="flex items-center px-4 py-3 text-gray-600 rounded-lg hover:bg-gray-100 {{ request()->routeIs('admin.members.*') ? 'bg-gray-100 text-gray-700' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                <span class="mx-4 font-medium">Ahli</span>
            </a>
            <a href="{{ route('admin.registrations.pending') }}" class="flex items-center px-4 py-3 text-gray-600 rounded-lg hover:bg-gray-100 {{ request()->routeIs('admin.registrations.*') ? 'bg-gray-100 text-gray-700' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
                <span class="mx-4 font-medium">Permohonan Baru</span>
            </a>
            <a href="{{ route('admin.transactions.index') }}" class="flex items-center px-4 py-3 text-gray-600 rounded-lg hover:bg-gray-100 {{ request()->routeIs('admin.transactions.*') ? 'bg-gray-100 text-gray-700' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <span class="mx-4 font-medium">Transaksi</span>
            </a>
            <a href="{{ route('admin.finance.index') }}" class="flex items-center px-4 py-3 text-gray-600 rounded-lg hover:bg-gray-100 {{ request()->routeIs('admin.finance.*') ? 'bg-gray-100 text-gray-700' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="mx-4 font-medium">Kewangan</span>
            </a>
            <a href="{{ route('admin.annual-reports.index') }}" class="flex items-center px-4 py-3 text-gray-600 rounded-lg hover:bg-gray-100 {{ request()->routeIs('admin.annual-reports.index') ? 'bg-gray-100 text-gray-700' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10l4-4m0 0l4 4m-4-4v12M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/>
                </svg>
                <span class="mx-4 font-medium">Laporan Tahunan</span>
            </a>
        </div>
    </nav>
</aside>