<div class="text-center">
    <p>Dolefil Agrarian Reform</p>
    <p>Beneficiaries Cooperative</p>
    <p>(DARBC)</p>
</div>
<br><br>
<p>Name: {{ $payslip_entry->member_name }}</p>
<p>Date : {{ now()->format('m/d/Y') }}</p>
<p>Time : {{ now()->format('h:i A') }}</p>
<br>
<p>Release: {{ $payslip_entry->payslip->release->name }}</p>
@foreach ($payslip_entry->content['items'] as $data)
    <p>{{ $data['title'] . ': ' . ($data['amount'] ?? 'none') }}</p>
@endforeach
<p>-----------</p>
<p>{{ $payslip_entry->content['total']['title'] . ': ' . ($payslip_entry->content['total']['amount'] ?? 'none') }}</p>
<p>-----------</p>
@foreach ($payslip_entry->content['extra'] as $data)
    <p>{{ $data['title'] . ': ' . ($data['amount'] ?? 'none') }}</p>
@endforeach
<br>
<p>TELLER NAME: {{ auth()->user()->first_name . ' ' . auth()->user()->surname }} </p>
