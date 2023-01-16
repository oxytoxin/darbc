<div class="mt-5" x-data="{ uploadMap : @entangle('uploadMapModal') }">
    <div class="flex items-center justify-between">
        <h1 class="uppercase text-lg font-bold text-custom-blue flex items-center space-x-3">
            <span>Land Information</span>
        </h1>
        <a href="{{ route('land-admin.dashboard') }}" class="text-white bg-custom-blue/90 hover:bg-custom-blue transition inline-flex items-center space-x-2 py-1.5 px-2 rounded-md">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="22" height="22">
                <path class="fill-current" d="M7.828 11H20v2H7.828l5.364 5.364-1.414 1.414L4 12l7.778-7.778 1.414 1.414z" />
            </svg>
            <span class="text-lg pr-1.5">Go Back</span>
        </a>
    </div>
    <div class="flex items-start space-x-20 mt-2">
        <div>
            <h1 class="font-semibold uppercase">Owner's Information</h1>
            <div class="mt-3 flex items-center space-x-5">
                <ul class="space-y-1.5">
                    <li class="text-gray-500 text-right">Owner's name: </li>
                    <li class="text-gray-500 text-right">Descendent name: </li>
                    {{-- <li class="text-gray-500 text-right">Cluster: </li> --}}
                    <li class="text-gray-500 text-right">Lot Location: </li>
                    <li class="text-gray-500 text-right">Draw Date: </li>
                </ul>
                <ul class="space-y-1.5">
                    <li class="font-semibold uppercase text-custom-blue">{{ $land->user->first_name }}</li>
                    <li class="font-semibold uppercase text-custom-blue">Descendant Name</li>
                    {{-- <li class="font-semibold uppercase text-custom-blue">Cluster: </li> --}}
                    <li class="font-semibold uppercase text-custom-blue">Block {{ $land->block->block }}, Lot {{ $land->lot->lot }}, {{ $land->area->area }}</li>
                    <li class="{{ $land->draw_date ? 'text-custom-blue font-semibold' : 'text-gray-400' }}">
                        {{ $land->draw_date != null ? $land->draw_date : 'None'}}
                    </li>
                </ul>
            </div>
        </div>
        
        <div>
            <h1 class="font-semibold uppercase">Buyer's Information</h1>
            <div class="mt-3 flex items-center space-x-5">
                <ul class="space-y-1.5">
                    <li class="text-gray-500 text-right">Status: </li>
                    <li class="text-gray-500 text-right">Buyer's name: </li>
                    <li class="text-gray-500 text-right">Date Sold:</li>
                </ul>
                <ul class="space-y-1.5">
                    <li class="font-semibold uppercase text-custom-blue">
                        <span class="{{ $land->status == 1 ? 'text-custom-green bg-custom-green/10' : 'text-red-500 bg-red-500/10' }} bg-custom-green/10 font-semibold py-1 px-3 rounded-full text-sm">{{ $land->status ? 'sold' : 'unsold' }}</span>
                    </li>
                    <li class="uppercase text-custom-blue">
                        <span class="{{ $land->buyer ? 'text-custom-blue font-semibold' : 'text-gray-400' }}">{{ $land->buyer ? $land->buyer : 'None' }}</span>
                    </li>
                    <li class="uppercase text-custom-blue">
                        <span class="{{ $land->date_sold ? 'text-custom-blue font-semibold' : 'text-gray-400' }}">{{ $land->date_sold ? $land->date_sold : 'None' }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="mt-5"><hr></div>

    <div class="mt-5 flex items-start space-x-7">
        <div>
            <h1 class="font-bold text-custom-blue">Land Map</h1>
            
            <figure class="relative h-[17rem] w-[25rem] mt- group mt-3">
                <input type="file" x-ref="mapLocationImage" wire:model="mapImage" hidden>

                @if ($mapImage)
                <img class="object-cover h-full w-full border" src="{{ $mapImage->temporaryUrl() }}" alt="">
                @elseif ($land->map_url)
                <img class="object-cover h-full w-full border"
                    src="{{ Storage::url('maps/' . $land->map_url) }}"
                    alt="{{ $land->map_url }}">
                @else
                <img class="object-cover h-full w-full border"
                    src="{{ asset('/assets/placeholder.jpg') }}"
                    alt="">
                @endif
                
                <section class="hidden group-hover:grid absolute inset-0 place-content-center bg-black/5 transition">
                    <button @click="$refs.mapLocationImage.click()"
                        class="bg-custom-blue text-white py-2 px-3 rounded-md flex items-center space-x-2">
                        {{ $mapImage ? 'Browse Map Again' : 'Browse Map to upload' }}
                    </button>
                </section>
            </figure>

            <section class="mt-2">
                <button wire:click="updateMap" class="bg-custom-blue w-full justify-center text-white py-2 px-3 rounded-md flex items-center space-x-2">
                    {{ $land->map_url ? 'Update Map' : 'Upload Map' }}
                </button>
            </section>
        </div>

        {{-- <div class="flex-1">
            <div class="flex items-center justify-between">
                <h1 class="text-lg font-bold text-custom-blue">Documents</h1>
                <button wire:click="updateMap"
                    class="bg-custom-blue justify-center text-white py-2 px-3 rounded-md flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="22" height="22">
                        <path class="fill-current"
                            d="M1 14.5a6.496 6.496 0 0 1 3.064-5.519 8.001 8.001 0 0 1 15.872 0 6.5 6.5 0 0 1-2.936 12L7 21c-3.356-.274-6-3.078-6-6.5zm15.848 4.487a4.5 4.5 0 0 0 2.03-8.309l-.807-.503-.12-.942a6.001 6.001 0 0 0-11.903 0l-.12.942-.805.503a4.5 4.5 0 0 0 2.029 8.309l.173.013h9.35l.173-.013zM13 13v4h-2v-4H8l4-5 4 5h-3z" />
                    </svg>
                    <span>Upload new file</span>
                </button>
            </div>
            
            <div class="mt-3">
                <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                        <table class="min-w-full divide-y divide-gray-300 bg-white">
                            <thead>
                                <tr class="bg-custom-blue">
                                    <th scope="col" class="py-4 uppercase text-left text-sm font-semibold text-white pl-5">
                                        Document Name
                                    </th>
                                    <th scope="col" class="py-4 uppercase text-left text-sm font-semibold text-white">
                                        Uploaded on
                                    </th>
                                    <th scope="col" class="py-4 uppercase text-left text-sm font-semibold text-white">
                                        Size
                                    </th>
                                    <th scope="col" class="py-4 uppercase text-left text-sm font-semibold text-white w-[5rem]">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <tr class="odd:bg-white even:bg-gray-100/50">
                                    <td class="whitespace-nowrap py-2 font-semibold text-black pl-5">Lot Title</td>
                                    <td class="whitespace-nowrap py-2 font-medium text-black">January 3, 2021</td>
                                    <td class="whitespace-nowrap py-2 font-medium text-black">2 MB</td>
                                    <td class="whitespace-nowrap py-2 font-medium text-gray-600 space-x-1">
                                        <button wire:click="showModal({{ $land->id }})"
                                            class="bg-custom-blue/10 text-custom-blue hover:bg-custom-blue hover:text-white transition p-1 rounded-md">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </button>
                                        <button wire:click="showModal({{ $land->id }})"
                                            class="bg-red-500/10 text-red-600 hover:bg-red-600 hover:text-white transition p-1 rounded-md">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>

    {{-- <div class="fixed inset-0 bg-black/30 h-screen" x-show="uploadMap">
        <div class="grid place-content-center">
            <div class="bg-white w-[35rem] mt-20 p-3 rounded-md">
                <section class="flex items-center justify-between">
                    <h1>Upload map image</h1>
                    <button>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20">
                            <path class="fill-current"
                                d="M12 10.586l4.95-4.95 1.414 1.414-4.95 4.95 4.95 4.95-1.414 1.414-4.95-4.95-4.95 4.95-1.414-1.414 4.95-4.95-4.95-4.95L7.05 5.636z" />
                        </svg>
                    </button>
                </section>

                <figure class="bg-red-500 h-[20rem] rounded-md my-3">
                    <input type="file" x-ref="mapLocationImage" wire:model="mapImage" hidden>
                    @if ($mapImage)
                    <img class="object-cover h-full w-full rounded-md" src="{{ $mapImage->temporaryUrl() }}" alt="">
                    @else
                    <img class="object-cover h-full w-full rounded-md"
                        src="https://static.vecteezy.com/system/resources/previews/002/292/395/non_2x/placeholder-on-map-line-outline-icon-for-website-and-mobile-app-on-grey-background-free-vector.jpg"
                        alt="">
                    @endif
                </figure>

                <section class="flex items-center justify-end space-x-2">
                    <button wire:click="saveLandOwnerInfo"
                        class="bg-custom-blue text-white py-2 px-3 rounded-md flex items-center space-x-2">
                        Save Map
                    </button>
                    
                    <button class="border text-gray-500 hover:text-custom-blue transition hover:border-custom-blue  py-2 px-3 rounded-md">Cancel</button>
                </section>
            </div>
        </div>
    </div> --}}
</div>
