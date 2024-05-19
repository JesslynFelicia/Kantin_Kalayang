<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ControllerKalayang;


//Menu Kalayang CRUD
Route::post('/viewmenu',[ControllerKalayang::class,'viewmenu']);
Route::post('/savemenu',[ControllerKalayang::class,'makemenu']);
Route::post('/updatemenu',[ControllerKalayang::class,'updatemenu']);
Route::post('/deletemenu',[ControllerKalayang::class,'deletemenu']);
Route::post('/viewonemenu',[ControllerKalayang::class,'viewonemenu']);
Route::post('/viewmenupenjual',[ControllerKalayang::class,'viewmenuonepenjual']);

//Transaksi Kalayang CRUD
Route::post('/viewtransaksi',[ControllerKalayang::class,'viewtransaksi']);
Route::post('/savetransaksi',[ControllerKalayang::class,'savetransaksi']);
Route::post('/viewrekap',[ControllerKalayang::class,'viewrekap']);
Route::post('/detailrekap',[ControllerKalayang::class,'detailrekap']);

//Akun Penjual Kalayang CRUD
Route::post('/savedata',[ControllerKalayang::class,'savedatapenjual']);
Route::post('/generatepassword',[ControllerKalayang::class,'generatepassword']);
Route::post('/newlogin',[ControllerKalayang::class,'loginnewuser']);
Route::post('/viewpenjual',[ControllerKalayang::class,'viewpenjual']);
Route::post('/accpenjual',[ControllerKalayang::class,'ApproveAdmin']);
Route::post('/viewtoko',[ControllerKalayang::class,'Viewpenjualall']);
Route::post('/viewprofile',[ControllerKalayang::class,'viewprofilepenjual']);
Route::post('/updatedatapenjual',[ControllerKalayang::class,'updatedatapenjual']);
Route::post('/showqris',[ControllerKalayang::class,'showqris']);


//Mail
Route::post('/user/mail/send', [ControllerKalayang::class, 'sendemail']);

// Han Vir
Route::post('/savedatanew',[ControllerKalayang::class,'savedatapenjual_new']);

//yang belom



