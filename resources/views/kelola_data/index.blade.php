@extends('kelola_data.base')
@section('header-base')
    <style>
        .max-w-100 {
            max-width: 100% !important;
        }
    </style>
@endsection
@section('page-name', 'Dashboard Kelola Data')
{{-- @endsection --}}
@section('content-base')
@include('components.test-drive-recent')
@endsection
