<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ModelKalayangMenu;
use App\Models\ModelKalayangTransaksi;
use App\Models\ModelKalayangPenjual;
use App\Models\ModelKalayangTransaksiTemp;
use App\Models\ModelKalayangAdmin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmailNew;
use App\Models\ModelKalayangGambar;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
class ControllerKalayang extends Controller
{

    //Controller Menu CRUD
    public function makemenu(Request $request)
    {
        $id_penjual = $request->post('id_penjual');
        $jenis = $request->post('jenis');
        $nama_menu = $request->post('nama_menu');
        $harga_menu = $request->post('harga_menu');
        $ekstra = $request->post('ekstra');
        $status_menu = $request->post('status_menu');
        $desc_menu = $request->post('desc_menu');

        if ($nama_menu) {
            if ($harga_menu) {
                if ($jenis) {
                    $savemenu = new ModelKalayangMenu();
                    $savemenu->id_penjual = $id_penjual;
                    $savemenu->jenis = $jenis;
                    $savemenu->nama_menu = $nama_menu;
                    $savemenu->harga_menu = $harga_menu;
                    $savemenu->ekstra = $ekstra;
                    $savemenu->status_menu = $status_menu;
                    $savemenu->desc_menu = $desc_menu;
                    $savemenu->save();
                    if ($savemenu) {
                        $msg = "Data berhasil di simpan";
                        $sts = true;
                    } else {
                        $msg = "Data gagal di simpan";
                        $sts = false;
                    }
                } else {
                    $msg = "Jenis menu tidak boleh kosong!";
                    $sts = false;
                }
            } else {
                $msg = "Harga menu tidak boleh kosong!";
                $sts = false;
            }
        } else {
            $msg = "Nama menu tidak boleh kosong!";
            $sts = false;
        }

        return response()->json(['message' => $msg, 'status' => $sts], 200);
    }

    public function viewmenu(Request $request)
    {
        $allmenu = ModelKalayangMenu::all();
        return response()->json(['message' => 'success', 'data' => $allmenu], 200);
    }


    public function viewmenuonepenjual(Request $request)
    {
        $id_penjual = $request->post('id_penjual');

        if (empty($id_penjual)) {
            return response()->json(['message' => 'failed'], 404);
        } else {
            $menu = ModelKalayangMenu::where('id_penjual', $id_penjual)->get();
            return response()->json(['message' => 'success', 'data' => $menu], 200);
        }
    }

    public function updatemenu(Request $request)
    {

        $id_menu = $request->post('id_menu');
        $jenis = $request->post('jenis');
        $nama_menu = $request->post('nama_menu');
        $harga_menu = $request->post('harga_menu');
        $status_menu = $request->post('status_menu');
        $desc_menu = $request->post('desc_menu');

        $savemenu = ModelKalayangMenu::find($id_menu);
        if ($savemenu) {
            $savemenu->jenis = $jenis;
            $savemenu->nama_menu = $nama_menu;
            $savemenu->harga_menu = $harga_menu;
            $savemenu->status_menu = $status_menu;
            $savemenu->desc_menu = $desc_menu;
            $savemenu->save();

            return response()->json(['message' => "Menu Update Successfully"], 200);
        } else {
            return response()->json(['message' => "Menu not found"], 404);
        }
    }

    public function deletemenu(Request $request)
    {
        $id_menu = $request->post('id_menu');
        $savemenu = ModelKalayangMenu::find($id_menu);
        if ($savemenu) {
            $savemenu->delete();

            return response()->json(['message' => "Menu Delete Successfully"], 200);
        } else {
            return response()->json(['message' => "Menu not found"], 404);
        }
    }

    public function deletepesanan(Request $request)
    {
        $guestId = $request->input('guest_id');
        $id_menu = $request->input('id_menu');
        $pesanan = ModelKalayangTransaksiTemp::where('guest_id', $guestId)->where('id_menu', $id_menu)->delete();
        if ($pesanan) {
            return response()->json(['message' => "berhasil"], 200);
        }
        return response()->json(['message' => "data tidak di temukan"], 404);
    }

    public function viewonemenu(Request $request)
    {
        $id_menu = $request->post('id_menu');
        $menu = ModelKalayangMenu::find($id_menu);

        if (!$menu) {
            return response()->json(['message' => 'Data Not Found'], 404);
        } else {
            return response()->json(['message' => 'success', 'data' => $menu], 200);
        }
    }

