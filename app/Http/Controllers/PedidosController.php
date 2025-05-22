<?php

namespace App\Http\Controllers;

use App\Http\Requests\Pedidos\PedidosCreateRequest;
use App\Http\Requests\Pedidos\PedidosUpdateRequest;
use App\Models\Cupons;
use App\Models\Pedidos;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;

class PedidosController extends Controller
{
    public function index()
    {
        try {
            $pedidos = Pedidos::all();
            return ResponseHelper::success($pedidos, 'Lista de pedidos retornada com sucesso.');
        } catch (\Exception $e) {
            return ResponseHelper::error('Erro ao buscar pedidos: ' . $e->getMessage(), 500);
        }
    }

    public function store(PedidosCreateRequest $request)
    {
        try {
            $data = $request->validated();
            $user = auth()->user();
            $data['created_by'] = $user->id;

            $cupom = null;

            if (!empty($data['codigo_cupom'])) {
                $itens = $data['itens'];
                $subtotal = $this->calcularSubtotal($itens);
                $frete = $data['frete'] ?? 0;

                $cupom = Cupons::where('codigo', $data['codigo_cupom'])->first();

                if (!$cupom) {
                    return ResponseHelper::error('Cupom inválido.', 422);
                }
                if ($cupom->validade && now()->greaterThan($cupom->validade)) {
                    return ResponseHelper::error('Cupom expirado.', 422);
                }
                if ($cupom->quantidade_usada >= $cupom->quantidade) {
                    return ResponseHelper::error('Limite de uso do cupom atingido.', 422);
                }
                if ($cupom->valor_minimo && $subtotal < $cupom->valor_minimo) {
                    return ResponseHelper::error('Subtotal insuficiente para usar o cupom.', 422);
                }

                $descontoAplicado = $cupom->percentual
                    ? $subtotal * ($cupom->percentual / 100)
                    : $cupom->desconto;

                $total = max(0, $subtotal + $frete - $descontoAplicado);

                $data['subtotal'] = $subtotal;
                $data['frete'] = $frete;
                $data['total'] = $total;
            } else {
                $data['subtotal'] = $data['subtotal'] ?? 0;
                $data['frete'] = $data['frete'] ?? 0;
                $data['total'] = $data['total'] ?? 0;
            }

            $data['itens'] = json_encode($data['itens']);
            $pedido = Pedidos::create($data);

            if ($cupom) {
                $cupom->increment('quantidade_usada');
            }

            return ResponseHelper::success($pedido, 'Pedido criado com sucesso.', 201);
        } catch (\Exception $e) {
            return ResponseHelper::error('Erro interno ao processar o pedido: ' . $e->getMessage(), 500);
        }
    }

    public function calcularSubtotal(array $itens): float
    {
        if (empty($itens) || !is_array($itens)) {
            return 0;
        }

        $subtotal = 0;

        foreach ($itens as $item) {
            $quantidade = $item['quantidade'] ?? 0;
            $precoUnitario = $item['preco_unitario'] ?? 0;

            $subtotal += $quantidade * $precoUnitario;
        }

        return $subtotal;
    }

    public function show($id)
    {
        try {
            $pedido = Pedidos::find($id);

            if (!$pedido) {
                return ResponseHelper::error('Pedido não encontrado.', 404);
            }

            return ResponseHelper::success($pedido, 'Pedido encontrado com sucesso.');
        } catch (\Exception $e) {
            return ResponseHelper::error('Erro ao buscar pedido: ' . $e->getMessage(), 500);
        }
    }

    public function update(PedidosUpdateRequest $request, $id)
    {
        try {
            $pedido = Pedidos::find($id);

            if (!$pedido) {
                return ResponseHelper::error('Pedido não encontrado.', 404);
            }

            $pedido->update($request->validated());

            return ResponseHelper::success($pedido, 'Pedido atualizado com sucesso.');
        } catch (\Exception $e) {
            return ResponseHelper::error('Erro ao atualizar pedido: ' . $e->getMessage(), 500);
        }
    }

    public function destroy($id)
    {
        try {
            $pedido = Pedidos::find($id);

            if (!$pedido) {
                return ResponseHelper::error('Pedido não encontrado.', 404);
            }

            $pedido->delete();

            return ResponseHelper::success([], 'Pedido removido com sucesso.');
        } catch (\Exception $e) {
            return ResponseHelper::error('Erro ao remover pedido: ' . $e->getMessage(), 500);
        }
    }
}
