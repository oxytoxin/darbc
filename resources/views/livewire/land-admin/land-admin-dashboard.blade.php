<div x-data="{ drawDate : @entangle('drawDateModal') }">
    <div class="bg-black/10 fixed inset-0" x-show="drawDate" x-cloak>
        <div class="h-screen flex justify-center">
            <div class="bg-white w-[32rem] h-[12.2rem] mt-10 p-3 rounded-md">
                <section class="flex items-center justify-between">
                    <h1 class="font-semibold text-custom-blue">Make Land Draw</h1>
                    <button @click="drawDate = false" class="text-gray-500 hover:text-red-500">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20">
                            <path class="fill-current"
                                d="M12 10.586l4.95-4.95 1.414 1.414-4.95 4.95 4.95 4.95-1.414 1.414-4.95-4.95-4.95 4.95-1.414-1.414 4.95-4.95-4.95-4.95L7.05 5.636z" />
                        </svg>
                    </button>
                </section>

                <div class="flex flex-col space-y-2 mt-3">
                    <label for="drawDate" class="font-semibold">Draw date</label>
                    <input wire:model="drawDate" type="text" name="drawDate" id="datepicker" class="rounded-md cursor-pointer" placeholder="select draw date">
                </div>

                <x-minor.button wire:click="saveDrawDate" buttonContent="Save Draw Date" class="bg-custom-blue text-white mt-3 select-none flex justify-center" />
            </div>
        </div>
    </div>
    <div class="mt-5">
        <!-- Top section -->
        <div class="flex items-center justify-between space-x-4">
            <input type="text" placeholder="Search..." class="border bg-white rounded-md flex-1" wire:model="search">
    
            <x-minor.button href="{{ route('land-admin.land-owner')}}" buttonContent="Add land owner" class="bg-custom-blue text-white">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20">
                    <path class="fill-current" d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z" />
                </svg>
            </x-minor.button>
        </div>
        
        <!-- Table -->
        <div class="mt-5">
            <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                    <table class="min-w-full divide-y divide-gray-300 bg-white">
                        <thead>
                            <tr class="bg-custom-blue">
                                <th scope="col"
                                    class="py-4 uppercase text-left text-sm font-semibold text-white pl-5 w-[23rem]">
                                    Name
                                </th>
                                <th scope="col" class="py-4 uppercase text-left text-sm font-semibold text-white">
                                    BLOCK
                                </th>
                                <th scope="col" class="py-4 uppercase text-left text-sm font-semibold text-white">
                                    LOT
                                </th>
                                <th scope="col" class="py-4 uppercase text-left text-sm font-semibold text-white">
                                    Area
                                </th>
                                <th scope="col" class="py-4 uppercase text-left text-sm font-semibold text-white">
                                    Status
                                </th>
                                <th scope="col" class="py-4 uppercase text-left text-sm font-semibold text-white w-[20rem]">
                                    Buyer
                                </th>
                                <th scope="col" class="py-4 uppercase text-left text-sm font-semibold text-white">
                                    Date Sold
                                </th>
                                <th scope="col" class="py-4 uppercase text-left text-sm font-semibold text-white">
                                    Draw date
                                </th>
                                <th scope="col" class="py-4 uppercase text-left text-sm font-semibold text-white w-[10rem]">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($informations as $land)
                                <tr class="odd:bg-white even:bg-gray-100/50">
                                    <td class="whitespace-nowrap py-2 font-medium text-gray-600 pl-5">{{ $land->user->first_name . ' ' . $land->user->surname}}</td>
                                    <td class="whitespace-nowrap py-2 font-medium text-gray-600">{{ $land->block->block }}</td>
                                    <td class="whitespace-nowrap py-2 font-medium text-gray-600">{{ $land->lot->lot }}</td>
                                    <td class="whitespace-nowrap py-2 font-medium text-gray-600">{{ $land->area->area }}</td>
                                    <td class="whitespace-nowrap py-2 font-medium text-gray-600">
                                        <span class="{{ $land->status == 1 ? 'text-custom-green bg-custom-green/10' : 'text-red-500 bg-red-500/10' }} bg-custom-green/10 font-semibold py-1 px-3 rounded-full text-sm">{{ $land->status ? 'sold' : 'unsold' }}</span>
                                    </td>
                                    <td class="whitespace-nowrap py-2 font-medium {{ $land->buyer ? 'text-gray-600' : 'text-gray-400'}}">
                                        <span>{{ $land->buyer ? $land->buyer : 'None' }}</span>
                                    </td>
                                    <td class="{{ $land->date_sold != null ? '' : 'text-gray-400' }} whitespace-nowrap py-2 font-medium">
                                        {{ $land->date_sold != null ? $land->date_sold : 'None'}}
                                    </td>
                                    <td class="{{ $land->draw_date != null ? '' : 'text-gray-400' }} whitespace-nowrap py-2 font-medium">
                                        {{ $land->draw_date != null ? $land->draw_date : 'None'}}
                                    </td>
                                    <td class="whitespace-nowrap py-2 font-medium text-gray-600 space-x-1">
                                        <button wire:click="showModal({{ $land->id }})"
                                            class="bg-custom-blue/10 text-custom-blue hover:bg-custom-blue hover:text-white transition p-1 rounded-md">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20">
                                                <path class="fill-current"
                                                    d="M17 3h4a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h4V1h2v2h6V1h2v2zm-2 2H9v2H7V5H4v4h16V5h-3v2h-2V5zm5 6H4v8h16v-8z" />
                                            </svg>
                                        </button>
                                        <a href="{{ route('land-admin.land-information', ['id' => $land->id]) }}"
                                            class="bg-custom-blue/10 text-custom-blue hover:bg-custom-blue hover:text-white transition p-1 rounded-md inline-flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20">
                                                <path class="fill-current"
                                                    d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zM11 7h2v2h-2V7zm0 4h2v6h-2v-6z" />
                                            </svg>
                                        </a>
                                        <a href=""
                                            class="bg-custom-blue/10 text-custom-blue hover:bg-custom-blue hover:text-white transition p-1 rounded-md inline-flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20">
                                                <path class="fill-current"
                                                    d="M15.728 9.686l-1.414-1.414L5 17.586V19h1.414l9.314-9.314zm1.414-1.414l1.414-1.414-1.414-1.414-1.414 1.414 1.414 1.414zM7.242 21H3v-4.243L16.435 3.322a1 1 0 0 1 1.414 0l2.829 2.829a1 1 0 0 1 0 1.414L7.243 21z" />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="py-3 text-center">
                                        <div class="flex flex-col items-center">
                                            <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 647.63626 632.17383"
                                                xmlns:xlink="http://www.w3.org/1999/xlink">
                                                <path
                                                    d="M687.3279,276.08691H512.81813a15.01828,15.01828,0,0,0-15,15v387.85l-2,.61005-42.81006,13.11a8.00676,8.00676,0,0,1-9.98974-5.31L315.678,271.39691a8.00313,8.00313,0,0,1,5.31006-9.99l65.97022-20.2,191.25-58.54,65.96972-20.2a7.98927,7.98927,0,0,1,9.99024,5.3l32.5498,106.32Z"
                                                    transform="translate(-276.18187 -133.91309)" fill="#f2f2f2" />
                                                <path
                                                    d="M725.408,274.08691l-39.23-128.14a16.99368,16.99368,0,0,0-21.23-11.28l-92.75,28.39L380.95827,221.60693l-92.75,28.4a17.0152,17.0152,0,0,0-11.28028,21.23l134.08008,437.93a17.02661,17.02661,0,0,0,16.26026,12.03,16.78926,16.78926,0,0,0,4.96972-.75l63.58008-19.46,2-.62v-2.09l-2,.61-64.16992,19.65a15.01489,15.01489,0,0,1-18.73-9.95l-134.06983-437.94a14.97935,14.97935,0,0,1,9.94971-18.73l92.75-28.4,191.24024-58.54,92.75-28.4a15.15551,15.15551,0,0,1,4.40966-.66,15.01461,15.01461,0,0,1,14.32032,10.61l39.0498,127.56.62012,2h2.08008Z"
                                                    transform="translate(-276.18187 -133.91309)" fill="#3f3d56" />
                                                <path
                                                    d="M398.86279,261.73389a9.0157,9.0157,0,0,1-8.61133-6.3667l-12.88037-42.07178a8.99884,8.99884,0,0,1,5.9712-11.24023l175.939-53.86377a9.00867,9.00867,0,0,1,11.24072,5.9707l12.88037,42.07227a9.01029,9.01029,0,0,1-5.9707,11.24072L401.49219,261.33887A8.976,8.976,0,0,1,398.86279,261.73389Z"
                                                    transform="translate(-276.18187 -133.91309)" fill="#220068" />
                                                <circle cx="190.15351" cy="24.95465" r="20" fill="#220068" />
                                                <circle cx="190.15351" cy="24.95465" r="12.66462" fill="#fff" />
                                                <path
                                                    d="M878.81836,716.08691h-338a8.50981,8.50981,0,0,1-8.5-8.5v-405a8.50951,8.50951,0,0,1,8.5-8.5h338a8.50982,8.50982,0,0,1,8.5,8.5v405A8.51013,8.51013,0,0,1,878.81836,716.08691Z"
                                                    transform="translate(-276.18187 -133.91309)" fill="#e6e6e6" />
                                                <path
                                                    d="M723.31813,274.08691h-210.5a17.02411,17.02411,0,0,0-17,17v407.8l2-.61v-407.19a15.01828,15.01828,0,0,1,15-15H723.93825Zm183.5,0h-394a17.02411,17.02411,0,0,0-17,17v458a17.0241,17.0241,0,0,0,17,17h394a17.0241,17.0241,0,0,0,17-17v-458A17.02411,17.02411,0,0,0,906.81813,274.08691Zm15,475a15.01828,15.01828,0,0,1-15,15h-394a15.01828,15.01828,0,0,1-15-15v-458a15.01828,15.01828,0,0,1,15-15h394a15.01828,15.01828,0,0,1,15,15Z"
                                                    transform="translate(-276.18187 -133.91309)" fill="#3f3d56" />
                                                <path
                                                    d="M801.81836,318.08691h-184a9.01015,9.01015,0,0,1-9-9v-44a9.01016,9.01016,0,0,1,9-9h184a9.01016,9.01016,0,0,1,9,9v44A9.01015,9.01015,0,0,1,801.81836,318.08691Z"
                                                    transform="translate(-276.18187 -133.91309)" fill="#220068" />
                                                <circle cx="433.63626" cy="105.17383" r="20" fill="#220068" />
                                                <circle cx="433.63626" cy="105.17383" r="12.18187" fill="#fff" />
                                            </svg>
                                            
                                            <span class="text-gray-500 {{ $search != null ? 'italic' : ''}}">{{ $search !=null ? "'". $search . "'" . ' not found' : 'No data found!' }}</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
    
                </div>
            </div>

            <div class="mt-3">
                {{ $informations->links() }}
            </div>
        </div>
    </div>
</div>