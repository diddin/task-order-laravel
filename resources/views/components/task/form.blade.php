@props(['task', 'networks', 'users', 'pic' => null, 'onsiteTeam' => []])

@php
    $prefix = Auth::user()->role->name; // 'admin', 'master', dll
    $actions = ['null' => 'Belum Dimulai', 'in progress' => 'Sedang Dikerjakan', 'completed' => 'Selesai'];
@endphp

<form method="POST" action="{{ $task->exists ? route($prefix . '.tasks.update', $task) : route($prefix . '.tasks.store') }}">
    @csrf
    @if($task->exists)
        @method('PUT')
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    {{-- Detail --}}
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Detail</label>
        <textarea name="detail" rows="3" class="w-full p-2 mt-1 border rounded dark:bg-gray-700 dark:text-white">{{ old('detail', $task->detail) }}</textarea>
        @error('detail') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
    </div>

    {{-- Network --}}
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">No. Jaringan</label>
        <select id="networkSelect" name="network_id" class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white">
            <option value="">-- Pilih Jaringan --</option>
            @foreach($networks as $network)
                <option 
                    value="{{ $network->id }}"
                    data-customer="{{ $network->customer->name }}"
                    {{ old('network_id', $task->network_id) == $network->id ? 'selected' : '' }}>
                    {{ $network->network_number }} : {{ $network->customer->name }} - {{ $network->customer->address }}
                </option>
            @endforeach
        </select>
        @error('network_id') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
    </div>

    {{-- PIC --}}
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">PIC</label>
        <select id="picSelect" name="pic_id" class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white">
            <option value="">-- Pilih PIC --</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}" {{ old('pic_id', $pic?->id) == $user->id ? 'selected' : '' }}>
                    {{ $user->name }}
                </option>
            @endforeach
        </select>
        @error('pic_id') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
    </div>

    {{-- Onsite Team --}}
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Tim Onsite</label>
        <select id="onsiteSelect" name="onsite_ids[]" multiple class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white">
            @foreach($users as $user)
                <option value="{{ $user->id }}" 
                    {{ in_array($user->id, old('onsite_ids', $onsiteTeam ?? [])) ? 'selected' : '' }}>
                    {{ $user->name }}
                </option>
            @endforeach
        </select>
        @error('onsite_ids') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
    </div>

    {{-- Action --}}
    <div class="mb-6">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Aksi</label>
        <select id="action" name="action" class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white">
            @foreach($actions as $key => $label)
                <option value="{{ $key }}" {{ old('action', $task->action) === $key ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
        @error('action') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
    </div>

    {{-- Submit Button --}}
    <div class="flex items-center">
        <x-primary-button>{{ $task->exists ? 'Update' : 'Buat Tiket' }}</x-primary-button>
        <a href="{{ route($prefix . '.tasks.index') }}"
            class="inline-flex items-center px-4 py-2 bg-gray-500 text-white border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ml-2">
            Kembali
        </a>
    </div>
</form>
@push('scripts')
<script>
    $(document).ready(function() {
        $('#networkSelect').select2({
            placeholder: "-- Pilih Jaringan --",
            allowClear: true
        });
        $('#picSelect').select2({
            placeholder: "-- Pilih PIC --",
            allowClear: true
        });
        $('#onsiteSelect').select2({
            placeholder: "--  Pilih Anggota Onsite -- ",
            allowClear: true,
            width: '100%' // penting agar lebarnya penuh
        });

        $('#action').select2({
            allowClear: true
        });

        // Fungsi untuk menonaktifkan opsi yang sama dengan PIC terpilih
        function disableSelectedPicInOnsite() {
            const selectedPic = $('#picSelect').val();

            $('#onsiteSelect option').each(function () {
                const optionValue = $(this).val();

                if (optionValue === selectedPic && selectedPic !== "") {
                    $(this).prop('disabled', true);
                } else {
                    $(this).prop('disabled', false);
                }
            });

            // Refresh select2 untuk menampilkan perubahan
            $('#onsiteSelect').select2();
        }

        // Jalankan fungsi saat pertama kali
        disableSelectedPicInOnsite();

        // Jalankan ulang saat PIC berubah
        $('#picSelect').on('change', disableSelectedPicInOnsite);
    });
</script>
@endpush