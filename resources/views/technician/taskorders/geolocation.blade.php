<x-dynamic-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Update Progress Tiket') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <h4 class="text-md font-semibold mb-2">Progress Timeline</h4>
            @if ($task->orders->count())
                <ul class="list-disc list-inside text-sm">
                    @foreach ($task->orders as $order)
                        <li>
                            <span class="text-gray-600 italic">{{ $order->created_at->format('d M Y H:i') }}:</span>
                            <span class="text-gray-800">{{ $order->status }}</span>
                        </li>
                    @endforeach
                </ul>
            @else
            <p class="text-sm text-gray-400">Belum ada progress tersedia.</p>
            @endif
        </div>
        <hr class="my-6 border-gray-600">
        
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                <form method="POST" action="{{ route('taskorders.store-progress', $task) }}" class="p-6 text-gray-900 dark:text-gray-100">
                    @csrf
                    @method('POST')
                    @include('technician.taskorders._progress-form', ['task' => $task])
                    <x-primary-button class="mt-4">{{ __('Kirim Progress Update') }}</x-primary-button>
                </form>
            </div>
        </div>
    </div>
    <script>
        function getLocation() {
            const status = document.getElementById('status');
    
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
    
                        document.getElementById('latitude').value = lat;
                        document.getElementById('longitude').value = lng;
                        status.textContent = "Lokasi berhasil diambil ✔️";
                        status.style.color = "green";
                    },
                    function(error) {
                        status.textContent = "Gagal mengambil lokasi ❌: " + error.message;
                        status.style.color = "red";
                    }
                );
            } else {
                status.textContent = "Browser tidak mendukung Geolocation ❌";
                status.style.color = "red";
            }
        }
    </script>
</x-dynamic-layout>
