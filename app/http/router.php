<?php 

    namespace App\http;
    use \closure;
    use \Exception;
    use \ReflectionFunction;

    class Router{
        // uri = final 
        // url = completa

        private $url = '';

        private $prefix = '';

        private $routers = [];

        private $request;

        public function __construct($url) {
            $this->request = new Request($this);
            $this->url = $url;
            $this->set_prefix();          
        }

        private function set_prefix(){
            //URL atual 
            $parse_url = parse_url($this->url);

            $this->prefix = $parse_url['path'] ?? '';
            
        }

        private function add_route($method,$route,$params = []) {
           // Instance of = para verificar se o objeto pertence a classe. Retornando True ou False;
           // Closure = Fechamento, podendo acessar variaveis de escopo externo.
            foreach($params as $key=>$value) {
                if ($value instanceof closure) {
                    $params['controller'] = $value;
                    unset($params[$key]);
                    continue;
                }
            }

            // 
            $params['variaveis'] = [];

            // Pattern variables: Padrão para validar as variaveis.
            // Agrupar as variaveis.
            $variaveis_padrao = '/{(.*?)}/'; 

            //Preg_match_all = Procura um padrão até terminar de processar toda string
            // Variavel $matches = Mostrar o que foi encontrado !!! 
            if (preg_match_all($variaveis_padrao,$route,$matches)) {

                // preg_replace = Usada para pesquisar e substituir o conteudo (Aceita até 5 parametros) (https://acervolima.com/php-funcao-preg_replace/)
                $route = preg_replace($variaveis_padrao,'(.*?)',$route);
                // Variaveis encontradas dentro da rota - Array [1] para trazer sem as chaves
                $params['variaveis'] = $matches[1];
            }

            // Apenas um padrão para validar a url
            $pattern_route = '/^'.str_replace('/','\/',$route).'$/';

            // Adicionar rota dentro da classe
            $this->routers[$pattern_route][$method] = $params;
        }

        public function get($route,$params = []) {
            return $this->add_route('GET',$route,$params);
        }

        public function post($route,$params = []) {
            return $this->add_route('POST',$route,$params);
        }

        public function put($route,$params = []) {
            return $this->add_route('PUT',$route,$params);
        }

        public function delete($route,$params = []) {
            return $this->add_route('DELETE',$route,$params);
        }

        public function get_uri(){
            $uri = $this->request->geturi();

            $x_uri = strlen($this->prefix) ? explode($this->prefix,$uri) : [$uri];
            return end($x_uri);

        }

        public function get_route(){

            $uri = $this->get_uri();

            //Metodo
            $http_method = $this->request->getHttpMethod();

            //Validar Rotas
            foreach ($this->routers as $pattern_route => $methods) {
                //Verifica URL 
                //Preg_match = Procura um padrão na string - retornando true ou false
                if (preg_match($pattern_route,$uri,$matches)){
                    //Verificando metodo
                    // Isset = Verificar se a variavel está definida (declarada) retornando true ou false
                    // Empty = Verificar se a variavel está vazia ou não.
                    if(isset($methods[$http_method])){
                        /* Faça um printr (debbug) Para verificar como está vindo as rotas e entender porque está sendo removido o primeiro array */
                        // Unset = Removendo a primeira posição do array
                        unset($matches[0]);

                        $keys = $methods[$http_method]['variaveis'];
                        $methods[$http_method]['variaveis'] = array_combine($keys,$matches);
                        $methods[$http_method]['variaveis']['request'] = $this->request;

                        //Retorno dos parametros (rota)
                        return $methods[$http_method];
                    }
                    // Exceção, quando passar um método não permitido
                    throw new Exception("Método não permitido", 405);                  
                }
            }
            // Exceção, caso não ache a URL verificada.
            throw new Exception("Url não encontrada", 404);    
        }
        // Retornando e tratando as respostas
        public function run() {

            try {
                // Obter rota atual
                $route = $this->get_route();

                // echo '<pre>';
                // print_r($route);
                // echo '</pre>';
                // exit();

                // Se não existir 
                if(!isset($route['controller'])){
                    throw new Exception("A Url não pode ser processada", 500);                   
                }
                //Argumentos
                $arguments = [];

                $reflection = new ReflectionFunction($route['controller']);

                foreach ($reflection->getParameters() as $parametro) {
                    // Pegando apenas o name 
                    $name = $parametro->getName();
                    // Se existir passa o name, senão fica vazio
                    $arguments[$name] = $route['variaveis'][$name] ?? '';
                }

                // call_user_func_array -> Chamar uma função php existente.
                // Sintaxe - Função como primeiro parametro e em seguida usar a matriz como segundo parametro.
                return call_user_func_array($route['controller'],$arguments);

            } catch (Exception $e) {
                return new response($e->getCode(),$e->getmessage());
            }
        }
    }

?>