<?php 
define('_DIR_ROOT', __DIR__);
//Xử lý http root
if(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on'){ //Lấy tên host
    $web_root = 'https://'.$_SERVER['HTTP_HOST'];
}
else{
    $web_root = 'http://'.$_SERVER['HTTP_HOST'];
}
$folderArr = explode("/", $_SERVER['REQUEST_URI']); //Lấy tên project($folderArr[1])
$web_root = $web_root.'/'.$folderArr[1];

define('_WEB_ROOT', $web_root); //Tạo web root: http://localhost/MVC

/**
 * Tự động load config
 * 
*/
$config_dir = scandir('configs'); // Trả về các file trong folder config

if(!empty($config_dir)){
    foreach($config_dir as $item){
        if($item != '.' && $item != '..' && file_exists('./configs/'.$item)){
            require_once './configs/'.$item;
        }
    }
} 

require_once './core/Route.php'; // Load Route class
require_once "./core/App.php"; //load app 


//Kiểm tra config và load database
if(!empty($config['database'])){
    $db_config = array_filter($config['database']);
    
    if(!empty($db_config)){
        require_once './core/Connection.php';
        require_once './core/QueryBuilder.php';
        require_once './core/Database.php';
        
    }
}

require_once "./core/Model.php"; //load Base Model

require_once "./core/Controllers.php"; //load base controller
?>