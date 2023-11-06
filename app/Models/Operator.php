<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operator extends Model
{
    use HasFactory;

    protected $table = 'operators';
    protected $primaryKey = 'nip';
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