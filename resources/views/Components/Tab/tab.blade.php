<div {{ $attributes }}
    class="sortable-item cursor-pointer select-none w-full bg-gray-100 py-2 px-2 rounded-md text-gray-500 hover:bg-gray-400 hover:text-white transition-all {{ $slot == $tab ? 'bg-gray-300' : 'bg-gray-100' }}">
    {{ $slot }}</div>
