@php
    $active_sidebar = 'Tambah Sertifikasi';
@endphp

@extends('kelola_data.base')

@section('header-base')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .max-w-100 {
            max-width: 100% !important;
        }

        label,
        .text-sm,
        input,
        select,
        textarea,
        button,
        .ts-control {
            font-size: 1.1rem !important;
        }

        /* TAB FILE STYLING */
        .tab-file {
            transition: all 0.2s ease;
            border-bottom: 4px solid transparent;
        }

        .tab-file.active {
            background-color: #0070ff !important;
            color: white !important;
            border-bottom: 4px solid #004bb3;
        }

        .tab-file.inactive {
            background-color: #f3f4f6 !important;
            color: #9ca3af !important;
        }

        .radio-card:checked+label {
            border-color: #0070ff;
            background-color: #eff6ff;
            box-shadow: 0 0 0 2px rgba(0, 112, 255, 0.2);
        }

        /* Container Grid */
        #form-grid-container {
            display: grid;
            gap: 2.5rem;
        }

        .grid-2-col {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .grid-1-col {
            grid-template-columns: repeat(1, minmax(0, 1fr));
        }
    </style>
@endsection

@section('page-name')
    <div class="flex flex-col md:flex-row items-center gap-4 px-1 pt-4 pb-4 text-[#101828]">
        <span class="font-bold text-2xl">Tambah Data Sertifikasi</span>
    </div>
@endsection

@section('content-base')
    <div class="flex flex-col gap-6 w-full max-w-100 mb-10">

        {{-- ALERT INFORMASI --}}
        @if ($errors->has('exist_sertif') || session('id_sertif_exist'))
            <div class="bg-blue-50 border-l-4 border-blue-400 p-6 rounded-xl shadow-sm mb-4 flex items-start gap-4">
                <span class="text-2xl mt-1">ℹ️</span>
                <div>
                    <h3 class="font-bold text-blue-800 text-lg">Sertifikat Terdeteksi (Sudah Terdaftar)</h3>
                    <p class="text-blue-700">
                        Data yang Anda masukkan sudah ada di sistem. Kami telah mengalihkan mode ke <b>"Pilih Existing"</b>
                        dan memilih sertifikat tersebut secara otomatis. Silakan cek kembali sertifikat yang terpilih,
                        jika sudah sesuai, silakan langsung klik <b>Simpan / Submit</b> untuk menautkan personel.
                    </p>
                </div>
            </div>
        @endif

        <x-form route="{{ route('manage.sertifikasi-dosen.store') }}" id="form-sertifikasi" enctype="multipart/form-data">

            {{-- PILIHAN TIPE --}}
            <div class="flex flex-col gap-4 p-6 bg-white border-2 border-gray-200 rounded-xl mb-6 shadow-sm">
                <label class="font-bold text-gray-800 text-lg">Tipe Keikutsertaan:</label>
                <div class="grid grid-cols-2 gap-4">
                    <input type="radio" id="type_mandiri" name="input_type" value="mandiri" class="hidden radio-card"
                        {{ old('input_type', 'mandiri') == 'mandiri' ? 'checked' : '' }}>
                    <label for="type_mandiri"
                        class="flex items-center justify-center p-5 border-2 rounded-xl cursor-pointer font-bold text-gray-700">👤
                        Mandiri</label>

                    <input type="radio" id="type_kelompok" name="input_type" value="kelompok" class="hidden radio-card"
                        {{ old('input_type') == 'kelompok' ? 'checked' : '' }}>
                    <label for="type_kelompok"
                        class="flex items-center justify-center p-5 border-2 rounded-xl cursor-pointer font-bold text-gray-700">👥
                        Berkelompok</label>
                </div>
            </div>

            <div id="form-grid-container" class="grid-2-col rounded-xl border-2 p-8 bg-white shadow-sm">

                {{-- KOLOM KIRI --}}
                <div class="flex flex-col gap-6" id="column-left">
                    {{-- Personel --}}
                    <div class="p-4 bg-blue-50/50 rounded-xl border border-blue-100 space-y-4">
                        <div class="flex justify-between items-center">
                            <label class="font-bold text-gray-800 text-lg">Personel Terlibat</label>
                            <button type="button" id="btn-reset-dosen"
                                class="text-xs font-bold text-red-600 uppercase tracking-widest hover:underline">Reset
                                Dosen</button>
                        </div>

                        {{-- Wrapper Mandiri --}}
                        <div id="wrapper-mandiri" class="{{ old('input_type', 'mandiri') == 'kelompok' ? 'hidden' : '' }}">
                            <x-islc lbl="Pilih Dosen" nm="dosen_id_single">
                                <option value="" disabled {{ old('dosen_id_single') == '' ? 'selected' : '' }}>--
                                    Pilih Dosen --</option>
                                @foreach ($all_pegawai as $pegawai)
                                    <option value="{{ $pegawai->id }}"
                                        {{ old('dosen_id_single') == $pegawai->id ? 'selected' : '' }}>
                                        {{ $pegawai->pegawai_aktif->nama_lengkap }}
                                    </option>
                                @endforeach
                            </x-islc>
                        </div>

                        {{-- Wrapper Kelompok --}}
                        <div id="wrapper-kelompok" class="{{ old('input_type') == 'kelompok' ? '' : 'hidden' }} space-y-4">
                            <div id="dosen-list-container" class="space-y-3">
                                @php
                                    $oldDosenGroup = old('dosen_id_group', ['']);
                                @endphp
                                @foreach ($oldDosenGroup as $index => $oldValue)
                                    <div class="flex gap-3 items-center dosen-row bg-white p-3 rounded-lg border shadow-sm">
                                        <div class="flex-grow">
                                            <select name="dosen_id_group[]" class="w-full border rounded-lg p-2">
                                                <option value="" disabled {{ $oldValue == '' ? 'selected' : '' }}>--
                                                    Pilih Dosen --</option>
                                                @foreach ($all_pegawai as $pegawai)
                                                    <option value="{{ $pegawai->id }}"
                                                        {{ $oldValue == $pegawai->id ? 'selected' : '' }}>
                                                        {{ $pegawai->tipe_pegawai . ' - ' . $pegawai->nama_lengkap }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <button type="button" class="remove-dosen text-red-500 p-2"><i
                                                class="fas fa-trash-alt"></i></button>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" id="add-dosen-btn"
                                class="w-full py-2 border-2 border-dashed border-blue-300 text-blue-600 rounded-lg font-bold">+
                                Tambah Personel</button>
                        </div>
                    </div>

                    {{-- Lampiran --}}
                    <div class="w-full border-2 border-gray-200 rounded-xl p-6 gap-4 flex flex-col bg-gray-50 shadow-inner">
                        <label class="font-bold text-gray-800 text-lg">Lampiran Sertifikat</label>
                        <div class="flex flex-row overflow-hidden rounded-xl border border-gray-300 bg-white">
                            <button type="button" class="tab-file flex-1 py-4 text-center font-bold active"
                                id="btn-file-baru">📁 Upload Baru</button>
                            <button type="button" class="tab-file flex-1 py-4 text-center font-bold inactive"
                                id="btn-file-existing">🔍 Pilih Existing</button>
                        </div>

                        <div id="section-file-baru" class="mt-2">
                            <x-itxt lbl="Unggah PDF" :req="false" type="file" nm="file_sertifikat"></x-itxt>
                            @if ($errors->any() && !$errors->has('exist_sertif'))
                                <p class="text-xs text-red-500 mt-1 italic">*File harus diupload ulang jika form gagal kirim
                                </p>
                            @endif
                        </div>

                        <div class="hidden flex flex-col gap-3 mt-2" id="section-file-existing">
                            @php
                                $selectedValue = old('sertifikat_id', session('id_sertif_exist'));
                            @endphp
                            <x-islc lbl="Cari Sertifikat" nm="sertifikat_id" :req="false" acom="false">
                                <option value="" disabled {{ is_null($selectedValue) ? 'selected' : '' }}>
                                    -- Pilih Dokumen --
                                </option>

                                @forelse ($all_sertifikasi as $sertifikasi)
                                    <option value="{{ $sertifikasi->id }}"
                                        {{ $selectedValue == $sertifikasi->id ? 'selected' : '' }}>
                                        {{ $sertifikasi->judul . ' - ' . $sertifikasi->nomor_registrasi }} (ID:
                                        {{ $sertifikasi->id }})
                                    </option>
                                @empty
                                    <option value="" disabled>No Data</option>
                                @endforelse
                            </x-islc>
                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN (DETAIL DATA) --}}
                <div class="flex flex-col gap-6" id="column-right">
                    <x-itxt lbl="Nomor Registrasi" nm="nomor_registrasi" value="{{ old('nomor_registrasi') }}"></x-itxt>
                    <x-itxt lbl="Judul Sertifikasi" nm="judul" value="{{ old('judul') }}"></x-itxt>

                    <div class="grid grid-cols-2 gap-4">
                        <x-islc lbl="Tipe" nm="tipe_sertifikasi">
                            <option value="Pelatihan" {{ old('tipe_sertifikasi') == 'Pelatihan' ? 'selected' : '' }}>
                                Pelatihan</option>
                            <option value="Kompetensi" {{ old('tipe_sertifikasi') == 'Kompetensi' ? 'selected' : '' }}>
                                Kompetensi</option>
                            <option value="Sertifikasi Dosen" {{ old('tipe_sertifikasi') == 'Sertifikasi Dosen' ? 'selected' : '' }}>
                                Sertifikasi Dosen</option>
                            
                        </x-islc>
                        <x-islc lbl="Metode" :req="false" nm="pelaksanaan">
                            <option value="Online" {{ old('pelaksanaan') == 'Online' ? 'selected' : '' }}>Online</option>
                            <option value="Offline" {{ old('pelaksanaan') == 'Offline' ? 'selected' : '' }}>Offline
                            </option>
                        </x-islc>
                    </div>

                    <x-itxt lbl="Biaya Pelatihan" :req="false" type="number" nm="biaya_pelatihan"
                        value="{{ old('biaya_pelatihan') }}"></x-itxt>

                    <div class="bg-gray-50 p-6 rounded-xl border-2 border-dashed border-gray-300 grid grid-cols-2 gap-4">
                        <x-itxt lbl="Tgl Mulai" :req="false" type="date" nm="tgl_berlaku_mulai"
                            value="{{ old('tgl_berlaku_mulai') }}"></x-itxt>
                        <x-itxt lbl="Tgl Berakhir" :req="false" type="date" nm="tgl_berlaku_selesai"
                            value="{{ old('tgl_berlaku_selesai') }}"></x-itxt>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <x-itxt lbl="Tgl Pelaksanaan" type="date" nm="tgl_pelaksana"
                            value="{{ old('tgl_pelaksana') }}"></x-itxt>
                        <x-itxt lbl="Tgl Terbit" type="date" nm="tgl_sertifikasi"
                            value="{{ old('tgl_sertifikasi') }}"></x-itxt>
                    </div>
                </div>
            </div>
        </x-form>
    </div>
