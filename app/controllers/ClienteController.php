<?php
namespace Controllers;

use Models\ClienteModel;
use \Firebase\JWT\JWT;

class ClienteController {
    public function __construct() {}

    // public static function listar( $request, $response, $args ) {
        //     $clientes = ClienteModel::all();

        //     return $response->withJson($clientes, 200);
        // }

    public static function inserir($request, $response, $args){
        $p = $request->getParsedBody();
        $nome = $p['nome'];
        $sobrenome = $p['sobrenome'];
        $email = $p['email'];
        $cpf = $p['cpf'];
        $rg = $p['rg'];
        $nascimento = $p['nascimento'];
        $senha = password_hash($p['senha'], PASSWORD_DEFAULT); // criptografa a senha do Cliente para salvar no banco


        if( ClienteController::verificaEmail($email) == NULL ) { // verifica se o email já foi cadastrado
            $cliente = ClienteModel::create([
                'nome' => $nome,
                'sobrenome' => $sobrenome,
                'email' => $email,
                'senha' => $senha,
                'cpf' => $cpf,
                'rg' => $rg,
                'nascimento' => $nascimento
            ]);
            return $response->withJson($cliente, 201);
        } else {
            return $response->withJson([
                "resposta" => false,
                "msg" => "E-mail já cadastrado"
            ], 200);
        }

    }

    public static function verificaEmail($email) {
        return ClienteModel::where('email', $email)->first();
    }

    public static function atualizar($request, $response, $args) {
        $p = $request->getParsedBody();
        $id = $args['id'];
        $nome = $p['nome'];
        $sobrenome = $p['sobrenome'];
        $email = $p['email'];
        $cpf = $p['cpf'];
        $rg = $p['rg'];
        $nascimento = $p['nascimento'];
        $senha = password_hash($p['senha'], PASSWORD_DEFAULT); // criptografa a senha do Cliente para salvar no banco

        try {
            $cliente = ClienteModel::find($id);

            $cliente->nome = $nome;
            $cliente->sobrenome = $sobrenome;
            $cliente->email = $email;
            $cliente->senha = $senha;
            $cliente->cpf = $cpf;
            $cliente->rg = $rg;
            $cliente->nascimento = $nascimento;

            $cliente->save();

            return $response->withJson($cliente, 200);
        } catch(Exception $e) {
            echo 'Exceção capturada: ',  $e->getMessage(), "\n";
        }

    }

    public static function buscarPorId($request, $response, $args) {
        $id = $args['id'];

        try {
            $cliente = ClienteModel::find($id);

            return $response->withJson($cliente, 200);
        } catch(Exception $e) {
            echo 'Exceção capturada: ',  $e->getMessage(), "\n";
        }
    }

    // public static function deletar($request, $response, $args){
        //     $id = $args['id'];
        //     $cliente = ClienteModel::find($id);

        //     if( $cliente ) {
        //         $cliente->delete();
        //     } else {
        //         $cliente = new \stdClass();

        //         $cliente->resposta = false;
        //         $cliente->msg = "Usuário não encontrado.";
        //     }

        //     return $response->withJson($cliente, 200);
        // }

    public static function login($request, $response, $args, $sKey) {
        $p = $request->getParsedBody();
        $cliente = ClienteModel::where('email', $p['email'])->get();

        foreach ($cliente as $c) {
            if( password_verify( $p['senha'], $c->senha ) ) {
                $token = array(
                    'user' => strval($c->id),
                    'nome' => $c->nome
                );

                $jwt = JWT::encode($token, $sKey);

                return $response->withJson(["token" => $jwt], 201)
                    ->withHeader('Content-type', 'application/json');
            } else {
                return $response->withJson(["resposta"=> false, "msg" => "Usuário ou senha inválidos"], 200);
            }
        }

    }
}

?>