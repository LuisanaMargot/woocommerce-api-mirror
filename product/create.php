<?php
header("Content-Type: application/json; charset=UTF-8");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With');


include_once '../config/database.php';
include_once '../objects/product.php';
include_once '../config/woocommerce-config.php';

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);
$data = json_decode(file_get_contents("php://input"));;

try{
    if(!empty($data->name) && !empty($data->price) && !empty($data->description)){
        $product->name = $data->name;
        $product->price = $data->price;
        $product->description = $data->description;
        if($product->create()){ 
            $woocommerceData = [
                'name' => $data->name,
                'regular_price' =>$data->price,
                'description' =>$data->description
            ];
            $idwoocommerce = $woocommerce->post('products', $woocommerceData);
            if (!empty($idwoocommerce)){
                $product->id_woocommerce = $idwoocommerce->id;
                    if($product->insertIDtoWoocommerceColumn()){
                        http_response_code(200); 
                          echo json_encode(array("message" => "Product was created."));
                    } 
                    else{
                            echo json_encode(array("message" => "Unable to create product."));
                    }        
            }

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
}

    catch(Exception $e){

        echo "Message:" . $e->getMessage();
    
    }



?>
