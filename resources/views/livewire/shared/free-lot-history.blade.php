<div class="pb-8">
    <div class="mt-10">
        <h1 class="text-xl font-bold text-custom-blue">Free Lot History</h1>
    </div>
    <div class="p-4 mt-4 bg-white shadow">
        <div class="grid grid-cols-2 gap-2 mb-8 font-semibold">
            <p class="text-xl font-semibold text-primary-600">OWNER: {{ $free_lot->user->full_name }}</p>
            <p>Cluster: {{ $free_lot->cluster?->name }}</p>
            <p>{{ $free_lot->address }}</p>
            <p>Current Status: <span
                      class="{{ match ($free_lot->status) {
                          1 => 'bg-green-200 text-green-600 border-green-600 border-2',
                          2 => 'bg-yellow-100 text-yellow-600 border-yellow-600 border-2',
                          3 => 'bg-blue-200 text-blue-600 border-blue-600 border-2',
                          4 => 'bg-purple-200 text-purple-600 border-purple-600 border-2',
                          default => null,
                      } }} px-2 py-1 font-bold rounded-full">{{ $free_lot->status_label }}</span>
            </p>
        </div>
        <hr class="mb-8 border-2 border-primary-600">
        <div>
            <h3 class="font-bold text-primary-600 text-xl">SELLING HISTORY</h3>
            <div class="p-4">
                @forelse ($free_lot->selling_history ?? [] as $sell_event)
                    <div class="pl-4 border-l-4 border-amber-600">
                        <div class="p-4 rounded border-primary-600 border-2">
                            <p class="font-bold text-primary-600">Date: {{ $sell_event['date'] ?? 'Unknown' }}</p>
                            <p class="font-bold text-primary-600">Buyer: {{ $sell_event['buyer'] ?? 'Unknown' }}</p>
                        </div>
                    </div>
                @empty
                    <p>Free lot was not sold.</p>
                @endforelse
            </div>
        </div>
        <div>
            <h3 class="font-bold text-primary-600 text-xl">RELOCATION HISTORY</h3>
            <div class="p-4">
                @forelse ($free_lot->relocation_history ?? [] as $relocation_event)
                    <div class="pl-4 border-l-4 border-amber-600">
                        <p class="font-bold text-primary-600">Date: {{ $relocation_event['date'] ?? 'Unknown' }}</p>
                        <div class="p-4 mt-4 rounded border-primary-600 border-2">
                            <p class="font-bold text-primary-600">Previous Lot Details</p>
                            <div class="p-4">
                                <p>Block {{ $relocation_event['origin']['block'] ?? 'UNKNOWN' }}, Lot {{ $relocation_event['origin']['lot'] ?? 'UNKNOWN' }},
                                    {{ $relocation_event['origin']['area'] ?? 'UNKNOWN' }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <p>Free lot was not relocated.</p>
                @endforelse
            </div>
        </div>
        <div>
            <h3 class="font-bold text-primary-600 text-xl">SWAPPING HISTORY</h3>
            <div class="p-4 space-y-4">
                @forelse ($free_lot->swapping_history ?? [] as $swapping_event)
                    <div class="pl-4 border-l-4 border-amber-600">
                        <p class="font-bold text-primary-600">Date: {{ $swapping_event['date'] ?? 'Unknown' }}</p>
                        <div class="flex gap-4 mt-4">
                            <div class="p-4 rounded flex-1 border-primary-600 border-2">
                                <p class="font-bold text-primary-600">Target Lot Details</p>
                                <div class="p-4">
                                    <p>Block {{ $swapping_event['target']['block'] ?? 'UNKNOWN' }}, Lot {{ $swapping_event['target']['lot'] ?? 'UNKNOWN' }},
                                        {{ $swapping_event['target']['area'] ?? 'UNKNOWN' }}</p>
                                    <p>Target Lot Owner: {{ $swapping_event['target']['owner'] }}</p>
                                </div>
                            </div>
                            <div class="p-4 rounded flex-1 border-primary-600 border-2">
                                <p class="font-bold text-primary-600">Original Lot Details</p>
                                <div class="p-4">
                                    <p>Block {{ $swapping_event['origin']['block'] ?? 'UNKNOWN' }}, Lot {{ $swapping_event['origin']['lot'] ?? 'UNKNOWN' }},
                                        {{ $swapping_event['origin']['area'] ?? 'UNKNOWN' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p>Free lot was not swapped.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
