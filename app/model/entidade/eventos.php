<?php 

namespace App\model\entidade;

use \WilliamCosta\DatabaseManager\Database;

class eventos {

    // public $id;

    // public $nome;

    // public $mensagem;

    public function cadastrar() {

        // Pode ser usado timestamp no banco
        // $this->data = date("Y-m-d H:i:s");

        // Inserindo informações da inscrição nos eventos
        $this->id = (new Database('tbleventos'))->insert([
            'NOME_EVENTO' => $this->nome,
            'DESCRICAO_EVENTO' => $this->descricao,
            'VALOR_EVENTO' => $this->valor,
            'CARGA_HORARIA' => $this->carga_horaria,
            'DATA_EVENTO' => $this->data = date("Y-m-d H:i:s"),
        ]);

        return true;

        //    echo '<pre>';
        //    print_r($this);
        //    echo '</pre>';
        //    exit(); 

    }

    // Reponsavel pelo retorno das incrições '*' pegar todos os campos
    public static function getEventos($where = null, $order = null, $limit = null, $field = '*') {
        return (new Database('tbleventos'))->select($where,$order,$limit,$field);
    }

}

?>