<?php
require_once './config/database.php';
require_once './config/config.php';
spl_autoload_register(function ($className) {
  require './app/models/' . $className . '.php';
});

$input = json_decode(file_get_contents('php://input'), true);
$arr_id_cat = $input['arr_id_cat'];

$productModel = new ProductModel();
if (sizeof($arr_id_cat) > 0) {
  $item = $productModel->getProductByCategorys($arr_id_cat);
} else {
  $item = $productModel->getProducts();
}
echo json_encode($item);
