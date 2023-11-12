<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skripsi extends Model
{
    use HasFactory;

    protected $table = 'skripsi';
    protected $primaryKey = 'id_skripsi';
    public $timestamps = false;

    protected $fillable = [
        'nim',
        'status',
        'nilai',
        'scan_skripsi',
        'statusVerif',
        'tanggal_sidang',
        'lama_studi',
        'semester',
        'nama_mhs', 
        'nama_doswal'
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim');
    }
}
