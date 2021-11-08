<?php 
class Product extends Controller{

    public $data = [];

    public function index()
    {
        echo "Danh sách sản phẩm";
    }
    public function list_product()
    {
       $product = $this->model('ProductModel');
       $dataProduct = $product->getProductList();
       
       $title = "Danh sách sản phẩm: ";

       $this->data['sub_content']['product_list'] = $dataProduct;
       $this->data['page_title'] = $title;
       $this->data['page_title']= $title;
       $this->data['content'] = 'products/list';

       //render view
       $this->render('products/list',$dataProduct);
    }
    public function detail($id = 0)
    {
        $product = $this->model('ProductModel');
        $this->data['sub_content']['info'] = $product->getDetail($id);
        $this->data['sub_content']['title'] = 'Chi tiết sản phẩm';
        $this->data['content'] = 'products/detail';
        $this->data['page_title'] = "Chi tiết sản phẩm";
        $this->render('layouts/client_layout', $this->data);
    }
}
?>