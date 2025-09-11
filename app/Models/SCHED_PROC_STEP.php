<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SCHED_PROC_STEP extends Model
{
    use HasFactory;
    protected $table = 'SCHED_PROC_STEP';  // Si tu tabla no sigue la convención 'pacientes'
    public $timestamps = false;
    protected $fillable = [
        'modality',
        'scheduled_station_ae_title',
        'start_date_time',
        'sched_proc_step_id',
        'req_proc_id',
    ];
}
