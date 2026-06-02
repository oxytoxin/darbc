<div class="mt-10">
    @php
        $u = $rsbsa->memberInformation?->user;
        $fullName = trim(
            ($rsbsa->surname ?: $u?->surname) . ', ' .
            ($rsbsa->first_name ?: $u?->first_name) . ' ' .
            ($rsbsa->middle_name ?: $u?->middle_name)
        );
        $fullName = trim($fullName, ', ');
    @endphp
    <div class="flex flex-col gap-2 mb-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-xl font-bold text-primary-500">View RSBSA</h1>
            <p class="text-sm font-medium text-gray-600">
                {{ $fullName ?: 'Unnamed record' }}@if($rsbsa->darbc_id) &middot; DARBC ID {{ $rsbsa->darbc_id }}@endif
            </p>
        </div>

        <div class="flex items-center gap-2">
            {{-- Edit Layout: redirects to the visual tuner, which renders with this
                 record's actual values so alignment can be corrected as needed. --}}
            <a href="{{ route('rsbsa.pdf.tuner', $rsbsa) }}"
               target="_blank"
               rel="noopener"
               class="inline-flex items-center gap-1 px-3 py-2 text-sm font-semibold text-white rounded bg-primary-500 hover:bg-primary-600">
                <x-heroicon-o-adjustments class="w-4 h-4" />
                Edit Layout
            </a>

            <a href="{{ route('rsbsa.pdf.download', $rsbsa) }}"
               class="inline-flex items-center gap-1 px-3 py-2 text-sm font-semibold border rounded border-primary-500 text-primary-600 hover:bg-primary-50">
                <x-heroicon-o-download class="w-4 h-4" />
                Download
            </a>
        </div>
    </div>

    {{-- PDF renderer: the overlay PDF embedded in-page (not the raw stream). --}}
    <div class="w-full overflow-hidden border rounded bg-gray-100" style="height: 85vh;">
        <iframe src="{{ route('rsbsa.pdf', $rsbsa) }}"
                class="w-full h-full"
                frameborder="0"
                title="RSBSA PDF"></iframe>
    </div>
</div>
