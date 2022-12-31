<?php 

namespace App\model\entidade;

use \WilliamCosta\DatabaseManager\Database;

class inscricoes {

    public $id;

    public $nome;

    public $mensagem;

    public function cadastrar() {

        // Pode ser usado timestamp no banco
        // $this->data = date("Y-m-d H:i:s");

        // Inserindo informações da inscrição nos eventos
        $this->id = (new Database('tblinscricao'))->insert([
            'NOME_PARTICIPANTE' => $this->nome,
            'CPF_PARTICIPANTE' => $this->cpf,
            // 'evento' => $this->evento,
        ]);

        return true;

        //    echo '<pre>';
        //    print_r($this);
        //    echo '</pre>';
        //    exit(); 

    }

    // Reponsavel pelo retorno das incrições '*' pegar todos os campos
    public static function getInscricoes($where = null, $order = null, $limit = null, $field = '*') {
        return (new Database('tblinscricao'))->select($where,$order,$limit,$field);
    }

}

?>