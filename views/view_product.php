<?php require_once '../controllers/product.php'; ?>

<!DOCTYPE html>
<html lang="pt-br">

<?php require_once '../templates/head.php'; ?>

<body>

<?php require 'header.php'; ?>

    <main class="container">
        <section id="product" class="container row">
            <div class="col-12 col-md-6">
                <h1><?php echo $product->getProductTitle(); ?></h1>
                <h4>R$ <?php echo formatPrice($product->getPrice()); ?></h4>
                <p>Quantidade Disponível: <?php echo $product->getQuantityInStock(); ?></p>
                <p>Vendedor: <?php echo $product->getSellerName(); ?></p>

                <?php 
                
                if (isset($_SESSION['id_user'])) {
                    if ((int)$_SESSION['id_user'] != (int)$product->getSellerUserId()) {
                        require './templates/button_buy.php';
                    } else { ?>
                        <p>Lembrando que você não pode comprar seu próprio produto, ok!?</p>
                    <?php
                    }
                } else {
                    require './templates/button_buy.php';
                }

                ?>

            </div>
            <figure class="col-12 col-md-6">
                <figcaption style="display: none;"><?php echo $product->getProductTitle(); ?></figcaption>
                <img src="image_product.php?id_product=<?php echo $product->getProductId(); ?>" 
                    alt="<?php echo $product->getProductTitle(); ?>"
                    style="max-width: 100%;"
                    >
            </figure>
            <div class="container col-12" style="white-space: normal;">
                <h2>Descrição do Produto: </h2>
                <div><?php echo $product->getDescription(); ?></div>
            </div>
        </section>
    </main>
    
</body>
</html>

