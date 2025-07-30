@props(['asset', 'route', 'method' => 'POST', 'portGroups' => [], 'network' => null])

<form action="{{ $route }}" id="form-asset" method="POST" enctype="multipart/form-data">
    @csrf
    @if(strtoupper($method) !== 'POST')
        @method($method)
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
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

    <div class="item-asset">
        <div class="img-asset overflow-x-auto whitespace-nowrap flex gap-1 p-0 border rounded">
            @foreach(optional($asset)->images ?? [] as $image)
                <div class="relative inline-block w-32 flex-shrink-0">
                    <img src="{{ asset('storage/' . $image->image_path) }}"
                        alt="image"
                        width="120"
                        class="cursor-pointer rounded shadow"
                        onclick="openModal('{{ asset('storage/' . $image->image_path) }}')">
                    <label class="absolute top-1 right-1 bg-red-300 text-dark text-xs px-1 py-0 rounded cursor-pointer hover:bg-red-700">
                        <input type="checkbox" name="delete_images[]" value="{{ $image->id }}" class="hidden">
                        <i class="ri-delete-bin-line"></i>
                    </label>
                </div>
            @endforeach
        </div>
        <!-- Modal -->
        <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50 hidden">
            <div class="relative">
                <img id="modalImage" src="" alt="Preview" class="max-h-screen max-w-full rounded shadow-lg">
                <button type="button" onclick="closeModal()" class="absolute top-2 right-2 bg-white text-black px-2 py-1 rounded-full shadow hover:bg-gray-200">
                    &times;
                </button>
            </div>
        </div>
        {{-- Preview images --}}
        <h4 class="mt-4">Preview</h4>
        <div class="img-asset" id="previewContainer"></div>
        
        <div class="input-file">
            <input type="file" id="fileInput" name="images[]" class="hidden" accept="image/*" multiple/>
            <label for="fileInput" class="btn-upload">Unggah Foto</label>
        </div>
        
        {{-- Hidden input to store remaining files before submit --}}
        <input type="hidden" name="fileCount" id="fileCount">

        <div class="input-group">
            @php
                $validationDate = old('validation_date', optional($asset)->validation_date);
                $formattedDate = $validationDate ? \Carbon\Carbon::parse($validationDate)->format('m/d/Y') : '';
            @endphp
            <label for="tgl_validasi">Tanggal Validasi</label>
            <input 
                type="text" 
                id="tgl_validasi" 
                name="validation_date" 
                value="{{ $formattedDate }}"
            />
        </div>
        <div class="input-group">
            <label for="waktu_pendataan">Waktu Pendataan</label>
            <input 
                type="date" 
                id="waktu_pendataan" 
                name="data_collection_time" 
                placeholder="Select date"
                value="{{ old('data_collection_time', isset($asset->data_collection_time) ? \Carbon\Carbon::parse($asset->data_collection_time)->format('Y-m-d') : '') }}"
            />
        </div>
        <div class="input-group">
            <label for="lokasi">Lokasi</label>
            <input 
                type="text" 
                id="lokasi" 
                name="location" 
                value="{{ old('location', optional($asset)->location) }}"
            />
        </div>
        <div class="input-group">
            <label for="kode_asset">Kode Data Asset</label>
            <input 
                type="text" 
                id="kode_asset" 
                name="code" 
                value="{{ old('code', optional($asset)->code) }}"
            />
        </div>
        <div class="input-group">
            <label for="nama_asset">Nama Asset</label>
            <input 
                type="text" 
                id="nama_asset" 
                name="name" 
                value="{{ old('name', optional($asset)->name) }}"
            />
        </div>
        <div class="input-group">
            <label for="label_asset">Label Asset</label>
            <input 
                type="text" 
                id="label_asset" 
                name="label" 
                value="{{ old('label', optional($asset)->label) }}"
            />
        </div>
        <div class="input-group">
            <label for="jenis_obj">Jenis Objek</label>
            <input 
                type="text" 
                id="jenis_obj" 
                name="object_type" 
                value="{{ old('object_type', optional($asset)->object_type) }}"
            />
        </div>
        <div class="input-group">
            <label for="lokasi_kontruksi">Lokasi Konstruksi</label>
            <input 
                type="text" 
                id="lokasi_kontruksi" 
                name="construction_location" 
                value="{{ old('construction_location', optional($asset)->construction_location) }}"
            />
        </div>
        <div class="input-group">
            <label for="potensi_masalah">Potensi Masalah</label>
            <textarea 
                name="potential_problem" 
                class="form-textarea w-full" 
                id="potensi_masalah"
            >{{ old('potential_problem', optional($asset)->potential_problem) }}</textarea>
            {{-- <input 
                type="text" 
                id="potensi_masalah" 
                name="potential_problem" 
                value="{{ old('potential_problem', optional($asset)->potential_problem) }}"
            /> --}}
        </div>
        <div class="input-group">
            <label for="rekomendasi_perbaikan">Rekomendasi Perbaikan</label>
            <textarea 
                name="improvement_recomendation" 
                class="form-textarea w-full" 
                id="rekomendasi_perbaikan"
            >{{ old('improvement_recomendation', optional($asset)->improvement_recomendation) }}</textarea>
            {{-- <input 
                type="text" 
                id="rekomendasi_perbaikan" 
                name="improvement_recomendation" 
                value="{{ old('improvement_recomendation', optional($asset)->improvement_recomendation) }}"
            /> --}}
        </div>
        <div class="input-group">
            <label for="penjelasan_rekomendasi_perbaikan">Penjelasan Rekomendasi Perbaikan</label>
            <textarea 
                name="detail_improvement_recomendation" 
                class="form-textarea w-full" 
                id="penjelasan_rekomendasi_perbaikan"
            >{{ old('detail_improvement_recomendation', optional($asset)->detail_improvement_recomendation) }}</textarea>
            {{-- <input 
                type="text" 
                id="penjelasan_rekomendasi_perbaikan" 
                name="detail_improvement_recomendation" 
                value="{{ old('detail_improvement_recomendation', optional($asset)->detail_improvement_recomendation) }}"
            /> --}}
        </div>
        <div class="input-group input-inline">
            <label for="pop">POP</label>
            <input 
                type="text" 
                id="pop" 
                name="pop" 
                value="{{ old('pop', optional($asset)->pop) }}"
            />
        </div>
        <div class="input-group input-inline">
            <label for="olt">OLT</label>
            <input 
                type="text" 
                id="olt" 
                name="olt" 
                value="{{ old('olt', optional($asset)->olt) }}"
            />
        </div>
        <div class="input-group input-inline">
            <label for="jumlah_port">Jumlah Port</label>
            <input 
                type="number" 
                id="jumlah_port" 
                name="number_of_ports" 
                value="{{ old('number_of_ports', optional($asset)->number_of_ports) }}" 
            />
        </div>
        <div class="input-group input-inline">
            <label for="jumlah_port_terdata">Jumlah Port Terdata</label>
            <input 
                type="number" 
                id="jumlah_port_terdata" 
                name="number_of_registered_ports" 
                value="{{ old('number_of_registered_ports', optional($asset)->number_of_registered_ports) }}"
            />
        </div>
        <div class="input-group input-inline">
            <label for="jumlah_label_terdata">Jumlah Label Terdata</label>
            <input 
                type="number" 
                id="jumlah_label_terdata" 
                name="number_of_registered_labels" 
                value="{{ old('number_of_registered_labels', optional($asset)->number_of_registered_labels) }}"
            />
        </div>
    </div>

    {{-- Looping data port: --}}
    @foreach ($portGroups as $group)
        {{-- isi loop tetap, gunakan optional($asset) --}}
        @php
            $filteredPorts = optional($asset->ports)->filter(function ($p) use ($group) {
                $portNumber = (int) filter_var($p['port'], FILTER_SANITIZE_NUMBER_INT);
                return $p['jumper_id'] && $portNumber >= $group['start'] && $portNumber <= $group['end'];
            }) ?? collect();
        @endphp

        <div class="item-asset">
            <div class="input-group" data-start="{{ $group['start'] }}" data-end="{{ $group['end'] }}">
                <label>Data Redaman & Arah Jumper Port {{ $group['start'] }}-{{ $group['end'] }}</label>
                @foreach ($filteredPorts as $port)
                    <div class="select-grid pt-2">
                        <select name="data_port[]" class="form-select">
                            @for ($i = $group['start']; $i <= $group['end']; $i++)
                                @php $portValue = $i; $portLabel = 'PORT ' .$i; @endphp
                                <option value="{{ $portValue }}" {{ intval($port['port']) === $portValue ? 'selected' : '' }}>
                                    {{ $portLabel }}
                                </option>
                            @endfor
                        </select>

                        <select name="jumper[]" class="form-select">
                            @for ($j = $group['start']; $j <= $group['end']; $j++)
                                @php $jumperLabel = $j; @endphp
                                <option value="{{ $jumperLabel }}" {{ intval($port['jumper_id']) === $jumperLabel ? 'selected' : '' }}>
                                    Jamper ke {{ $jumperLabel }}
                                </option>
                            @endfor
                        </select>
                    </div>
                @endforeach

                {{-- Jika belum ada --}}
                <div class="select-grid pt-2">
                    <select name="data_port[]" class="form-select">
                        <option value=0 selected>Pilih Data Port</option>
                        @for ($i = $group['start']; $i <= $group['end']; $i++)
                            @php $portValue = $i; $portLabel ='PORT ' .$i; @endphp
                            <option value="{{ $portValue }}">
                                {{ $portLabel }}
                            </option>
                        @endfor
                    </select>

                    <select name="jumper[]" class="form-select">
                        <option value=0 selected>Jamper ke</option>
                        @for ($j = $group['start']; $j <= $group['end']; $j++)
                            @php $jumperLabel = $j; @endphp
                            <option value="{{ $jumperLabel }}">
                                Jamper ke {{ $jumperLabel }}
                            </option>
                        @endfor
                    </select>
                </div>
                
                {{-- End jika belum ada --}}
            </div>
            <div class="flex justify-center mt-4">
                <button class="btn-secondary btn-icon" type="button">
                    <span class="ri-add-circle-fill"></span>
                    Tambah Data Port
                </button>
            </div>
        </div>
    @endforeach

    <div class="item-asset">
        <div class="input-group">
            <label for="">Label Patchcore</label>
            <div class="select-grid">
                <input 
                    type="text" 
                    name="patchcore_port_label" 
                    value="{{ old('patchcore_port_label', $asset->patchcore_port_label) }}"
                />
                <input 
                    type="text" 
                    name="patchcore_jumper_label" 
                    value="{{ old('patchcore_jumper_label', $asset->patchcore_jumper_label) }}"
                />
            </div>
        </div>
    </div>
    
    @php
        $isAdmin = Auth::user()->role->name !== 'technician';
        $networkId = isset($asset) && $asset->network 
            ? $asset->network->id 
            : (isset($network) ? $network->id : null);
    @endphp

    @if ($isAdmin)
        <div class="button-bottom fixed bottom-0 left-0 right-0 border-t bg-white z-50 lg:ml-60">
            <div class="w-full px-4 py-3">
                <div class="grid grid-cols-2 gap-4 lg:pl-40 lg:max-w-6xl lg:pr-60">
                    @if ($networkId)
                        <div class="btn-secondary justify-self-start">
                            @if(Auth::user()->role->name === 'technician')
                                <a href="{{ url()->previous() }}">BATAL</a>
                            @else
                                <a href="{{ route(Auth::user()->role->name . '.networks.show', $networkId) }}">BATAL</a>
                            @endif
                        </div>
                    @endif
                    <div class="justify-self-end">
                        <button type="submit" class="btn-primary">SIMPAN</button>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="button-bottom fixed bottom-0 left-0 right-0 border-t bg-white z-50">
            <div class="w-full px-4 py-3">
                    <div class="grid grid-cols-2 max-w-3xl px-4 gap-4 mx-auto">
                    @if ($networkId)
                        <div class="btn-secondary justify-self-start">
                            @if(Auth::user()->role->name === 'technician')
                                <a href="{{ url()->previous() }}">BATAL</a>
                            @else
                                <a href="{{ route(Auth::user()->role->name . '.networks.show', $networkId) }}">BATAL</a>
                            @endif
                        </div>
                    @endif
                    <div class="justify-self-end">
                        <button type="submit" class="btn-primary">SIMPAN</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</form>

