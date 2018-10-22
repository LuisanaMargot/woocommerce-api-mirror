<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");


include_once '../config/database.php';
include_once '../objects/product.php';
$database = new Database();
$db = $database->getConnection();

$product = new Product($db);
$data = json_decode(file_get_contents("php://input"));
$product->id = $data->id;
$idwoo = $product->idWoocommerce();

try{
    if($product->delete()){
        $result = $woocommerce->delete('products/'. $idwoo, ['force' => true]); 
       if(!empty($result)) {
        http_response_code(200);
        echo json_encode(array("message" => "Product was deleted.")); 
       }
    }
        
    else{
        http_response_code(503);
        echo json_encode(array("message" => "Unable to delete product."));
    }

}
catch(Exception $e){
  echo "Message:" . $e->getMessage();
}
?>