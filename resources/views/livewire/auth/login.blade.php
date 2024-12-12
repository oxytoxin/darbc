<div>
    <div class="flex justify-center mt-20">
        <div class="p-5 rounded-lg bg-white flex flex-col w-[30rem] shadow-sm">
            <div class="flex justify-center space-x-2">
                <img class="w-12" src="assets/darbc-logo.svg" alt="">
            </div>
            <div class="mt-3 text-center">
                <h1 class="text-xl font-bold text-primary-500">Welcome to DARBC</h1>
                <p class="text-gray-700">Enter a valid account to continue signing in.</p>
            </div>
            @env('local')
            <div class="space-y-2 mx-auto text-center mt-4">
                <x-login-link :user-attributes="['username' => 'DARBCMEMBERSHIP']" label="Login as admin" />
                <x-login-link :user-attributes="['username' => 'cashier1']" label="Login as cashier1" />
                <x-login-link :user-attributes="['username' => 'cashier2']" label="Login as cashier2" />
                <x-login-link :user-attributes="['username' => 'cashier19']" label="Login as cashier19" />
                <x-login-link :user-attributes="['username' => 'j7']" label="Login as office staff" />
            </div>
            @endenv

            <form class="mt-7" wire:submit.prevent="authenticate">
                <section>
                    <h1 class="font-medium">Username</h1>
                    <div class="flex items-center px-2 py-1 mt-2 bg-white border rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="22" height="22">
                            <path class="text-gray-500 fill-current" d="M2 3.993A1 1 0 0 1 2.992 3h18.016c.548 0 .992.445.992.993v16.014a1 1 0 0 1-.992.993H2.992A.993.993 0 0 1 2 20.007V3.993zM4 5v14h16V5H4zm2 2h6v6H6V7zm2 2v2h2V9H8zm-2 6h12v2H6v-2zm8-8h4v2h-4V7zm0 4h4v2h-4v-2z" />
                        </svg>
                        <input class="flex-1 p-2 border-none focus:outline-none focus:ring-0" type="text" required wire:model.defer="username" placeholder="Enter your username">
                    </div>
                </section>
                <section class="mt-2">
                    <h1 class="font-medium">Password</h1>
                    <div class="flex items-center px-2 py-1 mt-2 bg-white border rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="22" height="22">
                            <path class="text-gray-500 fill-current" d="M6 8V7a6 6 0 1 1 12 0v1h2a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1h2zm13 2H5v10h14V10zm-8 5.732a2 2 0 1 1 2 0V18h-2v-2.268zM8 8h8V7a4 4 0 1 0-8 0v1z" />
                        </svg>
                        <input class="flex-1 p-2 border-none focus:outline-none focus:ring-0" type="password" required wire:model.defer="password" placeholder="Password">
                    </div>
                </section>
                <x-filament-support::button class="w-full py-3 mt-5 text-white rounded-md bg-primary-500" type="submit" wire:target="authenticate">Login</x-filament-support::button>
            </form>
        </div>
    </div>

    <div class="fixed inset-0 flex justify-center -top-5 -z-10">
        <div class="w-[20rem] h-[20rem] bg-primary-500/10 blur-3xl backdrop-blur-xl absolute top-0"></div>
    </div>

</div>
