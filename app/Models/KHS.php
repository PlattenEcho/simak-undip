<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KHS extends Model
{
    use HasFactory;

    protected $table = 'KHS';
    protected $primaryKey = 'id_khs';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = ['nim', 'semester', 'sks_smt', 'sks_kum', 'ips', 'ipk', 'scan_khs'];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim');
    }
}
