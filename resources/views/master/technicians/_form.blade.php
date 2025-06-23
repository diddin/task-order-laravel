{{-- <div class="mb-4">
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Nama</label>
    <input type="text" name="name" value="{{ old('name', $admin->name) }}"
           class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white">
    @error('name') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
</div>

<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Email</label>
    <input type="email" name="email" value="{{ old('email', $admin->email) }}"
           class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white">
    @error('email') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
</div> --}}

<!-- Name -->
<div>
    <x-input-label for="name" :value="__('Nama')" />
    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $admin->name)" required autofocus autocomplete="name" />
    <x-input-error :messages="$errors->get('name')" class="mt-2" />
</div>

<!-- Email Address -->
<div class="mt-4">
    <x-input-label for="email" :value="__('Email')" />
    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $admin->email)" required autocomplete="username" />
    <x-input-error :messages="$errors->get('email')" class="mt-2" />
</div>

<!-- Password -->
<div class="mt-4">
    <x-input-label for="password" :value="__('Password')" />

    <x-text-input id="password" class="block mt-1 w-full"
                    type="password"
                    name="password"
                    required autocomplete="new-password" />

    <x-input-error :messages="$errors->get('password')" class="mt-2" />
</div>

<!-- Confirm Password -->
<div class="mt-4">
    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

    <x-text-input id="password_confirmation" class="block mt-1 w-full"
                    type="password"
                    name="password_confirmation" required autocomplete="new-password" />

    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
</div>

<div class="flex items-center justify-end mt-4">
    {{-- <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
        {{ __('Sudah terdaftar?') }}
    </a> --}}

    <x-primary-button class="ms-4">
        {{ isset($technician->id) ? __('Update') : __('Simpan') }}
    </x-primary-button>
</div>