<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cupons extends Model
{
    protected $table = 'cupons';

    protected $fillable = [
        'codigo',
        'desconto',
        'percentual',
        'valor_minimo',
        'validade',
        'quantidade',
        'quantidade_usada',
    ];

    protected $casts = [
        'validade' => 'date',
    ];
}
