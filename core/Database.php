<?php 
class Database{
    private $conn;

    use QueryBuilder;
    
    function __construct()
    {

        // Kết nối database
        global $db_config;
        $this->conn = Connection::getInstance($db_config);
        
        
    }
    function insertData($table, $data){
        if(!empty($data)){
            $fieldStr = '';
            $valueStr = '';
            foreach($data as $key=>$value){
                $fieldStr .= $key . ',';
                $valueStr .= "'" . $value . "',";
            }
            $fieldStr = rtrim($fieldStr, ',');
            $valueStr = rtrim($valueStr, ',');

            $sql = "INSERT INTO $table($fieldStr) VALUES ($valueStr)";

            $status = $this->query($sql);

            if($status){
                return true;
            }
        }
        return false;
    }
    function updateData($table, $data, $condition = ''){
        if(!empty($data)){
            $updateStr = '';
            foreach($data as $key=>$value){
                $updateStr.="$key='$value',";
            }

            $updateStr = rtrim($updateStr, ',');

            if(!empty($condition)){
                $sql = "UPDATE $table SET $updateStr WHERE $condition";
            }else{
                $sql = "UPDATE $table SET $updateStr";
            }

            $status = $this->query($sql);

            if($status){
                return true;
            }
        }
        return false;
    }
    function deleteData($table, $condition=''){
        if(!empty($condition)){
            $sql = "DELETE FROM $table WHERE $condition";
        }else{
            $sql = "DELETE FROM $table";
        }
        $status = $this->query($sql);
        if($status){
            return true;
        }
        return false;
    }
    
    function query($sql){
        try {
            $statement = $this->conn->prepare($sql);
            $statement->execute();
            return $statement;
        } catch (Exception $exception) {
            $mess = $exception->getMessage();
            $data['message'] = $mess; //truyền mess vào hàm loadError()
            App::$app->loadError('database', $data); // Gọi phương thức loadError trong class App
            die();
        }
        
        
    }
    // Trả về id mới nhất sau khi đã insert
    function lastInsertId(){
        return $this->conn->lastInsertId();
    }
}
?>