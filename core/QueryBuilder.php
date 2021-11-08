<?php
/**
 *  
 */
trait QueryBuilder
{
    public $tableName = '';
    public $where = '';
    public $operator = '';
    public $selectField = '*';
    public $limit = '';
    public $orderBy = '';
    public $groupBy = '';
    public $innerJoin = '';

    public function table($tableName)
    {
        $this->tableName = $tableName; 
        return $this;
    }
    public function where($field, $compare, $value){
            if(empty($this->where)){ 
                $this->operator = ' WHERE ';
            }else{
                $this->operator = ' AND ';
            }

            // if(empty($compare)){
            //     $compare = '=';
            // }
            $this->where .= "$this->operator $field $compare '$value'";
            return $this;
    }
    public function select($field='*'){
        $this->selectField = $field;
        return $this;
    }
    public function limit($number, $offset=0){
        $this->limit = "LIMIT $offset, $number";
        return $this;
    }
    public function orderBy($field, $type='ASC'){
        $fieldArr = array_filter(explode(',', $field));
        if(!empty($fieldArr) && count($fieldArr) >= 2){
            //MULTI ORDER BY
            $this->orderBy = "ORDER BY ".implode(',', $fieldArr);
        }else{
            $this->orderBy = 'ORDER BY '.$field." ".$type;
        }
        return $this;
    }
    public function groupBy($field){
        $fieldArr = array_filter(explode(',', $field));
        if(!empty($fieldArr) && count($fieldArr) >= 2){
            //MULTI GROUP BY
            $this->groupBy = "GROUP BY ".implode(',', $fieldArr);
        }else{
            $this->groupBy = "GROUP BY ".$field;
        }
        echo $this->groupBy;
        return $this;
    }
    // Inner join
    public function join($table, $relationship){
        $this->innerJoin .= 'INNER JOIN '.$table.' ON '.$relationship.' ';
        
        return $this;

    }
    public function insert($data){
        $tableName = $this->tableName;
        $insertStatus = $this->insertData($tableName, $data);
        return $insertStatus;
    }
    public function update($data){
        $tableName = $this->tableName;
        //Xóa where trong $this->where vì updateData() đã có where
        $condition = str_replace('WHERE', '', $this->where);
        $condition = trim($condition);
        $updateStatus = $this->updateData($tableName, $data, $condition);
        return $updateStatus;
    }
    public function delete(){
        $tableName = $this->tableName;
        //Xóa where trong $this->where vì updateData() đã có where
        $condition = str_replace('WHERE', '', $this->where);
        $condition = trim($condition);
        $deleteStatus = $this->deleteData($tableName, $condition);
        return $deleteStatus;
    }
    //LastId
    public function lastID(){
        return $this->lastInsertId();
    }
    public function get(){
        $sqlQuery = "SELECT $this->selectField FROM $this->tableName $this->innerJoin $this->where $this->orderBy $this->limit";
        $sqlQuery = trim($sqlQuery);
        $query = $this->query($sqlQuery);

        $this->resetQuery();

        if(!empty($query)){
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }
        return false;

        

    }
    public function first()
    {
        $sqlQuery = "SELECT $this->selectField FROM $this->tableName $this->where $this->limit";
        $query = $this->query($sqlQuery);

        $this->resetQuery();

        if(!empty($query)){
            return $query->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }
    public function orWhere($field, $compare, $value){
        if(empty($this->where)){ 
            $this->operator = ' WHERE ';
        }else{
            $this->operator = ' OR ';
        }

        // if(empty($compare)){
        //     $compare = '=';
        // }
        $this->where .= "$this->operator $field $compare '$value'";
        return $this;
    }
    public function whereLike($field, $value){
        if(empty($this->where)){ 
            $this->operator = ' WHERE ';
        }else{
            $this->operator = ' AND ';
        }

        // if(empty($compare)){
        //     $compare = '=';
        // }
        $this->where .= "$this->operator $field LIKE '$value'";
        return $this;
    }
    public function resetQuery(){
           //Reset fields
           $this->tableName = '';
           $this->where = '';
           $this->operator = '';
           $this->selectField = '*';
           $this->limit = '';
           $this->orderBy = '';
           $this->innerJoin = '';
    }
}

?>