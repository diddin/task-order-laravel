<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Nama</label>
    <input type="text" name="name" value="{{ old('name', $customer->name) }}"
           class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white">
    @error('name') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
</div>

<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Alamat</label>
    <textarea name="address"
              class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white">{{ old('address', $customer->address) }}</textarea>
    @error('address') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
</div>

<x-primary-button>{{ isset($customer->id) ? 'Update' : 'Simpan' }}</x-primary-button>
