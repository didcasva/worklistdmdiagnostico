<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERVICE_REQUEST extends Model
{
    use HasFactory;
    protected $table = 'SERVICE_REQUEST';  // Si tu tabla no sigue la convención 'pacientes'
    public $timestamps = false;
    protected $fillable = [
        'accession_number',
    ];
}
