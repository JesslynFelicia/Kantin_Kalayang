<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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

//Akun Penjual Kalayang CRUD
Route::post('/savedata', [ControllerKalayang::class, 'savedatapenjual']);
Route::post('/generatepassword', [ControllerKalayang::class, 'generatepassword']);
Route::post('/newlogin', [ControllerKalayang::class, 'loginnewuser']);
Route::post('/viewpenjual', [ControllerKalayang::class, 'viewpenjual']);
Route::post('/accpenjual', [ControllerKalayang::class, 'ApproveAdmin']);
Route::post('/viewtoko', [ControllerKalayang::class, 'Viewpenjualall']);
Route::post('/viewprofile', [ControllerKalayang::class, 'viewprofilepenjual']);
Route::post('/updatedatapenjual', [ControllerKalayang::class, 'updatedatapenjual']);
Route::post('/showqris', [ControllerKalayang::class, 'showqris']);


//Mail
Route::post('/user/mail/send', [ControllerKalayang::class, 'sendemail']);

// Han Vir
Route::post('/savedatanew', [ControllerKalayang::class, 'savedatapenjual_new']);

//yang belom

// laras guest id

Route::post('/guesxts', function (Request $request) {
    $guestId = $request->input('guestId');

    return response()->json([
        'success' => true,
        'message' => 'Guest ID received successfully',
        'guestId' => $guestId
    ]);
});

Route::post('/guests', function (Request $request) {
    $guestId = $request->input('guestId');
    $id = $request->input('id');
    $name = $request->input('name');
    $price = $request->input('price');
    $qty = $request->input('qty');
    $note = $request->input('note');
    $total = $request->input('total');

    // Anda dapat melakukan apa pun yang Anda inginkan dengan data yang diterima dari permintaan di sini

    // Kemudian, Anda dapat mengirimkan data tersebut sebagai respons JSON
    return response()->json([
        'success' => true,
        'guestId' => $guestId,
        // 'id' => $id,
        // 'name' => $name,
        'price' => $price,
        'qty' => $qty,
        'note' => $note,
        // 'total' => $total,
    ]);
});
