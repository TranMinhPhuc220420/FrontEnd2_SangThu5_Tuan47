<?php
require_once './config/database.php';
require_once './config/config.php';
spl_autoload_register(function ($className) {
    require './app/models/' . $className . '.php';
});

$input = json_decode(file_get_contents('php://input'), true);
$id = $input['id'];


$productModel = new ProductModel();
$item = $productModel->getProductById($id);

echo json_encode($item);