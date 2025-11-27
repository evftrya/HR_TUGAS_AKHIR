@extends('layouts.base-1')

@section('sidebar-menu')
    @include('kelola_data.sidebar')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @include('kelola_data.pegawai.js.alert-success-from-controller')
@endsection