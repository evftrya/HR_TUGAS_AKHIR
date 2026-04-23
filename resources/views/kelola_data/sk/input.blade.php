@php
    $active_sidebar = 'Tambah SK';
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
    <div
        class="flex flex-col md:flex-row items-center gap-[11.749480247497559px] self-stretch px-1 pt-[14.686850547790527px] pb-[13.952507972717285px]">
        <div class="flex w-full flex-col gap-[2.9373700618743896px] grow">
            <div class="flex items-center gap-[5.874740123748779px] self-stretch">
                <span class="font-medium text-2xl leading-[20.56159019470215px] text-[#101828]">
                    Tambah Surat Keputusan (SK) Baru
                </span>
            </div>
        </div>
    </div>
@endsection

@section('content-base')
    <x-form route="{{ route('manage.sk.store') }}" id="sk-input" enctype="multipart/form-data">
        <div class="grid gap-6">
            <div class="flex flex-col gap-4">

                {{-- Tipe Dokumen --}}
                <x-islc lbl="Tipe Dokumen" nm="tipe_dokumen" id="tipe_dokumen">
                    <option value="" disabled selected>-- Pilih Tipe Dokumen --</option>
                    <option value="SK" @selected(old('tipe_dokumen') == 'SK')>SK</option>
                    <option value="AMANDEMEN" @selected(old('tipe_dokumen') == 'AMANDEMEN')>AMANDEMEN</option>
                </x-islc>

                {{-- Nomor SK --}}
                <x-itxt lbl="Nomor SK" nm="no_sk" plc="Masukkan Nomor SK" max="100"
                    value="{{ old('no_sk') }}"></x-itxt>

                {{-- Tipe SK (Conditional) --}}
                <div id="container-tipe-sk">
                    <x-islc lbl="Tipe SK" nm="tipe_sk">
                        <option value="" disabled selected>-- Pilih Tipe SK --</option>
                        <option value="Pengakuan YPT" @selected(old('tipe_sk') == 'Pengakuan YPT')>Pengakuan YPT</option>
                        <option value="LLDIKTI" @selected(old('tipe_sk') == 'LLDIKTI')>LLDIKTI</option>
                    </x-islc>
                </div>

                {{-- Keterangan Singkat --}}
                <x-itxt lbl="Keterangan" nm="keterangan" plc="Keterangan singkat mengenai SK" max="200"
                    value="{{ old('keterangan') }}"></x-itxt>

                {{-- TMT --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-itxt lbl="TMT Mulai" type="date" nm="tmt_mulai" value="{{ old('tmt_mulai') }}"></x-itxt>
                    <x-itxt lbl="TMT Selesai (Opsional)" type="date" nm="tmt_selesai" :req="false"
                        value="{{ old('tmt_selesai') }}"></x-itxt>
                </div>

                {{-- File SK --}}
                <x-itxt lbl="File SK (PDF)" type="file" nm="file_sk" plc="Pilih Dokumen SK"></x-itxt>

            </div>
        </div>
    </x-form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tipeDokumenSelect = document.getElementById('tipe_dokumen');
            const containerTipeSk = document.getElementById('container-tipe-sk');
            const tipeSkSelect = containerTipeSk.querySelector('select');

            function toggleTipeSk() {
                if (tipeDokumenSelect.value === 'SK') {
                    containerTipeSk.classList.remove('hidden');
                } else {
                    containerTipeSk.classList.add('hidden');
                    tipeSkSelect.value = ''; // Reset value if hidden
                }
            }

            tipeDokumenSelect.addEventListener('change', toggleTipeSk);

            // Run on initial load to handle old() values
            toggleTipeSk();
        });
    </script>
@endsection
