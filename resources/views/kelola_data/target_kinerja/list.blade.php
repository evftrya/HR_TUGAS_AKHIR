@php
    $active_sidebar = 'Target Kinerja';
@endphp

@extends('kinerja_pegawai.base')

@section('page-name')
    <div class="flex flex-col md:flex-row items-center gap-[11.75px] self-stretch px-1 pt-[14.68px] pb-[13.95px]">
        <div class="flex w-full flex-col gap-[2.93px] grow">
            <div class="flex items-center gap-[5.87px] self-stretch">
                <span class="font-medium text-2xl leading-[20.56px] text-[#101828]">
                    @if(isset($role) && $role === 'pegawai' && !$isAdmin)
                        Detail Target KPI Saya
                    @else
                        Target Kinerja
                    @endif
                </span>
            </div>
            <span class="font-normal text-[10.28px] leading-[14.68px] text-[#1f2028]">Kelola data target kinerja</span>
        </div>
        <div class="flex items-center w-full justify-end gap-[11.75px]">
            @if(!(isset($role) && $role === 'pegawai' && !$isAdmin))
            <a href="{{ route('manage.target-kinerja.input') }}" class="flex rounded-[5.87px]">
                <div class="flex justify-center items-center gap-[5.87px] bg-[#0070ff] px-[11.75px] py-[7.34px] rounded-[5.87px] border border-[#0070ff] hover:bg-[#005fe0] transition">
                    <i class="bi bi-plus text-sm text-white"></i>
                    <span class="font-medium text-[10.28px] leading-[14.68px] text-white">Tambah</span>
                </div>
            </a>
            @endif
        </div>
    </div>
@endsection

@section('content-base')
    <div class="flex flex-grow-0 flex-col gap-2 max-w-100">
        @if(isset($role) && $role === 'pegawai' && !$isAdmin && $targetKinerja->isEmpty())
            <div class="text-center py-12 bg-white rounded-lg shadow-sm border border-gray-100">
                <i class="fa-solid fa-bullseye text-4xl text-gray-300 mb-4"></i>
                <p class="text-gray-500 font-medium">Belum ada target KPI yang dibebankan kepada Anda.</p>
            </div>
        @else
            <x-tb id="targetKinerjaTable">
                <x-slot:table_header>
                    <x-tb-td nama="nama" sorting=true>Nama</x-tb-td>
                    <x-tb-td nama="bobot" sorting=true>Bobot</x-tb-td>
                    <x-tb-td nama="responsibility">Responsibility</x-tb-td>
                    <x-tb-td nama="status">Status</x-tb-td>
                    <x-tb-td nama="progress">Progress</x-tb-td>
                    <x-tb-td nama="action">Action</x-tb-td>
                </x-slot:table_header>
                <x-slot:table_column>
                    @foreach ($targetKinerja as $index => $item)
                        <x-tb-cl id="{{ $item->id }}">
                            <x-tb-cl-fill>{{ $item->nama_kpi }}</x-tb-cl-fill>
                            <x-tb-cl-fill>{{ $item->bobot }}</x-tb-cl-fill>
                            <x-tb-cl-fill>{{ $item->responsibility ?? '-' }}</x-tb-cl-fill>
                            <x-tb-cl-fill>
                                @php
                                    $status = $item->status ?? 'pending';
                                    if (isset($role) && $role === 'pegawai' && !$isAdmin) {
                                        $pivot = $item->pegawai->where('id', auth()->id())->first();
                                        if ($pivot) {
                                            $status = $pivot->pivot->status ?? 'pending';
                                        }
                                    }
                                @endphp
                                @if($status === 'approved' || $status === 'completed')
                                    <span class="px-2 py-1 text-xs font-bold rounded-full bg-green-100 text-green-700">Completed</span>
                                @elseif($status === 'rejected' || $status === 'cancelled')
                                    <span class="px-2 py-1 text-xs font-bold rounded-full bg-red-100 text-red-700">Cancelled</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-bold rounded-full bg-yellow-100 text-yellow-700">Pending</span>
                                @endif
                            </x-tb-cl-fill>
                            <x-tb-cl-fill>
                                @php
                                    $progress = $item->target_percent ?? 0;
                                @endphp
                                <div class="flex items-center gap-2">
                                    <div class="w-16 bg-[#f5f5f7] h-2 rounded-full overflow-hidden">
                                        <div class="bg-[#34c759] h-full" style="width: {{ $progress }}%"></div>
                                    </div>
                                    <span class="font-bold text-[#1d1d1f] text-xs">{{ $progress }}%</span>
                                </div>
                            </x-tb-cl-fill>
                            <x-tb-cl-fill>
                                <div class="flex items-center justify-center gap-3">
                                    <a href="{{ route('manage.target-kinerja.view', $item->id) }}" class="flex items-center justify-center w-7 h-7 rounded-md border border-[#d0d5dd] bg-white hover:bg-[#f9fafb] transition duration-150 ease-in-out text-blue-600" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    @if(!(isset($role) && $role === 'pegawai' && !$isAdmin))
                                    <a href="{{ route('manage.target-kinerja.assign', $item->id) }}" class="flex items-center justify-center w-7 h-7 rounded-md border border-[#d0d5dd] bg-white hover:bg-[#f9fafb] transition duration-150 ease-in-out text-green-600" title="Assign Pegawai">
                                        <i class="bi bi-person-plus"></i>
                                    </a>
                                    <a href="{{ route('manage.target-kinerja.edit', $item->id) }}" class="flex items-center justify-center w-7 h-7 rounded-md border border-[#d0d5dd] bg-white hover:bg-[#f9fafb] transition duration-150 ease-in-out text-yellow-600" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('manage.target-kinerja.destroy', $item->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="flex items-center justify-center w-7 h-7 rounded-md border border-[#d0d5dd] bg-white hover:bg-[#f9fafb] transition duration-150 ease-in-out text-red-600" onclick="return confirm('Yakin ingin menghapus data ini?')" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </x-tb-cl-fill>
                        </x-tb-cl>
                    @endforeach
                </x-slot:table_column>
            </x-tb>
        @endif
    </div>
@endsection
