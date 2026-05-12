@extends('kinerja_pegawai.base')

@section('page-name', 'Daftar Fakultas')

@section('content-base')
<div class="mb-4">
    <p class="text-sm text-gray-500 italic">Kelola dan pantau seluruh fakultas yang terdaftar di sistem.</p>
</div>
<div class="w-full max-w-7xl mx-auto p-4 sm:p-6 lg:p-8 bg-white rounded-lg shadow-sm border border-gray-100">
    {{-- Statistics Row --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        @for ($i = 0; $i < 4; $i++)
            <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 text-center">
                <h1 class="text-4xl font-extrabold text-gray-800 mb-1">120</h1>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Total Fakultas</p>
            </div>
        @endfor
    </div>

    {{-- Action Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-4">
        <h3 class="text-lg font-semibold text-gray-700">Manajemen Data Fakultas</h3>
        <div class="flex gap-2">
            <button class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2 px-4 rounded-md transition duration-150 inline-flex items-center gap-2">
                <i class="fa-solid fa-plus text-xs"></i> Tambah Fakultas
            </button>
        </div>
    </div>

    <div class="overflow-x-auto border border-gray-200 rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-left">No</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-left">Kode</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-left">Nama Fakultas</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Jumlah Pegawai</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Status</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @for ($i = 1; $i <= 2; $i++)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $i }}</td>
                        <td class="px-6 py-4 text-sm font-bold text-gray-900">FTI {{ $i }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">Fakultas Teknik Industri</td>
                        <td class="px-6 py-4 text-center text-sm text-gray-700 font-medium">200</td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-2 py-1 rounded-full bg-green-100 text-green-700 text-[10px] font-bold uppercase border border-green-200">
                                Aktif
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <div class="flex items-center justify-center gap-2">
                                <a href="#" class="w-8 h-8 rounded-md border border-gray-200 bg-white flex items-center justify-center text-green-600 hover:bg-green-50 transition-all shadow-sm">
                                    <i class="fa-brands fa-whatsapp text-sm"></i>
                                </a>
                                <button class="w-8 h-8 rounded-md border border-gray-200 bg-white flex items-center justify-center text-blue-600 hover:bg-blue-50 transition-all shadow-sm">
                                    <i class="fa-solid fa-power-off text-xs"></i>
                                </button>
                                <button class="bg-white border border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white text-xs font-bold py-1.5 px-3 rounded-md transition duration-150">
                                    Details
                                </button>
                            </div>
                        </td>
                    </tr>
                @endfor
            </tbody>
        </table>
    </div>
</div>
@endsection
