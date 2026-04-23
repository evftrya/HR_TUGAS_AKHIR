<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\AllAboutAuthController;
use App\Http\Controllers\DashboardProdiController;
use App\Http\Controllers\DosenHasKKController;
use App\Http\Controllers\EmergencyContactController;
use App\Http\Controllers\FakultasController;
use App\Http\Controllers\FormationController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PengawakanController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RefJabatanFungsionalAkademikController;
use App\Http\Controllers\RefJabatanFungsionalKeahlianController;
use App\Http\Controllers\RefJenjangPendidikanController;
use App\Http\Controllers\RefPangkatGolonganController;
use App\Http\Controllers\RefStatusPegawaiController;
use App\Http\Controllers\RiwayatJabatanFungsionalAkademikController;
use App\Http\Controllers\RiwayatJabatanFungsionalKeahlianController;
use App\Http\Controllers\RiwayatJenjangPendidikanController;
use App\Http\Controllers\RiwayatNipController;
use App\Http\Controllers\RiwayatPangkatGolonganController;
use App\Http\Controllers\SertifikasiDosenController;
use App\Http\Controllers\SKController;
use App\Http\Controllers\TestingSIMDKController;
use App\Http\Controllers\WorkPositionController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Route::post('/testing/{kode}/{nama_fitur}', [TestingSIMDKController::class, 'submit_review'])->name('testing');

