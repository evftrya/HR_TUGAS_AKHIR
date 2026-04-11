<div class="w-full min-h-screen p-6 bg-[#FFFFFF] font-sans antialiased text-[#1D1D1F]" x-data="{
    showSectionA: true,
    showSectionB: true,
    isExpanded: false,
    formMode: 'kk',
    activeFakultas: ['f1', 'f2'],
    activeKK: [],
    searchQuery: '',

    database: [{
            id: 'f1',
            name: 'Informatika (FIF)',
            code: 'FIF',
            kks: [{
                    id: 'kk1',
                    name: 'Intelligent Systems',
                    code: 'KK-IS',
                    desc: 'Berfokus pada pengembangan algoritma cerdas, pemrosesan bahasa alami, dan sistem otonom untuk masa depan digital yang lebih intuitif.',
                    subs: [
                        { id: 's1', name: 'Machine Learning', code: 'SKK-ML', desc: 'Sistem yang belajar dari pola data tanpa instruksi eksplisit.' },
                        { id: 's2', name: 'Computer Vision', code: 'SKK-CV', desc: 'Menganalisis objek visual dari gambar dan video secara real-time.' },
                        { id: 's3', name: 'Natural Language Processing', code: 'SKK-NLP', desc: 'Teknologi pemrosesan bahasa untuk chatbot dan asisten virtual.' }
                    ]
                },
                {
                    id: 'kk2',
                    name: 'Cyber Security',
                    code: 'KK-CS',
                    desc: 'Perlindungan menyeluruh terhadap integritas jaringan dan data dari ancaman eksternal yang terus berkembang.',
                    subs: [
                        { id: 's4', name: 'Network Security', code: 'SKK-NS', desc: 'Keamanan perimeter jaringan dan kontrol akses.' },
                        { id: 's5', name: 'Cryptography', code: 'SKK-CRY', desc: 'Matematika tingkat lanjut untuk enkripsi data sensitif.' },
                        { id: 's6', name: 'Digital Forensics', code: 'SKK-DF', desc: 'Pelacakan jejak digital untuk keperluan investigasi keamanan.' }
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
                    { id: 's8', name: 'Logistics Systems', code: 'SKK-LOG', desc: 'Optimalisasi rute distribusi untuk efisiensi biaya.' },
                    { id: 's9', name: 'Warehouse Management', code: 'SKK-WM', desc: 'Sistem pergudangan modern berbasis Internet of Things.' }
                ]
            }]
        }
    ],

    // Logika Filter (Read Only)
    get filteredData() {
        if (!this.searchQuery.trim()) return this.database;
        const q = this.searchQuery.toLowerCase();

        return this.database.map(fak => {
            const fakMatch = fak.name.toLowerCase().includes(q) || fak.code.toLowerCase().includes(q);
            const matchedKKs = fak.kks.filter(kk => {
                const kkMatch = kk.name.toLowerCase().includes(q) || kk.code.toLowerCase().includes(q) || kk.desc.toLowerCase().includes(q);
                const subMatch = kk.subs.some(sub => sub.name.toLowerCase().includes(q) || sub.code.toLowerCase().includes(q) || sub.desc.toLowerCase().includes(q));
                return kkMatch || subMatch;
            });
            return { ...fak, kks: matchedKKs, isFakMatch: fakMatch };
        }).filter(fak => fak.isFakMatch || fak.kks.length > 0);
    },

    // Watcher untuk Search: Otomatis buka accordion saat mengetik
    init() {
        this.$watch('searchQuery', (value) => {
            if (!value.trim()) return;
            const q = value.toLowerCase();
            this.database.forEach(fak => {
                const fakMatch = fak.name.toLowerCase().includes(q) || fak.code.toLowerCase().includes(q);
                let hasMatchedKK = false;

                fak.kks.forEach(kk => {
                    const kkMatch = kk.name.toLowerCase().includes(q) || kk.code.toLowerCase().includes(q) || kk.desc.toLowerCase().includes(q);
                    const subMatch = kk.subs.some(sub => sub.name.toLowerCase().includes(q) || sub.code.toLowerCase().includes(q) || sub.desc.toLowerCase().includes(q));

                    if (kkMatch || subMatch) {
                        if (!this.activeKK.includes(kk.id)) this.activeKK.push(kk.id);
                        hasMatchedKK = true;
                    }
                });

                if (fakMatch || hasMatchedKK) {
                    if (!this.activeFakultas.includes(fak.id)) this.activeFakultas.push(fak.id);
                }
            });
        });
    }
}">

    <div class="max-w-[1400px] mx-auto transition-all duration-700">

        <header
            class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6 border-b border-gray-100 pb-8">
            <div>
                <h1 class="text-4xl font-bold tracking-tight text-black">Registry Keahlian</h1>
                <p class="text-gray-400 mt-2 text-lg">Kelola struktur kompetensi fakultas dan spesialisasi.</p>
            </div>
            <button @click="isExpanded = !isExpanded"
                class="hidden lg:flex items-center gap-3 px-8 py-3 bg-black text-white rounded-full text-sm font-bold hover:bg-gray-800 transition-all shadow-lg active:scale-95">
                <span x-text="isExpanded ? 'Tampilkan Semua Panel' : 'Mode Fokus Daftar'"></span>
            </button>
        </header>

        <div class="flex flex-col lg:flex-row gap-12">

            <aside class="w-full lg:w-5/12 space-y-6" x-show="!isExpanded" x-transition:enter="duration-500 ease-out"
                x-transition:enter-start="opacity-0 -translate-x-10">
                <nav class="flex p-1.5 bg-gray-100 rounded-2xl w-full">
                    <button @click="formMode = 'kk'"
                        :class="formMode === 'kk' ? 'bg-white shadow-sm text-[#0071E3]' : 'text-gray-400'"
                        class="flex-1 py-3 px-4 rounded-xl text-sm font-bold transition-all">KK</button>
                    <button @click="formMode = 'subkk'"
                        :class="formMode === 'subkk' ? 'bg-white shadow-sm text-[#0071E3]' : 'text-gray-400'"
                        class="flex-1 py-3 px-4 rounded-xl text-sm font-bold transition-all">Sub-KK</button>
                </nav>

                <div class="bg-white rounded-[2.5rem] border border-gray-200 shadow-sm overflow-hidden transition-all">
                    <div class="p-8 border-b border-gray-50 flex justify-between items-center bg-gray-50/30">
                        <h2 class="text-2xl font-bold text-black"
                            x-text="formMode === 'kk' ? 'Input Kelompok Keahlian' : 'Input Sub-Kelompok'"></h2>
                        <div class="w-2.5 h-2.5 rounded-full bg-[#0071E3]"></div>
                    </div>

                    <div class="p-8 space-y-6">
                        <template x-if="formMode === 'kk'">
                            <div class="space-y-5">
                                <x-itxt lbl="Nama KK" plc="Masukkan nama lengkap KK..." nm="nama_kk"></x-itxt>
                                <x-itxt lbl="Kode KK" plc="KK-01" nm="kode_kk"></x-itxt>
                                <x-itxt type="textarea" lbl="Deskripsi Visi" plc="Jelaskan fokus keahlian..."
                                    nm="desc_kk"></x-itxt>
                                <x-islc lbl="Fakultas" nm="fak_kk">
                                    <option value="" disabled selected>Pilih Fakultas</option>
                                    <template x-for="f in database" :key="f.id">
                                        <option :value="f.id" x-text="f.name"></option>
                                    </template>
                                </x-islc>
                                <button
                                    class="w-full bg-[#0071E3] hover:bg-blue-700 text-white py-4.5 rounded-2xl font-bold shadow-xl shadow-blue-100 transition-all active:scale-95">Simpan
                                    KK</button>
                            </div>
                        </template>
                        <template x-if="formMode === 'subkk'">
                            <div class="space-y-5">
                                <x-itxt lbl="Nama Spesialisasi" plc="Masukkan nama sub-kk..." nm="nama_sub"></x-itxt>
                                <x-itxt lbl="Kode Sub-KK" plc="SKK-01" nm="kode_sub"></x-itxt>
                                <x-itxt type="textarea" lbl="Deskripsi Teknis" plc="Detail keahlian..."
                                    nm="desc_sub"></x-itxt>
                                <x-islc lbl="Kelompok Keahlian" nm="parent_kk">
                                    <option value="" disabled selected>Pilih KK Induk</option>
                                    <template x-for="f in database" :key="f.id">
                                        <optgroup :label="f.name">
                                            <template x-for="kk in f.kks" :key="kk.id">
                                                <option :value="kk.id" x-text="kk.name"></option>
                                            </template>
                                        </optgroup>
                                    </template>
                                </x-islc>
                                <button
                                    class="w-full bg-black hover:bg-gray-800 text-white py-4.5 rounded-2xl font-bold shadow-xl transition-all active:scale-95">Daftarkan
                                    Sub-KK</button>
                            </div>
                        </template>
                    </div>
                </div>
            </aside>

            <main class="transition-all duration-700" :class="isExpanded ? 'w-full' : 'w-full lg:w-7/12'">
                <div class="relative mb-8 group">
                    <input type="text" x-model="searchQuery" placeholder="Cari nama, kode, atau deskripsi..."
                        class="w-full pl-16 pr-8 py-5.5 bg-gray-50 border border-gray-100 rounded-[2rem] outline-none focus:bg-white focus:ring-4 focus:ring-blue-50 focus:border-[#0071E3] transition-all text-lg shadow-inner">
                    {{-- <div
                        class="absolute inset-y-0 left-12 flex items-center text-gray-400 group-focus-within:text-[#0071E3]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div> --}}
                </div>

                <div class="space-y-8">
                    <template x-for="fak in filteredData" :key="fak.id">
                        <section class="bg-white rounded-[2.5rem] border border-gray-100 shadow-sm overflow-hidden">
                            <div @click="activeFakultas.includes(fak.id) ? activeFakultas = activeFakultas.filter(id => id !== fak.id) : activeFakultas.push(fak.id)"
                                class="p-8 flex items-center justify-between cursor-pointer hover:bg-gray-50 transition-colors">
                                <div class="flex items-center gap-6">
                                    <div class="w-2 h-12 bg-black rounded-full"
                                        :class="activeFakultas.includes(fak.id) ? 'bg-[#0071E3]' : ''"></div>
                                    <div>
                                        <h3 class="text-2xl font-black text-black" x-text="fak.name"></h3>
                                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest"
                                            x-text="'KODE: ' + fak.code"></span>
                                    </div>
                                </div>
                                <div class="p-2.5 rounded-full bg-gray-100 text-gray-400">
                                    <svg class="w-5 h-5 transition-transform duration-500"
                                        :class="activeFakultas.includes(fak.id) ? 'rotate-180' : ''" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>

                            <div x-show="activeFakultas.includes(fak.id)" x-collapse>
                                <div class="p-8 pt-0 grid gap-6"
                                    :class="isExpanded ? 'lg:grid-cols-2' : 'grid-cols-1'">
                                    <template x-for="kk in fak.kks" :key="kk.id">
                                        <div class="bg-gray-50 rounded-[2rem] p-6 border border-transparent hover:border-blue-100 hover:bg-white transition-all duration-300"
                                            x-data="{ showFull: false }">

                                            <div class="flex justify-between items-start mb-4"
                                                @click="activeKK.includes(kk.id) ? activeKK = activeKK.filter(id => id !== kk.id) : activeKK.push(kk.id)">
                                                <div class="flex-1 cursor-pointer">
                                                    <h4 class="text-lg font-bold text-black"
                                                        :class="activeKK.includes(kk.id) ? 'text-[#0071E3]' : ''"
                                                        x-text="kk.name"></h4>
                                                    <span
                                                        class="text-[9px] font-black text-gray-400 uppercase tracking-widest"
                                                        x-text="kk.code"></span>
                                                </div>
                                                <div class="p-2.5 rounded-2xl transition-all shadow-sm"
                                                    :class="activeKK.includes(kk.id) ? 'bg-[#0071E3] text-white' :
                                                        'bg-white text-gray-300'">
                                                    <svg class="w-4 h-4 transition-transform duration-300"
                                                        :class="activeKK.includes(kk.id) ? 'rotate-180' : ''"
                                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="3" d="M19 9l-7 7-7-7"></path>
                                                    </svg>
                                                </div>
                                            </div>

                                            <p class="text-[13px] text-gray-500 leading-relaxed cursor-pointer"
                                                @click="showFull = !showFull" :class="showFull ? '' : 'line-clamp-2'"
                                                x-text="kk.desc"></p>

                                            <div x-show="activeKK.includes(kk.id)" x-collapse
                                                class="mt-6 space-y-3 pt-6 border-t border-gray-200/60">
                                                <template x-for="sub in kk.subs" :key="sub.id">
                                                    <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:border-blue-200 transition-all cursor-default"
                                                        x-data="{ subFull: false }">
                                                        <div class="flex justify-between items-center mb-2">
                                                            <span class="font-bold text-black text-[13px]"
                                                                x-text="sub.name"></span>
                                                            <span
                                                                class="text-[9px] font-black text-[#0071E3] bg-blue-50 px-2 py-0.5 rounded-lg"
                                                                x-text="sub.code"></span>
                                                        </div>
                                                        <p class="text-[11px] text-gray-400 leading-snug cursor-pointer"
                                                            @click="subFull = !subFull"
                                                            :class="subFull ? '' : 'line-clamp-1'" x-text="sub.desc">
                                                        </p>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </section>
                    </template>
                </div>
            </main>
        </div>
    </div>
</div>
