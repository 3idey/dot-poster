@props(['name', 'href' => null, 'attributes' => [], 'type' => 'submit'])

@if ($href)
    <a href="{{ $href }}"
        {{ $attributes->merge(['class' => 'bg-gradient-to-r from-emerald-600 to-emerald-700 text-white px-4 py-2 rounded-xl hover:from-emerald-700 hover:to-emerald-800 transition-all duration-300 ease-in-out inline-block text-center shadow-lg hover:shadow-xl transform hover:scale-105']) }}>
        {{ $name }}
    </a>
@else
    <button type="{{ $type }}"
        {{ $attributes->merge(['class' => 'bg-gradient-to-r from-emerald-600 to-emerald-700 text-white px-4 py-2 rounded-xl hover:from-emerald-700 hover:to-emerald-800 transition-all duration-300 ease-in-out shadow-lg hover:shadow-xl transform hover:scale-105']) }}>
        {{ $name }}
    </button>
@endif
