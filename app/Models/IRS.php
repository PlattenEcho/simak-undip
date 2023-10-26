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

    protected $fillable = ['nim', 'semester', 'jml_sks', 'scan_irs', 'nama_mhs', 'nama_doswal'];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim');
    }
}


