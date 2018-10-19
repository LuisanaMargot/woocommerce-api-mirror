<?php

require '../vendor/autoload.php'; 
include_once 'config.php';
use Automattic\WooCommerce\Client;

$config = Config::getConfig();

$woocommerce = new Client(
    $config["woo"]["host"],
    $config["woo"]["client-key"],
    $config["woo"]["client-secret"],
    [
        'wp_api' => true,
        'version' => 'wc/v2'
    ]
);
?>