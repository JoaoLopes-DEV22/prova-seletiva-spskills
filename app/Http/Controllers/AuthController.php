<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    public function auth(Request $request)
    {
        // Valida os dados vindo do body da requisição
        $credentials = Validator::make($request->all(), [
            'username' => 'required',
            'senha' => 'required'
        ]);

        // Se houver erro na validação, retorna o erro ao usuário
        if ($credentials->fails()) {
            return response()->json([
                'mensagem' => 'Erro ao cadastrar, verifique os dados'
            ], 422);
        }

        // Altera o nome das credenciais para utilizar o método Auth
        $credentials = [
            'email' => $request->input('username'),
            'password' => $request->input('senha')
        ];

        // Se não conseguir autenticar, retorna que as credenciais são incorretas
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'mensagem' => 'Dados incorretos'
            ]);
        }

        // Seleciona o usuário através do email
        $user = User::where('email', $credentials['email'])->first();

        // Retorna o token do usuário autenticado
        return response()->json([
            'token' => $user->createToken("API")->plainTextToken
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function logout(Request $request)
    {
        // Pega o token vindo da url
        $token = $request->query('token');

        // Se  o token vier vazio, retorne o erro ao usuário
        if (!$token) {
            return response()->json([
                'mensagem' => 'Usuário inválido'
            ]);
        }

        // Se vier o token, vai tentar encontrar na tabela
        $accessToken = PersonalAccessToken::findToken($token);

        // Se o token não for validado, retorna o erro ao usuário
        if (!$accessToken) {
            return response()->json([
                'mensagem' => 'Usuário inválido'
            ]);
        }

        // Deleta o token da tabela
        $accessToken->delete();

        // Retorna mensagem de sucesso
        return response()->json([
            'mensagem' => 'Logout realizado com sucesso'
        ]);
    }
}
