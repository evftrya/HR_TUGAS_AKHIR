@php
    $active_sidebar = 'COE';
@endphp

@extends('kelola_data.base')

@section('header-base')
    <style>
        .max-w-100 { max-width: 100% !important; }
    </style>
@endsection

@section('page-name')
    <div class="flex flex-col md:flex-row items-center gap-3 self-stretch px-1 pt-4 pb-3">
        <div class="flex w-full flex-col gap-1 grow">
            <div class="flex items-center gap-2">
                <span class="font-medium text-2xl text-[#101828]">Center Of Excellence (COE)</span>
            </div>
            <span class="text-sm text-[#1f2028]">Kelola Center of Excellence</span>
        </div>
        <div class="flex items-center w-full justify-end gap-[11.749480247497559px]">
            <a href="{{ route('manage.coe.create') }}" class="flex rounded-[5.874740123748779px]">
                <div class="flex justify-center items-center gap-[5.874740123748779px] bg-[#0070ff] px-[11.749480247497559px] py-[7.343425273895264px] rounded-[5.874740123748779px] border border-[#0070ff] hover:bg-[#005fe0] transition">
                    <i class="bi bi-plus text-sm text-white"></i>
                    <span class="font-medium text-[10.28px] leading-[14.68px] text-white">Tambah COE</span>
                </div>
            </a>
        </div>
    </div>
@endsection

@section('content-base')
    <div class="flex flex-col gap-4 w-full max-w-100 mx-auto">
        @if(session('success'))
            <div class="rounded-md bg-green-50 p-4">
                <div class="text-sm text-green-700">{{ session('success') }}</div>
            </div>
        @endif

        <div class="flex flex-col gap-4 rounded-md border p-6 bg-white">
                    <h3 class="text-lg font-semibold text-gray-800">Daftar COE</h3>
                    <div class="text-sm text-gray-600">Total: <span class="font-semibold">{{ $coes->count() }}</span> COE</div>

            <div class="overflow-x-auto bg-white rounded-lg">
                {{-- <div class="flex justify-between items-center p-4 border-b">

                </div> --}}

                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border">No.</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border">Nama COE</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider border">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($coes as $index => $c)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-center border">{{ $index + 1 }}</td>
                                <td class="px-4 py-3 border">
                                    <div class="font-medium text-gray-900">{{ $c->nama_coe }}</div>
                                </td>
                                <td class="px-4 py-3 text-center border">
                                    <div class="flex gap-2 justify-center">
                                        <a href="{{ route('manage.coe.show', $c->id) }}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-gray-600 text-white text-xs font-medium rounded hover:bg-gray-700 transition">
                                            <i class="bi bi-eye"></i>
                                            Lihat
                                        </a>
                                        <a href="{{ route('manage.coe.edit', $c->id) }}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-600 text-white text-xs font-medium rounded hover:bg-blue-700 transition">
                                            <i class="bi bi-pencil-square"></i>
                                            Edit
                                        </a>
                                        <button onclick="confirmDelete('{{ $c->id }}', '{{ $c->nama_coe }}')" class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-600 text-white text-xs font-medium rounded hover:bg-red-700 transition">
                                            <i class="bi bi-trash"></i>
                                            Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-8 text-center text-gray-500">
                                    Belum ada data COE.
                                    <a href="{{ route('manage.coe.create') }}" class="text-blue-600 hover:underline">Tambah COE baru</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="flex justify-end gap-4">
            {{ $coes->links() }}
        </div>
    </div>

    {{-- Delete Modal --}}
    <div id="deleteModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 rounded-lg bg-white">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                    <i class="bi bi-exclamation-triangle text-red-600 text-2xl"></i>
                </div>
                <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4">Hapus COE</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500">Apakah Anda yakin ingin menghapus COE <strong id="deleteCoeName"></strong>?</p>
                    <p class="text-xs text-red-600 mt-2">Tindakan ini tidak dapat dibatalkan!</p>
                </div>
                <div class="flex gap-3 px-4 py-3">
                    <button onclick="closeDeleteModal()" class="flex-1 px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition">Batal</button>
                    <form id="deleteForm" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(coeId, coeName) {
            document.getElementById('deleteCoeName').textContent = coeName;
            document.getElementById('deleteForm').action = `/manage/coe/${coeId}`;
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        document.getElementById('deleteModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });
    </script>
@endsection
