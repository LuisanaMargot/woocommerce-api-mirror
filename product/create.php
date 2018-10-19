<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");


include_once '../config/database.php';
include_once '../objects/product.php';
include_once '../config/woocommerce-config.php';

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);
$data = json_decode(file_get_contents("php://input"));;

if(
    !empty($data->name) &&
    !empty($data->price) &&
    !empty($data->description) 
){
 
    // set product property values
  

    $data4 = [
        'name' => $data->name,
        'regular_price' =>$data->price,
        'description' =>$data->description
    ];

    $data5 = $woocommerce->post('products', $data4);
    $data6 = $data5->id;

    $product->name = $data->name;
    $product->price = $data->price;
    $product->description = $data->description;
    $product->category_id = $data->category_id;
    $product->created = date('Y-m-d H:i:s');
    $product->id_woocommerce = $data5->id;

    var_dump($product);

   
    if($product->create())
    { 
        
        http_response_code(200); 

        echo json_encode(array("message" => "Product was created."));
    }
 
    else{
 
        http_response_code(503);
        echo json_encode(array("message" => "Unable to create product."));
    }
}

else{

    http_response_code(400);
    echo json_encode(array("message" => "Unable to create product. Data is incomplete."));
}



?>
