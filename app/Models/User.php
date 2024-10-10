<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * La clave primaria de la tabla.
     *
     * @var string
     */
    protected $primaryKey = 'user_id'; // Cambiar a 'user_id'

    /**
     * Indica si la clave primaria se auto-incrementa.
     *
     * @var bool
     */
    public $incrementing = true; // Habilitar auto-incremento

    /**
     * El tipo de la clave primaria.
     *
     * @var string
     */
    protected $keyType = 'int'; // Establecer el tipo de la clave primaria como entero

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
        'username', // Si lo usas
        'status',   // Si manejas un estado del usuario
        'uuid',     // Si manejas UUID
        'url_img',  // Si manejas una URL de imagen
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
