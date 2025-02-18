<?php

// En el modelo Postulacion
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Postulacion extends Model
{
    use HasFactory;

    protected $table = 'postulaciones'; // Nombre de la tabla

    public $timestamps = false;


    protected $fillable = ['id_publicacion', 'dni_estudiante', 'fecha', 'estado', 'comentarios']; // Campos asignables

    // Relación con publicación
    public function publicacion()
    {
        return $this->belongsTo(Publicacion::class, 'id_publicacion');
    }

    // Relación con estudiante
    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'dni_estudiante');
    }
}
