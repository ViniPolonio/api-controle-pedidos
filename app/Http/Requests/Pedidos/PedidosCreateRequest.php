<?php

namespace App\Http\Requests\Pedidos;

use Illuminate\Foundation\Http\FormRequest;

class PedidosCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'codigo_cupom'           => 'nullable|string|exists:cupons,codigo',
            'itens'                  => 'required|array',
            'itens.*.product_id'     => 'required|integer|exists:produtos,id',
            'itens.*.quantidade'     => 'required|integer|min:1',
            'itens.*.preco_unitario' => 'required|numeric|min:0',
            'subtotal'               => 'nullable|numeric|min:0',
            'frete'                  => 'nullable|numeric|min:0',
            'total'                  => 'nullable|numeric|min:0',
            'cep'                    => 'required|string|max:10',
            'endereco'               => 'required|string|max:255',
            'endereco_referencia'    => 'nullable|string|max:255',
            'status_id'              => 'required|integer',
        ];
    }


    public function messages(): array
    {
        return [
            'codigo_cupom.exists'      => 'O cupom informado não foi encontrado.',
            'codigo_cupom.string'      => 'O código do cupom deve ser uma sequência de caracteres.',
            'itens.required'           => 'É obrigatório informar os itens do pedido.',
            'itens.json'               => 'Os itens do pedido devem estar em formato JSON válido.',
            'subtotal.numeric'         => 'O subtotal deve ser um número.',
            'subtotal.min'             => 'O subtotal não pode ser negativo.',
            'frete.numeric'            => 'O valor do frete deve ser um número.',
            'frete.min'                => 'O valor do frete não pode ser negativo.',
            'total.numeric'            => 'O total deve ser um número.',
            'total.min'                => 'O total não pode ser negativo.',
            'cep.required'             => 'O CEP é obrigatório.',
            'cep.string'               => 'O CEP deve ser uma sequência de caracteres.',
            'cep.max'                  => 'O CEP não pode ter mais que 10 caracteres.',
            'endereco.required'        => 'O endereço é obrigatório.',
            'endereco.string'          => 'O endereço deve ser uma sequência de caracteres.',
            'endereco.max'             => 'O endereço não pode ter mais que 255 caracteres.',
            'endereco_referencia.string' => 'A referência do endereço deve ser uma sequência de caracteres.',
            'endereco_referencia.max'    => 'A referência do endereço não pode ter mais que 255 caracteres.',
            'status_id.required'       => 'O status do pedido é obrigatório.',
            'status_id.integer'        => 'O status do pedido deve ser um número inteiro.',
        ];
    }
}
