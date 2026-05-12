@php
    $active_sidebar = 'Kinerja Harian';
@endphp

@extends('kinerja_pegawai.base')

@section('header-base')
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        [x-cloak] { display: none !important; }
        .evidence-preview {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            object-fit: cover;
            cursor: zoom-in;
            border: 2px solid #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
    </style>
@endsection

@section('page-name', 'Verifikasi Kinerja Harian')

@section('content-base')
<div class="mb-4">
    <p class="text-sm text-gray-500 italic">Tinjau bukti pengerjaan (Evidence Gallery) dan berikan verifikasi.</p>
</div>
<div class="w-full max-w-7xl mx-auto p-4 sm:p-6 lg:p-8 bg-white rounded-lg shadow-sm border border-gray-100" x-data="{ 
    showModal: false, 
    modalSrc: '', 
    isImage: true,
    openPreview(src, isImg) {
        this.modalSrc = src;
        this.isImage = isImg;
        this.showModal = true;
    }
}">
    {{-- SLA WIDGETS --}}
    <div class="mb-8 grid grid-cols-1 md:grid-cols-3 gap-5">
        <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 border-b-4 {{ $slaStats['avg_hours'] <= 48 ? 'border-b-green-500' : 'border-b-red-500' }}">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 {{ $slaStats['avg_hours'] <= 48 ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }} rounded-lg flex-shrink-0">
                    <i class="fa-solid fa-bolt-lightning fa-lg"></i>
                </div>
            </div>
            <div>
                <p class="text-3xl font-bold {{ $slaStats['avg_hours'] <= 48 ? 'text-green-600' : 'text-red-600' }}">
                    @if($slaStats['avg_hours'] >= 24)
                        {{ round($slaStats['avg_hours'] / 24, 1) }} <span class="text-sm font-semibold uppercase">Hari</span>
                    @else
                        {{ $slaStats['avg_hours'] }} <span class="text-sm font-semibold uppercase">Jam</span>
                    @endif
                </p>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-widest mt-1">Rata-rata SLA</p>
            </div>
        </div>

        <div class="bg-gray-50 p-6 rounded-xl border border-gray-200">
            <div class="flex items-center gap-3 mb-4 text-gray-400">
                <i class="fa-solid fa-chart-pie text-lg text-blue-500"></i>
                <span class="text-xs font-semibold uppercase tracking-widest text-gray-700">Aktivitas Approved</span>
            </div>
            <div class="space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Total Approved</span>
                    <span class="font-bold text-green-600">{{ $slaStats['approved_count'] }}</span>
                </div>
                <div class="w-full bg-white h-2 rounded-full overflow-hidden border border-gray-100">
                    @php $approvedPct = $slaStats['total_processed'] > 0 ? ($slaStats['approved_count'] / $slaStats['total_processed']) * 100 : 0; @endphp
                    <div class="bg-green-500 h-full transition-all" style="width: {{ $approvedPct }}%"></div>
                </div>
            </div>
        </div>

        <div class="bg-gray-50 p-6 rounded-xl border border-gray-200">
            <div class="flex items-center gap-3 mb-4 text-gray-400">
                <i class="fa-solid fa-layer-group text-lg text-yellow-500"></i>
                <span class="text-xs font-semibold uppercase tracking-widest text-gray-700">Pending Approval</span>
            </div>
            <p class="text-3xl font-bold text-gray-800">{{ $slaStats['pending_count'] }}</p>
            <p class="text-xs text-gray-400 font-semibold uppercase tracking-widest mt-1">Laporan Belum Diverifikasi</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-50 text-green-700 border border-green-200 rounded-md text-sm font-medium">
            {{ session('success') }}
        </div>
    @endif
    
    <div class="overflow-x-auto border border-gray-200 rounded-lg shadow-sm">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-left">Pekerjaan / Pegawai</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-left">Realisasi</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Evidence</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Status</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($items as $i => $it)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-bold text-gray-900">{{ $it->targetHarian->pekerjaan ?? '-' }}</div>
                            <div class="text-[10px] text-gray-400 font-semibold uppercase">{{ $it->pelapor?->nama_lengkap ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-600">{{ Str::limit($it->realisasi, 60) }}</div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($it->evidence)
                                @php
                                    $ext = strtolower(pathinfo($it->evidence, PATHINFO_EXTENSION));
                                    $isImg = in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'svg']);
                                    $isPdf = $ext === 'pdf';
                                @endphp
                                <div class="flex items-center justify-center">
                                    @if($isImg)
                                        <img src="{{ $it->evidence }}" 
                                            class="evidence-preview hover:scale-110 transition-transform" 
                                            @click="openPreview('{{ $it->evidence }}', true)"
                                            title="Klik untuk Zoom">
                                    @elseif($isPdf)
                                        <div @click="openPreview('{{ $it->evidence }}', false)" 
                                            class="w-10 h-10 bg-red-50 text-red-500 rounded-lg flex items-center justify-center cursor-pointer hover:bg-red-100 transition-colors">
                                            <i class="fa-solid fa-file-pdf"></i>
                                        </div>
                                    @else
                                        <a href="{{ $it->evidence }}" target="_blank" 
                                            class="w-10 h-10 bg-blue-50 text-blue-500 rounded-lg flex items-center justify-center hover:bg-blue-100 transition-colors">
                                            <i class="fa-solid fa-link"></i>
                                        </a>
                                    @endif
                                </div>
                            @else
                                <span class="text-xs text-gray-300 italic">No Evidence</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-tight {{ $it->status === 'approved' ? 'bg-green-100 text-green-800' : ($it->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ $it->status ?? 'pending' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <a href="{{ route('manage.target-kinerja.harian.reports.approval', $it->id) }}" 
                                class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold py-2 px-4 rounded-md transition duration-150 inline-flex items-center gap-2">
                                <i class="fa-solid fa-clipboard-check"></i> Verifikasi
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $items->links() }}
    </div>

    {{-- LIGHTBOX MODAL --}}
    <div x-show="showModal" 
        x-cloak
        class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-10"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
        
        <div class="absolute inset-0 bg-black/90 backdrop-blur-sm" @click="showModal = false"></div>
        
        <div class="relative max-w-5xl w-full h-full flex flex-col items-center justify-center"
            x-transition:enter="transition ease-out duration-300 scale-95"
            x-transition:enter-start="opacity-0 scale-90"
            x-transition:enter-end="opacity-100 scale-100">
            
            <button @click="showModal = false" class="absolute -top-12 right-0 text-white hover:text-gray-300 transition-colors">
                <i class="fa-solid fa-xmark text-3xl"></i>
            </button>

            <template x-if="isImage">
                <img :src="modalSrc" class="max-w-full max-h-full rounded-2xl shadow-2xl object-contain">
            </template>
            
            <template x-if="!isImage">
                <iframe :src="modalSrc" class="w-full h-full rounded-2xl bg-white shadow-2xl"></iframe>
            </template>
        </div>
    </div>
</div>
@endsection
