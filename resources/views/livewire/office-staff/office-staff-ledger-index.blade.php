<div>
    <div class="mt-10">
        <h1 class="text-xl font-bold text-custom-blue">Ledger</h1>
        <div class="flex items-center gap-5 mt-10">
            <h5 class="italic font-bold">Legend: </h5>
            <div class="flex items-center space-x-5 text-sm font-semibold">
                <div class="flex items-center space-x-1">
                    <div class='w-2.5 h-2.5 bg-gray-500 rounded-full'></div>
                    <span class="text-gray-500">Released</span>
                </div>
                <div class="flex items-center space-x-1">
                    <div class='w-2.5 h-2.5 bg-green-500 rounded-full'></div>
                    <span class="text-green-500">For Release</span>
                </div>
                <div class="flex items-center space-x-1">
                    <div class='w-2.5 h-2.5 bg-red-500 rounded-full'></div>
                    <span class="text-red-500">On Hold</span>
                </div>
                <div class="flex items-center space-x-1">
                    <div class='w-2.5 h-2.5 bg-custom-orange rounded-full'></div>
                    <span class="text-custom-orange">Pending</span>
                </div>
            </div>
        </div>
        <div class="mt-4">
            {{ $this->table }}
        </div>
    </div>
</div>
