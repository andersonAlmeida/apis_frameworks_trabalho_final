<?php
    namespace Models;
    use \Illuminate\Database\Eloquent\Model;

    class ProdutoModel extends Model
    {
        protected $table = 'produto';
        // protected $fillable = ['preco', 'nome', 'descricao', 'desconto', 'estoque', 'id_marca', 'id_categoria', 'ativo'];
        public $timestamps = false;
        protected $primaryKey = 'id';

        public function categoria() {
            return $this->hasOne('Models\CategoriaModel', 'id', 'id_categoria');
        }

        public function marca() {
            return $this->hasOne('Models\MarcaModel', 'id', 'id_marca');
        }

        public function fornecedor() {
            return $this->hasOne('Models\FornecedorModel', 'id', 'id_fornecedor');
        }

        public function imagem() {
            return $this->hasMany('Models\ImagemModel', 'id_produto');
        }
    }
?>