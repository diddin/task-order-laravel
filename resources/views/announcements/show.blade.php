
<x-basic-layout>
    <div class="overflow-y-visible sm:overflow-y-auto max-h-none sm:max-h-[calc(100vh-120px)]">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
                {{ $announcement->title }}
            </h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Diumumkan pada {{ $announcement->created_at->format('d M Y') }}
            </p>
        </div>

        <div class="mb-6">
            <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2">Isi Pengumuman</h2>
            <div class="prose dark:prose-invert max-w-none text-gray-900 dark:text-gray-100">
                {!! nl2br(e($announcement->content)) !!}
            </div>
        </div>
        <div class="mt-6">
            <a href="{{ url()->previous() }}" class="inline-flex items-center px-4 py-2 bg-gray-700 hover:bg-gray-800 text-white text-sm font-medium rounded-md">
                ← Kembali
            </a>
        </div>
    </div>
</x-basic-layout>