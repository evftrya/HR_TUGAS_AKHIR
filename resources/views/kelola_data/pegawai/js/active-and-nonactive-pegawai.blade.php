{{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
<script>
    function konfirmasiNonaktif(element) {
        Swal.fire({
            title: 'Yakin ingin menonaktifkan user ini?',
            text: "Tindakan ini tidak dapat dibatalkan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#2563eb',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Nonaktifkan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                let form = element.closest('form');
                form.submit();
                // document.getElementById('form-nonaktif-' + id).submit();
            }
        });
    }

    function konfirmasiAktif(element) {
        Swal.fire({
            title: 'Yakin ingin mengaktifkan user ini?',
            text: "User akan kembali bisa login dan mengakses sistem.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#10B981',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Aktifkan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                let form = element.closest('form');
                form.submit();
            }
        });
    }
</script>
