<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">No. Jaringan</label>
    <input type="text" name="network_number" value="{{ old('network_number', $network->network_number) }}"
           class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white" placeholder="e.g. 192.168.1.1">
    @error('network_number')
        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
    @enderror
</div>

<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Detail</label>
    <textarea name="detail" rows="3" class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white">{{ old('detail', $network->detail) }}</textarea>
    @error('detail')
        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
    @enderror
</div>

<div class="mb-6">
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Pelanggan</label>
    <select name="customer_id" class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white">
        <option value="">-- Pilih Pelanggan --</option>
        @foreach($customers as $customer)
            <option value="{{ $customer->id }}"
                {{ old('customer_id', $network->customer_id) == $customer->id ? 'selected' : '' }}>
                {{ $customer->name }}
            </option>
        @endforeach
    </select>
    @error('customer_id')
        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
    @enderror
</div>

<button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">
    {{ $network->exists ? 'Update' : 'Save' }}
</button>
