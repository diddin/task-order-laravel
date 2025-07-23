<x-dynamic-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Aset') }}
        </h2>
    </x-slot>

    <div class="container flex-1 overflow-y-auto px-4 pb-20">
        <x-asset.form 
            :asset="$asset" 
            :route="route('assets.update', $asset)" 
            method="PUT" 
            :portGroups="$portGroups" 
        />
    </div>
</x-dynamic-layout>
