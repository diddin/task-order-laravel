@props(['announcement'])

@php
    $isUpdate = $announcement->exists ?? false;
    $prefix = Auth::user()->role->name; // 'admin' atau 'master' misalnya
@endphp

<form action="{{ $isUpdate ? route($prefix . '.announcements.update', $announcement) : route($prefix . '.announcements.store') }}" method="POST">
    @csrf
    @if($isUpdate)
        @method('PUT')
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    {{-- Judul Pengumuman --}}
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Judul</label>
        <input type="text" name="title" value="{{ old('title', $announcement->title ?? '') }}"
               class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white" placeholder="Judul pengumuman">
        @error('title')
            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
        @enderror
    </div>

    {{-- Isi Pengumuman --}}
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Isi Pengumuman</label>
        <textarea name="content" rows="4" placeholder="Tulis isi pengumuman..."
                  class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white">{{ old('content', $announcement->content ?? '') }}</textarea>
        @error('content')
            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
        @enderror
    </div>

    {{-- Tanggal Mulai --}}
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Tanggal Mulai</label>
        <input type="date" name="start_date" value="{{ old('start_date', $announcement->start_date ?? '') }}"
               class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white">
        @error('start_date')
            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
        @enderror
    </div>

    {{-- Tanggal Selesai --}}
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Tanggal Selesai</label>
        <input type="date" name="end_date" value="{{ old('end_date', $announcement->end_date ?? '') }}"
               class="w-full mt-1 p-2 border rounded dark:bg-gray-700 dark:text-white">
        @error('end_date')
            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
        @enderror
    </div>

    {{-- Aktif / Tidak --}}
    <div class="mb-6">
        <label class="inline-flex items-center">
            <input type="checkbox" name="is_active" value="1"
                {{ old('is_active', $announcement->is_active ?? true) ? 'checked' : '' }}
                class="rounded text-indigo-600 border-gray-300 focus:ring-indigo-500">
            <span class="ml-2 text-sm text-gray-700 dark:text-gray-200">Aktif</span>
        </label>
    </div>

    {{-- Tombol Aksi --}}
    <div class="flex items-center">
        <x-primary-button>
            {{ $isUpdate ? 'Update' : 'Simpan' }}
        </x-primary-button>

        <a href="{{ route($prefix . '.announcements.index') }}"
           class="inline-flex items-center px-4 py-2 bg-gray-500 text-white border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ml-2">
            Kembali
        </a>
    </div>
</form>