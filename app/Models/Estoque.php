<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estoque extends Model
{
    protected $table = 'estoques';

    protected $fillable = [
        'produto_id',
        'cor',
        'tamanho',
        'quantidade',
    ];

    public function produto()
    {
        return $this->belongsTo(Produtos::class, 'produto_id');
    }
}
