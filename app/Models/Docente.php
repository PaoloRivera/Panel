<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    use HasFactory;

    protected $table = 'docentes';
    
    // Agregamos las nuevas columnas y modificamos la columna redes_sociales
    protected $fillable = [
        'nombre', 
        'descripcion', 
        'cargo', 
        'redes_sociales', 
        'redes_sociales_dos', 
        'redes_sociales_tres', 
        'foto'
    ];
}
