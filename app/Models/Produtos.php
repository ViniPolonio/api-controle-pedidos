<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produtos extends Model
{
    protected $table = 'produtos';

    protected $fillable = [
        'nome',
        'descricao',
        'preco',
        'status',
    ];

    public function estoque()
    {
        return $this->hasOne(Estoque::class, 'produto_id');
    }
}
