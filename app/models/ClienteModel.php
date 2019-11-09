<?php
    namespace Models;
    use \Illuminate\Database\Eloquent\Model;

    class ClienteModel extends Model
    {
        protected $table = 'cliente';
        protected $fillable = ['nome', 'sobrenome', 'email', 'senha', 'nascimento', 'cpf', 'rg', 'ativo'];
        public $timestamps = false;
    }
?>