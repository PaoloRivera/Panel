<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CursoTecnico extends Model
{
    use HasFactory;

    protected $table = 'curso_tecnico';
    public $timestamps = false;

    
    protected $fillable = [
        'titulo',
        'imagen',
        'id_docente',
        'descripcion',
        'beneficios',
        'tiempo',
        'fecha_examen',
        'fecha_inicio',
        'duracion',
        'matricula',
        'cuotas',
        'pension',
        'modalidad',
        'horario',
        'valor_academico',
        'malla_curricular',
        'estado'
    ];

    protected $casts = [
        'matricula' => 'float',
        'cuotas' => 'float',
        'pension' => 'float',
        'fecha_examen' => 'date',
        'fecha_inicio' => 'date'
    ];
}