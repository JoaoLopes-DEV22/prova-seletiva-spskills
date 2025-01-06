<?php

namespace App\Http\Controllers;

use App\Models\Prova;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;

class ProvaController extends Controller
{
    public function store(Request $request)
    {
        // Pega o token do header Authorization
        $token = $request->bearerToken();

        // Se o token vier vazio, retorna o erro ao usuário
        if (!$token) {
            return response()->json([
                'mensagem' => 'Usuário inválido'
            ]);
        }

        // Tenta encontrar o token na tabela
        $accessToken = PersonalAccessToken::findToken($token);

        // Se não encontrar, retorna o erro para o usuário
        if (!$accessToken) {
            return response()->json([
                'mensagem' => 'Usuário inválido'
            ]);
        }

        // Validação dos dados vindo do body
        $credentials = Validator::make($request->all(), [
            'dificuldade' => 'required',
            'quantidade_questoes' => 'required',
            'materias' => 'required|array'
        ]);

        // Se houver algum erro na validação, retorna o erro
        if ($credentials->fails()) {
            return response()->json([
                'mensagem' => 'Erro ao cadastrar, verifique os dados'
            ], 422);
        }

        // Transforma os dados vindo do array materias em JSON
        $materias = json_encode($request->materias, JSON_UNESCAPED_UNICODE);

        // Insere os dados da prova no banco de dados
        $prova = Prova::create([
            'dificuldade' => $request->dificuldade,
            'quantidade_questoes' => $request->quantidade_questoes,
            'materias' => $materias
        ]);

        // Retorna os dados da prova
        return response()->json([
            'id' => $prova->id,
            'finalizada' => false,
            'dificuldade' => $prova->dificuldade,
            'quantidade_questoes' => $prova->quantidade_questoes,
            'materias' => json_decode($prova->materias),
            'created_at' => $prova->created_at->format('d/m/Y H:i:s')
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        // Pega o token vindo do header Authorization
        $token = $request->bearerToken();

        // Se o token vier vazio, retorna o erro ao usuário
        if (!$token) {
            return response()->json([
                'mensagem' => 'Usuário inválido'
            ]);
        }

        // Tenta encontrar o token na tabela
        $accessToken = PersonalAccessToken::findToken($token);

        // Se não encontrar, retorna o erro ao usuário
        if (!$accessToken) {
            return response()->json([
                'mensagem' => 'Usuário inválido'
            ]);
        }

        // Se encontrar a prova com o id fornecido
        $prova = Prova::find($id);

        // Muda o status de false para true
        $prova->finalizada = "true";

        // Faz a alteração no banco
        $prova->save();

        // Retorna a mensagem de sucesso para o usuário
        return response()->json([
            'mensagem' => 'Prova finalizada com sucesso'
        ]);
    }

    public function showById(Request $request, $id)
    {
        // Pega o token vindo do header Authorization
        $token = $request->bearerToken();

        // Se o token vier vazio, retorna o erro ao usuário
        if (!$token) {
            return response()->json([
                'mensagem' => 'Usuário inválido'
            ]);
        }

        // Tenta encontrar o token na tabela
        $accessToken = PersonalAccessToken::findToken($token);

        // Se não encontrar, retorna o erro ao usuário
        if (!$accessToken) {
            return response()->json([
                'mensagem' => 'Usuário inválido'
            ]);
        }

        // Tenta encontrar a prova através do id fornecido
        $prova = Prova::find($id);

        // Se não encontrar a prova, retorna o erro ao usuário
        if (!$prova) {
            return response()->json([
                'mensagem' => 'ID da prova inválido'
            ]);
        }

        // Se encontrar, retorna todos os dados da prova selecionada ao usuário
        return response()->json([
            'id' => $prova->id,
            'dificuldade' => $prova->dificuldade,
            'quantidade_questoes' => $prova->quantidade_questoes,
            'finalizada' => $prova->finalizada,
            'materias' => json_decode($prova->materias),
            'created_at' => $prova->created_at->format('d/m/Y H:i:s'),
            'updated_at' => $prova->updated_at->format('d/m/Y H:i:s')
        ]);
    }
}
