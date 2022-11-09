<?php

session_start();

require_once '../../lib/functions.php';
require_once '../../lib/ShopCart.php';

if (!isset($_SESSION['id_user'])) {
    session_unset();
    session_destroy();

    header('location: view_login.php');
}

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    header('location: 404.html');
}

if (isset($_POST['submit'])) {
    $shopCart = new ShopCart($_SESSION['id_user']);
    $shopCartProductsIds = $shopCart->getProductsIds();
} else {
    header('location: 404.html');
}

$conn = connection();
$conn->beginTransaction();

$statSearch = $conn->prepare("SELECT * FROM products WHERE id_product=:id;");
$statModification = $conn->prepare("UPDATE products SET quantity=:newQuantity WHERE id_product=:id;");
$statRemove = $conn->prepare("DELETE FROM products WHERE id_product=:id;");

foreach ($shopCartProductsIds as $id) {
    if (isset($_POST['quantity_' . $id])) {
        if (!is_numeric($_POST['quantity_' . $id])) {
            $conn->rollBack();

            header('location: 404.html');
        }

        $quantity = (int)clear($_POST['quantity_' . $id]);
        $statSearch->bindParam(":id", $id);
        $statSearch->execute();
        $product = $statSearch->fetchAll()[0];

        if ($quantity === 0) {
            removeCart($id);
            continue;
        }

        if ($quantity > $product['quantity'] || $quantity < 1) {
            $conn->rollBack();
            header('location: 404.html');

        } elseif ($quantity < $product['quantity']) {
            $newQuantity = $product['quantity'] - $quantity;
            $statModification->bindParam(":id", $id);
            $statModification->bindParam(":newQuantity", $newQuantity);
            $statModification->execute();
            
        } elseif ($quantity === $product['quantity']) {
            $statRemove->bindParam(":id", $id);
            $statRemove->execute();
        }

        $statHistory = $conn->prepare("
            INSERT INTO history_buy_sale (
                id_buy,
                id_sale,
                id_products,
                title,
                quantity,
                price,
                data_negotiation
            )
            VALUES (
                :id_buy,
                :id_sale,
                :id_products,
                :title,
                :quantity,
                :price,
                :data_negotiation 
            );
        ");

        $statHistory->bindParam(":id_buy", $_SESSION['id_user']);
        $statHistory->bindParam(":id_sale", $product['id_user_sale']);
        $statHistory->bindParam(":id_product", $product['id_product']);
        $statHistory->bindParam(":title", $product['title']);
        $statHistory->bindParam(":quantity", $quantity);
        $statHistory->bindParam(":price", $product['price']);
        
        $time = time();
        $statHistory->bindParam(":data_negotiation", $time);
        $statHistory->execute;
            
    } else {
        $conn->rollBack();

        header('location: 404.html');
    }    
}

$conn->commit();
$shopCart->cleanAllProducts();

header('location: ../../account.php?link=buy');