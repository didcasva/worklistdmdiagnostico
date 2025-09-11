<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class REQUESTED_PROCEDURE extends Model
{
    use HasFactory;
    protected $table = 'REQUESTED_PROCEDURE';  // Si tu tabla no sigue la convención 'pacientes'
    public $timestamps = false;
    protected $fillable = [
        'study_instance_uid',
        'service_request_id',
        'patient_internal_id',
    ];
}