    public function tambahsatu(Request $request)
    {
        $id_menu = $request->post('id_menu');
        $id_penjual = $request->post('id_penjual');
        $menu = ModelKalayangMenu::where('id_menu', $id_menu)
            ->where('id_penjual', $id_penjual)
            ->get();


        if (!$menu) {
            return response()->json(['message' => 'Data Not Found'], 404);
        } else {
            return response()->json(['message' => 'success', 'data' => $menu], 200);
        }
    }

    //Controller Transaksi
    public function savetempkeranjang(Request $request)
    {
        $guestId = $request->post('guestId');
        $id_penjual = $request->post('id_penjual');
        $id_menu =  $request->post('id_menu');
        $number = $id_menu[0];
        $note =  $request->post('note');

        $delete_penjual = ModelKalayangTransaksiTemp::where('guest_id', $guestId)
            ->get();

        $id_penjual_array = $delete_penjual->pluck('id_penjual')->toArray();
        if (!empty($id_penjual_array)) {
            $id_penjual_implode = $id_penjual_array[0];
            if ($id_penjual !=  $id_penjual_implode) {

                $delete_penjual = ModelKalayangTransaksiTemp::where('guest_id', $guestId)
                    ->delete();
            }
        }

        $data = ModelKalayangTransaksiTemp::where('id_menu', $number)
            ->where('guest_id', $guestId)
            ->where('id_penjual', $id_penjual)
            ->delete();

        foreach ($id_menu as $menu_id) {
            ModelKalayangTransaksiTemp::create([
                'guest_id' => $guestId,
                'id_penjual' => $id_penjual,
                'id_menu' => $menu_id,
                'note' => $note,
            ]);
        }
    }

    public function ringkasanpesanan(Request $request)
    {
        $guestId = $request->post('guestId');

        $dataWithCounts = ModelKalayangTransaksiTemp::select('id_menu', 'id_penjual', DB::raw('COUNT(id_menu) as count'))
            ->where('guest_id', $guestId)
            ->groupBy('id_menu', 'id_penjual')
            ->get();


        $idMenus = $dataWithCounts->pluck('id_menu');
        $idPenjuals = $dataWithCounts->pluck('id_penjual');
        $totalIds = [];

        foreach ($dataWithCounts as $item) {
            $totalIds[$item->id_menu] = $item->count;
        }
        $totalIdSum = array_sum($totalIds);

        $totalIds = [];
        foreach ($dataWithCounts as $item) {
            $totalIds[$item->id_menu] = $item->count;
        }

        $dataFromOtherTable = ModelKalayangMenu::whereIn('id_menu', $idMenus->toArray())->get();


        $dataFromOtherTable1 = ModelKalayangPenjual::whereIn('id_penjual', $idPenjuals->toArray())->get();

        $namaTokos = [];
        foreach ($dataFromOtherTable1  as $penjual) {
            $namaTokos[$penjual->id_penjual] = $penjual->nama_toko;
        }


        $namaToko = reset($namaTokos);


        $totalPriceSum = 0;
        foreach ($dataFromOtherTable as $item) {
            $count = $totalIds[$item->id_menu] ?? 0;
            $item->count = $count;
            $item->total_price = $item->harga_menu * $count;
            $totalPriceSum += $item->total_price;
        }

        return response()->json([
            'data' => $dataFromOtherTable,
            'total_price_sum' => $totalPriceSum,
            'total_id_menu' => $totalIdSum,
            'nama_tokos' => $namaToko,
        ], 200);
    }

    public function viewtransaksi(Request $request)
    {
        $id_penjual = $request->post('id_penjual');
        $alltransaksi = ModelKalayangTransaksi::select(
            'tb_transaksi.id_menu',
            DB::raw('MAX(tb_transaksi.id_order) AS id_order'),
            DB::raw("DATE_FORMAT(MAX(tb_transaksi.tanggal_pemesanan), '%d/%m/%Y %h:%s') AS formatted_tanggal_pemesanan"),
            DB::raw('MAX(tb_transaksi.nomor_meja) AS nomor_meja'),
            DB::raw('MAX(tb_transaksi.status_pesanan) AS status_pesanan'),
            DB::raw('MAX(tb_transaksi.catatan_pemesan) AS catatan_pemesan'),
            DB::raw('MAX(tb_transaksi.created_at) AS created_at'),
            DB::raw('MAX(tb_transaksi.updated_at) AS updated_at'),
            DB::raw('MAX(tb_menu.nama_menu) AS nama_menu'),
            DB::raw("CONCAT( COUNT(tb_transaksi.id_menu)) AS Jumlah_pesan"),
            'tb_transaksi.id_penjual',
            DB::raw('SUM(tb_menu.harga_menu) AS harga_menu'),
        )
            ->join('tb_menu', 'tb_menu.id_menu', '=', 'tb_transaksi.id_menu')
            ->where('tb_transaksi.id_penjual', $id_penjual)
            ->whereNotIn('tb_transaksi.status_pesanan', ['SELESAI'])
            ->groupBy('tb_transaksi.id_menu', 'tb_transaksi.id_penjual')
            ->get();

        return response()->json(['message' => 'success', 'data' => $alltransaksi], 200);
    }



