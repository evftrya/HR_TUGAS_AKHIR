<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    /* CSS untuk Accordion */
    .collapse-content {
        display: grid;
        grid-template-rows: 0fr;
        transition: grid-template-rows 0.4s ease-out, opacity 0.3s ease-out;
        opacity: 0;
        overflow: hidden;
    }

    .collapse-content.open {
        grid-template-rows: 1fr;
        opacity: 1;
    }

    .collapse-inner {
        min-height: 0;
    }

    .rotate-180 {
        transform: rotate(180deg);
    }

    /* Z-Index fix for swal */
    .swal2-container {
        z-index: 99999 !important;
    }

    /* Animation for Error Items */
    .error-shake {
        animation: shake 0.5s cubic-bezier(.36, .07, .19, .97) both;
    }

    @keyframes shake {
        10%, 90% { transform: translate3d(-1px, 0, 0); }
        20%, 80% { transform: translate3d(2px, 0, 0); }
        30%, 50%, 70% { transform: translate3d(-4px, 0, 0); }
        40%, 60% { transform: translate3d(4px, 0, 0); }
    }
</style>

<div class="w-full min-h-screen p-6 bg-gray-50/50">
    <div class="max-w-[1400px] mx-auto transition-all duration-700">

        <header class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6 border-b border-gray-100 pb-8">
            <div>
                <h1 class="text-4xl font-bold tracking-tight text-black">Registry Keahlian</h1>
                <p class="text-gray-400 mt-2 text-lg">Kelola struktur kompetensi fakultas dan spesialisasi.</p>
            </div>
            <button id="btnFocusMode" class="hidden lg:flex items-center gap-3 px-8 py-3 bg-black text-white rounded-full text-sm font-bold hover:bg-gray-800 transition-all shadow-lg active:scale-95">
                <span id="txtFocusMode">Mode Fokus Daftar</span>
            </button>
        </header>

        <div id="validation-space">
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-xl error-shake">
                    <div class="flex items-center mb-2">
                        <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-sm font-bold text-red-800">Ups! Ada kesalahan input:</span>
                    </div>
                    <ul class="list-disc list-inside text-xs text-red-600 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-r-xl">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-sm font-bold text-green-800">{{ session('success') }}</span>
                    </div>
                </div>
            @endif
        </div>

        <div class="flex flex-col lg:flex-row gap-12">
            <aside id="sidebar-content" class="w-full lg:w-5/12 space-y-6 transition-all duration-500">
                <nav class="flex p-1.5 bg-gray-100 rounded-2xl w-full">
                    <button id="tabKK" class="flex-1 py-3 px-4 rounded-xl text-sm font-bold transition-all bg-white shadow-sm text-[#0071E3]">KK</button>
                    <button id="tabSubKK" class="flex-1 py-3 px-4 rounded-xl text-sm font-bold transition-all text-gray-400">Sub-KK</button>
                </nav>

                <div class="bg-white rounded-sm border border-gray-200 shadow-sm overflow-hidden">
                    <div class="p-8 border-b border-gray-50 flex justify-between items-center bg-gray-50/30">
                        <h2 id="formTitle" class="text-2xl font-bold text-black">Input Kelompok Keahlian</h2>
                        <div class="w-2.5 h-2.5 rounded-full bg-[#0071E3]"></div>
                    </div>

                    <div id="formBody" class="p-8">
                        <div id="formContainer"></div>
                    </div>
                </div>
            </aside>

            <main id="mainPanel" class="w-full lg:w-7/12 transition-all duration-700">
                <div class="relative mb-8 group">
                    <input type="text" id="searchInput" placeholder="Cari nama, kode, atau deskripsi..."
                        class="w-full pl-8 pr-8 py-3 bg-gray-50 border border-gray-100 rounded-[2rem] outline-none focus:bg-white focus:ring-4 focus:ring-blue-50 focus:border-[#0071E3] transition-all text-lg shadow-inner">
                </div>

                <div id="registryContainer" class="space-y-8">
                </div>
            </main>
        </div>
    </div>
</div>

<template id="tpl-empty">
    <div class="text-center py-12">
        <p class="text-gray-400 text-lg">Pencarian tidak menemukan hasil.</p>
    </div>
</template>

