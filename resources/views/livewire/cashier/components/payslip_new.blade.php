<div class="text-center">
    <p>Dolefil Agrarian Reform</p>
    <p>Beneficiaries Cooperative</p>
    <p>(DARBC)</p>
    <br>
    <strong>PAYSLIP</strong>
</div>
<br><br>
<p>Name: {{ $payslip_entry->member_name }}</p>
<p>Date : {{ now()->format('m/d/Y') }}</p>
<p>Time : {{ now()->format('h:i A') }}</p>
<br>
<p>Release: {{ $payslip_entry->payslip->release->name }}</p>
@foreach ($payslip_entry->content['items'] as $data)
    <strong>{{ $data['title'] }}</strong>
    @foreach ($data['entries'] as $item)
        <p>{{ $item['title'] . ': ' . ($item['amount'] ?? 'none') }}</p>
    @endforeach
    <p>-----------</p>
    <p>{{ $data['total']['title'] . ': ' . ($data['total']['amount'] ?? 'none') }}</p>
@endforeach
<p>-----------</p>
@foreach ($payslip_entry->content['extra'] as $data)
    <p>{{ $data['title'] . ': ' . ($data['amount'] ?? 'none') }}</p>
@endforeach
<br>
<p>TELLER NAME: {{ auth()->user()->first_name . ' ' . auth()->user()->surname }} </p>