Route::get('/test-skrg', function () {
    return view('testing');
});

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Route::get('/test-role', function(){
//     return'ahszjadskz';
// })->middleware(['admin:dosen']);

// Route::get('/tes', function () {
//     return view('kelola_data.sk.view');
// })->name('import');

Route::get('/dashboard', function () {
    $user = Auth::user();
    Log::info('User accessing dashboard', [
        'id' => $user->id,
        'email' => $user->email_institusi,
        'session_id' => Session::getId(),
    ]);

    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::group(['prefix' => 'verify-email', 'as' => 'verify-email.'], function () {
    Route::get('/verify-email-view', [AllAboutAuthController::class, 'go_to_verify_page'])->name('view');
    Route::post('/verify-email-code', [AllAboutAuthController::class, 'verifiy_code'])->name('send');
});

Route::group(['prefix' => 'forget-password', 'as' => 'forget-password.'], function () {
    Route::post('/send-email', [AllAboutAuthController::class, 'forget_password'])->name('send');
    // Route::post('/send-email', [AllAboutAuthController::class, 'forget_password'])->name('send');
    Route::get('/action/{email_institusi}/{verified_code}', [AllAboutAuthController::class, 'reset_view'])->name('action');
    Route::post('/reset', [PegawaiController::class, 'reset_password'])->name('reset');
    // Route::post('/reset-password', [AllAboutAuthController::class, 'reset_password'])->name('reset');
});

Route::middleware(['auth',  \App\Http\Middleware\CekFlashUser::class])->group(function () {

    Route::get('/profile/', function () {
        return redirect(route('profile.personal-info', ['idUser' => session('account')['id']]));
    });

    Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
        Route::get('/edit', [ProfileController::class, 'profileNormalisasi'])->name('profile.edit');
        Route::get('/personal-information/{idUser}', [ProfileController::class, 'personalInfo'])->name('personal-info');
        Route::get('/change-password/{idUser}', [ProfileController::class, 'changePassword'])->name('change-password');
        Route::post('/update-password/', [ProfileController::class, 'updatePassword'])->name('update-password');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy')->middleware(['admin:admin']);

        Route::group(['prefix' => 'emergency-contacts', 'as' => 'emergency-contacts.'], function () {
            Route::get('/list/{id_User}', [EmergencyContactController::class, 'list'])->name('list');
            Route::get('/new/{id_User}', [EmergencyContactController::class, 'new'])->name('new');
            Route::post('/new-data/{id_User}', [EmergencyContactController::class, 'new_data'])->name('new-data');
            Route::get('/{id_User}/update/{id_emergency_contact}', [EmergencyContactController::class, 'updateView'])->name('updateView');
            Route::post('/{id_User}/update-data/{id_emergency_contact}', [EmergencyContactController::class, 'updateData'])->name('updateData');
        });

        Route::group(['prefix' => 'history', 'as' => 'history.'], function () {
            Route::get('/{id_user}/pemetaan', [PengawakanController::class, 'history_pemetaan'])->name('pemetaan');
            Route::get('/{id_user}/sk', [SKController::class, 'history_sk'])->name('sk');
            Route::get('/{id_pegawai}/history-nip', [RiwayatNipController::class, 'history_nip'])->name('nip');
            Route::group(['prefix' => 'pendidikan', 'as' => 'pendidikan.'], function () {
                Route::get('/{idUser}/index', [RiwayatJenjangPendidikanController::class, 'profileRiwayatPendidikan'])->name('index');
            });
        });

        Route::group(['prefix' => 'sk', 'as' => 'sk.'], function () {
            Route::get('/{id_sk_or_sk_number}/view', [SKController::class, 'view'])->name('view');
            // Route::get('/new-dikti/',[SKController::class, 'new'])->name('new-dikti');

            Route::get('/{file_path}/{id_sk}/file', [SKController::class, 'getFile'])->name('file');
        });
    });
    Route::group(['prefix' => 'manage', 'as' => 'manage.'], function () {
        Route::get('/', function () {
            return view('kelola_data.index');
        })->name('view');

        Route::group(['prefix' => 'account', 'as' => 'account.'], function () {
            Route::get('/view', function () {
                return view('kelola_data.manajemen_akun.view');
            })->name('view');

            Route::get('/list', function () {
                return view('kelola_data.manajemen_akun.list');
            })->name('list');

            Route::get('/new', function () {
                return view('kelola_data.manajemen_akun.new');
            })->name('new');
            Route::get('/dashboard', function () {
                return view('kelola_data.manajemen_akun.dashboard');
            })->name('dashboard');
        });

        Route::group(['prefix' => 'pegawai', 'as' => 'pegawai.'], function () {

            Route::get('/dashboard', [PegawaiController::class, 'dashboard'])->name('dashboard');
            Route::get('/list/{destination}', [PegawaiController::class, 'index'])->name('list');
            Route::get('/new', [PegawaiController::class, 'new'])->name('new');
            Route::get('/update_data/{id_user}/', [PegawaiController::class, 'update_data'])->name('update-data');
            Route::post('/create', [PegawaiController::class, 'create'])->name('create');
            Route::post('/update/{id_user}', [PegawaiController::class, 'update'])->name('update');
            Route::post('/{idUser}/non-active', [PegawaiController::class, 'setNonactive'])->name('set-non-active');
            Route::post('/{idUser}/set-active', [PegawaiController::class, 'setActive'])->name('set-active');
            Route::post('/{idUser}/set-admin', [PegawaiController::class, 'setAdmin'])->name('set-admin');
            Route::post('/{idUser}/set-non-admin', [PegawaiController::class, 'setNonAdmin'])->name('set-non-admin');

            Route::group(['prefix' => 'view', 'as' => 'view.'], function () {
                Route::get('/{idUser}/employee-information', [ProfileController::class, 'employeeInfo'])->name('employee-info');
                Route::get('/{idUser}/personal-information', [ProfileController::class, 'personalInfo'])->name('personal-info');
                // Route::get('/{idUser}/riwayat-jabatan', [ProfileController::class, 'riwayatJabatan'])->name('riwayat-jabatan');
                Route::get('/{idUser}/change-password', [PegawaiController::class, 'changePassword'])->name('change-password')->middleware(['admin:admin']);
                Route::post('/{idUser}/update-password', [PegawaiController::class, 'updatePassword'])->name('update-password');
            });

            Route::group(['prefix' => 'import', 'as' => 'import.'], function () {
                Route::get('/add-file/', [PegawaiController::class, 'importAdd'])->name('add-file');
                Route::post('/validate-file/', [PegawaiController::class, 'importValidateFile'])->name('validate-file');
                Route::get('/validate-data/', [PegawaiController::class, 'importValidateData'])->name('validate-data');
                Route::post('/save-data/', [PegawaiController::class, 'importSaveData'])->name('save-data');
            });
        });

        Route::group(['prefix' => 'emergency-contact', 'as' => 'emergency-contact.'], function () {

            Route::get('/{id_User}/list', [EmergencyContactController::class, 'list'])->name('list');
            Route::get('/{id_User}/new', [EmergencyContactController::class, 'new'])->name('new');
            Route::post('/{id_User}/new-data', [EmergencyContactController::class, 'new_data'])->name('new-data');
            Route::get('/{id_User}/update/{id_emergency_contact}', [EmergencyContactController::class, 'updateView'])->name('updateView');
            Route::post('/{id_User}/update-data/{id_emergency_contact}', [EmergencyContactController::class, 'updateData'])->name('updateData');
        });

        // Route::group(['prefix' => 'emergency-contact', 'as' => 'emergency-contact.'], function () {

        //     Route::get('/{id_User}/list', [EmergencyContactController::class, 'list'])->name('list');

        // });
        Route::resource('fakultas', FakultasController::class)->middleware(['admin:admin']);
        Route::group(['prefix' => 'fakultas', 'as' => 'fakultas.'], function () {
            Route::get('/view', function () {
                return view('kelola_data.fakultas.view');
            })->name('view')->middleware(['admin:admin']);

            // Route::get('/list', [FacultyController::class, 'index'])->name('list');

            Route::get('/new', function () {
                return view('kelola_data.manajemen_akun.input');
            })->name('new')->middleware(['admin:admin']);
            Route::get('/dashboard', function () {
                return view('kelola_data.manajemen_akun.dashboard');
            })->name('dashboard')->middleware(['admin:admin']);
        });

        Route::group(['prefix' => 'level', 'as' => 'level.'], function () {
            Route::get('/view', function () {
                return view('kelola_data.fakultas.view');
            })->name('view');

            Route::get('/list/', [LevelController::class, 'index'])->name('list');
            Route::get('/new', [LevelController::class, 'new'])->name('new');
            Route::post('/create', [LevelController::class, 'create'])->name('create');
            Route::post('/update-data/{idLevel}', [LevelController::class, 'update_data'])->name('update-data');
            Route::get('/update/{idLevel}', [LevelController::class, 'update'])->name('update');

            // Route::get('/new', function () {
            //     return view('kelola_data.level.input');
            // })->name('new');
            Route::get('/dashboard', function () {
                return view('kelola_data.manajemen_akun.dashboard');
            })->name('dashboard');
        });
        Route::group(['prefix' => 'jfa', 'as' => 'jfa.'], function () {
            Route::get('/list/', [RiwayatJabatanFungsionalAkademikController::class, 'index'])->name('list');
            Route::get('/new/', [RiwayatJabatanFungsionalAkademikController::class, 'new'])->name('new');
            Route::get('/update/{id_jfa}', [RiwayatJabatanFungsionalAkademikController::class, 'update'])->name('update');
            Route::post('/update-data/{id_jfa}', [RiwayatJabatanFungsionalAkademikController::class, 'update_data'])->name('update-data');
            Route::post('/store/', [RiwayatJabatanFungsionalAkademikController::class, 'store'])->name('store');

            Route::group(['prefix' => 'ref', 'as' => 'ref.'], function () {
                Route::get('/new/', [RefJabatanFungsionalAkademikController::class, 'new'])->name('new');
                Route::get('/edit/', [RefJabatanFungsionalAkademikController::class, 'edit'])->name('edit');
                Route::get('/list/', [RefJabatanFungsionalAkademikController::class, 'list'])->name('list');
                Route::post('/store/', [RefJabatanFungsionalAkademikController::class, 'store'])->name('store');
                Route::post('/update/{id}', [RefJabatanFungsionalAkademikController::class, 'update'])->name('update');
            });
        });

        Route::group(['prefix' => 'jfk', 'as' => 'jfk.'], function () {
            Route::get('/list/', [RiwayatJabatanFungsionalKeahlianController::class, 'index'])->name('list');
            Route::get('/new/', [RiwayatJabatanFungsionalKeahlianController::class, 'new'])->name('new');
            Route::post('/store/', [RiwayatJabatanFungsionalKeahlianController::class, 'store'])->name('store');
            Route::get('/update/{id_jfk}/', [RiwayatJabatanFungsionalKeahlianController::class, 'update'])->name('update');
            Route::post('/update-data/{id_jfk}/', [RiwayatJabatanFungsionalKeahlianController::class, 'update_data'])->name('update-data');
            Route::post('/fill-sk-ypt/{id_jfk}/', [RiwayatJabatanFungsionalKeahlianController::class, 'isi_sk_ypt'])->name('fill-sk-ypt');

            Route::group(['prefix' => 'ref', 'as' => 'ref.'], function () {
                Route::get('/list/', [RefJabatanFungsionalKeahlianController::class, 'list'])->name('list');
                Route::post('/store/', [RefJabatanFungsionalKeahlianController::class, 'store'])->name('store');
                Route::post('/update/{id}', [RefJabatanFungsionalKeahlianController::class, 'update'])->name('update');
            });
        });

        Route::group(['prefix' => 'pangkat-golongan', 'as' => 'pangkat-golongan.'], function () {
            Route::get('/list/', [RiwayatPangkatGolonganController::class, 'index'])->name('list');
            Route::get('/new/', [RiwayatPangkatGolonganController::class, 'new'])->name('new');
            Route::post('/store/', [RiwayatPangkatGolonganController::class, 'store'])->name('store');
            Route::get('/update/{id_pg}/', [RiwayatPangkatGolonganController::class, 'update'])->name('update');
            Route::post('/update-data/{id_pg}/', [RiwayatPangkatGolonganController::class, 'update_data'])->name('update-data');
            Route::post('/fill-sk-dikti/{id_pg}/', [RiwayatPangkatGolonganController::class, 'isi_sk_dikti'])->name('fill-sk-dikti');

            Route::group(['prefix' => 'ref', 'as' => 'ref.'], function () {
                Route::get('/', function () {
                    return redirect(route('manage.pangkat-golongan.ref.list'));
                })->name('index');
                Route::get('/list/', [RefPangkatGolonganController::class, 'list'])->name('list');
                Route::get('/new/', [RefPangkatGolonganController::class, 'new'])->name('new');
                Route::get('/edit/{id_rpg}/', [RefPangkatGolonganController::class, 'edit'])->name('edit');
                Route::post('/update/', [RefPangkatGolonganController::class, 'update'])->name('update-data');
                Route::post('/store/', [RefPangkatGolonganController::class, 'store'])->name('store');
            });
        });

        Route::group(['prefix' => 'jenjang-pendidikan', 'as' => 'jenjang-pendidikan.'], function () {
            Route::get('/list/', [RiwayatJenjangPendidikanController::class, 'index'])->name('list');
            Route::get('/new/', [RiwayatJenjangPendidikanController::class, 'new'])->name('new');
            Route::post('/store/', [RiwayatJenjangPendidikanController::class, 'store'])->name('store');
            Route::get('/update/{id_jp}/', [RiwayatJenjangPendidikanController::class, 'update'])->name('update');
            Route::post('/update-data/{id_jp}/', [RiwayatJenjangPendidikanController::class, 'update_data'])->name('update-data');
            Route::get('/{idUser}/index', [RiwayatJenjangPendidikanController::class, 'profileRiwayatPendidikan'])->name('index');

            Route::group(['prefix' => 'ref', 'as' => 'ref.'], function () {
                Route::get('/new/', [RefJenjangPendidikanController::class, 'new'])->name('new');
                Route::get('/edit/', [RefJenjangPendidikanController::class, 'edit'])->name('edit');
                Route::get('/list/', [RefJenjangPendidikanController::class, 'list'])->name('list');
                Route::post('/store/', [RefJenjangPendidikanController::class, 'store'])->name('store');
                Route::post('/update/', [RefJenjangPendidikanController::class, 'update'])->name('update');
            });
        });

        Route::group(['prefix' => 'riwayat-nip', 'as' => 'riwayat-nip.'], function () {
            Route::get('/list/', [RiwayatNipController::class, 'index'])->name('list');
            Route::get('/new/', [RiwayatNipController::class, 'new'])->name('new');
            Route::post('/create/', [RiwayatNipController::class, 'create_data'])->name('create');
            Route::get('/history-nip/{id_pegawai}', [RiwayatNipController::class, 'history_nip'])->name('history');
            Route::get('/update-data/{id_nip}', [RiwayatNipController::class, 'update_data'])->name('update-data');
            Route::post('/update/{id_nip}', [RiwayatNipController::class, 'update'])->name('update');
        });

        Route::group(['prefix' => 'sk', 'as' => 'sk.'], function () {
            Route::get('/list', [SKController::class, 'index'])->name('list');
            Route::get('/input', [SKController::class, 'input_blade'])->name('input');
            Route::get('/edit/{id}', [SKController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [SKController::class, 'update'])->name('update');
            Route::post('/{YptOrDikti}/new', [SKController::class, 'new'])->name('new');
            Route::post('/simpan', [SKController::class, 'store'])->name('store');
            Route::get('/{id_sk_or_sk_number}/view', [SKController::class, 'view'])->name('view');
            // Route::get('/new-dikti/',[SKController::class, 'new'])->name('new-dikti');

            Route::get('/file/{id_sk}', [SKController::class, 'getFile'])->name('file');

            Route::get('/history/sk/{id_user}', [SKController::class, 'history_sk'])->name('history');
        });

        Route::group(['prefix' => 'formasi', 'as' => 'formasi.'], function () {
            Route::get('/view', function () {
                return view('kelola_data.formasi.view');
            })->name('view');

            Route::get('/list/', [FormationController::class, 'index'])->name('list');
            Route::get('/new/', [FormationController::class, 'new'])->name('new');
            Route::post('/create/', [FormationController::class, 'create'])->name('create');
            Route::get('/update/{idFormasi}', [FormationController::class, 'update'])->name('update');
            Route::post('/update-data/{idFormasi}', [FormationController::class, 'update_data'])->name('update-data');

            // Route::get('/new', function () {
            //     return view('kelola_data.formasi.view');
            // })->name('new');
            // Route::get('/dashboard', function () {
            //     return view('kelola_data.manajemen_akun.dashboard');
            // })->name('dashboard');
        });

        Route::group(['prefix' => 'pengawakan', 'as' => 'pengawakan.'], function () {
            // Route::get('/view', function () {
            //     return view('kelola_data.sotk-pengawakan.view');
            // })->name('view');
            // Route::get('/input', function () {
            //     return view('kelola_data.sotk-pengawakan.input');
            // })->name('input');

            Route::get('/list/', [PengawakanController::class, 'index'])->name('list');
            Route::get('/new/', [PengawakanController::class, 'new'])->name('new');
            Route::get('/struktur/', [PengawakanController::class, 'struktur'])->name('struktur');
            Route::post('/create/', [PengawakanController::class, 'create'])->name('create');
            Route::get('/update/{idPemetaan}/', [PengawakanController::class, 'update'])->name('update');
            Route::post('/update-data/{idPemetaan}/', [PengawakanController::class, 'update_data'])->name('update-data');
            Route::post('/selesaikan-jabatan/', [PengawakanController::class, 'end_pemetaan'])->name('selesaikan-jabatan');
            Route::get('/history-pemetaan/{id_user}/', [PengawakanController::class, 'history_pemetaan'])->name('history-pemetaan');
        });

        // Fakultas Routes

        // Prodi Routes
        Route::resource('prodi', ProdiController::class)->only(['create', 'store'])->middleware(['admin:admin']);
        Route::resource('prodi', ProdiController::class)->except(['create', 'store']);

        Route::group(['prefix' => 'prodi', 'as' => 'prodi.'], function () {
            Route::get('/{prodi}/get-cached-stats', [ProdiController::class, 'getCachedStats'])->name('getCachedStats');
            Route::post('/{prodi}/update-stats', [ProdiController::class, 'updateStats'])->name('updateStats');
            Route::get('/{prodi_id}/edit', [ProdiController::class, 'edit'])->name('edit');
        });

        Route::group(['prefix' => 'bagian', 'as' => 'bagian.'], function () {
            Route::get('/list', [WorkPositionController::class, 'list'])->name('list');
            Route::get('/input', [WorkPositionController::class, 'new'])->name('new');
            Route::get('/{id_wp}/edit', [WorkPositionController::class, 'edit'])->name('edit');
            Route::post('/create', [WorkPositionController::class, 'create'])->name('create');
            Route::post('/{id_wp}/edit_data', [WorkPositionController::class, 'update'])->name('update');
        });

        Route::group(['prefix' => 'status-pegawai', 'as' => 'status-pegawai.'], function () {
            Route::get('/list', [RefStatusPegawaiController::class, 'list'])->name('list');
            Route::post('/update', [RefStatusPegawaiController::class, 'update'])->name('update');
            Route::post('/create', [RefStatusPegawaiController::class, 'create'])->name('create');
        });

        // Dashboard Prodi Routes
        Route::group(['prefix' => 'dashboard-prodi', 'as' => 'dashboard-prodi.'], function () {
            Route::get('/pendidikan', [DashboardProdiController::class, 'pendidikan'])->name('pendidikan');
            Route::get('/fungsional', [DashboardProdiController::class, 'fungsional'])->name('fungsional');
            Route::get('/kepegawaian', [DashboardProdiController::class, 'kepegawaian'])->name('kepegawaian');
        });

        // Sertifikasi Dosen Routes
        Route::group(['prefix' => 'sertifikasi-dosen', 'as' => 'sertifikasi-dosen.'], function () {
            Route::get('/list', [SertifikasiDosenController::class, 'index'])->name('list')->middleware(['admin:admin']);
            Route::get('/bpmn', [SertifikasiDosenController::class, 'bpmn'])->name('bpmn')->middleware(['admin:dosen|admin']);
            Route::get('/{id_serdos}/file', [SertifikasiDosenController::class, 'serdos_file'])->name('file')->middleware(['admin:dosen|admin']);
            Route::get('/input', [SertifikasiDosenController::class, 'create'])->name('input')->middleware(['admin:dosen']);
            Route::post('/store', [SertifikasiDosenController::class, 'store'])->name('store')->middleware(['admin:dosen']);
            Route::get('/view/{id}', [SertifikasiDosenController::class, 'view'])->name('view')->middleware(['admin:dosen|admin']);
            Route::get('/edit/{id}', [SertifikasiDosenController::class, 'edit'])->name('edit')->middleware(['admin:dosen']);
            Route::post('/update/{id}', [SertifikasiDosenController::class, 'update'])->name('update')->middleware(['admin:dosen']);
            Route::delete('/destroy/{id}', [SertifikasiDosenController::class, 'destroy'])->name('destroy')->middleware(['admin:dosen']);
            Route::get('/upload', [SertifikasiDosenController::class, 'upload'])->name('upload')->middleware(['admin:dosen']);
            // Route::get('/file/{id}', [SertifikasiDosenController::class, 'view_file'])->name('file')->middleware(['admin:dosen|admin']);
            Route::post('/process-upload', [SertifikasiDosenController::class, 'processUpload'])->name('process-upload')->middleware(['admin:dosen']);
        });

        // Kelompok Keahlian Routes
        Route::group(['prefix' => 'kelompok-keahlian', 'as' => 'kelompok-keahlian.'], function () {
            Route::get('/list', [\App\Http\Controllers\KelompokKeahlianController::class, 'index'])->name('list')->middleware(['admin:admin']);
            Route::get('/input', [\App\Http\Controllers\KelompokKeahlianController::class, 'create'])->name('input')->middleware(['admin:admin']);
            Route::post('/store', [\App\Http\Controllers\KelompokKeahlianController::class, 'store'])->name('store')->middleware(['admin:admin']);
            Route::get('/view/{id}', [\App\Http\Controllers\KelompokKeahlianController::class, 'show'])->name('view')->middleware(['admin:admin']);
            Route::get('/edit/{id}', [\App\Http\Controllers\KelompokKeahlianController::class, 'edit'])->name('edit')->middleware(['admin:admin']);
            Route::post('/update/{id}', [\App\Http\Controllers\KelompokKeahlianController::class, 'update'])->name('update')->middleware(['admin:admin']);
            Route::delete('/destroy/{id}', [\App\Http\Controllers\KelompokKeahlianController::class, 'destroy'])->name('destroy')->middleware(['admin:admin']);
            Route::post('/nonaktifkan/{id}', [\App\Http\Controllers\KelompokKeahlianController::class, 'nonaktifkan'])->name('nonaktifkan')->middleware(['admin:admin']);
            Route::post('/assign-dosen/{id}', [\App\Http\Controllers\KelompokKeahlianController::class, 'assignDosen'])->name('assignDosen')->middleware(['admin:admin']);
            Route::get('/pegawai-list', [\App\Http\Controllers\KelompokKeahlianController::class, 'pegawaiList'])->name('pegawai-list')->middleware(['admin:admin']);

            Route::group(['prefix' => 'sub', 'as' => 'sub.'], function () {
                Route::get('/list', [\App\Http\Controllers\RefSubKelompokKeahlianController::class, 'index'])->name('list')->middleware(['admin:admin']);
                Route::post('/store', [\App\Http\Controllers\RefSubKelompokKeahlianController::class, 'store'])->name('store')->middleware(['admin:admin']);
                Route::post('/update/{id}', [\App\Http\Controllers\RefSubKelompokKeahlianController::class, 'update'])->name('update')->middleware(['admin:admin']);
            });

            Route::group(['prefix' => 'dosen-with-kk', 'as' => 'dosen-with-kk.'], function () {
                // Route::get('/list', [\App\Http\Controllers\RefSubKelompokKeahlianController::class, 'index'])->name('list')->middleware(['admin:admin']);
                Route::post('/store', [\App\Http\Controllers\DosenHasKKController::class, 'store'])->name('store')->middleware(['admin:admin']);
                Route::get('/lepas-dosen/{DosenHasKK_id}', [\App\Http\Controllers\DosenHasKKController::class, 'lepas_dosen'])->name('lepas-dosen')->middleware(['admin:admin']);
                Route::get('/struktur/', [DosenHasKKController::class, 'struktur'])->name('struktur');

            });
        });

        // COE (Center of Excellence) Routes
        Route::resource('coe', \App\Http\Controllers\CoeController::class);


        // Kinerja Pegawai — Dashboard landing (must be before the prefix group)
        Route::get('/target-kinerja', [\App\Http\Controllers\KinerjaDashboardController::class, 'index'])->name('target-kinerja.index');

        // Presensi & Jam Kerja
        Route::get('/presensi', [\App\Http\Controllers\PresensiController::class, 'index'])->name('presensi.index');

        // Target Kinerja Routes
        Route::group(['prefix' => 'target-kinerja', 'as' => 'target-kinerja.'], function () {
            Route::get('/list', [\App\Http\Controllers\TargetKinerjaController::class, 'index'])->name('list');
            Route::get('/input', [\App\Http\Controllers\TargetKinerjaController::class, 'create'])->name('input');
            Route::post('/store', [\App\Http\Controllers\TargetKinerjaController::class, 'store'])->name('store');
            Route::get('/view/{id}', [\App\Http\Controllers\TargetKinerjaController::class, 'show'])->name('view');
            Route::get('/edit/{id}', [\App\Http\Controllers\TargetKinerjaController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [\App\Http\Controllers\TargetKinerjaController::class, 'update'])->name('update');
            Route::delete('/destroy/{id}', [\App\Http\Controllers\TargetKinerjaController::class, 'destroy'])->name('destroy');
            Route::get('/assign/{id}', [\App\Http\Controllers\TargetKinerjaController::class, 'assign'])->name('assign');
            Route::post('/assign/{id}', [\App\Http\Controllers\TargetKinerjaController::class, 'storeAssignment'])->name('store-assignment');
            Route::post('/assign/{id}/pegawai/{userId}/status', [\App\Http\Controllers\TargetKinerjaController::class, 'updateAssignmentStatus'])->name('update-assignment-status');
            Route::delete('/assign/{id}/pegawai/{userId}', [\App\Http\Controllers\TargetKinerjaController::class, 'detachPegawai'])->name('detach-pegawai');
            // settings page removed — configuration is per-target now
            Route::get('/laporan', [\App\Http\Controllers\TargetKinerjaController::class, 'laporan'])->name('laporan');

            // Target Kinerja Harian (set target harian)
            Route::group(['prefix' => 'harian', 'as' => 'harian.'], function () {
                Route::get('/list', [\App\Http\Controllers\TargetKinerjaHarianController::class, 'index'])->name('list');
                Route::get('/input', [\App\Http\Controllers\TargetKinerjaHarianController::class, 'create'])->name('input');
                Route::post('/store', [\App\Http\Controllers\TargetKinerjaHarianController::class, 'store'])->name('store');
                Route::get('/view/{id}', [\App\Http\Controllers\TargetKinerjaHarianController::class, 'show'])->name('view');
                Route::delete('/destroy/{id}', [\App\Http\Controllers\TargetKinerjaHarianController::class, 'destroy'])->name('destroy');

                // Pelaporan (isi target)
                Route::get('/{id}/isi', [\App\Http\Controllers\PelaporanPekerjaanController::class, 'create'])->name('isi');
                Route::post('/{id}/submit-report', [\App\Http\Controllers\PelaporanPekerjaanController::class, 'store'])->name('submit-report');

                // Assignment moved to daily target (target_kinerja_harian)
                Route::get('/{id}/assign', [\App\Http\Controllers\TargetKinerjaHarianController::class, 'assign'])->name('assign');
                Route::post('/{id}/assign', [\App\Http\Controllers\TargetKinerjaHarianController::class, 'storeAssignment'])->name('store-assignment');
                Route::post('/{id}/assign/pegawai/{userId}/status', [\App\Http\Controllers\TargetKinerjaHarianController::class, 'updateAssignmentStatus'])->name('update-assignment-status');
                Route::delete('/{id}/assign/pegawai/{userId}', [\App\Http\Controllers\TargetKinerjaHarianController::class, 'detachPegawai'])->name('detach-pegawai');

                // Approval
                Route::get('/reports', [\App\Http\Controllers\PelaporanPekerjaanController::class, 'approvalList'])->name('reports');
                Route::get('/reports/{id}/approval', [\App\Http\Controllers\PelaporanPekerjaanController::class, 'showApproval'])->name('reports.approval');
                Route::post('/reports/{id}/approve', [\App\Http\Controllers\PelaporanPekerjaanController::class, 'approve'])->name('reports.approve');
            });
        });

        // Studi Lanjut Routes
        Route::group(['prefix' => 'studi-lanjut', 'as' => 'studi-lanjut.'], function () {
            Route::get('/list', [\App\Http\Controllers\StudiLanjutController::class, 'index'])->name('list');
            Route::get('/input', [\App\Http\Controllers\StudiLanjutController::class, 'create'])->name('input');
            Route::post('/store', [\App\Http\Controllers\StudiLanjutController::class, 'store'])->name('store');
            Route::get('/view/{id}', [\App\Http\Controllers\StudiLanjutController::class, 'show'])->name('view');
            Route::get('/edit/{id}', [\App\Http\Controllers\StudiLanjutController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [\App\Http\Controllers\StudiLanjutController::class, 'update'])->name('update');
            Route::delete('/destroy/{id}', [\App\Http\Controllers\StudiLanjutController::class, 'destroy'])->name('destroy');
        });
    });

    //

    Route::group([
        'prefix' => 'dupak',
        'as' => 'dupak.',
        // 'middleware' => ['auth'],
    ], function () {
        // Dashboard
        Route::get('/dashboard', [App\Http\Controllers\Dupak\DashboardController::class, 'index'])
            ->name('dashboard');

        // Pengajuan DUPAK
        Route::resource('pengajuan', \App\Http\Controllers\Dupak\PengajuanController::class)
            ->except(['edit', 'update', 'destroy']);

        // Riwayat DUPAK
        Route::resource('riwayat', \App\Http\Controllers\Dupak\RiwayatController::class)
            ->only(['index', 'show']);

        // Validasi DUPAK (for admin/validator)
        Route::resource('validasi', \App\Http\Controllers\Dupak\ValidasiController::class)
            ->only(['index', 'show', 'update']);

        // Pengisian Detil Formulir Pengajuan
        Route::resource('detil_pengajuan', \App\Http\Controllers\Dupak\DetilPengajuanController::class);
    });

    // Kinerja Pegawai Routes (separated from manage)
    Route::group(['prefix' => 'kinerja', 'as' => 'kinerja.'], function () {
        // Main index — with data from KinerjaDashboardController
        Route::get('/', [\App\Http\Controllers\KinerjaDashboardController::class, 'index'])->name('index');

        // Base and sidebar may be included in other views but provide direct routes for preview
        Route::get('/base', function () {
            return view('kinerja_pegawai.base');
        })->name('base');

        Route::get('/sidebar', function () {
            return view('kinerja_pegawai.sidebar');
        })->name('sidebar');

        // Dashboard Fakultas
        Route::get('/dashboard/fakultas', function () {
            return view('kinerja_pegawai.dashboard_fakultas.index');
        })->name('dashboard.fakultas.index');

        Route::get('/dashboard/fakultas/{id?}', function ($id = null) {
            return view('kinerja_pegawai.dashboard_fakultas.detail', ['id' => $id]);
        })->name('dashboard.fakultas.detail');

        Route::get('/dashboard/fakultas/input/{id?}', function ($id = null) {
            return view('kinerja_pegawai.dashboard_fakultas.input', ['id' => $id]);
        })->name('dashboard.fakultas.input');

        // Dashboard Target
        Route::get('/dashboard/target', function () {
            return view('kinerja_pegawai.dashboard_target.input');
        })->name('dashboard.target.input');

        Route::get('/dashboard/target/{action}/{id?}', function ($action, $id = null) {
            $action = in_array($action, ['approval', 'detail', 'edit', 'input']) ? $action : 'detail';

            return view("kinerja_pegawai.dashboard_target.$action", ['id' => $id]);
        })->where('action', 'approval|detail|edit|input')->name('dashboard.target.action');

        // Laporan Target
        Route::get('/laporan/target/{id?}', function ($id = null) {
            return view('kinerja_pegawai.laporan_target.detail', ['id' => $id]);
        })->name('laporan.target.detail');
    });
});

// Admin Routes
Route::middleware(['auth', 'admin:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // User Management
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/{user}', [AdminController::class, 'showUser'])->name('users.show');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');
});

require __DIR__.'/auth.php';
