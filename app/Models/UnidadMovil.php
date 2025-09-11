<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnidadMovil extends Model
{
    use HasFactory;

    // Si tu tabla no sigue la convención de pluralización de Laravel,
    // puedes especificar el nombre de la tabla así:
    protected $table = 'UNIDADMOVIL';

    public $timestamps = false; // Cambia a true si necesitas timestamps

    // Define los campos que se pueden asignar masivamente
    protected $fillable = [
        'unidad',
        'contador',
    ];
}
