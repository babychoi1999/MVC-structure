<?php 
class Connection{
    private static $instance = null, $conn = null;
    
    private function __construct($config)
    {
        // Kết nối DB
        try {
            // Cấu hình dsn
            $dsn = 'mysql:dbname='.$config['db'].';host='.$config['host'];

            //Cấu hình $options
            /**
             * - Cấu hình utf8
             * - Cấu hình ngoại lệ khi truy vấn bị lỗi
             */
            $options = [
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION

            ];
            //Câu lệnh kết nối
            $con = new PDO($dsn, $config['user'], $config['pass'], $options);
            self::$conn = $con;

        } catch (Exception $exception) {
            $mess = $exception->getMessage();
            $data['message'] = $mess;
            App::$app->loadError('database', $data);
            die();
        }
        
    }
    public static function getInstance($config){
        //Design pattern: Singleton (chỉ kết nối DB 1 lần)

        if(self::$instance == null){
            $connection = new Connection($config);
            self::$instance = self::$conn;
        }

        return self::$instance;
    }
}
?>