<?php

namespace App\Http\Requests\Estoque;

use Illuminate\Foundation\Http\FormRequest;

class EstoqueUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'produto_id' => 'sometimes|integer|exists:produtos,id',
            'cor'        => 'sometimes|string|max:50',
            'tamanho'    => 'sometimes|string|max:10',
            'quantidade' => 'sometimes|integer|min:0',
        ];
    }
}
