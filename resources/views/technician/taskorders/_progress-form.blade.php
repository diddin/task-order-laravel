<div>
    <div class="mt-4">
        <x-input-label for="nama_user" :value="__('Nama')" />
        <x-text-input id="nama_user" name="nama_user" type="text" class="mt-1 block w-full" autocomplete="name" />
        {{-- :value="old('name', $technician->name)" required autofocus  --}}
        {{-- <x-input-error class="mt-2" :messages="$errors->get('name')" /> --}}
    </div>

    <div class="mt-4">
        <x-input-label for="latitude" :value="__('Latitude:')" />
        <x-text-input id="latitude" name="latitude" type="text" class="mt-1 block w-full" autocomplete="name" readonly/>
        {{-- :value="old('name', $technician->name)" required autofocus  --}}
        {{-- <x-input-error class="mt-2" :messages="$errors->get('latitude')" /> --}}
    </div>

    <div class="mt-4">
        <x-input-label for="longitude" :value="__('Longitude:')" />
        <x-text-input id="longitude" name="longitude" type="text" class="mt-1 block w-full" autocomplete="name" readonly/>
        {{-- :value="old('name', $technician->name)" required autofocus  --}}
        {{-- <x-input-error class="mt-2" :messages="$errors->get('longitude')" /> --}}
    </div>

    <x-secondary-button type="button" onclick="getLocation()" class="mt-4">{{ __('📍 Tambah Lokasi') }}</x-secondary-button>
    <p id="status" style="margin-top: 10px; color: green;"></p>
</div>
