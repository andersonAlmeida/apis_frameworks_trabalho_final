<?php
namespace Controllers;

use Models\PedidoModel;
use Models\ProdutoModel;
use Models\ProdutoPedidoModel;
use \stdClass;
// use \Firebase\JWT\JWT;

class PedidoController {
    public function __construct() {}

    public static function inserir($request, $response, $args){
        $p = $request->getParsedBody();
        $dados = [];
        $produtos = null;

        foreach($p as $key => $value) {
            if( empty($value) ) $value = null;

            if ($key == "produtos") {
                $produtos = $value;
            } else {
                $dados[$key] = $value;
            }
        }

        $pedido = PedidoModel::create($dados);

        foreach($produtos as $key => $value) {

            $pedido_produto = [
                "id_pedido" => $pedido["id"],
                "id_produto" => $value["id"],
                "quantidade" => $value["quantidade"]
            ];

            echo "Quantidade >>> \n";
            var_dump($value["quantidade"]);

            echo "id >>> \n";
            var_dump($pedido["id"]);

            // atualiza o estoque do produto
            ProdutoModel::where('id', $value["id"])->decrement('estoque', $value["quantidade"]);

            ProdutoPedidoModel::create($pedido_produto);
        }

        return $response->withJson($pedido, 201);
    }

    public static function listar( $request, $response, $args ) {
        $id = intval($args['id']);
        $pedidos = PedidoModel::where('id_cliente', $id)->get();

        return $response->withJson($pedidos, 200);
    }

    public static function buscarPorId($request, $response, $args) {
        $id = $args['id'];

        try {
            $produto = PedidoModel::find($id);

            return $response->withJson($produto, 200);
        } catch(Exception $e) {
            echo 'Exceção capturada: ',  $e->getMessage(), "\n";
        }
    }
}

?>