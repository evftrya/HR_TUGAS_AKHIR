@extends('kinerja_pegawai.base')

@section('page-name', 'Detail Fakultas')

@section('content-base')
<div class="mb-4">
    <p class="text-sm text-gray-500 italic">Informasi lengkap dan statistik kinerja fakultas.</p>
</div>
<div class="w-full max-w-7xl mx-auto p-4 sm:p-6 lg:p-8 bg-white rounded-lg shadow-sm border border-gray-100">
    <div class="flex justify-between items-start mb-8 border-b border-gray-100 pb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Fakultas Teknik Industri</h2>
            <p class="text-sm text-gray-500 mt-1">Kode: FTI | ID: {{ $id ?? '#' }}</p>
        </div>
        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 uppercase">Aktif</span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
        <div>
            <h3 class="text-lg font-semibold text-gray-700 mb-4 border-l-4 border-blue-500 pl-3">Statistik Fakultas</h3>
            <div class="space-y-3">
                <div class="flex justify-between border-b border-gray-50 pb-2">
                    <span class="text-sm font-medium text-gray-500">Total Pegawai</span>
                    <span class="text-sm font-semibold text-gray-700">200 Orang</span>
                </div>
                <div class="flex justify-between border-b border-gray-50 pb-2">
                    <span class="text-sm font-medium text-gray-500">Rata-rata Efektivitas</span>
                    <span class="text-sm font-semibold text-gray-700">85%</span>
                </div>
            </div>
        </div>
        <div>
            <h3 class="text-lg font-semibold text-gray-700 mb-4 border-l-4 border-green-500 pl-3">Ringkasan Capaian</h3>
            <div class="p-4 bg-gray-50 rounded-lg">
                <p class="text-2xl font-bold text-blue-600">Optimal</p>
                <p class="text-xs text-gray-400 italic">Berdasarkan data 30 hari terakhir.</p>
            </div>
        </div>
    </div>

    <div class="flex justify-end gap-3 pt-6 border-t border-gray-100">
        <a href="{{ route('manage.dashboard.fakultas.index') }}" class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 text-sm font-medium py-2 px-4 rounded-md transition duration-150">Kembali</a>
    </div>
</div>
@endsection
