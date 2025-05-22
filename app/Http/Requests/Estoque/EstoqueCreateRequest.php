<?php

namespace App\Http\Requests\Estoque;

use Illuminate\Foundation\Http\FormRequest;

class EstoqueCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'produto_id' => 'required|integer|exists:produtos,id',
            'cor'        => 'required|string|max:50',
            'tamanho'    => 'required|string|max:10',
            'quantidade' => 'required|integer|min:0',
        ];
    }
}
