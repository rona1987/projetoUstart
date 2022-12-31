<?php 

    namespace App\Controller\Pages;

    use \App\utils\view;
    // as = Criado um alias.
    use \App\model\entidade\eventos as entidade_eventos;

    class Eventos extends page {

        // Consultas no banco de dados, obter o render das Eventos
        private static function getEventosLista() {
            $lista = '';
            $result = entidade_eventos::getEventos(null,'DATA_EVENTO DESC');

            while ($eventos = $result->fetchObject(entidade_eventos::class)){
                // echo '<pre>';
                // print_r($eventos);
                // echo '</pre>';
                // exit();

                $lista .= view::render('pages/listas/lista_eventos',[
                    'evento_nome'=> $eventos ->NOME_EVENTO,
                    'evento_descricao'=> $eventos ->DESCRICAO_EVENTO,
                    'evento_valor'=> $eventos ->VALOR_EVENTO,
                    'evento_carga_horaria' => $eventos ->CARGA_HORARIA,
                    'evento_data' => date('d/m/Y H:i:s',strtotime($eventos ->DATA_EVENTO)),
                ]);

            }

            return $lista;
        }
        
        public static function getEventos(){

            $conteudo = view::render('pages/eventos',[
                'lista_eventos'=> self::getEventosLista()
            ]);
            
            return parent::getPage('Eventos',$conteudo);
        }
        // Cadastrar as inscrições
        public static function inserir_eventos($request) {
            // Dados recebidos pelo metodo post
            $postVars = $request->getPostvars();

            // echo '<pre>';
            // print_r($postVars);
            // echo '</pre>';
            // exit();

            $eventos = new entidade_eventos;

            // Recomendado fazer validações se o dado vier inconsistente.
            $eventos->nome = $postVars['nome'];
            $eventos->descricao = $postVars['descricao'];
            $eventos->valor = $postVars['valor'];
            $eventos->carga_horaria = $postVars['carga_horaria'];
            $eventos->data = $postVars['data'];

            $eventos->cadastrar();

            // echo '<pre>';
            // print_r($postVars);
            // echo '</pre>';
            // exit();
            
            return self::getEventos();
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

