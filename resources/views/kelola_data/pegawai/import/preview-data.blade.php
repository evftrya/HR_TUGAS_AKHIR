@php
    $active_sidebar = 'Tambah Pegawai Baru';
@endphp

@extends('kelola_data.base')

@section('title-page')
    {{ $active_sidebar }}
@endsection

@section('header-base')
@endsection

@section('page-name')
    Validasi Data import
@endsection

@section('content-base')
    <form action="{{ route('manage.pegawai.import.save-data')}}" enctype="multipart/form-data" method="POST" class="flex flex-grow-0 flex-col gap-2 max-w-100">
        @csrf
        <div class="rounded-lg border border-amber-200 bg-amber-50 p-4 text-amber-900">
            <div class="flex items-start gap-3">
                <div class="mt-0.5 flex h-9 w-9 items-center justify-center rounded-full bg-amber-100 text-amber-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M8.257 3.099c.765-1.36 2.72-1.36 3.485 0l6.518 11.59c.75 1.334-.214 2.986-1.742 2.986H3.48c-1.528 0-2.492-1.652-1.742-2.986L8.257 3.1zM11 14a1 1 0 10-2 0 1 1 0 002 0zm-1-2a1 1 0 01-1-1V8a1 1 0 012 0v3a1 1 0 01-1 1z"
                            clip-rule="evenodd" />
                    </svg>
                </div>

                <div class="min-w-0">
                    <h3 class="text-base font-semibold leading-6">
                        Silahkan cek lagi data Anda
                    </h3>
                    <p class="mt-1 text-sm text-amber-800">
                        Ini adalah validasi untuk yang terakhir kalinya.
                    </p>

                    <ul class="mt-3 space-y-2 text-sm text-amber-900">
                        <li class="flex gap-2">
                            <span class="mt-1 inline-block h-2 w-2 shrink-0 rounded-full bg-red-500"></span>
                            <span>
                                Silahkan isi data yang masih <b>Kosong</b>
                                (ditandai berwarna <span class="font-semibold text-red-600">merah</span>).
                            </span>
                        </li>

                        <li class="flex gap-2">
                            <span class="mt-1 inline-block h-2 w-2 shrink-0 rounded-full bg-amber-500"></span>
                            <span>
                                Cara edit: klik data, maka Anda akan bisa mengeditnya.
                            </span>
                        </li>

                        <!-- 🔥 TAMBAHAN BARU -->
                        <li class="flex gap-2">
                            <span class="mt-1 inline-block h-2 w-2 shrink-0 rounded-full bg-sky-500"></span>
                            <span>
                                Jika sudah memvalidasi dan melengkapi seluruh data,
                                silahkan menuju ke <b>bagian paling bawah halaman</b> dan
                                klik tombol
                                <a href="#import-data-btn"
                                    class="font-semibold text-sky-600 underline underline-offset-2 hover:text-sky-700">
                                    Import Data Sekarang
                                </a>.
                            </span>
                        </li>
                    </ul>

                    <div class="mt-4 flex flex-wrap gap-2">
                        <span
                            class="inline-flex items-center gap-2 rounded-full bg-white px-3 py-1
                           text-xs font-medium text-amber-900 ring-1 ring-amber-200">
                            <span class="inline-block h-2 w-2 rounded-full bg-red-500"></span>
                            Kosong = merah
                        </span>

                        <span
                            class="inline-flex items-center gap-2 rounded-full bg-white px-3 py-1
                           text-xs font-medium text-amber-900 ring-1 ring-amber-200">
                            <span class="inline-block h-2 w-2 rounded-full bg-amber-500"></span>
                            Klik untuk edit
                        </span>
                    </div>
                </div>
            </div>
        </div>



        <x-tb id="formasiTable" search_status=false>
            <x-slot:table_header>
                <x-tb-td nama="nama_lengkap" >Nama Lengkap*</x-tb-td>
                <x-tb-td nama="nik" >Nomor Induk Kependudukan*</x-tb-td>
                <x-tb-td nama="username" >Username*</x-tb-td>
                <x-tb-td nama="telepon" >Telepon*</x-tb-td>
                <x-tb-td nama="email_pribadi" >Email Pribadi*</x-tb-td>
                <x-tb-td nama="email_institusi" >Email Institusi*</x-tb-td>
                <x-tb-td nama="no_telepon_darurat" >No Telepon Darurat*</x-tb-td>
                <x-tb-td nama="jenis_kelamin" >Jenis Kelamin*</x-tb-td>
                <x-tb-td nama="alamat" >Alamat*</x-tb-td>
                <x-tb-td nama="tempat_lahir" >Tempat Lahir*</x-tb-td>
                <x-tb-td nama="tanggal_lahir" >Tanggal Lahir (hh/bb/tttt)*</x-tb-td>
                <x-tb-td nama="tipe_pegawai" >Tipe Pegawai*</x-tb-td>
                <x-tb-td nama="status_kepegawaian" >Status Kepegawaian*</x-tb-td>
                <x-tb-td nama="nip">NIP*</x-tb-td>
                <x-tb-td nama="tanggal_berlaku_nip" >Tanggal Berlaku NIP (hh/bb/tttt)</x-tb-td>

                <x-tb-td nama="ec1_status_hubungan" >Emergency Contact 1 (Status Hubungan)</x-tb-td>
                <x-tb-td nama="ec1_nama_lengkap" >Emergency Contact 1 (Nama Lengkap)</x-tb-td>
                <x-tb-td nama="ec1_telepon" >Emergency Contact 1 (Telepon)</x-tb-td>
                <x-tb-td nama="ec1_email" >Emergency Contact 1 (Email)</x-tb-td>
                <x-tb-td nama="ec1_alamat" >Emergency Contact 1 (Alamat)</x-tb-td>

                <x-tb-td nama="ec2_status_hubungan" >Emergency Contact 2 (Status Hubungan)</x-tb-td>
                <x-tb-td nama="ec2_nama_lengkap" >Emergency Contact 2 (Nama Lengkap)</x-tb-td>
                <x-tb-td nama="ec2_telepon" >Emergency Contact 2 (Telepon)</x-tb-td>
                <x-tb-td nama="ec2_email" >Emergency Contact 2 (Email)</x-tb-td>
                <x-tb-td nama="ec2_alamat" >Emergency Contact 2 (Alamat)</x-tb-td>

                <x-tb-td nama="ec3_status_hubungan" >Emergency Contact 3 (Status Hubungan)</x-tb-td>
                <x-tb-td nama="ec3_nama_lengkap" >Emergency Contact 3 (Nama Lengkap)</x-tb-td>
                <x-tb-td nama="ec3_telepon" >Emergency Contact 3 (Telepon)</x-tb-td>
                <x-tb-td nama="ec3_email" >Emergency Contact 3 (Email)</x-tb-td>
                <x-tb-td nama="ec3_alamat" >Emergency Contact 3 (Alamat)</x-tb-td>

                <x-tb-td nama="ec4_status_hubungan" >Emergency Contact 4 (Status Hubungan)</x-tb-td>
                <x-tb-td nama="ec4_nama_lengkap" >Emergency Contact 4 (Nama Lengkap)</x-tb-td>
                <x-tb-td nama="ec4_telepon" >Emergency Contact 4 (Telepon)</x-tb-td>
                <x-tb-td nama="ec4_email" >Emergency Contact 4 (Email)</x-tb-td>
                <x-tb-td nama="ec4_alamat" >Emergency Contact 4 (Alamat)</x-tb-td>

                {{-- <x-tb-td type="select" nama="bagian" >SK YPT</x-tb-td> --}}
                {{-- <x-tb-td nama="action" >Action</x-tb-td> --}}
                {{-- <x-tb-td nama="email_pribadi"></x-tb-td> --}}
            </x-slot:table_header>

            <x-slot:table_column>
                @forelse ($data as $row)
                    <x-tb-cl id="">
                        {{-- ====== PASTE INI DI SETIAP CELL (SEMUA KOLOM) ====== --}}

                        {{-- DATA UTAMA --}}
                        <x-tb-cl-fill>
                            <div class="editable-cell px-2 py-1 rounded cursor-pointer transition hover:bg-gray-100 hover:shadow-sm hover:ring-1 hover:ring-gray-300"
                                data-name="nama_lengkap" data-value="{{ $row['nama_lengkap'] }}">
                                <span
                                    class="{{ $row['nama_lengkap'] === '' ? 'text-red-500' : '' }}">{{ $row['nama_lengkap'] === '' ? 'KOSONG' : $row['nama_lengkap'] }}</span>
                                <input type="hidden" name="nama_lengkap[]" value="{{ $row['nama_lengkap'] }}">
                            </div>
                        </x-tb-cl-fill>

                        <x-tb-cl-fill>
                            <div class="editable-cell px-2 py-1 rounded cursor-pointer transition hover:bg-gray-100 hover:shadow-sm hover:ring-1 hover:ring-gray-300"
                                data-name="nik" data-value="{{ $row['nik'] }}">
                                <span
                                    class="{{ $row['nik'] === '' ? 'text-red-500' : '' }}">{{ $row['nik'] === '' ? 'KOSONG' : $row['nik'] }}</span>
                                <input type="hidden" name="nik[]" value="{{ $row['nik'] }}">
                            </div>
                        </x-tb-cl-fill>

                        <x-tb-cl-fill>
                            <div class="editable-cell px-2 py-1 rounded cursor-pointer transition hover:bg-gray-100 hover:shadow-sm hover:ring-1 hover:ring-gray-300"
                                data-name="username" data-value="{{ $row['username'] }}">
                                <span
                                    class="{{ $row['username'] === '' ? 'text-red-500' : '' }}">{{ $row['username'] === '' ? 'KOSONG' : $row['username'] }}</span>
                                <input type="hidden" name="username[]" value="{{ $row['username'] }}">
                            </div>
                        </x-tb-cl-fill>

                        <x-tb-cl-fill>
                            <div class="editable-cell px-2 py-1 rounded cursor-pointer transition hover:bg-gray-100 hover:shadow-sm hover:ring-1 hover:ring-gray-300"
                                data-name="telepon" data-value="{{ $row['telepon'] }}">
                                <span
                                    class="{{ $row['telepon'] === '' ? 'text-red-500' : '' }}">{{ $row['telepon'] === '' ? 'KOSONG' : $row['telepon'] }}</span>
                                <input type="hidden" name="telepon[]" value="{{ $row['telepon'] }}">
                            </div>
                        </x-tb-cl-fill>

                        <x-tb-cl-fill>
                            <div class="editable-cell px-2 py-1 rounded cursor-pointer transition hover:bg-gray-100 hover:shadow-sm hover:ring-1 hover:ring-gray-300"
                                data-name="email_pribadi" data-value="{{ $row['email_pribadi'] }}">
                                <span
                                    class="{{ $row['email_pribadi'] === '' ? 'text-red-500' : '' }}">{{ $row['email_pribadi'] === '' ? 'KOSONG' : $row['email_pribadi'] }}</span>
                                <input type="hidden" name="email_pribadi[]" value="{{ $row['email_pribadi'] }}">
                            </div>
                        </x-tb-cl-fill>

                        <x-tb-cl-fill>
                            <div class="editable-cell px-2 py-1 rounded cursor-pointer transition hover:bg-gray-100 hover:shadow-sm hover:ring-1 hover:ring-gray-300"
                                data-name="email_institusi" data-value="{{ $row['email_institusi'] }}">
                                <span
                                    class="{{ $row['email_institusi'] === '' ? 'text-red-500' : '' }}">{{ $row['email_institusi'] === '' ? 'KOSONG' : $row['email_institusi'] }}</span>
                                <input type="hidden" name="email_institusi[]" value="{{ $row['email_institusi'] }}">
                            </div>
                        </x-tb-cl-fill>

                        <x-tb-cl-fill>
                            <div class="editable-cell px-2 py-1 rounded cursor-pointer transition hover:bg-gray-100 hover:shadow-sm hover:ring-1 hover:ring-gray-300"
                                data-name="telepon_darurat" data-value="{{ $row['telepon_darurat'] }}">
                                <span
                                    class="{{ $row['telepon_darurat'] === '' ? 'text-red-500' : '' }}">{{ $row['telepon_darurat'] === '' ? 'KOSONG' : $row['telepon_darurat'] }}</span>
                                <input type="hidden" name="telepon_darurat[]" value="{{ $row['telepon_darurat'] }}">
                            </div>
                        </x-tb-cl-fill>

                        <x-tb-cl-fill>
                            <div class="editable-cell px-2 py-1 rounded cursor-pointer transition hover:bg-gray-100 hover:shadow-sm hover:ring-1 hover:ring-gray-300"
                                data-name="jenis_kelamin" data-value="{{ $row['jenis_kelamin'] }}">
                                <span
                                    class="{{ $row['jenis_kelamin'] === '' ? 'text-red-500' : '' }}">{{ $row['jenis_kelamin'] === '' ? 'KOSONG' : $row['jenis_kelamin'] }}</span>
                                <input type="hidden" name="jenis_kelamin[]" value="{{ $row['jenis_kelamin'] }}">
                            </div>
                        </x-tb-cl-fill>

                        <x-tb-cl-fill>
                            <div class="editable-cell px-2 py-1 rounded cursor-pointer transition hover:bg-gray-100 hover:shadow-sm hover:ring-1 hover:ring-gray-300"
                                data-name="alamat" data-value="{{ $row['alamat'] }}">
                                <span
                                    class="{{ $row['alamat'] === '' ? 'text-red-500' : '' }}">{{ $row['alamat'] === '' ? 'KOSONG' : $row['alamat'] }}</span>
                                <input type="hidden" name="alamat[]" value="{{ $row['alamat'] }}">
                            </div>
                        </x-tb-cl-fill>

                        <x-tb-cl-fill>
                            <div class="editable-cell px-2 py-1 rounded cursor-pointer transition hover:bg-gray-100 hover:shadow-sm hover:ring-1 hover:ring-gray-300"
                                data-name="tempat_lahir" data-value="{{ $row['tempat_lahir'] }}">
                                <span
                                    class="{{ $row['tempat_lahir'] === '' ? 'text-red-500' : '' }}">{{ $row['tempat_lahir'] === '' ? 'KOSONG' : $row['tempat_lahir'] }}</span>
                                <input type="hidden" name="tempat_lahir[]" value="{{ $row['tempat_lahir'] }}">
                            </div>
                        </x-tb-cl-fill>

                        <x-tb-cl-fill>
                            <div class="editable-cell px-2 py-1 rounded cursor-pointer transition hover:bg-gray-100 hover:shadow-sm hover:ring-1 hover:ring-gray-300"
                                data-name="tgl_lahir" data-value="{{ $row['tgl_lahir'] }}">
                                <span
                                    class="{{ $row['tgl_lahir'] === '' ? 'text-red-500' : '' }}">{{ $row['tgl_lahir'] === '' ? 'KOSONG' : $row['tgl_lahir'] }}</span>
                                <input type="hidden" name="tgl_lahir[]" value="{{ $row['tgl_lahir'] }}">
                            </div>
                        </x-tb-cl-fill>

                        <x-tb-cl-fill>
                            <div class="editable-cell px-2 py-1 rounded cursor-pointer transition hover:bg-gray-100 hover:shadow-sm hover:ring-1 hover:ring-gray-300"
                                data-name="tipe_pegawai" data-value="{{ $row['tipe_pegawai'] }}">
                                <span
                                    class="{{ $row['tipe_pegawai'] === '' ? 'text-red-500' : '' }}">{{ $row['tipe_pegawai'] === '' ? 'KOSONG' : $row['tipe_pegawai'] }}</span>
                                <input type="hidden" name="tipe_pegawai[]" value="{{ $row['tipe_pegawai'] }}">
                            </div>
                        </x-tb-cl-fill>

                        <x-tb-cl-fill>
                            <div class="editable-cell px-2 py-1 rounded cursor-pointer transition hover:bg-gray-100 hover:shadow-sm hover:ring-1 hover:ring-gray-300"
                                data-name="status_kepegawaian" data-value="{{ $row['status_kepegawaian'] }}">
                                <span
                                    class="{{ $row['status_kepegawaian'] === '' ? 'text-red-500' : '' }}">{{ $row['status_kepegawaian'] === '' ? 'KOSONG' : $row['status_kepegawaian'] }}</span>
                                <input type="hidden" name="status_kepegawaian[]"
                                    value="{{ $row['status_kepegawaian'] }}">
                            </div>
                        </x-tb-cl-fill>

                        <x-tb-cl-fill>
                            <div class="editable-cell px-2 py-1 rounded cursor-pointer transition hover:bg-gray-100 hover:shadow-sm hover:ring-1 hover:ring-gray-300"
                                data-name="nip" data-value="{{ $row['nip'] }}">
                                <span
                                    class="{{ $row['nip'] === '' ? 'text-red-500' : '' }}">{{ $row['nip'] === '' ? 'KOSONG' : $row['nip'] }}</span>
                                <input type="hidden" name="nip[]" value="{{ $row['nip'] }}">
                            </div>
                        </x-tb-cl-fill>

                        <x-tb-cl-fill>
                            <div class="editable-cell px-2 py-1 rounded cursor-pointer transition hover:bg-gray-100 hover:shadow-sm hover:ring-1 hover:ring-gray-300"
                                data-name="tmt_mulai" data-value="{{ $row['tmt_mulai'] }}">
                                <span
                                    class="{{ $row['tmt_mulai'] === '' ? 'text-red-500' : '' }}">{{ $row['tmt_mulai'] === '' ? 'KOSONG' : $row['tmt_mulai'] }}</span>
                                <input type="hidden" name="tmt_mulai[]" value="{{ $row['tmt_mulai'] }}">
                            </div>
                        </x-tb-cl-fill>

                        {{-- EMERGENCY CONTACT 1 --}}
                        <x-tb-cl-fill>
                            <div class="editable-cell px-2 py-1 rounded cursor-pointer transition hover:bg-gray-100 hover:shadow-sm hover:ring-1 hover:ring-gray-300"
                                data-name="ec1_status_hubungan" data-value="{{ $row['ec1_status_hubungan'] }}"><span
                                    class="{{ $row['ec1_status_hubungan'] === '' ? 'text-red-500' : '' }}">{{ $row['ec1_status_hubungan'] === '' ? 'KOSONG' : $row['ec1_status_hubungan'] }}</span><input
                                    type="hidden" name="ec1_status_hubungan[]"
                                    value="{{ $row['ec1_status_hubungan'] }}"></div>
                        </x-tb-cl-fill>
                        <x-tb-cl-fill>
                            <div class="editable-cell px-2 py-1 rounded cursor-pointer transition hover:bg-gray-100 hover:shadow-sm hover:ring-1 hover:ring-gray-300"
                                data-name="ec1_nama_lengkap" data-value="{{ $row['ec1_nama_lengkap'] }}"><span
                                    class="{{ $row['ec1_nama_lengkap'] === '' ? 'text-red-500' : '' }}">{{ $row['ec1_nama_lengkap'] === '' ? 'KOSONG' : $row['ec1_nama_lengkap'] }}</span><input
                                    type="hidden" name="ec1_nama_lengkap[]" value="{{ $row['ec1_nama_lengkap'] }}">
                            </div>
                        </x-tb-cl-fill>
                        <x-tb-cl-fill>
                            <div class="editable-cell px-2 py-1 rounded cursor-pointer transition hover:bg-gray-100 hover:shadow-sm hover:ring-1 hover:ring-gray-300"
                                data-name="ec1_telepon" data-value="{{ $row['ec1_telepon'] }}"><span
                                    class="{{ $row['ec1_telepon'] === '' ? 'text-red-500' : '' }}">{{ $row['ec1_telepon'] === '' ? 'KOSONG' : $row['ec1_telepon'] }}</span><input
                                    type="hidden" name="ec1_telepon[]" value="{{ $row['ec1_telepon'] }}"></div>
                        </x-tb-cl-fill>
                        <x-tb-cl-fill>
                            <div class="editable-cell px-2 py-1 rounded cursor-pointer transition hover:bg-gray-100 hover:shadow-sm hover:ring-1 hover:ring-gray-300"
                                data-name="ec1_email" data-value="{{ $row['ec1_email'] }}"><span
                                    class="{{ $row['ec1_email'] === '' ? 'text-red-500' : '' }}">{{ $row['ec1_email'] === '' ? 'KOSONG' : $row['ec1_email'] }}</span><input
                                    type="hidden" name="ec1_email[]" value="{{ $row['ec1_email'] }}"></div>
                        </x-tb-cl-fill>
                        <x-tb-cl-fill>
                            <div class="editable-cell px-2 py-1 rounded cursor-pointer transition hover:bg-gray-100 hover:shadow-sm hover:ring-1 hover:ring-gray-300"
                                data-name="ec1_alamat" data-value="{{ $row['ec1_alamat'] }}"><span
                                    class="{{ $row['ec1_alamat'] === '' ? 'text-red-500' : '' }}">{{ $row['ec1_alamat'] === '' ? 'KOSONG' : $row['ec1_alamat'] }}</span><input
                                    type="hidden" name="ec1_alamat[]" value="{{ $row['ec1_alamat'] }}"></div>
                        </x-tb-cl-fill>

                        {{-- EMERGENCY CONTACT 2 --}}
                        <x-tb-cl-fill>
                            <div class="editable-cell px-2 py-1 rounded cursor-pointer transition hover:bg-gray-100 hover:shadow-sm hover:ring-1 hover:ring-gray-300"
                                data-name="ec2_status_hubungan" data-value="{{ $row['ec2_status_hubungan'] }}"><span
                                    class="{{ $row['ec2_status_hubungan'] === '' ? 'text-red-500' : '' }}">{{ $row['ec2_status_hubungan'] === '' ? 'KOSONG' : $row['ec2_status_hubungan'] }}</span><input
                                    type="hidden" name="ec2_status_hubungan[]"
                                    value="{{ $row['ec2_status_hubungan'] }}"></div>
                        </x-tb-cl-fill>
                        <x-tb-cl-fill>
                            <div class="editable-cell px-2 py-1 rounded cursor-pointer transition hover:bg-gray-100 hover:shadow-sm hover:ring-1 hover:ring-gray-300"
                                data-name="ec2_nama_lengkap" data-value="{{ $row['ec2_nama_lengkap'] }}"><span
                                    class="{{ $row['ec2_nama_lengkap'] === '' ? 'text-red-500' : '' }}">{{ $row['ec2_nama_lengkap'] === '' ? 'KOSONG' : $row['ec2_nama_lengkap'] }}</span><input
                                    type="hidden" name="ec2_nama_lengkap[]" value="{{ $row['ec2_nama_lengkap'] }}">
                            </div>
                        </x-tb-cl-fill>
                        <x-tb-cl-fill>
                            <div class="editable-cell px-2 py-1 rounded cursor-pointer transition hover:bg-gray-100 hover:shadow-sm hover:ring-1 hover:ring-gray-300"
                                data-name="ec2_telepon" data-value="{{ $row['ec2_telepon'] }}"><span
                                    class="{{ $row['ec2_telepon'] === '' ? 'text-red-500' : '' }}">{{ $row['ec2_telepon'] === '' ? 'KOSONG' : $row['ec2_telepon'] }}</span><input
                                    type="hidden" name="ec2_telepon[]" value="{{ $row['ec2_telepon'] }}"></div>
                        </x-tb-cl-fill>
                        <x-tb-cl-fill>
                            <div class="editable-cell px-2 py-1 rounded cursor-pointer transition hover:bg-gray-100 hover:shadow-sm hover:ring-1 hover:ring-gray-300"
                                data-name="ec2_email" data-value="{{ $row['ec2_email'] }}"><span
                                    class="{{ $row['ec2_email'] === '' ? 'text-red-500' : '' }}">{{ $row['ec2_email'] === '' ? 'KOSONG' : $row['ec2_email'] }}</span><input
                                    type="hidden" name="ec2_email[]" value="{{ $row['ec2_email'] }}"></div>
                        </x-tb-cl-fill>
                        <x-tb-cl-fill>
                            <div class="editable-cell px-2 py-1 rounded cursor-pointer transition hover:bg-gray-100 hover:shadow-sm hover:ring-1 hover:ring-gray-300"
                                data-name="ec2_alamat" data-value="{{ $row['ec2_alamat'] }}"><span
                                    class="{{ $row['ec2_alamat'] === '' ? 'text-red-500' : '' }}">{{ $row['ec2_alamat'] === '' ? 'KOSONG' : $row['ec2_alamat'] }}</span><input
                                    type="hidden" name="ec2_alamat[]" value="{{ $row['ec2_alamat'] }}"></div>
                        </x-tb-cl-fill>

                        {{-- EMERGENCY CONTACT 3 --}}
                        <x-tb-cl-fill>
                            <div class="editable-cell px-2 py-1 rounded cursor-pointer transition hover:bg-gray-100 hover:shadow-sm hover:ring-1 hover:ring-gray-300"
                                data-name="ec3_status_hubungan" data-value="{{ $row['ec3_status_hubungan'] }}"><span
                                    class="{{ $row['ec3_status_hubungan'] === '' ? 'text-red-500' : '' }}">{{ $row['ec3_status_hubungan'] === '' ? 'KOSONG' : $row['ec3_status_hubungan'] }}</span><input
                                    type="hidden" name="ec3_status_hubungan[]"
                                    value="{{ $row['ec3_status_hubungan'] }}"></div>
                        </x-tb-cl-fill>
                        <x-tb-cl-fill>
                            <div class="editable-cell px-2 py-1 rounded cursor-pointer transition hover:bg-gray-100 hover:shadow-sm hover:ring-1 hover:ring-gray-300"
                                data-name="ec3_nama_lengkap" data-value="{{ $row['ec3_nama_lengkap'] }}"><span
                                    class="{{ $row['ec3_nama_lengkap'] === '' ? 'text-red-500' : '' }}">{{ $row['ec3_nama_lengkap'] === '' ? 'KOSONG' : $row['ec3_nama_lengkap'] }}</span><input
                                    type="hidden" name="ec3_nama_lengkap[]" value="{{ $row['ec3_nama_lengkap'] }}">
                            </div>
                        </x-tb-cl-fill>
                        <x-tb-cl-fill>
                            <div class="editable-cell px-2 py-1 rounded cursor-pointer transition hover:bg-gray-100 hover:shadow-sm hover:ring-1 hover:ring-gray-300"
                                data-name="ec3_telepon" data-value="{{ $row['ec3_telepon'] }}"><span
                                    class="{{ $row['ec3_telepon'] === '' ? 'text-red-500' : '' }}">{{ $row['ec3_telepon'] === '' ? 'KOSONG' : $row['ec3_telepon'] }}</span><input
                                    type="hidden" name="ec3_telepon[]" value="{{ $row['ec3_telepon'] }}"></div>
                        </x-tb-cl-fill>
                        <x-tb-cl-fill>
                            <div class="editable-cell px-2 py-1 rounded cursor-pointer transition hover:bg-gray-100 hover:shadow-sm hover:ring-1 hover:ring-gray-300"
                                data-name="ec3_email" data-value="{{ $row['ec3_email'] }}"><span
                                    class="{{ $row['ec3_email'] === '' ? 'text-red-500' : '' }}">{{ $row['ec3_email'] === '' ? 'KOSONG' : $row['ec3_email'] }}</span><input
                                    type="hidden" name="ec3_email[]" value="{{ $row['ec3_email'] }}"></div>
                        </x-tb-cl-fill>
                        <x-tb-cl-fill>
                            <div class="editable-cell px-2 py-1 rounded cursor-pointer transition hover:bg-gray-100 hover:shadow-sm hover:ring-1 hover:ring-gray-300"
                                data-name="ec3_alamat" data-value="{{ $row['ec3_alamat'] }}"><span
                                    class="{{ $row['ec3_alamat'] === '' ? 'text-red-500' : '' }}">{{ $row['ec3_alamat'] === '' ? 'KOSONG' : $row['ec3_alamat'] }}</span><input
                                    type="hidden" name="ec3_alamat[]" value="{{ $row['ec3_alamat'] }}"></div>
                        </x-tb-cl-fill>

                        {{-- EMERGENCY CONTACT 4 --}}
                        <x-tb-cl-fill>
                            <div class="editable-cell px-2 py-1 rounded cursor-pointer transition hover:bg-gray-100 hover:shadow-sm hover:ring-1 hover:ring-gray-300"
                                data-name="ec4_status_hubungan" data-value="{{ $row['ec4_status_hubungan'] }}"><span
                                    class="{{ $row['ec4_status_hubungan'] === '' ? 'text-red-500' : '' }}">{{ $row['ec4_status_hubungan'] === '' ? 'KOSONG' : $row['ec4_status_hubungan'] }}</span><input
                                    type="hidden" name="ec4_status_hubungan[]"
                                    value="{{ $row['ec4_status_hubungan'] }}"></div>
                        </x-tb-cl-fill>
                        <x-tb-cl-fill>
                            <div class="editable-cell px-2 py-1 rounded cursor-pointer transition hover:bg-gray-100 hover:shadow-sm hover:ring-1 hover:ring-gray-300"
                                data-name="ec4_nama_lengkap" data-value="{{ $row['ec4_nama_lengkap'] }}"><span
                                    class="{{ $row['ec4_nama_lengkap'] === '' ? 'text-red-500' : '' }}">{{ $row['ec4_nama_lengkap'] === '' ? 'KOSONG' : $row['ec4_nama_lengkap'] }}</span><input
                                    type="hidden" name="ec4_nama_lengkap[]" value="{{ $row['ec4_nama_lengkap'] }}">
                            </div>
                        </x-tb-cl-fill>
                        <x-tb-cl-fill>
                            <div class="editable-cell px-2 py-1 rounded cursor-pointer transition hover:bg-gray-100 hover:shadow-sm hover:ring-1 hover:ring-gray-300"
                                data-name="ec4_telepon" data-value="{{ $row['ec4_telepon'] }}"><span
                                    class="{{ $row['ec4_telepon'] === '' ? 'text-red-500' : '' }}">{{ $row['ec4_telepon'] === '' ? 'KOSONG' : $row['ec4_telepon'] }}</span><input
                                    type="hidden" name="ec4_telepon[]" value="{{ $row['ec4_telepon'] }}"></div>
                        </x-tb-cl-fill>
                        <x-tb-cl-fill>
                            <div class="editable-cell px-2 py-1 rounded cursor-pointer transition hover:bg-gray-100 hover:shadow-sm hover:ring-1 hover:ring-gray-300"
                                data-name="ec4_email" data-value="{{ $row['ec4_email'] }}"><span
                                    class="{{ $row['ec4_email'] === '' ? 'text-red-500' : '' }}">{{ $row['ec4_email'] === '' ? 'KOSONG' : $row['ec4_email'] }}</span><input
                                    type="hidden" name="ec4_email[]" value="{{ $row['ec4_email'] }}"></div>
                        </x-tb-cl-fill>
                        <x-tb-cl-fill>
                            <div class="editable-cell px-2 py-1 rounded cursor-pointer transition hover:bg-gray-100 hover:shadow-sm hover:ring-1 hover:ring-gray-300"
                                data-name="ec4_alamat" data-value="{{ $row['ec4_alamat'] }}"><span
                                    class="{{ $row['ec4_alamat'] === '' ? 'text-red-500' : '' }}">{{ $row['ec4_alamat'] === '' ? 'KOSONG' : $row['ec4_alamat'] }}</span><input
                                    type="hidden" name="ec4_alamat[]" value="{{ $row['ec4_alamat'] }}"></div>
                        </x-tb-cl-fill>

                        {{-- ====== JS SWEETALERT2 (PASTE SEKALI DI BAWAH PAGE) ====== --}}


                    </x-tb-cl>
                @empty
                    <p>No Data</p>
                @endforelse
            </x-slot:table_column>
        </x-tb>
        <p class="mt-2 text-xs text-gray-500">
            Pastikan semua data tidak berwarna merah sebelum mengimpor.
        </p>
        <button id="import-data-btn" type="submit"
            class="inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-6 py-3
                text-sm font-semibold text-white shadow-sm transition
                hover:bg-emerald-700 focus:outline-none focus:ring-2
                focus:ring-emerald-500 focus:ring-offset-2">
            <!-- save icon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                <path
                    d="M17 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V7l-4-4zm-5 16a3 3 0 1 1 0-6 3 3 0 0 1 0 6zM6 5h9v4H6V5z" />
            </svg>
            Import Data Sekarang
        </button>


    </form>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('click', async (e) => {
            const el = e.target.closest('.editable-cell');
            if (!el) return;

            console.log('clicked editable-cell', el); // <- buat ngecek event masuk

            const field = el.dataset.name || '';
            const current = el.dataset.value ?? '';

            const result = await Swal.fire({
                title: 'Edit',
                input: 'text',
                inputLabel: field,
                inputValue: current,
                showCancelButton: true,
                confirmButtonText: 'Simpan',
                cancelButtonText: 'Batal'
            });

            if (!result.isConfirmed) return;

            const finalValue = (result.value ?? '').toString();

            // update dataset
            el.dataset.value = finalValue;

            // update teks
            const span = el.querySelector('span');
            if (span) {
                if (finalValue === '') {
                    span.textContent = 'KOSONG';
                    span.classList.add('text-red-500');
                } else {
                    span.textContent = finalValue;
                    span.classList.remove('text-red-500');
                }
            }

            // update hidden input
            const hidden = el.querySelector('input[type="hidden"]');
            if (hidden) hidden.value = finalValue;
        });
    </script>
@endsection
