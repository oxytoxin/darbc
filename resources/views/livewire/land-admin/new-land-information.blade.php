<div class="mt-5 relative" x-data="{ expanded: @entangle('collapseExpand') }">
    <div class="flex items-start space-x-5">
        <div>
            <div class="flex-1 rounded-md">
                <h1 class="font-semibold">Assign member as land owner</h1>
                <input type="text" placeholder="Search member's name"
                    class="rounded-md mt-1 w-full {{ $search != null ? 'border-none focus:outline-none focus:border-transparent' : 'border'}}"
                    wire:model="search">
            
                @if ($search != null)
                @forelse ($informations as $info)
                <div class="bg-white w-full flex items-center justify-between p-2 border">
                    <h1>{{ $info->user->first_name . ' ' . $info->user->surname }}</h1>
                    </h1>
                    <button wire:click="makeAsOwner({{ $info->id }})"
                        class="bg-custom-blue text-white py-1 px-2 rounded-md text-sm">Make as owner</button>
                </div>
                @empty
                <div class="bg-white w-full p-2 py-2.5 flex items-center text-gray-400 justify-center">'{{ $search }}' not found
                </div>
                @endforelse
                @endif
            </div>

            <div class="mt-5">
                <h1 class="font-semibold text-custom-blue text-lg">Owner Information</h1>
            
                <div class="mt-1.5 flex items-center space-x-3">
                    <div>
                        <h1 class="text-gray-500">First name</h1>
                        <input type="text" placeholder="First name" class="rounded-md mt-1 w-[18.5rem]" wire:model="firstName">
                    </div>
                    <div>
                        <h1 class="text-gray-500">Middle name</h1>
                        <input type="text" placeholder="Middle name" class="rounded-md mt-1 w-[18.5rem]" wire:model="middleName">
                    </div>
                    <div>
                        <h1 class="text-gray-500">Surname</h1>
                        <input type="text" placeholder="Surname" class="rounded-md mt-1 w-[18.5rem]" wire:model="surname">
                    </div>
                    <div>
                        <h1 class="text-gray-500">Suffix</h1>
                        <input type="text" placeholder="suffix name" class="rounded-md mt-1 w-[15rem]" wire:model="suffix">
                    </div>
                </div>
            </div>

            <div class="mt-5">
                <h1 class="font-semibold text-custom-blue text-lg">Land Information</h1>
            
                <div class="mt-1.5 flex items-center space-x-3">
                    <div>
                        <h1 class="text-gray-500">Block</h1>
                        <select wire:model="block" class="rounded-md mt-1 w-[18.5rem] bg-gray-200 overflow-y-scroll max-h-20">
                            <option hidden>Select block</option>
                            @forelse ($blocks as $block)
                            <option value="{{ $block->id }}">{{ $block->block }}</option>
                            @empty
                            <option value="">Empty</option>
                            @endforelse
                        </select>
                    </div>
                    <div>
                        <h1 class="text-gray-500">Lot</h1>
                        <select wire:model="lot" class="rounded-md mt-1 w-[18.5rem] bg-gray-200">
                            <option hidden>Select lot</option>
                            @forelse ($lots as $lot)
                            <option value="{{ $lot->id }}">{{ $lot->lot }}</option>
                            @empty
                            <option value="">Empty</option>
                            @endforelse
                        </select>
                    </div>
                    <div>
                        <h1 class="text-gray-500">Area</h1>
                        <select wire:model="area" class="rounded-md mt-1 w-[18.5rem] bg-gray-200">
                            <option hidden>Select area</option>
                            @forelse ($areas as $area)
                            <option value="{{ $area->id }}">{{ $area->area }}</option>
                            @empty
                            <option value="">Empty</option>
                            @endforelse
                        </select>
                    </div>
                    <div>
                        <h1 class="text-gray-500">Status</h1>
                        <select wire:model="status" class="rounded-md mt-1 w-[15rem] bg-gray-200">
                            <option hidden>Select tatus</option>
                            <option value="0">Unsold</option>
                            <option value="1">Sold</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <h1 class="font-semibold">Upload map</h1>
        
            <form wire:submit.prevent="saveMap" enctype="multipart/form-data">
                @csrf
                <figure class="h-[18rem] w-[25rem] mt-2 relative">
                    <input type="file" x-ref="mapLocationImage" wire:model="mapImage" hidden>
                    @if ($mapImage)
                    <img class="object-cover h-full w-full" src="{{ $mapImage->temporaryUrl() }}" alt="">
                    @else
                    <img class="object-cover h-full w-full"
                        src="https://static.vecteezy.com/system/resources/previews/002/292/395/non_2x/placeholder-on-map-line-outline-icon-for-website-and-mobile-app-on-grey-background-free-vector.jpg"
                        alt="">
                    @endif
        
                    <div class="absolute top-3 right-3">
                        <button type="button" @click="$refs.mapLocationImage.click()"
                            class="bg-custom-blue/80 hover:bg-custom-blue text-white px-2 py-1.5 rounded-md flex items-center space-x-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20">
                                <path class="fill-current"
                                    d="M12.414 5H21a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h7.414l2 2zM20 11H4v8h16v-8zm0-2V7h-8.414l-2-2H4v4h16z" />
                            </svg>
        
                            <span>Browse Map</span>
                        </button>
                    </div>
        
                    @if ($mapImage)
                    <div class="absolute bottom-0 inset-x-0 text-center bg-gradient-to-t from-gray-400 py-7">
                        <button type="submit" class="bg-custom-blue text-white p-2 rounded-md ">Upload Map</button>
                    </div>
                    @endif
                </figure>
            </form>
        </div>
    </div>
    
    {{-- x-show="expanded" x-collapse.duration.1000ms --}}

    <!-- File uploads -->

    <div class="space-x-1.5 flex items-center justify-end absolute -bottom-32 right-0">
        <button wire:click="saveLandOwnerInfo" class="bg-custom-blue text-white py-2 px-3 rounded-md flex items-center space-x-2">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="22" height="22">
                <path class="fill-current"
                    d="M7 19v-6h10v6h2V7.828L16.172 5H5v14h2zM4 3h13l4 4v13a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1zm5 12v4h6v-4H9z" />
            </svg>
            <span>Save land information</span>
        </button>
        <a href="{{ route('land-admin.dashboard') }}" class="border text-gray-500 hover:text-custom-blue transition hover:border-custom-blue  py-2 px-3 rounded-md">Cancel</a>
    </div>

    @push('file-upload')
        <script>
            function dataFileDnD() {
            return {
                files: [],
                fileDragging: null,
                fileDropping: null,
                humanFileSize(size) {
                    const i = Math.floor(Math.log(size) / Math.log(1024));
                    return (
                        (size / Math.pow(1024, i)).toFixed(2) * 1 +
                        " " +
                        ["B", "kB", "MB", "GB", "TB"][i]
                    );
                },
                remove(index) {
                    let files = [...this.files];
                    files.splice(index, 1);
        
                    this.files = createFileList(files);
                },
                drop(e) {
                    let removed, add;
                    let files = [...this.files];
        
                    removed = files.splice(this.fileDragging, 1);
                    files.splice(this.fileDropping, 0, ...removed);
        
                    this.files = createFileList(files);
        
                    this.fileDropping = null;
                    this.fileDragging = null;
                },
                dragenter(e) {
                    let targetElem = e.target.closest("[draggable]");
        
                    this.fileDropping = targetElem.getAttribute("data-index");
                },
                dragstart(e) {
                    this.fileDragging = e.target
                        .closest("[draggable]")
                        .getAttribute("data-index");
                    e.dataTransfer.effectAllowed = "move";
                },
                loadFile(file) {
                    const preview = document.querySelectorAll(".preview");
                    const blobUrl = URL.createObjectURL(file);
        
                    preview.forEach(elem => {
                        elem.onload = () => {
                            URL.revokeObjectURL(elem.src); // free memory
                        };
                    });
        
                    return blobUrl;
                },
                addFiles(e) {
                    const files = createFileList([...this.files], [...e.target.files]);
                    this.files = files;
                    this.form.formData.files = [...files];
                }
            };
        }
        </script>
    @endpush
