@php
    $active_sidebar = 'Tambah Pegawai Baru';
@endphp

@extends('kelola_data.base')

@section('header-base')
    <style>
        .max-w-100 {
            max-width: 100% !important;
        }

        .nav-active {
            background-color: #2563eb; /* blue-600 tailwind */
        }

        .nav-active span {
            color: white;
        }
    </style>
@endsection

@section('page-name')
    <div class="flex flex-col md:flex-row items-center gap-[11.7px] self-stretch px-1 pt-[14.6px] pb-[13.9px]">
        <div class="flex w-full flex-col gap-[2.9px] grow">
            <div class="flex items-center gap-[5.8px] self-stretch">
                <span class="font-semibold text-2xl leading-[20.5px] text-slate-800">
                    Tambah Pegawai Baru
                </span>
            </div>
            <span class="font-normal text-sm text-slate-500 mt-1">
                Lengkapi formulir di bawah ini untuk mendaftarkan pegawai baru ke dalam sistem.
            </span>
        </div>
        <div class="flex items-center w-full justify-end gap-[11.7px]">
            {{-- <x-export-csv-tb target_id="pegawaiTable"></x-export-csv-tb> --}}
        </div>
    </div>
@endsection

@section('content-base')
    <x-form route="{{ route('manage.pegawai.create') }}" id="pegawai-input">
        
        <div class="flex flex-col gap-6">
            {{-- Data Diri --}}
            <div class="flex flex-col gap-6 w-full max-w-100 mx-auto bg-white rounded-xl shadow-sm border border-slate-200 p-6 md:p-8">
                <h2 class="text-xl font-bold text-slate-800 border-b border-slate-100 pb-3 mb-2">Data Diri Pegawai</h2>

                <div class="grid md:grid-cols-2 gap-x-8 gap-y-6">
                    {{-- Kolom Kiri --}}
                    <div class="flex flex-col gap-5">
                        <x-itxt lbl="Nama Lengkap" plc="John Doe" nm="nama_lengkap" max="100"></x-itxt>

                        <x-itxt lbl="Username" plc="johndoe" nm="username" max="20"></x-itxt>

                        <x-itxt lbl="Telepon" plc="081234567890" nm="telepon" max="13" :rules="['Harus dimulai dengan 0', 'berjumlah 10-13 digit']"></x-itxt>

                        <x-itxt lbl="No Telepon Darurat" plc="081234567890" nm="emergency_contact_phone" max="13"
                            :rules="['Harus dimulai dengan 0', 'berjumlah 10-13 digit']" :required="false"></x-itxt>

                        <x-itxt type="textarea" lbl="Alamat" plc="Jl. Telekomunikasi No. 1, Bandung" nm="alamat"
                            max="300" fill="flex-grow"></x-itxt>
                    </div>

                    {{-- Kolom Kanan --}}
                    <div class="flex flex-col gap-5">
                        <x-itxt lbl="Nomor Induk Kependudukan (NIK)" plc="3568165xxxxxxxxx" nm="nik"
                            max="20"></x-itxt>

                        <x-itxt type="email" lbl="Email Pribadi" plc="johndoe@gmail.com" nm="email_pribadi"
                            max="150"></x-itxt>

                        <x-itxt type="email" lbl="Email Institusi" plc="john.doe@telkomuniversity.ac.id" nm="email_institusi"
                            max="150"></x-itxt>

                        <x-islc lbl="Jenis Kelamin" nm="jenis_kelamin">
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </x-islc>

                        <div class="flex flex-col xl:flex-row justify-between w-full gap-4">
                            <x-itxt lbl="Tempat Lahir" fill="flex-1" plc="Surabaya" nm="tempat_lahir"></x-itxt>
                            <x-itxt type="date" fill="flex-1" lbl="Tanggal Lahir" nm="tgl_lahir" max="2025-10-27"
                                rules="none"></x-itxt>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col lg:flex-row justify-between items-start gap-6 w-full max-w-100 md:mx-auto">
                {{-- Selector Tipe Pegawai (SELALU TAMPIL) --}}
                <div class="flex flex-col gap-6 flex-1 flex-grow w-full md:mx-auto bg-white rounded-xl shadow-sm border border-slate-200 p-6 md:p-8">

                    <h2 class="text-xl font-bold text-slate-800 border-b border-slate-100 pb-3 mb-2">Data Kepegawaian</h2>

                    @php
                        $selectedType = old('tipe_pegawai', request('type') ?? 'Dosen');
                    @endphp
                    
                    <div class="grid md:grid-cols-2 gap-x-8 gap-y-6">
                        <div class="flex flex-col gap-5">
                            <x-islc lbl="Tipe Pegawai" nm="tipe_pegawai" id="tipe_pegawai" required>
                                <option value="" disabled>-- Pilih Tipe --</option>
                                <option value="Dosen" {{ $selectedType === 'Dosen' ? 'selected' : '' }}>Dosen</option>
                                <option value="TPA" {{ $selectedType === 'Tpa' ? 'selected' : '' }}>TPA</option>
                            </x-islc>

                            <x-islc lbl="Status Kepegawaian" nm="status_kepegawaian">
                                @foreach ($status_pegawai_options as $status)
                                    <option value="{{ (string) data_get($status, 'id') }}"
                                        class="opsi-kepegawaian {{ $status->tipe_pegawai }}">
                                        {{ $status->status_pegawai }}</option>
                                @endforeach
                            </x-islc>
                        </div>
                        
                        <div class="flex flex-col gap-5">
                            <x-itxt lbl="Nomor Induk Pegawai" plc="1234567890" nm="nip" max="30" :req=false></x-itxt>

                            <x-itxt type="date" lbl="Tanggal Berlaku NIP" plc="dd/mm/yyyy" nm="tmt_mulai" max="none"
                                :rules="['Silahkan masukkan tanggal pertama karyawan aktif bekerja.']"></x-itxt>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Emergency Contact --}}
            <div id="emergency-contacts" class="flex flex-col gap-4 w-full max-w-100 mx-auto bg-white rounded-xl shadow-sm border border-slate-200 p-6 md:p-8">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h2 class="text-xl font-bold text-slate-800">Emergency Contact</h2>
                    <button type="button" id="add-contact" class="px-4 py-2 bg-blue-50 text-blue-600 border border-blue-200 rounded-lg text-sm font-semibold hover:bg-blue-600 hover:text-white transition-all duration-300 active:scale-95 flex items-center gap-2 shadow-sm">
                        <i class="fas fa-plus"></i> Tambah Kontak
                    </button>
                </div>

                <div id="contacts-container" class="space-y-4"></div>
            </div>
            
            {{-- Tombol Submit form dari komponen form x-form biasanya sudah ter-handle, jika belum bisa ditambahkan disini --}}
        </div>
    </x-form>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('contacts-container');
            const addBtn = document.getElementById('add-contact');
            let index = 0;

            function contactTemplate(i) {
                return `
                        <div class="rounded-xl border border-slate-200 bg-slate-50/50 p-5 mt-4 space-y-5 shadow-sm transition-all duration-300" data-index="${i}">
                            <div class="flex items-center justify-between border-b border-slate-200/60 pb-3">
                                <span class="text-base font-bold text-slate-700 flex items-center gap-2">
                                    <i class="fas fa-address-book text-slate-400"></i> Kontak #${i + 1}
                                </span>
                                <button type="button" class="text-rose-600 bg-rose-50 border border-rose-100 hover:bg-rose-600 hover:text-white text-xs font-semibold px-3 py-1.5 rounded-lg transition-colors remove-contact">
                                    <i class="fas fa-trash-alt mr-1"></i> Hapus
                                </button>
                            </div>

                            <div class="grid md:grid-cols-2 gap-5">
                                <label class="block">
                                    <span class="block text-sm font-medium text-slate-700 mb-1.5">Nama Lengkap</span>
                                    <input type="text" name="emergency_contacts[${i}][nama_lengkap]" placeholder="Jane Doe" maxlength="100" class="border border-slate-300 bg-white p-2.5 rounded-lg w-full text-slate-700 focus:ring-2 focus:ring-blue-100 focus:border-blue-400 outline-none transition-all shadow-sm">
                                </label>

                                <label class="block">
                                    <span class="block text-sm font-medium text-slate-700 mb-1.5">Status Hubungan</span>
                                    <select name="emergency_contacts[${i}][status_hubungan]" class="border border-slate-300 bg-white p-2.5 rounded-lg w-full text-slate-700 focus:ring-2 focus:ring-blue-100 focus:border-blue-400 outline-none transition-all shadow-sm">
                                        <option value="">-- Pilih --</option>
                                        <option value="Orang Tua">Orang Tua</option>
                                        <option value="Suami/Istri">Suami/Istri</option>
                                        <option value="Saudara">Saudara</option>
                                        <option value="Teman">Teman</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                </label>

                                <label class="block">
                                    <span class="block text-sm font-medium text-slate-700 mb-1.5">Telepon</span>
                                    <input type="text" name="emergency_contacts[${i}][telepon]" placeholder="081234567890" maxlength="13" class="border border-slate-300 bg-white p-2.5 rounded-lg w-full text-slate-700 focus:ring-2 focus:ring-blue-100 focus:border-blue-400 outline-none transition-all shadow-sm">
                                </label>

                                <label class="block">
                                    <span class="block text-sm font-medium text-slate-700 mb-1.5">Email</span>
                                    <input type="email" name="emergency_contacts[${i}][email]" placeholder="jane.doe@gmail.com" maxlength="150" class="border border-slate-300 bg-white p-2.5 rounded-lg w-full text-slate-700 focus:ring-2 focus:ring-blue-100 focus:border-blue-400 outline-none transition-all shadow-sm">
                                </label>

                                <label class="block md:col-span-2">
                                    <span class="block text-sm font-medium text-slate-700 mb-1.5">Alamat</span>
                                    <textarea name="emergency_contacts[${i}][alamat]" placeholder="Jl. Telekomunikasi No. 1, Bandung" maxlength="300" class="border border-slate-300 bg-white p-2.5 rounded-lg w-full text-slate-700 focus:ring-2 focus:ring-blue-100 focus:border-blue-400 outline-none transition-all shadow-sm min-h-[80px]"></textarea>
                                </label>
                            </div>
                        </div>
                `;
            }

            function addContact() {
                container.insertAdjacentHTML('beforeend', contactTemplate(index));
                index++;
                updateRemoveButtons();
            }

            function updateRemoveButtons() {
                const removeButtons = container.querySelectorAll('.remove-contact');
                removeButtons.forEach(btn => {
                    btn.onclick = function() {
                        const block = this.closest('[data-index]');
                        // Efek transisi sebelum menghapus
                        block.style.opacity = '0';
                        block.style.transform = 'scale(0.95)';
                        setTimeout(() => {
                            block.remove();
                            renumberContacts();
                        }, 200);
                    };
                });
            }

            function renumberContacts() {
                const blocks = container.querySelectorAll('[data-index]');
                blocks.forEach((block, i) => {
                    block.setAttribute('data-index', i);
                    block.querySelector('span.text-base').innerHTML = `<i class="fas fa-address-book text-slate-400"></i> Kontak #${i + 1}`;
                    block.querySelectorAll('input, select, textarea').forEach(input => {
                        input.name = input.name.replace(/\[\d+\]/, `[${i}]`);
                    });
                });
                index = blocks.length;
            }

            addBtn.addEventListener('click', addContact);

            // default satu kontak
            addContact();
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tipePegawai = document.querySelector('select[name="tipe_pegawai"]') || document.getElementById(
                'tipe_pegawai');
            const statusKepegawaian = document.querySelector('select[name="status_kepegawaian"]');
            const dataTPA = document.getElementById('data-tpa');
            const dataDosen = document.getElementById('data-dosen');

            if (!tipePegawai || !statusKepegawaian) {
                console.warn('Elemen penting tidak ditemukan.');
                return;
            }

            function setSectionRequired(sectionEl, isRequired) {
                if (!sectionEl) return;
                const fields = sectionEl.querySelectorAll('input:not([type="hidden"]), select, textarea');
                fields.forEach(el => {
                    if (isRequired) {
                        el.setAttribute('required', 'required');
                        el.setAttribute('aria-required', 'true');
                    } else {
                        el.removeAttribute('required');
                        el.removeAttribute('aria-required');
                    }
                });
            }

            function showHideByType(type) {
                if (type === 'Dosen' && dataDosen && dataTPA) {
                    dataDosen.classList.remove('hidden');
                    dataTPA.classList.add('hidden');
                    setSectionRequired(dataDosen, true);
                    setSectionRequired(dataTPA, false);
                } else if (type === 'TPA' && dataDosen && dataTPA) {
                    dataTPA.classList.remove('hidden');
                    dataDosen.classList.add('hidden');
                    setSectionRequired(dataTPA, true);
                    setSectionRequired(dataDosen, false);
                } else if (dataDosen && dataTPA) {
                    dataTPA.classList.add('hidden');
                    dataDosen.classList.add('hidden');
                    setSectionRequired(dataTPA, false);
                    setSectionRequired(dataDosen, false);
                }
            }

            // ⬇️ FILTER TANPA MENGUBAH VALUE TERPILIH
            function filterStatusOptions(type) {
                // Pastikan statusOptions didefinisikan secara global jika dari script eksternal
                if(typeof statusOptions !== 'undefined') {
                    statusOptions.forEach(({
                        el,
                        classes
                    }) => {
                        // Biarkan placeholder (yang disabled) tetap terlihat
                        const isPlaceholder = el.disabled && el.value === '';
                        if (isPlaceholder) {
                            el.hidden = false;
                            return;
                        }

                        // Tampilkan hanya opsi yang mengandung kelas tipe (Dosen/TPA)
                        const classList = (classes || '').split(/\s+/);
                        el.hidden = !classList.includes(type);
                    });
                }
            }

            function handleTypeChange() {
                const type = tipePegawai.value;
                filterStatusOptions(type);
                showHideByType(type);
            }

            // Inisialisasi
            handleTypeChange();

            // Re-filter saat tipe pegawai berubah
            tipePegawai.addEventListener('change', handleTypeChange);
        });
        
        document.querySelectorAll(".tom-select").forEach(function(el) {
            if (!el.tomselect) {
                new TomSelect(el);
            }
        });
    </script>
    
    @if (session('error') || $errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Waduh!',
                html: "{!! session('error') ?? 'Ada Masalah pada input data Anda!' !!}",
                confirmButtonText: 'Oke, Saya Cek Lagi',
                confirmButtonColor: '#ef4444', // red-500 tailwind
                customClass: {
                    confirmButton: 'rounded-xl shadow-sm'
                }
            });
        </script>
    @endif
@endsection