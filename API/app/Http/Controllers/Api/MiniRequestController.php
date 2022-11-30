<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Request as Solicitacao;
use Illuminate\Http\Request as Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Mini\Validator as Mini;

use function Mini\sanitize;

class MiniRequestController extends RequestController
{
    public static function post(array $data)
    {
        $input = $data['input'];
        
        [$sanitized_input, $results, $is_safe] = Mini::mini_validate($input);

        $solicitacao['usuarioUid'] = $data["uid"];
        $solicitacao['input'] = $data["input"];
        $solicitacao['uid'] = Str::uuid()->toString();
        $solicitacao['sanitizedInput'] = $sanitized_input;
        $solicitacao['results'] = json_encode($results);
        $solicitacao['isSafe'] = $is_safe;

        $solicitacao = Solicitacao::create($solicitacao);

        return $solicitacao;
    }
}