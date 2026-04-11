@php
    $active_sidebar = 'Kelompok Keahlian';
@endphp

@extends('kelola_data.base')

@section('header-base')
    <style>
        .max-w-100 {
            max-width: 100% !important;
        }
    </style>
@endsection

@section('page-name')
@endsection

@section('content-base')
    @include('kelola_data.kelompok_keahlian.component.manage-dosen')
@endsection


