@php
    $active_sidebar = 'COE';
@endphp

@extends('kelola_data.base')

@section('page-name')
    <div class="flex items-center justify-between px-1 pt-4 pb-3">
        <div>
            <span class="font-medium text-2xl">Edit COE</span>
            <div class="text-sm text-gray-600">Perbarui data Center of Excellence</div>
        </div>
    </div>
@endsection

@section('content-base')
    <div class="flex flex-col gap-4 w-full max-w-2xl mx-auto">
        @if($errors->any())
            <div class="rounded-md bg-red-50 p-4">
                <ul class="text-sm text-red-700">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="rounded-md border p-6 bg-white">
            <form action="{{ route('manage.coe.update', $coe->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Nama COE</label>
                    <input type="text" name="nama_coe" value="{{ old('nama_coe', $coe->nama_coe) }}" class="mt-1 block w-full rounded-md border-gray-300" required>
                </div>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('manage.coe.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">Batal</a>
                    <button class="px-4 py-2 bg-[#0070ff] text-white rounded hover:bg-[#005fe0]">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
