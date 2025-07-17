<div>
    <x-input-label for="name" :value="__('Name')" />
    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
    <x-input-error class="mt-2" :messages="$errors->get('name')" />
</div>

<div>
    <x-input-label for="email" :value="__('Email')" />
    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
    <x-input-error class="mt-2" :messages="$errors->get('email')" />

    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
        <div>
            <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                {{ __('Alamat email Anda belum diverifikasi.') }}

                <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                    {{ __('Klik di sini untuk mengirim ulang email verifikasi.') }}
                </button>
            </p>

            @if (session('status') === 'verification-link-sent')
                <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                    {{ __('Tautan verifikasi baru telah dikirim ke alamat email Anda.') }}
                </p>
            @endif
        </div>
    @endif
</div>

<div>
    <x-input-label for="username" :value="__('Username')" />
    <x-text-input id="username" name="username" type="text" class="mt-1 block w-full" 
        :value="old('username', $user->username)" required autocomplete="username" />
    <x-input-error class="mt-2" :messages="$errors->get('username')" />
</div>

<div>
    <x-input-label for="phone_number" :value="__('Phone Number')" />
    <x-text-input id="phone_number" name="phone_number" type="text" class="mt-1 block w-full" :value="old('phone_number', $user->phone_number)" required autocomplete="tel" />
    <x-input-error class="mt-2" :messages="$errors->get('phone_number')" />
</div>

<div class="mt-4">
    <x-input-label for="profile_image" :value="__('Foto Profil')" />
    <input id="profile_image" name="profile_image" type="file" 
        class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
               file:rounded-full file:border-0 file:text-sm file:font-semibold
               file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
    <x-input-error class="mt-2" :messages="$errors->get('profile_image')" />

    @if ($user->profile_image && file_exists(storage_path('app/public/' . $user->profile_image)))

        <img class="mt-2" src="{{ asset('storage/' . $user->profile_image) }}" alt="Foto Task" width="300">

        <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Gambar saat ini:') }}</p>
        <div class="mt-2" id="profile-icon">
            <img src="{{ asset('storage/' . $user->profile_image) }}" 
                 alt="Profile Image" class="h-16 w-16 rounded-full mt-1 object-cover" />
        </div>
    @else
        <p>Tidak ada gambar atau file hilang.</p>
    @endif
</div>

<div class="mt-2">
    <img id="preview-image" class="h-16 w-16 rounded-full object-cover hidden" />
</div>

<div class="flex items-center gap-4">
    <x-secondary-button type="submit" class="hover:bg-gray-200">{{ __('Simpan') }}</x-secondary-button>

    @if (session('status') === 'profile-updated')
        <p
            x-data="{ show: true }"
            x-show="show"
            x-transition
            x-init="setTimeout(() => show = false, 2000)"
            class="text-sm text-gray-600 dark:text-gray-400"
        >{{ __('Update Berhasil.') }}</p>
    @endif
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