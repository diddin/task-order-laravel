<section>
    
    <x-update-password-header />

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('master.admins.update', $user) }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')
        @include('profile._profile-information-form')
    </form>
</section>
