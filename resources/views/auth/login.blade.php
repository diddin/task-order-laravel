<x-login-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="container">
        <div class="wrapper">
            {{-- <a href="#" class="justify-center avara-logo"></a> --}}
            <div class="justify-center avara-logo">
                <img src="{{ asset('images/logo.png') }}" alt="avara logo">
            </div>
            
            <div class="login-content">
                <h1>Silakan login ke akun Anda</h1>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="input-group-icon">
                        {{-- <input type="text" name="username" placeholder="Username">
                        <div class="icon ri-user-3-line"></div> --}}
                        <x-text-input id="email" class="block mt-1 w-full" 
                            type="text" 
                            name="email" 
                            :value="old('email')" required autofocus autocomplete="username"
                            placeholder="Email or Username"/>
                        
                        <div class="icon ri-user-3-line"></div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    <div class="input-group-icon">
                        <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password"
                            placeholder="Password"/>
                        
                        <div class="icon ri-eye-line cursor-pointer" id="togglePassword"></div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                    <button type="submit" class="btn-primary">LOGIN</button>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggle = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');

            toggle.addEventListener('click', function () {
                const isVisible = passwordInput.type === 'text';

                passwordInput.type = isVisible ? 'password' : 'text';

                // Ganti ikon mata (optional)
                toggle.classList.toggle('ri-eye-line', isVisible);
                toggle.classList.toggle('ri-eye-off-line', !isVisible);
            });
        });
    </script>
    @endpush
</x-login-layout>
