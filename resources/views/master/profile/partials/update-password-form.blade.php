<section>
    
    <x-update-password-header />

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')
        @include('profile._password-information-form')
    </form>
</section>
