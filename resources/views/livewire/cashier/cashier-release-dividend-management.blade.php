<div>
    @if ($restricted_by_election)
        <div x-transition x-show="open" x-data="{ open: true }" class="fixed inset-0 z-50 bg-gray-700 bg-opacity-50 grid place-items-center">
            <div class="bg-white p-4 w-96">
                <h3 class="text-xl font-semibold">MEMBER VOTING STATUS</h3>
                <div class="mt-2">
                    <div class="flex justify-between">
                        <p>Election:</p>
                        <p class="font-semibold">{{ $voting_status['election_name'] }}</p>
                    </div>
                    <div class="flex justify-between mt-2">
                        <p class="font-semibold text-2xl text-center {{ $voting_status['has_voted'] ? 'text-green-700' : 'text-red-600' }}">{{ $voting_status['has_voted'] ? 'USER HAS ALREADY VOTED' : 'USER HAS NOT YET VOTED' }}</p>
                    </div>
                    <div class="mt-2 flex justify-end">
                        @if ($voting_status['has_voted'])
                            <x-filament::button @click="open = false">DISMISS</x-filament::button>
                        @else
                            <x-filament::button @click="window.location.back">DISMISS</x-filament::button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
    <x-title>Release Dividend</x-title>
    <div class="flex gap-2">
        <div class="w-2/3 p-4 space-y-4 bg-white rounded shadow">
            <div class="grid grid-cols-4">
                <section class="leading-4">
                    <h1 class="font-semibold">{{ $dividend->user->full_name }}</h1>
                    <p class="text-sm text-gray-400">
                        {{ $dividend->user->member_information->succession_number == '0' ? 'Original Owner' : ordinal($dividend->user->member_information->succession_number) . ' Successor' }}
                    </p>
                </section>
                <section class="leading-4">
                    <h1 class="text-xs text-gray-400 uppercase">DARBC ID</h1>
                    <p class="mt-1 font-semibold">{{ $dividend->user->member_information->darbc_id }}</p>
                </section>

                <section class="leading-4">
                    <h1 class="text-xs text-gray-400 uppercase">Status</h1>
                    <p class="font-semibold text-custom-green relative ml-3 before:absolute before:top-1.5 before:-left-3 before:h-2 before:w-2 before:bg-custom-green before:rounded-full">
                        Ready to release</p>
                </section>
            </div>
            <hr>
            <div class="grid grid-cols-2 gap-4">
                <section class="leading-4">
                    <h1 class="text-xs text-gray-400 uppercase">Gross Amount</h1>
                    <p class="mt-1 text-xl font-semibold">
                        {{ Akaunting\Money\Money::PHP($dividend->gross_amount, true) }}
                    </p>
                </section>
                <section class="leading-4">
                    <h1 class="text-xs text-gray-400 uppercase">Deductions</h1>
                    <p class="mt-1 text-xl font-semibold text-red-600">
                        {{ Akaunting\Money\Money::PHP($dividend->deductions_amount, true) }}
                    </p>
                </section>
                <section class="leading-4">
                    <h1 class="text-xs text-gray-400 uppercase">Net Amount Receivable</h1>
                    <p class="mt-1 text-xl font-semibold text-green-600">
                        {{ Akaunting\Money\Money::PHP($dividend->net_amount, true) }}
                    </p>
                </section>
                <section class="leading-4">
                    <h1 class="text-xs text-gray-400 uppercase">Restrictions</h1>
                    <ul class="mt-1">
                        @forelse ($dividend->restriction_entries as $restriction)
                            <li>{{ $restriction }}</li>
                        @empty
                            <li>No restrictions.</li>
                        @endforelse
                    </ul>
                </section>
                <section class="leading-4">
                    <h1 class="text-xs text-gray-400 uppercase">Authorized Personnel</h1>
                    <ul class="mt-1">
                        @forelse ($dividend->user->member_information->spa as $spa_name)
                            <li><strong>SPA: </strong>{{ $spa_name }}</li>
                        @empty
                            <li>No SPA assigned.</li>
                        @endforelse
                    </ul>
                </section>
            </div>
            <hr>
            <div>
                {{ $this->form }}
            </div>
        </div>

        <div class="w-1/3 p-4 bg-white rounded shadow" x-data="{ captured: false }">
            <img class="mx-auto my-2 rounded h-44 aspect-auto" src="{{ $proof_of_release ?? 'https://media.istockphoto.com/id/1357365823/vector/default-image-icon-vector-missing-picture-page-for-website-design-or-mobile-app-no-photo.jpg?s=612x612&w=0&k=20&c=PM_optEhHBTZkuJQLlCjLz-v3zzxp-1mpNQZsdjrbns=' }}" alt="proof_of_release">
            <x-modal>
                <x-slot name="button">
                    <x-filament-support::button class="w-full"
                                                @click="
                            const supported = 'mediaDevices' in navigator;
                            if(supported){
                                navigator.mediaDevices.getUserMedia({
                                    video:  {
                                        width: 480,
                                        height: 360,
                                    },
                                  }).then((stream) => {
                                    $refs.preview.srcObject = stream;
                                });
                                show = true;
                            }else{
                                alert('Your browser does not support this feature.');
                            }
                        "
                                                color="success" iconPosition="after" icon="heroicon-o-photograph">
                        Proof of Release
                    </x-filament-support::button>
                </x-slot>
                <div wire:model.defer="proof_of_release">
                    <video class="bg-black " x-show="!captured" x-ref="preview" width="480" height="360" autoplay>
                    </video>
                    <canvas class="w-full bg-black" x-show="captured" x-ref="canvas" width="480" height="360"></canvas>
                    <div class="flex gap-2 mt-4">
                        <x-filament-support::button @click="
                        " color="success" x-show="!captured"
                                                    @click="
                            $refs.canvas.getContext('2d').drawImage($refs.preview, 0, 0, 480, 360);
                            $refs.preview.srcObject.getVideoTracks().forEach(track => track.stop());
                            captured = true;
                        " iconPosition="after" icon="heroicon-o-camera">
                            Capture
                        </x-filament-support::button>

                        <x-filament-support::button x-show="captured" @click="
                        " color="warning"
                                                    @click="
                            navigator.mediaDevices.getUserMedia({
                                video:  {
                                    width: 480,
                                    height: 360,
                                },
                            }).then((stream) => {
                                $refs.preview.srcObject = stream;
                            });
                            captured = false;
                        "
                                                    iconPosition="after" icon="heroicon-o-refresh">
                            Retake
                        </x-filament-support::button>
                        <x-filament-support::button x-show="captured" wire:target="captureProofOfRelease" @click="
                                $wire.captureProofOfRelease($refs.canvas.toDataURL());
                        " color="success" iconPosition="after" icon="heroicon-o-check-circle">
                            Save
                        </x-filament-support::button>
                    </div>
                </div>
            </x-modal>
            @if ($proof_of_release)
                <div class="mt-2">
                    <x-filament-support::button class="w-full" onclick="return confirm('Are you sure?') || event.stopImmediatePropagation()" wire:click="release" wire:target="release" color="success" iconPosition="after" icon="heroicon-o-check-circle">
                        Release Now
                    </x-filament-support::button>
                </div>
            @endif
        </div>
    </div>
</div>
