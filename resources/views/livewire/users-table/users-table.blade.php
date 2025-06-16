<div class="flex flex-col gap-y-5 bg-white p-3 rounded-md overflow-y-auto">
    <div class="flex justify-start px-5">
        <div class="flex justify-between items-center gap-x-3">
            <span class="">Search</span>
            <x-input.input name="search" id="search" wire:model.live='search' placeholder=""></x-input.input>
        </div>
    </div>
    <hr class="text-gray-200">
    <table>
        <thead>
            <tr class="text-gray-700">
                <th>Sr#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Joined</th>
                <th>Role</th>
                @can('view users')
                    <th class="mb-5">Actions</th>
                @endcan
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse ($users as $user)
                <tr class="text-center">
                    <td class="p-2">{{ $loop->iteration }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at->diffForHumans() }}</td>
                    <td>
                        @forelse ($user->roles as $role)
                            <x-badge.badge>{{ $role->name }}</x-badge.badge>
                        @empty
                            <x-badge.badge bg="bg-gray-400">None</x-badge.badge>
                        @endforelse
                    </td>
                    @can('view users')
                        <td x-data="{ deleteModal: false, edit: false }" class="flex justify-center items-center gap-x-3 h-full p-2">
                            <x-TableButton.table_button @click="edit=true" bg="bg-yellow-400" hover="hover:bg-yellow-500">
                                <i class="ri-pencil-line"></i>
                            </x-TableButton.table_button>
                            <x-TableButton.table_button @click="deleteModal=true" bg="bg-orange-400"
                                hover="hover:bg-orange-500">
                                <i class="ri-delete-bin-6-line"></i>
                            </x-TableButton.table_button>
                            <div x-cloak>
                                <!-- Background overlay -->
                                <div x-show="edit" class="fixed inset-0 bg-black bg-opacity-50 z-40" x-transition.opacity
                                    @click="edit=false">
                                </div>
                                <div x-show="edit"
                                    class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white p-6 rounded-lg shadow-lg z-50"
                                    x-transition @keydown.escape.window="edit=false">
                                    <div class="flex justify-between items-center mb-4">
                                        <h2 class="text-xl font-semibold">Edit {{ $user->name }}</h2>
                                        <button @click="edit=false"
                                            class="text-gray-600 hover:text-black text-xl">&times;</button>
                                    </div>
                                    <div class="space-y-4 flex gap-x-7">
                                        <div class="w-32">
                                            <p class="text-sm text-gray-600 font-medium mb-2 text-start">Current Roles</p>
                                            <ul
                                                class="list-disc list-inside text-gray-800 text-sm h-48 overflow-y-auto text-start">
                                                @forelse ($user->roles->pluck('name') as $role)
                                                    <li>{{ $role }}</li>
                                                @empty
                                                    <li class="text-gray-400 italic">No Role assigned</li>
                                                @endforelse
                                            </ul>
                                        </div>
                                        <div class="w-40">
                                            <p class="text-sm text-gray-600 font-medium mb-2">Add Roles</p>
                                            <select wire:model="rolesToAssign" multiple
                                                class="block w-full p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-700 h-48">
                                                @forelse ($roles as $role)
                                                    @if (!in_array($role->name, $user->roles->pluck('name')->toArray()))
                                                        <option value="{{ $role->name }}">{{ $role->name }}
                                                        </option>
                                                    @endif
                                                @empty
                                                    <option disabled class="text-gray-400">No Role available
                                                    </option>
                                                @endforelse
                                            </select>
                                        </div>
                                        <div class="w-40">
                                            <p class="text-sm text-gray-600 font-medium mb-2">Revoke Roles</p>
                                            <select wire:model="rolesToRevoke" multiple
                                                class="block w-full p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-700 h-48">
                                                @forelse ($roles as $role)
                                                    @if (in_array($role->name, $user->roles->pluck('name')->toArray()))
                                                        <option value="{{ $role->name }}">{{ $role->name }}
                                                        </option>
                                                    @endif
                                                @empty
                                                    <option disabled class="text-gray-400">No Role available
                                                    </option>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    <p class="mb-3">Hold Ctrl while selecting to select multiple permissions.</p>
                                    <div class="text-right">
                                        <button @click="edit=false" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                                            Cancel
                                        </button>
                                        <button type="button" @click="edit=false"
                                            wire:click="editRole('{{ $user->id }}')"
                                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                            Save
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div x-cloak>
                                <!-- Background overlay -->
                                <div x-show="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 z-40"
                                    x-transition.opacity @click="deleteModal=false">
                                </div>

                                <!-- Modal Content -->
                                <div x-show="deleteModal"
                                    class="fixed top-1/2 left-1/2 max-w-md transform -translate-x-1/2 -translate-y-1/2 bg-white p-6 rounded-lg shadow-lg z-50"
                                    x-transition @keydown.escape.window="deleteModal=false">

                                    <div class="flex justify-between items-center mb-4">
                                        <h2 class="text-xl font-semibold">Delete User {{ $user->name }}</h2>
                                        <button @click="deleteModal=false"
                                            class="text-gray-600 hover:text-black text-xl">&times;</button>
                                    </div>

                                    <div class="mb-4 flex gap-x-5">
                                        <p>Are you sure you want to delete this user?</p>
                                    </div>
                                    <i class="ri-delete-bin-2-line text-8xl text-red-400"></i>
                                    <div class="text-right mt-8">
                                        <button @click="deleteModal=false"
                                            class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                                            Cancel
                                        </button>
                                        <button type="button" @click="deleteModal=false"
                                            wire:click="deleteUser('{{ $user->id }}')"
                                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                            Delete
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </td>
                    @endcan
                </tr>
            @empty
            @endforelse

        </tbody>
    </table>
    {{ $users->links() }}
</div>
