<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    protected $table = 'consultas';

    public $timestamps = false;

    protected $fillable = [
        'paciente_id',
        'medico_id',
        'agenda_id',
        'marcacao',
        'observacao',
        'status'
    ];

    public function agenda()
    {
        return $this->belongsTo(Agenda::class, 'agenda_id');
    }

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }

    public function medico()
    {
        return $this->belongsTo(Medico::class, 'medico_id');
    }

    // Scopes
    public function scopeDoPaciente($query, $pacienteId)
    {
        return $query->where('paciente_id', $pacienteId);
    }

    public function scopeDoMedico($query, $medicoId)
    {
        return $query->where('medico_id', $medicoId);
    }
}