    public function savetransaksi(Request $request)
    {

        $guestId = $request->post('guest_id');
        $nomor_meja = $request->post('nomor_meja');
        $status_pesanan = "CHECK";
        $pesanan = $request->post('Pesanan');
        $status_pembayaran = $request->post('status_pembayaran');

        if ($status_pembayaran == "Belum dibayar") {
            $transaksiList = ModelKalayangTransaksiTemp::where('guest_id', $guestId)->get();
            if ($transaksiList->isNotEmpty()) {
                ModelKalayangTransaksiTemp::where('guest_id', $guestId)->update(['nomor_meja' => $nomor_meja, 'pesanan' => $pesanan]);
                return response()->json(['message' => 'Data berhasil di simpan', 'sts' => true], 200);
            } else {
                return response()->json(['message' => 'Data gagal di simpan', 'sts' => false], 404);
            }
        }
        if ($status_pembayaran == "Sudah dibayar") {
            $transaksiList = ModelKalayangTransaksiTemp::where('guest_id', $guestId)->get();
            if ($transaksiList->isNotEmpty()) {
                $id_order = $this->generateUniqueNumber();
                foreach ($transaksiList as $transaksi) {
                    $transaction = new ModelKalayangTransaksi();
                    $transaction->id_menu = $transaksi->id_menu;
                    $transaction->id_penjual = $transaksi->id_penjual;
                    $transaction->id_order = $id_order;
                    $transaction->guest_id  = $guestId;
                    $transaction->nomor_meja =  $transaksi->nomor_meja;
                    $transaction->status_pesanan = $status_pesanan;
                    $transaction->pesanan = $transaksi->pesanan;
                    $transaction->catatan_pemesan = $transaksi->note;
                    $transaction->save();
                }

                if ($transaction) {
                    $msg = "Data berhasil di simpan";
                    $sts = true;
                    $code = 200;
                    ModelKalayangTransaksiTemp::where('guest_id', $guestId)->delete();
                } else {
                    $msg = "Data gagal di simpan";
                    $sts = false;
                    $code = 404;
                }
            } else {
                $msg = "Data kosong";
                $sts = false;
                $code = 404;
            }
            return response()->json(['message' => $msg, 'sts' => $sts], $code);
        }
    }

    public function viewrekap(Request $request)
    {
        $id_penjual = $request->post('id_penjual');
        $alltransaksi = ModelKalayangTransaksi::select(
            DB::raw("DATE_FORMAT(DATE(tb_transaksi.tanggal_pemesanan), '%d/%m/%Y %h:%i') AS formatted_tanggal_pemesanan"),
            DB::raw('MAX(tb_transaksi.id_order) AS id_order'),
            DB::raw('MAX(tb_transaksi.nomor_meja) AS nomor_meja'),
            DB::raw('MAX(tb_transaksi.status_pesanan) AS status_pesanan'),
            DB::raw('MAX(tb_transaksi.catatan_pemesan) AS catatan_pemesan'),
            DB::raw('MAX(tb_transaksi.ekstra_menu) AS ekstra_menu'),
            DB::raw('MAX(tb_transaksi.created_at) AS created_at'),
            DB::raw('MAX(tb_transaksi.updated_at) AS updated_at'),
            DB::raw('COUNT(tb_transaksi.id_penjual) AS Jumlah_pesan'),
            'tb_transaksi.id_penjual',
            DB::raw('SUM(tb_menu.harga_menu) AS harga_menu')
        )
            ->join('tb_menu', 'tb_menu.id_menu', '=', 'tb_transaksi.id_menu')
            ->where('tb_transaksi.id_penjual', $id_penjual)
            ->groupBy('formatted_tanggal_pemesanan', 'tb_transaksi.id_penjual')
            ->get();

        return response()->json(['message' => 'success', 'data' => $alltransaksi], 200);
    }

