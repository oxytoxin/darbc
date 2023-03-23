@php
    $roles = auth()->user()?->roles;
@endphp
<section class="flex justify-between">
    @if ($roles?->find(4))
        <section class="flex items-start space-x-2">
            <img class="w-[3rem] h-[3rem]" src="/assets/darbc-logo.svg" alt="darbc logo">
            <div class="leading-3">
                <h1 class="text-2xl font-[900] text-custom-blue">DARBC</h1>
                <span class="text-gray-600">Land Management</span>
            </div>
        </section>
    @else
        <button>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="25" height="25">
                <path class="fill-current text-primary-500" d="M3 4h18v2H3V4zm0 7h18v2H3v-2zm0 7h18v2H3v-2z" />
            </svg>
        </button>
    @endif
    <section class="flex items-center space-x-2">
        <img class="w-[39.73px] h-[39.73px] rounded-full" src="{{ asset('assets/darbc-logo.svg') }}" alt="">
        <div class="leading-4">
            <h1 class="font-medium">{{ auth()->user()?->first_name }}</h1>
            <p class="text-sm font-medium text-gray-500">{{ auth()->user()?->active_role->name }}</p>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">
                <x-heroicon-o-logout class="w-6 " />
            </button>
        </form>
    </section>
</section>
