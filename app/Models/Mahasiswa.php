<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswa';
    protected $primaryKey = 'nim';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'nim',
        'nama',
        'angkatan',
        'status',
        'jalur_masuk',
        'alamat',
        'kabupaten',
        'provinsi',
        'username',
        'nomor_telepon',
        'nip'
    ];

    public function dosen_wali()
    {
        return $this->belongsTo(Doswal::class, 'nip');
    }

    public function irs()
    {
        return $this->hasMany(IRS::class, 'nim', 'nim');
    }
}