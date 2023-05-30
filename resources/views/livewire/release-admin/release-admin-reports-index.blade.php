<div class="pb-8">
    <div class="mt-10">
        <h1 class="text-xl font-bold text-custom-blue">Reports</h1>
    </div>
    <div class="p-4 mt-4 bg-white shadow">
        <div>
            <label for="release">
                <h1 class="font-bold text-primary-600">Release</h1>
                <select class="text-xs rounded" wire:model="release_id">
                    @forelse ($releases as $release)
                        <option value="{{ $release->id }}">{{ $release->name }}</option>
                    @empty
                        <option disabled selected hidden>No releases found</option>
                    @endforelse
                </select>
            </label>
        </div>
        <div class="grid grid-cols-3 gap-4 mt-4">
            <div class="p-4 border-2 rounded-lg">
                <h2 class="text-2xl font-bold text-custom-blue">{{ $selected_release->released_dividends_count }}</h2>
                <h3 class="font-bold text-custom-blue">
                    Total Released Dividends
                </h3>
                <a class="flex justify-end text-sm font-bold text-green-600 underline" href="{{ route('download-report.releases-by-status', [
                    'release' => $release_id,
                    'status' => 4,
                ]) }}" target="_blank">Download</a>
            </div>
            <div class="p-4 border-2 rounded-lg">
                <h2 class="text-2xl font-bold text-custom-blue">{{ $selected_release->unclaimed_dividends_count }}</h2>
                <h3 class="font-bold text-custom-blue">
                    Unclaimed Dividends
                </h3>
                <a class="flex justify-end text-sm font-bold text-green-600 underline" href="{{ route('download-report.releases-by-status', [
                    'release' => $release_id,
                    'status' => 2,
                ]) }}" target="_blank">Download</a>
            </div>
            <div class="p-4 border-2 rounded-lg">
                <h2 class="text-2xl font-bold text-custom-blue">{{ $selected_release->onhold_dividends_count }}</h2>
                <h3 class="font-bold text-custom-blue">
                    On-Hold Dividends
                </h3>
                <a class="flex justify-end text-sm font-bold text-green-600 underline" href="{{ route('download-report.releases-by-status', [
                    'release' => $release_id,
                    'status' => 3,
                ]) }}" target="_blank">Download</a>
            </div>
            <div class="p-4 border-2 rounded-lg">
                <h2 class="text-2xl font-bold text-custom-blue">{{ $selected_release->member_claimed_dividends_count }}</h2>
                <h3 class="font-bold text-custom-blue">
                    Claimed by Members
                </h3>
                <a class="flex justify-end text-sm font-bold text-green-600 underline" href="{{ route('download-report.claimed-releases-by-type', [
                    'release' => $release_id,
                    'claim_type' => 1,
                ]) }}" target="_blank">Download</a>
            </div>
            <div class="p-4 border-2 rounded-lg">
                <h2 class="text-2xl font-bold text-custom-blue">{{ $selected_release->spa_claimed_dividends_count }}</h2>
                <h3 class="font-bold text-custom-blue">
                    Claimed by SPA
                </h3>
                <a class="flex justify-end text-sm font-bold text-green-600 underline" href="{{ route('download-report.claimed-releases-by-type', [
                    'release' => $release_id,
                    'claim_type' => 2,
                ]) }}" target="_blank">Download</a>
            </div>
            <div class="p-4 border-2 rounded-lg">
                <h2 class="text-2xl font-bold text-custom-blue">{{ $selected_release->representative_claimed_dividends_count }}</h2>
                <h3 class="font-bold text-custom-blue">
                    Claimed by Authorized Representative
                </h3>
                <a class="flex justify-end text-sm font-bold text-green-600 underline" href="{{ route('download-report.claimed-releases-by-type', [
                    'release' => $release_id,
                    'claim_type' => 3,
                ]) }}" target="_blank">Download</a>
            </div>
            <div class="p-4 border-2 rounded-lg">
                <h2 class="text-2xl font-bold text-custom-blue">{{ $selected_release->voided_dividends_count }}</h2>
                <h3 class="font-bold text-custom-blue">
                    Total Voided Dividends
                </h3>
                <a class="flex justify-end text-sm font-bold text-green-600 underline" href="{{ route('download-report.voided-releases', [
                    'release' => $release_id,
                ]) }}" target="_blank">Download</a>
            </div>
        </div>
        <hr class="my-4">
        <h3 class="text-lg font-bold text-custom-blue">Per Counter Releases</h3>
        <table class="w-full mt-4">
            <thead>
                <tr>
                    <th class="text-left">Cashier</th>
                    <th>Releases</th>
                    <th></th>
                    <th>Voided Releases</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cashiers as $cashier)
                    <tr>
                        <td>{{ $cashier->full_name }}</td>
                        <td class="text-center">{{ $cashier->releases_count }}</td>
                        <td>
                            <a class="text-xs font-bold text-green-600 underline" href="{{ route('download-report.releases-by-cashier', [
                                'cashier' => $cashier,
                                'release_id' => $release_id,
                            ]) }}" target="_blank">Download</a>
                        </td>
                        <td class="text-center">{{ $cashier->voided_count }}</td>
                        <td><a class="text-xs font-bold text-green-600 underline" href="{{ route('download-report.voided-releases-by-cashier', [
                            'cashier' => $cashier,
                            'release_id' => $release_id,
                        ]) }}" target="_blank">Download</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
