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

        /* Inner container agar konten tidak terpotong saat animasi */
        .collapse-inner {
            min-height: 0;
        }

        /* Transisi halus untuk rotasi icon */
        .rotate-180 {
            transform: rotate(180deg);
        }
    </style>
</head>
<body class="bg-gray-50/50">

<div class="w-full min-h-screen p-6">
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

        <div class="flex flex-col lg:flex-row gap-12">
            
            <aside id="sidebar-content" class="w-full lg:w-5/12 space-y-6 transition-all duration-500">
                <nav class="flex p-1.5 bg-gray-100 rounded-2xl w-full">
                    <button id="tabKK" class="flex-1 py-3 px-4 rounded-xl text-sm font-bold transition-all bg-white shadow-sm text-[#0071E3]">KK</button>
                    <button id="tabSubKK" class="flex-1 py-3 px-4 rounded-xl text-sm font-bold transition-all text-gray-400">Sub-KK</button>
                </nav>

                <div class="bg-white rounded-[2.5rem] border border-gray-200 shadow-sm overflow-hidden">
                    <div class="p-8 border-b border-gray-50 flex justify-between items-center bg-gray-50/30">
                        <h2 id="formTitle" class="text-2xl font-bold text-black">Input Kelompok Keahlian</h2>
                        <div class="w-2.5 h-2.5 rounded-full bg-[#0071E3]"></div>
                    </div>

                    <div id="formBody" class="p-8 space-y-6">
                        </div>
                </div>
            </aside>

            <main id="mainPanel" class="w-full lg:w-7/12 transition-all duration-700">
                <div class="relative mb-8 group">
                    <input type="text" id="searchInput" placeholder="Cari nama, kode, atau deskripsi..."
                        class="w-full pl-8 pr-8 py-5.5 bg-gray-50 border border-gray-100 rounded-[2rem] outline-none focus:bg-white focus:ring-4 focus:ring-blue-50 focus:border-[#0071E3] transition-all text-lg shadow-inner">
                </div>

                <div id="registryContainer" class="space-y-8">
                    </div>
            </main>
        </div>
    </div>
</div>

