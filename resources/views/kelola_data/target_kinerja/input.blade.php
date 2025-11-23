@php
    $active_sidebar = 'Target Kinerja';
@endphp

@extends('kelola_data.base')

@section('page-name')
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-medium">Tambah Target Kinerja</h2>
            <p class="text-sm text-gray-600">Buat target kinerja baru</p>
        </div>
    </div>
@endsection

@section('content-base')
    <div class="max-w-2xl">
        <form action="{{ route('manage.target-kinerja.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Nama</label>
                <input type="text" name="nama" value="{{ old('nama') }}" class="w-full border rounded px-3 py-2" required>
                @error('nama')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Bobot</label>
                <input type="number" name="bobot" value="{{ old('bobot', 0) }}" class="w-full border rounded px-3 py-2">
                @error('bobot')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Keterangan</label>
                <textarea name="keterangan" class="w-full border rounded px-3 py-2">{{ old('keterangan') }}</textarea>
            </div>

            <div class="mb-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="is_active" value="1" checked class="form-checkbox">
                    <span class="ml-2">Active</span>
                </label>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Simpan</button>
                <a href="{{ route('manage.target-kinerja.list') }}" class="px-4 py-2 bg-gray-300 rounded text-gray-700">Batal</a>
            </div>
        </form>
    </div>
@endsection
