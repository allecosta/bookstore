<?php

if (isset($_GET['add_shop_cart'])) {

    if (!isset($_SESSION['id_user'])) {
        session_unset();
        session_destroy();

        header('location: ./views/view_login.php');
    }

    require_once './lib/ShopCart.php';

    $productId = clear($_GET['id_product']);
    $shopCart = new ShopCart(clear($_SESSION['id_user']));

    $shopCart->addProducts($productId);
}

?>

<a class="btn btn-success" 
    href="buy.php?id_product=<?php echo $product->getProductId(); ?>">Comprar
</a>
<a class="btn btn-warning" 
    href="?id_product=<?php echo $product->getProductId(); ?>&add_shop_cart=1">Adicionar ao carrinho
</a>