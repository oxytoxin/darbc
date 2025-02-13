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
                        <div class="border border-black w-6 h-6 flex items-center justify-center text-gray-800 font-semibold ">0</div>
                        <div class="border border-black w-6 h-6 flex items-center justify-center text-gray-800 font-semibold ">1</div>
                        <div class="border border-black w-6 h-6 flex items-center justify-center text-gray-800 font-semibold ">2</div>
                        <div class="border border-black w-6 h-6 flex items-center justify-center text-gray-800 font-semibold ">1</div>
                        <div class="border border-black w-6 h-6 flex items-center justify-center text-gray-800 font-semibold ">1</div>
                        <div class="border border-black w-6 h-6 flex items-center justify-center text-gray-800 font-semibold ">1</div>
                        <div class="border border-black w-6 h-6 flex items-center justify-center text-gray-800 font-semibold ">1</div>
                        <div class="border border-black w-6 h-6 flex items-center justify-center text-gray-800 font-semibold ">1</div>
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

    <div class="border-2 border-black">
        <!-- Section Header -->
        <div class="bg-black text-white text-xs font-bold p-1">
            PART I: PERSONAL INFORMATION
        </div>
    
        <!-- Personal Information Fields -->
        <div class="grid grid-cols-2  gap-x-4">
            <!-- Surname -->
            <div class="relative">
                <p class="text-center text-xs italic py-2">Dela Cruz</p>
                <div class="text-center text-xs font-bold uppercase border-t border-black py-1">Surname</div>
            </div>
    
            <!-- First Name -->
            <div class="relative">
                <p class="text-center text-xs italic py-2">Juan</p>
                <div class="text-center text-xs font-bold uppercase border-t border-black py-1">First Name</div>
            </div>
        </div>
    
        <div class="grid grid-cols-2  gap-x-4">
            <!-- Middle Name -->
            <div class="relative">
                <p class="text-center text-xs italic py-2">Santos</p>
                <div class="text-center text-xs font-bold uppercase border-t border-black py-1">Middle Name</div>
            </div>
    
            <!-- Extension Name & Sex -->
            <div class="grid grid-cols-2">
                <!-- Extension Name -->
                <div class="relative border-r border-black">
                    <p class="text-center text-xs italic py-2">Jr.</p>
                    <div class="text-center text-xs font-bold uppercase border-t border-black py-1">Extension Name</div>
                </div>
    
                <!-- Sex (Male/Female) -->
                <div class="flex items-center justify-center px-2 space-x-2 border-t border-black">
                    <div class="text-xs font-bold uppercase">Sex:</div>
                    <div class="flex items-center space-x-1">
                        <div class="border border-black w-4 h-4 flex items-center justify-center">
                            <!-- Checkmark for Male -->
                            &#10003;
                        </div>
                        <span class="text-xs">Male</span>
                    </div>
                    <div class="flex items-center space-x-1">
                        <div class="border border-black w-4 h-4"></div>
                        <span class="text-xs">Female</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="border-2 border-black">
        <!-- Address Header (without full border) -->
        <div class="flex">
            <div class="text-xs font-bold uppercase p-1 w-32 border-r-2 border-black">Address</div>
            <div class="flex-1"></div>
        </div>
    
        <!-- First Row (House Lot, Street, Barangay) -->
        <div class="grid grid-cols-3 border-t border-black">
            <div class="border-r border-black flex flex-col">
                <div class="h-8"></div>
                <span class="text-[10px] uppercase font-bold text-center border-t border-black">House/Lot/Bldg. No./Purok</span>
            </div>
            <div class="border-r border-black flex flex-col">
                <div class="h-8"></div>
                <span class="text-[10px] uppercase font-bold text-center border-t border-black">Street/Sitio/Subdv.</span>
            </div>
            <div class="flex flex-col">
                <div class="h-8"></div>
                <span class="text-[10px] uppercase font-bold text-center border-t border-black">Barangay</span>
            </div>
        </div>
    
        <!-- Second Row (Municipality, Province) -->
        <div class="grid grid-cols-2 border-t border-black">
            <div class="border-r border-black flex flex-col">
                <div class="h-8"></div>
                <span class="text-[10px] uppercase font-bold text-center border-t border-black">Municipality/City</span>
            </div>
            <div class="flex flex-col">
                <div class="h-8"></div>
                <span class="text-[10px] uppercase font-bold text-center border-t border-black">Province</span>
            </div>
        </div>
    
        <!-- Third Row (Region - Full Width) -->
        <div class="flex flex-col border-t border-black">
            <div class="h-8"></div>
            <span class="text-[10px] uppercase font-bold text-center border-t border-black">Region</span>
        </div>
    </div>
    
    
    
    
    
</div>
