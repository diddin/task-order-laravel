@props(['customer'])

@php
    $prefix = Auth::user()->role->name; // Misal: 'admin' atau 'master'
    $isUpdate = isset($customer->id);
@endphp

<form action="{{ $isUpdate ? route($prefix . '.customers.update', $customer) : route($prefix . '.customers.store') }}" method="POST">
    @csrf
    @if($isUpdate)
        @method('PUT')
    @endif

    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Nama</label>
        <input type="text" name="name" value="{{ old('name', $customer->name) }}"
               class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white" />
        @error('name') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
    </div>

    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Alamat</label>
        <textarea name="address" rows="3"
                  class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white">{{ old('address', $customer->address) }}</textarea>
        @error('address') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
    </div>

    <x-primary-button>{{ $isUpdate ? 'Update' : 'Simpan' }}</x-primary-button>
</form>
