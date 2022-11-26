<div>
    <div class="mt-10">
        <h1 class="text-xl font-bold text-custom-blue">Manage Release Dividends</h1>
        <div class="p-4 mt-4 bg-white rounded-md shadow">
            <h4>Release Name: {{ $release->name }}</h4>
            <h5>Total Amount: <strong>{{ Akaunting\Money\Money::PHP($release->total_amount, true) }}</strong></h5>
            <h5>Release Date: {{ $release->created_at->format('M d, Y') }}</h5>
            <h5>Dividends Net Amount: <strong>{{ Akaunting\Money\Money::PHP($dividends_net_amount, true) }}</strong></h5>
        </div>
    </div>
    <div class="mt-4">
        {{ $this->table }}
    </div>
</div>
