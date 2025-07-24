<x-dynamic-layout>
    <!-- content -->
    <div>
    <div class="container flex-1 overflow-y-auto px-4 pb-20 sm:pb-20">
        <div class="wrapper">
            <a href="{{ route('technician.dashboard') }}" class="back-to">
                <span class="text-xl ri-arrow-left-s-line"></span>
                <span>Kembali</span>
            </a>
            @if (session('error'))
                <div class="detail-text">
                    {{ session('error') }}
                </div>
            @endif
            @if (session('success'))
                <div class="detail-text">
                    {{ session('success') }}
                </div>
            @endif
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
                </div>
                {{-- <div class="group-between">
                    <span class="text-gray-600">Data Aset</span>
                    <a href="{{ route('assets.show', [$task->network->asset, $task]) }}" class="btn-secondary">Lihat Data Aset</a>
                </div> --}}
                <div class="group-between">
                    <span class="text-gray-600">Data Aset</span>
                    <a href="{{ $task->network->asset
                        ? route('assets.edit', $task->network->asset) 
                        : route('assets.create', ['network' => $task->network->id]) 
                    }}" class="btn-secondary">
                        {{ $task->network->asset ? 'Lihat Data Aset' : 'Tambah Data Aset' }}
                    </a>
                </div>

                <div class="pic-content">
                    <h4>PIC</h4>
                    <div class="pic-item">
                        <div class="pic-name">
                            <img 
                                src="{{ $task->pic()?->profile_image ? asset('storage/' . $task->pic()->profile_image) : asset('images/default-profile.png') }}" 
                                alt="photo profile"/>
                            <span>{{ $task->pic()->name }}</span>
                        </div>
                        <div class="pic-contact">
                            {{-- <a href="tel:{{ $task->pic()->phone_number }}" class="block text-gray-600">
                                <span class="ri-phone-line"></span>
                            </a> --}}
                            <a href="https://wa.me/{{ $task->pic()->phone_number }}" class="block text-green-700">
                                <span class="ri-whatsapp-line"></span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="pic-content">
                    <h4>Tim Onsite</h4>
                    @foreach ($task->onsiteTeam() as $member)
                        <div class="pic-item">
                            <div class="pic-name">
                                <img 
                                    src="{{ $member->profile_image ? asset('storage/' . $member->profile_image) : asset('images/default-profile.png') }}" 
                                    alt="photo profile"
                                    class="w-10 h-10 rounded-full object-cover"
                                />
                                <span>{{ $member->name }}</span> {{-- Sesuaikan field nama user --}}
                            </div>
                            <div class="pic-contact">
                                {{-- <a href="tel:{{ $member->phone }}" class="block text-gray-600">
                                    <span class="ri-phone-line"></span>
                                </a> --}}
                                <a href="https://wa.me/{{ $member->phone }}" class="block text-green-700">
                                    <span class="ri-whatsapp-line"></span>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="eta-footer group-between">
                    <span class="text-gray-700">
                        ETA: {{ $task->created_at->copy()->addHours(6)->format('d M Y H:i') }}
                    </span>
                    <span class="text-red-700">{{ $task->remaining }}</span>
                </div>

                <form action="{{ route('technician.task.complete', $task->id) }}" method="POST" id="completeForm">
                    @csrf
                    <button type="button" id="openModal" class="w-full mt-4 btn-primary">PEKERJAAN SELESAI</button>
                </form>
            </div>
        </div>
        <!-- Modal Overlay -->
        <div id="modalOverlay" class="fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center hidden">
            <div id="modalContainer" class="bg-white p-6 rounded-lg w-80 transform scale-95 opacity-0 transition-all duration-300">
                <h3 class="text-lg font-semibold mb-2">Terima Kasih</h3>
                <p class="text-sm text-gray-600">Anda telah menyelesaikan pekerjaan dalam waktu:</p>
                <span class="block my-3 text-xl font-bold text-green-700">{{ $task->remaining }}</span>
                
                <div class="text-right">
                    <button id="confirmComplete" class="btn-primary">OKE</button>
                </div>
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

                @error('latitude') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
                @error('longitude') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror

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

                {{-- <div class="input-group-icon">
                    <div title="Upload gambar" class="icon icon-start ri-camera-line cursor-pointer" onclick="document.getElementById('image').click()"></div>
                    <input name="status" type="text" placeholder="Tulis update disini...">
                    <button type="button" class="icon ri-map-pin-2-line pr-8" onclick="toggleMap()"></button>
                    <button type="submit" class="icon ri-send-plane-fill" style="border: none; background: none;"></button>
                </div> --}}

                <div class="flex items-center gap-2 px-3 py-2 sm:gap-3 w-full">
                    <!-- Kamera -->
                    <div title="Upload gambar"
                            class="cursor-pointer text-xl text-gray-600"
                            onclick="document.getElementById('image').click()">
                        <i class="ri-camera-line"></i>
                    </div>
                
                    <!-- Input teks -->
                    <input name="status"
                        type="text"
                        placeholder="Tulis update disini..."
                        class="flex-1 min-w-0 px-3 py-2 rounded border border-gray-300 
                            focus:outline-none focus:ring focus:ring-blue-200 text-sm" />
                    @error('status') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
                
                    <!-- Tombol Map -->
                    <button type="button"
                            class="text-xl text-blue-600 hover:text-blue-800"
                            onclick="toggleMap()">
                        <i class="ri-map-pin-2-line"></i>
                    </button>
                
                    <!-- Tombol Kirim -->
                    <button type="submit"
                            class="text-xl text-green-600 hover:text-green-800">
                        <i class="ri-send-plane-fill"></i>
                    </button>
                </div>
            </form>
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

        const openModalBtn = document.getElementById("openModal");
        const modalOverlay = document.getElementById("modalOverlay");
        const modalContainer = document.getElementById("modalContainer");
        const cancelBtn = document.getElementById("cancelBtn");
        const confirmCompleteBtn = document.getElementById("confirmComplete");
        const completeForm = document.getElementById("completeForm");

        function openModal() {
            modalOverlay.classList.remove("hidden");
            modalOverlay.classList.add("flex");
            setTimeout(() => {
                modalContainer.classList.remove("scale-95", "opacity-0");
                modalContainer.classList.add("scale-100", "opacity-100");
            }, 50);
        }

        function closeModal() {
            modalContainer.classList.remove("scale-100", "opacity-100");
            modalContainer.classList.add("scale-95", "opacity-0");
            setTimeout(() => {
                modalOverlay.classList.add("hidden");
                modalOverlay.classList.remove("flex");
            }, 300);
        }

        if (openModalBtn) openModalBtn.addEventListener("click", openModal);
        if (cancelBtn) cancelBtn.addEventListener("click", closeModal);

        if (modalOverlay) {
            modalOverlay.addEventListener("click", (e) => {
                if (e.target === modalOverlay) {
                    closeModal();
                }
            });
        }

        if (confirmCompleteBtn) {
            confirmCompleteBtn.addEventListener("click", () => {
                completeForm.submit();
            });
        }

        // Menutup modal dengan tombol ESC
        document.addEventListener("keydown", (e) => {
            if (e.key === "Escape") {
            if (!modalOverlay.classList.contains("hidden")) {
                closeModal();
            }
            }
  });
    </script>
@endpush
</x-dynamic-layout>