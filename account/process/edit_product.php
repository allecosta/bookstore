<?php 

require_once './lib/EditProduct.php';

$product = new EditProduct(clear($_GET['id_product']));

if ($product->getSellerUserId() !== (int)$_SESSION['id_user']) {
    header("location: 404.html");
} else {
    $dataProduct['id_product'] = $product->getProductId();

    if ($_SERVER['REQUEST_METHOD'] === "GET") {
        $dataProduct['title'] = $product->getProductTitle();
        $dataProduct['quantity'] = $product->getQuantityInStock();
        $dataProduct['price'] = formatPrice($product->getPrice());
        $dataProduct['description'] = $product->getDescription();

    } elseif ($_SERVER['REQUEST_METHOD'] === "POST") {
        foreach ($dataProduct as $key => $value) {
            if (isset($_POST[$key])) {
                $dataProduct[$key] = clear($_POST[$key]);

                if (empty($dataProduct[$key])) {
                    $msg_errors[$key] = "É obrigatorio o preenchimento deste campo";
                }
            }
        }

        $msg_errors['title'] = $product->setProductTitle($dataProduct['title']);
        $msg_errors['quantity'] = $product->setQuantityInStock($dataProduct['quantity']);
        $msg_errors['price'] = $product->setPrice($dataProduct['price']);
        $msg_errors['description'] = $product->setDescription($dataProduct['description']);

        if (empty($_FILES['img']['tmp_name'])) {
            $msg_errors['img'] = $product->setImage(null);
        } elseif (isset($_FILES['img'])) {
            $msg_errors['img'] = $product->setImage("image");
        }

        if (!isset($_SESSION['id_user'])) {
            header("location: view_login.php");
        }

        if ($product->save()) {
            header("location: view_account.php?link=my_products");
        } else {
            throw new Exception("OPS! Erro na edição do produto! Contate a equipe de desenvolvimento.");
        }
    }
}