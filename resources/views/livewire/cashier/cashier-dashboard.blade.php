<div>
    <div x-data="{ showStatGraph: false }">
        <div class="mt-10">
            <h1 class="text-xl font-bold text-custom-blue">Overview</h1>
            <div class="flex items-start justify-between h-full mt-2 space-x-2">
                <div class="flex flex-col flex-1">
                    <div class='grid flex-1 grid-cols-3 gap-2'>
                        <!-- Active members-->
                        <x-card-stat cardTitle='Active members' :statCount="$active_members_count">
                            <section class="flex items-center justify-between">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                    <path class="fill-current text-custom-blue"
                                        d="M12 14v2a6 6 0 0 0-6 6H4a8 8 0 0 1 8-8zm0-1c-3.315 0-6-2.685-6-6s2.685-6 6-6 6 2.685 6 6-2.685 6-6 6zm0-2c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm6 10.5l-2.939 1.545.561-3.272-2.377-2.318 3.286-.478L18 14l1.47 2.977 3.285.478-2.377 2.318.56 3.272L18 21.5z" />
                                </svg>
                                <button class="bg-custom-green/[7%] p-1 rounded-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-6 h-6 2">
                                        <path class="fill-current text-custom-green"
                                            d="m2.859 2.877 12.57-1.795a.5.5 0 0 1 .571.495v20.846a.5.5 0 0 1-.57.495L2.858 21.123a1 1 0 0 1-.859-.99V3.867a1 1 0 0 1 .859-.99zM4 4.735v14.53l10 1.429V3.306L4 4.735zM17 19h3V5h-3V3h4a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1h-4v-2zm-6.8-7 2.8 4h-2.4L9 13.714 7.4 16H5l2.8-4L5 8h2.4L9 10.286 10.6 8H13l-2.8 4z" />
                                    </svg>
                                </button>
                            </section>
                        </x-card-stat>

                        <!-- Original members-->
                        <x-card-stat cardTitle='Original member' :statCount="$original_members_count">
                            <section class="flex items-center justify-between">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                    <path class="fill-current text-custom-blue"
                                        d="M17.841 15.659l.176.177.178-.177a2.25 2.25 0 0 1 3.182 3.182l-3.36 3.359-3.358-3.359a2.25 2.25 0 0 1 3.182-3.182zM12 14v2a6 6 0 0 0-6 6H4a8 8 0 0 1 7.75-7.996L12 14zm0-13c3.315 0 6 2.685 6 6a5.998 5.998 0 0 1-5.775 5.996L12 13c-3.315 0-6-2.685-6-6a5.998 5.998 0 0 1 5.775-5.996L12 1zm0 2C9.79 3 8 4.79 8 7s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4z" />
                                </svg>
                                <button class="bg-custom-green/[7%] p-1 rounded-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-6 h-6 2">
                                        <path class="fill-current text-custom-green"
                                            d="m2.859 2.877 12.57-1.795a.5.5 0 0 1 .571.495v20.846a.5.5 0 0 1-.57.495L2.858 21.123a1 1 0 0 1-.859-.99V3.867a1 1 0 0 1 .859-.99zM4 4.735v14.53l10 1.429V3.306L4 4.735zM17 19h3V5h-3V3h4a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1h-4v-2zm-6.8-7 2.8 4h-2.4L9 13.714 7.4 16H5l2.8-4L5 8h2.4L9 10.286 10.6 8H13l-2.8 4z" />
                                    </svg>
                                </button>
                            </section>
                        </x-card-stat>

                        <!-- Replaced members-->
                        <x-card-stat cardTitle='Replaced members' :statCount="$replacement_members_count">
                            <section class="flex items-center justify-between">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                    <path class="fill-current text-custom-blue"
                                        d="M14 14.252v2.09A6 6 0 0 0 6 22l-2-.001a8 8 0 0 1 10-7.748zM12 13c-3.315 0-6-2.685-6-6s2.685-6 6-6 6 2.685 6 6-2.685 6-6 6zm0-2c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm6 6v-3.5l5 4.5-5 4.5V19h-3v-2h3z" />
                                </svg>
                                <button class="bg-custom-green/[7%] p-1 rounded-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-6 h-6 2">
                                        <path class="fill-current text-custom-green"
                                            d="m2.859 2.877 12.57-1.795a.5.5 0 0 1 .571.495v20.846a.5.5 0 0 1-.57.495L2.858 21.123a1 1 0 0 1-.859-.99V3.867a1 1 0 0 1 .859-.99zM4 4.735v14.53l10 1.429V3.306L4 4.735zM17 19h3V5h-3V3h4a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1h-4v-2zm-6.8-7 2.8 4h-2.4L9 13.714 7.4 16H5l2.8-4L5 8h2.4L9 10.286 10.6 8H13l-2.8 4z" />
                                    </svg>
                                </button>
                            </section>
                        </x-card-stat>

                        <!-- Deceased members-->
                        <x-card-stat cardTitle='Deceased members' :statCount="$deceased_members_count">
                            <section class="relative flex items-start justify-between">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                    <path class="fill-current text-custom-blue"
                                        d="M12 2c5.523 0 10 4.477 10 10 0 .727-.077 1.435-.225 2.118l-1.782-1.783a8 8 0 1 0-4.375 6.801 3.997 3.997 0 0 0 1.555 1.423A9.956 9.956 0 0 1 12 22C6.477 22 2 17.523 2 12S6.477 2 12 2zm7 12.172l1.414 1.414a2 2 0 1 1-2.93.11l.102-.11L19 14.172zM12 15c1.466 0 2.785.631 3.7 1.637l-.945.86C13.965 17.182 13.018 17 12 17c-1.018 0-1.965.183-2.755.496l-.945-.86A4.987 4.987 0 0 1 12 15zm-3.5-5a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3zm7 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3z" />
                                </svg>
                                <section class="flex flex-col">
                                    <button class="bg-custom-green/[7%] p-1 rounded-md">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-6 h-6 2">
                                            <path class="fill-current text-custom-green"
                                                d="m2.859 2.877 12.57-1.795a.5.5 0 0 1 .571.495v20.846a.5.5 0 0 1-.57.495L2.858 21.123a1 1 0 0 1-.859-.99V3.867a1 1 0 0 1 .859-.99zM4 4.735v14.53l10 1.429V3.306L4 4.735zM17 19h3V5h-3V3h4a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1h-4v-2zm-6.8-7 2.8 4h-2.4L9 13.714 7.4 16H5l2.8-4L5 8h2.4L9 10.286 10.6 8H13l-2.8 4z" />
                                        </svg>
                                    </button>
                                    <button class="bg-custom-green/[7%] p-1 rounded-md absolute top-10"
                                        @click="showStatGraph = true">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                            height="24">
                                            <path class="fill-current text-custom-blue"
                                                d="M3 12h4v9H3v-9zm14-4h4v13h-4V8zm-7-6h4v19h-4V2z" />
                                        </svg>
                                    </button>
                                </section>
                            </section>
                        </x-card-stat>

                        <!-- Current hold members-->
                        <x-card-stat cardTitle='Restricted members' :statCount="$members_on_hold_count">
                            <section class="flex items-center justify-between">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                    <path class="fill-current text-custom-orange"
                                        d="M12 2c5.523 0 10 4.477 10 10 0 2.4-.846 4.604-2.256 6.328l.034.036-1.414 1.414-.036-.034A9.959 9.959 0 0 1 12 22C6.477 22 2 17.523 2 12S6.477 2 12 2zM4 12a8 8 0 0 0 12.905 6.32l-2.375-2.376A2.51 2.51 0 0 1 14 16h-1v2h-2v-2H8.5v-2H14a.5.5 0 0 0 .09-.992L14 13h-4a2.5 2.5 0 0 1-2.165-3.75L5.679 7.094A7.965 7.965 0 0 0 4 12zm8-8c-1.848 0-3.55.627-4.905 1.68L9.47 8.055A2.51 2.51 0 0 1 10 8h1V6h2v2h2.5v2H10a.5.5 0 0 0-.09.992L10 11h4a2.5 2.5 0 0 1 2.165 3.75l2.156 2.155A8 8 0 0 0 12 4z" />
                                </svg>
                                <button class="bg-custom-green/[7%] p-1 rounded-md" @click="showStatGraph = true">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                        <path class="fill-current text-custom-blue"
                                            d="M3 12h4v9H3v-9zm14-4h4v13h-4V8zm-7-6h4v19h-4V2z" />
                                    </svg>
                                </button>
                            </section>
                        </x-card-stat>

                        @if ($latest_release)
                        <div class="bg-white border flex flex-col justify-between p-3 rounded-md h-[140px]">
                            <div class="flex items-center justify-between">
                                <h1 class="text-sm font-medium">{{ $latest_release->name }}</h1>
                                <section class="flex items-center space-x-1 text-custom-blue">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
                                    </svg>
                                    <h1 class="text-sm font-medium">{{ $latest_release->created_at->format('M d, Y') }}
                                    </h1>
                                </section>
                            </div>
                            <div class="leading-3">
                                <section class="flex items-center justify-between">
                                    <h1 class="text-2xl font-medium text-custom-orange">{{
                                        $latest_release->released_dividends_count }}</h1>
                                    <h1 class="text-2xl font-bold text-custom-blue">{{ $latest_release->dividends_count
                                        }}</h1>
                                </section>
                                <progress id="file" value="{{ $latest_release->released_dividends_count }}"
                                    max="{{ $latest_release->dividends_count }}"></progress>
                                <section class="flex items-center justify-between mt-1">
                                    <h1 class="text-sm font-medium text-gray-500">{{
                                        Akaunting\Money\Money::PHP(($latest_release->released_dividends_gross ?? 0) -
                                        ($latest_release->released_dividends_deductions ?? 0), false) }}</h1>
                                    <h1 class="text-sm font-bold text-custom-blue">{{
                                        Akaunting\Money\Money::PHP($latest_release->total_amount, true) }}</h1>
                                </section>
                            </div>
                            <section>
                                <p class="font-medium text-gray-500">{{ $latest_release->name }} release statistics</p>
                            </section>
                        </div>
                        @endif
                    </div>

                    <div class="my-3 bg-white border p-3 h-[250px]">
                        <h1 class="font-semibold text-custom-blue">2022 members grow chart</h1>
                        <div class="grid h-full place-content-center">
                            <h1 class="text-gray-500 animate-bounce">Coming soon</h1>
                        </div>
                    </div>
                </div>
                <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        var calendarEl = document.getElementById('calendar');
                        var calendar = new FullCalendar.Calendar(calendarEl, {
                            initialView: 'dayGridMonth',
                        });
                        calendar.render();
                    });
                </script>
                <div class="bg-white w-[22rem] p-2 rounded-md border">
                    <div id="calendar"></div>
                    <section class="px-3 mt-3">
                        <h2 class="font-semibold text-gray-900">Upcoming Events</h2>
                    </section>
                </div>
            </div>
        </div>

        <!-- Recent Transactions -->
        <div class="p-3 bg-white border rounded-md">
            <div class="flex items-center justify-between">
                <h1 class="font-semibold text-custom-blue">Recent Releases</h1>
                <a href="{{ route('cashier.releases.index') }}" class="flex items-center space-x-1 text-custom-blue">
                    <span class="text-sm">Show all</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
                    </svg>
                </a>
            </div>
            <div class="flex flex-col mt-2">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5">
                            <table class="min-w-full divide-y divide-gray-300">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500 pl-3 w-[15rem]">
                                            DATE</th>
                                        <th scope="col"
                                            class="py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500 w-[40rem]">
                                            TITLE</th>
                                        <th scope="col"
                                            class="py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase">
                                            STATUS
                                        </th>
                                        <th scope="col"
                                            class="px-3 py-3 text-right text-xs font-medium uppercase tracking-wide text-gray-500 w-[15rem]">
                                            TOTAL AMOUNT
                                        </th>
                                        <th scope="col"
                                            class="px-3 py-3 text-right text-xs font-medium uppercase tracking-wide text-gray-500 w-[15rem]">
                                            RELEASED AMOUNT
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse ($latest_releases as $release)
                                    <tr>
                                        <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                            {{ $release->created_at->format('h:i A F d, Y') }}
                                        </td>
                                        <td class="py-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap">
                                            {{ $release->name }}
                                        </td>
                                        <td class="py-4 text-sm text-gray-500 whitespace-nowrap">
                                            @if ($release->disbursed)
                                            <div>
                                                <span
                                                    class="bg-custom-green/[8%] py-1 px-4 rounded-full text-custom-green">DISBURSED</span>
                                            </div>
                                            @else
                                            <div>
                                                <span
                                                    class="bg-red-500/[8%] py-1 px-4 rounded-full text-red-700">PENDING</span>
                                            </div>
                                            @endif
                                        </td>
                                        <td
                                            class="px-3 py-4 text-sm font-bold text-right text-gray-500 whitespace-nowrap">
                                            {{ Akaunting\Money\Money::PHP($release->total_amount, true) }}
                                        </td>
                                        <td
                                            class="px-3 py-4 text-sm font-bold text-right text-gray-500 whitespace-nowrap">
                                            {{ Akaunting\Money\Money::PHP($release->gross - $release->deductions, false)
                                            }}
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5"
                                            class="px-3 py-4 text-sm text-center text-gray-500 whitespace-nowrap">07
                                            No releases found.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Components -->
    <x-admin-components.stat-bar />
</div>
