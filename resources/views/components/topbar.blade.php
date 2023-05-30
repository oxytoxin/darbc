@php
    $roles = auth()->user()?->roles;
@endphp
<section class="flex justify-end">
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
