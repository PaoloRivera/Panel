<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transparencia extends Model
{
    use HasFactory;

    protected $table = 'transparencias'; // Nombre de la tabla
    protected $fillable = ['titulo', 'pdf']; // Campos asignables
}
