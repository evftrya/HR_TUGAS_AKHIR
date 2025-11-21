<?php

namespace App\Http\Controllers\Dupak;

use App\Http\Controllers\Controller;
use App\Models\Dupak\Pengajuan;
use App\Models\Dosen;
use App\Models\Dupak\RefTargetJabatanPengajuan;
use App\Models\refJabatanFungsionalAkademik;
use App\Models\riwayatJabatanFungsionalAkademik;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;

class DashboardController extends Controller
{
    protected $aturanPengajuanJFA = [
        'b467678d-8e9f-4453-bb76-f0cba91468dc' => 'Asisten Ahli',
        'f6890047-b0ea-4b45-a9f9-b0584c65bdd6' => 'Lektor',
        '21ac00aa-1f19-4347-84c1-9e70413209ab' => 'Lektor Kepala',
        'd6418a5e-b76f-4d67-9990-056e1acabe66' => 'Guru Besar (Profesor)',
    ];

    private function getDosen(User $user)
    {
        return Dosen::where('users_id', $user->id)->first();
    }

    private function getCurrentJFA(?Dosen $dosen)
    {
        return $dosen
            ? riwayatJabatanFungsionalAkademik::where('dosen_id', $dosen->id)->latest()->first()
            : null;
    }

    private function getJfaTujuan(?string $jfaId)
    {
        if (!$jfaId) return null;

        $keys = array_keys($this->aturanPengajuanJFA);
        $i = array_search($jfaId, $keys);

        return ($i !== false && isset($keys[$i + 1])) ? $keys[$i + 1] : null;
    }

    private function getTargetKum(?string $asal, ?string $tujuan, $minimal)
    {
        if (!$asal || !$tujuan) return $minimal;

        $record = RefTargetJabatanPengajuan::where('jfaAsal', $asal)
            ->where('jfaTujuan', $tujuan)
            ->first();

        return $record->kumTarget;
    }

    private function buildProgress($current, $goal)
    {
        $percent = $goal > 0 ? min(100, ($current / $goal) * 100) : 0;

        return [
            'current' => number_format($current, 2),
            'goal' => number_format($goal, 2),
            'remaining' => number_format(max(0, $goal - $current), 2),
            'percent' => $percent,
            'statusColor' => $percent >= 100 ? 'bg-green-600' : ($percent >= 60 ? 'bg-yellow-500' : 'bg-indigo-600'),
        ];
    }

    private function submissions(User $user, ?string $dosenId)
    {
        $q = Pengajuan::with(['dosen', 'dosen.pegawai'])->orderBy('id', 'desc');

        if (!$user->is_admin) {
            $q->where('idDosen', $dosenId ?? '___INVALID___');
        }

        return $q;
    }

    private function hasPendingSubmission(?string $dosenId): bool
    {
        if (!$dosenId) {
            return false;
        }

        // Tentukan status-status yang dianggap "pending" atau sedang dalam proses.
        // Anda perlu menyesuaikan array status ini dengan nilai yang ada di kolom 'status'
        // tabel 'dupak_pengajuan'. Contoh di sini: draft, submitted, dan reviewed.
        $pendingStatuses = ['draft', 'submitted', 'reviewed', 'pending'];

        return Pengajuan::where('idDosen', $dosenId)
            ->whereIn('status', $pendingStatuses)
            ->exists();
    }

    public function index()
    {
        $user = Auth::user();
        $dosen = $this->getDosen($user);

        // JFA
        $riwayat = $this->getCurrentJFA($dosen);
        $jfaAsal = $riwayat?->ref_jfa_id;

        $refJfa = $jfaAsal ? refJabatanFungsionalAkademik::find($jfaAsal) : null;

        $minimalKum = $refJfa->minimal_kum ?? 0;
        $jabatanSaatIniNama = $refJfa->nama_jabatan ?? 'Anda bukan dosen';

        // Next JFA
        $jfaTujuan = $this->getJfaTujuan($jfaAsal);
        $jfaTujuanNama = $jfaTujuan ? $this->aturanPengajuanJFA[$jfaTujuan] : 'Tidak Ada (Jabatan Tertinggi)';
        // karena sudah mendapatkan hasil id Jfa tujuan, ini bisa digunakan untuk mendapatkan skor yang dibutuhkan untuk mencari target kum yang ada di dalam database dupak.


        // Target KUM -- ini salah, mengambil angkanya itu dari dupak.ref_target_jabatan_pengajuan.minimal
        $targetKum = $this->getTargetKum($jfaAsal, $jfaTujuan, $minimalKum);

        // dd($targetKum);

        // Progress -- ini salah karena untuk mendapatkan user kum bukan disitu, tapi biarkan dulu.
        $progress = $this->buildProgress($user->kum ?? 0, $targetKum);
        $hasPendingSubmission = $this->hasPendingSubmission($dosen?->id);

        // get pengajuan terbaru dari user untuk tombol detail kegiatan harus statusnya pending atau sedang diproses
        $pengajuanTerbaru = null;
        if (!$user->is_admin) {
            $pengajuanTerbaru = Pengajuan::where('idDosen', $dosen?->id)
                ->whereIn('status', ['pending', 'submitted', 'reviewed']) // Sesuaikan dengan status yang dianggap "sedang diproses"
                ->latest()
                ->first();
        } else {
            $pengajuanTerbaru = Pengajuan::latest()->first();
        }

        // if userID is found in user database, but in dosen table there is no userID of the user, then flag it as "only admin"
        $userIsDosen = !is_null($dosen);
        $userIsAdminButNotDosen = $user->is_admin && !$userIsDosen;
        // end of user identification


        return view('dupak.dashboard', [
            'user' => $user,
            'dosenId' => $dosen?->id,
            'dosen' => $dosen,
            'currentKum' => $progress['current'],
            'targetKum' => $progress['goal'],
            'percent' => $progress['percent'],
            'remaining' => $progress['remaining'],
            'statusColor' => $progress['statusColor'],
            'updatedAtFormatted' => $user->kum_updated_at ? Carbon::parse($user->kum_updated_at)->diffForHumans() : 'Belum pernah diperbarui',
            'jabatan_saat_ini' => $jabatanSaatIniNama,
            'jabatan_tujuan' => $jfaTujuanNama,
            'pengajuan' => $this->submissions($user, $dosen?->id)->paginate(10),
            'hasPendingSubmission' => $hasPendingSubmission, // Kirim ke view
            'pengajuanTerbaru' => $pengajuanTerbaru,
            'userIsAdminButNotDosen' => $userIsAdminButNotDosen
        ]);
    }
}
