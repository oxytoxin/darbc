<div>
    <h1 class="mt-10 text-xl font-bold text-primary-500">Manage Member Restrictions</h1>
    <div class="p-4 mt-4 bg-white rounded shadow">
        <h3>{{ $member->user->full_name }}</h3>
        <div class="mt-10">
            <h4 class="font-bold text-primary-500">Restrictions</h4>
        </div>
        <div class="mt-8">
            {{ $this->table }}
        </div>
    </div>
</div>