<template id="tpl-fakultas">
    <section class="bg-white rounded-sm border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-8 flex items-center justify-between cursor-pointer hover:bg-gray-50 transition-colors fak-toggle-btn">
            <div class="flex items-center gap-6">
                <div class="w-2 h-12 rounded-full transition-colors fak-indicator bg-black"></div>
                <div>
                    <h3 class="text-2xl font-black text-black fak-nama"></h3>
                    <div class="flex items-center gap-3">
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest fak-kode"></span>
                        <span class="text-[10px] italic text-blue-500 font-medium fak-hint"></span>
                    </div>
                </div>
            </div>
            <div class="p-2.5 rounded-full bg-gray-100 text-gray-400">
                <svg class="w-5 h-5 transition-transform duration-500 fak-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                </svg>
            </div>
        </div>
        <div class="collapse-content fak-collapse">
            <div class="collapse-inner">
                <div class="p-8 pt-0 grid gap-6 kks-container"></div>
            </div>
        </div>
    </section>
</template>

<template id="tpl-kk">
    <div class="bg-gray-50 rounded-sm p-6 border border-transparent hover:border-blue-100 hover:bg-white transition-all duration-300 relative group">
        <div class="flex justify-between items-start mb-4 cursor-pointer kk-toggle-btn">
            <div class="flex-1">
                <div class="flex items-center gap-2">
                    <h4 class="text-lg font-bold kk-nama"></h4>
                    <span class="kk-status-badge"></span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest kk-kode"></span>
                    <span class="text-[9px] italic text-blue-400 font-medium kk-hint"></span>
                </div>
            </div>

            <div class="flex items-center gap-2" onclick="event.stopPropagation()">
                <div class="flex items-center gap-1 mr-2">
                    <button class="btn-status-kk hidden p-2 rounded-lg transition-colors" title="Toggle Status">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                        </svg>
                    </button>
                    <button class="btn-edit-kk p-2 text-blue-500 hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                        </svg>
                    </button>
                    <button class="btn-delete-kk hidden p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </div>

                <div class="p-2.5 rounded-2xl transition-all shadow-sm kk-icon-bg bg-white text-gray-300">
                    <svg class="w-4 h-4 transition-transform duration-300 kk-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
            </div>
        </div>
        <p class="text-[13px] text-gray-500 leading-relaxed kk-desc"></p>
        <div class="collapse-content kk-collapse">
            <div class="collapse-inner mt-6 space-y-3 pt-6 border-t border-gray-200/60 subs-container"></div>
        </div>
    </div>
</template>

<template id="tpl-subkk">
    <div class="bg-white p-5 rounded-sm border border-gray-100 shadow-sm hover:border-blue-200 transition-all group">
        <div class="flex justify-between items-center mb-2">
            <div class="flex items-center gap-2">
                <span class="font-bold text-black text-[13px] subkk-nama"></span>
                <span class="subkk-status-dot w-1.5 h-1.5 rounded-full"></span>
            </div>
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-1">
                    <button class="btn-status-sub hidden p-1.5 hover:bg-gray-50 rounded-lg transition-colors" title="Toggle Status">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                        </svg>
                    </button>
                    <button class="btn-edit-sub p-1.5 text-blue-500 hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                        </svg>
                    </button>
                    <button class="btn-delete-sub hidden p-1.5 text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </div>
                <span class="text-[9px] font-black text-[#0071E3] bg-blue-50 px-2 py-0.5 rounded-lg subkk-kode"></span>
            </div>
        </div>
        <p class="text-[11px] text-gray-400 leading-snug subkk-desc"></p>
    </div>
</template>

<template id="tpl-form-kk">
    <form method="POST" action="{{ route('manage.kelompok-keahlian.store') }}" class="space-y-5">
        @csrf
        <div>
            <label class="block text-xs font-bold text-gray-400 mb-2 ml-1">Fakultas</label>
            <select name="fakultas_id" class="w-full p-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-blue-100 outline-none transition-all select-fakultas" required>
                <option value="" disabled selected>Pilih Fakultas</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-bold text-gray-400 mb-2 ml-1">Nama KK</label>
            <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Masukkan nama lengkap KK..." class="w-full p-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-blue-100 outline-none transition-all" required>
        </div>
        <div>
            <label class="block text-xs font-bold text-gray-400 mb-2 ml-1">Kode KK</label>
            <input type="text" name="kode" value="{{ old('kode') }}" placeholder="KK-01" class="w-full p-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-blue-100 outline-none transition-all" required>
        </div>
        <div>
            <label class="block text-xs font-bold text-gray-400 mb-2 ml-1">Deskripsi Visi</label>
            <textarea name="deskripsi" placeholder="Jelaskan fokus keahlian..." class="w-full p-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-blue-100 outline-none transition-all h-32" required>{{ old('deskripsi') }}</textarea>
        </div>
        <button type="submit" class="w-full bg-[#0071E3] hover:bg-blue-700 text-white py-4 rounded-2xl font-bold shadow-xl transition-all active:scale-95">Simpan KK</button>
    </form>
