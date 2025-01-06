<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;

class UserController extends Controller
{
    public function store(Request $request)
    {
        // Valida os dados vindo do body da requisição
        $credentials = Validator::make($request->all(), [
            'nome' => 'required',
            'username' => 'required|unique:users,email',
            'senha' => 'required'
        ]);

        // Se tiver algum erro de validação retorna o erro
        if ($credentials->fails()) {
            return response()->json([
                'mensagem' => 'Erro ao cadastrar, verifique os dados'
            ], 422);
        }

        // Insere os dados na tabela
        User::create([
            'name' => $request->nome,
            'email' => $request->username,
            'password' => $request->senha
        ]);

        // Retorna mensagem de erro ao usuário
        return response()->json([
            'mensagem' => 'Cadastro realizado com sucesso'
        ]);
    }
}
