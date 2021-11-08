<?php 
class App{
    private $controller, $action, $params, $routes;

    static public $app;
    
    function __construct()
    {
        global $config;

        self::$app = $this; //Gán class App vào thuộc tính static $app

        $this->routes = new Route();
        $this->controller = "home";
        $this->action = "index";
        $this->params = [];
        $this->handleUrl();
    }
    function getUrl(){
        if(!empty($_SERVER['PATH_INFO'])){
            $url = $_SERVER['PATH_INFO'];
        }else{
            $url = "/";
        }
        return $url;
    }
    public function handleUrl(){

        
        $url = $this->getUrl();

        $url = $this->routes->handleRoute($url); //gọi hàm Xử lý(rewrite) url

        $urlArr =  array_filter(explode("/", $url));
        $urlArr = array_values($urlArr);

        $urlCheck = '';
        
        // Xử lý controllers
        if(!empty($urlArr)){
            foreach($urlArr as $key=>$item){
                $urlCheck.=$item.'/'; //Nối đường dẫn vào biến $urlCheck
                $fileCheck = rtrim($urlCheck, '/'); //Xóa dấu / bên phải $url
                $fileArr = explode('/', $fileCheck);
                $fileArr[count($fileArr) - 1] = ucfirst($fileArr[count($fileArr) - 1]); //Đổi chữ cái đầu của tên file thành chữ in hoa
                $fileCheck = implode('/', $fileArr);
                echo $fileCheck.'<br/>' ;

                if(!empty($urlArr[$key - 1])){
                    unset($urlArr[$key - 1]); // Xóa folder trong mảng url
                }
                
                if(file_exists("./app/Controllers/".$fileCheck.".php")){
                    $urlCheck = $fileCheck;
                    break;
                }
            }
        }
        $urlArr = array_values($urlArr);
        
        
        if(!empty($urlArr[0])){
            $this->controller = ucfirst($urlArr[0]); // ucfirst chuyển ký tự đầu tiên thành hoa
        }else{
            $this->controller = ucfirst($this->controller);
        }

        if(empty($urlCheck)){
            $urlCheck = $this->controller;
        }

        if(file_exists("./app/Controllers/".$urlCheck.".php")){
            require_once "./app/Controllers/".$urlCheck.".php";

            //Kiểm tra class $this->controller tồn tại

            if(class_exists($this->controller)){
                $this->controller = new $this->controller();
                unset($urlArr[0]);
            }else{
                $this->loadError();
            }
           
        }else{
            $this->loadError();
        }

        //Xử lý action
        if(!empty($urlArr[1])){
            $this->action = $urlArr[1];
            unset($urlArr[1]);
        }

        //Xử lý params
        $this->params = array_values($urlArr);
        call_user_func_array( [$this->controller,$this->action] ,$this->params);
    }
    public function loadError($name = '404', $data = []){
        extract($data); //Chuyển key của $data thành một biến!
        require_once "./app/Errors/".$name.".php";
    }
}
?>