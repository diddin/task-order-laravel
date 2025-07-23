<section>
    <x-update-profile-header title="Teknisi" content="teknisi" />

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('master.technicians.update', $user) }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')
        @include('profile._profile-information-form')
    </form>
</section>