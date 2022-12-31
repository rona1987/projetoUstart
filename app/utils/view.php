<?php 

    namespace App\utils;    

    class view{

        // Variaveis padroes da view
        private static $vars = [];

        // Definir dados inicias das classes
        public static function init($vars = []){
            self::$vars = $vars;
        }
        
        //Retornar conteudo da View
        private static function getContentView($view) {
            $file = __DIR__ .'/../../resources/view/' .$view.'.html';
            return file_exists($file) ? file_get_contents($file) : 'Não encontrou o conteudo';
        }

        //Retornar conteudo renderizado da View
        public static function render($view, $vars = []) {
            $contentView = self::getContentView($view);

            // Array_merge = Para unir as duas variaveis
            // Pegando o vars padrão e o que vem das classes
            $vars = array_merge(self::$vars,$vars);
        
            $keys = array_keys($vars);
            $keys = array_map(function($item){
                return '{{'.$item.'}}';
            },$keys);

            return str_replace($keys,array_values($vars),$contentView);
        }
    }
?>