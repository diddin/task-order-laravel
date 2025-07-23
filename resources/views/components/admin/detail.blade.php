@props(['admin'])

<div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">
    <h3 class="text-lg font-semibold mb-4">Informasi Admin</h3>

    <div class="mb-3">
        <strong>Nama:</strong>
        <p>{{ $admin->name }}</p>
    </div>

    <div class="mb-3">
        <strong>Username:</strong>
        <p>{{ $admin->username }}</p>
    </div>

    <div class="mb-3">
        <strong>Email:</strong>
        <p>{{ $admin->email }}</p>
    </div>
    <div class="mb-3">
        <strong>No. Hp:</strong>
        <p>
            @if($admin->phone_number)
                {{ $admin->phone_number }}
            @endif
        </p>
    </div>

    <div class="mb-3">
        <strong>Foto Profil:</strong>
        @if ($admin->profile_image)
            <img src="{{ asset('storage/' . $admin->profile_image) }}" 
                 alt="Foto Admin" class="mt-2 h-24 w-24 rounded-full object-cover border">
        @else
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Belum mengunggah foto profil.</p>
        @endif
    </div>

    <hr class="my-6 border-gray-600">

    <div class="mt-6">
        <a href="{{ route('master.admins.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
            Kembali
        </a>
    </div>
</div>