<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    use HasFactory;

    protected $table = 'estudiantes'; // Nombre de la tabla
    public $timestamps = false;

    protected $primaryKey = 'dni'; // Clave primaria es 'dni'
    public $incrementing = false; // Porque 'dni' no es autoincremental
    protected $fillable = ['dni', 'nombre', 'apellidos', 'correo', 'telefono', 'cv']; // Campos asignables
}
