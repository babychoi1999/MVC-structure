<?php 
class Controller{
    public function model($model){
        if(file_exists('./app/Models/'.$model.'.php')){
            require_once './app/Models/'.$model.'.php';
            if(class_exists($model)){
                $model = new $model();
                return $model;
            }
        return false; 
        }
    }   
    public function render($view, $data=[])
    {
        extract($data); //Chuyển key của mảng thành 1 biến
        if(file_exists('./app/Views/'.$view.'.php')){
            require_once './app/Views/'.$view.'.php';
        }
    }
}
?>