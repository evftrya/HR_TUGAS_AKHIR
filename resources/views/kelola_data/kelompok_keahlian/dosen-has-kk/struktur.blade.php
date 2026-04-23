@extends('kelola_data.base')
@php
    $active_sidebar = 'Daftar Pemetaan';
@endphp

@section('header-base')
    <style>
        /* Container Wrapper untuk mencegah overflow merusak template */
        .tree-scroll-container {
            width: 100%;
            overflow-x: auto;
            overflow-y: hidden;
            padding: 20px;
            background: #f8fafc;
            border-radius: 0.75rem;
            min-height: 400px;
        }

        /* Tree Layout Core */
        .tree {
            display: inline-block;
            min-width: 100%;
            text-align: center;
        }

        .tree ul {
            padding-top: 20px;
            position: relative;
            display: flex;
            justify-content: center;
            transition: all 0.3s;
            padding-left: 0;
            margin-bottom: 0;
        }

        .tree li {
            text-align: center;
            list-style-type: none;
            position: relative;
            padding: 20px 10px 0 10px;
            transition: all 0.3s;
        }

        /* Garis Horizontal */
        .tree li::before,
        .tree li::after {
            content: '';
            position: absolute;
            top: 0;
            right: 50%;
            border-top: 2px solid #cbd5e1;
            width: 50%;
            height: 20px;
        }

        .tree li::after {
            right: auto;
            left: 50%;
            border-left: 2px solid #cbd5e1;
        }

        .tree li:only-child::after,
        .tree li:only-child::before {
            display: none;
        }

        .tree li:only-child {
            padding-top: 0;
        }

        .tree li:first-child::before,
        .tree li:last-child::after {
            border: 0 none;
        }

        .tree li:last-child::before {
            border-right: 2px solid #cbd5e1;
            border-radius: 0 5px 0 0;
        }

        .tree li:first-child::after {
            border-radius: 5px 0 0 0;
        }

        /* Garis Vertikal ke Bawah - Hanya muncul jika ada UL di dalamnya */
        .tree li > div + ul::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            border-left: 2px solid #cbd5e1;
            width: 0;
            height: 20px;
        }

        /* Node Design */
        .node-container {
            width: 280px;
            display: inline-block;
            position: relative;
            z-index: 10;
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 1rem;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
        }

        .btn-circle-add {
            width: 26px;
            height: 26px;
            background: #10b981;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            border: none;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn-circle-add:hover {
            transform: scale(1.1);
            background: #059669;
        }

        .btn-toggle-view {
            transition: all 0.2s ease-in-out;
            border: 1px solid #cbd5e1;
            background: white;
            color: #64748b;
        }

        .is-collapsed {
            background: #2563eb !important;
            color: white !important;
            border-color: #1d4ed8 !important;
        }

        .btn-detach {
            background-color: #fee2e2;
            color: #ef4444;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 10px;
            border: 1px solid #fecaca;
            font-weight: 800;
            transition: 0.2s;
        }

        .btn-detach:hover {
            background-color: #ef4444;
            color: white;
        }

        .tree-scroll-container::-webkit-scrollbar {
            height: 8px;
        }

        .tree-scroll-container::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        .tree-scroll-container::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
    </style>
@endsection

