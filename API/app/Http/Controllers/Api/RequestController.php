<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Request as Solicitacao;
use Illuminate\Http\Request as Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use MINI\VALIDATOR as XSS_VALIDATOR;

use function MINI\sanitize;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $solicitacao = Solicitacao::all();

        return response()->json($solicitacao);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = Validator::make(
            $request->all(),
            [
                'usuarioUid' => 'required|uuid',
                'input' => 'required|string'
            ]
        );

        if ($validated->fails()) {
            return response()->json([
                'retorno' => 'ALGUM ERRO OCORREU'
            ], 400);
        };

        $input = $request->all()['input'];

        [$sanitized_input, $result, $is_safe]
            = XSS_VALIDATOR::mini_validate($input);

        $solicitacao = $request->all(); 
        $solicitacao['uid'] = Str::uuid()->toString();
        $solicitacao['sanitizedInput'] = $sanitized_input;
        $solicitacao['result'] = $result;
        $solicitacao['isSafe'] = $is_safe;

        $solicitacao = Solicitacao::create($solicitacao);

        return response()->json([
            $solicitacao
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(string $uid)
    {
        $solicitacaoAlvo = null;

        $solicitacao = Solicitacao::all();
        foreach ($solicitacao as $s) {
            if ($s['uid'] == $uid) {
                $solicitacaoAlvo = new Solicitacao();
                $solicitacaoAlvo->uid = $s->uid;
                $solicitacaoAlvo->usuario_uid = $s->usuario_uid;
                $solicitacaoAlvo->created_at = $s->created_at;
                $solicitacaoAlvo->input = $s->input;
                $solicitacaoAlvo->sanitized_input = $s->sanitized_input;
                $solicitacaoAlvo->result = $s->result;
                $solicitacaoAlvo->is_safe = $s->is_safe;
                break;
            };
        };

        return ($solicitacaoAlvo == null) ?
            response()->json(['message' => 'SOLICITACAO NAO ENCONTRADA'],400)
            : response()->json($solicitacaoAlvo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Solicitacao $solicitacao)
    {
        /*
        $solicitacao->update($request->all());

        return response()->json([
                'message' => 'SOLICITACAO ATUALIZADA',
                'solicitacao' => $solicitacao
            ], 200);
        */

        return response()->json(['METODO NAO IMPLEMENTADO NESTE EXEMPLO'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Solicitacao $solicitacao)
    {
        /*
        $solicitacao->delete();

        return response()->json([
                'message' => 'SOLICITACAO REMOVIDA',
                'solicitacao' => $solicitacao
            ], 200);
        */

        return response()->json(['METODO NAO IMPLEMENTADO NESTE EXEMPLO'], 200);
    }
}
