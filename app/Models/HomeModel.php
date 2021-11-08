<?php 
class HomeModel extends Model{
    protected $__table = 'users';
    // public function __construct()
    // {
        
    // }
    function tableFill(){
        return 'users';   
    }
    function fieldFill(){
        return '*';
    }
    function primaryKey(){
        return 'id';
    }

    public function getList(){
        $data = $this->db->query("SELECT * FROM $this->_table")->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
    public function getUserList(){
        // $data = $this->db->table('users')->whereLike('name','%h%')->select('id, name, email')->orderBy('id', 'DESC')->limit(2,1)->get();
         $data = $this->db->table('users as u')->join('plans as p','p.id = u.plan_id')->where('p.id','=', 1)->get();
        return $data;
    }
    public function getUserDetail(){
        
        $data = $this->db->table('users')->select('id, name, email')->first();
        return $data;
    }
    public function insertUser($data){
        $this->db->table('users')->insert($data);
        return $this->db->lastID();
    }
    public function updateUser($data, $id){
        $this->db->table('users')->where('id', '=', $id)->update($data);
    }
    public function deleteUser($id){
        $this->db->table('users')->where('id', '=', $id)->delete();
    }
    
}
?>