<?php

// En el modelo Publicacion
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publicacion extends Model
{
    use HasFactory;

    protected $table = 'publicaciones'; // Nombre de la tabla

    public $timestamps = false;

    protected $fillable = ['titulo', 'descripcion', 'fecha_termino', 'ubicacion', 'modalidad', 'estado', 'remuneracion']; // Campos asignables
}
