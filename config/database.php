<?php
class Database{
 
    // specify your own database credentials
    private $host = "localhost"; //"34.214.216.246";
    private $db_name = "suncomportal";
    private $username = "root"; //"suncommysqladmin";
    private $password = "sunesoft123"; //"sunComMySQLAdmin";

    public $conn;
 
    // get the database connection
    public function getConnection(){
 
        $this->conn = null;
 
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
 
        return $this->conn;
    }
}
?>
