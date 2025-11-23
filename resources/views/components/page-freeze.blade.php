<style>
    body.frozen {
        pointer-events: none;
        /* Nonaktifkan semua interaksi */
        overflow: hidden;
        /* Cegah scroll */
    }

    /* Membekukan halaman */
    /* Loader (spinner) */
    .loader {
        border: 4px solid #F5F5F5;
        border-top: 4px solid transparent;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        animation: spin 1s linear infinite;
    }

    /* Animasi berputar */
    @keyframes spin {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }
</style>
<div id="pageOverlay"
    class="hidden fixed inset-0 bg-black/50 backdrop-blur-xl text-white text-lg flex items-center justify-center z-[9999]">
    <div class="text-center">
        <div class="loader mx-auto mb-4"></div>
        <p>Sedang mengarahkan ke halaman...</p>
    </div>
</div>
<script defer>
    function overlayArahkan(event) {
        event.stopImmediatePropagation()
        event.preventDefault();
        const target = event.currentTarget.getAttribute('href');

        // Aktifkan overlay
        const overlay = document.getElementById('pageOverlay');
        overlay.classList.remove('hidden');

        // Bekukan halaman (pastikan body tidak bisa discroll & klik)
        document.body.style.overflow = 'hidden';
        overlay.style.pointerEvents = 'all'; // pastikan overlay menangkap semua klik
        window.location.href = target;
    }
</script>
