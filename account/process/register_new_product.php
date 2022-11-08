<?php

require_once './lib/CreateProduct.php';

foreach ($dataProduct as $key => $value) {
    if (isset($_POST[$key])) {
        $dataProduct[$key] = clear($_POST[$key]);

        if (empty($dataProduct[$key])) {
            $msg_errors[$key] = "Favor preencher este campo";
        }
    }
}

if (!isset($_SESSION['id_user'])) {
    header('location: view_login.php');
    exit;
}

$product = new CreateProdutct((int)$_SESSION['id_user']);

$msg_errors['quantity'] = $product->setProductTitle($dataProduct['title']);
$msg_errors['quantity'] = $product->setQuantityInStock($dataProduct['quantity']);
$msg_errors['price'] = $product->setPrice($dataProduct['price']);
$msg_errors['description'] = $product->setDescription($dataProduct['description']);
$msg_errors['img'] = $product->setImage("img");

if ($product->save()) {
    header('location: ?link=my_products');
}