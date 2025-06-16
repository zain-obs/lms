<div class="flex flex-col gap-y-5 p-5">
    <h1 class="text-2xl text-gray-500 font-bold">People</h1>
    <div class="flex justify-between gap-x-5">
        @foreach ($roleCounts as $role => $count)
            <div
                class="flex flex-col gap-x-3 bg-gray-100 p-3 rounded-md text-center w-full select-none hover:scale-105 transition-all">
                <h1 class="text-2xl text-gray-500">{{ ucfirst($role) }}s</h1>
                <h1 class="text-3xl text-gray-500 font-bold">{{ $count }}</h1>
            </div>
        @endforeach
    </div>
    <h1 class="text-2xl text-gray-500 font-bold">Classes</h1>
    <div
        class="flex flex-col gap-x-3 bg-gray-100 p-3 rounded-md text-center w-full select-none hover:scale-105 transition-all">
        <h1 class="text-2xl text-gray-500">Classes</h1>
        <h1 class="text-3xl text-gray-500 font-bold">{{ $classCount }}</h1>
    </div>
    <h1 class="text-2xl text-gray-500 font-bold">External Api Call</h1>
    <p class="-mt-4 text-gray-500">You can register and login a user on the library api project from here</p>
    <div x-data="{ loginModal: false, registerModal: false, fetchModal: false }">
        <x-button.button @click="loginModal = true">Login</x-button.button>
        <x-button.button @click="registerModal = true">Register</x-button.button>
        <x-button.button @click="fetchModal = true">Fetch Users</x-button.button>
        <div x-cloak>
            <!-- Background overlay -->
            <div x-show="loginModal" class="fixed inset-0 bg-black bg-opacity-50 z-40" x-transition.opacity
                @click="loginModal=false">
            </div>
            <!-- Modal Content -->
            <div x-show="loginModal"
                class="fixed top-1/2 left-1/2 max-w-md transform -translate-x-1/2 -translate-y-1/2 bg-white p-6 rounded-lg shadow-lg z-50"
                x-transition @keydown.escape.window="loginModal=false">

                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold">Login</h2>
                    <button @click="loginModal=false" class="text-gray-600 hover:text-black text-xl">&times;</button>
                </div>
                <div class="my-4 flex flex-col gap-y-5">
                    <x-input.input wire:model.defer="email" name="email" placeholder="email">Email</x-input.input>
                    <x-input.input wire:model.defer="password" name="password"
                        placeholder="password">Password</x-input.input>
                </div>
                <div class="text-right mt-8">
                    <button @click="loginModal=false" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                        Cancel
                    </button>
                    <button @click="loginModal=false" type="button" wire:click="loginApi"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Hit
                    </button>
                </div>
            </div>
        </div>
        <div x-cloak>
            <!-- Background overlay -->
            <div x-show="registerModal" class="fixed inset-0 bg-black bg-opacity-50 z-40" x-transition.opacity
                @click="registerModal=false">
            </div>
            <!-- Modal Content -->
            <div x-show="registerModal"
                class="fixed top-1/2 left-1/2 max-w-md transform -translate-x-1/2 -translate-y-1/2 bg-white p-6 rounded-lg shadow-lg z-50"
                x-transition @keydown.escape.window="registerModal=false">

                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold">Register</h2>
                    <button @click="registerModal=false" class="text-gray-600 hover:text-black text-xl">&times;</button>
                </div>
                <div class="my-4 flex flex-col gap-y-5">
                    <x-input.input wire:model.defer="name" name="name" placeholder="name">Name</x-input.input>
                    <x-input.input wire:model.defer="email" name="email" placeholder="email">Email</x-input.input>
                    <x-input.input wire:model.defer="password" name="password"
                        placeholder="password">Password</x-input.input>
                </div>
                <div class="text-right mt-8">
                    <button @click="registerModal=false" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                        Cancel
                    </button>
                    <button @click="registerModal=false" type="button" wire:click="registerApi()"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Hit
                    </button>
                </div>
            </div>
        </div>
        <div x-cloak>
            <!-- Background overlay -->
            <div x-show="fetchModal" class="fixed inset-0 bg-black bg-opacity-50 z-40" x-transition.opacity
                @click="fetchModal=false">
            </div>
            <!-- Modal Content -->
            <div x-show="fetchModal"
                class="fixed top-1/2 left-1/2 max-w-md transform -translate-x-1/2 -translate-y-1/2 bg-white p-6 rounded-lg shadow-lg z-50"
                x-transition @keydown.escape.window="fetchModal=false">

                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold">Fetch Users</h2>
                    <button @click="fetchModal=false" class="text-gray-600 hover:text-black text-xl">&times;</button>
                </div>
                <div class="my-4 flex flex-col gap-y-5">
                    <x-input.input wire:model.defer="token" name="token" placeholder="token">Token</x-input.input>
                </div>
                <div class="text-right mt-8">
                    <button @click="fetchModal=false" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                        Cancel
                    </button>
                    <button @click="fetchModal=false" type="button" wire:click="fetchUsers"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Fetch
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="flex flex-col overflow-y-auto max-w-7xl">
        @if ($loginResponse)
            <div class="mb-4 p-3 bg-gray-100 rounded">
                <span class="font-bold">Login => </span>
                <pre class="text-sm">{{ json_encode($loginResponse, JSON_PRETTY_PRINT) }}</pre>
            </div>
        @endif
        @if ($loginError)
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
                <span class="font-bold">Login => </span>{{ $loginError }}
            </div>
        @endif
        @if ($registerResponse)
            <div class="mb-4 p-3 bg-gray-100 rounded">
                <span class="font-bold">Register => </span>
                <pre class="text-sm">{{ json_encode($registerResponse, JSON_PRETTY_PRINT) }}</pre>
            </div>
        @endif
        @if ($registerError)
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
                <span class="font-bold">Register => </span>{{ $registerError }}
            </div>
        @endif
        @if ($fetchResponse)
            <div class="mb-4 p-3 bg-gray-100 rounded max-h-96 overflow-y-auto">
                <span class="font-bold">Fetch => </span>
                <pre class="text-sm">{{ json_encode($fetchResponse, JSON_PRETTY_PRINT) }}</pre>
            </div>
        @endif
        @if ($fetchError)
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
                <span class="font-bold">Fetch => </span>{{ $fetchError }}
            </div>
        @endif
    </div>
</div>
