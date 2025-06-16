<div x-data="{
    message: '',
    classroomId: @entangle('classroomId'),
    scrollToBottom() {
        this.$nextTick(() => {
            const el = this.$refs.messages;
            if (el) el.scrollTop = el.scrollHeight;
        });
    }
}" x-init="scrollToBottom()" x-on:message-added.window="scrollToBottom()"
    class="flex flex-col bg-gray-200 rounded-md p-3 gap-y-3 flex-grow overflow-hidden">

    {{-- Messages list --}}
    <div wire:ignore id="messages" x-ref="messages" class="flex flex-col gap-y-1 overflow-y-auto flex-grow pr-1">
        @forelse ($messages as $message)
            <div class="flex flex-col bg-white shadow-md rounded py-1 px-3">
                <p class="text-start text-sm">{{ $message->message }}</p>
                <div class="text-xs text-gray-400 flex justify-between">
                    <span>{{ $message->sender }}</span>
                    <span>{{ $message->created_at->diffForHumans() }}</span>
                </div>
            </div>
        @empty
            <p class="text-lg text-gray-500 font-semibold">No Messages</p>
        @endforelse
    </div>

    {{-- Message input --}}
    <div class="flex justify-between gap-x-3 pt-2">
        <input x-model="message" placeholder="type something ..."
            @keydown.enter="
                if (message.trim()) {
                    $wire.sendMessage(message).then(() => {
                        message = '';
                        $dispatch('classroom-id-available', { classroomId });
                    });
                }
            "
            class="bg-white ps-2 px-4 w-full focus:outline-none focus:ring-2 ring-gray-500 rounded-sm shadow-sm" />

        <button
            @click="
                if (message.trim()) {
                    $wire.sendMessage(message).then(() => {
                        message = '';
                        window.dispatchEvent(new CustomEvent('message-added'));
                        $dispatch('classroom-id-available', { classroomId });
                    });
                }
            "
            wire:loading.attr="disabled"
            class="px-3 py-2 rounded-md bg-white hover:bg-gray-400 transition-all hover:text-white shadow-sm">
            <i wire:loading.remove wire:target="sendMessage" class="ri-send-plane-2-line text-xl"></i>
            <svg wire:loading wire:target="sendMessage" class="h-5 w-5 text-gray-600 animate-spin"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                    stroke-width="4" />
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z" />
            </svg>
        </button>
    </div>
</div>
