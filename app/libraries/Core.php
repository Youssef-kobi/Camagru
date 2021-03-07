<?php
    /*
    App core class 
    this is for creating urls  and load core controller
    URL FORMAT - /controller/method/params 
    */
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);


    class Core{

        protected $currentController = 'Pages';
        protected $currentMethod = 'index';
        protected $params = [];

        public function __construct(){
            $url = $this->getUrl();
            // check if  the first value is in the controllers 
            if(isset($url[0]) &&  file_exists('../app/controllers/' . ucwords($url[0]) .'.php')){
                // if exist set as controller 
                
                $this->currentController = ucwords($url[0]);
                //unset url controller
                unset($url[0]);
            }
             //require the controller
             require_once '../app/controllers/' . $this->currentController . '.php';
            //instantiate the controller class
             $this->currentController = new $this->currentController;
            // check if method exist
            if (isset($url[1]) && method_exists($this->currentController,$url[1])){
                $this->currentMethod = $url[1];
                unset($url[1]);
            }
            //get params
            $this->params = $url ? array_values($url) : [];
            //call a callback 
            call_user_func_array([$this->currentController,$this->currentMethod],$this->params); 
        }

        public function getUrl(){
            if(isset($_GET['url'])){
                $url = rtrim($_GET['url'],'/');
                $url = filter_var($url, FILTER_SANITIZE_URL);
                $url = explode('/', $url);
                return $url;
            }
        }
    }
?>