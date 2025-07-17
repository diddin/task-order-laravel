<x-dynamic-layout>
    <div class="body-content">  
        <div class="container">
            <div class="wrapper">
                <a href="{{ route('technician.dashboard') }}" class="back-to">
                    <span class="text-xl ri-arrow-left-s-line"></span>
                    <span>Kembali</span>
                </a>
                <h3>Pemberitahuan</h3>
                <a class="content-shadow" href="{{ route('notifications.detail', ['id' => 1]) }}">
                    <span class="block mb-2 text-xs font-semibold text-gray-600">12 Juni 2025</span>
                    <h5 class="!mb-0">Kantor Pos Jaya Baru - Srengseng Sawah</h5>
                </a>
                <a class="content-shadow" href="{{ route('notifications.detail', ['id' => 2]) }}">
                    <span class="block mb-2 text-xs font-semibold text-gray-600">12 Juni 2025</span>
                    <h5 class="!mb-0">Bank BRI Permata Hijau</h5>
                </a>
                <a class="content-shadow" href="{{ route('notifications.detail', ['id' => 3]) }}">
                    <span class="block mb-2 text-xs font-semibold text-gray-600">12 Juni 2025</span>
                    <h5 class="!mb-0">Kantor Pos Jaya Baru - Srengseng Sawah</h5>
                </a>
            </div>
        </div>
    </div>
</x-dynamic-layout>