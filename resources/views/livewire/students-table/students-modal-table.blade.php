<div class="{{ $students->isNotEmpty() ?? 'flex flex-col gap-y-2 bg-white p-3 rounded-md' }}">
    @if ($students->isNotEmpty())
        <div class="flex justify-between items-center px-5">
            <span>Students</span>
            <div class="flex justify-end items-center gap-x-3">
                <span class="">Search</span>
                <x-input.input name="search" id="searchStudent" wire:model.live='searchStudent'
                    placeholder=""></x-input.input>
            </div>
        </div>
        <table class="w-full mt-2">
            <thead>
                <tr class="text-gray-700">
                    <th>Sr#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Joined</th>
                    @can('remove students')
                        @if ($classroom->instructor_id == auth()->id())
                            <th>Actions</th>
                        @endif
                    @endcan
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($students as $student)
                    <tr class="text-center">
                        <td class="p-2">
                            {{ ($students->currentPage() - 1) * $students->perPage() + $loop->iteration }}
                        </td>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->email }}</td>
                        <td>{{ $student->created_at->diffForHumans() }}</td>
                        @can('remove students')
                            @if ($classroom->instructor_id == auth()->id())
                                <td x-data="{ removeModal: false }" class="flex justify-center items-center gap-x-3 h-full p-2">
                                    <x-TableButton.table_button @click="removeModal=true" bg="bg-orange-400"
                                        hover="hover:bg-orange-500">
                                        <i class="ri-logout-box-r-line"></i>
                                    </x-TableButton.table_button>
                                    <div x-cloak>
                                        <!-- Background overlay -->
                                        <div x-show="removeModal" class="fixed inset-0 bg-black bg-opacity-50 z-40"
                                            x-transition.opacity @click="removeModal=false">
                                        </div>
                                        <!-- Modal Content -->
                                        <div x-show="removeModal"
                                            class="fixed top-1/2 left-1/2 max-w-md transform -translate-x-1/2 -translate-y-1/2 bg-white p-6 rounded-lg shadow-lg z-50"
                                            x-transition @keydown.escape.window="removeModal=false">
                                            <div class="flex justify-between items-center mb-4">
                                                <h2 class="text-xl font-semibold">Remove {{ $student->name }}</h2>
                                                <button @click="removeModal=false"
                                                    class="text-gray-600 hover:text-black text-xl">&times;</button>
                                            </div>
                                            <div class="my-4 flex gap-x-5">
                                                <p>Are you sure you want to remove this student?</p>
                                            </div>
                                            <i class="ri-delete-bin-2-line text-8xl text-red-400"></i>
                                            <div class="text-right mt-8">
                                                <button @click="removeModal=false"
                                                    class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                                                    Cancel
                                                </button>
                                                <button type="button" @click="removeModal=false"
                                                    wire:click="removeStudent('{{ $student->id }}')"
                                                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                                    Remove
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            @endif
                        @endcan
                    </tr>
                @empty
                @endforelse
            </tbody>
        </table>
        {{ $students->links() }}
    @endif
</div>
