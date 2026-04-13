@props(['page', 'config' => null])

<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    window.handleSliderChange = function(key, val) {
        const valDisplay = document.getElementById(`${key}_val`);
        if (valDisplay) valDisplay.innerText = val;
        
        const extra = document.getElementById(`${key}_extra`);
        if (extra) {
            // Munculkan input alasan jika nilai <= 3 (asumsi skala 1-7)
            if (parseInt(val) < 4) {
                extra.classList.remove('hidden');
                extra.style.display = 'block'; 
            } else {
                extra.classList.add('hidden');
                extra.style.display = 'none';
            }
        }
    };

    (function() {
        const FORM_URL = "https://docs.google.com/forms/d/e/1FAIpQLSdXboM1efTFXwkP4gNHj-NKfKpR3LHLp-hbpKkjmVoicIHvbg/formResponse";
        const FIELD_DATA = "entry.1222575501";
        const FIELD_SS   = "entry.1081555875";
        
        const RAW_CONFIG = @json($config);
        const PAGE_NAME = "{{ $page }}";
        const DISPLAY_PAGE = PAGE_NAME.replace(/-/g, ' ').replace(/\b\w/g, l => l.toUpperCase());

        async function captureArea() {
            try {
                const element = document.getElementById('uat-target-area') || document.body;
                const canvas = await html2canvas(element, {
                    scale: 1,
                    useCORS: true,
                    backgroundColor: "#f5f5f7",
                    logging: false
                });
                return canvas.toDataURL("image/jpeg", 0.3);
            } catch (e) {
                return "failed_to_capture";
            }
        }

        function generateHTML(questions) {
            if (!questions) return `<div class="p-4 text-center text-red-500 font-bold">Konfigurasi tidak ditemukan.</div>`;

            return `
            <div class="text-left py-2 space-y-6 overflow-x-hidden" style="max-height: 70vh; overflow-y: auto;">
                
                <div class="flex items-center gap-2 mb-2">
                    <span class="text-[10px] uppercase tracking-wider font-bold text-gray-400">Evaluasi Fitur:</span>
                    <span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-xs font-bold ring-1 ring-indigo-200">
                        ${DISPLAY_PAGE}
                    </span>
                </div>

                ${questions.map(q => {
                    if (q.type === 'scale') {
                        // Ambil label kustom dari config, atau gunakan default jika tidak ada
                        const leftLabel = (q.labels && q.labels[0]) ? q.labels[0] : "Rendah";
                        const rightLabel = (q.labels && q.labels[1]) ? q.labels[1] : "Tinggi";

                        return `
                        <div class="bg-white border border-gray-200 p-5 rounded-3xl shadow-sm mb-4">
                            <div class="flex justify-between items-start mb-1">
                                <label class="font-bold text-gray-800 text-base leading-tight pr-4">${q.label}</label>
                                <span id="${q.key}_val" class="text-xl font-black text-blue-600 bg-blue-50 px-3 py-1 rounded-xl border border-blue-100 shadow-inner">4</span>
                            </div>
                            
                            <input type="range" min="1" max="7" value="4" step="1" id="${q.key}" 
                                class="w-full h-3 bg-gray-200 rounded-lg appearance-none cursor-pointer mt-6 mb-2 relative z-10" 
                                style="accent-color: #0071e3; -webkit-appearance: none;"
                                oninput="window.handleSliderChange('${q.key}', this.value)">
                            
                            <div class="flex justify-between px-1 text-[10px] font-black text-gray-500 uppercase tracking-tighter">
                                <span class="w-1/3 text-left">${leftLabel}</span>
                                <span class="w-1/3 text-center text-gray-300">Netral</span>
                                <span class="w-1/3 text-right">${rightLabel}</span>
                            </div>

                            <div id="${q.key}_extra" class="hidden mt-4 pt-4 border-t border-dashed border-gray-200 transition-all">
                                <label class="block text-xs font-bold text-red-500 mb-2 uppercase italic">Apa kendalanya?</label>
                                <textarea id="${q.key}_reason" class="w-full p-3 bg-red-50 border border-red-100 rounded-2xl text-sm focus:outline-none" placeholder="Ceritakan sedikit kendala Anda..."></textarea>
                            </div>
                        </div>`;
                    }
                    
                    return `
                    <div class="px-2 mb-4">
                        <label class="block font-bold text-gray-800 mb-2">${q.label}</label>
                        <textarea id="${q.key}" class="w-full p-4 border-2 border-gray-100 rounded-2xl focus:border-blue-500 focus:outline-none text-sm" rows="3" placeholder="Tuliskan masukan Anda..."></textarea>
                    </div>`;
                }).join('')}
            </div>`;
        }

        async function openUAT() {
            const questions = Array.isArray(RAW_CONFIG) ? RAW_CONFIG : (RAW_CONFIG ? RAW_CONFIG[PAGE_NAME] : null);
            if (!questions) return;

            const startTime = performance.now();

            const { value: res, isConfirmed } = await Swal.fire({
                title: `<span class="text-xl font-bold text-gray-800 text-center block w-full">Feedback System</span>`,
                html: generateHTML(questions),
                width: 580,
                confirmButtonText: 'Kirim Masukan',
                confirmButtonColor: '#0071e3',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                allowOutsideClick: false,
                didOpen: () => {
                    questions.forEach(q => {
                        if (q.type === 'scale') {
                            const el = document.getElementById(q.key);
                            if (el) window.handleSliderChange(q.key, el.value);
                        }
                    });
                },
                preConfirm: () => {
                    let data = {};
                    questions.forEach(q => {
                        const el = document.getElementById(q.key);
                        const val = el ? el.value : "";
                        data[q.key] = val;
                        if (q.type === 'scale' && parseInt(val) < 4) {
                            const reasonEl = document.getElementById(`${q.key}_reason`);
                            data[`${q.key}_alasan`] = reasonEl ? reasonEl.value : "n/a";
                        }
                    });
                    return data;
                }
            });

            if (isConfirmed) {
                Swal.fire({
                    title: 'Sedang Mengirim...',
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });

                const screenshotData = await captureArea();
                const duration = ((performance.now() - startTime) / 1000).toFixed(1);

                const meta = `pg:${PAGE_NAME}|dur:${duration}s|ts:${new Date().toISOString()}`;
                const answers = Object.entries(res).map(([k, v]) => `${k}:${v}`).join("|");
                const dataPayload = `${meta}|${answers}`;

                const formData = new URLSearchParams();
                formData.append(FIELD_DATA, dataPayload);
                formData.append(FIELD_SS, screenshotData);

                try {
                    await fetch(FORM_URL, { method: "POST", mode: "no-cors", body: formData });
                    Swal.fire({
                        icon: 'success',
                        title: 'Terkirim!',
                        text: 'Terima kasih atas bantuan Anda meningkatkan sistem ini.',
                        confirmButtonColor: '#0071e3'
                    });
                } catch (err) {
                    Swal.fire('Error', 'Gagal mengirim data.', 'error');
                }
            }
        }

        if (document.readyState === 'complete') {
            setTimeout(openUAT, 1000);
        } else {
            window.addEventListener('load', () => setTimeout(openUAT, 1000));
        }
    })();
</script>