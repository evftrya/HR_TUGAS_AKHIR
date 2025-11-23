@php
    $active_sidebar = 'Target Kinerja';
@endphp

@extends('kelola_data.base')

@section('page-name')
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-medium">Pengaturan Kinerja</h2>
            <p class="text-sm text-gray-600">Konfigurasi sistem target kinerja</p>
        </div>
    </div>
@endsection

@section('content-base')
    <div class="max-w-4xl">
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
        @endif

        <form action="{{ route('manage.target-kinerja.update-settings') }}" method="POST">
            @csrf

            <!-- Periode Kinerja -->
            <div class="bg-white p-6 rounded-lg shadow mb-6">
                <h3 class="text-lg font-semibold mb-4 border-b pb-2">Periode Kinerja</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Tahun Periode Aktif</label>
                        <input type="number" name="periode_tahun"
                            value="{{ $settings['periode_tahun']->value ?? date('Y') }}"
                            class="w-full border rounded px-3 py-2">
                        <input type="hidden" name="periode_tahun_type" value="number">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Semester</label>
                        <select name="periode_semester" class="w-full border rounded px-3 py-2">
                            <option value="1" {{ ($settings['periode_semester']->value ?? '1') == '1' ? 'selected' : '' }}>Semester 1 (Januari - Juni)</option>
                            <option value="2" {{ ($settings['periode_semester']->value ?? '1') == '2' ? 'selected' : '' }}>Semester 2 (Juli - Desember)</option>
                        </select>
                        <input type="hidden" name="periode_semester_type" value="string">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Tanggal Mulai Periode</label>
                        <input type="date" name="periode_tanggal_mulai"
                            value="{{ $settings['periode_tanggal_mulai']->value ?? '' }}"
                            class="w-full border rounded px-3 py-2">
                        <input type="hidden" name="periode_tanggal_mulai_type" value="string">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Tanggal Akhir Periode</label>
                        <input type="date" name="periode_tanggal_akhir"
                            value="{{ $settings['periode_tanggal_akhir']->value ?? '' }}"
                            class="w-full border rounded px-3 py-2">
                        <input type="hidden" name="periode_tanggal_akhir_type" value="string">
                    </div>
                </div>
            </div>

            <!-- Bobot Penilaian -->
            <div class="bg-white p-6 rounded-lg shadow mb-6">
                <h3 class="text-lg font-semibold mb-4 border-b pb-2">Bobot Penilaian</h3>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Bobot Target Tercapai (%)</label>
                        <input type="number" name="bobot_target_tercapai"
                            value="{{ $settings['bobot_target_tercapai']->value ?? 40 }}"
                            min="0" max="100" class="w-full border rounded px-3 py-2">
                        <input type="hidden" name="bobot_target_tercapai_type" value="number">
                        <p class="text-xs text-gray-500 mt-1">Bobot penilaian untuk pencapaian target kinerja</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Bobot Kualitas Kerja (%)</label>
                        <input type="number" name="bobot_kualitas_kerja"
                            value="{{ $settings['bobot_kualitas_kerja']->value ?? 30 }}"
                            min="0" max="100" class="w-full border rounded px-3 py-2">
                        <input type="hidden" name="bobot_kualitas_kerja_type" value="number">
                        <p class="text-xs text-gray-500 mt-1">Bobot penilaian untuk kualitas pekerjaan</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Bobot Disiplin (%)</label>
                        <input type="number" name="bobot_disiplin"
                            value="{{ $settings['bobot_disiplin']->value ?? 20 }}"
                            min="0" max="100" class="w-full border rounded px-3 py-2">
                        <input type="hidden" name="bobot_disiplin_type" value="number">
                        <p class="text-xs text-gray-500 mt-1">Bobot penilaian untuk kedisiplinan</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Bobot Inisiatif (%)</label>
                        <input type="number" name="bobot_inisiatif"
                            value="{{ $settings['bobot_inisiatif']->value ?? 10 }}"
                            min="0" max="100" class="w-full border rounded px-3 py-2">
                        <input type="hidden" name="bobot_inisiatif_type" value="number">
                        <p class="text-xs text-gray-500 mt-1">Bobot penilaian untuk inisiatif pegawai</p>
                    </div>

                    <div class="bg-blue-50 p-3 rounded">
                        <p class="text-sm font-medium">Total Bobot: <span id="total-bobot" class="text-blue-600">100</span>%</p>
                        <p class="text-xs text-gray-600 mt-1">Pastikan total bobot = 100%</p>
                    </div>
                </div>
            </div>

            <!-- Pengaturan Umum -->
            <div class="bg-white p-6 rounded-lg shadow mb-6">
                <h3 class="text-lg font-semibold mb-4 border-b pb-2">Pengaturan Umum</h3>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Minimal Nilai Tercapai</label>
                        <input type="number" name="minimal_nilai_tercapai"
                            value="{{ $settings['minimal_nilai_tercapai']->value ?? 75 }}"
                            min="0" max="100" class="w-full border rounded px-3 py-2">
                        <input type="hidden" name="minimal_nilai_tercapai_type" value="number">
                        <p class="text-xs text-gray-500 mt-1">Nilai minimal untuk dianggap tercapai (0-100)</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Batas Waktu Pengisian (hari sebelum deadline)</label>
                        <input type="number" name="batas_waktu_pengisian"
                            value="{{ $settings['batas_waktu_pengisian']->value ?? 7 }}"
                            min="0" class="w-full border rounded px-3 py-2">
                        <input type="hidden" name="batas_waktu_pengisian_type" value="number">
                        <p class="text-xs text-gray-500 mt-1">Berapa hari sebelum deadline untuk reminder</p>
                    </div>

                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" name="auto_reminder" value="1"
                                {{ ($settings['auto_reminder']->value ?? '0') == '1' ? 'checked' : '' }}
                                class="form-checkbox mr-2">
                            <span class="text-sm font-medium">Aktifkan Reminder Otomatis</span>
                        </label>
                        <input type="hidden" name="auto_reminder_type" value="boolean">
                        <p class="text-xs text-gray-500 mt-1 ml-6">Kirim reminder otomatis ke pegawai</p>
                    </div>

                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" name="require_approval" value="1"
                                {{ ($settings['require_approval']->value ?? '1') == '1' ? 'checked' : '' }}
                                class="form-checkbox mr-2">
                            <span class="text-sm font-medium">Wajib Approval Atasan</span>
                        </label>
                        <input type="hidden" name="require_approval_type" value="boolean">
                        <p class="text-xs text-gray-500 mt-1 ml-6">Target kinerja harus disetujui atasan</p>
                    </div>
                </div>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan Pengaturan</button>
                <a href="{{ route('manage.target-kinerja.list') }}" class="px-6 py-2 bg-gray-300 rounded text-gray-700 hover:bg-gray-400">Kembali</a>
            </div>
        </form>
    </div>
