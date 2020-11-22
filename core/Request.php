<?php
    namespace Core;

    class Request{
        private $request;
        private $method;
        private $url;

        public function __construct(){
            session_start();
            $this->request = $_REQUEST;
            $this->method =$_SERVER['REQUEST_METHOD'];
            $this->url = $_SERVER['REQUEST_URI'];
        }

        public function get($name){
            if(isset($this->request[$name])){
                $result = $this->request[$name];
                $result =  filter_var($result, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $result = filter_var($result, FILTER_SANITIZE_ADD_SLASHES);
                return $result;
            }
            else{
                return false;
            }
        }

        public function isPost(){
            return $this->method === "POST"?true:false;
        }

        public function getUrl(){
            return $this->url;
        }

        public function setSessionLogin($id){
            $_SESSION['crt'] = $id;
        }

        public function isSessionLogin(){
            if(isset($_SESSION['crt'])){
                return $_SESSION['crt'];
            }
            else{
                return false;
            }
        }

        public function removeSessionLogin(){
            unset($_SESSION['crt']);
        }
    }