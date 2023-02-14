<?php

session_start();

require_once '../lib/functions.php';
require_once '../lib/GetProduct.php';

$msgQuantity = "";
$confirmation = false;

if (isset($_GET['id'])) {
    $productID = clear($_GET['id']);

    if (!isset($_SESSION['id'])) {
        header("location: view_login.php?buy={$productID}");
    } else {
        $product = new GetProduct($productID);

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && (isset($_POST['quantity'], $_POST['submit']))) {
            $quantity = clear($_POST['quantity']);

            if (is_numeric($quantity)) {
                $quantity = floor((float)$quantity);

                if ($quantity > 0 && $quantity <= $product->getQuantityInStock()) {
                    $price = $product->getPrice() * $quantity;
                    $confirmation = true;
                }
            } else {
                $msgQuantity = "OPS! Valor Inválido";
            }
        }
    }
} else {
    header('location: /views/404.html');
}