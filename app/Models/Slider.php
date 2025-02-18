<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $table = 'slider'; // Nombre de la tabla
    public $timestamps = false;

    protected $fillable = ['logo', 'titulo', 'descripcion', 'boton']; // Campos asignables
}
