@php
    $active_sidebar = 'none';
@endphp
@extends('kelola_data.base')
@section('header-base')
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}

    <!-- OrgChart.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://balkan.app/js/OrgChart.js" defer></script>
    <style>
        .max-w-100 {
            max-width: 100% !important;
        }



        .nav-active {
            background-color: #0070ff;

            span {
                color: white;
            }
        }
    </style>
@endsection
@section('page-name')
@endsection
@section('content-base')
    @include('kelola_data.sk.component.body-view')
@endsection
