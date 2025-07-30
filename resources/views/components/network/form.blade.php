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

    @if ($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">No. Jaringan</label>
        <input type="text" name="network_number" value="{{ old('network_number', $network->network_number ?? '') }}"
               class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white" placeholder="no jaringan">
        @error('network_number')
            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Detail</label>
        <textarea placeholder="detail jaringan" name="detail" rows="3"
                  class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white">{{ old('detail', $network->detail ?? '') }}</textarea>
        @error('detail')
            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Akses</label>
        <input type="text" name="access" value="{{ old('access', $network->access ?? '') }}"
               class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white" placeholder="akses jaringan">
        @error('access')
            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Data Core</label>
        <textarea placeholder="data core jaringan" name="data_core" rows="4"
                  class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white">{{ old('data_core', $network->data_core ?? '') }}</textarea>
        @error('data_core')
            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="mb-6">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Pelanggan</label>
        <select id="customer_id" name="customer_id" class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white">
            <option value="">-- Pilih Pelanggan --</option>
            @foreach($customers as $customer)
                <option value="{{ $customer->id }}"
                    {{ old('customer_id', $network->customer_id ?? '') == $customer->id ? 'selected' : '' }}>
                    {{ $customer->name }}
                </option>
            @endforeach
        </select>
        @error('customer_id')
            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="flex items-center">
        <x-primary-button>{{ $isUpdate ? 'Update' : 'Simpan' }}</x-primary-button>
        <a href="{{ route($prefix . '.networks.index') }}"
            class="inline-flex items-center px-4 py-2 bg-gray-500 text-white border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ml-2">
            Kembali
        </a>
    </div>
</form>
@push('scripts')
<script>
    $(document).ready(function() {
        $('#customer_id').select2({
            placeholder: "-- Pilih Pelanggan --",
            allowClear: true
        });
    });
</script>
@endpush
