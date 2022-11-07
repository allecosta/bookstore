<?php require_once '../controllers/buy.php'; ?>

<!DOCTYPE html>
<html lang="pt-br">

<?php require_once '../templates/head.php'; ?>

<body>

<?php require 'header.php'; ?>

    <main class="container row" style="margin-left: auto; margin-right: auto;">
        <section class="container row">
            <?php if ($confirmation === false) : ?>
                <div class="container col-12 col-md-6">
                    <section>
                        <h1><?php echo $product->getProductTitle(); ?></h1>
                        <h4>R$ <?php formatPrice($product->getPrice()); ?></h4>
                        <p>Vendedor: <?php echo $product->getSellerName(); ?></p>
                    </section>
                    <form method="POST" action="">
                        <?php if (isset($_SESSION['id_user'])) : ?>
                            <?php if ((int)$_SESSION['id_user'] != (int)$product->getSellerUserId()) : ?>
                                <label>
                                    Deseja comprar quantas unidades?
                                    <input type="number" name="quantity" value="1" min="1" max="<?php echo $product->getQuantityInStock(); ?>">
                                </label>
                                <label><?php echo $msg_quantity; ?></label><br>
                                <input class="btn btn-success" type="submit" name="submit" value="Comprar">
                            <?php else : ?>
                                <p>Lembrando quevocê não poder comprar o seu próprio produto</p>
                            <?php endif; ?>
                        <?php else : ?>
                            <?php require '../templates/button_buy.php'; ?>
                        <?php endif; ?>    
                    </form>
                </div>
                <figure class="col-12 col-md-6">
                    <figcaption style="display: none;"><?php echo $product->getProductTitle(); ?></figcaption>
                    <img src="image_product.php?id_product=<?php echo $product->getProductId(); ?>" 
                    alt="<?php echo $product->getProductTitle(); ?>"
                    style="max-width: 100%; max-height: 500px;"
                    >
                </figure>
                
            <?php elseif ($confirmation === true) : ?>
                <div class="container col-12 col-sm-6">
                    <section>
                        <h1>Confirmar Compra: </h1>
                        <h2><?php echo $product->getProductTitle(); ?></h2>
                        <h4>R$ Preço Total: R$ <?php echo formatPrice($price); ?></h4>
                        <p>Vendedor: <?php echo $product->getSellerName(); ?></p>
                    </section>
                    <form action="../account/process/confirm_buy.php" method="POST"> 
                        <label>
                            O sr(a) vai comprar <strong><?php echo $quantity; ?></strong> unidades
                            <input class="btn btn-success" type="submit" name="submit" value="Confirmar Compra">

                            <input type="hidden" name="quantity_buy" value="<?php echo $quantity; ?>">
                            <input type="hidden" name="id_product" value="<?php echo $product->getProductId(); ?>">
                        </label>
                    </form>
                </div>
                <figure class="col-12 col-sm">
                    <figcaption style="display: none;"><?php echo $product->getProductTitle(); ?></figcaption>
                    <img src="image_product.php?id_product=<?php echo $product->getProductId(); ?>" 
                    alt="<?php echo $product->getProductTitle(); ?>"
                    style="max-width: 100%; max-height: 500px;"
                    >
                </figure>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>