@endsection

@push('script-under-base')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btnBaru = document.getElementById('btn-file-baru');
            const btnExisting = document.getElementById('btn-file-existing');
            const sectionBaru = document.getElementById('section-file-baru');
            const sectionExist = document.getElementById('section-file-existing');
            const gridContainer = document.getElementById('form-grid-container');
            const columnRight = document.getElementById('column-right');
            const selectExistSertif = sectionExist.querySelector('select[name="sertifikat_id"]');

            function updateUIMode(mode) {
                const allInputsRight = columnRight.querySelectorAll('input, select');
                if (mode === 'existing') {
                    btnExisting.classList.replace('inactive', 'active');
                    btnBaru.classList.replace('active', 'inactive');
                    sectionExist.classList.remove('hidden');
                    sectionBaru.classList.add('hidden');
                    columnRight.classList.add('hidden');
                    gridContainer.classList.replace('grid-2-col', 'grid-1-col');

                    allInputsRight.forEach(el => {
                        el.disabled = true;
                        el.removeAttribute('required');
                    });

                    if (selectExistSertif) {
                        selectExistSertif.disabled = false;
                        selectExistSertif.setAttribute('required', 'required');
                    }
                } else {
                    btnBaru.classList.replace('inactive', 'active');
                    btnExisting.classList.replace('active', 'inactive');
                    sectionBaru.classList.remove('hidden');
                    sectionExist.classList.add('hidden');
                    columnRight.classList.remove('hidden');
                    gridContainer.classList.replace('grid-1-col', 'grid-2-col');

                    allInputsRight.forEach(el => {
                        el.disabled = false;
                        el.setAttribute('required', 'required');
                    });

                    if (selectExistSertif) {
                        selectExistSertif.disabled = true;
                        selectExistSertif.removeAttribute('required');
                    }
                }
                updateDosenRequired();
            }

            btnBaru.addEventListener('click', () => updateUIMode('baru'));
            btnExisting.addEventListener('click', () => updateUIMode('existing'));

            const radioMandiri = document.getElementById('type_mandiri');
            const radioKelompok = document.getElementById('type_kelompok');
            const wrapperMandiri = document.getElementById('wrapper-mandiri');
            const wrapperKelompok = document.getElementById('wrapper-kelompok');

            function updateDosenRequired() {
                const selectMandiri = wrapperMandiri.querySelector('select');
                const selectsKelompok = wrapperKelompok.querySelectorAll('select');

                if (radioMandiri.checked) {
                    wrapperMandiri.classList.remove('hidden');
                    wrapperKelompok.classList.add('hidden');
                    selectMandiri.disabled = false;
                    selectMandiri.setAttribute('required', 'required');
                    selectsKelompok.forEach(s => {
                        s.disabled = true;
                        s.removeAttribute('required');
                    });
                } else {
                    wrapperMandiri.classList.add('hidden');
                    wrapperKelompok.classList.remove('hidden');
                    selectMandiri.disabled = true;
                    selectMandiri.removeAttribute('required');
                    selectsKelompok.forEach(s => {
                        s.disabled = false;
                        s.setAttribute('required', 'required');
                    });
                }
            }

            radioMandiri.addEventListener('change', updateDosenRequired);
            radioKelompok.addEventListener('change', updateDosenRequired);

            document.getElementById('add-dosen-btn').addEventListener('click', function() {
                const container = document.getElementById('dosen-list-container');
                const rows = container.querySelectorAll('.dosen-row');
                const newRow = rows[0].cloneNode(true);
                const newSelect = newRow.querySelector('select');
                newSelect.value = "";
                newSelect.disabled = false;
                container.appendChild(newRow);
                updateRemoveButtons();
                updateDosenRequired();
            });

            function updateRemoveButtons() {
                const container = document.getElementById('dosen-list-container');
                const rows = container.querySelectorAll('.dosen-row');
                rows.forEach(row => {
                    const btn = row.querySelector('.remove-dosen');
                    btn.style.display = rows.length > 1 ? 'block' : 'none';
                    btn.onclick = () => {
                        row.remove();
                        updateRemoveButtons();
                        updateDosenRequired();
                    };
                });
            }

            document.getElementById('btn-reset-dosen').addEventListener('click', function() {
                const container = document.getElementById('dosen-list-container');
                wrapperMandiri.querySelector('select').value = "";
                while (container.querySelectorAll('.dosen-row').length > 1) {
                    container.lastElementChild.remove();
                }
                container.querySelector('select').value = "";
                updateRemoveButtons();
                updateDosenRequired();
            });

            // Inisialisasi
            updateRemoveButtons();
            updateDosenRequired();

            // Logika Auto-Mode saat ada Error atau Session
            @if ($errors->has('exist_sertif') || session('id_sertif_exist') || old('sertifikat_id'))
                updateUIMode('existing');
                setTimeout(() => {
                    if (selectExistSertif) {
                        selectExistSertif.value = "{{ old('sertifikat_id', session('id_sertif_exist')) }}";
                    }
                }, 300);
            @endif
        });
    </script>
@endpush
