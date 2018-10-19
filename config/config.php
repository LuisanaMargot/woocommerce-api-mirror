<?php 
class Config{

    public static  function getConfig(){
        // Read JSON file

        $json = file_get_contents( dirname(__FILE__).'/config.json');

        //Decode JSON
        $config = json_decode($json,true);

       return  $config;
    }


}


?>
