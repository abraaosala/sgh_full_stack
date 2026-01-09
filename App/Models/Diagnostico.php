<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diagnostico extends Model
{
    protected $table = 'diagnosticos';

    public $timestamps = false; // Check if it has timestamps later, assuming false for now

    protected $fillable = [
        'paciente_id',
        'medico_id',
        'doenca_id',
        'data_diagnostico',
        'observacoes',
        'status'
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }

    public function medico()
    {
        return $this->belongsTo(Medico::class, 'medico_id');
    }

    public function doenca()
    {
        return $this->belongsTo(Doenca::class, 'doenca_id');
    }
}
