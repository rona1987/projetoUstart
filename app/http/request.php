<?php 
    namespace App\http;

    class Request {
        private $httpMethod;

        private $uri;

        private $query_Params = [];

        private $postVars = [];

        private $headers = [];

        public function __construct() {
            $this->queryParams = $_GET ?? [];
            $this->postVars = $_POST ?? [];
            $this->headers = getallheaders();
            $this->httpMethod = $_SERVER['REQUEST_METHOD'] ?? '';
            $this->uri = $_SERVER['REQUEST_URI'] ?? '';
        }

        public function getHttpMethod() {
            return $this->httpMethod;
        }

        public function getUri() {
            return $this->uri;
        }

        public function getQuery_Params() {
            return $this->query_Params;
        }

        public function getpostVars() {
            return $this->postVars;
        }

        public function getHeaders() {
            return $this->headers;
        }
    }
?>