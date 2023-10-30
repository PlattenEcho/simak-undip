<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doswal extends Model
{
    use HasFactory;

    protected $table = 'dosen_wali';
    protected $primaryKey = 'nip';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'nip',
        'nama',
        'tahun_masuk',
        'gelar_depan',
        'gelar_belakang',
        'alamat',
        'nomor_telepon',
    ];

    public function mahasiswa()
    {
        return $this->hasMany(Mahasiswa::class, 'nip', 'nip');
    }
}
