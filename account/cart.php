<?php 

require_once '../lib/ShopCart.php';

$shopCart = new ShopCart(clear($_SESSION['id_user']));

if (isset($_GET['remove_shop_cart'])) {
    $id = clear($_GET['remove_shop_cart']);
    $shopCart->removeProduct($id);
}

$confirmation = false;

if ($_SERVER['REQUEST_METHOD'] === "GET") {
    $products = $shopCart->getProducts();
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $products = [];
    $conn = connection();
    $shopCartProducts = $shopCart->getProductsIds();
    $stat = $conn->prepare("SELECT title, id_product, price, quantity FROM products WHERE id_products=:id");

    foreach ($_POST as $key => $value) {
        if (array_search($key, $shopCartProductsIds) !== false) {
            if (!is_numeric($value)) {
                header("location: 404.html");
            }

            $id = clear($key);
            $quant = (int)floor((float)clear($value));

            if ($quant < 0) {
                continue;
            }

            $stat->bindParam(":id", $id);
            $stat->execute();
            $prod = $stat->fetchAll();

            if (count($prod) === 1) {
                $prod[0]['quant'] = $quant;
                array_push($products, $prod[0]);
            }
        }
    }

    foreach ($products as $product) {
        if ($product['quant'] > $product['quantity'] || $product['quant' < 0]) {
            $confirmation = false;
        } else {
            $confirmation = true;
        }
    }
}

if (count($products) === 0) { ?>
    <div class="container col-12 col-md-9 col-lg-10">
        <h1 class="text-center">Seu carrinho está vazio!</h1>
    </div>
    
<?php 

} elseif ($confirmation === false) { 
    require 'process/cart_false.php';
} else {
    require 'process/cart_true.php';
}

?>

 
 
