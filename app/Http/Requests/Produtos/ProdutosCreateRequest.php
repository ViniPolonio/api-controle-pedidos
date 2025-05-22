<?php

namespace App\Http\Requests\Produtos;

use Illuminate\Foundation\Http\FormRequest;

class ProdutosCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome'      => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'preco'     => 'required|numeric|min:0',
            'status'    => 'required|boolean',

            // Campos para a tabela estoque
            'cor'       => 'required|string|max:100',
            'tamanho'   => 'required|string|max:10',
            'quantidade'=> 'required|integer|min:0',
        ];
    }
}
