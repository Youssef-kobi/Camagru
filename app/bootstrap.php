<?php
    //load config
    require_once 'config/database.php';
   // require_once 'config/setup.php';
    //load Helpers
        require_once 'helpers/url_helper.php';
        require_once 'helpers/session_helper.php';
    //autoload libraries
    spl_autoload_register(function ($className){
        require_once 'libraries/'. $className .'.php';
    });
?>