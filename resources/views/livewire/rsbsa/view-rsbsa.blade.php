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
                        <div class="border border-black w-6 h-6 text-center text-xs italic flex items-center justify-center  ">0</div>
                        <div class="border border-black w-6 h-6 text-center text-xs italic flex items-center justify-center  ">1</div>
                        <div class="border border-black w-6 h-6 text-center text-xs italic flex items-center justify-center  ">2</div>
                        <div class="border border-black w-6 h-6 text-center text-xs italic flex items-center justify-center  ">1</div>
                        <div class="border border-black w-6 h-6 text-center text-xs italic flex items-center justify-center  ">1</div>
                        <div class="border border-black w-6 h-6 text-center text-xs italic flex items-center justify-center  ">1</div>
                        <div class="border border-black w-6 h-6 text-center text-xs italic flex items-center justify-center  ">1</div>
                        <div class="border border-black w-6 h-6 text-center text-xs italic flex items-center justify-center  ">1</div>
                    </div>
                    <!-- Labels for MM/DD/YYYY -->
                    <div class="flex space-x-1  uppercase text-center">
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
                        <span class=" uppercase text-center mt-1">Region</span>
                    </div>
                    <!-- Province -->
                    <div class="flex flex-col">
                        <div class="flex border border-black">
                            <div class="w-6 h-6 flex items-center justify-center text-gray-800 font-semibold border-r border-black">3</div>
                            <div class="w-6 h-6 flex items-center justify-center text-gray-800 font-semibold">1</div>
                        </div>
                        <span class=" uppercase text-center mt-1">Province</span>
                    </div>
                    <!-- City/Municipality -->
                    <div class="flex flex-col">
                        <div class="flex border border-black">
                            <div class="w-6 h-6 flex items-center justify-center text-gray-800 font-semibold border-r border-black">3</div>
                            <div class="w-6 h-6 flex items-center justify-center text-gray-800 font-semibold">1</div>
                        </div>
                        <span class=" uppercase text-center mt-1">City/Muni</span>
                    </div>
                    <!-- Barangay -->
                    <div class="flex flex-col">
                        <div class="flex border border-black">
                            <div class="w-6 h-6 flex items-center justify-center text-gray-800 font-semibold border-r border-black">1</div>
                            <div class="w-6 h-6 flex items-center justify-center text-gray-800 font-semibold border-r border-black">3</div>
                            
                            <div class="w-6 h-6 flex items-center justify-center text-gray-800 font-semibold">1</div>
                        </div>
                        <span class=" uppercase text-center mt-1">Barangay</span>
                    </div>
                    <div class="flex flex-col ">
                        <div class="flex border border-black">
                            <div class="w-6 h-6 flex items-center justify-center text-gray-800 font-semibold border-r border-black">2</div>
                            <div class="w-6 h-6 flex items-center justify-center text-gray-800 font-semibold border-r border-black">3</div>
                            <div class="w-6 h-6 flex items-center justify-center text-gray-800 font-semibold border-r border-black">4</div>
                            <div class="w-6 h-6 flex items-center justify-center text-gray-800 font-semibold border-r border-black">2</div>                            
                            <div class="w-6 h-6 flex items-center justify-center text-gray-800 font-semibold">1</div>
                        </div>
                        <span class=" uppercase text-center mt-1 invisible">""</span>

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
    
        <!-- Name Fields -->
        <div class="grid grid-cols-2 border-b border-black">
            <div class="border-r border-black p-2">
                <p class="text-center text-xs italic">Dela Cruz</p>
                <div class="text-center text-xs font-bold uppercase border-t border-black py-1">Surname</div>
            </div>
            <div class="p-2">
                <p class="text-center text-xs italic">Juan</p>
                <div class="text-center text-xs font-bold uppercase border-t border-black py-1">First Name</div>
            </div>
        </div>
    
        <div class="grid grid-cols-2 border-b border-black">
            <div class="border-r border-black p-2">
                <p class="text-center text-xs italic">Santos</p>
                <div class="text-center text-xs font-bold uppercase border-t border-black py-1">Middle Name</div>
            </div>
            <div class="grid grid-cols-2">
                <div class="p-2">
                    <p class="text-center text-xs italic">Jr.</p>
                    <div class="text-center text-xs font-bold uppercase border-t border-black py-1">Extension Name</div>
                </div>
                <div class="inline-flex items-center justify-center border-l border-black p-2">
                    <div class="text-xs font-bold uppercase">Sex:</div>
                    <div class="flex items-center space-x-2 ml-2">
                        <div class="border border-black w-4 h-4 flex items-center justify-center">&#10003;</div>
                        <span class="text-xs">Male</span>
                    </div>
                    <div class="flex items-center space-x-2 ml-4">
                        <div class="border border-black w-4 h-4"></div>
                        <span class="text-xs">Female</span>
                    </div>
                </div>
            </div>
        </div>
    
        <!-- Address -->
        <div class="border-b border-black">
            <div class="flex">
                <div class="text-xs font-bold uppercase p-2 w-32 border-r border-black">Address</div>
                <div class="flex-1"></div>
            </div>
            <div class="grid grid-cols-3 gap-4 px-2 pb-2">
                <div class="flex flex-col">
                    <div class="border border-black h-8 text-center text-xs italic p-1">Purok Tagumpay 1</div>
                    <span class="text-[10px] uppercase font-bold text-center">House/Lot/Bldg. No./Purok</span>
                </div>
                <div class="flex flex-col">
                    <div class="border border-black h-8 text-center text-xs italic p-1">78 Salem</div>
                    <span class="text-[10px] uppercase font-bold text-center">Street/Sitio/Subdv.</span>
                </div>
                <div class="flex flex-col">
                    <div class="border border-black h-8 text-center text-xs italic p-1">Kalawahg 2</div>
                    <span class="text-[10px] uppercase font-bold text-center">Barangay</span>
                </div>
                <div class="flex flex-col">
                    <div class="border border-black h-8 text-center text-xs italic p-1">Isulan</div>
                    <span class="text-[10px] uppercase font-bold text-center">Municipality/City</span>
                </div>
                <div class="flex flex-col">
                    <div class="border border-black h-8 text-center text-xs italic p-1">Sultan Kudarat</div>
                    <span class="text-[10px] uppercase font-bold text-center">Province</span>
                </div>
                <div class="flex flex-col">
                    <div class="border border-black h-8 text-center text-xs italic p-1">Region 12</div>
                    <span class="text-[10px] uppercase font-bold text-center">Region</span>
                </div>
            </div>
        </div>
    
        <!-- Mobile & Landline -->
        <div class="grid grid-cols-2 border-b border-black">
            <div class="border-r border-black p-2">
                <p class="text-xs font-bold">Mobile Number:</p>
                <div class="flex space-x-1">
                    <div class="border border-black w-6 h-6 text-center text-xs italic flex items-center justify-center"></div>
                    <div class="border border-black w-6 h-6 text-center text-xs italic flex items-center justify-center"></div>
                    <div class="border border-black w-6 h-6 text-center text-xs italic flex items-center justify-center"></div>
                    <div class="border border-black w-6 h-6 text-center text-xs italic flex items-center justify-center"></div>
                    <div class="border border-black w-6 h-6 text-center text-xs italic flex items-center justify-center"></div>
                    <div class="border border-black w-6 h-6 text-center text-xs italic flex items-center justify-center"></div>
                    <div class="border border-black w-6 h-6 text-center text-xs italic flex items-center justify-center"></div>
                    <div class="border border-black w-6 h-6 text-center text-xs italic flex items-center justify-center"></div>
                </div>
            </div>
            <div class="p-2">
                <p class="text-xs font-bold">Landline Number:</p>
                <div class="flex space-x-1">
                    <div class="border border-black w-6 h-6 text-center text-xs italic flex items-center justify-center"></div>
                    <div class="border border-black w-6 h-6 text-center text-xs italic flex items-center justify-center"></div>
                    <div class="border border-black w-6 h-6 text-center text-xs italic flex items-center justify-center"></div>
                    <div class="border border-black w-6 h-6 text-center text-xs italic flex items-center justify-center"></div>
                    <div class="border border-black w-6 h-6 text-center text-xs italic flex items-center justify-center"></div>
                    <div class="border border-black w-6 h-6 text-center text-xs italic flex items-center justify-center"></div>
                    <div class="border border-black w-6 h-6 text-center text-xs italic flex items-center justify-center"></div>
                    <div class="border border-black w-6 h-6 text-center text-xs italic flex items-center justify-center"></div>
                </div>
            </div>
        </div>
    
        <!-- Date of Birth & Place of Birth -->
        <div class="grid grid-cols-2 border-b border-black">
            <div class="border-r border-black p-2">
                <p class="text-xs font-bold">Date of Birth:</p>
                <div class="flex space-x-1">
                    <div class="border border-black w-6 h-6 text-center text-xs italic flex items-center justify-center"></div>
                    <div class="border border-black w-6 h-6 text-center text-xs italic flex items-center justify-center"></div>
                    <div class="border border-black w-6 h-6 text-center text-xs italic flex items-center justify-center"></div>
                    <div class="border border-black w-6 h-6 text-center text-xs italic flex items-center justify-center"></div>
                    <div class="border border-black w-6 h-6 text-center text-xs italic flex items-center justify-center"></div>
                    <div class="border border-black w-6 h-6 text-center text-xs italic flex items-center justify-center"></div>
                    <div class="border border-black w-6 h-6 text-center text-xs italic flex items-center justify-center"></div>
                    <div class="border border-black w-6 h-6 text-center text-xs italic flex items-center justify-center"></div>
                </div>
            </div>
            <div class="p-2">
                <p class="text-xs font-bold">Place of Birth:</p>
                <div class="border border-black h-8 text-center text-xs italic p-1">Isulan</div>
            </div>
        </div>
    </div>
    
    
    
    
    <div class="border-2 border-black mt-4">
        <!-- Section Header -->
        <div class="bg-black text-white text-xs font-bold p-1 uppercase">
            Part II: Farm Profile
        </div>
    
        <!-- Main Livelihood -->
        <div class="grid grid-cols-4 text-xs font-bold border-b border-black p-2">
            <div class="flex items-center space-x-2">
                <div class="border border-black w-4 h-4"></div>
                <span>Farmer</span>
            </div>
            <div class="flex items-center space-x-2">
                <div class="border border-black w-4 h-4"></div>
                <span>Farmworker/Laborer</span>
            </div>
            <div class="flex items-center space-x-2">
                <div class="border border-black w-4 h-4"></div>
                <span>Fisherfolk</span>
            </div>
            <div class="flex items-center space-x-2">
                <div class="border border-black w-4 h-4"></div>
                <span>Agri Youth</span>
            </div>
        </div>
    
        <!-- Farm Profile Details -->
        <div class="grid grid-cols-4 border-b border-black text-xs">
            <!-- Farmers -->
            <div class="border-r border-black p-2">
                <p class="font-bold italic">For farmers:</p>
                <p class="font-bold">Type of Farming Activity</p>
                <div class="space-y-2">
                    <div class="flex items-center space-x-2">
                        <div class="border border-black w-4 h-4"></div>
                        <span>Rice</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="border border-black w-4 h-4"></div>
                        <span>Corn</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="border border-black w-4 h-4"></div>
                        <span>Other crops, please specify: ________</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="border border-black w-4 h-4"></div>
                        <span>Livestock, please specify: ________</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="border border-black w-4 h-4"></div>
                        <span>Poultry, please specify: ________</span>
                    </div>
                </div>
            </div>
    
            <!-- Farmworkers -->
            <div class="border-r border-black p-2">
                <p class="font-bold italic">For farmworkers:</p>
                <p class="font-bold">Kind of Work</p>
                <div class="space-y-2">
                    <div class="flex items-center space-x-2">
                        <div class="border border-black w-4 h-4"></div>
                        <span>Land Preparation</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="border border-black w-4 h-4"></div>
                        <span>Planting/Transplanting</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="border border-black w-4 h-4"></div>
                        <span>Cultivation</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="border border-black w-4 h-4"></div>
                        <span>Harvesting</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="border border-black w-4 h-4"></div>
                        <span>Others, please specify: ________</span>
                    </div>
                </div>
            </div>
    
            <!-- Fisherfolk -->
            <div class="border-r border-black p-2">
                <p class="font-bold italic">For fisherfolk:</p>
                <p class="text-xs italic">The Lending Conduit shall coordinate with BFAR...</p>
                <p class="font-bold">Type of Fishing Activity</p>
                <div class="space-y-2">
                    <div class="flex items-center space-x-2">
                        <div class="border border-black w-4 h-4"></div>
                        <span>Fish Capture</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="border border-black w-4 h-4"></div>
                        <span>Fish Processing</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="border border-black w-4 h-4"></div>
                        <span>Aquaculture</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="border border-black w-4 h-4"></div>
                        <span>Fish Vending</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="border border-black w-4 h-4"></div>
                        <span>Gleaning</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="border border-black w-4 h-4"></div>
                        <span>Others, please specify: ________</span>
                    </div>
                </div>
            </div>
    
            <!-- Agri Youth -->
            <div class="p-2">
                <p class="font-bold italic">For agri youth:</p>
                <p class="text-xs italic">For the purposes of training and financial assistance...</p>
                <p class="font-bold">Type of Involvement</p>
                <div class="space-y-2">
                    <div class="flex items-center space-x-2">
                        <div class="border border-black w-4 h-4"></div>
                        <span>Part of a farming household</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="border border-black w-4 h-4"></div>
                        <span>Attended formal agri-fishery course</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="border border-black w-4 h-4"></div>
                        <span>Attended non-formal agri-fishery course</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="border border-black w-4 h-4"></div>
                        <span>Participated in any agricultural program</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="border border-black w-4 h-4"></div>
                        <span>Others, please specify: ________</span>
                    </div>
                </div>
            </div>
        </div>
    
        <!-- Gross Annual Income -->
        <div class="border-t-2 border-black p-2 flex justify-between text-xs font-bold">
            <span>Gross Annual Income Last Year:</span>
            <span>Farming: ___________</span>
            <span>Non-farming: ___________</span>
        </div>
    </div>
    
    <div class="relative  border-black mt-4">
        <div class="absolute left-0 right-0 top-1/2 transform -translate-y-1/2 border-t border-dashed border-black w-full"></div>
        <div class="absolute right-0 top-1/2 transform -translate-y-1/2 text-black text-xl">✂</div>
    </div>
    
    
</div>
