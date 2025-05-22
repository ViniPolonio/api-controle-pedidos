<?php

namespace App\Http\Requests\Pedidos;

use Illuminate\Foundation\Http\FormRequest;

class PedidosUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'itens'                => 'sometimes|json',
            'subtotal'             => 'sometimes|numeric|min:0',
            'frete'                => 'sometimes|numeric|min:0',
            'total'                => 'sometimes|numeric|min:0',
            'cep'                  => 'sometimes|string|max:10',
            'endereco'             => 'sometimes|string|max:255',
            'endereco_referencia' => 'sometimes|nullable|string|max:255',
            'status_id'            => 'sometimes|integer',
            'created_by'           => 'sometimes|integer',
            'updated_by'           => 'sometimes|integer',
        ];
    }
}
