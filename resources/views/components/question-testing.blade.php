@props(['page', 'config' => null, 'route' => null, 'fitur_code' => null, 'fitur_name' => null])

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
        const FORM_URL =
            "https://docs.google.com/forms/d/e/1FAIpQLSdXboM1efTFXwkP4gNHj-NKfKpR3LHLp-hbpKkjmVoicIHvbg/formResponse";
        const FORM_USER = "{{ $route }}";
        const FIELD_DATA = "entry.1222575501";
        const FIELD_FITUR_CODE = "entry.241518130";
        const FIELD_DEVICE_INFO = "entry.1081555875";

        const RAW_CONFIG = @json($config);
        const PAGE_NAME = "{{ $fitur_name }}";
        const FITUR_CODE = "{{ $fitur_code ?? '-' }}";
        const USER_NAME = "{{ auth()->check() ? auth()->user()->name : 'Pengguna' }}";

        const RAW_FITUR_NAME = "{!! html_entity_decode($fitur_name ?? '-') !!}";
        const DISPLAY_PAGE = RAW_FITUR_NAME
            .toLowerCase()
            .replace(/\b\w/g, l => l.toUpperCase());

        function generateHTML(questions) {
            if (!questions)
                return '<div class="p-2 text-center text-xs text-gray-400">Formulir evaluasi belum tersedia.</div>';

            let htmlStr = '<div class="text-left font-sans px-1 uat-scroll">';

            htmlStr += `
                <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 mb-6 flex items-start gap-3">
                    <div class="bg-blue-500 rounded-full p-1 text-white flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <p class="text-[12px] text-blue-800 leading-relaxed">
                        <strong>Halo!</strong> Mohon bantu evaluasi fitur <strong>${DISPLAY_PAGE}</strong>.
                    </p>
                </div>`;

            htmlStr += '<div class="space-y-6">';
            htmlStr += questions.map(q => {
                if (q.type === 'scale') {
                    const minLabel = q.labels?.[0] || 'Sangat Kurang';
                    const maxLabel = q.labels?.[1] || 'Sangat Baik';

                    return `
                        <div class="bg-white rounded-xl p-4 border border-gray-100 shadow-sm">
                            <div class="flex justify-between items-center mb-1">
                                <label class="font-semibold text-gray-800 text-sm">${q.label}</label>
                                <span id="${q.key}_val" class="text-xs font-bold text-blue-600 bg-blue-50 px-3 py-0.5 rounded-full border border-blue-100">4</span>
                            </div>
                            
                            <div class="mt-4 mb-2">
                                <input type="range" min="1" max="7" value="4" step="1" id="${q.key}" 
                                    class="apple-slider w-full" 
                                    oninput="window.handleSliderChange('${q.key}', this.value)">
                                <div class="flex justify-between mt-1">
                                    <span class="text-[10px] text-gray-400">${minLabel}</span>
                                    <span class="text-[10px] text-gray-400">${maxLabel}</span>
                                </div>
                            </div>
                            
                            <div id="${q.key}_extra" class="hidden mt-4 pt-4 border-t border-dashed">
                                <textarea id="${q.key}_reason" 
                                    class="w-full p-3 border rounded-xl text-xs"
                                    placeholder="Apa yang perlu diperbaiki?" rows="2"></textarea>
                            </div>
                        </div>`;
                }

                return `
                    <div>
                        <label class="block font-semibold text-gray-800 text-sm mb-1">${q.label}</label>
                        <textarea id="${q.key}" 
                            class="w-full p-3 border rounded-xl text-sm"
                            placeholder="Masukan Anda..." rows="2"></textarea>
                    </div>`;
            }).join('');

            htmlStr += '</div></div>';
            return htmlStr;
        }

        async function openUAT() {
            const questions = Array.isArray(RAW_CONFIG) ? RAW_CONFIG : RAW_CONFIG?.[PAGE_NAME];
            if (!questions) return;

            const startTime = performance.now();
            const isMobile = window.innerWidth < 480;

            const {
                value: res,
                isConfirmed
            } = await Swal.fire({
                title: `<div class="apple-header">PENILAIAN FITUR<br><span class="text-blue-600">${DISPLAY_PAGE}</span></div>`,
                html: generateHTML(questions),
                width: isMobile ? '100%' : '95%',
                confirmButtonText: 'Kirim',
                confirmButtonColor: '#007AFF',
                customClass: {
                    popup: 'apple-popup',
                    confirmButton: 'apple-button-v2'
                },
                preConfirm: () => {
                    let data = {};
                    let valid = true;

                    questions.forEach(q => {
                        const val = document.getElementById(q.key)?.value.trim() || "";
                        if (q.type !== 'scale' && val === "") valid = false;

                        data[q.key] = val;

                        if (q.type === 'scale') {
                            data[`${q.key}_alasan`] = document.getElementById(
                                `${q.key}_reason`)?.value.trim() || "";
                        }
                    });

                    if (!valid) return Swal.showValidationMessage('Isi masukan utama dulu ya');
                    return data;
                }
            });

            if (isConfirmed) {
                Swal.fire({
                    title: 'Mengirim...',
                    didOpen: () => Swal.showLoading()
                });

                const duration = ((performance.now() - startTime) / 1000).toFixed(1);
                const device = navigator.userAgent;

                const meta = `user:${USER_NAME}|pg:${DISPLAY_PAGE}|dur:${duration}s`;
                const answers = Object.entries(res).map(([k, v]) => `${k}:${v}`).join("|");

                const body = new FormData();
                body.append(FIELD_DATA, `${meta}|${answers}`);
                body.append(FIELD_FITUR_CODE, FITUR_CODE);
                body.append(FIELD_DEVICE_INFO, device);




                try {
                    await fetch(FORM_URL, {
                        method: "POST",
                        mode: "no-cors",
                        body
                    });
                    
                    const token = document.querySelector('meta[name="csrf-token"]').content;

                    await fetch(FORM_USER, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": token
                        }
                    });

                    Swal.fire({
                        icon: 'success',
                        title: 'Terima kasih!',
                        timer: 1500,
                        showConfirmButton: false
                    });
                } catch {
                    Swal.fire('Error', 'Gagal kirim', 'error');
                }
            }
        }

        setTimeout(openUAT, 800);
    })();
</script>

<style>
    /* POPUP */
    .apple-popup {
        border-radius: 20px !important;
        padding: 16px !important;
        width: 100% !important;
        max-width: 500px;
    }

    /* HEADER */
    .apple-header {
        font-weight: 800;
        font-size: clamp(14px, 2vw, 16px);
    }

    /* BUTTON */
    .apple-button-v2 {
        width: 100% !important;
        border-radius: 14px !important;
        padding: 12px !important;
        font-size: clamp(14px, 2vw, 16px);
    }

    /* SCROLL */
    .uat-scroll {
        max-height: 60vh;
        overflow-y: auto;
    }

    /* SLIDER */
    .apple-slider {
        height: 6px;
        background: #e5e5e7;
        border-radius: 10px;
    }

    /* MOBILE */
    @media (max-width: 480px) {
        .apple-popup {
            padding: 12px !important;
            border-radius: 16px !important;
        }
    }

    /* TABLET */
    @media (min-width: 481px) and (max-width: 768px) {
        .apple-popup {
            max-width: 420px;
        }
    }

    /* LAPTOP */
    @media (min-width: 769px) and (max-width: 1200px) {
        .apple-popup {
            max-width: 460px;
        }
    }

    /* LARGE SCREEN */
    @media (min-width: 1201px) {
        .apple-popup {
            max-width: 520px;
        }
    }
</style>
