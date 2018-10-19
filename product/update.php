<?php   
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../objects/product.php';

$database = new Database();
$db = $database->getConnection();
 
$product = new Product($db);
$data = json_decode(file_get_contents("php://input"));



$product->id = $data->id;
$product->name = $data->name;
$product->price = $data->price;
$product->description = $data->description;
$product->category_id = $data->category_id;
$idwoo = $product->idWoocommerce();

$data4 = [
    'name' => $data->name,
    'regular_price' =>$data->price,
    'description' =>$data->description
];

$woocommerce->put('products/'. $idwoo, $data4);


if($product->update()){
 
    // set response code - 200 ok
    http_response_code(200);
 
    // tell the user
    echo json_encode(array("message" => "Product was updated."));
}
 

else{
 
    // set response code - 503 service unavailable
    http_response_code(503);
 
    // tell the user
    echo json_encode(array("message" => "Unable to update product."));
}

?>