</div>


{{-- <div>
    <div class="mt-5">
        <div class="mt-1.5 flex items-start space-x-10">
            <div class="flex-1">
                <h1 class="text-gray-500 mb-2">Additional Documents</h1> --}}

                {{-- <div class="w-full">
                        <label
                            class="flex justify-center w-full h-32 px-4 transition bg-white border-2 border-gray-300 border-dashed rounded-md appearance-none cursor-pointer hover:border-gray-400 focus:outline-none">
                            <span class="flex items-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                <span class="font-medium text-gray-600">
                                    Drop document files to Attach, or
                                    <span class="text-blue-600 underline">browse</span>
                                </span>
                            </span>
                            <input type="file" wire:model="fileDocuments" name="file_upload" class="hidden">
                        </label>
                    </div> --}}

                {{-- <div x-data="dataFileDnD()"
                    class="relative flex flex-col p-4 text-gray-400 border border-gray-200 rounded bg-white">
                    <div x-ref="dnd"
                        class="relative flex flex-col text-gray-400 border border-gray-200 border-dashed rounded cursor-pointer">
                        <input accept="*" type="file" multiple
                            class="absolute inset-0 z-50 w-full h-full p-0 m-0 outline-none opacity-0 cursor-pointer"
                            @change="addFiles($event)"
                            @dragover="$refs.dnd.classList.add('border-blue-400'); $refs.dnd.classList.add('ring-4'); $refs.dnd.classList.add('ring-inset');"
                            @dragleave="$refs.dnd.classList.remove('border-blue-400'); $refs.dnd.classList.remove('ring-4'); $refs.dnd.classList.remove('ring-inset');"
                            @drop="$refs.dnd.classList.remove('border-blue-400'); $refs.dnd.classList.remove('ring-4'); $refs.dnd.classList.remove('ring-inset');"
                            title="" />

                        <div class="flex flex-col items-center justify-center py-10 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            <span class="font-medium text-gray-600">
                                Drop document files to Attach, or
                                <span class="text-blue-600 underline">browse</span>
                            </span>
                        </div>
                    </div>

                    <template x-if="files.length > 0">
                        <div class="grid grid-cols-4 gap-4 mt-4 md:grid-cols-6" @drop.prevent="drop($event)"
                            @dragover.prevent="$event.dataTransfer.dropEffect = 'move'">
                            <template x-for="(_, index) in Array.from({ length: files.length })">
                                <div class="relative flex flex-col items-center overflow-hidden text-center bg-gray-100 border rounded cursor-move select-none"
                                    style="padding-top: 100%;" @dragstart="dragstart($event)"
                                    @dragend="fileDragging = null" :class="{'border-blue-600': fileDragging == index}"
                                    draggable="true" :data-index="index">
                                    <button
                                        class="absolute top-0 right-0 z-50 p-1 bg-white rounded-bl focus:outline-none"
                                        type="button" @click="remove(index)">
                                        <svg class="w-4 h-4 text-gray-700" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                    <template x-if="files[index].type.includes('application/') || files[index].type === ''">
                                        <svg class="absolute w-10 h-10 text-gray-400 transform top-1/2 -translate-y-2/3" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                        </svg>
                                    </template> --}}

                                    {{-- <template x-if="files[index].type.includes('audio/')">
                                        <svg class="absolute w-12 h-12 text-gray-400 transform top-1/2 -translate-y-2/3"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                        </svg>
                                    </template>
                                    <template x-if="files[index].type.includes('image/')">
                                            <img class="absolute inset-0 z-0 object-cover w-full h-full border-4 border-white preview"
                                                x-bind:src="loadFile(files[index])" />
                                        </template>
                                    <template x-if="files[index].type.includes('video/')">
                                        <video
                                            class="absolute inset-0 object-cover w-full h-full border-4 border-white pointer-events-none preview">
                                            <fileDragging x-bind:src="loadFile(files[index])" type="video/mp4">
                                        </video>
                                    </template> --}}

                                    {{-- <div
                                        class="absolute bottom-0 left-0 right-0 flex flex-col p-2 text-xs bg-white bg-opacity-50">
                                        <span class="w-full font-bold text-gray-900 truncate"
                                            x-text="files[index].name">Loading</span>
                                        <span class="text-xs text-gray-900"
                                            x-text="humanFileSize(files[index].size)">...</span>
                                    </div>

                                    <div class="absolute inset-0 z-40 transition-colors duration-300"
                                        @dragenter="dragenter($event)" @dragleave="fileDropping = null"
                                        :class="{'bg-blue-200 bg-opacity-80': fileDropping == index && fileDragging != index}">
                                    </div>
                                </div>
                            </template>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
</div> --}}