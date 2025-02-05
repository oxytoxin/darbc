@extends('layouts.base')
@php
    $roles = auth()->user()?->roles;
@endphp
@section('body')
    <div class="relative h-full">
        <div class="fixed inset-0 p-4 bg-primary-600 text-white z-50 md:hidden flex">
            This site is not optimized for mobile devices.
        </div>
        <div class="w-[18rem] fixed top-0 left-0 bottom-0 bg-white flex flex-col overflow-hidden  px-[1rem] py-[1.2rem]">
            <section class="flex items-center space-x-2">
                <img class="w-[3rem] h-[3rem]" src="/assets/darbc-logo.svg" alt="darbc logo">
                <h1 class="text-3xl font-[900] text-custom-blue">DARBC</h1>
            </section>

            <div class="overflow-y-auto h-full sidebar mt-[2.5rem] z-[9999]">
                <ul class="space-y-4">
                    @if ($roles?->find(1))
                        <li>
                            <x-sidebars.release-admin />
                        </li>
                    @endif
                    @if ($roles?->find(2))
                        <li>
                            <x-sidebars.cashier />
                        </li>
                    @endif
                    @if ($roles?->find(3))
                        <li>
                            <x-sidebars.office-staff />
                        </li>
                    @endif
                    @if ($roles?->find(1))
                        <li>
                            <x-sidebars.rsbsa />
                        </li>
                    @endif
                </ul>
            </div>

            <!-- SVG lines -->
            <section class="transform rotate-12 absolute -bottom-[5rem] -z-10">
                <svg width="669" height="1025" viewBox="0 0 669 1025" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path class='stroke-[#7D7D7D]/90' opacity="0.05" d="M614.731 55.5594C347.011 167.057 256.002 339.824 341.704 573.861C427.405 807.898 391.934 999.921 235.289 1149.93" stroke="#7D7D7D" stroke-opacity="0.1" stroke-width="2.5" stroke-linecap="round" />
                    <path class='stroke-[#7D7D7D]/90' opacity="0.08" d="M601.856 51.0958C342.719 165.569 256.002 339.825 341.704 573.861C427.405 807.898 387.642 998.433 222.415 1145.47" stroke="#7D7D7D" stroke-opacity="0.1" stroke-width="2.5" stroke-linecap="round" />
                    <path class='stroke-[#7D7D7D]/90' opacity="0.12" d="M588.982 46.6316C338.428 164.081 256.002 339.824 341.704 573.861C427.405 807.898 383.351 996.945 209.54 1141" stroke="#7D7D7D" stroke-opacity="0.1" stroke-width="2.5" stroke-linecap="round" />
                    <path class='stroke-[#7D7D7D]/90' opacity="0.15" d="M576.107 42.1678C334.136 162.593 256.002 339.825 341.704 573.861C427.406 807.898 379.059 995.457 196.665 1136.54" stroke="#7D7D7D" stroke-opacity="0.1" stroke-width="2.5" stroke-linecap="round" />
                    <path class='stroke-[#7D7D7D]/90' opacity="0.18" d="M563.232 37.7044C329.845 161.106 256.002 339.825 341.704 573.862C427.405 807.898 374.768 993.97 183.791 1132.08" stroke="#7D7D7D" stroke-opacity="0.1" stroke-width="2.5" stroke-linecap="round" />
                    <path class='stroke-[#7D7D7D]/90' opacity="0.21" d="M550.358 33.24C325.553 159.617 256.002 339.825 341.704 573.861C427.406 807.898 370.476 992.481 170.916 1127.61" stroke="#7D7D7D" stroke-opacity="0.1" stroke-width="2.5" stroke-linecap="round" />
                    <path class='stroke-[#7D7D7D]/90' opacity="0.25" d="M537.483 28.776C321.261 158.129 256.002 339.824 341.704 573.861C427.405 807.898 366.185 990.993 158.041 1123.15" stroke="#7D7D7D" stroke-opacity="0.1" stroke-width="2.5" stroke-linecap="round" />
                    <path class='stroke-[#7D7D7D]/90' opacity="0.28" d="M524.609 24.3125C316.97 156.642 256.002 339.825 341.704 573.862C427.406 807.898 361.893 989.506 145.167 1118.68" stroke="#7D7D7D" stroke-opacity="0.1" stroke-width="2.5" stroke-linecap="round" />
                    <path class='stroke-[#7D7D7D]/90' opacity="0.31" d="M511.734 19.8485C312.679 155.154 256.002 339.825 341.704 573.862C427.406 807.898 357.602 988.018 132.292 1114.22" stroke="#7D7D7D" stroke-opacity="0.1" stroke-width="2.5" stroke-linecap="round" />
                    <path class='stroke-[#7D7D7D]/90' opacity="0.34" d="M498.859 15.3845C308.387 153.666 256.002 339.825 341.704 573.861C427.406 807.898 353.31 986.53 119.417 1109.76" stroke="#7D7D7D" stroke-opacity="0.1" stroke-width="2.5" stroke-linecap="round" />
                    <path class='stroke-[#7D7D7D]/90' opacity="0.38" d="M485.984 10.9205C304.095 152.178 256.002 339.825 341.704 573.861C427.405 807.898 349.018 985.042 106.543 1105.29" stroke="#7D7D7D" stroke-opacity="0.1" stroke-width="2.5" stroke-linecap="round" />
                    <path class='stroke-[#7D7D7D]/90' opacity="0.41" d="M473.11 6.45642C299.804 150.69 256.002 339.824 341.704 573.861C427.405 807.898 344.727 983.553 93.668 1100.83" stroke="#7D7D7D" stroke-opacity="0.1" stroke-width="2.5" stroke-linecap="round" />
                    <path class='stroke-[#7D7D7D]/90' opacity="0.44" d="M460.235 1.99237C295.512 149.201 256.002 339.824 341.704 573.861C427.405 807.898 340.435 982.065 80.7934 1096.36" stroke="#7D7D7D" stroke-opacity="0.1" stroke-width="2.5" stroke-linecap="round" />
                    <path class='stroke-[#7D7D7D]/90' opacity="0.48" d="M447.361 -2.47097C291.221 147.714 256.002 339.825 341.704 573.862C427.406 807.898 336.144 980.578 67.9188 1091.9" stroke="#7D7D7D" stroke-opacity="0.1" stroke-width="2.5" stroke-linecap="round" />
                    <path class='stroke-[#7D7D7D]/90' opacity="0.51" d="M434.486 -6.93508C286.929 146.226 256.002 339.825 341.704 573.861C427.405 807.898 331.852 979.09 55.0441 1087.44" stroke="#7D7D7D" stroke-opacity="0.1" stroke-width="2.5" stroke-linecap="round" />
                    <path class='stroke-[#7D7D7D]/90' opacity="0.54" d="M421.611 -11.3991C282.638 144.738 256.002 339.825 341.704 573.861C427.406 807.898 327.561 977.602 42.1694 1082.97" stroke="#7D7D7D" stroke-opacity="0.1" stroke-width="2.5" stroke-linecap="round" />
                    <path class='stroke-[#7D7D7D]/90' opacity="0.57" d="M408.737 -15.8632C278.346 143.25 256.002 339.824 341.704 573.861C427.406 807.898 323.269 976.114 29.2949 1078.51" stroke="#7D7D7D" stroke-opacity="0.1" stroke-width="2.5" stroke-linecap="round" />
                    <path class='stroke-[#7D7D7D]/90' opacity="0.61" d="M395.862 -20.3269C274.055 141.762 256.002 339.825 341.704 573.861C427.406 807.898 318.978 974.626 16.4202 1074.04" stroke="#7D7D7D" stroke-opacity="0.1" stroke-width="2.5" stroke-linecap="round" />
                    <path class='stroke-[#7D7D7D]/90' opacity="0.64" d="M382.987 -24.7911C269.763 140.274 256.002 339.824 341.704 573.861C427.406 807.898 314.686 973.138 3.54556 1069.58" stroke="#7D7D7D" stroke-opacity="0.1" stroke-width="2.5" stroke-linecap="round" />
                    <path class='stroke-[#7D7D7D]/90' opacity="0.67" d="M370.113 -29.2547C265.471 138.786 256.002 339.825 341.704 573.861C427.406 807.898 310.395 971.65 -9.32909 1065.12" stroke="#7D7D7D" stroke-opacity="0.1" stroke-width="2.5" stroke-linecap="round" />
                    <path class='stroke-[#7D7D7D]/90' opacity="0.71" d="M357.238 -33.7188C261.18 137.298 256.002 339.824 341.704 573.861C427.406 807.898 306.103 970.162 -22.2038 1060.65" stroke="#7D7D7D" stroke-opacity="0.1" stroke-width="2.5" stroke-linecap="round" />
                    <path class='stroke-[#7D7D7D]/90' opacity="0.74" d="M344.363 -38.1825C256.888 135.81 256.002 339.825 341.704 573.861C427.405 807.898 301.811 968.674 -35.0785 1056.19" stroke="#7D7D7D" stroke-opacity="0.1" stroke-width="2.5" stroke-linecap="round" />
                    <path class='stroke-[#7D7D7D]/90' opacity="0.77" d="M331.489 -42.6466C252.597 134.322 256.002 339.825 341.704 573.861C427.406 807.898 297.52 967.186 -47.9532 1051.73" stroke="#7D7D7D" stroke-opacity="0.1" stroke-width="2.5" stroke-linecap="round" />
                    <path class='stroke-[#7D7D7D]/90' opacity="0.8" d="M318.614 -47.1103C248.305 132.834 256.002 339.825 341.704 573.861C427.406 807.898 293.228 965.698 -60.8278 1047.26" stroke="#7D7D7D" stroke-opacity="0.1" stroke-width="2.5" stroke-linecap="round" />
                    <path class='stroke-[#7D7D7D]/90' opacity="0.84" d="M305.739 -51.5742C244.014 131.346 256.002 339.825 341.704 573.861C427.406 807.898 288.937 964.21 -73.7025 1042.8" stroke="#7D7D7D" stroke-opacity="0.1" stroke-width="2.5" stroke-linecap="round" />
                    <path class='stroke-[#7D7D7D]/90' opacity="0.87" d="M292.865 -56.0383C239.722 129.858 256.002 339.825 341.704 573.861C427.406 807.898 284.645 962.722 -86.577 1038.33" stroke="#7D7D7D" stroke-opacity="0.1" stroke-width="2.5" stroke-linecap="round" />
                    <path class='stroke-[#7D7D7D]/90' opacity="0.9" d="M279.99 -60.5022C235.431 128.37 256.002 339.825 341.704 573.861C427.406 807.898 280.354 961.234 -99.4518 1033.87" stroke="#7D7D7D" stroke-opacity="0.1" stroke-width="2.5" stroke-linecap="round" />
                    <path class='stroke-[#7D7D7D]/90' opacity="0.93" d="M267.115 -64.9661C231.139 126.882 256.002 339.825 341.704 573.861C427.405 807.898 276.062 959.746 -112.327 1029.41" stroke="#7D7D7D" stroke-opacity="0.1" stroke-width="2.5" stroke-linecap="round" />
                    <path class='stroke-[#7D7D7D]/90' opacity="0.97" d="M254.241 -69.4302C226.848 125.394 256.002 339.824 341.704 573.861C427.406 807.898 271.771 958.258 -125.201 1024.94" stroke="#7D7D7D" stroke-opacity="0.1" stroke-width="2.5" stroke-linecap="round" />
                </svg>
            </section>
        </div>
    </div>

    <main class="flex-1 px-[1.5rem] ml-[18rem] pt-[1.3rem]">
        <x-topbar />

        @yield('content')

        @isset($slot)
            {{ $slot }}
        @endisset
    </main>
@endsection
