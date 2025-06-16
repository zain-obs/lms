<div>
    <p class="mb-1 font-medium text-gray-700">{{ $slot }}</p>
    <input required="{{ $required = false }}" type="{{ $type = 'text' }}" name="{{ $name }}"
        id="{{ $name }}" placeholder="{{ $placeholder = '' }}" {{ $attributes }}
        class="bg-gray-100 ps-2 py-2 px-4 min-w-80 focus:outline-none focus:ring-2 ring-gray-500 rounded-sm shadow-sm">
</div>
