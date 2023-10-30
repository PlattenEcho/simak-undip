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
        'nip',
        'iduser',
    ];

    public function dosen_wali()
    {
        return $this->belongsTo(Doswal::class, 'nip');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'iduser');
    }

    public function irs()
    {
        return $this->hasMany(IRS::class, 'nim', 'nim');
    }

    public function khs()
    {
        return $this->hasMany(KHS::class, 'nim', 'nim');
    }

    public function pkl()
    {
        return $this->hasMany(PKL::class, 'nim', 'nim');
    }

    public function skripsi()
    {
        return $this->hasMany(Skripsi::class, 'nim', 'nim');
    }
}