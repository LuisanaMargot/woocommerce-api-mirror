$product->name = $data->name;
$product->price = $data->price;
$product->description = $data->description;
$product->category_id = $data->category_id;
$product->created = date('Y-m-d H:i:s');

$data2 = array($data->name,$data->category_id,$data->price,$data->description);


if($product->created() and $data->createdWod($data2)){
    echo '{';
        echo '"message" : "Product was created."';
    echo '}';
}

else {
    echo '{';
        echo '"message" : "Unable to create product.+c"';
    echo '}';
}



