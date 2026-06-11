<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'user'; // Paksa Laravel pakai tabel 'user' native kamu
    protected $primaryKey = 'id_user'; // Ganti jika primary key-mu bukan 'id' (misal 'id_user')
    
    // Jika kolom password di tabelmu namanya bukan 'password'
    public function getAuthPassword()
    {
        return $this->password_user; 
    }
}