<div>
    <table class="w-full border border-collapse border-black">
        <thead>
            <tr>
                <th class="text-left border border-black p-2 text-sm">DARBC ID</th>
                <th class="text-left border border-black p-2 text-sm">Member Name</th>
                <th class="border border-black p-2 text-sm">Amount</th>
                <th class="border border-black p-2 text-sm">Date Awarded</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($incentives as $incentive)
                <tr>
                    <td class="p-2 border border-black text-sm">{{ $incentive->user->member_information->darbc_id }}</td>
                    <td class="p-2 border border-black text-sm">{{ $incentive->user->full_name }}</td>
                    <td class="p-2 border border-black text-center text-sm">{{ Akaunting\Money\Money::php($incentive->amount, true) }}</td>
                    <td class="p-2 border border-black text-center text-sm">{{ $incentive->created_at->format('F d, Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="p-2 text-sm text-center">No incentives awarded.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
