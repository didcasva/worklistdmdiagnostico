<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tecnologa extends Model
{
    use HasFactory;
    protected $table = 'tecnologa';  // Si tu tabla no sigue la convención 'pacientes'
    public $timestamps = false;
    protected $fillable = [
        'id',
        'CodigoRm',
        'numDocumento',
        'NombreCompleto',
    ];
    public function pacientes() {
        return $this->hasMany(Paciente::class);
    }
    
}
