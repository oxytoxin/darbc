<div class="my-10">
    <div class="space-y-8">
        <h1 class="text-xl font-bold text-primary-500">Member Claims</h1>
        <x-member-details :member="$member" />
        <div class="flex justify-end gap-2">
            <div class="py-2 px-4 border-2 border-slate-700 rounded-lg">
                <h4 class="text-lg text-gray-600 font-semibold text-right">Amount to be Released</h4>
                <h5 class="text-2xl font-semibold text-green-600 text-right">
                    {{ Akaunting\Money\Money::PHP($dividends_amount_to_claim, true) }}
                </h5>
            </div>
            <button wire:click="export" class="py-2 px-4 border-2 hover:bg-green-400 bg-green-200 border-slate-700 rounded-lg">
                <h4 class="text-lg text-gray-900 font-semibold text-right">Export</h4>
            </button>
        </div>
        <div class="flex-1">
            <table class="table w-full border border-collapse table-auto">
                <thead class="text-left text-white bg-primary-500">
                    <tr>
                        <th></th>
                        <th class="px-2">Release Name</th>
                        <th class="px-2">Amount</th>
                        <th class="px-2">Date of Release</th>
                        <th class="px-2">Status</th>
                    </tr>
                <tbody>
                    @php
                        $isCashier = auth()
                            ->user()
                            ->isCashier();
                    @endphp
                    @forelse ($dividends_by_year as $year => $dividends)
                        @foreach ($dividends as $dividend)
                            <tr>
                                @if ($loop->first)
                                    <td class="
                                    @if ($loop->parent->odd) bg-[#E3E3E3]
                                    @else
                            bg-[#EF9A47] @endif py-4" rowspan="{{ count($dividends) }}">
                                        <p class="text-center -rotate-90">{{ $year }}</p>
                                    </td>
                                @endif
                                <td class="px-2 py-2 border-b">{{ $dividend->release->name }}</td>
                                <td class="px-2 py-2 border-b">{{ Akaunting\Money\Money::PHP($dividend->net_amount, true) }}
                                </td>
                                <td class="px-2 py-2 border-b">{{ $dividend->released_at?->format('F d, Y') }}</td>
                                <td class="px-2 py-2 border-b">
                                    <a class="px-2 py-1 text-xs font-semibold rounded-full {{ match ($dividend->status) {
                                        App\Models\Dividend::PENDING => 'bg-yellow-200 text-yellow-800',
                                        App\Models\Dividend::FOR_RELEASE => 'bg-success-200 text-success-800 underline',
                                        App\Models\Dividend::ON_HOLD => 'bg-red-200 text-red-800',
                                        App\Models\Dividend::RELEASED => 'bg-gray-200 text-gray-800',
                                    } }}"
                                       href="{{ $dividend->status == App\Models\Dividend::FOR_RELEASE && $isCashier ? route('cashier.dividends.manage', ['dividend' => $dividend]) : ' #' }}">{{ match ($dividend->status) {
                                           App\Models\Dividend::PENDING => 'Pending',
                                           App\Models\Dividend::FOR_RELEASE => 'For Release',
                                           App\Models\Dividend::ON_HOLD => 'On Hold',
                                           App\Models\Dividend::RELEASED => 'Released',
                                       } }}
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @empty
                        <tr>
                            <td class="py-4 text-sm text-center" colspan="5">No dividends found for this user.</td>
                        </tr>
                    @endforelse
                </tbody>
                </thead>
            </table>
        </div>
    </div>

</div>
