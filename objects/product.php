<?php 

include_once '../config/woocommerce-config.php';

class Product{

    private $conn;
    private $table_name = "products";

    public $id;
    public $name;
    public $description;
    public $price;
    public $category_id;
    public $category_name;
    public $created;
    public $id_woocommerce;

    public function __construct($db){
        $this->conn= $db;
    }
        function read(){
 
            // select all query
            $query ='SELECT c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created FROM '. $this->table_name .' p LEFT JOIN categories c ON p.category_id = c.id ORDER BY p.created DESC';
            
            // prepare query statement
            $stmt = $this->conn->prepare($query);
         
            // execute query
            $stmt->execute();
         
            return $stmt;
        }

       function create(){

        $result = true;

            try{
                $query = "INSERT INTO ".$this->table_name ." SET name=:name, price=:price, description=:description, id_woocommerce=:id_woocommerce"; 
         
                $stmt = $this->conn->prepare($query);    
                
                $this->name=htmlspecialchars(strip_tags($this->name));
                $this->price=htmlspecialchars(strip_tags($this->price));
                $this->description=htmlspecialchars(strip_tags($this->description));
                $this->id_woocommerce=htmlspecialchars(strip_tags($this->id_woocommerce));
    
                $stmt->bindParam(":name", $this->name);
                $stmt->bindParam(":price", $this->price);
                $stmt->bindParam(":description", $this->description);
                $stmt->bindParam(":id_woocommerce", $this->id_woocommerce);
                $stmt->execute();
                $this->id = $this->conn->lastInsertId();
            }

            catch (Exception $e){
                $result = false;

            }
           
        return $result;
       }

       function insertIDtoWoocommerceColumn(){

            $query = "UPDATE " . $this->table_name . " SET id_woocommerce = :id_woocommerce  WHERE id = :id";
            $stmt = $this->conn->prepare($query);
     
        
            $this->id_woocommerce=htmlspecialchars(strip_tags($this->id_woocommerce));
           
    
            $stmt->bindParam(':id_woocommerce', $this->id_woocommerce);
            $stmt->bindParam(':id', $this->id);
            $stmt->execute(); 
         return  $stmt; 
            
       }

       function readOne(){

        $query = "SELECT c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created FROM " . $this->table_name . " p LEFT JOIN categories c ON p.category_id = c.id WHERE p.id = ? LIMIT 0,1";
       
        $stmt = $this->conn->prepare( $query );
 
        $stmt->bindParam(1, $this->id);    
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->name = $row['name'];
        $this->price = $row['price'];
        $this->description = $row['description'];
        $this->category_id = $row['category_id'];
        $this->category_name = $row['category_name'];
       }

       function idWoocommerce(){


        $query = "SELECT  p.id_woocommerce FROM  " . $this->table_name . " p WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $this->id);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $row['id_woocommerce'];
      

       }


       function update(){
 
        $query = "UPDATE " . $this->table_name . " SET name = :name, price = :price, description = :description  WHERE id = :id";


        $stmt = $this->conn->prepare($query);
     
     
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->price=htmlspecialchars(strip_tags($this->price));
        $this->description=htmlspecialchars(strip_tags($this->description));
        $this->id=htmlspecialchars(strip_tags($this->id));
     
        
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':description', $this->description);
          $stmt->bindParam(':id', $this->id);
     
        
        if($stmt->execute()){
            return true;
        }
     
        return false;
       }

     
       function delete(){

        $query = "DELETE FROM " . $this->table_name . "  p WHERE id = ?";
    
        $stmt = $this->conn->prepare($query);
        $this->id=htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(1, $this->id);
    
        $stmt->execute();
        return $stmt;
        
     
        }   
       

       
}
?>
