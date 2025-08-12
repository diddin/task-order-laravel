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
            @if(session('success'))
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="pt-10 text-sm text-gray-600 dark:text-gray-400"
                >{{ session('success') }}</p>
            @endif
            <div class="content-shadow">
                <div class="detail-text">
                    <span>No. Tiket</span>
                    <p>{{ $task->task_number }}</p>
                </div>
                <div class="detail-text">
                    <span>Tanggal Dibuat</span>
                    <p>{{ $task->created_at->translatedFormat('d F Y') }}</p>
                </div>
                <div class="detail-text">
                    <span>Pelanggan</span>
                    <p>{{ $task->customer?->name ?? 'Backbone' }}</p>
                </div>

                <div class="detail-text">
                    <span>PIC</span>
                    <p>{{ $task->customer?->pic ?? '-' }}</p>
                </div>
                
                <div class="detail-text">
                    <span>No. Jaringan</span>
                    <p>{{ $task->customer?->network_number ?? '-' }}</p>
                </div>
                <div class="detail-text">
                    <span>Alamat</span>
                    <p>{{ $task->customer?->address ?? '-' }}</p>
                </div>
                <div class="detail-text">
                    <span>Data Teknis</span>
                    <div class="whitespace-pre-wrap border border-gray-300 p-2 w-100 min-h-[100px] font-mono bg-gray-50 overflow-y-auto">
                        <?= htmlspecialchars($task->customer->technical_data ?? '-') ?>
                    </div>
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
                    <button 
                        type="button" 
                        id="openModal" 
                        class="w-full mt-4 btn-primary" 
                        {{ $task->completed_at ? 'disabled class=btn-disabled cursor-not-allowed opacity-50' : '' }}>
                        PEKERJAAN SELESAI
                    </button>
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

                @php
                    $previousDate = null;
                @endphp

                @foreach($task->orders->sortBy('created_at') as $order)

                    @php
                        $currentDate = $order->created_at->translatedFormat('d F Y');
                    @endphp

                    @if ($currentDate !== $previousDate)
                        <div class="mb-4 date split-date">
                            {{ $currentDate }}
                        </div>
                        @php $previousDate = $currentDate; @endphp
                    @endif

                    <div class="update-item {{ $order->type === 'hold' ? 'bg-yellow-100 border-l-4 border-yellow-500' : '' }} p-4 rounded mb-4">
                        <span class="time block text-sm text-gray-500">
                            <p class="font-semibold">{{ $order->type === 'hold' ? 'Hold' : '' }}</p>
                            {{ $order->created_at->locale('id')->translatedFormat('d F Y | H:i') }}
                            <div class="text-xs text-gray-400">
                                {{ $order->created_at->diffForHumans() }}
                            </div>
                        </span>

                        @if ($order->image && file_exists(storage_path('app/public/' . $order->image)))
                            <img src="{{ asset('storage/' . $order->image) }}" alt="Foto Task" width="300" class="my-2 rounded">
                        @endif

                        <span class="block text-xs text-gray-700 mb-1">Koordinat: {{ $order->latitude }}, {{ $order->longitude }}</span>

                        <p class="text-sm text-gray-800">{{ $order->status }}</p>
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
                <input type="hidden" name="type" id="typeInput" value="progress">

                @error('latitude') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
                @error('longitude') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
                @error('status') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror

                <!-- Peta -->
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
                
                    <!-- Tombol Map -->
                    <button type="button"
                            class="text-xl text-blue-600 hover:text-blue-800"
                            onclick="toggleMap()">
                        <i class="ri-map-pin-2-line"></i>
                    </button>

                    <div class="relative inline-block text-left">
                        {{-- Tombol utama: ikon pesawat --}}
                        <button type="button" onclick="toggleDropdown()" class="text-xl text-green-600 hover:text-green-800">
                            <i class="ri-send-plane-fill"></i>
                        </button>

                        @php
                            $lastOrder = $task->orders->last();
                            $lastType = $lastOrder?->type;
                        @endphp

                        {{-- Dropdown muncul di atas tombol --}}
                        <div id="sendDropdown"
                            class="hidden absolute right-0 bottom-full mb-2 w-40 bg-white border border-gray-300 rounded shadow-lg z-50">
                           
                            {{-- Jika terakhir HOLD, hanya tampilkan RESUME --}}
                            @if ($lastType === 'hold')
                                <button type="submit" onclick="setType('resume')"
                                    class="block w-full text-left px-4 py-2 text-sm text-blue-700 hover:bg-blue-100">
                                    Lanjutkan (Resume)
                                </button>

                            {{-- Jika terakhir PROGRESS atau RESUME atau belum ada order --}}
                            @elseif (in_array($lastType, ['progress', 'resume']) || !$lastType)
                                <button type="submit" onclick="setType('progress')"
                                    class="block w-full text-left px-4 py-2 text-sm text-green-700 hover:bg-green-100">
                                    Kirim Progress
                                </button>
                                <button type="submit" onclick="setType('hold')"
                                    class="block w-full text-left px-4 py-2 text-sm text-yellow-700 hover:bg-yellow-100">
                                    Tunda (Hold)
                                </button>
                            @endif
                        </div>
                    </div>
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

        // Dropdown toggle
        function setType(type) {
            document.getElementById('typeInput').value = type;
            document.getElementById('sendDropdown').classList.add('hidden'); // auto-close dropdown
        }

        function toggleDropdown() {
            const dropdown = document.getElementById('sendDropdown');
            dropdown.classList.toggle('hidden');
        }

        // Optional: close dropdown saat klik di luar
        document.addEventListener('click', function(e) {
            const dropdown = document.getElementById('sendDropdown');
            const button = document.querySelector('button[onclick="toggleDropdown()"]');
            if (!dropdown.contains(e.target) && !button.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });

    </script>
@endpush
</x-dynamic-layout>