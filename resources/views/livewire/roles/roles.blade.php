<div class="flex flex-col gap-y-5 bg-white p-3 rounded-md overflow-y-auto">
    <div class="flex justify-between px-5">
        <div class="flex justify-between items-center gap-x-3">
            <span class="">Search</span>
            <x-input.input name="search" id="search" wire:model.live='search' placeholder=""></x-input.input>
        </div>
        <div x-data="{ open: false, open2: false, open3: false }">
            <button @click="open = true"
                class="px-4 py-2 rounded-sm bg-gray-400 ml-auto bebas text-white transition-all hover:bg-gray-600">Add
                Role</button>
            <button @click="open2 = true"
                class="px-4 py-2 rounded-sm bg-gray-400 ml-auto bebas text-white transition-all hover:bg-gray-600">Add
                Permission</button>
            <button @click="open3 = true"
                class="px-4 py-2 rounded-sm bg-gray-400 ml-auto bebas text-white transition-all hover:bg-gray-600">All
                Permissions</button>
            <!-- Modal -->
            <div x-cloak wire:ignore>
                <!-- Background overlay -->
                <div x-show="open" class="fixed inset-0 bg-black bg-opacity-50 z-40" x-transition.opacity
                    @click="open = false">
                </div>

                <!-- Modal Content -->
                <div x-show="open"
                    class="fixed top-1/2 left-1/2 max-w-md transform -translate-x-1/2 -translate-y-1/2 bg-white p-6 rounded-lg shadow-lg z-50"
                    x-transition @keydown.escape.window="open = false">

                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold">Add Role</h2>
                        <button @click="open = false" class="text-gray-600 hover:text-black text-xl">&times;</button>
                    </div>

                    <div class="mb-4">
                        <p>Enter the role details below.</p>
                        <x-input.input wire:model="roleCreationName" name="role_name">Role Name</x-input.input>
                        <label for="roles" class="block text-sm font-medium text-gray-700 mb-1">Select Roles</label>
                        <select wire:model="rolesSelection" multiple
                            class="block w-full p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-700 h-48">
                            @foreach ($permissions as $permission)
                                <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                            @endforeach
                        </select>
                        <p>Hold Ctrl while selecting to select multiple permissions.</p>
                    </div>

                    <div class="text-right">
                        <button @click="open = false" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                            Cancel
                        </button>
                        <button wire:click="createRole()" @click="open = false"
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Create Role
                        </button>
                    </div>
                </div>
            </div>
            <div x-cloak>
                <!-- Background overlay -->
                <div x-show="open2" class="fixed inset-0 bg-black bg-opacity-50 z-40" x-transition.opacity
                    @click="open2 = false">
                </div>

                <!-- Modal Content -->
                <div x-show="open2"
                    class="fixed top-1/2 left-1/2 max-w-md transform -translate-x-1/2 -translate-y-1/2 bg-white p-6 rounded-lg shadow-lg z-50"
                    x-transition @keydown.escape.window="open2 = false">

                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold">Add Permission</h2>
                        <button @click="open2 = false" class="text-gray-600 hover:text-black text-xl">&times;</button>
                    </div>

                    <div class="mb-4 flex gap-x-5">
                        <x-input.input wire:model.defer="permission" name="permission"
                            placeholder="permission">Permission</x-input.input>
                    </div>

                    <div class="text-right">
                        <button @click="open2 = false" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                            Cancel
                        </button>
                        <button type="button" wire:click="addPermission()" @click="open2 = false"
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Add
                        </button>
                    </div>
                </div>
            </div>
            <div x-cloak>
                <!-- Background overlay -->
                <div x-show="open3" class="fixed inset-0 bg-black bg-opacity-50 z-40" x-transition.opacity
                    @click="open3 = false">
                </div>

                <!-- Modal Content -->
                <div x-show="open3"
                    class="fixed top-1/2 left-1/2 w-full max-w-md transform -translate-x-1/2 -translate-y-1/2 bg-white p-6 rounded-lg shadow-lg z-50"
                    x-transition @keydown.escape.window="open3 = false">

                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold">All Permissions</h2>
                        <button @click="open3 = false" class="text-gray-600 hover:text-black text-xl">&times;</button>
                    </div>

                    <div class="mb-4 flex flex-col">
                        <table class="w-full mb-5">
                            <thead>
                                <tr class="text-gray-700">
                                    <th>Sr#</th>
                                    <th>Name</th>
                                    <th class="mb-5">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($permissions as $key => $permission)
                                    <tr class="text-center">
                                        <td class="p-2">{{ $loop->iteration }}</td>
                                        <td>{{ $permission->name }}</td>
                                        <td class="flex justify-center items-center gap-x-3 h-full p-2"
                                            x-data="{ deletePermission: false }">
                                            <x-TableButton.table_button @click="deletePermission=true"
                                                bg="bg-orange-400" hover="hover:bg-orange-500">
                                                <i class="ri-delete-bin-6-line"></i>
                                            </x-TableButton.table_button>
                                            <div x-cloak wire:ignore>
                                                <!-- Background overlay -->
                                                <div x-show="deletePermission"
                                                    class="fixed inset-0 bg-black bg-opacity-50 z-40"
                                                    x-transition.opacity @click="deletePermission = false">
                                                </div>

                                                <!-- Modal Content -->
                                                <div x-show="deletePermission"
                                                    class="fixed top-1/2 left-1/2 w-full max-w-md transform -translate-x-1/2 -translate-y-1/2 bg-white p-6 rounded-lg shadow-lg z-50"
                                                    x-transition @keydown.escape.window="deletePermission = false">

                                                    <div class="flex justify-between items-center mb-4">
                                                        <h2 class="text-xl font-semibold">Delete Permission</h2>
                                                        <button @click="deletePermission = false"
                                                            class="text-gray-600 hover:text-black text-xl">&times;</button>
                                                    </div>

                                                    <div class="mb-4 text-start">
                                                        <p>Are you sure you want to delete the following permission:</p>
                                                        <p class="font-bold">{{ $permission->name }}</p>
                                                    </div>
                                                    <div class="text-right">
                                                        <button @click="deletePermission=false"
                                                            class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                                                            Cancel
                                                        </button>
                                                        <button type="button" @click="deletePermission=false"
                                                            wire:click="deletePermission('{{ $permission->id }}')"
                                                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                                            Yes
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                @endforelse

                            </tbody>
                        </table>
                        {{ $permissions->links() }}
                    </div>

                    <div class="text-right">
                        <button @click="open3 = false" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr class="text-gray-200">
    <table>
        <thead>
            <tr class="text-gray-700">
                <th>Sr#</th>
                <th>Name</th>
                <th colspan="2">Permissions</th>
                <th class="mb-5">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse ($roles as $key => $role)
                <tr class="text-center">
                    <td class="p-2">{{ $loop->iteration }}</td>
                    <td>{{ $role->name }}</td>
                    <td x-data="{ permissions: false }" colspan="2">
                        <x-TableButton.table_button @click="permissions = true" bg="bg-teal-400"
                            hover="hover:bg-teal-500">
                            <i class="ri-settings-line"></i>
                        </x-TableButton.table_button>
                        <div x-cloak>
                            <div x-show="permissions" class="fixed inset-0 bg-black bg-opacity-50 z-40"
                                x-transition.opacity @click="permissions = false">
                            </div>
                            <div x-show="permissions"
                                class="fixed top-1/2 left-1/2 w-full max-w-md transform -translate-x-1/2 -translate-y-1/2 bg-white p-6 rounded-lg shadow-lg z-50"
                                x-transition @keydown.escape.window="permissions = false">
                                <div class="flex justify-between items-center mb-4">
                                    <h2 class="text-xl font-semibold">Permissions</h2>
                                    <button @click="permissions = false"
                                        class="text-gray-600 hover:text-black text-xl">&times;</button>
                                </div>
                                <div class="mb-4 text-start">
                                    <ul>
                                        @foreach ($role->permissions as $permission)
                                            <li>{{ $permission->name }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="text-right">
                                    <button @click="permissions = false"
                                        class="px-4 py-2 bg-blue-400 rounded hover:bg-blue-500 text-white">
                                        Ok
                                    </button>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td x-data="{ deleteRole: false, editRole: false }" class="flex justify-center items-center gap-x-3 h-full p-2">
                        <x-TableButton.table_button @click="editRole=true" bg="bg-yellow-400"
                            hover="hover:bg-yellow-500">
                            <i class="ri-pencil-line"></i>
                        </x-TableButton.table_button>
                        <x-TableButton.table_button @click="deleteRole=true" bg="bg-orange-400"
                            hover="hover:bg-orange-500">
                            <i class="ri-delete-bin-6-line"></i>
                        </x-TableButton.table_button>
                        <div x-cloak>
                            <!-- Background overlay -->
                            <div x-show="editRole" class="fixed inset-0 bg-black bg-opacity-50 z-40"
                                x-transition.opacity @click="editRole=false">
                            </div>
                            <div x-show="editRole"
                                class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white p-6 rounded-lg shadow-lg z-50"
                                x-transition @keydown.escape.window="editRole=false">
                                <div class="flex justify-between items-center mb-4">
                                    <h2 class="text-xl font-semibold">Edit {{ $role->name }} Role</h2>
                                    <button @click="editRole=false"
                                        class="text-gray-600 hover:text-black text-xl">&times;</button>
                                </div>
                                <div class="space-y-4 flex gap-x-7">
                                    <div class="w-40">
                                        <p class="text-sm text-gray-600 font-medium mb-2">Current Permissions:</p>
                                        <ul
                                            class="list-disc list-inside text-gray-800 text-sm h-48 overflow-y-auto text-start">
                                            @forelse ($role->permissions as $permission)
                                                <li>{{ $permission->name }}</li>
                                            @empty
                                                <li class="text-gray-400 italic">No permissions assigned.</li>
                                            @endforelse
                                        </ul>
                                    </div>
                                    <div class="w-40">
                                        <p class="text-sm text-gray-600 font-medium mb-2">Add More Permissions:</p>
                                        <select wire:model="rolesSelection" multiple
                                            class="block w-full p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-700 h-48">
                                            @forelse ($allPermissions as $permission)
                                                @if (!$role->permissions->contains('id', $permission->id))
                                                    <option value="{{ $permission->name }}">{{ $permission->name }}
                                                    </option>
                                                @endif
                                            @empty
                                                <option disabled class="text-gray-400">No permissions available
                                                </option>
                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="w-40">
                                        <p class="text-sm text-gray-600 font-medium mb-2">Revoke Permissions:</p>
                                        <select wire:model="rolesSelectionToRemove" multiple
                                            class="block w-full p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-700 h-48">
                                            @forelse ($allPermissions as $permission)
                                                @if ($role->permissions->contains('name', $permission->name))
                                                    <option value="{{ $permission->name }}">{{ $permission->name }}
                                                    </option>
                                                @endif
                                            @empty
                                                <option disabled class="text-gray-400">No permissions available
                                                </option>
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                                <p class="mb-3">Hold Ctrl while selecting to select multiple permissions.</p>
                                <div class="text-right">
                                    <button @click="editRole=false"
                                        class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                                        Cancel
                                    </button>
                                    <button type="button" @click="editRole=false"
                                        wire:click="editRole('{{ $role->id }}')"
                                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div x-cloak>
                            <!-- Background overlay -->
                            <div x-show="deleteRole" class="fixed inset-0 bg-black bg-opacity-50 z-40"
                                x-transition.opacity @click="deleteRole=false">
                            </div>

                            <!-- Modal Content -->
                            <div x-show="deleteRole"
                                class="fixed top-1/2 left-1/2 max-w-md transform -translate-x-1/2 -translate-y-1/2 bg-white p-6 rounded-lg shadow-lg z-50"
                                x-transition @keydown.escape.window="deleteRole=false">

                                <div class="flex justify-between items-center mb-4">
                                    <h2 class="text-xl font-semibold">Delete {{ $role->name }} Role</h2>
                                    <button @click="deleteRole=false"
                                        class="text-gray-600 hover:text-black text-xl">&times;</button>
                                </div>

                                <div class="mb-4 flex gap-x-5">
                                    <p>Are you sure you want to delete this role?</p>
                                </div>
                                <i class="ri-delete-bin-2-line text-8xl text-red-400"></i>
                                <div class="text-right mt-8">
                                    <button @click="deleteRole=false"
                                        class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                                        Cancel
                                    </button>
                                    <button type="button" @click="deleteRole=false"
                                        wire:click="deleteRole('{{ $role->id }}')"
                                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @empty
            @endforelse

        </tbody>
    </table>
    {{ $roles->links() }}
</div>
