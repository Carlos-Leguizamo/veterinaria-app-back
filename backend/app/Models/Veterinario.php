<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Veterinario extends Model
{
    use HasApiTokens, Notifiable;
    protected $fillable = ['first_name', 'second_name', 'last_name', 'second_last_name', 'email', 'password', 'telefono', 'especialidad', 'tipo_identidad', 'numero_identidad'];


    protected $hidden = ['password'];

    public function amos()
    {
        return $this->belongsToMany(Amo::class, 'amo_veterinario', 'veterinarios_id', 'amos_id');
    }
}
