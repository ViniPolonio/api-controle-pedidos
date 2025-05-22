<?php

namespace App\Http\Requests\Produtos;

use Illuminate\Foundation\Http\FormRequest;

class ProdutosUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome'      => 'sometimes|string|max:255',
            'descricao' => 'sometimes|nullable|string',
            'preco'     => 'sometimes|numeric|min:0',
            'status'    => 'sometimes|boolean',
        ];
    }
}
