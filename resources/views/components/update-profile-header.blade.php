@props(['title', 'content'])

<header>
    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
        {{ __("Informasi $title") }}
    </h2>

    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
        {{ __("Perbarui informasi profil akun dan alamat email $content.") }}
    </p>
</header>