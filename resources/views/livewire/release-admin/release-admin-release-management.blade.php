<div>
    <div class="mt-10">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-primary-500">Release Management</h1>
            <x-modal>
                <x-slot name="button">
                    <button @click="show = true" class="flex items-center px-3 py-2 space-x-2 text-white rounded bg-primary-500">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                            <path class="text-white fill-current" d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z" />
                        </svg>
                        <span>New Release</span>
                    </button>
                </x-slot>
                <form wire:submit.prevent="createRelease">
                    {{ $this->form }}
                    <div class="flex justify-end mt-4">
                        <x-forms::button type="submit">Save</x-forms::button>
                    </div>
                </form>
            </x-modal>
        </div>
        <div class="flex flex-col mt-3">
            <div class="overflow-x-auto">
                {{ $this->table }}
            </div>
        </div>
    </div>

</div>