    public function detailrekap(Request $request)
    {
        $id_penjual = $request->post('id_penjual');
        $date = $request->post('date');
        $alltransaksi = ModelKalayangTransaksi::select(
            DB::raw("DATE_FORMAT(DATE(tb_transaksi.tanggal_pemesanan), '%d/%m/%Y %h:%i') AS formatted_tanggal_pemesanan"),
            DB::raw('MAX(tb_transaksi.id_order) AS id_order'),
            DB::raw('MAX(tb_transaksi.nomor_meja) AS nomor_meja'),
            DB::raw('MAX(tb_transaksi.status_pesanan) AS status_pesanan'),
            DB::raw('MAX(tb_transaksi.catatan_pemesan) AS catatan_pemesan'),
            DB::raw('MAX(tb_transaksi.ekstra_menu) AS ekstra_menu'),
            DB::raw('MAX(tb_transaksi.created_at) AS created_at'),
            DB::raw('MAX(tb_transaksi.updated_at) AS updated_at'),
            DB::raw('COUNT(tb_transaksi.id_penjual) AS Jumlah_pesan'),
            'tb_transaksi.id_penjual',
            DB::raw('SUM(tb_menu.harga_menu) AS harga_menu'),
            DB::raw('MAX(tb_menu.nama_menu) AS nama_menu'),
            DB::raw('COUNT(tb_menu.id_menu) AS Jumlah')
        )
            ->join('tb_menu', 'tb_menu.id_menu', '=', 'tb_transaksi.id_menu')
            ->where('tb_transaksi.id_penjual', $id_penjual)
            ->wheredate('tb_transaksi.tanggal_pemesanan', $date)
            ->groupBy('formatted_tanggal_pemesanan', 'tb_transaksi.id_penjual')
            ->get();

        return response()->json(['message' => 'success', 'data' => $alltransaksi], 200);


        return response()->json(['message' => 'success', 'data' => $alltransaksi], 200);


        $detailtransaksi = ModelKalayangTransaksi::select(
            DB::raw("DATE_FORMAT(DATE(tb_transaksi.tanggal_pemesanan), '%d/%m/%Y %h:%i') AS formatted_tanggal_pemesanan"),
            'tb_transaksi.id_penjual',
            DB::raw('SUM(tb_menu.harga_menu) AS harga_menu'),
            DB::raw('MAX(tb_menu.nama_menu) AS nama_menu'),
            DB::raw('COUNT(tb_menu.id_menu) AS Jumlah')
        )
            ->join('tb_menu', 'tb_menu.id_menu', '=', 'tb_transaksi.id_menu')
            ->where('tb_transaksi.id_penjual', $id_penjual)
            ->wheredate('tb_transaksi.tanggal_pemesanan', $date)
            ->groupBy('formatted_tanggal_pemesanan', 'tb_transaksi.id_penjual', 'tb_menu.id_menu')
            ->get();



        return response()->json(['message' => 'success', 'data' => $alltransaksi, 'detail' => $detailtransaksi], 200);
    }

    public function updatedatapenjual(Request $request)
    {
        $email = $request->post('email');
        $kata_sandi_lama = $request->post('password');
        $kata_sandi_baru = $request->post('kata_sandi');
        $nama_toko = $request->post('nama_toko');

        $penjual = ModelKalayangPenjual::where('email', $email)->first();

        if (!$penjual) {
            return response()->json(['error' => 'Data penjual tidak ditemukan.', 'status' => false], 404);
        }

        $status_akun = $penjual->status_acc;


        $rules = [
            'email' => 'required|email',
            'gambar_profile' => 'image|mimes:jpeg,png,jpg,gif'
        ];

        if ($status_akun !== 'True') {
            $rules['kata_sandi'] = 'min:6';
            $rules['qris'] ='required|image|mimes:jpeg,png,jpg,gif';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 400);
        }

        if ($status_akun !== 'True') {
            $penjual->kata_sandi = Hash::make($kata_sandi_baru);
            $penjual->status_acc = 'True';
        } elseif ($kata_sandi_baru) {
            if (empty($kata_sandi_baru) || !Hash::check($kata_sandi_lama, $penjual->kata_sandi)) {
                return response()->json(['message' => 'Kata sandi lama salah atau kata sandi baru kosong'], 401);
            }
            $penjual->kata_sandi = Hash::make($kata_sandi_baru);
        }

        $penjual->nama_toko = $nama_toko;
        $penjual->save();

        $id_penjual = $penjual->id_penjual;
        $this->updateOrInsertImage($request->file('qris'), $id_penjual, 'QRIS');
        $this->updateOrInsertImage($request->file('gambar_profile'), $id_penjual, 'PROFILE');

