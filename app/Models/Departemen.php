<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departemen extends Model
{
    use HasFactory;

    protected $table = 'departemens';
    protected $primaryKey = 'idDepartemen';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'nama',
        'nip',
        'tahun_masuk',
        'alamat',
        'no_telepon',
        'iduser',
        'foto',
        'username',
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'iduser');
    }
}
