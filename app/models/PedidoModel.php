<?php
    namespace Models;
    use \Illuminate\Database\Eloquent\Model;

    class PedidoModel extends Model
    {
        protected $table = 'pedido';
        protected $fillable = ['total', 'prazo', 'id_cliente', 'codigo_rastreamento'];
        public $timestamps = false;

        public function produto() {
            return $this->belongsToMany('Models\ProdutoModel');
        }

        public function cliente() {
            return $this->belongsTo('Models\ClienteModel');
        }
    }
?>