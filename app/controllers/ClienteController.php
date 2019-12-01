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
        $fbId = $p['fbid'];
        $senha = password_hash($p['senha'], PASSWORD_DEFAULT); // criptografa a senha do Cliente para salvar no banco

        if( ClienteController::verificaEmail($email) == NULL ) { // verifica se o email já foi cadastrado
            $userData = [
                'nome' => $nome,
                'sobrenome' => $sobrenome,
                'email' => $email,
                'senha' => $senha,
                'cpf' => $cpf
            ];

            if (isset($rg)) {
                $userData['rg'] = $rg;
            }
            if (isset($nascimento)) {
                $userData['nasi$nascimento'] = $nascimento;
            }
            if (isset($fbId)) {
                $userData['fb_id'] = $fbId;
            }

            $cliente = ClienteModel::create($userData);
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
        // $senha = password_hash($p['senha'], PASSWORD_DEFAULT); // criptografa a senha do Cliente para salvar no banco

        try {
            $cliente = ClienteModel::find($id);

            $cliente->nome = $nome;
            $cliente->sobrenome = $sobrenome;
            $cliente->email = $email;
            // $cliente->senha = $senha;
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

    public static function buscarPorIdFb($request, $response, $args, $sKey) {
        $id = $args['fbid'];

        try {
            $cliente = ClienteModel::select('nome', 'sobrenome', 'email', 'id')->where('fb_id', $id)->first();

            if ($cliente) {
                date_default_timezone_set('America/Sao_Paulo');

                $issuedAt = time();

                $token = array(
                    'user' => strval($cliente->id),
                    'name' => $cliente->nome,
                    'date' => date("Y-m-d H:i:s"),
                    'iat' => $issuedAt,
                    'nbf' => $issuedAt,
                    'exp' => $issuedAt + 14400
                );

                $jwt = JWT::encode($token, $sKey);

                return $response->withJson([
                    "token" => $jwt,
                    "nome" => $cliente->nome,
                    "sobrenome" => $cliente->sobrenome,
                    "codigo" => $cliente->id,
                    "email" => $cliente->email
                ], 200)
                    ->withHeader('Content-type', 'application/json');
            }

            // return $response->withJson($cliente, 200);
        } catch(Exception $e) {
            echo 'Exceção capturada: ',  $e->getMessage(), "\n";
        }
    }

    public static function login($request, $response, $args, $sKey) {
        $p = $request->getParsedBody();
        $cliente = ClienteModel::where('email', $p['email'])->get();

        foreach ($cliente as $c) {
            if( password_verify( $p['senha'], $c->senha ) ) {
                date_default_timezone_set('America/Sao_Paulo');

                $issuedAt = time();

                $token = array(
                    'user' => strval($c->id),
                    'name' => $c->nome,
                    'date' => date("Y-m-d H:i:s"),
                    'iat' => $issuedAt,
                    'nbf' => $issuedAt,
                    'exp' => $issuedAt + 14400
                );

                $jwt = JWT::encode($token, $sKey);

                return $response->withJson([
                    "token" => $jwt,
                    "nome" => $c->nome,
                    "sobrenome" => $c->sobrenome,
                    "codigo" => $c->id,
                    "email" => $c->email
                ], 200)
                    ->withHeader('Content-type', 'application/json');
            } else {
                return $response->withJson(["resposta"=> false, "msg" => "Usuário ou senha inválidos"], 200);
            }
        }
    }
}

?>