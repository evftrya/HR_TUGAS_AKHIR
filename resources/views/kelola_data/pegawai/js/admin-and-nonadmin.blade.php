{{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
<script>
    function konfirmasiCopotAdmin(elemen) {
        Swal.fire({
            title: 'Yakin ingin melepas hak akses admin pegawai ini?',
            text: "Tindakan ini tidak dapat dibatalkan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#2563eb',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Nonaktifkan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                elemen.closest('form').submit();
            }
        });
    }

    function konfirmasiAdmin(elemen) {
        Swal.fire({
            title: 'Yakin ingin memberikan hak akses admin pada pegawai ini?',
            text: "User akan kembali bisa login dan mengakses sistem.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#10B981',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Aktifkan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                elemen.closest('form').submit();
            }
        });
    }
</script>
