<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    use HasFactory;

    protected $table = 'Pacientes';  // Si tu tabla no sigue la convención 'pacientes'
    protected $primaryKey = 'N_Orden'; // 👈 clave primaria real
    public $incrementing = false;     // 👈 si N_Orden no es autoincremental
    protected $keyType = 'string';    // 👈 si es string, cámbialo a 'int' si es numérico
    public $timestamps = false;
    protected $fillable = [
        'Id_Log',
        'N_Orden',
        'Cedula',
        'P_Apellido',
        'S_Apellido',
        'P_Nombre',
        'S_Nombre',
        'Sexo',
        'Ano',
        'Mes',
        'Dia',
        'Rh',
        'Edad',
        'Fecha_Nacimiento',
        'Tipo_Estudio',
        'Entidad',
        'Lugar',
        'Nombre_Completo',
        'Fecha_Estudio',
        'Direccion',
        'Telefono',
        'Tipo_Documento',
        'tecnologa_id',
        'HoraAtencion',
        'CCDkv',
        'CCDmas',
        'MLDkv',
        'MLDmas',
        'CCIkv',
        'CCImas',
        'MLIkv',
        'MLImas',
        'CCDespesor',
        'MLDespesor',
        'CCIespesor',
        'MLIespesor',
        'estado',
        'numeroplacas',
        'observaciones',
        'horafin',
        'atencionsiono',
        'lado_derecho',
        'lado_izquierdo'
    ];
    public function tecnologa() {
        return $this->belongsTo(Tecnologa::class);
    }
    
}

