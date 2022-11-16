<?php 

session_start();

require_once '../../lib/functions.php';
require_once '../../lib/GetProduct.php';

if (!isset($_SESSION['id_user'])) {
    session_unset();
    session_destroy();

    header('location: view_login.php');
}

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    header('location: 404.html');
}

if (isset($_POST['submit'], $_POST['quantity'])) {
    $idProduct = clear($_POST['id_product']);
    $product = new GetProduct($idProduct);

    if ((int)$_SESSION['id_user'] === (int)$product->getSellerUserId()) {
        header('location: 404.html');
    }

    if (isset($_SESSION['id_user']) || (is_countable($product) === 0)) {
        if ($_SESSION['id_user'] === $product->getSellerUserId()) {
            header('location: 404.html');
        }
    }

    $quantity = clear($_POST['quantity']);

    if (is_numeric($quantity)) {
        $quantity = (int)$quantity;
        $quantityInStock = $product->getQuantityInStock();

        if (is_nan($quantity)) {
            header('location: 404.html');
        } elseif ($quantity > 0 && $quantity <= $quantityInStock) {
            try {
                $conn = connection();
                $conn->beginTransaction();
                $price = $product->getPrice() * $quantity;
                $newQuantity = $quantityInStock - $quantity;

                if ($quantity === $quantityInStock) {
                    $conn->exec("DELETE FROM products WHERE id_product='{$idProduct}';");
                } elseif ($quantity < $quantityInStock) {
                    $conn->exec("UPDATE products SET quantity={$newQuantity} WHERE id_product='{$idProduct}';");
                }

                $stat = $conn->prepare("
                    INSERT INTO hystory_buy_sale (
                        id_buy,
                        id_sale,
                        id_products,
                        title,
                        quantity,
                        price,
                        date_negotition
                    )
                    VALUES (
                        :id_buy,
                        :id_sale,
                        :id_products,
                        :title,
                        :quantity,
                        :price,
                        :date_negotition
                    );
                ");

                $stat->bindParam(":id_buy", $_SESSION['id_user']);
                $stat->bindParam(":id_sale", $product->getSellerUserId());
                $stat->bindParam(":id_product", $product->getProductId());
                $stat->bindParam(":title", $product->getProductTitle());
                $stat->bindParam(":quantity", $quantity);
                $stat->bindParam(":price", $product->getPrice());

                $time = time();
                $stat->bindParam(":data_negotition", $time);
                $stat->execute();
                $conn->commit();

                header("location: ../../view_accocunt.php?link=buy");

            } catch(PDOException $e) {
                dbError($e);
            }
        }
    }
}