</template>

<template id="tpl-form-subkk">
    <form method="POST" action="{{ route('manage.kelompok-keahlian.sub.store') }}" class="space-y-5">
        @csrf
        <div>
            <label class="block text-xs font-bold text-gray-400 mb-2 ml-1">Kelompok Keahlian</label>
            <select name="kk_id" class="w-full p-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-blue-100 outline-none transition-all select-kk" required>
                <option value="" disabled selected>Pilih KK Induk</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-bold text-gray-400 mb-2 ml-1">Nama Spesialisasi</label>
            <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Masukkan nama sub-kk..." class="w-full p-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-blue-100 outline-none transition-all" required>
        </div>
        <div>
            <label class="block text-xs font-bold text-gray-400 mb-2 ml-1">Kode Sub-KK</label>
            <input type="text" name="kode" value="{{ old('kode') }}" placeholder="SKK-01" class="w-full p-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-blue-100 outline-none transition-all" required>
        </div>
        <div>
            <label class="block text-xs font-bold text-gray-400 mb-2 ml-1">Deskripsi Teknis</label>
            <textarea name="deskripsi" placeholder="Detail keahlian..." class="w-full p-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-blue-100 outline-none transition-all h-32" required>{{ old('deskripsi') }}</textarea>
        </div>
        <button type="submit" class="w-full bg-black hover:bg-gray-800 text-white py-4 rounded-2xl font-bold shadow-xl transition-all active:scale-95">Daftarkan Sub-KK</button>
    </form>
</template>

