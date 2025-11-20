<!-- Modal Tambah Prodi -->
<div id="createModal" class="fixed inset-0 z-50 hidden flex items-center justify-center">
    <div id="createModalBackdrop" class="absolute inset-0 bg-black bg-opacity-50"></div>
    <div class="relative bg-white rounded-lg shadow-xl w-full max-w-sm mx-4 overflow-hidden z-10">
        <!-- Header -->
        <div class="text-center px-6 pt-6">
            <h2 class="text-3xl font-semibold text-gray-900">Tambah Prodi</h2>
        </div>

        <!-- Body -->
        <div class="p-6 space-y-4">
            <form id="createProdiForm" method="POST" action="{{ route('manage.prodi.store') }}">
                @csrf

                <!-- Kode Prodi -->
                <div>
                    <label for="kode_modal" class="block text-sm font-semibold text-gray-700 mb-1">Kode
                        Prodi</label>
                    <input id="kode_modal" name="kode" type="text" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition"
                        placeholder="Contoh: TI">
                </div>

                <!-- Nama Prodi -->
                <div>
                    <label for="nama_prodi_modal" class="block text-sm font-semibold text-gray-700 mb-1">Nama
                        Prodi</label>
                    <input id="nama_prodi_modal" name="position_name" type="text" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition"
                        placeholder="Contoh: Teknik Informatika">
                </div>

                <!-- Fakultas -->
                <div>
                    <label for="fakultas_id_modal" class="block text-sm font-semibold text-gray-700 mb-1">Nama
                        Fakultas</label>
                    <select id="fakultas_id_modal" name="fakultas_id" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition bg-white">
                        <option value="">-- Pilih Fakultas --</option>
                        @foreach ($fakultas as $f)
                            <option value="{{ $f->id }}">{{ $f->position_name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Tombol -->
                <div class="flex justify-between mt-6">
                    <button type="button" id="cancelCreateModal"
                        class="w-1/2 mr-2 py-2 rounded-md bg-red-500 text-white font-medium hover:bg-red-600 transition">
                        Tutup
                    </button>
                    <button type="submit"
                        class="w-1/2 ml-2 py-2 rounded-md bg-blue-600 text-white font-medium hover:bg-blue-700 transition">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    (function() {
        const openBtn = document.getElementById('openCreateModal');
        const modal = document.getElementById('createModal');
        const backdrop = document.getElementById('createModalBackdrop');
        const cancelBtn = document.getElementById('cancelCreateModal');

        function showModal() {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function hideModal() {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }

        if (openBtn) openBtn.addEventListener('click', showModal);
        if (cancelBtn) cancelBtn.addEventListener('click', hideModal);
        if (backdrop) backdrop.addEventListener('click', hideModal);
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') hideModal();
        });
    })();
</script>
