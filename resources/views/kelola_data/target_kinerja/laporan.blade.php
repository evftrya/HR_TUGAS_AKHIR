@php
    $active_sidebar = 'Target Kinerja';
@endphp

@extends('kelola_data.base')

@section('page-name')
    <div class="flex flex-col md:flex-row items-center gap-3 self-stretch px-1 pt-4 pb-3">
        <div class="flex w-full flex-col gap-1 grow">
            <div class="flex items-center gap-2">
                <span class="font-medium text-2xl text-[#101828]">Laporan Target Kinerja</span>
            </div>
            <span class="font-normal text-sm text-[#1f2028]">Rekap data target kinerja pegawai/dosen</span>
        </div>
    </div>
@endsection

@section('content-base')
    <div class="flex flex-col gap-8 w-full max-w-100 mx-auto">
        <form method="GET" class="flex flex-wrap gap-4 mb-4">
            <div>
                <label class="block text-xs mb-1">Pegawai</label>
                <select name="user_id" class="border rounded px-2 py-1 min-w-[180px]">
                    <option value="">Semua</option>
                    @foreach($allUsers as $user)
                        <option value="{{ $user->id }}" @if(request('user_id') == $user->id) selected @endif>{{ $user->nama_lengkap }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs mb-1">Target</label>
                <select name="target_id" class="border rounded px-2 py-1 min-w-[180px]">
                    <option value="">Semua</option>
                    @foreach($allTargets as $target)
                        <option value="{{ $target->id }}" @if(request('target_id') == $target->id) selected @endif>{{ $target->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs mb-1">Status</label>
                <select name="status" class="border rounded px-2 py-1 min-w-[120px]">
                    <option value="">Semua</option>
                    <option value="pending" @if(request('status')=='pending') selected @endif>Pending</option>
                    <option value="in_progress" @if(request('status')=='in_progress') selected @endif>In Progress</option>
                    <option value="completed" @if(request('status')=='completed') selected @endif>Completed</option>
                    <option value="cancelled" @if(request('status')=='cancelled') selected @endif>Cancelled</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Filter</button>
            </div>
        </form>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left">Pegawai/Dosen</th>
                        <th class="px-4 py-2 text-left">Target Kinerja</th>
                        <th class="px-4 py-2 text-left">Bobot</th>
                        <th class="px-4 py-2 text-left">Tanggal Mulai</th>
                        <th class="px-4 py-2 text-left">Tanggal Selesai</th>
                        <th class="px-4 py-2 text-left">Status</th>
                        <th class="px-4 py-2 text-left">Catatan</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($targetKinerjaList as $target)
                        @foreach($target->pegawai as $pegawai)
                            <tr>
                                <td class="px-4 py-2">{{ $pegawai->nama_lengkap }}</td>
                                <td class="px-4 py-2">{{ $target->nama }}</td>
                                <td class="px-4 py-2">{{ $target->bobot }}</td>
                                <td class="px-4 py-2">{{ $pegawai->pivot->tanggal_mulai }}</td>
                                <td class="px-4 py-2">{{ $pegawai->pivot->tanggal_selesai }}</td>
                                <td class="px-4 py-2 capitalize">{{ $pegawai->pivot->status }}</td>
                                <td class="px-4 py-2">{{ $pegawai->pivot->catatan }}</td>
                            </tr>
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-gray-500">Tidak ada data laporan target kinerja</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