<template id="tpl-edit-kk-modal">
    <form class="text-left space-y-4 mt-4">
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1">Fakultas</label>
            <select name="fakultas_id" class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl outline-none focus:border-[#0071E3] select-fakultas-edit" required>
                <option value="" disabled selected>Pilih Fakultas</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1">Nama KK</label>
            <input type="text" name="nama" class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl outline-none focus:border-[#0071E3]" required>
        </div>
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1">Kode KK</label>
            <input type="text" name="kode" class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl outline-none focus:border-[#0071E3]" required>
        </div>
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1">Deskripsi</label>
            <textarea name="deskripsi" class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl h-24 outline-none focus:border-[#0071E3]" required></textarea>
        </div>
        <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
            <button type="button" onclick="Swal.close()" class="px-5 py-2.5 bg-gray-100 text-gray-600 font-bold rounded-xl hover:bg-gray-200 transition-all">Batal</button>
            <button type="submit" class="px-5 py-2.5 bg-[#0071E3] text-white font-bold rounded-xl hover:bg-blue-700 transition-all">Simpan Perubahan</button>
        </div>
    </form>
</template>

<template id="tpl-edit-sub-modal">
    <form class="text-left space-y-4 mt-4">
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1">Kelompok Keahlian</label>
            <select name="kk_id" class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl outline-none focus:border-[#0071E3] select-kk-edit" required>
                <option value="" disabled selected>Pilih KK Induk</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1">Nama Sub-KK</label>
            <input type="text" name="nama" class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl outline-none focus:border-[#0071E3]" required>
        </div>
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1">Kode Sub-KK</label>
            <input type="text" name="kode" class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl outline-none focus:border-[#0071E3]" required>
        </div>
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-1">Deskripsi</label>
            <textarea name="deskripsi" class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl h-24 outline-none focus:border-[#0071E3]" required></textarea>
        </div>
        <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
            <button type="button" onclick="Swal.close()" class="px-5 py-2.5 bg-gray-100 text-gray-600 font-bold rounded-xl hover:bg-gray-200 transition-all">Batal</button>
            <button type="submit" class="px-5 py-2.5 bg-[#0071E3] text-white font-bold rounded-xl hover:bg-blue-700 transition-all">Simpan Perubahan</button>
        </div>
    </form>
</template>

<script>
    // 1. DATA
    const varFakultas = @json($fakultas);
    const varKK = @json($kks);
    const varRegistry = @json($registryData);

    // 2. INITIAL STATE
    let state = {
        isExpanded: false,
        formMode: '{{ old('kk_id') ? 'subkk' : 'kk' }}',
        searchQuery: '',
        activeFakultas: varRegistry.map(f => f.id),
        activeKK: varRegistry.flatMap(f => (f.kks || []).map(kk => kk.id))
    };

    const registryContainer = document.getElementById('registryContainer');
    const searchInput = document.getElementById('searchInput');
    const formContainer = document.getElementById('formContainer');
    const formTitle = document.getElementById('formTitle');
    const tabKK = document.getElementById('tabKK');
    const tabSubKK = document.getElementById('tabSubKK');
    const btnFocusMode = document.getElementById('btnFocusMode');
    const sidebar = document.getElementById('sidebar-content');
    const mainPanel = document.getElementById('mainPanel');
    const txtFocusMode = document.getElementById('txtFocusMode');

    function cloneTemplate(id) {
        return document.getElementById(id).content.cloneNode(true);
    }

    function submitActionForm(actionUrl, dataObj) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = actionUrl;
        for (const key in dataObj) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = key;
            input.value = dataObj[key];
            form.appendChild(input);
        }
        const token = document.createElement('input');
        token.type = 'hidden';
        token.name = '_token';
        token.value = '{{ csrf_token() }}';
        form.appendChild(token);
        document.body.appendChild(form);
        form.submit();
    }

    function fillFakultasSelect(selectEl, selectedId = null) {
        [...varFakultas].sort((a, b) => (a.position_name || a.nama).localeCompare(b.position_name || b.nama))
            .forEach(f => {
                const opt = document.createElement('option');
                opt.value = f.id;
                opt.textContent = f.position_name || f.nama;
                if (f.id == selectedId) opt.selected = true;
                selectEl.appendChild(opt);
            });
    }

    function fillKKSelect(selectEl, selectedId = null) {
        const sortedFakultas = [...varFakultas].sort((a, b) => (a.position_name || a.nama).localeCompare(b.position_name || b.nama));
        sortedFakultas.forEach(f => {
            const kksInFak = varKK.filter(kk => kk.fakultas_id === f.id);
            if (kksInFak.length > 0) {
                const group = document.createElement('optgroup');
                group.label = f.position_name || f.nama;
                [...kksInFak].sort((a, b) => (a.nama || a.nama_kk).localeCompare(b.nama || b.nama_kk))
                    .forEach(kk => {
                        const opt = document.createElement('option');
                        opt.value = kk.id;
                        opt.textContent = kk.nama || kk.nama_kk;
                        if (kk.id == selectedId) opt.selected = true;
                        group.appendChild(opt);
                    });
                selectEl.appendChild(group);
            }
        });
    }

    function renderForm() {
        formContainer.innerHTML = '';
        if (state.formMode === 'kk') {
            formTitle.innerText = "Input Kelompok Keahlian";
            tabKK.className = "flex-1 py-3 px-4 rounded-xl text-sm font-bold transition-all bg-white shadow-sm text-[#0071E3]";
            tabSubKK.className = "flex-1 py-3 px-4 rounded-xl text-sm font-bold transition-all text-gray-400";
            const tpl = cloneTemplate('tpl-form-kk');
            fillFakultasSelect(tpl.querySelector('.select-fakultas'), "{{ old('fakultas_id') }}");
            formContainer.appendChild(tpl);
        } else {
            formTitle.innerText = "Input Sub-Kelompok";
            tabSubKK.className = "flex-1 py-3 px-4 rounded-xl text-sm font-bold transition-all bg-white shadow-sm text-[#0071E3]";
            tabKK.className = "flex-1 py-3 px-4 rounded-xl text-sm font-bold transition-all text-gray-400";
            const tpl = cloneTemplate('tpl-form-subkk');
            fillKKSelect(tpl.querySelector('.select-kk'), "{{ old('kk_id') }}");
            formContainer.appendChild(tpl);
        }
    }

    function renderRegistry() {
        registryContainer.innerHTML = '';
        const keywords = state.searchQuery.toLowerCase().trim().split(/\s+/).filter(k => k);
        const isMatch = (str) => {
            if (!str) return false;
            const text = str.toLowerCase();
            return keywords.length === 0 || keywords.every(kw => text.includes(kw));
        };

        const filtered = varRegistry.map(fak => {
            const fakMatch = isMatch(fak.nama_fakultas) || isMatch(fak.kode_fakultas);
            const mappedKKs = (fak.kks || []).map(kk => {
                const kkMatch = isMatch(kk.nama_kk) || isMatch(kk.kode_kk) || isMatch(kk.deskripsi);
                const matchedSubs = (kk.subs || []).filter(s => isMatch(s.nama_sub_kk) || isMatch(s.kode_sub_kk) || isMatch(s.deskripsi_sub));
                const subMatch = matchedSubs.length > 0;
                if (keywords.length > 0 && (fakMatch || kkMatch || subMatch)) {
                    if (!state.activeFakultas.includes(fak.id)) state.activeFakultas.push(fak.id);
                    if (!state.activeKK.includes(kk.id)) state.activeKK.push(kk.id);
                }
                return { ...kk, subs: (fakMatch || kkMatch || keywords.length === 0) ? kk.subs : matchedSubs, _isMatch: (kkMatch || subMatch) };
            }).filter(kk => fakMatch || kk._isMatch);
            return { ...fak, kks: mappedKKs, _isFakMatch: fakMatch };
        }).filter(fak => fak._isFakMatch || fak.kks.length > 0);

        if (filtered.length === 0) {
            registryContainer.appendChild(cloneTemplate('tpl-empty'));
            return;
        }

        filtered.forEach(fak => {
            const fakNode = cloneTemplate('tpl-fakultas');
            const isFakActive = state.activeFakultas.includes(fak.id);
            fakNode.querySelector('.fak-nama').textContent = fak.nama_fakultas;
            fakNode.querySelector('.fak-kode').textContent = fak.kode_fakultas;
            fakNode.querySelector('.fak-hint').textContent = isFakActive ? "(Klik untuk menutup)" : "(Klik untuk membuka)";

            if (isFakActive) {
                fakNode.querySelector('.fak-indicator').classList.replace('bg-black', 'bg-[#0071E3]');
                fakNode.querySelector('.fak-icon').classList.add('rotate-180');
                fakNode.querySelector('.fak-collapse').classList.add('open');
            }

            fakNode.querySelector('.fak-toggle-btn').onclick = () => {
                if (isFakActive) state.activeFakultas = state.activeFakultas.filter(id => id !== fak.id);
                else state.activeFakultas.push(fak.id);
                renderRegistry();
            };

            const kksContainer = fakNode.querySelector('.kks-container');
            kksContainer.classList.add(state.isExpanded ? 'lg:grid-cols-2' : 'grid-cols-1');

            fak.kks.forEach(kk => {
                const kkNode = cloneTemplate('tpl-kk');
                const isKKActive = state.activeKK.includes(kk.id);
                const isActive = kk.is_active != 0;

                kkNode.querySelector('.kk-nama').textContent = kk.nama_kk;
                kkNode.querySelector('.kk-kode').textContent = kk.kode_kk;
                kkNode.querySelector('.kk-desc').textContent = (!kk.deskripsi || kk.deskripsi === '-') ? 'Tidak ada deskripsi.' : kk.deskripsi;
                kkNode.querySelector('.kk-hint').textContent = isKKActive ? "(Tutup detail)" : "(Buka detail)";

                const statusBadge = kkNode.querySelector('.kk-status-badge');
                statusBadge.textContent = isActive ? 'Aktif' : 'Non-aktif';
                statusBadge.className = `text-[8px] px-2 py-0.5 rounded-full font-bold ${isActive ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600'}`;

                // Logic Edit KK
                kkNode.querySelector('.btn-edit-kk').onclick = (e) => {
                    e.stopPropagation();
                    const formElement = cloneTemplate('tpl-edit-kk-modal').firstElementChild;
                    fillFakultasSelect(formElement.querySelector('.select-fakultas-edit'), fak.id);
                    formElement.querySelector('[name="nama"]').value = kk.nama_kk;
                    formElement.querySelector('[name="kode"]').value = kk.kode_kk;
                    formElement.querySelector('[name="deskripsi"]').value = kk.deskripsi || '';

                    Swal.fire({
                        title: 'Edit Kelompok Keahlian',
                        html: formElement,
                        showConfirmButton: false,
                        customClass: { popup: 'rounded-3xl' },
                        didOpen: () => {
                            formElement.onsubmit = (ev) => {
                                ev.preventDefault();
                                const fData = new FormData(ev.target);
                                const routekkedit = "{{ route('manage.kelompok-keahlian.update', ['id' => 'isi-id']) }}".replace("isi-id", kk.id);
                                submitActionForm(routekkedit, {
                                    _method: 'POST',
                                    fakultas_id: fData.get('fakultas_id'),
                                    nama: fData.get('nama'),
                                    kode: fData.get('kode'),
                                    deskripsi: fData.get('deskripsi')
                                });
                            };
                        }
                    });
                };

                // Toggle & Delete Logic (untuk KK) dilewati krn button hidden
                
                if (isKKActive) {
                    const iconBg = kkNode.querySelector('.kk-icon-bg');
                    iconBg.classList.replace('bg-white', 'bg-[#0071E3]');
                    iconBg.classList.replace('text-gray-300', 'text-white');
                    kkNode.querySelector('.kk-icon').classList.add('rotate-180');
                    kkNode.querySelector('.kk-collapse').classList.add('open');
                }

                kkNode.querySelector('.kk-toggle-btn').onclick = () => {
                    if (isKKActive) state.activeKK = state.activeKK.filter(id => id !== kk.id);
                    else state.activeKK.push(kk.id);
                    renderRegistry();
                };

                const subsContainer = kkNode.querySelector('.subs-container');
                (kk.subs || []).forEach(sub => {
                    const subNode = cloneTemplate('tpl-subkk');
                    const isSubActive = sub.is_active != 0;

                    subNode.querySelector('.subkk-nama').textContent = sub.nama_sub_kk;
                    subNode.querySelector('.subkk-kode').textContent = sub.kode_sub_kk;
                    subNode.querySelector('.subkk-desc').textContent = (!sub.deskripsi_sub || sub.deskripsi_sub === '-') ? 'Spesialisasi teknis.' : sub.deskripsi_sub;

                    const dot = subNode.querySelector('.subkk-status-dot');
                    dot.classList.add(isSubActive ? 'bg-green-500' : 'bg-red-400');

                    // Edit Sub-KK
                    subNode.querySelector('.btn-edit-sub').onclick = () => {
                        const formElement = cloneTemplate('tpl-edit-sub-modal').firstElementChild;
                        fillKKSelect(formElement.querySelector('.select-kk-edit'), kk.id);
                        formElement.querySelector('[name="nama"]').value = sub.nama_sub_kk;
                        formElement.querySelector('[name="kode"]').value = sub.kode_sub_kk;
                        formElement.querySelector('[name="deskripsi"]').value = sub.deskripsi_sub || '';

                        Swal.fire({
                            title: 'Edit Sub-Kelompok',
                            html: formElement,
                            showConfirmButton: false,
                            customClass: { popup: 'rounded-3xl' },
                            didOpen: () => {
                                formElement.onsubmit = (ev) => {
                                    ev.preventDefault();
                                    const fData = new FormData(ev.target);
                                    const routeSubKK = "{{ route('manage.kelompok-keahlian.sub.update', ['id' => 'isi-id']) }}".replace("isi-id", sub.id);
                                    submitActionForm(routeSubKK, {
                                        _method: 'POST',
                                        kk_id: fData.get('kk_id'),
                                        nama: fData.get('nama'),
                                        kode: fData.get('kode'),
                                        deskripsi: fData.get('deskripsi')
                                    });
                                };
                            }
                        });
                    };

                    subsContainer.appendChild(subNode);
                });
                kksContainer.appendChild(kkNode);
            });
            registryContainer.appendChild(fakNode);
        });
    }

    searchInput.oninput = (e) => {
        state.searchQuery = e.target.value;
        renderRegistry();
    };

    tabKK.onclick = () => {
        state.formMode = 'kk';
        renderForm();
    };

    tabSubKK.onclick = () => {
        state.formMode = 'subkk';
        renderForm();
    };

    btnFocusMode.onclick = () => {
        state.isExpanded = !state.isExpanded;
        sidebar.classList.toggle('hidden', state.isExpanded);
        mainPanel.classList.toggle('lg:w-7/12', !state.isExpanded);
        mainPanel.classList.toggle('w-full', state.isExpanded);
        txtFocusMode.innerText = state.isExpanded ? "Tampilkan Semua Panel" : "Mode Fokus Daftar";
        renderRegistry();
    };

    renderForm();
    renderRegistry();
</script>