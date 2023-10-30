<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PKL extends Model
{
    use HasFactory;

    protected $table = 'PKL';
    protected $primaryKey = 'idPKL';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = ['nim', 'status', 'nilai', 'scan_pkl'];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim');
    }
}
