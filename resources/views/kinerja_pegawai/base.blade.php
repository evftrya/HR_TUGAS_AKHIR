@extends('layouts.base-1')

@section('sidebar-menu')
    @include('kinerja_pegawai.sidebar')
@endsection

@push('script-add')
    @stack('script-under-base')
@endpush