@once
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
    
            //delete images
            document.querySelectorAll('input[type="checkbox"][name="delete_images[]"]').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const label = this.parentElement; // label dari checkbox
                    if (this.checked) {
                        label.classList.remove('bg-red-300');
                        label.classList.add('bg-red-700');
                    } else {
                        label.classList.remove('bg-red-700');
                        label.classList.add('bg-red-300');
                    }
                });
            });
    
            // upload images
            const fileInput = document.getElementById('fileInput');
            const previewContainer = document.getElementById('previewContainer');
    
            let selectedFiles = [];
    
            fileInput.addEventListener('change', function () {
                const newFiles = Array.from(fileInput.files);
    
                newFiles.forEach(file => {
                    const exists = selectedFiles.some(f => f.file.name === file.name && f.file.size === file.size);
                    if (!exists) {
                        selectedFiles.push({
                            id: Date.now() + Math.random(), // ID unik
                            file: file
                        });
                    }
                });
    
                fileInput.value = ''; // reset agar bisa pilih ulang
                renderPreviews();
            });
    
            function renderPreviews() {
                previewContainer.querySelectorAll('.img-wrapper.preview-new').forEach(el => el.remove());
    
                selectedFiles.forEach(item => {
                    const reader = new FileReader();
    
                    reader.onload = function (e) {
                        const wrapper = document.createElement('div');
                        wrapper.classList.add('img-wrapper', 'preview-new');
    
                        const img = document.createElement('img');
                        img.src = e.target.result;
    
                        const removeBtn = document.createElement('button');
                        removeBtn.innerText = '×';
                        removeBtn.classList.add('remove-btn');
                        removeBtn.addEventListener('click', function () {
                            selectedFiles = selectedFiles.filter(f => f.id !== item.id);
                            renderPreviews(); // re-render preview
                        });
    
                        wrapper.appendChild(img);
                        wrapper.appendChild(removeBtn);
                        previewContainer.appendChild(wrapper);
                    };
    
                    reader.readAsDataURL(item.file);
                });
            }
    
            // Override form submit
            document.getElementById('form-asset').addEventListener('submit', function (e) {
                e.preventDefault();
                // Cek apakah ada file yang dipilih
                if (selectedFiles.length === 0) {
                    return this.submit();
                    //alert('Belum ada file yang dipilih.');
                    //return;
                }
                // Buat DataTransfer untuk mengupdate file input
                const dt = new DataTransfer();
                // Filter dan masukkan file yang masih ada
                selectedFiles.forEach(item => dt.items.add(item.file));
                // Masukkan kembali ke file input
                fileInput.files = dt.files;
                // Optional: set count untuk pengecekan di backend
                document.getElementById('fileCount').value = dt.files.length;
                // Delay submit agar fileInput update selesai dulu
                setTimeout(() => {
                    this.submit();
                }, 20); // 20ms cukup
            });
    
            // Data Port & Jumper
            document.querySelectorAll('.item-asset .btn-secondary').forEach(button => {
                button.addEventListener('click', function (e) {
                    e.preventDefault();
                    addDataPortRow(this);
                });
            });
    
            function addDataPortRow(button) {
                const itemAsset = button.closest('.item-asset');
                const inputGroup = itemAsset.querySelector('.input-group');
                const start = parseInt(inputGroup.dataset.start);
                const end = parseInt(inputGroup.dataset.end);
    
                // Buat elemen pembungkus
                const selectGrid = document.createElement('div');
                selectGrid.classList.add('select-grid');
                selectGrid.classList.add('pt-2');
    
                // Select Data Port
                const dataSelect = document.createElement('select');
                dataSelect.name = 'data_port[]';
                dataSelect.classList.add('form-select');
                dataSelect.innerHTML = `<option value="" disabled selected>Pilih Data Port</option>`;
                for (let i = start; i <= end; i++) {
                    const label = `${i}`;
                    dataSelect.innerHTML += `<option value="${label}">PORT ${label}</option>`;
                }
    
                // Select Jumper
                const jumperSelect = document.createElement('select');
                jumperSelect.name = 'jumper[]';
                jumperSelect.classList.add('form-select');
                jumperSelect.innerHTML = `<option value="" disabled selected>Jamper ke</option>`;
                for (let i = start; i <= end; i++) {
                    const label = `${i}`;
                    jumperSelect.innerHTML += `<option value="${label}">Jamper ke ${label}</option>`;
                }
    
                // Tambahkan ke grid dan tampilkan
                selectGrid.appendChild(dataSelect);
                selectGrid.appendChild(jumperSelect);
                inputGroup.appendChild(selectGrid);
            }
        });
    
        function openModal(imageSrc) {
            const modal = document.getElementById('imageModal');
            const modalImg = document.getElementById('modalImage');
            modalImg.src = imageSrc;
            modal.classList.remove('hidden');
        }
    
        function closeModal() {
            document.getElementById('imageModal').classList.add('hidden');
        }
    
        // Tutup modal jika klik luar gambar
        document.getElementById('imageModal').addEventListener('click', function(e) {
            if (e.target.id === 'imageModal') {
                closeModal();
            }
        });
    </script>
    @endpush
@endonce
