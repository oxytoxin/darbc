<div class="simple-card">
    <x-member-details :member="$member" />
    <div class="flex gap-4 items-center">
        <x-filament::button href="{{ $this->getEditRoute($member->id) }}" tag="a" icon="heroicon-o-pencil" color="success" outlined size="sm">Edit this Member</x-filament::button>
        <div x-data="{ show: false }">
            <x-filament::button x-show="!show" @click="show=true" outlined>Edit Share Percentage</x-filament::button>
            <div class="flex items-center gap-2" x-cloak x-show="show">
                <input class="border border-black p-1 rounded-lg" type="number" wire:model.defer="percentage">
                <div class="gap-1">
                    <x-filament::button @click="$wire.save();show=false;" color="success">Save</x-filament::button>
                    <x-filament::button @click="show=false" color="danger">Cancel</x-filament::button>
                </div>
            </div>
        </div>
        <x-filament::button tag="a" href="{{ route('member-form-print', ['member' => $member]) }}" icon="heroicon-o-printer">Print Member Form</x-filament::button>
    </div>
    <div class="my-4 p-4 border-2 rounded-lg">
        <h3 class="font-semibold">Documents</h3>
        <div class="flex gap-4">
            <ul class="p-4 gap-4 flex flex-col flex-1">
                @forelse ($member->getMedia('documents') as $document)
                    <li class="flex gap-2 items-center">
                        <p class="italic">{{ $document->file_name }}</p>
                        <x-filament::button wire:click="deleteDocument({{ $document->id }})" onclick="confirm('Are you sure?') || event.stopImmediatePropagation()" icon="heroicon-o-trash" color="danger" outlined size="sm">Delete</x-filament::button>
                        <x-filament::button href="{{ $document->getUrl() }}" tag="a" target="blank" icon="heroicon-o-download" color="success" outlined size="sm">Download</x-filament::button>
                    </li>
                @empty
                    <p>No documents uploaded.</p>
                @endforelse
            </ul>
            <div class="flex-1">
                {{ $this->form }}
                <div class="flex justify-end mt-4">
                    <x-filament::button wire:click="saveDocuments" onclick="confirm('Are you sure?') || event.stopImmediatePropagation()" icon="heroicon-o-upload" color="success" outlined size="sm">Upload</x-filament::button>
                </div>
            </div>
        </div>
    </div>
    <div class="flex mt-4">
        <div class="w-1/3">
            <p class="font-semibold">Account Ownership</p>
            <div>
                @foreach ($lineage_members as $lineage_member)
                    <div class="flex items-center gap-2 @if (!$loop->first) px-8 @endif">
                        @if (!$loop->first)
                            <svg width="16" height="16" viewBox="0 0 5 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.0702 3.72808L0.0385742 1.78091L1.05403 0.806641L4.1011 3.72808L1.05403 6.64952L0.0385742 5.67525L2.0702 3.72808Z" fill="#EF9A47" />
                            </svg>
                        @endif
                        <div>
                            <p class="flex items-center gap-2">
                                <a href="{{ route($route_name, ['member' => $lineage_member]) }}">{{ $lineage_member->user->full_name }}</a>
                                <a class="text-xs font-bold text-green-700 underline" href="{{ $this->getEditRoute($lineage_member->id) }}">EDIT</a>
                            </p>
                            <h5 class="text-xs font-semibold text-gray-400">
                                {{ $lineage_member->succession_number == '0' ? 'Original Owner' : ordinal($lineage_member->succession_number) . ' Successor' }}
                                @if ($lineage_member->id == $member->id)
                                    <span class="text-green-600">(Current)</span>
                                @endif
                            </h5>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div>
        @livewire('shared.member-restrictions-management', ['member' => $member], key('member-restrictions-' . $member->id))
    </div>
</div>
