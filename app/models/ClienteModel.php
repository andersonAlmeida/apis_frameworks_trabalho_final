<?php
    namespace Models;
    use \Illuminate\Database\Eloquent\Model;

    class ClienteModel extends Model
    {
        protected $table = 'cliente';
        protected $fillable = ['nome', 'sobrenome', 'email', 'senha', 'nascimento', 'cpf', 'rg', 'ativo', 'fb_id'];
        public $timestamps = false;

        public function pedido() {
            return $this->hasMany('Models\PedidoModel');
        }

        public function endereco() {
            return $this->hasMany('Models\EnderecoModel');
        }
    }
?>