@endsection

@section('script-base')
<script>
    // Calculate total bobot
    function calculateTotalBobot() {
        const bobotTarget = parseFloat(document.querySelector('[name="bobot_target_tercapai"]').value) || 0;
        const bobotKualitas = parseFloat(document.querySelector('[name="bobot_kualitas_kerja"]').value) || 0;
        const bobotDisiplin = parseFloat(document.querySelector('[name="bobot_disiplin"]').value) || 0;
        const bobotInisiatif = parseFloat(document.querySelector('[name="bobot_inisiatif"]').value) || 0;

        const total = bobotTarget + bobotKualitas + bobotDisiplin + bobotInisiatif;
        document.getElementById('total-bobot').textContent = total;

        // Change color if not 100
        const totalElement = document.getElementById('total-bobot');
        if (total === 100) {
            totalElement.classList.remove('text-red-600');
            totalElement.classList.add('text-green-600');
        } else {
            totalElement.classList.remove('text-green-600');
            totalElement.classList.add('text-red-600');
        }
    }

    // Add event listeners to bobot inputs
    document.querySelectorAll('[name^="bobot_"]').forEach(input => {
        input.addEventListener('input', calculateTotalBobot);
    });

    // Calculate on page load
    calculateTotalBobot();
</script>
@endsection
