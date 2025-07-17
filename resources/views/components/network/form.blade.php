@props(['network', 'customers'])

@php
    $isUpdate = $network->exists ?? false;
    $prefix = Auth::user()->role->name; // misal 'admin' atau 'master'
@endphp

<form action="{{ $isUpdate ? route($prefix . '.networks.update', $network) : route($prefix . '.networks.store') }}" method="POST">
    @csrf
    @if($isUpdate)
        @method('PUT')
    @endif

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

    <x-primary-button>{{ $isUpdate ? 'Update' : 'Simpan' }}</x-primary-button>
</form>
