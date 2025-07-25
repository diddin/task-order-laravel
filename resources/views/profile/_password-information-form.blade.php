<div>
    <x-input-label for="update_password_current_password" :value="__('Kata Sandi Saat Ini')" />
    <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
    <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
</div>

<div>
    <x-input-label for="update_password_password" :value="__('Kata Sandi Baru')" />
    <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
    <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
</div>

<div>
    <x-input-label for="update_password_password_confirmation" :value="__('Konfirmasi Kata Sandi')" />
    <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
    <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
</div>

<div class="flex items-center gap-4">
    <x-primary-button>{{ __('Simpan') }}</x-primary-button>

    @if (session('status') === 'password-updated')
        <p
            x-data="{ show: true }"
            x-show="show"
            x-transition
            x-init="setTimeout(() => show = false, 2000)"
            class="text-sm text-gray-600 dark:text-gray-400"
        >{{ __('Update Berhasil.') }}</p>
    @endif
</div>