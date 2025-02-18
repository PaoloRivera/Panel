<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    use HasFactory;

    protected $table = 'carreras'; // Nombre de la tabla
    public $timestamps = false;

    protected $fillable = [
        'titulo', 'foto', 'descripcion', 'contenido_titulo', 'contenido_subtitulo', 
        'modalidad', 'fecha_inicio', 'horario', 'valor_academico', 'costo', 'video', 'id_docente'
    ]; // Campos asignables

    // Relación con el modelo Docente
    public function docente()
    {
        return $this->belongsTo(Docente::class, 'id_docente');
    }
}
