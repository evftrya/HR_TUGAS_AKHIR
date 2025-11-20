@extends('layouts.app')

@section('content')

<x-dupak.sidebar></x-dupak.sidebar>

<!-- Main Content -->

<div class="mt-16 md:ml-64">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h1 class="mb-6 text-2xl font-semibold">Selamat Datang Di Dasbor DUPAK</h1>
                <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                    <div class="col-span-1 p-6 bg-white border border-gray-200 rounded-lg shadow md:col-span-2">
                        <div class="flex items-start justify-between">
                            <div>
                                <h3 class="mb-1 text-lg font-medium text-gray-900">Informasi KUM</h3>
                                <p class="text-sm text-gray-600">Ringkasan KUM, jabatan, dan progress target</p>
                            </div>
                            <div class="text-right">
                                <span class="text-xs text-gray-500">Jabatan</span>
                                <div class="mt-1 text-sm font-semibold text-gray-900">{{ $jabatan_saat_ini ?? 'Belum diisi' }}</div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-4 mt-4 sm:grid-cols-3">
                            <div>
                                <div class="text-xs text-gray-500">KUM Saat Ini</div>
                                <div class="mt-1 text-2xl font-bold text-blue-900">{{ number_format($currentKum , 2, ',', '.') }}</div>
                            </div>

                            <div>
                                <div class="text-xs text-gray-500">Target KUM</div>
                                <div class="mt-1 text-lg font-semibold text-gray-900">{{ number_format($goalKum, 0, ',', '.') }}</div>
                            </div>

                            <div>
                                <div class="text-xs text-gray-500">Tersisa untuk Target</div>
                                <div class="mt-1 text-lg font-semibold text-gray-900">{{ number_format($remaining, 2, ',', '.') }}</div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <div class="flex items-center justify-between">
                                <div class="text-sm text-gray-600">Progress menuju target</div>
                                <div class="text-sm font-medium text-gray-700">{{ number_format($percent, 0) }}%</div>
                            </div>

                            <div class="w-full h-4 mt-2 overflow-hidden bg-gray-200 rounded-full">
                                <div class="h-full {{ $statusColor }}" style="width: {{ $percent }}%"></div>
                            </div>

                            {{-- Menggunakan $updatedAt yang sudah diformat di controller, atau Carbon di view jika perlu --}}
                            @if($updatedAt ?? false)
                            <div class="mt-2 text-xs text-gray-500">Terakhir diperbarui: {{ \Carbon\Carbon::parse($updatedAt)->diffForHumans() ?? 'Tidak tersedia' }}</div>
                            @endif
                        </div>

                        <div class="flex flex-wrap gap-2 mt-4">
                            <!--route('dupak.kum.details') -->
                            <a href="" class="inline-block px-4 py-2 text-sm text-white bg-blue-900 rounded hover:bg-blue-950">Detail KUM</a>

                            <!--  route('dupak.pengajuan.create') -->
                            <a href="" class="inline-block px-4 py-2 text-sm text-blue-900 border border-blue-900 rounded hover:bg-indigo-50">Ajukan Tambahan</a>

                            <!-- route('dupak.kum.goal.edit') -->
                            <a href="" class="inline-block px-4 py-2 text-sm text-gray-700 bg-gray-100 border border-gray-200 rounded hover:bg-gray-200">Atur Target</a>
                        </div>
                    </div>

                    @if (auth()->user()->is_admin)
                    <!-- Card Validasi DUPAK (Admin Only) -->
                    <div class="p-6 bg-white border border-gray-200 rounded-lg shadow">
                        <h3 class="mb-2 text-lg font-medium text-gray-900">Validasi DUPAK</h3>
                        <p class="mb-4 text-gray-600">Validasi pengajuan DUPAK dari pegawai.</p>
                        <a href="{{ route('dupak.validasi.index') }}" class="inline-block px-4 py-2 text-white bg-blue-900 rounded hover:bg-blue-950">
                            Validasi Pengajuan
                        </a>
                    </div>
                    @endif
                </div>

                <div class="mt-10 p-6 overflow-hidden bg-white rounded-lg shadow">
                    <div class="flex items-center justify-between mb-6">
                        <h1 class="text-2xl font-semibold">
                            Daftar Pengajuan DUPAK
                            @if ($user->is_admin)
                            (Admin View)
                            @endif
                        </h1>
                        @if (!$user->is_admin)
                        <a href="{{ route('dupak.pengajuan.create', ['userId' => $user->id]) }}"
                            class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase bg-blue-900 border border-transparent rounded-md hover:bg-blue-950 active:bg-blue-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25">
                            Buat Pengajuan Baru
                        </a>
                        @endif
                    </div>
                    <div class="overflow-hidden bg-white rounded-lg shadow">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-blue-900">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-white uppercase">
                                        ID Pengajuan
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-white uppercase">
                                        Nama Dosen
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-white uppercase">
                                        Tanggal Pengajuan
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-white uppercase">
                                        Periode Ajuan
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-white uppercase">
                                        Status
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-white uppercase">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>

                            {{-- START OF CORRECTED TABLE BODY --}}
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($pengajuan as $item)
                                <tr class="hover:bg-gray-50 border-b last:border-b-0">

                                    <!-- 1. ID Pengajuan -->
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                                        <!-- {{ '0' + $item->id }} -->
                                        {{ str_pad($item->id, 2, '0', STR_PAD_LEFT) }}
                                    </td>

                                    <!-- 2. Nama Dosen (Diasumsikan ada relasi 'dosen' ke model Dosen) -->
                                    <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
                                        <!-- $item->dosen->nama -->
                                        <!-- ini yang butuh nama dosen -->
                                        {{ $item->dosen->pegawai->nama_lengkap ?? 'N/A' }}
                                    </td>

                                    <!-- 3. Tanggal Pengajuan (created_at) -->
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}
                                    </td>

                                    <!-- 4. Periode Ajuan (start - end) -->
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($item->start)->format('d/m/Y') }} -
                                        {{ \Carbon\Carbon::parse($item->end)->format('d/m/Y') }}
                                    </td>

                                    <!-- 5. Status -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                        // Menentukan warna badge berdasarkan status
                                        $status = $item->status ?? 'Draft';
                                        $badgeColor = [
                                        'Draft' => 'bg-gray-100 text-gray-800',
                                        'Diajukan' => 'bg-yellow-100 text-yellow-800',
                                        'Menunggu' => 'bg-indigo-100 text-indigo-800',
                                        'Ditolak' => 'bg-red-100 text-red-800',
                                        'Diterima' => 'bg-green-100 text-green-800',
                                        'Revisi' => 'bg-yellow-100 text-yellow-800',
                                        ][$status] ?? 'bg-gray-100 text-gray-800';
                                        @endphp
                                        <span class="inline-flex px-2 text-xs font-semibold leading-5 rounded-full {{ $badgeColor }}">
                                            {{ ucfirst($status) }}
                                        </span>
                                    </td>

                                    <!-- 6. Aksi -->
                                    <td class="px-6 py-4 text-sm font-medium whitespace-nowrap">
                                        <a href="{{ route('dupak.pengajuan.show', $item->id) }}" class="text-blue-600 hover:text-blue-900 mr-2">Lihat</a>

                                        @if ($status === 'Draft' || $status === 'Revisi')
                                        <a href="{{ route('dupak.pengajuan.edit', $item->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-2">Edit</a>

                                        <!-- Tombol hapus, menggunakan form untuk keamanan -->
                                        <form action="{{ route('dupak.pengajuan.destroy', $item->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Apakah Anda yakin ingin menghapus pengajuan ini?')">Hapus</button>
                                        </form>
                                        @endif

                                        @if (auth()->user()->is_admin && $status === 'Diajukan')
                                        <a href="{{ route('dupak.validasi.show', $item->id) }}" class="ml-2 text-green-600 hover:text-green-900">Validasi</a>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-10 text-sm text-center text-gray-500">
                                        Belum ada data pengajuan yang tersedia.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                            {{-- END OF CORRECTED TABLE BODY --}}

                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
@endsection