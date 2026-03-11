@extends('layouts.base-1')

@section('sidebar-menu')
    <style>
        .loading-dots::after {
            content: '';
            animation: dots 1.5s steps(4, end) infinite;
        }

        @keyframes dots {

            0%,
            20% {
                content: '';
            }

            40% {
                content: '.';
            }

            60% {
                content: '..';
            }

            80%,
            100% {
                content: '...';
            }
        }
    </style>
    @include('kelola_data.sidebar')
    @include('kelola_data.pegawai.js.alert-success-from-controller')
    <script>
        function Pop_message(title = null, message = null, is_load = false, type = 'save') {
            if (is_load) {

                // Swal.fire({
                //     title: title == null ? 'Loading...' : title,
                //     text: message != null ? message : 'Sedang memproses data',
                //     allowOutsideClick: false,
                //     allowEscapeKey: false,
                //     showConfirmButton: false,
                //     showCancelButton: false,
                //     didOpen: () => {
                //         Swal.showLoading()
                //     }
                // });
                Swal.fire({
                    title: title == null ? 'Memproses...' : title,
                    html: 'Mohon tunggu '+message+'<span class="loading-dots"></span>',
                    allowOutsideClick: false,
                    showConfirmButton: false
                });
            } else {
                Swal.fire({
                    icon: type == 'save' ? 'success' : 'warning',
                    title: title,
                    html: message,
                    confirmButtonText: 'OK'
                });
            }

        }
    </script>
@endsection
