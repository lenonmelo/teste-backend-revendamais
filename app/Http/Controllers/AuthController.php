<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    /**
     * Efetua o login do usuário.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $data = $request->all();
        if (Auth::attempt($data)) {
            return response()->json([
                'status' => 'Autorizado',
                'token' => $request->user()->createToken('revendamais')->plainTextToken
            ])->setStatusCode(200);
        }

        return response()->json(['status' => 'Não autorizado'])->setStatusCode(401);
    }

    /**
     * Desconecta o usuário, revogando o token de acesso atual.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['Token revogado'])->setStatusCode(200);
    }
}
