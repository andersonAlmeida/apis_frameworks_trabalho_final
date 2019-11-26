<?php
namespace Controllers;

use Models\ProdutoModel;
use \stdClass;
// use \Firebase\JWT\JWT;

class ProdutoController {
    public function __construct() {}

    public static function listar( $request, $response, $args ) {
        $produtos = ProdutoModel::with(['categoria', 'marca', 'imagem', 'fornecedor'])->orderBy('id')->get();

        foreach ($produtos as $produto) {
            if (count($produto->imagem) > 0) {
                $path = "https://apis-frameworks-admin.herokuapp.com/_assets/uploads/" . $produto->imagem[0]->imagem;
                $produto->imagem[0]->imagem = $path;
            }
        }

        return $response->withJson($produtos, 200);
    }

    public static function buscarPorId($request, $response, $args) {
        $id = $args['id'];

        try {
            $produto = ProdutoModel::find($id);

            return $response->withJson($produto, 200);
        } catch(Exception $e) {
            echo 'Exceção capturada: ',  $e->getMessage(), "\n";
        }
    }
}

?>