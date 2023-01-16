<div>
    @php
        $proof_of_release = $dividend->getFirstMedia('proof_of_release');
    @endphp
    @if ($proof_of_release)
        <div class="flex justify-center">
            <img src="{{ $proof_of_release->getUrl() }}" alt="proof_of_release">
        </div>
    @else
        <div class="flex justify-center">
            <p>No proof of release found. <a class="text-sm font-semibold underline" href="{{ route('release-admin.manage-proof-of-release', ['dividend' => $dividend]) }}">Manage</a></p>
        </div>
    @endif
</div>
