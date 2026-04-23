@php
    $active_sidebar = 'Target Kinerja';
@endphp

@extends('kinerja_pegawai.base')

@section('page-name')
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-medium">Assign Target Kinerja</h2>
            <p class="text-sm text-gray-600">{{ $targetKinerja->nama_kpi }}</p>
        </div>
    </div>
@endsection

@section('content-base')
    <div class="bg-white p-4 rounded-lg shadow max-w-4xl">
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">{{ session('error') }}</div>
        @endif

        <!-- Form Tambah Pegawai -->
        <div class="bg-white p-4 rounded-lg shadow mb-6">
            <h3 class="text-lg font-semibold mb-4">Tambah Pegawai</h3>
            <form action="{{ route('manage.target-kinerja.store-assignment', $targetKinerja->id) }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Pegawai</label>
                        <select name="user_id" class="w-full border rounded px-3 py-2" required>
                            <option value="">-- Pilih Pegawai --</option>
                            @foreach($pegawai as $p)
                                @if(!$assignedPegawai->contains($p->id))
                                    <option value="{{ $p->id }}">{{ $p->nama_lengkap }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('user_id')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Status</label>
                        <select name="status" class="w-full border rounded px-3 py-2">
                            <option value="pending">Pending</option>
                            <option value="in_progress">In Progress</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" class="w-full border rounded px-3 py-2" required>
                        @error('tanggal_mulai')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" class="w-full border rounded px-3 py-2" required>
                        @error('tanggal_selesai')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium mb-1">Catatan</label>
                        <textarea name="catatan" rows="2" class="w-full border rounded px-3 py-2"></textarea>
                    </div>
                </div>

                <div class="flex gap-2 mt-4">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Tambah</button>
                    <a href="{{ route('manage.target-kinerja.list') }}" class="px-4 py-2 bg-gray-300 rounded text-gray-700">Kembali</a>
                </div>
            </form>
        </div>

        <!-- Daftar Pegawai yang Sudah Ditugaskan -->
        <div class="mt-8">
            <h3 class="text-lg font-bold text-gray-800 mb-4 px-1">Pegawai yang Ditugaskan ({{ $assignedPegawai->count() }})</h3>

            @if($assignedPegawai->count() > 0)
                <div class="flex flex-grow-0 flex-col gap-2 max-w-100">
                    <x-tb id="assignedPegawaiTable" :search_status="false">
                        <x-slot:table_header>
                            <x-tb-td nama="nama" sorting="true">Nama</x-tb-td>
                            <x-tb-td nama="status" sorting="true">Status</x-tb-td>
                            <x-tb-td nama="mulai" sorting="true">Mulai</x-tb-td>
                            <x-tb-td nama="selesai" sorting="true">Selesai</x-tb-td>
                            <x-tb-td nama="catatan">Catatan</x-tb-td>
                            <x-tb-td nama="action">Action</x-tb-td>
                        </x-slot:table_header>
                        <x-slot:table_column>
                            @foreach($assignedPegawai as $p)
                                <x-tb-cl id="{{ $p->id }}">
                                    <x-tb-cl-fill>
                                        <span class="font-semibold text-gray-900">{{ $p->nama_lengkap }}</span>
                                    </x-tb-cl-fill>
                                    <x-tb-cl-fill>
                                        <form action="{{ route('manage.target-kinerja.update-assignment-status', [$targetKinerja->id, $p->id]) }}" method="POST">
                                            @csrf
                                            <select name="status" onchange="this.form.submit()" class="border-gray-200 rounded-lg py-1 px-2 text-xs focus:ring-blue-500 focus:border-blue-500 transition-all">
                                                <option value="pending" {{ $p->pivot->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="in_progress" {{ $p->pivot->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                                <option value="completed" {{ $p->pivot->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                                <option value="cancelled" {{ $p->pivot->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                            </select>
                                        </form>
                                    </x-tb-cl-fill>
                                    <x-tb-cl-fill>
                                        <span class="text-xs text-gray-600">{{ $p->pivot->tanggal_mulai ? \Carbon\Carbon::parse($p->pivot->tanggal_mulai)->format('d/m/Y') : '-' }}</span>
                                    </x-tb-cl-fill>
                                    <x-tb-cl-fill>
                                        <span class="text-xs text-gray-600">{{ $p->pivot->tanggal_selesai ? \Carbon\Carbon::parse($p->pivot->tanggal_selesai)->format('d/m/Y') : '-' }}</span>
                                    </x-tb-cl-fill>
                                    <x-tb-cl-fill>
                                        <span class="text-xs text-gray-500 italic">{{ $p->pivot->catatan ?? '-' }}</span>
                                    </x-tb-cl-fill>
                                    <x-tb-cl-fill>
                                        <div class="flex items-center justify-center">
                                            <form action="{{ route('manage.target-kinerja.detach-pegawai', [$targetKinerja->id, $p->id]) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="flex items-center justify-center w-7 h-7 rounded-md border border-red-100 text-red-500 hover:bg-red-500 hover:text-white transition-all" onclick="return confirm('Hapus pegawai dari target kinerja ini?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </x-tb-cl-fill>
                                </x-tb-cl>
                            @endforeach
                        </x-slot:table_column>
                    </x-tb>
                </div>
            @else
                <div class="p-8 text-center bg-gray-50 rounded-xl border border-dashed border-gray-200">
                    <p class="text-gray-400 text-sm italic">Belum ada pegawai yang ditugaskan</p>
                </div>
            @endif
        </div>
    </div>
@endsection
