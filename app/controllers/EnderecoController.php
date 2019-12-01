<?php
namespace Controllers;

use Models\EnderecoModel;
use \Firebase\JWT\JWT;

class EnderecoController {
    public function __construct() {}

    public static function listar( $request, $response, $args ) {
        $id = $args['id'];

        $clientes = EnderecoModel::where('id_proprietario', $id)->get();

        return $response->withJson($clientes, 200);
    }

    public static function inserir($request, $response, $args){
        $p = $request->getParsedBody();
        $nome = $p['nome'];
        $idCliente = intval($p['idCliente']);
        $cep = $p['cep'];
        $logradouro = $p['logradouro'];
        $numero = intval($p['numero']);
        $bairro = $p['bairro'];
        $cidade = $p['cidade'];
        $estado = $p['estado'];
        $tipo = 1;

        $userData = [
            'nome' => $nome,
            'id_proprietario' => $idCliente,
            'cep' => $cep,
            'logradouro' => $logradouro,
            'numero' => $numero,
            'bairro' => $bairro,
            'cidade' => $cidade,
            'estado' => $estado,
            'tipo' => $tipo
        ];

        $endereco = EnderecoModel::create($userData);
        return $response->withJson($endereco, 201);
    }

    public static function atualizar($request, $response, $args) {
        $p = $request->getParsedBody();
        $nome = $p['nome'];
        $cep = $p['cep'];
        $logradouro = $p['logradouro'];
        $numero = intval($p['numero']);
        $bairro = $p['bairro'];
        $cidade = $p['cidade'];
        $estado = $p['estado'];
        $id = $args['id'];
        $idCliente = $args['userid'];

        $data = [
            'nome' => $nome,
            'cep' => $cep,
            'logradouro' => $logradouro,
            'numero' => $numero,
            'bairro' => $bairro,
            'cidade' => $cidade,
            'estado' => $estado
        ];

        try {
            $endereco = EnderecoModel::where('id', $id)
                                    ->where('id_proprietario', $idCliente)
                                    ->update($data);

            return $response->withJson($endereco, 200);
        } catch(Exception $e) {
            echo 'Exceção capturada: ',  $e->getMessage(), "\n";
        }

    }

    public static function buscarPorId($request, $response, $args) {
        $id = $args['id'];
        $idCliente = $args['userid'];

        try {
            $endereco = EnderecoModel::where('id', $id)
                                    ->where('id_proprietario', $idCliente)
                                    ->get();

            return $response->withJson($endereco, 200);
        } catch(Exception $e) {
            echo 'Exceção capturada: ',  $e->getMessage(), "\n";
        }
    }

    public static function deletar($request, $response, $args){
        $id = $args['id'];
        $endereco = EnderecoModel::find($id);

        if( $endereco ) {
            try {
                $endereco->delete();
            }catch(\Illuminate\Database\QueryException $e) {
                return $response->withJson([
                    "resposta" => false,
                    "msg" => $e->getMessage()
                ], 500);
            }
        } else {
            $endereco = new \stdClass();

            $endereco->resposta = false;
            $endereco->msg = "Endereço não encontrada.";
        }

        return $response->withJson($endereco, 200);
    }
}

?>