@php
    $active_sidebar = 'Target Kinerja';
@endphp

@extends('kelola_data.base')

@section('page-name')
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-medium">Detail Target Kinerja</h2>
            <p class="text-sm text-gray-600">Detail dan informasi target kinerja</p>
        </div>
    </div>
@endsection

@section('content-base')
    <div class="max-w-2xl">
        <div class="mb-4">
            <h3 class="font-semibold">Nama</h3>
            <p>{{ $targetKinerja->nama }}</p>
        </div>

        <div class="mb-4">
            <h3 class="font-semibold">Bobot</h3>
            <p>{{ $targetKinerja->bobot }}</p>
        </div>

        <div class="mb-4">
            <h3 class="font-semibold">Keterangan</h3>
            <p>{{ $targetKinerja->keterangan ?? '-' }}</p>
        </div>

        <div class="mb-4">
            <h3 class="font-semibold">Active</h3>
            <p>{{ $targetKinerja->is_active ? 'Ya' : 'Tidak' }}</p>
        </div>

        <div class="flex gap-2">
            <a href="{{ route('manage.target-kinerja.edit', $targetKinerja->id) }}" class="px-4 py-2 bg-yellow-400 rounded">Edit</a>
            <a href="{{ route('manage.target-kinerja.list') }}" class="px-4 py-2 bg-gray-300 rounded">Kembali</a>
        </div>
    </div>
@endsection
