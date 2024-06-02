<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\ControllerKalayang;


//Menu Kalayang CRUD
Route::post('/viewmenu', [ControllerKalayang::class, 'viewmenu']);
Route::post('/savemenu', [ControllerKalayang::class, 'makemenu']);
Route::post('/updatemenu', [ControllerKalayang::class, 'updatemenu']);
Route::post('/deletemenu', [ControllerKalayang::class, 'deletemenu']);
Route::post('/viewonemenu', [ControllerKalayang::class, 'viewonemenu']);
Route::post('/viewmenupenjual', [ControllerKalayang::class, 'viewmenuonepenjual']);
Route::post('/tambah', [ControllerKalayang::class, 'tambahsatu']);

//Transaksi Kalayang CRUD
Route::post('/viewtransaksi', [ControllerKalayang::class, 'viewtransaksi']);
Route::post('/savetransaksi', [ControllerKalayang::class, 'savetransaksi']);
Route::post('/viewrekap', [ControllerKalayang::class, 'viewrekap']);
Route::post('/detailrekap', [ControllerKalayang::class, 'detailrekap']);
Route::post('/status_pesanan', [ControllerKalayang::class, 'status_pesanan']);
Route::post('/riwayatpenjual', [ControllerKalayang::class, 'riwayatpenjual']);

//Akun Penjual Kalayang CRUD
Route::post('/generatepassword', [ControllerKalayang::class, 'generatepassword']);
Route::post('/newlogin', [ControllerKalayang::class, 'loginnewuser']);
Route::post('/viewpenjual', [ControllerKalayang::class, 'viewpenjual']);
Route::post('/viewtoko', [ControllerKalayang::class, 'Viewpenjualall']);
Route::post('/viewprofile', [ControllerKalayang::class, 'viewprofilepenjual']);
Route::post('/updatedatapenjual', [ControllerKalayang::class, 'updatedatapenjual']);
Route::post('/showqris', [ControllerKalayang::class, 'showqris']);
Route::post('/viewonepenjual', [ControllerKalayang::class, 'viewonepenjual']);
Route::post('/guests', [ControllerKalayang::class, 'savetempkeranjang']);
Route::post('/ringkasanpesanan', [ControllerKalayang::class, 'ringkasanpesanan']);
Route::post('/keranjang', [ControllerKalayang::class, 'keranjang']);
Route::post('/forgot_password', [ControllerKalayang::class, 'forgot_password']);


//Mail
// Route::post('/user/mail/send', [ControllerKalayang::class, 'sendemail']);

Route::post('/savedatanew', [ControllerKalayang::class, 'savedatapenjual_new']);
Route::post('/deletepesanan', [ControllerKalayang::class, 'deletepesanan']);
