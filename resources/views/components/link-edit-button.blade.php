@props(['href', 'text' => 'Edit'])

<a href="{{ $href }}"
   {{ $attributes->merge(['class' => 'px-3 py-1 text-sm font-medium text-yellow-600 bg-yellow-100 hover:bg-yellow-200 rounded-full transition w-full sm:w-auto text-center']) }}>
    {{ $text }}
</a>