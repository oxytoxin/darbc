<div>
    <div class="mt-10">
        <h1 class="text-xl font-bold text-custom-blue">Proof Of Release</h1>
        <div class="mt-4">
            <p>Release Name: {{ $dividend->release->name }}</p>
            <p>Member: {{ $dividend->user->full_name }}</p>
        </div>
    </div>
    <hr class="mt-2">
    <div class="flex w-2/3 gap-2 p-4 mx-auto mt-4 bg-white rounded shadow">
        <div class="flex-1" x-data="{ captured: false }">
            @if ($old_proof_of_release)
                <img src="{{ $old_proof_of_release->getUrl() }}" class="mx-auto my-2 rounded h-52 aspect-auto" alt="proof_of_release">
            @else
                <img src="{{ $proof_of_release ?? 'https://media.istockphoto.com/id/1357365823/vector/default-image-icon-vector-missing-picture-page-for-website-design-or-mobile-app-no-photo.jpg?s=612x612&w=0&k=20&c=PM_optEhHBTZkuJQLlCjLz-v3zzxp-1mpNQZsdjrbns=' }}"
                    alt="proof_of_release" class="mx-auto my-2 rounded h-52 aspect-auto">
            @endif

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
                        Capture Proof of Release
                    </x-filament-support::button>
                </x-slot>
                <div wire:model.defer="proof_of_release">
                    <video x-show="!captured" x-ref="preview" width="480" height="360" autoplay class="bg-black ">
                    </video>
                    <canvas x-show="captured" x-ref="canvas" width="480" height="360" class="w-full bg-black"></canvas>
                    <div class="flex gap-2 mt-4">
                        <x-filament-support::button @click="
                    " color="success" x-show="!captured"
                            @click="
                        $refs.canvas.getContext('2d').drawImage($refs.preview, 0, 0, 480, 360);
                        $refs.preview.srcObject.getVideoTracks().forEach(track => track.stop());
                        captured = true;
                    "
                            iconPosition="after" icon="heroicon-o-camera">
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
                    " color="success"
                            iconPosition="after" icon="heroicon-o-check-circle">
                            Save
                        </x-filament-support::button>
                    </div>
                </div>
            </x-modal>

        </div>
        <form class="flex-1" wire:submit.prevent="saveUploadedProof">
            {{ $this->form }}
            <x-filament-support::button type="submit" wire:target="saveUploadedProof" class="w-full mt-2" color="success" iconPosition="after" icon="heroicon-o-check-circle">
                Save
            </x-filament-support::button>
        </form>
    </div>

</div>
