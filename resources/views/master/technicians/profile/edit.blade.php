<x-dynamic-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Teknisi') }}
        </h2>
    </x-slot>

    <div class="flex-1 ml-64 p-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('master.technicians.profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('master.technicians.profile.partials.update-password-form')
                </div>
            </div> --}}
        </div>
    </div>
</x-dynamic-layout>
