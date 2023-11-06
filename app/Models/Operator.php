<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operator extends Model
{
    use HasFactory;

    protected $table = 'operator';
    protected $primaryKey = 'idOperator';
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
        'password'
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'iduser');
    }
}