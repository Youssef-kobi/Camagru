<?php
/*
    Base Controller
    Loads the model and views


*/

class Controller{
     //load model
    public function model($model){
        // require model files ?? doesnt that needs to be checked first ? oO
        require_once '../app/models/' . $model . '.php';
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