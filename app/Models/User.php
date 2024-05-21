<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;
    protected $table = 'usuarios';
    protected $fillable = [
        'username',
        'password',
        'administrator', // Campo para indicar si el usuario es administrador
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function iruzkinak()
    {
        return $this->hasMany(Iruzkina::class, 'user_id');
    }
    public function panelesFavoritos()
    {
        return $this->hasMany(UsuarioPanelFavorito::class, 'usuario_id');
    }
    public function userKoloreak()
    {
        return $this->hasOne(UserKoloreak::class, 'login_id');
    }
}
