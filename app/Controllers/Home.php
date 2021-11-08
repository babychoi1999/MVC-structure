<?php 
class Home extends Controller{
    public $model;
    public function __construct()
    {
        $this->model = $this->model('HomeModel');
    }
    public function index(){
        // $data = $this->model->getUserList();
        // $data1 = $this->model->find(3);
        // print_r($data);
        // $data = [
        //     'name'=>'Thanh',
        //     'email'=>'Thanh@gmail.com',
        //     'password'=>md5('123'),
        //     'created_at'=>date('Y-m-d h:i:sa'),
        //     'updated_at'=>date('Y-m-d h:i:sa')
        // ];
        // $data = [
        //     'name'=>'Quang Thanh',
        //     'email'=>'Quangthanh@gmail.com'
        // ];
        $data = $this->model->getUserDetail();
        print_r($data);
        // $this->model->insertUser($data);
    }
}
?>