<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tratamento extends Model
{
    protected $table = 'tratamentos';
    public $timestamps = false;
    protected $fillable = [
        'diagnostico_id',
        'descricao',
        'data_inicio',
        'data_fim'
    ];

    public function diagnostico()
    {
        return $this->belongsTo(Diagnostico::class, 'diagnostico_id');
    }
}
