<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class N_PATIENT extends Model
{
    use HasFactory;
    protected $table = 'N_PATIENT';  // Si tu tabla no sigue la convención 'pacientes'
    public $timestamps = false;
    protected $fillable = [
        'patient_id',
        'patient_name',
        'birth_date',
        'sex',
    ];
}
