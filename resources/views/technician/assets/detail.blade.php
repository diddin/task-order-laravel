<x-dynamic-layout>
    <div class="container flex-1 overflow-y-auto px-4 pb-20">
        <div class="wrapper">
            <h3>Data Asset</h3>
            <form action="{{ route('assets.update', $asset) }}" id="form-asset" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="item-asset">
                    <div class="img-asset">
                        @foreach($asset->images ?? [] as $image)
                        <div class="relative w-32">
                            <img src="{{ asset('storage/' . $image->image_path) }}" alt="image" width="120">
                            <label class="absolute top-1 right-1 bg-red-300 text-dark text-xs px-2 py-1 rounded cursor-pointer hover:bg-red-700">
                                    <input type="checkbox" name="delete_images[]" value="{{ $image->id }}" class="hidden">
                                    <i class="ri-delete-bin-line"></i>
                                </label>
                        </div>
                        @endforeach
                        {{-- @foreach($asset->images ?? [] as $image)
                            <div class="relative w-32">
                                <input
                                    type="checkbox"
                                    name="delete_images[]"
                                    value="{{ $image->id }}"
                                    id="img_{{ $image->id }}"
                                    class="hidden peer"
                                />

                                <label for="img_{{ $image->id }}" class="block cursor-pointer relative">
                                    <img
                                        src="{{ asset('storage/' . $image->image_path) }}"
                                        class="rounded-md w-32 h-auto object-cover transition-opacity duration-300 peer-checked:opacity-40"
                                        alt="image"
                                    >

                                    <span
                                        class="absolute top-1 right-1 bg-red-300 text-dark text-xs px-2 py-1 rounded hover:bg-red-700 
                                            transition-all duration-200 
                                            peer-checked:bg-red-700 peer-checked:text-white peer-checked:font-bold"
                                    >
                                        <i class="ri-delete-bin-line"></i>
                                    </span>
                                </label>
                            </div>
                        @endforeach --}}
                    </div>

                    {{-- Preview images --}}
                    <h4 class="mt-4">Upload Preview</h4>
                    <div class="img-asset" id="previewContainer"></div>
                    
                    <div class="input-file">
                        <input type="file" id="fileInput" name="images[]" class="hidden" accept="image/*" multiple/>
                        <label for="fileInput" class="btn-upload">Upload</label>
                    </div>
                    
                    {{-- Hidden input to store remaining files before submit --}}
                    <input type="hidden" name="fileCount" id="fileCount">
                    
                    <div class="input-group">
                        @php
                            $validationDate = old('validation_date', $asset->validation_date);
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
                            value="{{ old('location', $asset->location) }}"
                        />
                    </div>
                    <div class="input-group">
                        <label for="kode_asset">Kode Data Asset</label>
                        <input 
                            type="text" 
                            id="kode_asset" 
                            name="code" 
                            value="{{ old('code', $asset->code) }}"
                        />
                    </div>
                    <div class="input-group">
                        <label for="nama_asset">Nama Asset</label>
                        <input 
                            type="text" 
                            id="nama_asset" 
                            name="name" 
                            value="{{ old('name', $asset->name) }}"
                        />
                    </div>
                    <div class="input-group">
                        <label for="label_asset">Label Asset</label>
                        <input 
                            type="text" 
                            id="label_asset" 
                            name="label" 
                            value="{{ old('label', $asset->label) }}"
                        />
                    </div>
                    <div class="input-group">
                        <label for="jenis_obj">Jenis Objek</label>
                        <input 
                            type="text" 
                            id="jenis_obj" 
                            name="object_type" 
                            value="{{ old('object_type', $asset->object_type) }}"
                        />
                    </div>
                    <div class="input-group">
                        <label for="lokasi_kontruksi">Lokasi Konstruksi</label>
                        <input 
                            type="text" 
                            id="lokasi_kontruksi" 
                            name="construction_location" 
                            value="{{ old('construction_location', $asset->construction_location) }}"
                        />
                    </div>
                    <div class="input-group">
                        <label for="potensi_masalah">Potensi Masalah</label>
                        <input 
                            type="text" 
                            id="potensi_masalah" 
                            name="potential_problem" 
                            value="{{ old('potential_problem', $asset->potential_problem) }}"
                        />
                    </div>
                    <div class="input-group">
                        <label for="rekomendasi_perbaikan">Rekomendasi Perbaikan</label>
                        <input 
                            type="text" 
                            id="rekomendasi_perbaikan" 
                            name="improvement_recomendation" 
                            value="{{ old('improvement_recomendation', $asset->improvement_recomendation) }}"
                        />
                    </div>
                    <div class="input-group">
                        <label for="penjelasan_rekomendasi_perbaikan">Penjelasan Rekomendasi Perbaikan</label>
                        <input 
                            type="text" 
                            id="penjelasan_rekomendasi_perbaikan" 
                            name="detail_improvement_recomendation" 
                            value="{{ old('detail_improvement_recomendation', $asset->detail_improvement_recomendation) }}"
                        />
                    </div>
                    <div class="input-group input-inline">
                        <label for="pop">POP</label>
                        <input 
                            type="text" 
                            id="pop" 
                            name="pop" 
                            value="{{ old('pop', $asset->pop) }}"
                        />
                    </div>
                    <div class="input-group input-inline">
                        <label for="olt">OLT</label>
                        <input 
                            type="text" 
                            id="olt" 
                            name="olt" 
                            value="{{ old('olt', $asset->olt) }}"
                        />
                    </div>
                    <div class="input-group input-inline">
                        <label for="jumlah_port">Jumlah Port</label>
                        <input 
                            type="number" 
                            id="jumlah_port" 
                            name="number_of_ports" 
                            value="{{ old('number_of_ports', $asset->number_of_ports) }}" 
                        />
                    </div>
                    <div class="input-group input-inline">
                        <label for="jumlah_port_terdata">Jumlah Port Terdata</label>
                        <input 
                            type="number" 
                            id="jumlah_port_terdata" 
                            name="number_of_registered_ports" 
                            value="{{ old('number_of_registered_ports', $asset->number_of_registered_ports) }}"
                        />
                    </div>
                    <div class="input-group input-inline">
                        <label for="jumlah_label_terdata">Jumlah Label Terdata</label>
                        <input 
                            type="number" 
                            id="jumlah_label_terdata" 
                            name="number_of_registered_labels" 
                            value="{{ old('number_of_registered_labels', $asset->number_of_registered_labels) }}"
                        />
                    </div>
                </div>
                <div class="item-asset">
                <div class="input-group">
                    <label>Data Redaman & Arah Jumper Port 1-12</label>
                    <div class="select-grid">
                        <select name="data_port" id="data_port">
                            <option value="1" selected>Data Port 1</option>
                            <option value="2">Data Port 2</option>
                            <option value="3">Data Port 3</option>
                        </select>
                        <select name="jamper" id="jamper">
                            <option value="1" selected>Jamper ke 37</option>
                            <option value="2">Jamper ke 38</option>
                            <option value="3">Jamper ke 39</option>
                        </select>
                        <select name="data_port2" id="data_port2">
                            <option value="1" disabled selected>Pilih Data Port</option>
                            <option value="2">Data Port 1</option>
                            <option value="3">Data Port 2</option>
                        </select>
                        <select name="jamper2" id="jamper2">
                            <option value="1" disabled selected>Jamper ke</option>
                            <option value="2">Data Port 1</option>
                            <option value="3">Data Port 2</option>
                        </select>                  
                    </div>
                    <div class="flex justify-center mt-4">
                    <button class="btn-secondary btn-icon">
                        <span class="ri-add-circle-fill"></span>
                        Tambah Data Port
                    </button>
                    </div>
                </div>
                </div>
                <div class="item-asset">
                <div class="input-group">
                    <label for="">Data Redaman & Arah Jumper Port 13-24</label>
                    <div class="select-grid">
                        <select name="data_port3" id="data_port3">
                            <option value="1" selected>Data Port 13</option>
                            <option value="2">Data Port 2</option>
                            <option value="3">Data Port 3</option>
                        </select>
                        <select name="jamper3" id="jamper3">
                            <option value="1" selected>Jamper ke 45</option>
                            <option value="2">Jamper ke 38</option>
                            <option value="3">Jamper ke 39</option>
                        </select>
                        <select name="data_port4" id="data_port4">
                            <option value="1" disabled selected>Pilih Data Port</option>
                            <option value="2">Data Port 1</option>
                            <option value="3">Data Port 2</option>
                        </select>
                        <select name="jamper4" id="jamper4">
                            <option value="1" disabled selected>Jamper ke</option>
                            <option value="2">Data Port 1</option>
                            <option value="3">Data Port 2</option>
                        </select>                  
                    </div>
                    <div class="flex justify-center mt-4">
                        <button class="btn-secondary btn-icon">
                            <span class="ri-add-circle-fill"></span>
                            Tambah Data Port
                        </button>
                    </div>
                </div>
                </div>
                <div class="item-asset">
                <div class="input-group">
                    <label for="">Data Redaman & Arah Jumper Port 37-44</label>
                    <div class="select-grid">
                        <select name="data_port5" id="data_port5">
                            <option value="1" selected>Data Port 37</option>
                            <option value="2">Data Port 2</option>
                            <option value="3">Data Port 3</option>
                        </select>
                        <select name="jamper5" id="jamper5">
                            <option value="1" selected>Jamper ke 1</option>
                            <option value="2">Jamper ke 38</option>
                            <option value="3">Jamper ke 39</option>
                        </select>
                        <select name="data_port6" id="data_port6">
                            <option value="1" disabled selected>Pilih Data Port</option>
                            <option value="2">Data Port 1</option>
                            <option value="3">Data Port 2</option>
                        </select>
                        <select name="jamper6" id="jamper6">
                            <option value="1" disabled selected>Jamper ke</option>
                            <option value="2">Data Port 1</option>
                            <option value="3">Data Port 2</option>
                        </select>                  
                    </div>
                    <div class="flex justify-center mt-4">
                        <button class="btn-secondary btn-icon">
                            <span class="ri-add-circle-fill"></span>
                            Tambah Data Port
                        </button>
                    </div>
                </div>
                </div>
                <div class="item-asset">
                <div class="input-group">
                    <label for="">Data Redaman & Arah Jumper Port 45-48</label>
                    <div class="select-grid">
                        <select name="data_port7" id="data_port7">
                            <option value="1" selected>Data Port 45</option>
                            <option value="2">Data Port 2</option>
                            <option value="3">Data Port 3</option>
                        </select>
                        <select name="jamper7" id="jamper7">
                            <option value="1" selected>Jamper ke 13</option>
                            <option value="2">Jamper ke 38</option>
                            <option value="3">Jamper ke 39</option>
                        </select>
                        <select name="data_port8" id="data_port8">
                            <option value="1" disabled selected>Pilih Data Port</option>
                            <option value="2">Data Port 1</option>
                            <option value="3">Data Port 2</option>
                        </select>
                        <select name="jamper8" id="jamper8">
                            <option value="1" disabled selected>Jamper ke</option>
                            <option value="2">Data Port 1</option>
                            <option value="3">Data Port 2</option>
                        </select>                  
                    </div>
                    <div class="flex justify-center mt-4">
                        <button class="btn-secondary btn-icon">
                            <span class="ri-add-circle-fill"></span>
                            Tambah Data Port
                        </button>
                    </div>
                </div>
                </div>
                <div class="item-asset">
                    <div class="input-group">
                        <label for="">Label Patchcore Port 37-44</label>
                        <div class="select-grid">
                            <select name="data_port9" id="data_port9">
                                <option value="1" selected>Label Port 37</option>
                                <option value="2">Label Port 38</option>
                                <option value="3">Label Port 39</option>
                            </select>
                            <select name="jamper9" id="jamper9">
                                <option value="1" selected>Uplink Splitter</option>
                                <option value="2">Uplink Splitter 2</option>
                                <option value="3">Uplink Splitter 3</option>
                            </select>          
                        </div>
                    </div>
                </div>
                
                <div class="button-bottom">
                    <div class="container">
                        <div class="button-content">
                        <div class="btn-secondary btn-disabled">BATAL</div>
                        <button type="submit" class="!m-0 btn-primary">SIMPAN</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@push('scripts')
    <script>
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

        // const form = document.getElementById('form-asset');
        // form.addEventListener('submit', function (e) {
        //     e.preventDefault();

        //     if (selectedFiles.length === 0) {
        //         alert('Belum ada file yang dipilih.');
        //         return;
        //     }

        //     const dt = new DataTransfer();
        //     // Filter dan masukkan file yang masih ada
        //     selectedFiles.forEach(item => dt.items.add(item.file));
        //     // Masukkan kembali ke file input
        //     fileInput.files = dt.files;
        //     // Optional: set count untuk pengecekan di backend
        //     document.getElementById('fileCount').value = dt.files.length;
        //     // cek sebelum submit
        //     console.log(fileInput.files); 
        //     // submit form SETELAH fileInput.files diisi ulang
        //     form.submit();
        // });
    </script>
@endpush
</x-dynamic-layout>