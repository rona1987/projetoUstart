<?php 

    namespace App\http;

    class Response {

        private $http_code = 200;

        private $headers = [];

        private $content_type = 'text/html';

        private $content;

        public function __construct($http_code,$content,$content_type = 'text/html'){
            $this->$http_code = $http_code;
            $this->content = $content;
            $this->setContent_type($content_type);
        }

        public function setContent_type($content_type){
            $this->content_type = $content_type;
            $this->addHeader('content-type', $content_type);
        }
        
        public function addHeader($key,$value) {
            $this->headers[$key] = $value;
        }

        private function send_headers() {
            http_response_code($this->http_code);
            foreach($this->headers as $key=>$value) {
                header($key. ': '.$value);
            }
        }

        public function send_response() {
            $this->send_headers();
            switch ($this->content_type) {
                case 'text/html';
                echo $this->content;
                exit;
            }
        }
    }

?>