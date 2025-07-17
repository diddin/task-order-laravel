<!-- Name -->
<div>
    <x-input-label for="name" :value="__('Nama')" />
    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
    <x-input-error :messages="$errors->get('name')" class="mt-2" />
</div>

<!-- Username -->
<div class="mt-4">
    <x-input-label for="username" :value="__('Username')" />
    <x-text-input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')" required autocomplete="username" />
    <x-input-error :messages="$errors->get('username')" class="mt-2" />
</div>

<!-- Email Address -->
<div class="mt-4">
    <x-input-label for="email" :value="__('Email')" />
    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="email" />
    <x-input-error :messages="$errors->get('email')" class="mt-2" />
</div>

<!-- Phone Number -->
<div class="mt-4">
    <x-input-label for="phone_number" :value="__('Nomor Telepon')" />
    <x-text-input id="phone_number" class="block mt-1 w-full" type="text" name="phone_number" :value="old('phone_number')" required autocomplete="tel" pattern="^0[0-9]{9,14}$" />
    <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
</div>

<!-- Password -->
<div class="mt-4">
    <x-input-label for="password" :value="__('Password')" />
    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" autocomplete="new-password" />
    <x-input-error :messages="$errors->get('password')" class="mt-2" />
</div>

<!-- Confirm Password -->
<div class="mt-4">
    <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" autocomplete="new-password" />
    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
</div>

<div class="mt-2">
    <img id="preview-image" class="h-16 w-16 rounded-full object-cover hidden" />
</div>

<!-- Profile Image -->
<div class="mt-4">
    <x-input-label for="profile_image" :value="__('Foto Profil')" />
    <x-text-input id="profile_image" name="profile_image" type="file" accept="image/*"
        class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
            file:rounded-full file:border-0 file:text-sm file:font-semibold
            file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" 
    />
    <x-input-error :messages="$errors->get('profile_image')" class="mt-2" />
</div>

<div class="flex items-center justify-end mt-6">
    <x-primary-button class="ms-4">
        {{ isset($user->id) ? __('Update') : __('Simpan') }}
    </x-primary-button>
</div>
@push('scripts')
    <script>
        document.getElementById('profile_image').addEventListener('change', function (event) {
            const profileIcon = document.getElementById('profile-icon');
            const preview = document.getElementById('preview-image');
            const file = event.target.files[0];
            if (file) {
                preview.src = URL.createObjectURL(file);
                preview.classList.remove('hidden');
                profileIcon.classList.add('hidden');
            } else {
                preview.src = '';
                preview.classList.add('hidden');
            }
        });
    </script>
@endpush