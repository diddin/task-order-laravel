@props(['href', 'text' => 'Lihat'])

<a href="{{ $href }}"
   {{ $attributes->merge(['class' => 'px-3 py-1 text-sm font-medium text-blue-600 bg-blue-100 hover:bg-blue-200 rounded-full transition w-full sm:w-auto text-center']) }}>
    {{ $text }}
</a>

{{-- <x-link-show-button :href="route('master.admins.show', $admin)" /> --}}
{{-- Atau jika kamu ingin mengganti teks: --}}
{{-- <x-link-show-button :href="route('master.admins.show', $admin)">Detail</x-link-show-button> --}}