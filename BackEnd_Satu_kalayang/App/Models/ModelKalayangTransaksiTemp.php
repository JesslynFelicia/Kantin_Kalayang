<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelKalayangTransaksiTemp extends Model
{
    use HasFactory;
    protected $table ='tb_transaksi_temp';
    protected $primaryKey ='id_temp';
    protected $fillable = ['guest_id', 'id_penjual','id_menu','note', 'created_at','updated_at'];
}
