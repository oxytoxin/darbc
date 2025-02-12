<div class="border-4 border-black p-4 w-full">
    <!-- Main Header Section -->
    <div class="flex justify-between items-start">
        <!-- Left Side: Logo & Title -->
        <div class="w-3/4">
            <div class="flex items-center space-x-4">
                <!-- Department Logo -->
                <img src="{{asset('assets/darbc-logo.svg')}}" alt="DA Logo" class="h-16 w-16">
                <div>
                    <h1 class="text-2xl font-extrabold uppercase leading-tight">ANI AT KITA <br> RSBSA Enrollment Form</h1>
                    <p class="text-sm font-semibold uppercase text-gray-700">Registry System for Basic Sectors in Agriculture (RSBSA)</p>
                </div>
            </div>

            <!-- Enrollment Type & Date Administered -->
            <div class="flex items-center mt-3">
                <p class="text-xs font-bold uppercase mr-2">Enrollment Type & <br> Date Administered:</p>
                <!-- Checkboxes for Enrollment Type -->
                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-1">
                        <div class="border border-black h-4 w-4 flex items-center justify-center relative before:content-['✓'] before:text-black before:absolute before:text-xs"></div>
                        <span class="text-sm">New</span>
                    </div>
                    <div class="flex items-center space-x-1">
                        <div class="border border-black h-4 w-4"></div>
                        <span class="text-sm">Updating</span>
                    </div>
                </div>
                

                <!-- Date Boxes -->
                <div class="ml-6">
                    <div class="flex space-x-1">
                        <div class="border border-black w-6 h-6 flex items-center justify-center text-gray-800 font-semibold "></div>
                        <div class="border border-black w-6 h-6 flex items-center justify-center text-gray-800 font-semibold "></div>
                        <div class="border border-black w-6 h-6 flex items-center justify-center text-gray-800 font-semibold "></div>
                        <div class="border border-black w-6 h-6 flex items-center justify-center text-gray-800 font-semibold "></div>
                        <div class="border border-black w-6 h-6 flex items-center justify-center text-gray-800 font-semibold "></div>
                        <div class="border border-black w-6 h-6 flex items-center justify-center text-gray-800 font-semibold "></div>
                        <div class="border border-black w-6 h-6 flex items-center justify-center text-gray-800 font-semibold "></div>
                        <div class="border border-black w-6 h-6 flex items-center justify-center text-gray-800 font-semibold "></div>
                    </div>
                    <!-- Labels for MM/DD/YYYY -->
                    <div class="flex space-x-1 text-[10px] uppercase text-center">
                        <span class="w-6">M</span>
                        <span class="w-6">M</span>
                        <span class="w-6">D</span>
                        <span class="w-6">D</span>
                        <span class="w-6">Y</span>
                        <span class="w-6">Y</span>
                        <span class="w-6">Y</span>
                        <span class="w-6">Y</span>
                    </div>
                </div>
            </div>

            <!-- Reference Number Section -->
            <div class="">
                <p class="text-xs font-semibold italic mb-1">Reference Number:</p>
                <div class="flex items-end space-x-2">
                    <!-- Region -->
                    <div class="flex flex-col">
                        <div class="flex border border-black">
                            <div class="w-6 h-6 flex items-center justify-center text-gray-800 font-semibold border-r border-black">1</div>
                            <div class="w-6 h-6 flex items-center justify-center text-gray-800 font-semibold">9</div>
                        </div>
                        <span class="text-[10px] uppercase text-center mt-1">Region</span>
                    </div>
                    <!-- Province -->
                    <div class="flex flex-col">
                        <div class="flex border border-black">
                            <div class="w-6 h-6 flex items-center justify-center text-gray-800 font-semibold border-r border-black">3</div>
                            <div class="w-6 h-6 flex items-center justify-center text-gray-800 font-semibold">1</div>
                        </div>
                        <span class="text-[10px] uppercase text-center mt-1">Province</span>
                    </div>
                    <!-- City/Municipality -->
                    <div class="flex flex-col">
                        <div class="flex border border-black">
                            <div class="w-6 h-6 flex items-center justify-center text-gray-800 font-semibold border-r border-black">3</div>
                            <div class="w-6 h-6 flex items-center justify-center text-gray-800 font-semibold">1</div>
                        </div>
                        <span class="text-[10px] uppercase text-center mt-1">City/Muni</span>
                    </div>
                    <!-- Barangay -->
                    <div class="flex flex-col">
                        <div class="flex border border-black">
                            <div class="w-6 h-6 flex items-center justify-center text-gray-800 font-semibold border-r border-black">1</div>
                            <div class="w-6 h-6 flex items-center justify-center text-gray-800 font-semibold border-r border-black">3</div>
                            
                            <div class="w-6 h-6 flex items-center justify-center text-gray-800 font-semibold">1</div>
                        </div>
                        <span class="text-[10px] uppercase text-center mt-1">Barangay</span>
                    </div>
                    <div class="flex flex-col ">
                        <div class="flex border border-black">
                            <div class="w-6 h-6 flex items-center justify-center text-gray-800 font-semibold border-r border-black">2</div>
                            <div class="w-6 h-6 flex items-center justify-center text-gray-800 font-semibold border-r border-black">3</div>
                            <div class="w-6 h-6 flex items-center justify-center text-gray-800 font-semibold border-r border-black">4</div>
                            <div class="w-6 h-6 flex items-center justify-center text-gray-800 font-semibold border-r border-black">2</div>                            
                            <div class="w-6 h-6 flex items-center justify-center text-gray-800 font-semibold">1</div>
                        </div>
                        <span class="text-[10px] uppercase text-center mt-1 invisible">""</span>

                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side: 2x2 Picture Box -->
        <div class="w-1/4 text-center">
            <p class="text-xs font-bold uppercase">Revised Version: 03-2021</p>
            
            <!-- 2x2 Picture Box -->
            <div class="border-2 border-black w-[192px] h-[192px] flex flex-col items-center justify-center mx-auto mt-2">
                <p class="text-sm font-bold uppercase">2x2 Picture</p>
                <p class="text-xs">Photo Taken Within 6 Months</p>
            </div>
        </div>
    </div>
</div>
