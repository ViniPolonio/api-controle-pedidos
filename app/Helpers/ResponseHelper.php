<?php

namespace App\Helpers;

//Helper para padronização de mensagens de retorno

class ResponseHelper
{
    public static function success($data = [], $message = 'Operação realizada com sucesso.', $status = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data'    => $data,
        ], $status);
    }

    public static function error($message = 'Erro na operação.', $status = 400, $errors = [])
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors'  => $errors,
        ], $status);
    }
}
