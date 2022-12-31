<?php 

    namespace App\Controller\Pages;

    use \App\utils\view;
    use \App\model\entidade\empresa;

    class sobre extends page{
        
        public static function getSobre(){
            $empresa = new empresa;

            $conteudo = view::render('pages/sobre',[
                'nome'=> $empresa->nome,
                'descricao' => $empresa->descricao,
                'site' => $empresa->site
            ]);
            return parent::getPage('Sobre',$conteudo);
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

