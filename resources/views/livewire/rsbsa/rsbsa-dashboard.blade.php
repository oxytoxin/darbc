<div class="grid grid-cols-2 gap-4">
    <!-- Active Members WITH RSBSA -->
    <x-card-stat cardTitle="Active Members with RSBSA" :statCount="$total_active_member_where_has_rsbsa" />

    <!-- Active Members WITHOUT RSBSA -->
    <x-card-stat cardTitle="Active Members without RSBSA" :statCount="$total_active_member_where_doesnt_have" />
</div>
