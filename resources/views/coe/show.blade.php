@php
    $active_sidebar = 'COE';
@endphp

@extends('kelola_data.base')

@section('page-name')
    <div class="flex items-center justify-between px-1 pt-4 pb-3">
        <div>
            <span class="font-medium text-2xl">Detail COE</span>
            <div class="text-sm text-gray-600">Informasi Center of Excellence</div>
        </div>
    </div>
@endsection

@section('content-base')
    <div class="flex flex-col gap-4 w-full max-w-2xl mx-auto">
        <div class="rounded-md border p-6 bg-white">
            <h3 class="text-lg font-semibold mb-2">{{ $coe->nama_coe }}</h3>
            <p class="text-sm text-gray-600"><strong>ID:</strong> {{ $coe->id }}</p>
        </div>

        <div class="flex justify-end">
            <a href="{{ route('manage.coe.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">Kembali</a>
        </div>
    </div>
@endsection
