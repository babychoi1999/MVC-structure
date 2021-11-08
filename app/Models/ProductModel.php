<?php 
class ProductModel{
    public function getProductList()
    {
        return [
            'sản phẩm 1',
            'sản phẩm 2',
            'sản phẩm 3'
        ];
    }
    public function getDetail($id)
    {
        $data = [
            'sản phẩm 1',
            'sản phẩm 2',
            'sản phẩm 3'
        ];
        return $data[$id];
    }
}
?>