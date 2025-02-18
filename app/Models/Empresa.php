<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    // Definir la tabla asociada
    protected $table = 'empresas';

    // Definir los campos que se pueden llenar
    protected $fillable = [
        'ruc',
        'razon_social',
        'direccion',
        'logo',
        'estado',
    ];

    // Indicar que la clave primaria no es autoincremental
    protected $primaryKey = 'ruc';
    
    // Definir que no usamos timestamps (si no los necesitas)
    public $timestamps = false;
}
