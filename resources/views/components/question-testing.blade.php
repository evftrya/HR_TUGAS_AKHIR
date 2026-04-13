@props(['page', 'config' => null])

<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    window.handleSliderChange = function(key, val) {
        const valDisplay = document.getElementById(`${key}_val`);
        if (valDisplay) valDisplay.innerText = val;
        
        const extra = document.getElementById(`${key}_extra`);
        if (extra) {
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
        // Mengambil identitas user dari Laravel Auth
        const USER_NAME = "{{ auth()->check() ? auth()->user()->name : 'Guest' }}";
        const DISPLAY_PAGE = PAGE_NAME.replace(/-/g, ' ').replace(/\b\w/g, l => l.toUpperCase());

        async function captureArea() {
            try {
                const element = document.getElementById('uat-target-area') || document.body;
                const canvas = await html2canvas(element, {
                    scale: 0.5, 
                    useCORS: true,
                    backgroundColor: "#ffffff",
                    logging: false
                });
                return canvas.toDataURL("image/jpeg", 0.1);
            } catch (e) { return "failed_to_capture"; }
        }

        function generateHTML(questions) {
            if (!questions) return `<div class="p-2 text-center text-xs text-gray-400">No config.</div>`;
            return `
            <div class="text-left font-sans px-1" style="max-height: 55vh; overflow-y: auto;">
                <div class="bg-blue-50 border border-blue-100 rounded-lg p-3 mb-5 flex items-start gap-2.5">
                    <svg class="w-4 h-4 text-blue-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"></path>
                    </svg>
                    <span class="text-[11px] font-semibold text-blue-700 leading-normal">Halo <b>${USER_NAME}</b>, mohon isi evaluasi ini untuk pengujian portability sistem.</span>
                </div>
                <div class="space-y-6">
                    ${questions.map(q => {
                        if (q.type === 'scale') {
                            return `
                            <div class="bg-gray-50 rounded-xl p-4 border border-gray-100 shadow-sm">
                                <div class="flex justify-between items-center mb-1">
                                    <label class="font-bold text-gray-700 text-[14px] tracking-tight">${q.label}</label>
                                    <span id="${q.key}_val" class="text-[12px] font-extrabold text-blue-600 bg-white border border-blue-100 px-2 py-0.5 rounded-md">4</span>
                                </div>
                                <input type="range" min="1" max="7" value="4" step="1" id="${q.key}" class="apple-slider w-full" oninput="window.handleSliderChange('${q.key}', this.value)">
                                <div id="${q.key}_extra" class="hidden mt-4 pt-4 border-t border-red-100">
                                    <label class="block text-[10px] font-black text-red-500 uppercase tracking-wide mb-2 italic">Kendala Portabilitas?</label>
                                    <textarea id="${q.key}_reason" class="w-full p-3 bg-red-50/30 border border-red-100 rounded-xl text-[12px] focus:outline-none" placeholder="Contoh: Layout berantakan di layar ini..." rows="2"></textarea>
                                </div>
                            </div>`;
                        }
                        return `
                        <div class="space-y-2 px-1">
                            <label class="block font-bold text-gray-700 text-[14px]">${q.label}</label>
                            <textarea id="${q.key}" class="w-full p-4 border border-gray-200 bg-gray-50 rounded-2xl focus:outline-none text-[13px]" rows="2"></textarea>
                        </div>`;
                    }).join('')}
                </div>
            </div>`;
        }

        async function openUAT() {
            const questions = Array.isArray(RAW_CONFIG) ? RAW_CONFIG : (RAW_CONFIG ? RAW_CONFIG[PAGE_NAME] : null);
            if (!questions) return;
            const startTime = performance.now();

            const { value: res, isConfirmed } = await Swal.fire({
                title: `<div class="apple-header flex items-center gap-2"><span>UAT Portability</span><span class="text-gray-300 font-light">|</span><span class="text-blue-600 truncate">${DISPLAY_PAGE}</span></div>`,
                html: generateHTML(questions),
                width: '460px',
                confirmButtonText: 'Kirim Masukan',
                confirmButtonColor: '#007AFF',
                customClass: { popup: 'apple-popup', confirmButton: 'apple-button-v2', title: 'apple-title-reset' },
                preConfirm: () => {
                    let data = {};
                    let valid = true;
                    questions.forEach(q => {
                        const el = document.getElementById(q.key);
                        const val = el ? el.value.trim() : "";
                        if (q.type !== 'scale' && val === "") valid = false;
                        data[q.key] = val;
                        if (q.type === 'scale' && parseInt(val) < 4) {
                            const rEl = document.getElementById(`${q.key}_reason`);
                            const rVal = rEl ? rEl.value.trim() : "";
                            if (rVal === "") valid = false;
                            data[`${q.key}_alasan`] = rVal;
                        }
                    });
                    if (!valid) { Swal.showValidationMessage('Mohon lengkapi jawaban Anda.'); return false; }
                    return data;
                }
            });

            if (isConfirmed) {
                Swal.fire({ title: 'Finalizing...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
                
                const screenshotData = await captureArea();
                const endTime = new Date();
                const duration = ((performance.now() - startTime) / 1000).toFixed(1);
                
                // DATA LOG UNTUK PORTABILITY TEST
                const meta = [
                    `user:${USER_NAME}`,
                    `pg:${DISPLAY_PAGE}`,
                    `dur:${duration}s`,
                    `dev:${navigator.userAgent}`,
                    `res:${window.screen.width}x${window.screen.height}`,
                    `submit_at:${endTime.toLocaleString('id-ID')}`
                ].join('|');

                const answers = Object.entries(res).map(([k, v]) => `${k}:${v}`).join("|");
                const fullLog = `${meta}|${answers}`;

                const formData = new URLSearchParams();
                formData.append(FIELD_DATA, fullLog);
                formData.append(FIELD_SS, screenshotData);

                try {
                    await fetch(FORM_URL, { method: "POST", mode: "no-cors", body: formData });
                    Swal.fire({ icon: 'success', title: 'Data Berhasil Dicatat', showConfirmButton: false, timer: 1500 });
                } catch (err) { Swal.fire('Error', 'Gagal kirim data.', 'error'); }
            }
        }
        setTimeout(openUAT, 1000);
    })();
</script>

<style>
    .apple-title-reset { padding: 0 !important; margin: 0 0 12px 0 !important; line-height: 1 !important; display: block !important; }
    .apple-header { font-size: 16px; font-weight: 800; color: #1c1c1e; border-bottom: 1px solid #f2f2f7; padding-bottom: 10px; width: 100%; text-align: left; }
    .apple-popup { border-radius: 20px !important; padding: 20px !important; }
    .apple-button-v2 { background: #007AFF !important; width: 100% !important; border-radius: 14px !important; font-weight: 700; padding: 14px 0 !important; }
    .apple-slider { -webkit-appearance: none; height: 6px; background: #e5e5e7; border-radius: 10px; outline: none; margin: 15px 0; }
    .apple-slider::-webkit-slider-thumb { -webkit-appearance: none; width: 22px; height: 22px; background: #fff; border: 0.5px solid #d1d1d6; border-radius: 50%; box-shadow: 0 3px 8px rgba(0,0,0,0.15); cursor: pointer; }
</style>