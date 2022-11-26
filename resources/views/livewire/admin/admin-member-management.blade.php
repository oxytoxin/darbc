<div>
    <div class="mt-10">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-primary-500">Members List</h1>
            <div class="flex items-center justify-end">
                <section class="flex items-center space-x-2">
                    <x-minor.button buttonContent="Export to Excel" class="bg-custom-green/[8%] text-custom-green">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                            <path class="fill-current"
                                d="M2.859 2.877l12.57-1.795a.5.5 0 0 1 .571.495v20.846a.5.5 0 0 1-.57.495L2.858 21.123a1 1 0 0 1-.859-.99V3.867a1 1 0 0 1 .859-.99zM4 4.735v14.53l10 1.429V3.306L4 4.735zM17 19h3V5h-3V3h4a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1h-4v-2zm-6.8-7l2.8 4h-2.4L9 13.714 7.4 16H5l2.8-4L5 8h2.4L9 10.286 10.6 8H13l-2.8 4z" />
                        </svg>
                    </x-minor.button>
                    <x-minor.button href="{{ route('administrator.register-members') }}" buttonContent="Add member" class="text-white bg-custom-blue">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="23" height="23">
                            <path class="text-white fill-current" d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z" />
                        </svg>
                    </x-minor.button>
                </section>
            </div>
        </div>
        <div class="flex flex-col mt-4">
            {{ $this->table }}
        </div>
    </div>
</div>
</div>
