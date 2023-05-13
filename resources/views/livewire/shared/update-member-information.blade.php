<div class="my-10">
    <div class="space-y-8">
        <h1 class="text-xl font-bold text-primary-500">Update Member Information</h1>
        <div>
            {{ $this->form }}
            <div class="flex justify-end mt-8 gap-2">
                <x-filament::button href="{{ $this->getProfileRoute() }}" outlined color="success" tag="a">Back to Member's Profile</x-filament::button>
                <x-filament::button wire:click="save" wire:target="save">Save</x-filament::button>
            </div>
        </div>
    </div>
</div>
