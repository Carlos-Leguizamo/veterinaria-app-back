<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Historia;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Consulta extends Model
{
    use HasFactory;


    protected $table = 'consultas';


    protected $fillable = [
        'historias_clinicas_id',
        'mascotas_id',
        'veterinarios_id',
        'amos_id',
        'fecha_consulta',
        'detalles'
    ];



    public function historias_clinicas()
    {
        return $this->belongsTo(Historia::class);
    }
}
