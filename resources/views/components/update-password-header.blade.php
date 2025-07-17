@props([
    'title' => __('Perbarui Kata Sandi'),
    'description' => __('Pastikan akun Anda menggunakan kata sandi yang panjang dan acak agar tetap aman.'),
])

<header>
    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
        {{ $title }}
    </h2>

    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
        {{ $description }}
    </p>
</header>


{{-- on child use this --}}
{{-- <x-update-password-header /> }}

{{-- ========== OR ==========}}

{{-- <x-update-password-header 
    title="Ubah Password Anda"
    description="Gunakan kombinasi huruf, angka, dan simbol untuk keamanan maksimal."
/> --}}