<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuario = Usuario::all();
        
        return response()->json($usuario);
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
                'email' => 'required|email',
                'password' => 'required|max:50|min:10'
            ]
        );

        if ($validated->fails()) {
            return response()->json([
                    'retorno' => 'ALGUM ERRO OCORREU'
                ], 400);
        };

        $usuario = $request->all();
        $usuario['uid'] = Str::uuid()->toString();

        $usuario = Usuario::create($usuario);

        return response()->json([
                'retorno' => 'USUARIO CRIADO',
                'usuario' => [
                    'usuario' => $usuario->email,
                    'uid' => $usuario->uid,
                    'criacao' => $usuario->created_at->format('Y-m-d H:i:s T')
                ]
            ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function show(string $uid)
    {
        $usuarioAlvo = null;

        $usuario = Usuario::all();
        foreach ($usuario as $u) {
            if ($u['uid'] == $uid) {
                $usuarioAlvo = new Usuario();
                $usuarioAlvo->uid = $u->uid;
                $usuarioAlvo->email = $u->email;
                break;
            };
        };

        return ($usuarioAlvo == null) ?
            response()->json(['message' => 'USUARIO NAO ENCONTRADO'],400)
            : response()->json($usuarioAlvo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Usuario $usuario)
    {
        /*
        $usuarioAlvo = null;

        $usuario = Usuario::all();
        foreach ($usuario as $u) {
            if ($u['uid'] == $uid) {
                $usuarioAlvo = new Usuario();
                $usuarioAlvo->email = $u->email;
                $usuarioAlvo->password = $u->password;
                break;
            };
        };

        if ($usuarioAlvo == null) 
            return response()->json(['message' => 'USUARIO NAO ENCONTRADO'],400);

        $usuarioAlvo->update($request->all());

        return response()->json([
                'message' => 'USUARIO ATUALIZADO',
                'usuario' => $usuarioAlvo
            ], 200);
        */

        return response()->json(['METODO NAO IMPLEMENTADO NESTE EXEMPLO'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function destroy(Usuario $usuario)
    {
        /*
        $usuario->delete();

        return response()->json([
                'message' => 'USUARIO REMOVIDO',
                'usuario' => $usuario
            ], 200);
        */

        return response()->json(['METODO NAO IMPLEMENTADO NESTE EXEMPLO'], 200);
    }
}
