<?php

namespace App\Http\Controllers;

use App\Models\Cupons;
use Illuminate\Http\Request;
use App\Http\Requests\Cupons\CuponsCreateRequest;
use App\Http\Requests\Cupons\CuponsUpdateRequest;
use App\Helpers\ResponseHelper;

class CuponsController extends Controller
{
    public function index()
    {
        try {
            $cupons = Cupons::all();
            return ResponseHelper::success($cupons, 'Lista de cupons retornada com sucesso.');
        } catch (\Exception $e) {
            return ResponseHelper::error('Erro ao listar cupons: ' . $e->getMessage(), 500);
        }
    }

    public function store(CuponsCreateRequest $request)
    {
        try {
            $cupon = Cupons::create($request->validated());
            return ResponseHelper::success($cupon, 'Cupom criado com sucesso.', 201);
        } catch (\Exception $e) {
            return ResponseHelper::error('Erro ao criar cupom: ' . $e->getMessage(), 500);
        }
    }

    public function show(string $cupom)
    {
        try {
            $cupon = Cupons::where('codigo', '=', $cupom)->first();

            if (!$cupon) {
                return ResponseHelper::error('Cupom não encontrado.', 404);
            }

            if ($cupon->validade && now()->greaterThan($cupon->validade)) {
                return ResponseHelper::error('Cupom expirado.', 422);
            }

            if ($cupon->quantidade_usada >= $cupon->quantidade) {
                return ResponseHelper::error('Limite de uso do cupom atingido.', 422);
            }

            return ResponseHelper::success($cupon, 'Cupom encontrado com sucesso.');
        } catch (\Exception $e) {
            return ResponseHelper::error('Erro ao buscar cupom: ' . $e->getMessage(), 500);
        }
    }


    public function update(CuponsUpdateRequest $request, $id)
    {
        try {
            $cupon = Cupons::find($id);

            if (!$cupon) {
                return ResponseHelper::error('Cupom não encontrado.', 404);
            }

            $cupon->update($request->validated());

            return ResponseHelper::success($cupon, 'Cupom atualizado com sucesso.');
        } catch (\Exception $e) {
            return ResponseHelper::error('Erro ao atualizar cupom: ' . $e->getMessage(), 500);
        }
    }

    public function destroy($id)
    {
        try {
            $cupon = Cupons::find($id);

            if (!$cupon) {
                return ResponseHelper::error('Cupom não encontrado.', 404);
            }

            $cupon->delete();

            return ResponseHelper::success([], 'Cupom removido com sucesso.');
        } catch (\Exception $e) {
            return ResponseHelper::error('Erro ao remover cupom: ' . $e->getMessage(), 500);
        }
    }
}
