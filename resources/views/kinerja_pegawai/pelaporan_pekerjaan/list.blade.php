@php
    $active_sidebar = 'Target Kinerja';
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

@section('page-name')
    <div class="flex flex-col md:flex-row items-center gap-[11.75px] self-stretch px-1 pt-[14.68px] pb-[13.95px]">
        <div class="flex w-full flex-col gap-[2.93px] grow">
            <div class="flex items-center gap-[5.87px] self-stretch">
                <span class="font-medium text-2xl leading-[20.56px] text-[#101828]">Verifikasi Laporan</span>
            </div>
            <span class="font-normal text-[10.28px] leading-[14.68px] text-[#1f2028]">Tinjau bukti pengerjaan (Evidence Gallery) dan berikan approval</span>
        </div>
    </div>
@endsection

@section('content-base')
    <div class="flex flex-grow-0 flex-col gap-2 max-w-100" x-data="{ 
        showModal: false, 
        modalSrc: '', 
        isImage: true,
        openPreview(src, isImg) {
            this.modalSrc = src;
            this.isImage = isImg;
            this.showModal = true;
        }
    }">
        {{-- SECTION TITLE --}}
        <div class="px-1 mb-4">
            <h3 class="font-bold text-gray-900 tracking-tight text-lg">Monitoring Kecepatan Verifikasi (SLA)</h3>
            <p class="text-xs text-gray-500">Statistik pemrosesan laporan pada bulan {{ now()->translatedFormat('F Y') }}</p>
        </div>

        {{-- SLA WIDGETS --}}
        <div class="mb-8 grid grid-cols-1 md:grid-cols-3 gap-5">
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 flex flex-col justify-between group hover:shadow-md transition-all border-b-4 {{ $slaStats['avg_hours'] <= 48 ? 'border-b-green-500' : 'border-b-red-500' }}">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 {{ $slaStats['avg_hours'] <= 48 ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600' }} rounded-2xl flex-shrink-0">
                        <i class="fa-solid fa-bolt-lightning fa-lg"></i>
                    </div>
                </div>
                <div>
                    <p class="text-3xl font-black {{ $slaStats['avg_hours'] <= 48 ? 'text-green-600' : 'text-red-600' }}">
                        @if($slaStats['avg_hours'] >= 24)
                            {{ round($slaStats['avg_hours'] / 24, 1) }} <span class="text-sm font-bold uppercase">Hari</span>
                        @else
                            {{ $slaStats['avg_hours'] }} <span class="text-sm font-bold uppercase">Jam</span>
                        @endif
                    </p>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mt-1">Rata-rata SLA</p>
                </div>
            </div>

            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 flex flex-col justify-between group hover:shadow-md transition-all">
                <div class="flex items-center gap-3 mb-4 text-gray-400">
                    <i class="fa-solid fa-chart-pie text-lg"></i>
                    <span class="text-[10px] font-bold uppercase tracking-widest">Aktivitas</span>
                </div>
                <div class="space-y-2">
                    <div class="flex justify-between text-xs">
                        <span class="text-gray-600">Approved</span>
                        <span class="font-bold text-green-600">{{ $slaStats['approved_count'] }}</span>
                    </div>
                    <div class="w-full bg-gray-100 h-1 rounded-full overflow-hidden">
                        @php $approvedPct = $slaStats['total_processed'] > 0 ? ($slaStats['approved_count'] / $slaStats['total_processed']) * 100 : 0; @endphp
                        <div class="bg-green-500 h-full" style="width: {{ $approvedPct }}%"></div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 flex flex-col justify-between group hover:shadow-md transition-all">
                <div class="flex items-center gap-3 mb-4 text-gray-400">
                    <i class="fa-solid fa-layer-group text-lg"></i>
                    <span class="text-[10px] font-bold uppercase tracking-widest">Pending</span>
                </div>
                <p class="text-3xl font-black text-gray-900">{{ $slaStats['pending_count'] }}</p>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-1">Laporan Belum Diverifikasi</p>
            </div>
        </div>

        @if(session('success'))<div class="mb-4 p-3 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>@endif
        
        <x-tb id="pelaporanTable" :search_status="true">
            <x-slot:table_header>
                <x-tb-td nama="target_harian" sorting=true>Target Harian</x-tb-td>
                <x-tb-td nama="realisasi" sorting=false>Realisasi</x-tb-td>
                <x-tb-td nama="evidence" sorting=false>Evidence (Gallery)</x-tb-td>
                <x-tb-td nama="status" sorting=true>Status</x-tb-td>
                <x-tb-td nama="action" sorting=false>Action</x-tb-td>
            </x-slot:table_header>
            <x-slot:table_column>
                @foreach($items as $i => $it)
                    <x-tb-cl id="{{ $it->id }}">
                        <x-tb-cl-fill>
                            <span class="font-bold text-gray-900">{{ $it->targetHarian->pekerjaan ?? '-' }}</span>
                            <p class="text-[9px] text-gray-400 uppercase tracking-tighter">{{ $it->pelapor?->nama_lengkap ?? '-' }}</p>
                        </x-tb-cl-fill>
                        <x-tb-cl-fill>{{ Str::limit($it->realisasi, 40) }}</x-tb-cl-fill>
                        
                        {{-- QUICK VIEW EVIDENCE --}}
                        <x-tb-cl-fill>
                            @if($it->evidence)
                                @php
                                    $ext = strtolower(pathinfo($it->evidence, PATHINFO_EXTENSION));
                                    $isImg = in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'svg']);
                                    $isPdf = $ext === 'pdf';
                                @endphp
                                
                                <div class="flex items-center gap-2">
                                    @if($isImg)
                                        <img src="{{ $it->evidence }}" 
                                            class="evidence-preview hover:scale-110 transition-transform" 
                                            @click="openPreview('{{ $it->evidence }}', true)"
                                            title="Klik untuk Zoom">
                                    @elseif($isPdf)
                                        <div @click="openPreview('{{ $it->evidence }}', false)" 
                                            class="w-10 h-10 bg-red-50 text-red-500 rounded-lg flex items-center justify-center cursor-pointer hover:bg-red-100 transition-colors"
                                            title="Preview PDF">
                                            <i class="fa-solid fa-file-pdf"></i>
                                        </div>
                                    @else
                                        <a href="{{ $it->evidence }}" target="_blank" 
                                            class="w-10 h-10 bg-blue-50 text-blue-500 rounded-lg flex items-center justify-center hover:bg-blue-100 transition-colors"
                                            title="Buka Tautan">
                                            <i class="fa-solid fa-link"></i>
                                        </a>
                                    @endif
                                </div>
                            @else
                                <span class="text-[10px] text-gray-300 italic">No Evidence</span>
                            @endif
                        </x-tb-cl-fill>

                        <x-tb-cl-fill>
                            <span class="px-2 py-1 rounded-full text-[9px] font-black uppercase {{ $it->status === 'approved' ? 'bg-green-50 text-green-700 border border-green-100' : ($it->status === 'pending' ? 'bg-yellow-50 text-yellow-700 border border-yellow-100' : 'bg-red-50 text-red-700 border border-red-100') }}">
                                {{ $it->status ?? 'pending' }}
                            </span>
                        </x-tb-cl-fill>
                        
                        <x-tb-cl-fill>
                            <div class="flex items-center justify-center gap-3">
                                <a href="{{ route('manage.target-kinerja.harian.reports.approval', $it->id) }}" 
                                    class="flex items-center justify-center w-8 h-8 rounded-xl border border-gray-200 bg-white hover:bg-blue-600 hover:text-white hover:border-blue-600 transition-all text-blue-600" title="Verifikasi">
                                    <i class="fa-solid fa-clipboard-check text-xs"></i>
                                </a>
                            </div>
                        </x-tb-cl-fill>
                    </x-tb-cl>
                @endforeach
            </x-slot:table_column>
        </x-tb>
        <div class="mt-4">
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
