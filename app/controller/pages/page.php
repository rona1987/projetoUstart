<?php 

    namespace App\Controller\Pages;

    use \App\utils\view;

    class Page{

        private static function getHeader(){
            return view::render('pages/header');
        }

        private static function getFooter(){
            return view::render('pages/footer');
        }

        public static function getPage($titulo,$conteudo) {
            return view::render('pages/page',[
                'titulo' => $titulo,
                'header' => self::getHeader(),
                'footer' => self::getFooter(),
                'conteudo' => $conteudo,
            ]);
        }
    }

?>