@section('content-base')
    <div class="card shadow-sm border-0 rounded-xl mb-4 ">
        <div class="card-body py-4 px-6">
            <div class="col g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label text-[10px] font-bold text-slate-500 uppercase tracking-wider">Filter Tanggal</label>
                    <form action="{{ url()->current() }}" method="GET" class="flex items-center gap-2">
                        <input type="date" name="filter_date" value="{{ $filter_date }}"
                            class="form-control form-control-sm rounded-lg shadow-none border-slate-300">
                        <button type="submit" class="btn btn-primary btn-sm px-4 font-bold uppercase">Filter</button>
                    </form>
                </div>
                <div class="col-md-9 mt-4">
                    <div class="flex justify-between items-end">
                        <label class="form-label text-[10px] font-bold text-slate-500 uppercase tracking-wider">Pencarian Unit / Dosen</label>
                        <span id="search-status" class="text-[9px] text-blue-500 font-bold hidden mb-1 animate-pulse italic">Sedang mencari...</span>
                    </div>
                    <input type="text" id="input-search" placeholder="Cari nama fakultas, KK, atau dosen..."
                        class="form-control form-control-sm rounded-lg border-slate-300 focus:ring-blue-500 shadow-none">
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-xl overflow-hidden">
        <div class="tree-scroll-container">
            <div id="org-chart" class="tree">
                {{-- Data dirender via JS --}}
            </div>
        </div>
    </div>

    {{-- Template Node --}}
    <template id="node-template">
        <li class="node-li">
            <div class="node-wrapper flex flex-col items-center">
                <div class="node-container p-4">
                    <div class="flex justify-between items-center mb-3">
                        <span class="level-badge text-[8px] px-2 py-0.5 rounded-full font-bold uppercase text-white"></span>
                        <button class="btn-circle-add btn-add-action" title="Tambah">+</button>
                    </div>
                    <h6 class="node-title text-[11px] font-black text-slate-800 uppercase leading-tight mb-3 text-left border-l-4 border-slate-300 pl-2"></h6>

                    <div class="inner-toggle-container d-none mb-2">
                        <button class="btn-toggle-inner w-full border border-slate-200 rounded-lg py-1.5 text-[9px] font-bold flex items-center justify-center gap-2">
                            <span class="inner-toggle-icon">▶</span>
                            <span class="inner-toggle-text">LIHAT ANGGOTA</span>
                        </button>
                    </div>

                    <div class="dosen-wrapper d-none pt-3 border-t border-dashed border-slate-200">
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-3 text-left">Anggota Sub-KK</p>
                        <div class="dosen-list space-y-2"></div>
                    </div>

                    <div class="empty-state-container d-none pt-2 border-t border-slate-100 text-center">
                        <p class="text-[10px] font-bold italic text-red-500 uppercase">Belum ada dosen</p>
                    </div>
                </div>

                <div class="outer-collapse-trigger d-none mt-3">
                    <button class="btn-toggle-outer rounded-full px-4 py-1.5 text-[10px] font-bold shadow-sm flex items-center gap-2 btn-toggle-view">
                        <span class="outer-toggle-icon">▼</span>
                        <span class="outer-toggle-text">TUTUP</span>
                    </button>
                </div>
            </div>
            {{-- child-ul akan ditambahkan secara dinamis jika level < 3 --}}
        </li>
    </template>

    {{-- Template Dosen --}}
    <template id="dosen-template">
        <div class="flex items-center justify-between gap-3 bg-slate-50 p-2 rounded-xl border border-slate-100">
            <div class="flex items-center gap-2 overflow-hidden">
                <div class="avatar flex-shrink-0 w-7 h-7 rounded-full bg-indigo-600 text-[9px] text-white flex items-center justify-center font-bold"></div>
                <span class="dosen-name text-[9px] font-bold text-slate-700 uppercase text-left leading-tight truncate"></span>
            </div>
            <form action="" method="POST" class="m-0 flex-shrink-0">
                @csrf
                <input type="hidden" name="dosen_id" class="input-dosen-id">
                <input type="hidden" name="sub_kk_id" class="input-sub-id">
                <button type="submit" class="btn-detach" onclick="return confirm('Lepas dosen ini?')">Lepas</button>
            </form>
        </div>
    </template>
@endsection

