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




    <div class="flex flex-center">
        @2026 - Tim Penelitian SDM Telkom University Surabaya
    </div>
@endsection

@push('script-add')
    @stack('script-under-base')
@endpush
