<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneratedAccount extends Model
{
    use HasFactory;

    protected $table = 'generated_accounts';
    protected $fillable = ['nama', 'username', 'password'];
}
