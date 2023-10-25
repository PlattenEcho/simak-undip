<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matkul extends Model
{
    use HasFactory;

    protected $table = 'matkul';
    protected $primaryKey = 'kode_mk';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = ['kode_mk', 'nama', 'semester', 'jml_sks'];
}
