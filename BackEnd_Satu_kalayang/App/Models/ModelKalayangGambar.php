<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelKalayangGambar extends Model
{
    use HasFactory;
    protected $table ='tb_gambar';
    protected $primaryKey ='id_gambar';
    protected $fillable = ['id_penjual','format_gambar','data_image', 'gambar', 'created_at' ,'updated_at'];
}
