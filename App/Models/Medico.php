<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medico extends Model
{
    protected $table = 'medicos';
    
    public $timestamps = false;
    
    protected $fillable = [
        'usuario_id',
        'especialidade_id',
        'numero_ordem',
        'nivel',
        'hospital',
        'provincia_id',
        'telefone'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function especialidade()
    {
        return $this->belongsTo(Especialidade::class, 'especialidade_id');
    }

    public function provincia()
    {
        return $this->belongsTo(Provincia::class, 'provincia_id');
    }

    public function consultas()
    {
        return $this->hasMany(Consulta::class, 'medico_id');
    }

    public function diagnosticos()
    {
        return $this->hasMany(Diagnostico::class, 'medico_id');
    }
}
