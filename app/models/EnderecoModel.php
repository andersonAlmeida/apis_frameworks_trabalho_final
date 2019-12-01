<?php
    namespace Models;
    use \Illuminate\Database\Eloquent\Model;

    class EnderecoModel extends Model
    {
        protected $table = 'endereco';
        public $timestamps = false;
        protected $fillable = ['nome', 'logradouro', 'cep', 'bairro', 'cidade', 'tipo', 'id_proprietario', 'numero', 'estado'];

        public function cliente() {
            return $this->belongsTo('Models\ClienteModel');
        }
    }
?>