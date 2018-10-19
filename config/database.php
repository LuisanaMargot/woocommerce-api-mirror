<?php 
include_once 'config.php';
class Database{

    private $config;     
    private $host ="";
    private $db_name = "";
    private $username = "";
    private $password = "";
    private $conn;

    public function __construct(){
        $this->config = Config::getConfig();
        $this->host = $this->config["db"]["host"] ;
        $this->db_name = $this->config["db"]["db_name"];
        $this->username = $this->config["db"]["username"];
        $this->password = $this->config["db"]["password"];

        $this->conn = null;
       
    }

    public function getConnection(){
       
        try {
            $this->conn = new PDO ("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");

        }catch(PDOException $exception){
            echo "Connection error:" . $exception->getMessage();
        }
        return $this->conn;
    }

}
?>



