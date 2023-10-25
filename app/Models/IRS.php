<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IRS extends Model
{
    use HasFactory;

    protected $table = 'IRS';
    protected $primaryKey = 'id_irs';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = ['nim', 'kode_mk', 'semester', 'jml_sks', 'scan_irs'];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim');
    }

    public function matkul()
    {
        return $this->belongsTo(Matkul::class, 'kode_mk');
    }
}


