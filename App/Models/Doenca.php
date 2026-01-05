<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doenca extends Model
{
    protected $table = 'doencas_respiratorias';
    public $timestamps = false;
    protected $fillable = [
        'nome',
        'descricao'
    ];

    public function diagnosticos()
    {
        return $this->hasMany(Diagnostico::class, 'doenca_id');
    }
}
