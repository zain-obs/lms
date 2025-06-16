<button
    {{ $attributes->merge([
        'class' =>
            'bebas px-2 py-1 text-white transition-all rounded-sm ' .
            ($bg ?? 'bg-gray-500') .
            ' ' .
            ($hover ?? 'hover:bg-gray-600'),
    ]) }}>{{ $slot }}</button>
