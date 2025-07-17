<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Informasi Teknisi') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Perbarui informasi profil akun dan alamat email teknisi.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('master.technicians.update', $user) }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')
        @include('profile._profile-information-form')
    </form>
</section>