<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PKL extends Model
{
    use HasFactory;

    protected $table = 'pkl';
    protected $primaryKey = 'idPKL';
    public $timestamps = false;

    protected $fillable = ['nim', 'semester', 'status', 'nilai', 'scan_pkl', 'statusVerif', 'nama_mhs', 'nama_doswal'];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim');
    }
}
