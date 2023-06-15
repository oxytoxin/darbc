<div>
    <x-title>Cluster Members</x-title>
    <p class="mt-4 font-semibold">Cluster {{ $cluster->name }} - {{ $cluster->address }}</p>
    <div class="mt-4">
        {{ $this->table }}
    </div>
</div>
