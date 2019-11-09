<?php
    namespace Models;
    use \Illuminate\Database\Eloquent\Model;

    class ImagemModel extends Model
    {
        protected $table = 'imagem';
        public $timestamps = false;

        public function produto() {
            return $this->belongsTo('Models\ProdutoModel', 'id', 'id_produto');
        }
    }
?>