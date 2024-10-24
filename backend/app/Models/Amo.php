<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Amo extends Model
{
    use HasApiTokens,HasFactory;


    protected $fillable = [
        'first_name',
        'second_name',
        'last_name',
        'second_last_name',
        'email',
        'password',
        'tipo_identidad',
        'numero_identidad',
        'direccion',
        'telefono',
        'genero',
    ];


    protected $hidden = [
        'password',
    ];
}