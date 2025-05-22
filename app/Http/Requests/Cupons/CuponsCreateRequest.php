<?php

namespace App\Http\Requests\Cupons;

use Illuminate\Foundation\Http\FormRequest;

class CuponsCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'codigo'          => 'required|string|max:50|unique:cupons,codigo',
            'desconto'        => 'nullable|numeric|min:0',
            'percentual'      => 'nullable|numeric|min:0|max:100',
            'valor_minimo'    => 'nullable|numeric|min:0',
            'validade'        => 'nullable|date',
            'quantidade'      => 'required|integer|min:1',
            'quantidade_usada'=> 'nullable|integer|min:0',
        ];
    }
}