        return response()->json(['message' => 'Data penjual berhasil diperbarui', 'status' => true], 200);
    }

    private function updateOrInsertImage($file, $id_penjual, $jenis_gambar)
    {
        if ($file && $file->isValid()) {
            $check_image = ModelKalayangGambar::where('id_penjual', $id_penjual)->where('gambar', $jenis_gambar)->first();
            $data_image = file_get_contents($file->getRealPath());
            $properties_image = getimagesize($file->getRealPath());

            if ($check_image) {
                $check_image->format_gambar = $properties_image['mime'];
                $check_image->data_image = $data_image;
                $check_image->save();
            } else {
                $new_image = new ModelKalayangGambar();
                $new_image->id_penjual = $id_penjual;
                $new_image->format_gambar = $properties_image['mime'];
                $new_image->data_image = $data_image;
                $new_image->gambar = $jenis_gambar;
                $new_image->save();
            }
        }
    }


    public function generatepassword(Request $request)
    {
        $email = $request->post('email');
        $penjual = ModelKalayangPenjual::where('email', 'like', $email . '%')->first();
        if ($penjual) {
            $idPenjual = $penjual->id_penjual;
            $UpdatePenjual = ModelKalayangPenjual::find($idPenjual);
            $password = Str::password(16, true, true, false, false);
            if ($UpdatePenjual) {
                $UpdatePenjual->kata_sandi = $password;
                $UpdatePenjual->save();
                return response()->json(['message' => "Update berhasil", 'status' => true], 200);
            } else {
                return response()->json(['message' => "Update penjual gagal", 'status' => false], 500);
            }
        } else {
            return  response()->json(['message' => "gagal mencari id", 'status' => false], 404);
        }
    }

    public function loginnewuser(Request $request)
    {
        $email = $request->post('email');
        $kata_sandi = $request->post('kata_sandi');
        $penjual = ModelKalayangPenjual::where('email', $email)->first();


        if (!$penjual) {
            $admin = ModelKalayangAdmin::where('username', $request->email)->first();
            if ($admin && Hash::check($kata_sandi, $admin->password)) {
                $role = $admin->role;
                return response()->json(['message' => "Berhasil login", 'status' => true, 'role' => $role], 200);
            } else {
                return response()->json(['message' => "Akun tidak ditemukan", 'status' => false], 404);
            }
        }

        $emaildatabase = $penjual->email;
        $password = $penjual->kata_sandi;

        $status = $penjual->status_acc;
        if ($status == 'False') {
            if ($email != $emaildatabase || $kata_sandi != $password) {
                return response()->json(['message' => "Email atau Password salah", 'status' => false], 404);
            }
            return response()->json(['message' => "Berhasil login", 'status' => true, 'status_akun' => $status], 200);
        }
        if ($status == 'True') {
            if ($email == $emaildatabase && Hash::check($kata_sandi, $penjual->kata_sandi)) {
                return response()->json(['message' => "Berhasil login", 'status' => true, 'status_akun' => $status], 200);
            }
            return response()->json(['message' => "Email atau Password salah", 'status' => false], 404);
        }
    }

    public function viewonepenjual(Request $request)
    {
        $email = $request->post('email');
        $penjual = ModelKalayangPenjual::where('email', 'like', $email . '%')->first();
        return response()->json(['message' => 'success', 'data' => $penjual], 200);
    }

    public function viewpenjual()
    {
        $allpenjual = ModelKalayangPenjual::all();
        return response()->json(['message' => 'success', 'data' => $allpenjual], 200);
    }

    public function Viewpenjualall()
    {
        $allpenjual = ModelKalayangPenjual::all();
        return response()->json(['message' => 'success', 'data' => $allpenjual], 200);
    }

    public function viewprofilepenjual(Request $request)
    {
        $email = $request->post('email');
        $allpenjual = ModelKalayangPenjual::where('email', $email)->get();
        return response()->json(['message' => 'success', 'data' => $allpenjual], 200);
    }

    public function riwayatpenjual(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $id_penjual = $request->input('id_penjual');
        $penjual = ModelKalayangTransaksi::select(
            'tb_transaksi.id_menu',
            DB::raw('MAX(tb_transaksi.id_order) AS id_order'),
            DB::raw("DATE_FORMAT(MAX(tb_transaksi.tanggal_pemesanan), '%d/%m/%Y %h:%s') AS formatted_tanggal_pemesanan"),
            DB::raw('MAX(tb_transaksi.nomor_meja) AS nomor_meja'),
            DB::raw('MAX(tb_transaksi.status_pesanan) AS status_pesanan'),
            DB::raw('MAX(tb_transaksi.catatan_pemesan) AS catatan_pemesan'),
            // DB::raw('MAX(tb_transaksi.ekstra_menu) AS ekstra_menu'),
            DB::raw('MAX(tb_transaksi.created_at) AS created_at'),
            DB::raw('MAX(tb_transaksi.updated_at) AS updated_at'),
            DB::raw("CONCAT('x', COUNT(tb_transaksi.id_menu)) AS Jumlah_pesan"),
            'tb_transaksi.id_penjual',
            DB::raw('SUM(tb_menu.harga_menu) AS harga_menu'),
            'tb_menu.nama_menu'
        )
            ->join('tb_menu', 'tb_menu.id_menu', '=', 'tb_transaksi.id_menu')
            ->where('tb_transaksi.id_penjual', $id_penjual)

            // ->where('tb_transaksi.status_pesanan', ['SELESAI'])
            ->groupBy('tb_transaksi.id_menu', 'tb_transaksi.id_penjual', 'tb_transaksi.id_order', 'tb_menu.nama_menu')
            ->paginate($perPage);
        // $penjual = ModelKalayangTransaksi::where('id_penjual', $id_penjual)->paginate($perPage);

        return response()->json($penjual);
    }

    public function showqris(Request $request)
    {

        $id_penjual = $request->input('id_penjual');
        $qris = strtoupper($request->input('qris'));
        $gambar = ModelKalayangGambar::where('id_penjual', $id_penjual)->where('gambar', $qris)->first();

        if (!$gambar) {
            return response()->json(['error' => 'Image not found'], 404);
        }

        // Mengembalikan respons gambar dengan data gambar, nama file, dan Content-Type yang sesuai
        return response($gambar->data_image)
            ->header('Content-Disposition', 'attachment; filename="' . $gambar->gambar . '"')
            ->header('Content-Type', $gambar->format_gambar);
    }

    public function status_pesanan(Request $request)
    {
        $guestId = $request->post('guestId');
        $tombol_pesanan = strtoupper($request->post('status'));
        $id_order = $request->post('id_order');

        // Pastikan nilai $guestId dan $nomor_transaksi tidak nul
        if($guestId && empty($id_order) && empty($tombol_pesanan)) {
            $transaksi = ModelKalayangTransaksi::where('guest_id', $guestId)->get();
            if ($transaksi->isEmpty()) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }
            return response()->json(['message' => $transaksi], 200);
        }
        if(empty($guestId) && $id_order && $tombol_pesanan) {

        $transaksi1 = ModelKalayangTransaksi::where('id_order', $id_order)->get();

        foreach ($transaksi1 as $item) {
            $item->status_pesanan = $tombol_pesanan;
            $item->save();
        }
        return response()->json(['message' => 'Transaksi berhasil diupdate'], 200);
    }
    }

    public function forgot_password(Request $request)
    {
        $email = $request->post('email');
        $penjual = ModelKalayangPenjual::where('email', $email)->first();
        $kata_sandi_random = Str::password(16, true, true, false, false);
        $status = 'False';
        if ($penjual) {
            // Update atribut model dengan nilai baru
            $penjual->kata_sandi = $kata_sandi_random;
            $penjual->status_acc = $status;

            // Simpan perubahan
            $penjual->save();
        }

        if ($penjual) {
            $msg = "password berhasil di reset";
            $sts = true;
            $this->sendemail_forgotpass($email);
        } else {
            $msg = "Data gagal di simpan";
            $sts = false;
        }
        return response()->json(['message' => $msg, 'status' => $sts], 200);
    }

    public function savedatapenjual_new(Request $request)
    {
        $nama_pemilik_toko = $request->post('nama_pemilik_toko');
        $nama_toko = $request->post('nama_toko');
        $nomor_telepon = $request->post('nomor_telepon');
        $nomor_toko = $request->post('nomor_toko');
        $email = $request->post('email');
        $kata_sandi_random = Str::password(16, true, true, false, false);
        $existingEmail = ModelKalayangPenjual::where('email', $email)->first();
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $msg = "Format email tidak valid";
            $sts = false;
            return response()->json(['message' => $msg, 'status' => $sts, 'email' => $email], 404);
        } else {
            if ($existingEmail) {
                $msg = "Email sudah terdaftar";
                $sts = false;
                return response()->json(['message' => $msg, 'status' => $sts], 404);
            } else {
                if ($nama_pemilik_toko) {
                    if ($nama_toko) {
                        if ($nomor_telepon) {
                            if ($nomor_toko) {
                                if ($email) {
                                    $savedata = new ModelKalayangPenjual();
                                    $savedata->nama_pemilik = $nama_pemilik_toko;
                                    $savedata->nama_toko = $nama_toko;
                                    $savedata->nomor_telepon = $nomor_telepon;
                                    $savedata->nomor_toko = $nomor_toko;
                                    $savedata->email = $email;
                                    $savedata->kata_sandi = $kata_sandi_random;
                                    $savedata->save();

                                    if ($savedata) {
                                        $msg = "Data berhasil di simpan";
                                        $sts = true;
                                        $this->sendemail_new($email);
                                    } else {
                                        $msg = "Data gagal di simpan";
                                        $sts = false;
                                    }
                                } else {
                                    $sts = false;
                                    $msg = "Email tidak boleh kosong";
                                }
                            } else {
                                $sts = false;
                                $msg = "Nomor toko tidak boleh kosong";
                            }
                        } else {
                            $sts = false;
                            $msg = "Nomor telepon tidak boleh kosong";
                        }
                    } else {
                        $sts = false;
                        $msg = "Nama toko tidak boleh kosong";
                    }
                } else {
                    $sts = false;
                    $msg = "Nama pemilik toko tidak boleh kosong";
                }
                return response()->json(['message' => $msg, 'status' => $sts], 200);
            }
        }
    }


    public function cekpesanan(Request $request)
    {
        $guestId = $request->input('guest_id');
        $id_menu = $request->input('id_menu');

        $pesanan = ModelKalayangTransaksiTemp::select('id_menu', DB::raw('COUNT(id_menu) as count'))
            ->where('guest_id', $guestId)
            ->where('id_menu', $id_menu)
            ->groupBy('id_menu', 'id_penjual')
            ->get();

        if (($pesanan)->IsEmpty()) {
            return response()->json(['data' =>'0'], 404);
        }

        return response()->json(['data' =>  $pesanan], 200);
    }

    public function sendemail_new($email)
    {
        $penjual = ModelKalayangPenjual::where('email', 'like', $email . '%')->first();
        if ($email) {
            if ($penjual) {
                $content = '<!DOCTYPE html>
                <html>

                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <meta http-equiv="X-UA-Compatible" content="ie=edge">
                    <style>
                        body {
                            height: 750px;
                            margin: 2px;
                            padding: 2px;
                            font-family: Helvetica, Arial, sans-serif;
                        }

                        .button-container {
                            margin: 40px 0;
                        }

                        #box {
                            width: 850px;
                            margin: 0 auto;
                            height: 100%;
                        }

                        #header {
                            height: 200px;
                            width: 100%;
                            position: relative;
                            display: block;
                            border-bottom: 1px solid #504597;
                        }

                        .button {
                            background-color: #d60e0e;
                            border: none;
                            color: white !important;
                            padding: 10px 25px;
                            text-align: center;
                            text-decoration: none;
                            margin: auto;
                            font-size: 22px;
                            cursor: pointer;
                            border-radius: 10px;
                        }

                        #image {
                            width: 150px;
                            height: auto;
                            margin-top: 16px;
                        }

                        #rightbar {
                            width: 100%;
                            height: 560px;
                            padding: 0px;
                        }

                        .text-div {
                            font-size: 18px;
                            margin-bottom: 3px;
                        }

                        #footer {
                            clear: both;
                            height: 40px;
                            text-align: center;
                            background-color: #2d0f80;
                            margin: 0px;
                            padding: 0px;
                            color: white;
                        }

                        p,
                        pre {
                            font-size: 18px;
                            line-height: 1.4;
                        }

                        .heading {
                            color: #504597;
                            font-size: 24px;
                        }
                    </style>
                </head>

                <body>
                    <!-- mail body -->
                    <div id="box">
                        <div id="header">
                        </div>
                        <div class="spacing"></div>
                        <div id="rightbar">
                            <h1 class="heading"></h1>
                            <p>Hi, ' . $penjual['nama_pemilik'] . '</p>
                            <p>Terimakasih telah mendaftar di kantin kalayang</p>
                            <p>dengan email ini kami telah menyetujui seluruh berkas yang anda berikan</p>
                            <p>berikut kami berikan username dan password :</p>
                            <p>Email : ' . $penjual['email'] . '</p>
                            <p>Password : ' . $penjual['kata_sandi'] . '</p>
                            <p>Mohon setelah anda berhasil login dapat langsung mengganti password anda</p>
                            <div class="text-div">Terima kasih,</div>
                            <div class="text-div">Admin Kantin Kalayang</div>
                        </div>
                    </div>
                </body>

                </html>';
                $mailData = [
                    'to' => $penjual['email'],
                    'content' => $content,
                    'subject' => 'Your Registration is Accepted!!!',
                ];
                $send = Mail::to($mailData['to'])->send(new SendEmailNew($mailData));
            } else {
                return "error";
            }
            return true;
        } else {
            return false;
        }
    }

    public function sendemail_forgotpass($email)
    {
        $penjual = ModelKalayangPenjual::where('email', 'like', $email . '%')->first();
        if ($email) {
            if ($penjual) {
                $content = '<!DOCTYPE html>
                <html>

                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <meta http-equiv="X-UA-Compatible" content="ie=edge">
                    <style>
                        body {
                            height: 750px;
                            margin: 2px;
                            padding: 2px;
                            font-family: Helvetica, Arial, sans-serif;
                        }

                        .button-container {
                            margin: 40px 0;
                        }

                        #box {
                            width: 850px;
                            margin: 0 auto;
                            height: 100%;
                        }

                        #header {
                            height: 200px;
                            width: 100%;
                            position: relative;
                            display: block;
                            border-bottom: 1px solid #504597;
                        }

                        .button {
                            background-color: #d60e0e;
                            border: none;
                            color: white !important;
                            padding: 10px 25px;
                            text-align: center;
                            text-decoration: none;
                            margin: auto;
                            font-size: 22px;
                            cursor: pointer;
                            border-radius: 10px;
                        }

                        #image {
                            width: 150px;
                            height: auto;
                            margin-top: 16px;
                        }

                        #rightbar {
                            width: 100%;
                            height: 560px;
                            padding: 0px;
                        }

                        .text-div {
                            font-size: 18px;
                            margin-bottom: 3px;
                        }

                        #footer {
                            clear: both;
                            height: 40px;
                            text-align: center;
                            background-color: #2d0f80;
                            margin: 0px;
                            padding: 0px;
                            color: white;
                        }

                        p,
                        pre {
                            font-size: 18px;
                            line-height: 1.4;
                        }

                        .heading {
                            color: #504597;
                            font-size: 24px;
                        }
                    </style>
                </head>

                <body>
                    <!-- mail body -->
                    <div id="box">
                        <div id="header">
                        </div>
                        <div class="spacing"></div>
                        <div id="rightbar">
                            <h1 class="heading"></h1>
                            <p>Hi, ' . $penjual['nama_pemilik'] . '</p>
                            <p>Dengan email yang terdaftar  ' . $penjual['email'] . '</p>
                            <p>Terimakasih telah menghubungi kami di kantin kalayang</p>
                            <p>dengan email ini kami telah melakukan reset kata sandi anda</p>
                            <p>Password baru : ' . $penjual['kata_sandi'] . '</p>
                            <p>Mohon setelah anda berhasil login dapat langsung mengganti password anda</p>
                            <div class="text-div">Terima kasih,</div>
                            <div class="text-div">Admin Kantin Kalayang</div>
                        </div>
                    </div>
                </body>

                </html>';
                $mailData = [
                    'to' => $penjual['email'],
                    'content' => $content,
                    'subject' => 'Your New Passowrd',
                ];
                $send = Mail::to($mailData['to'])->send(new SendEmailNew($mailData));
            } else {
                return "error";
            }
            return true;
        } else {
            return false;
        }
    }

    //Controller Private Function
    private function generateUniqueNumber()
    {
        $date = date('dmy');
        $lastNumber = ModelKalayangTransaksi::where('id_order', 'like', '#M' . $date . '%')->max('id_order');
        $lastSequentialNumber = $lastNumber ? intval(substr($lastNumber, 10)) : 0;
        if (!$lastNumber) {
            $nextSequentialNumber = 1;
        } else {
            $nextSequentialNumber = $lastSequentialNumber + 1;
        }
        return '#M' . $date . sprintf('%04d', $nextSequentialNumber);
    }


    //E-Mail
    // /**
    //  * Get the authenticated User.
    //  *
    //  * @return \Illuminate\Http\JsonResponse
    //  */
    // public function sendemail(Request $request)
    // {
    //     $email = $request->post('email');
    //     $penjual = ModelKalayangPenjual::where('email', 'like', $email . '%')->first();
    //     if ($penjual) {
    //         session(['namaPemilik' => $penjual['nama_pemilik']]);
    //         session(['email' => $penjual['email']]);
    //         session(['nomorTelepon' => $penjual['nomor_telepon']]);
    //         session(['KataSandi' => $penjual['kata_sandi']]);
    //         if ($email) {
    //             Mail::to($email)->send(new SendEmail());
    //         } else {
    //             return "error";
    //         }
    //         return  response()->json(['message' => "berhasil kirim", 'status' => true], 200);
    //     } else {
    //         return response()->json(['message' => "Data tidak ditemukan", 'status' => false, 'data' => $penjual], 404);
    //     }
    // }


}
