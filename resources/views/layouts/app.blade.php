@extends('layouts.base')

@section('body')
    @switch(auth()->user()?->active_role->id)
        @case(1)
            <x-sidebars.release-admin />
        @break

        @case(2)
            <x-sidebars.cashier />
        @break

        @case(3)
            <x-sidebars.office-staff />
        @break

        @default
    @endswitch

    <main class="ml-[18rem] flex-1 px-[1.5rem] pt-[1.3rem]">
        <x-topbar />

        @yield('content')

        @isset($slot)
            {{ $slot }}
        @endisset
    </main>
@endsection
