@php
    $active_sidebar = 'Daftar Pemetaan';
    $filter_date = request('filter_date', date('Y-m-d'));
@endphp

@extends('kelola_data.base')

@section('header-base')
    <style>
        /* Struktur Dasar Tree */
        .tree ul {
            padding-top: 20px;
            position: relative;
            display: flex;
            justify-content: center;
            width: fit-content;
            margin: 0 auto;
        }

        .tree li {
            text-align: center;
            list-style-type: none;
            position: relative;
            padding: 20px 5px 0 5px;
        }

        /* Garis horizontal */
        .tree li::before, .tree li::after {
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

        .tree li:only-child::after, .tree li:only-child::before { display: none; }
        .tree li:only-child { padding-top: 0; }
        .tree li:first-child::before, .tree li:last-child::after { border: 0 none; }
        .tree li:last-child::before { border-right: 2px solid #cbd5e1; border-radius: 0 5px 0 0; }
        .tree li:first-child::after { border-radius: 5px 0 0 0; }

        /* Garis vertikal */
        .tree ul ul::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            border-left: 2px solid #cbd5e1;
            width: 0;
            height: 20px;
        }

        .tree li > ul.hidden::before { display: none !important; }

        /* MODIFIKASI LAYAR PENUH */
        #capture-wrapper:fullscreen {
            background-color: #f1f5f9;
            padding: 40px;
            display: flex;
            align-items: flex-start;
            justify-content: flex-start;
            overflow: auto;
            width: 100vw;
            height: 100vh;
        }

        #capture-wrapper:fullscreen #capture-area {
            margin: auto;
            padding: 20px;
        }

        /* Perbaikan untuk Nama Panjang (Auto Enter) */
        .user-name-wrapper {
            white-space: normal !important; /* Biarkan teks membungkus/enter */
            word-wrap: break-word;
            overflow-wrap: break-word;
            max-width: 160px; /* Batasi lebar teks agar tidak melebar ke samping */
        }
    </style>
@endsection

@section('content-base')
    <div class="card shadow-sm border-0 rounded-xl mb-4">
        <div class="card-body py-3 px-6">
            <form id="filter-form" action="{{ route('manage.pengawakan.struktur') }}" method="GET" class="flex items-center gap-4">
                <div class="flex flex-col">
                    <label for="filter_date" class="text-[10px] font-bold text-slate-500 uppercase mb-1">Struktur Per Tanggal</label>
                    <div class="flex gap-2">
                        <input type="date" name="filter_date" id="filter_date" value="{{ $filter_date }}" class="form-control form-control-sm border-slate-200 rounded-lg text-sm font-semibold text-slate-700">
                        <button type="submit" class="btn btn-primary btn-sm px-4 font-bold uppercase">
                            Tampilkan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-xl">
        <div class="card-header bg-white border-b border-slate-100 py-4 px-6 flex justify-between items-center">
            <h3 class="text-sm font-bold text-slate-800 uppercase tracking-tight">Visualisasi Struktur SIMDK</h3>
            <div class="flex gap-2">
                <button onclick="toggleFullScreen()" class="btn btn-outline-primary btn-sm font-bold">
                    <i class="fas fa-expand mr-1"></i> LAYAR PENUH
                </button>
                <button onclick="exportHandler('png')" class="btn btn-success btn-sm font-bold">
                    <i class="fas fa-image mr-1"></i> UNDUH PNG
                </button>
            </div>
        </div>

        <div class="card-body bg-slate-50 p-0 overflow-hidden">
            <div id="capture-wrapper" class="w-full overflow-auto p-8 lg:p-12">
                <div id="capture-area" class="inline-block bg-white shadow-sm rounded-lg border border-slate-100">
                    <div class="tree p-6" id="org-chart">
                        <p class="text-slate-400 text-sm italic">Membangun struktur...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <template id="node-template">
        <li class="node-li">
            <div class="node-container inline-block bg-white border border-slate-200 rounded-xl p-3.5 min-w-[220px] shadow-sm">
                <p class="formasi-name text-[10px] font-black text-slate-700 uppercase mb-2 leading-none border-b border-slate-50 pb-1.5 tracking-wider"></p>
                <div class="member-list bg-slate-50/50 rounded-lg px-2"></div>
            </div>
            <ul class="child-container hidden"></ul>
        </li>
    </template>

    <template id="member-template">
        <div class="flex items-center mt-2 bg-blue-50/50 px-2 gap-2.5 py-2 border-t border-slate-100 text-left rounded-md">
            <div class="avatar-container shrink-0"></div>
            <div class="flex-1 min-w-0">
                <div class="user-name user-name-wrapper text-[10px] text-slate-800 font-extrabold leading-tight uppercase"></div>
                <div class="flex items-center gap-1 mt-0.5">
                    <div class="status-indicator w-1.5 h-1.5 rounded-full"></div>
                    <span class="status-text text-[8px] text-slate-500 font-bold uppercase"></span>
                </div>
            </div>
        </div>
    </template>
@endsection

