<?php 
class Route{
    function handleRoute($url){
        // Xử lý rewrite url
       global $routes;
       $url = trim($url, "/"); //xóa ký tự / ở 2 đầu chuỗi

       if(empty($url)){
           $url = '/';
       }
       
       $handleUrl = $url;
       if(!empty($routes)){
           foreach($routes as $key=>$value){
               if(preg_match('~'.$key.'~is', $url)){ 
                 $handleUrl = preg_replace('~'.$key.'~is', $value, $url); //Thay thế giá trị của key thành value
               }
           }
       }
       return $handleUrl;
    }
}
?>