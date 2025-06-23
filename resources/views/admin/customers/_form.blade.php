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

<button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">
    {{ isset($customer->id) ? 'Update' : 'Save' }}
</button>
