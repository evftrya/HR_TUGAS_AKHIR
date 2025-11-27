<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\DashboardProdiController;
use App\Http\Controllers\EmergencyContactController;
use App\Http\Controllers\FakultasController;
use App\Http\Controllers\FormationController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PengawakanController;
use App\Http\Controllers\ProdiController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\SertifikasiDosenController;
use App\Models\Emergency_contact;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    $user = Auth::user();
    Log::info('User accessing dashboard', [
        'id' => $user->id,
        'email' => $user->email_institusi,
        'session_id' => Session::getId()
    ]);

    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Route::get('/profile/edit', [ProfileController::class, 'profileNormalisasi'])->name('profile.edit');
    // Route::get('/profile/personal-information/{idUser}', [ProfileController::class, 'personalInfo'])->name('profile.personal-info');
    // Route::get('/profile/change-password/{idUser}', [ProfileController::class, 'changePassword'])->name('profile.change-password');
    // Route::post('/profile/update-password/', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
        Route::get('/edit', [ProfileController::class, 'profileNormalisasi'])->name('profile.edit');
        Route::get('/personal-information/{idUser}', [ProfileController::class, 'personalInfo'])->name('personal-info');
        Route::get('/change-password/{idUser}', [ProfileController::class, 'changePassword'])->name('change-password');
        Route::post('/update-password/', [ProfileController::class, 'updatePassword'])->name('update-password');
        Route::post('/emergency-contacts/{idUser}', [EmergencyContactController::class, 'emergencyContacts'])->name('emergency-contacts');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
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

            Route::get('/list/{destination}', [PegawaiController::class, 'index'])->name('list');
            Route::get('/new', [PegawaiController::class, 'new'])->name('new');
            Route::post('/create', [PegawaiController::class, 'create'])->name('create');
            Route::post('/{idUser}/non-active', [PegawaiController::class, 'setNonactive'])->name('set-non-active');
            Route::post('/{idUser}/set-active', [PegawaiController::class, 'setActive'])->name('set-active');
            Route::group(['prefix' => 'view', 'as' => 'view.'], function () {
                Route::get('/{idUser}/employee-information', [ProfileController::class, 'employeeInfo'])->name('employee-info');
                Route::get('/{idUser}/personal-information', [ProfileController::class, 'personalInfo'])->name('personal-info');
                Route::get('/{idUser}/riwayat-jabatan', [ProfileController::class, 'riwayatJabatan'])->name('riwayat-jabatan');
                Route::get('/{idUser}/change-password', [PegawaiController::class, 'changePassword'])->name('change-password');
                Route::post('/{idUser}/update-password', [PegawaiController::class, 'updatePassword'])->name('update-password');
            });

            Route::get('/dashboard', function () {
                return view('kelola_data.manajemen_akun.dashboard');
            })->name('dashboard');
        });

        Route::group(['prefix' => 'emergency-contact', 'as' => 'emergency-contact.'], function () {

            Route::get('/{id_User}/list', [EmergencyContactController::class, 'list'])->name('list');
        });

        // Route::group(['prefix' => 'emergency-contact', 'as' => 'emergency-contact.'], function () {

        //     Route::get('/{id_User}/list', [EmergencyContactController::class, 'list'])->name('list');

        // });

        Route::group(['prefix' => 'fakultas', 'as' => 'fakultas.'], function () {
            Route::get('/view', function () {
                return view('kelola_data.fakultas.view');
            })->name('view');

            // Route::get('/list', [FacultyController::class, 'index'])->name('list');

            Route::get('/new', function () {
                return view('kelola_data.manajemen_akun.input');
            })->name('new');
            Route::get('/dashboard', function () {
                return view('kelola_data.manajemen_akun.dashboard');
            })->name('dashboard');
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
            Route::post('/create/', [PengawakanController::class, 'create'])->name('create');
            Route::get('/update/', [PengawakanController::class, 'update'])->name('update');
            Route::post('/update-data/', [PengawakanController::class, 'update-data'])->name('update-data');

            // Route::get('/new', function () {
            //     return view('kelola_data.sotk-pengawakan.view');
            // })->name('new');
            // Route::get('/dashboard', function () {
            //     return view('kelola_data.sotk-pengawakan.dashboard');
            // })->name('dashboard');
        });

        // Fakultas Routes
        Route::resource('fakultas', FakultasController::class);

        // Prodi Routes
        Route::get('prodi/{prodi}/get-cached-stats', [ProdiController::class, 'getCachedStats'])->name('prodi.getCachedStats');
        Route::post('prodi/{prodi}/update-stats', [ProdiController::class, 'updateStats'])->name('prodi.updateStats');
        Route::resource('prodi', ProdiController::class);

        // Dashboard Prodi Routes
        Route::group(['prefix' => 'dashboard-prodi', 'as' => 'dashboard-prodi.'], function () {
            Route::get('/pendidikan', [DashboardProdiController::class, 'pendidikan'])->name('pendidikan');
            Route::get('/fungsional', [DashboardProdiController::class, 'fungsional'])->name('fungsional');
            Route::get('/kepegawaian', [DashboardProdiController::class, 'kepegawaian'])->name('kepegawaian');
        });

        // Sertifikasi Dosen Routes
        Route::group(['prefix' => 'sertifikasi-dosen', 'as' => 'sertifikasi-dosen.'], function () {
            Route::get('/list', [SertifikasiDosenController::class, 'index'])->name('list');
            Route::get('/input', [SertifikasiDosenController::class, 'create'])->name('input');
            Route::post('/store', [SertifikasiDosenController::class, 'store'])->name('store');
            Route::get('/view/{id}', [SertifikasiDosenController::class, 'view'])->name('view');
            Route::get('/edit/{id}', [SertifikasiDosenController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [SertifikasiDosenController::class, 'update'])->name('update');
            Route::delete('/destroy/{id}', [SertifikasiDosenController::class, 'destroy'])->name('destroy');
            Route::get('/upload', [SertifikasiDosenController::class, 'upload'])->name('upload');
            Route::post('/process-upload', [SertifikasiDosenController::class, 'processUpload'])->name('process-upload');
        });
    });

    // --------------- Dupak Routing --------------------
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
        // Main index
        Route::get('/', function () {
            return view('kinerja_pegawai.index');
        })->name('index');

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
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // User Management
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/{user}', [AdminController::class, 'showUser'])->name('users.show');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');
});

require __DIR__ . '/auth.php';
