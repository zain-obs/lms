<div class="flex gap-x-3">
    <div class="flex flex-col w-full bg-gray-200 rounded-md p-3 gap-y-3">
        <div class="h-52 overflow-y-auto flex flex-col gap-y-1">
            @if (!$messages->isEmpty())
                @foreach ($messages as $message)
                    <div class="flex flex-col bg-white shadow-md rounded py-1 px-3">
                        <p class="text-start text-sm">{{ $message->message }}</p>
                        <div class="text-xs text-gray-400 flex justify-between">
                            <span>{{ $message->sender }}</span>
                            <span>{{ $message->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="text-lg text-gray-500 font-semibold">No Messages</p>
            @endif
        </div>
        @can('create message')
            <div class="flex justify-between gap-x-3">
                <input wire:model="message" placeholder="type something ..."
                    class="bg-white ps-2 px-4 w-full focus:outline-none focus:ring-2 ring-gray-500 rounded-sm shadow-sm">

                <button wire:loading.attr="disabled" wire:click="sendMessage"
                    class="px-3 py-2 rounded-md bg-white hover:bg-gray-400 transition-all hover:text-white shadow-sm">
                    <i wire:loading.remove wire:target="sendMessage" class="ri-send-plane-2-line text-xl"></i>
                    <svg wire:loading wire:target="sendMessage" class="h-5 w-5 text-gray-600 animate-spin"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                </button>
            </div>
        @endcan
    </div>
    <div x-data="{ fileCount: 0 }" class="w-100 bg-gray-200 rounded-md p-3 flex flex-col justify-between">
        <p class="text-lg text-gray-500 font-semibold">Books</p>
        <div class="h-44 overflow-y-auto flex flex-col gap-y-1">
            @if (!$books->isEmpty())
                @foreach ($books as $book)
                    <div class="flex justify-between bg-white shadow-md rounded py-1 px-3">
                        <p class="text-start text-sm">{{ $book->name }}</p>
                        <div class="text-xs text-gray-400 flex justify-between">
                            <a target="_blank" href="{{ route('book-download', ['bookId' => $book->id]) }}">
                                <x-TableButton.table_button @click="viewClassroom=true" bg="bg-teal-400"
                                    hover="hover:bg-teal-500">
                                    <i class="ri-download-line"></i>
                                </x-TableButton.table_button>
                            </a>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="text-lg text-gray-500 font-semibold">No Content</p>
            @endif
        </div>
        @can('create book')
            <div class="flex justify-between gap-x-3">
                <button wire:loading.attr="disabled" @click="$refs.fileInput.click()"
                    class="w-full relative px-3 py-2 rounded-md bg-white hover:bg-gray-400 transition-all hover:text-white shadow-sm">
                    <i class="ri-folder-add-line text-xl"></i>
                    <input wire:model="booksToStore" wire:loading.attr="disabled"
                        @change="fileCount = $refs.fileInput.files.length;" x-ref="fileInput" type="file" class="hidden"
                        multiple />
                    <template x-if="fileCount > 0">
                        <i class="ri-check-line absolute top-1 right-1 text-green-500 font-bold -mt-0.5"></i>
                    </template>
                </button>
                <button wire:click="addBook" @click="fileCount = 0" wire:loading.attr="disabled"
                    class="w-full px-3 py-2 rounded-md bg-white hover:bg-gray-400 transition-all hover:text-white shadow-sm">
                    <i wire:loading.remove wire:target="addBook" class="ri-save-line text-xl"></i>
                    <svg wire:loading wire:target="addBook" class="h-5 w-5 text-gray-600 animate-spin"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4">
                        </circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                </button>
            </div>
        @endcan
    </div>
</div>
