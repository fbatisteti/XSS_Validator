<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $log = Log::all();
        
        return response()->json($log);
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
                'start' => 'date',
                'end' => 'date'
            ]
        );

        if ($validated->fails()) {
            return response()->json([
                'retorno' => 'ALGUM ERRO OCORREU'
            ], 400);
        };

        $usuario_uid = $request->all()['usuarioUid'];
        if ($request->all()['start'] != null)
            $startDate = $request->all()['start'];
        if ($request->all()['end'] != null)
            $endDate = $request->all()['end'];

        $content = '';

        $solicitacao = $request->all();
        $log['uid'] = Str::uuid()->toString();
        $solicitacao['usuarioUid'] = $usuario_uid;
        $solicitacao['content'] = $content;

        $log = Log::create($log);

        return response()->json([
            $log
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Log  $log
     * @return \Illuminate\Http\Response
     */
    public function show(string $uid)
    {
        $logAlvo = null;

        $log = Log::all();
        foreach ($log as $l) {
            if ($l['uid'] == $uid) {
                $logAlvo = new Log();
                $logAlvo->uid = $l->uid;
                $logAlvo->usuario_uid = $l->usuario_uid;
                $logAlvo->content = $l->content;
                break;
            };
        };

        return ($logAlvo == null) ?
            response()->json(['message' => 'LOG NAO ENCONTRADO'],400)
            : response()->json($logAlvo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Log  $log
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Log $log)
    {
        return response()->json(['METODO NAO IMPLEMENTADO NESTE EXEMPLO'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Log  $log
     * @return \Illuminate\Http\Response
     */
    public function destroy(Log $log)
    {
        return response()->json(['METODO NAO IMPLEMENTADO NESTE EXEMPLO'], 200);
    }
}
