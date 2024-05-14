<?php

/**
 * Controller Sayang
 */

use App\Http\Controllers\LoginController;
use App\Http\Controllers\AparController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\IpalController;
use App\Http\Controllers\GasMedikController;
use App\Http\Controllers\SistemKelistrikanController;
use App\Http\Controllers\MasterDataController;
use App\Http\Controllers\SistemPengairanController;
use App\Http\Controllers\SistemJaringanKomunikasiController;
use App\Http\Controllers\SistemProteksiPetirController;
use App\Http\Controllers\PagarSelasarController;
use App\Http\Controllers\PencahayaanDanVentilasiController;
use App\Http\Controllers\KendaraanPuskesmasController;
use App\Http\Controllers\MobilPuslingController;
use App\Http\Controllers\NotifikasiMFKController;



/**
 * Model Sayang
 */
// use App\Models\GroupAgentModel;
// use App\Models\MainModel;
// use App\Models\PerusahaanModel;
// use App\Models\UserManagementModel;

/**
 * Lain - lain
 */
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route Web



Route::get("/login",                    [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::match(['get', 'post'], '/auth',  [LoginController::class, 'auth_login'])->name('auth');
Route::get("/logout",                   [LoginController::class, 'logout'])->name('logout');
Route::get('/no_power', function () {
    return view('no_power');
})->name('no_power');

// Route with Filter Login
/**
 * Middleware RouteValidation, untuk mengecek apakah user
 * memiliki hak akses ke halaman index tersebut,
 * jangan kuatir semua hak akses sudah diatur di database
 */

Route::group(['middleware' => ['XssSanitization', 'auth', 'InputSanitasi',]], function () {

        //Log itu nomor 1
        Route::get("/byakugan", [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);

        // Dashboard
        Route::get("/dashboard",        [DashboardController::class, 'index'])->name('dashboard');
        Route::post("/dashboard/get_data_mfk", [DashboardController::class, 'get_data_mfk']);
        Route::get("/",                 [DashboardController::class, 'index'])->name('/');
        Route::post('/change_password', [DashboardController::class, 'change_password']);

        // ================================ MASTER RUANGAN  ==================

        Route::get("/master_ruangan", [MasterDataController::class, 'master_ruangan'])
                ->name('master_ruang');
        
        Route::get("/master_kendaraan", [MasterDataController::class, 'master_kendaraan'])
                ->name('master_kendaraan');

        Route::get("/master_puskesmas", [MasterDataController::class, 'master_puskesmas'])
                ->name('master_puskesmas');

        // ================================ USER MANAGEMENT ==================
        Route::get("/user_management", [UserManagementController::class, 'index'])
                ->name('user_management')
                ->middleware('RouteValidation');

        Route::post("/user_management/datatable", [UserManagementController::class, 'datatable']);

        Route::post("/user_management/process", [UserManagementController::class, 'process']);

        Route::post("/user_management/delete_user", [UserManagementController::class, 'delete_user']);
        Route::post("/user_management/activate_user", [UserManagementController::class, 'activate_user']);
        Route::post("/user_management/reset_password", [UserManagementController::class, 'reset_password']);

        Route::post("/user_management/get", [UserManagementController::class, 'get_data_menu_user']);
        Route::post("/user_management/process_menu_user", [UserManagementController::class, 'process_menu_user']);
        // =============================END USER MANAGEMENT ==================

        // ================================ NOTIFIKASI MFK =====================

        Route::get("/notifikasi_mfk", [NotifikasiMFKController::class, 'index'])
                ->name('notifikasi_mfk')
                ->middleware('RouteValidation');

       
        Route::post("/notifikasi_mfk/process", [NotifikasiMFKController::class, 'process']);
        Route::post("/notifikasi_mfk/delete", [NotifikasiMFKController::class, 'hapus']);
        Route::post("/notifikasi_mfk/get", [NotifikasiMFKController::class, 'get_data']);

        // =============================END NOTIFIKASI MFK =====================

        // ================================ APAR =============================
        Route::get("/apar", [AparController::class, 'index'])
                ->name('apar')
                ->middleware('RouteValidation');

        Route::post("/apar/datatable", [AparController::class, 'datatable']);

        Route::post("/apar/process", [AparController::class, 'process']);
        Route::post("/apar/delete", [AparController::class, 'hapus']);
        Route::post("/apar/get", [AparController::class, 'get_data']);

        //==========================END APAR======================================

        //=============================IPAL=======================================
        Route::get("/ipal", [IpalController::class, 'index'])
                ->name('ipal')
                ->middleware('RouteValidation');

        Route::post("/ipal/datatable", [IpalController::class, 'datatable']);
        Route::post("/ipal/process", [IpalController::class, 'process']);
        Route::post("/ipal/delete", [IpalController::class, 'hapus']);
        Route::post("/ipal/get", [IpalController::class, 'get_data']);

        //==========================END IPAL======================================

        //========================= GAS MEDIK ====================================

        Route::get("/gas_medik", [GasMedikController::class, 'index'])
            ->name('gas_medik')
            ->middleware('RouteValidation');
        Route::post("/gas_medik/datatable", [GasMedikController::class, 'datatable']);
        Route::post("/gas_medik/process", [GasMedikController::class, 'process']);
        Route::post("/gas_medik/delete", [GasMedikController::class, 'hapus']);
        Route::post("/gas_medik/get", [GasMedikController::class, 'get_data']);
        
        //========================= END GAS MEDIK ================================

        //========================= SISTEM KELISTRIKAN ============================

        Route::get("/sistem_kelistrikan", [SistemKelistrikanController::class, 'index'])
            ->name('sistem_kelistrikan')
            ->middleware('RouteValidation');
        
        Route::post("/sistem_kelistrikan/datatable", [SistemKelistrikanController::class, 'datatable']);
        Route::post("/sistem_kelistrikan/process", [SistemKelistrikanController::class, 'process']);
        Route::post("/sistem_kelistrikan/delete", [SistemKelistrikanController::class, 'hapus']);
        Route::post("/sistem_kelistrikan/get", [SistemKelistrikanController::class, 'get_data']);

        //======================= END SISTEM KELISTRIKAN ==========================

        //========================= SISTEM PENGAIRAN ==============================

        Route::get("/sistem_pengairan", [SistemPengairanController::class, 'index'])
            ->name('sistem_pengairan')
            ->middleware('RouteValidation');

        Route::post("/sistem_pengairan/datatable", [SistemPengairanController::class, 'datatable']);
        Route::post("/sistem_pengairan/process", [SistemPengairanController::class, 'process']);
        Route::post("/sistem_pengairan/delete", [SistemPengairanController::class, 'hapus']);
        Route::post("/sistem_pengairan/get", [SistemPengairanController::class, 'get_data']);

        //======================= END SISTEM PENGAIRAN ==========================

        //========================= SISTEM JARINGAN KOMUNIKASI ====================
        Route::get("/sistem_jaringan_komunikasi", [SistemJaringanKomunikasiController::class, 'index'])
            ->name('sistem_jaringan_komunikasi')
            ->middleware('RouteValidation');
        Route::post("/sistem_jaringan_komunikasi/datatable", [SistemJaringanKomunikasiController::class, 'datatable']);
        Route::post("/sistem_jaringan_komunikasi/process", [SistemJaringanKomunikasiController::class, 'process']);
        Route::post("/sistem_jaringan_komunikasi/delete", [SistemJaringanKomunikasiController::class, 'hapus']);
        Route::post("/sistem_jaringan_komunikasi/get", [SistemJaringanKomunikasiController::class, 'get_data']);

        //======================= END SISTEM JARINGAN KOMUNIKASI =================

        //========================= SISTEM PROTEKSI PETIR =========================
        Route::get("/sistem_proteksi_petir", [SistemProteksiPetirController::class, 'index'])
            ->name('sistem_proteksi_petir')
            ->middleware('RouteValidation');

        Route::post("/sistem_proteksi_petir/datatable", [SistemProteksiPetirController::class, 'datatable']);
        Route::post("/sistem_proteksi_petir/process", [SistemProteksiPetirController::class, 'process']);
        Route::post("/sistem_proteksi_petir/delete", [SistemProteksiPetirController::class, 'hapus']);
        Route::post("/sistem_proteksi_petir/get", [SistemProteksiPetirController::class, 'get_data']);

        //======================= END SISTEM PROTEKSI PETIR ======================

        //========================= PAGAR SELASAR ================================
        Route::get("/pagar_selasar", [PagarSelasarController::class, 'index'])
            ->name('pagar_selasar')
            ->middleware('RouteValidation');

        Route::post("/pagar_selasar/datatable", [PagarSelasarController::class, 'datatable']);
        Route::post("/pagar_selasar/process", [PagarSelasarController::class, 'process']);
        Route::post("/pagar_selasar/delete", [PagarSelasarController::class, 'hapus']);
        Route::post("/pagar_selasar/get", [PagarSelasarController::class, 'get_data']);

        //======================= END PAGAR SELASAR ==============================

        //========================= PENCAHAYAAN DAN VENTILASI ====================
        Route::get("/pencahayaan_dan_ventilasi", [PencahayaanDanVentilasiController::class, 'index'])
            ->name('pencahayaan_dan_ventilasi')
            ->middleware('RouteValidation');

        Route::post("/pencahayaan_dan_ventilasi/datatable", [PencahayaanDanVentilasiController::class, 'datatable']);
        Route::post("/pencahayaan_dan_ventilasi/process", [PencahayaanDanVentilasiController::class, 'process']);
        Route::post("/pencahayaan_dan_ventilasi/delete", [PencahayaanDanVentilasiController::class, 'hapus']);
        Route::post("/pencahayaan_dan_ventilasi/get", [PencahayaanDanVentilasiController::class, 'get_data']);

        //======================= END PENCAHAYAAN DAN VENTILASI ==================

        //========================= KENDARAAN PUSKESMAS ==========================
        Route::get("/kendaraan_puskesmas", [KendaraanPuskesmasController::class, 'index'])
            ->name('kendaraan_puskesmas')
            ->middleware('RouteValidation');

        Route::post("/kendaraan_puskesmas/datatable", [KendaraanPuskesmasController::class, 'datatable']);
        Route::post("/kendaraan_puskesmas/process", [KendaraanPuskesmasController::class, 'process']);
        Route::post("/kendaraan_puskesmas/delete", [KendaraanPuskesmasController::class, 'hapus']);
        Route::post("/kendaraan_puskesmas/get", [KendaraanPuskesmasController::class, 'get_data']);

        //======================= END KENDARAAN PUSKESMAS ========================

        //========================= MOBIL PUSLING ===============================

        Route::get("/mobil_pusling", [MobilPuslingController::class, 'index'])
            ->name('mobil_pusling')
            ->middleware('RouteValidation');

        Route::post("/mobil_pusling/datatable", [MobilPuslingController::class, 'datatable']);
        Route::post("/mobil_pusling/process", [MobilPuslingController::class, 'process']);
        Route::post("/mobil_pusling/delete", [MobilPuslingController::class, 'hapus']);
        Route::post("/mobil_pusling/get", [MobilPuslingController::class, 'get_data']);

        //======================= END MOBIL PUSLING ==============================
});


