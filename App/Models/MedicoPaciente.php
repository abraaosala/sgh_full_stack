<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicoPaciente extends Model
{
    protected $table = 'medico_paciente';
    
    public $timestamps = false;
    
    protected $guarded = [];
}
