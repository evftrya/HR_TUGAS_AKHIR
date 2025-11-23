@php
    $active_sidebar = 'Target Kinerja';
@endphp

@extends('kelola_data.base')

@section('page-name')
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-medium">Edit Target Kinerja</h2>
            <p class="text-sm text-gray-600">Ubah data target kinerja</p>
        </div>
    </div>
@endsection

@section('content-base')
    <div class="max-w-2xl">
        <form action="{{ route('manage.target-kinerja.update', $targetKinerja->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Nama</label>
                <input type="text" name="nama" value="{{ old('nama', $targetKinerja->nama) }}" class="w-full border rounded px-3 py-2" required>
                @error('nama')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Bobot</label>
                <input type="number" name="bobot" value="{{ old('bobot', $targetKinerja->bobot) }}" class="w-full border rounded px-3 py-2">
                @error('bobot')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Keterangan</label>
                <textarea name="keterangan" class="w-full border rounded px-3 py-2">{{ old('keterangan', $targetKinerja->keterangan) }}</textarea>
            </div>

            <div class="mb-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="is_active" value="1" {{ $targetKinerja->is_active ? 'checked' : '' }} class="form-checkbox">
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
