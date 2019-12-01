<?php
    namespace Models;
    use \Illuminate\Database\Eloquent\Model;

    class ProdutoPedidoModel extends Model
    {
        protected $table = 'produto_pedido';
        protected $fillable = ['id_pedido', 'id_produto', 'quantidade'];
        public $timestamps = false;

        // public function pedido() {
        //     return $this->hasMany('Models\PedidoModel', 'id_pedido');
        // }

        // public function produto() {
        //     return $this->hasMany('Models\ProdutoModel', 'id_produto')->select(['nome', 'imagem']);
        // }
    }
?>