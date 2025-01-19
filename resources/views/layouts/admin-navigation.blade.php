<x-nav-link :href="route('admin.annual-reports.index')" :active="request()->routeIs('admin.annual-reports.*')">
    {{ __('Annual Reports') }}
</x-nav-link> 