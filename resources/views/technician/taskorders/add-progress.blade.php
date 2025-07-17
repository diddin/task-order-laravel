<x-dynamic-layout>
    <!-- content -->
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div>
    <div class="container flex-1 overflow-y-auto px-4 pb-20 sm:pb-20">
        <div class="wrapper">
            <a href="{{ route('technician.dashboard') }}" class="back-to">
                <span class="text-xl ri-arrow-left-s-line"></span>
                <span>Kembali</span>
            </a>
            <div class="content-shadow">
                <div class="detail-text">
                    <span>No. Tiket</span>
                    <p>{{ $task->task_number }}</p>
                </div>
                <h2>{{ $task->network->customer->name }}</h2>
                <div class="detail-text">
                    <span>No. Jaringan</span>
                    <p>{{ $task->network->network_number }}</p>
                </div>
                <div class="detail-text">
                    <span>Alamat</span>
                    <p>{{ $task->network->customer->address }}</p>
                </div>
                <div class="detail-text">
                    <span>Akses</span>
                    <p>Akses: {{ $task->network->access }}</p>
                </div>
                <div class="detail-text">
                    <span>Datek</span>
                    <div class="whitespace-pre-wrap border border-gray-300 p-2 w-100 min-h-[100px] font-mono bg-gray-50 overflow-y-auto">
                        <?= htmlspecialchars($task->network->data_core ?? '') ?>
                    </div>
                    {{-- <form action="" class="mt-2">
                        <div class="input-group">
                            <textarea name="data_core" class="text-left form-control" rows="8">
                                {{ old('data_core', $task->network->data_core ?? '') }}
                            </textarea>
                        </div>
                    </form> --}}
                </div>
                <div class="group-between">
                    <span class="text-gray-600">Data Asset</span>
                    <a href="{{ route('assets.show', $task->network->asset) }}" class="btn-secondary">Lihat Data Asset</a>
                </div>
                
                <div class="pic-content">
                    <h4>PIC</h4>
                    <div class="pic-item">
                        <div class="pic-name">
                            <img src="{{ asset('images/pic1.png') }}" alt="photo profile">
                            <span>Suryanto Wilogo</span>
                        </div>
                        <div class="pic-contact">
                            <a href="#" class="block text-gray-600"><span class="ri-phone-line"></span></a>
                            <a href="#" class="block text-green-700"><span class="ri-whatsapp-line"></span></a>
                        </div>
                    </div>
                    <div class="pic-item">
                        <div class="pic-name">
                            <img src="{{ asset('images/pic2.png') }}" alt="photo profile">
                            <span>Farhan Syafroni</span>
                        </div>
                        <div class="pic-contact">
                            <a href="#" class="block text-gray-600"><span class="ri-phone-line"></span></a>
                            <a href="#" class="block text-green-700"><span class="ri-whatsapp-line"></span></a>
                        </div>
                    </div>
                </div>
                <div class="pic-content">
                    <h4>Tim Onsite</h4>
                    <div class="pic-item">
                        <div class="pic-name">
                            <img src="{{ asset('images/pic3.png') }}" alt="photo profile">
                            <span>Justin Fernando</span>
                        </div>
                        <div class="pic-contact">
                            <a href="#" class="block text-gray-600"><span class="ri-phone-line"></span></a>
                            <a href="#" class="block text-green-700"><span class="ri-whatsapp-line"></span></a>
                        </div>
                    </div>
                </div>
                
                <div class="eta-footer group-between">
                    <span class="text-gray-700">ETA: 12:00</span>
                    <span class="text-red-700">{{ $task->remaining }}</span>
                </div>

                <button id="openModal" class="w-full mt-4 btn-primary">PEKERJAAN SELESAI</button>
            </div>
        </div>
        <div class="wrapper">
            <h3>Update</h3>
            <div class="content-update">
                <div class="mb-4 date">
                    {{ $task->created_at->translatedFormat('d F Y') }}
                </div>
                @foreach($task->orders as $order)
                    <div class="update-item">
                        <span class="time">
                            {{ $order->created_at->locale('id')->translatedFormat('d F Y | H:i') }}
                        </span>
                        @if ($order->image && file_exists(storage_path('app/public/' . $order->image)))
                            <img src="{{ asset('storage/' . $order->image) }}" alt="Foto Task" width="300">
                        @else
                            {{-- <p>Tidak ada gambar atau file hilang.</p> --}}
                        @endif
                        
                        {{-- <img src="{{ asset('images/update-img.png') }}" alt="update images"> --}}
                        <span>Koordinat: {{ $order->latitude }}, {{ $order->longitude }}</span>
                        <p>{{ $order->status }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    </div>
    <!-- footer -->
    <div class="avara-keyboard">
        <div class="container">
            <form action="{{ route('technician.taskorders.store-progress', $task) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Input tersembunyi -->
                <input type="hidden" id="latitude" name="latitude">
                <input type="hidden" id="longitude" name="longitude">

                <div id="map-container" style="display: none; margin-top: 10px; transition: all 0.3s ease;">
                    <div class="w-full max-w-[750] mx-auto">
                        <iframe
                            id="map-frame"
                            width="750"
                            height="400"
                            style="border:0"
                            loading="lazy"
                            allowfullscreen
                            referrerpolicy="no-referrer-when-downgrade"
                            src="https://www.google.com/maps?q=-6.200000,106.816666&hl=id&z=14&output=embed">
                        </iframe>
                    </div>
                </div>

                <!-- Preview gambar -->
                {{-- <div id="image-preview" style="margin-top: 10px;"> --}}
                <div id="image-preview" class="mt-2 relative w-max">
                    <!-- Preview akan muncul di sini -->
                </div>

                <!-- Upload gambar -->
                <input
                    type="file"
                    name="image"
                    id="image"
                    accept="image/*"
                    style="display: none;"
                    onchange="previewImage(event)"
                />

                <div class="input-group-icon">
                    <div title="Upload gambar" class="icon icon-start ri-camera-line cursor-pointer" onclick="document.getElementById('image').click()"></div>
                    <input name="status" type="text" placeholder="Tulis update disini...">
                    <button type="button" class="icon ri-map-pin-2-line pr-8" onclick="toggleMap()"></button>
                    <button type="submit" class="icon ri-send-plane-fill" style="border: none; background: none;"></button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Modal Overlay -->
    <div id="modalOverlay" class="hidden">
        <!-- Modal Container -->
        <div id="modalContainer" class="scale-95 opacity-0">            
            <h3>Terima Kasih</h3>
            <p>Anda telah menyelesaikan pekerjaan dalam waktu </p>
            <span>4 jam 12 menit</span>
            
            <!-- Modal Footer -->
            <div id="modalFooter">
                <button id="cancelBtn" class="btn-primary">
                    OKE
                </button>
            </div>
        </div>
    </div>
    
@push('scripts')
    <script>

        let userLat = null;
        let userLng = null;

        function getLocation() {
            const status = document.getElementById('map-status');

            if (!navigator.geolocation) {
                status.textContent = "Browser tidak mendukung Geolocation ❌";
                status.style.color = "red";
                return;
            }

            navigator.geolocation.getCurrentPosition(
                function (position) {
                    userLat = position.coords.latitude;
                    userLng = position.coords.longitude;

                    document.getElementById('latitude').value = userLat;
                    document.getElementById('longitude').value = userLng;

                    status.textContent = "Lokasi berhasil diambil ✔️";
                    status.style.color = "green";
                },
                function (error) {
                    status.textContent = "Gagal mengambil lokasi ❌: " + error.message;
                    status.style.color = "red";
                }
            );
        }

        function toggleMap() {
            const mapContainer = document.getElementById('map-container');
            const iframe = document.getElementById('map-frame');

            if (mapContainer.style.display === 'none' || mapContainer.style.display === '') {
                mapContainer.style.display = 'block';

                if (userLat && userLng) {
                    const zoom = 14;
                    const mapUrl = `https://www.google.com/maps?q=${userLat},${userLng}&hl=id&z=${zoom}&output=embed`;
                    iframe.src = mapUrl;
                    console.log('Map loaded:', mapUrl);
                }
            } else {
                mapContainer.style.display = 'none';
            }
        }

        setTimeout(() => {
            getLocation();
        }, 1000);

        function previewImage(event) {
            const previewContainer = document.getElementById('image-preview');
            previewContainer.innerHTML = ''; // Hapus preview lama

            const file = event.target.files[0];
            if (!file) return;

            const wrapper = document.createElement('div');
            wrapper.classList.add('relative', 'inline-block');

            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            img.style.maxWidth = '300px';
            img.style.borderRadius = '8px';
            img.alt = "Preview gambar";

            const removeBtn = document.createElement('button');
            removeBtn.innerText = '×';
            removeBtn.type = 'button';
            removeBtn.classList.add(
                'absolute', 'top-1', 'right-1', 'bg-red-500', 'text-white', 'rounded-full',
                'w-6', 'h-6', 'flex', 'items-center', 'justify-center', 'hover:bg-red-700', 'text-sm'
            );

            removeBtn.addEventListener('click', function () {
                // Kosongkan preview dan reset input file
                previewContainer.innerHTML = '';
                document.getElementById('image').value = '';
            });

            wrapper.appendChild(img);
            wrapper.appendChild(removeBtn);
            previewContainer.appendChild(wrapper);
        }

        // function previewImage(event) {
        //     const previewContainer = document.getElementById('image-preview');
        //     previewContainer.innerHTML = ''; // Kosongkan dulu preview sebelumnya

        //     const file = event.target.files[0];
        //     if (!file) return;

        //     const img = document.createElement('img');
        //     img.src = URL.createObjectURL(file);
        //     img.style.maxWidth = '300px';
        //     img.style.borderRadius = '8px';
        //     img.style.marginTop = '5px';
        //     img.alt = "Preview gambar";

        //     previewContainer.appendChild(img);
        // }
    </script>
@endpush
</x-dynamic-layout>