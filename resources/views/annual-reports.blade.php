@auth
    @if(auth()->user()->isA('admin'))
        <x-app-layout>
            @include('admin.annual-reports.index')
        </x-app-layout>
    @else
        <x-app-layout>
            @include('auth.annual-report')
        </x-app-layout>
    @endif
@else
    @include('auth.annual-report')
@endauth