<script>
    // --- DATABASE ---
    const database = [
        {
            id: 'f1',
            name: 'Informatika (FIF)',
            code: 'FIF',
            kks: [
                {
                    id: 'kk1',
                    name: 'Intelligent Systems',
                    code: 'KK-IS',
                    desc: 'Berfokus pada pengembangan algoritma cerdas, pemrosesan bahasa alami, dan sistem otonom untuk masa depan digital yang lebih intuitif.',
                    subs: [
                        { id: 's1', name: 'Machine Learning', code: 'SKK-ML', desc: 'Sistem yang belajar dari pola data tanpa instruksi eksplisit.' },
                        { id: 's2', name: 'Computer Vision', code: 'SKK-CV', desc: 'Menganalisis objek visual dari gambar dan video secara real-time.' },
                        { id: 's3', name: 'Natural Language Processing', code: 'SKK-NLP', desc: 'Teknologi pemersoesan bahasa untuk chatbot dan asisten virtual.' }
                    ]
                },
                {
                    id: 'kk2',
                    name: 'Cyber Security',
                    code: 'KK-CS',
                    desc: 'Perlindungan menyeluruh terhadap integritas jaringan dan data dari ancaman eksternal yang terus berkembang.',
                    subs: [
                        { id: 's4', name: 'Network Security', code: 'SKK-NS', desc: 'Keamanan perimeter jaringan dan kontrol akses.' },
                        { id: 's5', name: 'Cryptography', code: 'SKK-CRY', desc: 'Matematika tingkat lanjut untuk enkripsi data sensitif.' }
                    ]
                }
            ]
        },
        {
            id: 'f2',
            name: 'Rekayasa Industri (FRI)',
            code: 'FRI',
            kks: [{
                id: 'kk3',
                name: 'Supply Chain Management',
                code: 'KK-SCM',
                desc: 'Manajemen alur logistik global yang mengintegrasikan efisiensi produksi dengan kecepatan distribusi.',
                subs: [
                    { id: 's7', name: 'Inventory Control', code: 'SKK-IC', desc: 'Manajemen stok menggunakan metode Just-In-Time.' },
                    { id: 's8', name: 'Logistics Systems', code: 'SKK-LOG', desc: 'Optimalisasi rute distribusi untuk efisiensi biaya.' }
                ]
            }]
        }
    ];

    // --- STATE ---
    let state = {
        isExpanded: false,
        formMode: 'kk',
        searchQuery: '',
        activeFakultas: ['f1'], // Secara default satu dibuka
        activeKK: []
    };

    // --- DOM ELEMENTS ---
    const registryContainer = document.getElementById('registryContainer');
    const searchInput = document.getElementById('searchInput');
    const formBody = document.getElementById('formBody');
    const formTitle = document.getElementById('formTitle');
    const tabKK = document.getElementById('tabKK');
    const tabSubKK = document.getElementById('tabSubKK');
    const btnFocusMode = document.getElementById('btnFocusMode');
    const sidebar = document.getElementById('sidebar-content');
    const mainPanel = document.getElementById('mainPanel');
    const txtFocusMode = document.getElementById('txtFocusMode');

    // --- FUNCTIONS ---

    function renderForm() {
        if (state.formMode === 'kk') {
            formTitle.innerText = "Input Kelompok Keahlian";
            formBody.innerHTML = `
                <div class="space-y-5">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 mb-2 ml-1">Nama KK</label>
                        <input type="text" placeholder="Masukkan nama lengkap KK..." class="w-full p-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-blue-100 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 mb-2 ml-1">Kode KK</label>
                        <input type="text" placeholder="KK-01" class="w-full p-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-blue-100 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 mb-2 ml-1">Deskripsi Visi</label>
                        <textarea placeholder="Jelaskan fokus keahlian..." class="w-full p-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-blue-100 outline-none transition-all h-32"></textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 mb-2 ml-1">Fakultas</label>
                        <select class="w-full p-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-blue-100 outline-none transition-all">
                            <option value="" disabled selected>Pilih Fakultas</option>
                            ${database.map(f => `<option value="${f.id}">${f.name}</option>`).join('')}
                        </select>
                    </div>
                    <button class="w-full bg-[#0071E3] hover:bg-blue-700 text-white py-4.5 rounded-2xl font-bold shadow-xl shadow-blue-100 transition-all active:scale-95 py-4">Simpan KK</button>
                </div>
            `;
        } else {
            formTitle.innerText = "Input Sub-Kelompok";
            formBody.innerHTML = `
                <div class="space-y-5">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 mb-2 ml-1">Nama Spesialisasi</label>
                        <input type="text" placeholder="Masukkan nama sub-kk..." class="w-full p-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-blue-100 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 mb-2 ml-1">Kode Sub-KK</label>
                        <input type="text" placeholder="SKK-01" class="w-full p-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-blue-100 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 mb-2 ml-1">Deskripsi Teknis</label>
                        <textarea placeholder="Detail keahlian..." class="w-full p-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-blue-100 outline-none transition-all h-32"></textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 mb-2 ml-1">Kelompok Keahlian</label>
                        <select class="w-full p-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-blue-100 outline-none transition-all">
                            <option value="" disabled selected>Pilih KK Induk</option>
                            ${database.map(f => `
                                <optgroup label="${f.name}">
                                    ${f.kks.map(kk => `<option value="${kk.id}">${kk.name}</option>`).join('')}
                                </optgroup>
                            `).join('')}
                        </select>
                    </div>
                    <button class="w-full bg-black hover:bg-gray-800 text-white py-4.5 rounded-2xl font-bold shadow-xl transition-all active:scale-95 py-4">Daftarkan Sub-KK</button>
                </div>
            `;
        }
    }

    function renderRegistry() {
        const q = state.searchQuery.toLowerCase();
        
        // Logika Filter
        const filteredData = database.map(fak => {
            const fakMatch = fak.name.toLowerCase().includes(q) || fak.code.toLowerCase().includes(q);
            const matchedKKs = fak.kks.filter(kk => {
                const kkMatch = kk.name.toLowerCase().includes(q) || kk.code.toLowerCase().includes(q) || kk.desc.toLowerCase().includes(q);
                const subMatch = kk.subs.some(sub => sub.name.toLowerCase().includes(q) || sub.code.toLowerCase().includes(q) || sub.desc.toLowerCase().includes(q));
                
                // Auto expand saat search
                if (q.trim() !== "" && (kkMatch || subMatch)) {
                    if (!state.activeKK.includes(kk.id)) state.activeKK.push(kk.id);
                    if (!state.activeFakultas.includes(fak.id)) state.activeFakultas.push(fak.id);
                }

                return kkMatch || subMatch;
            });
            return { ...fak, kks: matchedKKs, isFakMatch: fakMatch };
        }).filter(fak => fak.isFakMatch || fak.kks.length > 0);

        // Render ke DOM
        registryContainer.innerHTML = filteredData.map(fak => `
            <section class="bg-white rounded-[2.5rem] border border-gray-100 shadow-sm overflow-hidden">
                <div onclick="toggleFakultas('${fak.id}')" class="p-8 flex items-center justify-between cursor-pointer hover:bg-gray-50 transition-colors">
                    <div class="flex items-center gap-6">
                        <div class="w-2 h-12 ${state.activeFakultas.includes(fak.id) ? 'bg-[#0071E3]' : 'bg-black'} rounded-full transition-colors"></div>
                        <div>
                            <h3 class="text-2xl font-black text-black">${fak.name}</h3>
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">KODE: ${fak.code}</span>
                        </div>
                    </div>
                    <div class="p-2.5 rounded-full bg-gray-100 text-gray-400">
                        <svg class="w-5 h-5 transition-transform duration-500 ${state.activeFakultas.includes(fak.id) ? 'rotate-180' : ''}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>

                <div class="collapse-content ${state.activeFakultas.includes(fak.id) ? 'open' : ''}">
                    <div class="collapse-inner">
                        <div class="p-8 pt-0 grid gap-6 ${state.isExpanded ? 'lg:grid-cols-2' : 'grid-cols-1'}">
                            ${fak.kks.map(kk => `
                                <div class="bg-gray-50 rounded-[2rem] p-6 border border-transparent hover:border-blue-100 hover:bg-white transition-all duration-300">
                                    <div class="flex justify-between items-start mb-4 cursor-pointer" onclick="toggleKK('${kk.id}')">
                                        <div class="flex-1">
                                            <h4 class="text-lg font-bold ${state.activeKK.includes(kk.id) ? 'text-[#0071E3]' : 'text-black'}">${kk.name}</h4>
                                            <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest">${kk.code}</span>
                                        </div>
                                        <div class="p-2.5 rounded-2xl transition-all shadow-sm ${state.activeKK.includes(kk.id) ? 'bg-[#0071E3] text-white' : 'bg-white text-gray-300'}">
                                            <svg class="w-4 h-4 transition-transform duration-300 ${state.activeKK.includes(kk.id) ? 'rotate-180' : ''}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <p class="text-[13px] text-gray-500 leading-relaxed">${kk.desc}</p>

                                    <div class="collapse-content ${state.activeKK.includes(kk.id) ? 'open' : ''}">
                                        <div class="collapse-inner mt-6 space-y-3 pt-6 border-t border-gray-200/60">
                                            ${kk.subs.map(sub => `
                                                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:border-blue-200 transition-all">
                                                    <div class="flex justify-between items-center mb-2">
                                                        <span class="font-bold text-black text-[13px]">${sub.name}</span>
                                                        <span class="text-[9px] font-black text-[#0071E3] bg-blue-50 px-2 py-0.5 rounded-lg">${sub.code}</span>
                                                    </div>
                                                    <p class="text-[11px] text-gray-400 leading-snug">${sub.desc}</p>
                                                </div>
                                            `).join('')}
                                        </div>
                                    </div>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                </div>
            </section>
        `).join('');
    }

    // --- INTERACTIVITY ---

    window.toggleFakultas = (id) => {
        if (state.activeFakultas.includes(id)) {
            state.activeFakultas = state.activeFakultas.filter(fid => fid !== id);
        } else {
            state.activeFakultas.push(id);
        }
        renderRegistry();
    }

    window.toggleKK = (id) => {
        if (state.activeKK.includes(id)) {
            state.activeKK = state.activeKK.filter(kid => kid !== id);
        } else {
            state.activeKK.push(id);
        }
        renderRegistry();
    }

    // Search event
    searchInput.addEventListener('input', (e) => {
        state.searchQuery = e.target.value;
        renderRegistry();
    });

    // Tab switcher
    tabKK.addEventListener('click', () => {
        state.formMode = 'kk';
        tabKK.className = "flex-1 py-3 px-4 rounded-xl text-sm font-bold transition-all bg-white shadow-sm text-[#0071E3]";
        tabSubKK.className = "flex-1 py-3 px-4 rounded-xl text-sm font-bold transition-all text-gray-400";
        renderForm();
    });

    tabSubKK.addEventListener('click', () => {
        state.formMode = 'subkk';
        tabSubKK.className = "flex-1 py-3 px-4 rounded-xl text-sm font-bold transition-all bg-white shadow-sm text-[#0071E3]";
        tabKK.className = "flex-1 py-3 px-4 rounded-xl text-sm font-bold transition-all text-gray-400";
        renderForm();
    });

    // Focus mode
    btnFocusMode.addEventListener('click', () => {
        state.isExpanded = !state.isExpanded;
        if (state.isExpanded) {
            sidebar.classList.add('hidden');
            mainPanel.classList.remove('lg:w-7/12');
            mainPanel.classList.add('w-full');
            txtFocusMode.innerText = "Tampilkan Semua Panel";
        } else {
            sidebar.classList.remove('hidden');
            mainPanel.classList.remove('w-full');
            mainPanel.classList.add('lg:w-7/12');
            txtFocusMode.innerText = "Mode Fokus Daftar";
        }
        renderRegistry();
    });

    // Initial render
    renderForm();
    renderRegistry();

</script>