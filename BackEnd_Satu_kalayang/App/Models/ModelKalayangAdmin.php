<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelKalayangAdmin extends Model
{
    use HasFactory;
    protected $table ='tb_admin';
    protected $primaryKey ='id_admin';
    protected $fillable = ['username','password','role', 'created_at', 'updated_at'];
}
