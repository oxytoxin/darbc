<div>
    <div class="flex items-center justify-between mt-10">
        <h1 class="text-xl font-bold text-primary-500">Cluster Members</h1>
    </div>
    <p class="mt-4 font-semibold">Cluster {{ $cluster->name }} - {{ $cluster->address }}</p>
    <div class="mt-4">
        {{ $this->table }}
    </div>
</div>
