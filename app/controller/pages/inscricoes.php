<?php 

    namespace App\Controller\Pages;

    use \App\utils\view;
    // as = Criado um alias.
    use \App\model\entidade\inscricoes as entidade_inscricoes;

    class Inscricoes extends page{

        // Consultas no banco de dados, obter o render das inscricoes
        private static function getInscricoesLista() {
            $lista = '';
            $result = entidade_inscricoes::getInscricoes(null,'CODIGO_INSCRICAO DESC');
            while ($inscricao = $result->fetchObject(entidade_inscricoes::class)){
                // echo '<pre>';
                // print_r($inscricao);
                // echo '</pre>';
                // exit();

                $lista .= view::render('pages/listas/lista_inscricoes',[
                    'inscricao_nome'=> $inscricao ->NOME_PARTICIPANTE,
                    'inscricao_cpf'=> $inscricao ->CPF_PARTICIPANTE,
                    // 'inscricao_evento'=> $inscricao ->evento,
                    'inscricao_data' => date('d/m/Y H:i:s',strtotime($inscricao ->DATA_INSCRICAO)),
                ]);
            }

            return $lista;
        }
        
        public static function getInscricoes(){

            $conteudo = view::render('pages/inscricoes',[
                'lista_inscricoes'=> self::getInscricoesLista()
            ]);
            
            return parent::getPage('Inscricoes',$conteudo);
        }
        // Cadastrar as inscrições
        public static function inserir_inscricoes($request) {
            // Dados recebidos pelo metodo post
            $postVars = $request->getPostvars();

            $inscricao = new entidade_inscricoes;

            // Recomendado fazer validações se o dado vier inconsistente.
            $inscricao->nome = $postVars['nome'];
            $inscricao->cpf = $postVars['cpf'];
            $inscricao->evento = $postVars['evento'];

            $inscricao->cadastrar();

            // echo '<pre>';
            // print_r($postVars);
            // echo '</pre>';
            // exit();
            
            return self::getInscricoes();
        }
    }

    // class Home extends page{
    //     public static function getHome(){
    //         $conteudo = view::render('pages/home',[
    //             'nome'=> 'U-Start',
    //             'sala' =>'io7lc5m'
    //         ]);
    //         return parent::getPage('U-Start 02',$conteudo);
    //     }
    // }

    // class Home{
    //     public static function getHome(){
    //         return "Hello World";
    //     }
    // }

?>

