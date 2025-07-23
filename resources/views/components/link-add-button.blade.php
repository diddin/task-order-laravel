
@props(['href', 'text', 'prefix' => '+'])

<a href="{{ $href }}"
   class="ml-1 mb-4 inline-block bg-green-600 text-white hover:bg-green-700 px-4 py-2 rounded transition">
   {{ $prefix }} {{ $text }}
</a>