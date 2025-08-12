<x-dynamic-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Daftar Progress Tiket
        </h2>
    </x-slot>

    <div class="py-12 max-w-5xl mx-auto sm:px-6 lg:px-8">
        @if(session('success'))
            <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 2000)"
                class="pt-10 text-sm text-gray-600 dark:text-gray-400"
            >{{ session('success') }}</p>
        @endif

        <a href="{{ route('taskorders.create') }}" class="mb-4 inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            Tambah Progress Baru
        </a>

        <table class="min-w-full bg-white dark:bg-gray-800 border rounded">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">ID</th>
                    <th class="py-2 px-4 border-b">Detail Tiket</th>
                    <th class="py-2 px-4 border-b">Status</th>
                    <th class="py-2 px-4 border-b">Dibuat pada</th>
                    <th class="py-2 px-4 border-b">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($taskOrders as $order)
                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                        <td class="py-2 px-4 border-b text-center">{{ $order->id }}</td>
                        <td class="py-2 px-4 border-b">{{ $order->task->detail ?? '-' }}</td>
                        <td class="py-2 px-4 border-b">{{ $order->status }}</td>
                        <td class="py-2 px-4 border-b">{{ $order->created_at->format('d M Y H:i') }}</td>
                        <td class="py-2 px-4 border-b space-x-2">
                            <a href="{{ route('taskorders.show', $order->id) }}" class="text-blue-600 hover:underline">View</a> |
                            <a href="{{ route('taskorders.edit', $order) }}" class="text-yellow-600 hover:underline">Edit</a> |
                            <form action="{{ route('taskorders.destroy', $order) }}" method="POST" class="inline"
                                onsubmit="return confirm('Are you sure want to delete this progress?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-4 text-center text-gray-500">Tidak ada progress tiket yang ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $taskOrders->links() }}
        </div>
    </div>
</x-dynamic-layout>
