<div class="flex gap-4">

    @foreach (["MEMBER'S COPY", 'DARBC COPY'] as $title)
        <div class="border border-black p-4 flex-1">
            <div class="text-center">
                <p>Dolefil Agrarian Reform</p>
                <p>Beneficiaries Cooperative</p>
                <p>(DARBC)</p>
                <br>
                <strong>DIVIDEND PAYSLIP</strong>
            </div>
            <br>
            <p>{{ $title }}</p>
            <p>Member ID: {{ $payslip_entry->darbc_id }}</p>
            <p>Name: {{ $payslip_entry->member_name }}</p>
            <p>Date : {{ now()->format('m/d/Y') }}</p>
            <p>Time : {{ now()->format('h:i A') }}</p>
            <br>
            <p>Release: {{ $payslip_entry->payslip->release->name }}</p>
            @foreach ($payslip_entry->content['items'] as $data)
                <br>
                <strong>{{ $data['title'] }}</strong>
                @foreach ($data['entries'] as $item)
                    <p>{{ $item['title'] . ': ' . ($item['amount'] ?? 'none') }}</p>
                @endforeach
                <p>-----------</p>
                <p><strong>{{ $data['total']['title'] }}</strong>: {{ $data['total']['amount'] ?? 'none' }}</p>
            @endforeach
            <p>-----------</p>
            <p><strong>Grand Total</strong>: {{ collect($payslip_entry->content['items'])->sum('total.amount') }}</p>
            <p>-----------</p>
            @foreach ($payslip_entry->content['extra'] as $data)
                <p>{{ $data['title'] . ': ' . ($data['amount'] ?? 'none') }}</p>
                @if ($data['title'] == 'Gift Certificate')
                    <p>GC #: {{ $payslip_entry->full_gc_number }}</p>
                @endif
            @endforeach
            <br>
            <p>TELLER NAME: {{ auth()->user()->first_name . ' ' . auth()->user()->surname }} </p>
            <br>
            <p>MEMBER'S SIGNATURE:</p>
            <br>
            <br>
        </div>
    @endforeach
</div>
