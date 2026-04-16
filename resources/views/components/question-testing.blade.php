@props(['page', 'config' => null, 'route' => null, 'fitur_code' => null])

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    window.handleSliderChange = function(key, val) {
        const valDisplay = document.getElementById(`${key}_val`);
        if (valDisplay) valDisplay.innerText = val;

        const extra = document.getElementById(`${key}_extra`);
        if (extra) {
            // Memunculkan area penjelasan jika nilai di bawah 4 (netral ke bawah)
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
        const FIELD_FITUR_CODE = "entry.241518130"; 
        const FIELD_DEVICE_INFO = "entry.1081555875"; 

        const RAW_CONFIG = @json($config);
        const PAGE_NAME = "{{ $page }}";
        const FITUR_CODE = "{{ $fitur_code ?? '-' }}";
        const USER_NAME = "{{ auth()->check() ? auth()->user()->name : 'Pengguna' }}";
        const DISPLAY_PAGE = PAGE_NAME.replace(/-/g, ' ').replace(/\b\w/g, l => l.toUpperCase());

        function generateHTML(questions) {
            if (!questions) return '<div class="p-2 text-center text-xs text-gray-400">Formulir evaluasi belum tersedia.</div>';
            
            let htmlStr = '<div class="text-left font-sans px-1" style="max-height: 55vh; overflow-y: auto;">';
            
            htmlStr += `
                <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 mb-6 flex items-start gap-3">
                    <div class="bg-blue-500 rounded-full p-1 text-white flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <p class="text-[12px] text-blue-800 leading-relaxed">
                        <strong>Halo!</strong> Kami sangat menghargai bantuan Anda. Mohon luangkan waktu sejenak untuk mengevaluasi fitur <strong>${DISPLAY_PAGE}</strong> agar kami bisa melayani Anda lebih baik lagi.
                    </p>
                </div>`;

            htmlStr += '<div class="space-y-6">';
            htmlStr += questions.map(q => {
                if (q.type === 'scale') {
                    const minLabel = (q.labels && q.labels[0]) ? q.labels[0] : 'Sangat Kurang';
                    const maxLabel = (q.labels && q.labels[1]) ? q.labels[1] : 'Sangat Baik';

                    return `
                        <div class="bg-white rounded-xl p-4 border border-gray-100 shadow-sm transition-all hover:border-blue-200">
                            <div class="flex justify-between items-center mb-1">
                                <label class="font-semibold text-gray-800 text-[14px]">${q.label}</label>
                                <span id="${q.key}_val" class="text-[12px] font-bold text-blue-600 bg-blue-50 px-3 py-0.5 rounded-full border border-blue-100">4</span>
                            </div>
                            
                            <div class="mt-4 mb-2">
                                <input type="range" min="1" max="7" value="4" step="1" id="${q.key}" class="apple-slider w-full" oninput="window.handleSliderChange('${q.key}', this.value)">
                                <div class="flex justify-between mt-1">
                                    <span class="text-[10px] font-medium text-gray-400 uppercase tracking-tighter">${minLabel}</span>
                                    <span class="text-[10px] font-medium text-gray-400 uppercase tracking-tighter text-right">${maxLabel}</span>
                                </div>
                            </div>
                            
                            <div id="${q.key}_extra" class="hidden mt-4 pt-4 border-t border-dashed border-gray-200">
                                <label class="block text-[11px] font-bold text-amber-600 uppercase tracking-wider mb-2 italic">
                                    Apa yang menurut Anda perlu kami perbaiki? (Opsional)
                                </label>
                                <textarea id="${q.key}_reason" class="w-full p-3 bg-amber-50/30 border border-amber-100 rounded-xl text-[12px] focus:ring-1 focus:ring-amber-200 focus:outline-none" 
                                    placeholder="Masukan Anda sangat berharga bagi kami..." rows="2"></textarea>
                            </div>
                        </div>`;
                }
                return `
                    <div class="space-y-2 px-1">
                        <label class="block font-semibold text-gray-800 text-[14px]">${q.label}</label>
                        <textarea id="${q.key}" class="w-full p-4 border border-gray-200 bg-gray-50 rounded-2xl focus:ring-2 focus:ring-blue-100 focus:bg-white transition-all focus:outline-none text-[13px]" 
                            placeholder="Tuliskan masukan atau saran Anda di sini..." rows="2"></textarea>
                    </div>`;
            }).join('');

            htmlStr += '</div></div>';
            return htmlStr;
        }

        async function openUAT() {
            const questions = Array.isArray(RAW_CONFIG) ? RAW_CONFIG : (RAW_CONFIG ? RAW_CONFIG[PAGE_NAME] : null);
            if (!questions) return;
            
            const startTime = performance.now();

            const { value: res, isConfirmed } = await Swal.fire({
                title: `<div class="apple-header text-left">PENILAIAN FITUR | <span class="text-blue-600">${DISPLAY_PAGE}</span></div>`,
                html: generateHTML(questions),
                width: '480px',
                confirmButtonText: 'Kirim Masukan',
                confirmButtonColor: '#007AFF',
                footer: '<p class="text-[10px] text-gray-400 italic">Terima kasih atas bantuan Anda!</p>',
                customClass: { popup: 'apple-popup', confirmButton: 'apple-button-v2' },
                preConfirm: () => {
                    let data = {};
                    let valid = true;
                    questions.forEach(q => {
                        const val = document.getElementById(q.key)?.value.trim() || "";
                        
                        // Validasi hanya untuk field non-scale (textarea utama)
                        if (q.type !== 'scale' && val === "") valid = false;
                        
                        data[q.key] = val;
                        
                        // Ambil nilai alasan jika ada, tapi tidak wajib (valid tetap true)
                        if (q.type === 'scale') {
                            const rVal = document.getElementById(`${q.key}_reason`)?.value.trim() || "";
                            data[`${q.key}_alasan`] = rVal; 
                        }
                    });
                    
                    if (!valid) return Swal.showValidationMessage('Mohon isi masukan utama Anda.');
                    return data;
                }
            });

            if (isConfirmed) {
                Swal.fire({ 
                    title: 'Sedang Mengirim...', 
                    html: 'Terima kasih, masukan Anda sedang kami proses.',
                    didOpen: () => Swal.showLoading(), 
                    allowOutsideClick: false 
                });

                const duration = ((performance.now() - startTime) / 1000).toFixed(1);
                const deviceSpecs = navigator.userAgent;
                const screenRes = `${window.screen.width}x${window.screen.height}`;
                
                const meta = `user:${USER_NAME}|pg:${DISPLAY_PAGE}|dur:${duration}s|spec:${deviceSpecs}|res:${screenRes}`;
                const answers = Object.entries(res).map(([k, v]) => `${k}:${v}`).join("|");

                const bodyData = new FormData();
                bodyData.append(FIELD_DATA, `${meta}|${answers}`);
                bodyData.append(FIELD_FITUR_CODE, FITUR_CODE);
                bodyData.append(FIELD_DEVICE_INFO, `Browser/OS: ${deviceSpecs}`);

                try {
                    await fetch(FORM_URL, { method: "POST", mode: "no-cors", body: bodyData });

                    const csrf = document.querySelector('meta[name="csrf-token"]')?.content;
                    if ('{{ $route }}' && '{{ $route }}' !== '') {
                        await fetch('{{ $route }}', {
                            method: "POST",
                            headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json', 'Content-Type': 'application/json' },
                            body: JSON.stringify({ page: PAGE_NAME, code: FITUR_CODE, status: 'success' })
                        });
                    }

                    Swal.fire({ 
                        icon: 'success', 
                        title: 'Terima Kasih!', 
                        text: 'Masukan Anda telah kami terima.',
                        timer: 2000, 
                        showConfirmButton: false 
                    });
                } catch (err) {
                    console.error("Kesalahan Pengiriman:", err);
                    Swal.fire('Mohon Maaf', 'Terjadi kendala saat mengirim. Coba lagi nanti.', 'error');
                }
            }
        }
        
        setTimeout(openUAT, 1000);
    })();
</script>

<style>
    .apple-header { font-size: 16px; font-weight: 800; color: #1c1c1e; border-bottom: 1px solid #f2f2f7; padding-bottom: 12px; margin-bottom: 10px; }
    .apple-popup { border-radius: 24px !important; padding: 20px !important; }
    .apple-button-v2 { background: #007AFF !important; width: 100% !important; border-radius: 16px !important; font-weight: 700; padding: 14px 0 !important; transition: all 0.2s ease; }
    .apple-button-v2:hover { background: #0063CC !important; transform: scale(1.01); }
    .apple-slider { -webkit-appearance: none; height: 6px; background: #e5e5e7; border-radius: 10px; outline: none; }
    .apple-slider::-webkit-slider-thumb { -webkit-appearance: none; width: 24px; height: 24px; background: #fff; border: 0.5px solid #d1d1d6; border-radius: 50%; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.12); cursor: pointer; transition: transform 0.1s ease; }
    .apple-slider::-webkit-slider-thumb:active { transform: scale(1.2); }
</style>