@push('script-under-base')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <script>
        function toggleFullScreen() {
            const elem = document.getElementById("capture-wrapper");
            if (!document.fullscreenElement) {
                elem.requestFullscreen().catch(err => {
                    Swal.fire('Error', `Gagal Layar Penuh: ${err.message}`, 'error');
                });
            } else {
                document.exitFullscreen();
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const filterForm = document.getElementById('filter-form');
            filterForm.addEventListener('submit', function() {
                Swal.fire({
                    title: 'Memproses Data',
                    html: 'Mohon tunggu, sedang memuat struktur organisasi...',
                    allowOutsideClick: false,
                    didOpen: () => { Swal.showLoading(); }
                });
            });

            const rawData = @json($rawData); // cek
            const levelColors = {
                1: 'border-t-red-700', 2: 'border-t-orange-600', 3: 'border-t-blue-600',
                4: 'border-t-cyan-600', 5: 'border-t-green-600'
            };

            function getInitialData(name) {
                const colors = ['#3b82f6', '#ef4444', '#10b981', '#f59e0b', '#6366f1'];
                return {
                    initials: name.split(' ').map(n => n[0]).join('').toUpperCase().substring(0, 2),
                    color: colors[name.length % colors.length]
                };
            }

            function createNode(nodeData) {
                const template = document.getElementById('node-template');
                const clone = template.content.cloneNode(true);
                const container = clone.querySelector('.node-container');
                const childContainer = clone.querySelector('.child-container');

                container.classList.add('border-t-[6px]', levelColors[nodeData.urut_formasi] || 'border-t-slate-400');
                clone.querySelector('.formasi-name').textContent = nodeData.formasi;

                const members = typeof nodeData.members === 'string' ? JSON.parse(nodeData.members) : nodeData.members;
                const memberList = clone.querySelector('.member-list');

                if (members && members.length > 0) {
                    members.forEach(m => {
                        const mTemplate = document.getElementById('member-template');
                        const mClone = mTemplate.content.cloneNode(true);
                        const { initials, color } = getInitialData(m.user_nama);
                        const isDosen = m.is_dosen || nodeData.urut_formasi <= 4;

                        const avatarDiv = mClone.querySelector('.avatar-container');
                        if (m.foto) {
                            avatarDiv.innerHTML = `<img src="${m.foto}" crossorigin="anonymous" class="w-7 h-7 rounded-full object-cover border border-slate-200">`;
                        } else {
                            avatarDiv.innerHTML = `<div class="w-7 h-7 rounded-full flex items-center justify-center text-[9px] font-black text-white" style="background-color: ${color}">${initials}</div>`;
                        }

                        mClone.querySelector('.user-name').textContent = m.user_nama;
                        mClone.querySelector('.status-indicator').classList.add(isDosen ? 'bg-emerald-500' : 'bg-slate-400');
                        mClone.querySelector('.status-text').textContent = isDosen ? 'Dosen' : 'Pegawai';
                        memberList.appendChild(mClone);
                    });
                } else {
                    memberList.innerHTML = '<div class="text-[9px] text-slate-300 italic py-2 text-center font-bold uppercase tracking-tighter">Belum Diisi</div>';
                }

                if (nodeData.children && nodeData.children.length > 0) {
                    childContainer.classList.remove('hidden');
                    nodeData.children.forEach(child => childContainer.appendChild(createNode(child)));
                }

                return clone;
            }

            const treeData = (function build(data) {
                let tree = [], mapped = {};
                data.forEach(item => mapped[item.formasi] = { ...item, children: [] });
                data.forEach(item => {
                    if (item.atasan_formasi && mapped[item.atasan_formasi]) mapped[item.atasan_formasi].children.push(mapped[item.formasi]);
                    else tree.push(mapped[item.formasi]);
                });
                return tree;
            })(rawData);

            const chart = document.getElementById('org-chart');
            chart.innerHTML = '';
            const mainUl = document.createElement('ul');
            treeData.forEach(rootNode => mainUl.appendChild(createNode(rootNode)));
            chart.appendChild(mainUl);
        });

        window.exportHandler = function(type) {
            Swal.fire({
                title: 'Menyiapkan File',
                text: 'Sedang merender gambar, harap tunggu...',
                allowOutsideClick: false,
                didOpen: () => { Swal.showLoading(); }
            });

            const area = document.getElementById('capture-area');
            html2canvas(area, {
                useCORS: true,
                scale: 2,
                backgroundColor: '#ffffff',
                logging: false
            }).then(canvas => {
                if(type === 'png') {
                    const link = document.createElement('a');
                    link.download = `struktur-${new Date().getTime()}.png`;
                    link.href = canvas.toDataURL();
                    link.click();
                } else {
                    const { jsPDF } = window.jspdf;
                    const pdf = new jsPDF('l', 'mm', 'a4');
                    const imgData = canvas.toDataURL('image/jpeg', 1.0);
                    const pdfWidth = pdf.internal.pageSize.getWidth();
                    const pdfHeight = (canvas.height * pdfWidth) / canvas.width;
                    pdf.addImage(imgData, 'JPEG', 0, 0, pdfWidth, pdfHeight);
                    pdf.save('struktur-organisasi.pdf');
                }
                Swal.close();
            }).catch(err => {
                Swal.fire('Error', 'Gagal mengekspor gambar', 'error');
            });
        };
    </script>
@endpush
