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

    @if ($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <input type="hidden" name="category" value="akses" />

    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Nama Pelanggan</label>
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

    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">No. Jaringan</label>
        <input type="text" name="network_number" value="{{ old('network_number', $customer->network_number) }}"
               class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white" />
        @error('network_number') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
    </div>

    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">PIC (Nomor HP)</label>
        <input type="text" name="pic" value="{{ old('pic', $customer->pic) }}"
               class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white" />
        @error('pic') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
    </div>

    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Kontak Person</label>
        <input type="text" name="contact_person" value="{{ old('contact_person', $customer->contact_person) }}"
            class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white" />
        @error('contact_person') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
    </div>

    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Cluster</label>
        <select name="cluster"
                class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white">
            <option value="">-- Pilih Cluster --</option>
            @foreach(['BWA', 'SAST', 'CDA', 'BDA', 'SEOA', 'NEA'] as $cluster)
                <option value="{{ $cluster }}"
                    {{ old('cluster', $customer->cluster) === $cluster ? 'selected' : '' }}>
                    {{ $cluster }}
                </option>
            @endforeach
        </select>
        @error('cluster') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
    </div>

    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Data Teknis</label>
        <textarea name="technical_data" rows="4"
                  class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white">{{ old('technical_data', $customer->technical_data) }}</textarea>
        @error('technical_data') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
    </div>

    <div class="flex items-center">
        <x-primary-button>{{ $isUpdate ? 'Update' : 'Simpan' }}</x-primary-button>
        <a href="{{ route($prefix . '.customers.index') }}"
            class="inline-flex items-center px-4 py-2 bg-gray-500 text-white border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ml-2">
            Kembali
        </a>
    </div>
</form>
