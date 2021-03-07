<?php
/*
    Base Controller
    Loads the model and views


*/

class Controller{
     //load model
    public function model($model){
        
        require_once '../app/models/' . $model . '.php';
        require_once '../app/config/setup.php';
        //instantiate model
        return new $model();
    }

    public function view($view , $data = []){
        //load views
        if(file_exists('../app/views/' . $view . '.php')){
            require_once '../app/views/' . $view . '.php';
        } else {
            //Views doesnt exist
            die('view doesnt exist');
        }
    }
}
?>