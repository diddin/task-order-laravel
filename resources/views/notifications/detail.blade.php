<x-dynamic-layout>
    <div class="body-content">  
        <div class="container">
            <div class="wrapper">
                <a href="{{ route('notifications.index') }}" class="back-to">
                    <span class="text-xl ri-arrow-left-s-line"></span>
                    <span>Kembali</span>
                </a>
                
                <h5 class="mb-2 font-semibold text-gray-700">Pemberitahuan</h5>

                <div class="content-shadow">
                    <span class="block mb-2 text-xs font-semibold text-gray-600">
                        {{ $data->created_at->format('d F Y') }}
                    </span>

                    @if (isset($data->title))
                        {{-- Jika announcement --}}
                        <h2 class="text-lg font-bold text-gray-800">
                            {{ $data->title }}
                        </h2>
                        <p class="mt-2 text-gray-700 leading-relaxed">
                            {!! nl2br(e($data->content)) !!}
                        </p>
                    @else
                        {{-- Jika task --}}
                        <h2 class="text-lg font-bold text-gray-800 mb-2">Detail Tiket</h2>

                        <p><span class="font-semibold">Detail:</span> {{ $data->detail }}</p>
                        <p><span class="font-semibold">Jaringan:</span> {{ $data->network->network_number ?? '-' }}</p>

                        @if ($data->network && $data->network->customer)
                            <p><span class="font-semibold">Pelanggan:</span> {{ $data->network->customer->name }}</p>
                            <p><span class="font-semibold">Alamat:</span> {{ $data->network->customer->address }}</p>
                        @else
                            <p><em>Data pelanggan tidak tersedia</em></p>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-dynamic-layout>