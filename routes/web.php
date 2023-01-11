<?php

use App\Http\Controllers\PresentController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\LeaveApplicationController;
use App\Http\Controllers\UserController;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => true,
]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['web', 'auth', 'verified']], function(){
    
    Route::get('/ganti-password', [UserController::class,'gantiPassword'])->name('ganti-password');
    Route::get('/profil', [UserController::class, 'profil'])->name('profil');
    Route::patch('/update-profil/{user}', [UserController::class, 'updateProfil'])->name('update-profil');
    Route::patch('/update-password/{user}', [UserController::class, 'updatePassword'])->name('update-password');

    Route::get('/pengajuan/create', [LeaveApplicationController::class, 'create'])->name('submission.create');
    Route::get('/pengajuan/histori', [LeaveApplicationController::class, 'list'])->name('submission.list');
    Route::get('/pengajuan/histori/detail/{id}', [LeaveApplicationController::class, 'detail'])->name('submission.detail');
    Route::post('/pengajuan/store', [LeaveApplicationController::class, 'store'])->name('submission.store');
    Route::get('/pengajuan/cari-histori', [LeaveApplicationController::class, 'searchHistory'])->name('submission.searchHistory');
    
    Route::group(['middleware' => ['role:admin']], function(){
        Route::get('/users/cari', [UserController::class, 'search'])->name('users.search');
        Route::patch('/users/password/{user}', [UserController::class, 'password'])->name('users.password');
        Route::resource('users', UserController::class);
        
        Route::get('/kehadiran', [PresentController::class, 'index'])->name('kehadiran.index');
        Route::get('/kehadiran/cari', [PresentController::class, 'search'])->name('kehadiran.search');
        Route::get('/kehadiran/{user}/cari', [PresentController::class, 'cari'])->name('kehadiran.cari');
        Route::post('/kehadiran', [PresentController::class, 'store'])->name('kehadiran.store');
        Route::patch('/kehadiran/{kehadiran}', [PresentController::class, 'update'])->name('kehadiran.update');
        Route::post('/kehadiran/ubah', [PresentController::class, 'ubah'])->name('ajax.get.kehadiran');
        
        Route::get('/pengajuan', [LeaveApplicationController::class, 'index'])->name('submission.index');
        Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
        Route::patch('/setting', [SettingController::class, 'update'])->name('setting.update');
        
        Route::get('/pengajuan/show/{submission}', [LeaveApplicationController::class, 'show'])->name('submission.show');
        Route::post('/pengajuan/edit', [LeaveApplicationController::class, 'edit'])->name('submission.edit');
        Route::patch('/pengajuan/update/{submission}', [LeaveApplicationController::class, 'update'])->name('submission.update');
        Route::delete('/pengajuan/destroy/{submission}', [LeaveApplicationController::class, 'destroy'])->name('submission.destroy');
        Route::get('/pengajuan/cari', [LeaveApplicationController::class, 'search'])->name('submission.search');
    });

    Route::group(['roles' => 'Pegawai'], function(){
        Route::get('/daftar-hadir', [PresentController::class, 'show'])->name('daftar-hadir');
        Route::get('/daftar-hadir/cari', [PresentController::class,'cariDaftarHadir'])->name('daftar-hadir.cari');
    });
    
    Route::post('/absen', [PresentController::class, 'checkIn'])->name('kehadiran.check-in');
    Route::patch('/absen/{kehadiran}', [PresentController::class, 'checkOut'])->name('kehadiran.check-out');
});
