<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedidos extends Model
{
    protected $table = 'pedidos';

    protected $fillable = [
        'itens',
        'subtotal',
        'frete',
        'total',
        'cep',
        'endereco',
        'endereco_referencia',
        'status_id',
        'created_by',
        'updated_by'
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