@push('script-under-base')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dataRaw = @json($database);
            const targetChart = document.getElementById('org-chart');
            const inputSearch = document.getElementById('input-search');
            const searchStatus = document.getElementById('search-status');
            const addSubKK = "{{ route('manage.kelompok-keahlian.list') }}#tabSubKK"

            let debounceTimer;

            const config = {
                1: { label: 'Fakultas', color: 'border-t-red-500', badge: 'bg-red-500' },
                2: { label: 'Kelompok Keahlian', color: 'border-t-orange-500', badge: 'bg-orange-500' },
                3: { label: 'Sub-KK', color: 'border-t-blue-500', badge: 'bg-blue-500' }
            };

            function ensureArray(data) {
                if (!data) return [];
                if (Array.isArray(data)) return data;
                try { return JSON.parse(data) || []; } catch (e) { return []; }
            }

            function buildNode(title, level, params = {}, forceOpen = false) {
                const temp = document.getElementById('node-template').content.cloneNode(true);
                const li = temp.querySelector('.node-li');
                const container = temp.querySelector('.node-container');
                const badge = temp.querySelector('.level-badge');
                const outerTrigger = temp.querySelector('.outer-collapse-trigger');
                const btnOuter = temp.querySelector('.btn-toggle-outer');
                const innerContainer = temp.querySelector('.inner-toggle-container');
                const btnInner = temp.querySelector('.btn-toggle-inner');
                const dosenWrapper = temp.querySelector('.dosen-wrapper');
                const emptyContainer = temp.querySelector('.empty-state-container');

                container.classList.add('border-t-4', config[level].color);
                badge.textContent = config[level].label;
                badge.classList.add(config[level].badge);
                temp.querySelector('.node-title').textContent = title || '-';

                temp.querySelector('.btn-add-action').onclick = () => {
                    let baseUrl = level === 1 ? '/tambah-kk/' : (level === 2 ? '/tambah-sub-kk/' : '/tambah-dosen/');
                    window.location.href = baseUrl + params.id;
                };

                // Level 3 Logic (Sub-KK)
                if (level === 3) {
                    const dosens = ensureArray(params.dosens);
                    if (dosens.length > 0) {
                        innerContainer.classList.remove('d-none');
                        const list = temp.querySelector('.dosen-list');
                        dosens.forEach(d => {
                            const dTemp = document.getElementById('dosen-template').content.cloneNode(true);
                            dTemp.querySelector('.dosen-name').textContent = d.dosen_name;
                            dTemp.querySelector('.avatar').textContent = d.dosen_name.substring(0, 2).toUpperCase();
                            dTemp.querySelector('.input-dosen-id').value = d.id;
                            dTemp.querySelector('.input-sub-id').value = params.id;
                            list.appendChild(dTemp);
                        });

                        const toggleDosen = (collapse) => {
                            if(collapse) dosenWrapper.classList.add('d-none'); else dosenWrapper.classList.remove('d-none');
                            btnInner.querySelector('.inner-toggle-text').textContent = collapse ? 'LIHAT ANGGOTA' : 'TUTUP ANGGOTA';
                            btnInner.querySelector('.inner-toggle-icon').textContent = collapse ? '▶' : '▼';
                            btnInner.classList.toggle('is-collapsed', !collapse);
                        };

                        toggleDosen(!forceOpen);
                        btnInner.onclick = () => toggleDosen(!dosenWrapper.classList.contains('d-none'));
                    } else {
                        emptyContainer.classList.remove('d-none');
                    }
                }

                // Level 1 & 2 Logic (Fakultas & KK)
                let childUl = null;
                if (level < 3) {
                    childUl = document.createElement('ul');
                    if (!forceOpen) childUl.classList.add('d-none');
                    li.appendChild(childUl);

                    const toggleOuter = (collapse) => {
                        if(collapse) childUl.classList.add('d-none'); else childUl.classList.remove('d-none');
                        btnOuter.querySelector('.outer-toggle-text').textContent = collapse ? 'PERBESAR' : 'TUTUP';
                        btnOuter.querySelector('.outer-toggle-icon').textContent = collapse ? '▶' : '▼';
                        btnOuter.classList.toggle('is-collapsed', collapse);
                    };

                    toggleOuter(!forceOpen);
                    btnOuter.onclick = () => toggleOuter(!childUl.classList.contains('d-none'));
                }

                return { li, ul: childUl, trigger: outerTrigger };
            }

            function render(keyword = "") {
                targetChart.innerHTML = "";
                const term = keyword.toLowerCase().trim();
                const rootUl = document.createElement('ul');

                dataRaw.forEach(fak => {
                    const isFakMatch = fak.fakultas_name.toLowerCase().includes(term);
                    const kks = ensureArray(fak.result);

                    let filteredKks = kks.filter(kk => {
                        const isKkMatch = kk.kk_nama.toLowerCase().includes(term);
                        const subs = ensureArray(kk.sub);
                        const hasSubOrDosenMatch = subs.some(s => {
                            const isSubMatch = s.nama_sub.toLowerCase().includes(term);
                            const dosens = ensureArray(s.dosens);
                            return isSubMatch || dosens.some(d => d.dosen_name.toLowerCase().includes(term));
                        });
                        return term === "" || isFakMatch || isKkMatch || hasSubOrDosenMatch;
                    });

                    if (term !== "" && !isFakMatch && filteredKks.length === 0) return;

                    const fakNode = buildNode(fak.fakultas_name, 1, { id: fak.fakultas_id }, term !== "");
                    if (filteredKks.length > 0) {
                        fakNode.trigger.classList.remove('d-none');
                        filteredKks.forEach(kk => {
                            const isKkMatch = kk.kk_nama.toLowerCase().includes(term);
                            const subs = ensureArray(kk.sub);
                            let filteredSubs = subs.filter(s => {
                                const isSubMatch = s.nama_sub.toLowerCase().includes(term);
                                const dosens = ensureArray(s.dosens);
                                return term === "" || isFakMatch || isKkMatch || isSubMatch || dosens.some(d => d.dosen_name.toLowerCase().includes(term));
                            });

                            const kkNode = buildNode(kk.kk_nama, 2, { id: kk.kk_id }, term !== "");
                            if (filteredSubs.length > 0) {
                                kkNode.trigger.classList.remove('d-none');
                                filteredSubs.forEach(sub => {
                                    const dosens = ensureArray(sub.dosens);
                                    const hasDosenMatch = dosens.some(d => d.dosen_name.toLowerCase().includes(term));
                                    const forceOpenSub = term !== "" && (sub.nama_sub.toLowerCase().includes(term) || hasDosenMatch);
                                    const subNode = buildNode(sub.nama_sub, 3, { id: sub.sub_id, dosens: sub.dosens }, forceOpenSub);
                                    kkNode.ul.appendChild(subNode.li);
                                });
                            }
                            fakNode.ul.appendChild(kkNode.li);
                        });
                    }
                    rootUl.appendChild(fakNode.li);
                });
                targetChart.appendChild(rootUl);
                searchStatus.classList.add('hidden');
            }

            inputSearch.addEventListener('input', (e) => {
                clearTimeout(debounceTimer);
                searchStatus.classList.remove('hidden');
                debounceTimer = setTimeout(() => render(e.target.value), 500);
            });

            render();
        });
    </script>
@endpush
