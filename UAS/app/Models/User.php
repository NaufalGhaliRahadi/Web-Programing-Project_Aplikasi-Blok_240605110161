<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'penulis';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'nama_depan', 'nama_belakang', 'user_name', 'password', 'foto'
    ];

    protected $hidden = ['password'];
}