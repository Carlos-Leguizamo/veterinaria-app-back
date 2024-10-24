<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Historia extends Model
{
    protected $table = 'historias_clinicas';
    protected $fillable = ['mascotas_id', 'veterinarios_id', 'fecha_consulta', 'diagnostico', 'tratamiento'];
}
