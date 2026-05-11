@php
    $active_sidebar = 'Kontrak Manajemen (KM) & Sasaran Mutu (SM)';
    $isAdmin = auth()->user()->is_admin;
    $role = auth()->user()->role;
@endphp

@extends('kinerja_pegawai.base')

@section('page-name', (isset($role) && $role === 'pegawai' && !$isAdmin) ? 'Detail KM & Sasaran Mutu Saya' : 'Kontrak Manajemen (KM) & Sasaran Mutu (SM)')

@section('content-base')
<div class="mb-4">
    <p class="text-sm text-gray-500 italic">Kelola master indikator KM & Sasaran Mutu institusi.</p>
</div>
<div class="w-full max-w-7xl mx-auto p-4 sm:p-6 lg:p-8 bg-white rounded-lg shadow-sm border border-gray-100">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 pb-6 border-b border-gray-100 gap-4">
        <div>
            <h3 class="text-lg font-semibold text-gray-700">Daftar Indikator KPI</h3>
            <p class="text-xs text-gray-400 italic">Daftar seluruh Kontrak Manajemen dan Sasaran Mutu yang terdaftar.</p>
        </div>
        <div class="flex items-center gap-3">
            @if(!(isset($role) && $role === 'pegawai' && !$isAdmin))
            <a href="{{ route('manage.target-kinerja.input') }}" 
                class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2 px-4 rounded-md transition duration-150 inline-flex items-center gap-2 shadow-sm">
                <i class="fa-solid fa-plus text-xs"></i> Tambah KM/SM
            </a>
            @endif
        </div>
    </div>

    <div class="flex flex-col gap-6">
        @if(isset($role) && $role === 'pegawai' && !$isAdmin && $targetKinerja->isEmpty())
            <div class="text-center py-20 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                <i class="fa-solid fa-bullseye text-5xl text-gray-200 mb-4 block"></i>
                <p class="text-gray-400 font-medium italic">Belum ada target KPI yang dibebankan kepada Anda.</p>
            </div>
        @else
            <div class="overflow-x-auto border border-gray-200 rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-left">Indikator KM/SM</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Jenis</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-left">Unit</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Total Target</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Progress</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($targetKinerja as $index => $item)
                            @php
                                $totalTarget = $item->tw1_target + $item->tw2_target + $item->tw3_target + $item->tw4_target;
                            @endphp
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-gray-900 leading-tight">{{ $item->nama_kpi }}</div>
                                    <div class="text-[10px] text-gray-400 mt-1 uppercase">Tahun {{ $item->tahun }}</div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="px-2 py-0.5 rounded bg-blue-50 text-blue-700 text-[10px] font-bold uppercase border border-blue-100">
                                        {{ $item->jenis }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 font-medium">
                                    {{ $item->unit->nama_unit ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="text-sm font-bold text-gray-800">{{ number_format($totalTarget) }}</span>
                                    <span class="text-[10px] text-gray-400 font-medium uppercase ml-0.5">{{ $item->satuan }}</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @php
                                        $realisasi = 0;
                                        foreach($item->targetHarian as $harian) {
                                            $realisasi += $harian->pelaporan()->where('status', 'approved')->sum('approved_jumlah');
                                        }
                                        $progress = $totalTarget > 0 ? min(round(($realisasi / $totalTarget) * 100, 1), 100) : 0;
                                    @endphp
                                    <div class="flex flex-col items-center gap-1">
                                        <span class="text-[10px] font-bold text-gray-700">{{ $progress }}%</span>
                                        <div class="w-16 bg-gray-100 h-1.5 rounded-full overflow-hidden border border-gray-50 shadow-inner">
                                            <div class="bg-green-500 h-full transition-all duration-500" style="width: {{ $progress }}%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('manage.target-kinerja.view', $item->id) }}" 
                                            class="w-8 h-8 rounded-md border border-gray-200 bg-white flex items-center justify-center text-blue-600 hover:bg-blue-50 transition-all" title="View Detail">
                                            <i class="fa-solid fa-eye text-xs"></i>
                                        </a>
                                        @if(!(isset($role) && $role === 'pegawai' && !$isAdmin))
                                        <a href="{{ route('manage.target-kinerja.assign', $item->id) }}" 
                                            class="w-8 h-8 rounded-md border border-gray-200 bg-white flex items-center justify-center text-green-600 hover:bg-green-50 transition-all" title="Assign Pegawai">
                                            <i class="fa-solid fa-user-plus text-xs"></i>
                                        </a>
                                        <a href="{{ route('manage.target-kinerja.edit', $item->id) }}" 
                                            class="w-8 h-8 rounded-md border border-gray-200 bg-white flex items-center justify-center text-amber-600 hover:bg-amber-50 transition-all" title="Edit">
                                            <i class="fa-solid fa-pen text-xs"></i>
                                        </a>
                                        <form action="{{ route('manage.target-kinerja.destroy', $item->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-8 h-8 rounded-md border border-gray-200 bg-white flex items-center justify-center text-red-600 hover:bg-red-50 transition-all" 
                                                onclick="return confirm('Yakin ingin menghapus indikator KPI ini?')" title="Hapus">
                                                <i class="fa-solid fa-trash text-xs"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
