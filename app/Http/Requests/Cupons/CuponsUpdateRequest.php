<?php

namespace App\Http\Requests\Cupons;

use Illuminate\Foundation\Http\FormRequest;

class CuponsUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'codigo'          => 'sometimes|string|max:50|unique:cupons,codigo,' . $this->route('id'),
            'desconto'        => 'nullable|numeric|min:0',
            'percentual'      => 'nullable|numeric|min:0|max:100',
            'valor_minimo'    => 'nullable|numeric|min:0',
            'validade'        => 'nullable|date',
            'quantidade'      => 'sometimes|integer|min:1',
            'quantidade_usada'=> 'nullable|integer|min:0',
        ];
    }
}
