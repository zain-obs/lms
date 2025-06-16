<div class="flex flex-col gap-y-5 bg-white p-3 rounded-md overflow-y-auto">
    <div x-data="{ createModal: false, joinModal: false }" class="flex justify-between items-center">
        <span>Classrooms</span>
        <div class="flex gap-x-3 ml-auto">
            <button @click="joinModal = true"
                class="px-4 py-2 rounded-sm bg-gray-400 ml-auto bebas text-white transition-all hover:bg-gray-600">Join</button>
            @can('create class')
                <button @click="createModal = true"
                    class="px-4 py-2 rounded-sm bg-gray-400 ml-auto bebas text-white transition-all hover:bg-gray-600">Create</button>
            @endcan
        </div>
        <div x-cloak>
            <!-- Background overlay -->
            <div x-show="createModal" class="fixed inset-0 bg-black bg-opacity-50 z-40" x-transition.opacity
                @click="createModal = false">
            </div>
            <div x-show="createModal"
                class="fixed top-1/2 left-1/2 max-w-md transform -translate-x-1/2 -translate-y-1/2 bg-white p-6 rounded-lg shadow-lg z-50"
                x-transition @keydown.escape.window="createModal = false">

                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold">Create Classroom</h2>
                    <button @click="createModal = false" class="text-gray-600 hover:text-black text-xl">&times;</button>
                </div>

                <div class="mb-4 flex flex-col gap-y-5">
                    <x-input.input wire:model.defer="course" name="course" placeholder="course">Course</x-input.input>
                    <x-input.input wire:model.defer="section" name="section"
                        placeholder="section">Section</x-input.input>
                </div>

                <div class="text-right">
                    <button @click="createModal = false" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                        Cancel
                    </button>
                    <button type="button" wire:click="createClassroom()" @click="createModal = false"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Create
                    </button>
                </div>
            </div>
        </div>
        <div x-cloak>
            <!-- Background overlay -->
            <div x-show="joinModal" class="fixed inset-0 bg-black bg-opacity-50 z-40" x-transition.opacity
                @click="joinModal = false">
            </div>
            <div x-show="joinModal"
                class="fixed top-1/2 left-1/2 max-w-md transform -translate-x-1/2 -translate-y-1/2 bg-white p-6 rounded-lg shadow-lg z-50"
                x-transition @keydown.escape.window="joinModal = false">

                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold">Join Classroom</h2>
                    <button @click="joinModal = false" class="text-gray-600 hover:text-black text-xl">&times;</button>
                </div>

                <div class="mb-4 flex flex-col gap-y-5">
                    <x-input.input wire:model.defer="classCode" name="classCode" placeholder="classCode">Class
                        Code</x-input.input>
                </div>

                <div class="text-right">
                    <button @click="joinModal = false" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                        Cancel
                    </button>
                    <button type="button" wire:click="joinClassroom()" @click="joinModal = false"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Join
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="flex justify-start px-5">
        <div class="flex justify-end items-center gap-x-3">
            <span class="">Search</span>
            <x-input.input name="search" id="search" wire:model.live='search' placeholder=""></x-input.input>
        </div>
    </div>
    <hr class="text-gray-200">
    <table>
        <thead>
            <tr class="text-gray-700">
                <th>Sr#</th>
                <th>Course</th>
                <th>Section</th>
                <th>Instructor</th>
                <th>Created</th>
                <th class="mb-5">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse ($classrooms as $classroom)
                <tr class="text-center">
                    <td class="p-2">{{ $loop->iteration }}</td>
                    <td>{{ $classroom->course }}</td>
                    <td>{{ $classroom->section }}</td>
                    <td>{{ $classroom->instructor->id == auth()->user()->id ? 'You' : $classroom->instructor->name }}
                    </td>
                    <td>{{ $classroom->created_at->diffForHumans() }}</td>
                    <td x-effect="if(chatModal) { $nextTick(() => { $refs.messages.scrollTop = $refs.messages.scrollHeight }) }"
                        x-data="{ deleteModal: false, viewClassroom: false, chatModal: false }" class="flex justify-center items-center gap-x-3 h-full p-2">
                        <x-TableButton.table_button @click="viewClassroom=true" bg="bg-blue-400"
                            hover="hover:bg-blue-500">
                            <i class="ri-eye-line"></i>
                        </x-TableButton.table_button>
                        <x-TableButton.table_button @click="chatModal=true" bg="bg-yellow-400"
                            hover="hover:bg-yellow-500">
                            <i class="ri-message-2-line"></i>
                        </x-TableButton.table_button>
                        @can('edit class')
                            @if ($classroom->instructor_id == auth()->id())
                                <x-TableButton.table_button @click="deleteModal=true" bg="bg-orange-400"
                                    hover="hover:bg-orange-500">
                                    <i class="ri-delete-bin-6-line"></i>
                                </x-TableButton.table_button>
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
                                            <h2 class="text-xl font-semibold">Delete Classroom</h2>
                                            <button @click="deleteModal=false"
                                                class="text-gray-600 hover:text-black text-xl">&times;</button>
                                        </div>
                                        <h2 class="text-xl text-start font-semibold">{{ $classroom->course }} -
                                            {{ $classroom->section }}</h2>
                                        <div class="my-4 flex gap-x-5">
                                            <p>Are you sure you want to delete this classroom?</p>
                                        </div>
                                        <i class="ri-delete-bin-2-line text-8xl text-red-400"></i>
                                        <div class="text-right mt-8">
                                            <button @click="deleteModal=false"
                                                class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                                                Cancel
                                            </button>
                                            <button type="button" @click="deleteModal=false"
                                                wire:click="deleteClassroom('{{ $classroom->id }}')"
                                                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                                Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endcan
                        <div x-cloak>
                            <!-- Background overlay -->
                            <div x-show="viewClassroom" class="fixed inset-0 bg-black bg-opacity-50 z-40"
                                x-transition.opacity @click="viewClassroom=false">
                            </div>
                            <div x-show="viewClassroom"
                                class="fixed m-10 inset-0 bg-white p-6 rounded-lg shadow-lg z-50" x-transition
                                @keydown.escape.window="viewClassroom=false">
                                <button @click="viewClassroom=false"
                                    class="text-gray-600 hover:text-black text-xl absolute right-3 top-1">&times;</button>
                                <div class="flex justify-between gap-x-3 h-full">
                                    <div class="relative flex h-full">
                                        <img class="h-full w-auto rounded-md shadow-md"
                                            src="{{ asset('images/bg.webp') }}" alt="bg">
                                        <div
                                            class="select-none absolute inset-0 text-white m-5 shadow-md flex flex-col gap-y-5 bg-gray-100/30 backdrop-blur-md rounded-md p-3">
                                            <h1 class="text-2xl font-bold mt-8">{{ $classroom->course }}
                                            </h1>
                                            <h1 class="text-xl font-bold">{{ $classroom->section }}
                                            </h1>
                                            <h1 class="text-xl">
                                                Instructor <span
                                                    class="font-bold">{{ $classroom->instructor->name }}</span>
                                            </h1>
                                            <h1 class="text-xl">
                                                Class Code <span class="font-bold">{{ $classroom->code }}</span>
                                            </h1>
                                            <div class="w-full ps-3">
                                                {!! QrCode::size(200)->generate($classroom->code) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="w-full flex flex-col justify-between gap-y-3">
                                        <livewire:students-table.students-modal-table :classroomId="$classroom->id" />
                                        <livewire:classroom.classroom-messages :classroomId="$classroom->id" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div x-cloak>
                            <!-- Background overlay -->
                            <div x-show="chatModal" class="fixed inset-0 bg-black bg-opacity-50 z-40"
                                x-transition.opacity @click="chatModal=false">
                            </div>
                            <!-- Modal Content -->
                            <div x-show="chatModal" class="fixed inset-0 bg-white p-6 z-50 flex flex-col" x-transition
                                @keydown.escape.window="chatModal=false">
                                <div class="flex justify-between items-center mb-4">
                                    <h2 class="text-xl font-semibold">{{ $classroom->course }} -
                                        {{ $classroom->section }}</h2>
                                    <button @click="chatModal=false"
                                        class="text-gray-600 hover:text-black text-3xl">&times;</button>
                                </div>
                                <h2 class="text-xl text-start font-semibold mb-3">Class Discussion</h2>
                                <livewire:realtime-messages.realtime-messages :classroomId="$classroom->id" />
                            </div>
                        </div>
                    </td>
                </tr>
            @empty
                <span class="text-2xl text-gray-500 font-semibold">No Classrooms Joined or Created</span>
            @endforelse
        </tbody>
    </table>
    {{ $classrooms->links() }}
</div>
