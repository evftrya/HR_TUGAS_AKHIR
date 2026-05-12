@php
    $active_sidebar = 'Target Kinerja';
@endphp

@extends('kinerja_pegawai.base')

@section('page-name', 'Assign Target Kinerja')

@section('content-base')
<div class="mb-4">
    <p class="text-sm text-gray-500 italic">{{ $targetKinerja->nama_kpi }} (Tahun {{ $targetKinerja->tahun }})</p>
</div>
<div class="w-full max-w-7xl mx-auto space-y-8">
    
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm font-medium flex items-center gap-2">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm font-medium flex items-center gap-2">
            <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
        </div>
    @endif

    {{-- Form Tambah Pegawai --}}
    <div class="bg-white p-4 sm:p-6 lg:p-8 rounded-lg shadow-sm border border-gray-100">
        <h3 class="text-lg font-semibold text-gray-700 mb-6 border-l-4 border-blue-600 pl-4 uppercase tracking-tight">Tambah Penugasan Pegawai</h3>
        <form action="{{ route('manage.target-kinerja.store-assignment', $targetKinerja->id) }}" method="POST" class="space-y-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50 p-6 rounded-xl border border-gray-200 shadow-inner">
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Pilih Pegawai</label>
                    <select name="user_id" class="w-full text-sm border-gray-300 rounded-md shadow-sm focus:ring-blue-500" required>
                        <option value="">-- Pilih Pegawai --</option>
                        @foreach($pegawai as $p)
                            @if(!$assignedPegawai->contains($p->id))
                                <option value="{{ $p->id }}">{{ $p->nama_lengkap }}</option>
                            @endif
                        @endforeach
                    </select>
                    @error('user_id')<div class="text-red-600 text-xs mt-1 font-bold">{{ $message }}</div>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Status Penugasan</label>
                    <select name="status" class="w-full text-sm border-gray-300 rounded-md shadow-sm focus:ring-blue-500">
                        <option value="pending">Pending</option>
                        <option value="in_progress">In Progress</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" class="w-full text-sm border-gray-300 rounded-md shadow-sm focus:ring-blue-500" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" class="w-full text-sm border-gray-300 rounded-md shadow-sm focus:ring-blue-500" required>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-600 mb-2">Catatan Penugasan</label>
                    <textarea name="catatan" rows="2" class="w-full text-sm border-gray-300 rounded-md shadow-sm focus:ring-blue-500" placeholder="Berikan instruksi tambahan jika ada..."></textarea>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route('manage.target-kinerja.list') }}" class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 text-sm font-medium py-2 px-6 rounded-md transition duration-150 shadow-sm">Kembali ke Daftar</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2 px-8 rounded-md transition duration-150 shadow-sm">Assign Pegawai</button>
            </div>
        </form>
    </div>

    {{-- Daftar Pegawai yang Sudah Ditugaskan --}}
    <div class="bg-white p-4 sm:p-6 lg:p-8 rounded-lg shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-8 pb-4 border-b border-gray-100">
            <h3 class="text-lg font-bold text-gray-700 uppercase tracking-tight">Pegawai yang Ditugaskan</h3>
            <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-[10px] font-black uppercase tracking-widest">
                {{ $assignedPegawai->count() }} Orang
            </span>
        </div>

        @if($assignedPegawai->count() > 0)
            <div class="overflow-x-auto border border-gray-200 rounded-lg shadow-inner">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-left">Nama Pegawai</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Status</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Periode</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-left">Catatan</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($assignedPegawai as $p)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 font-bold text-xs">
                                            {{ strtoupper(substr($p->nama_lengkap, 0, 1)) }}
                                        </div>
                                        <span class="text-sm font-bold text-gray-900">{{ $p->nama_lengkap }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <form action="{{ route('manage.target-kinerja.update-assignment-status', [$targetKinerja->id, $p->id]) }}" method="POST">
                                        @csrf
                                        <select name="status" onchange="this.form.submit()" 
                                            class="text-[10px] font-bold uppercase border-gray-200 rounded-lg py-1 px-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50 hover:bg-white transition-all">
                                            <option value="pending" {{ $p->pivot->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="in_progress" {{ $p->pivot->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                            <option value="completed" {{ $p->pivot->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                            <option value="cancelled" {{ $p->pivot->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                    </form>
                                </td>
                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    <p class="text-xs text-gray-600 font-medium">
                                        {{ $p->pivot->tanggal_mulai ? \Carbon\Carbon::parse($p->pivot->tanggal_mulai)->format('d/m/Y') : '-' }} 
                                        — 
                                        {{ $p->pivot->tanggal_selesai ? \Carbon\Carbon::parse($p->pivot->tanggal_selesai)->format('d/m/Y') : '-' }}
                                    </p>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-xs text-gray-500 italic truncate max-w-xs block">{{ $p->pivot->catatan ?? '-' }}</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <form action="{{ route('manage.target-kinerja.detach-pegawai', [$targetKinerja->id, $p->id]) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-8 h-8 rounded-md border border-red-100 text-red-500 hover:bg-red-500 hover:text-white transition-all shadow-sm flex items-center justify-center mx-auto" 
                                            onclick="return confirm('Hapus pegawai dari penugasan ini?')">
                                            <i class="fa-solid fa-trash text-[10px]"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-12 text-center bg-gray-50 rounded-xl border border-dashed border-gray-200">
                <p class="text-gray-400 text-sm font-medium italic">Belum ada pegawai yang ditugaskan untuk indikator ini.</p>
            </div>
        @endif
    </div>
</div>
@endsection
