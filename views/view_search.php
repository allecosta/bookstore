<?php require_once '../controllers/search.php'; ?>

<!DOCTYPE html>
<html lang="pt-br">

<?php require_once '../templates/head.php'; ?>

<body>

<?php require 'header.php'; ?>

    <main>
        <section class="row container col-12">
            <?php if ($products === false) : ?>
                <h1 class="text-center">Nenhum produto encontrado!</h1>
            <?php else : ?>
                <?php foreach ($products as $product) : ?>
                    <div class="css-container-product col-12 col-sm-6 col-md col-lg-3">
                        <a href="product.php?id_product=<?php echo $product['id_product']; ?>">
                            <div>
                                <img src="image_product.php?id_product=<?php echo $product['id_product']; ?>" 
                                alt="<?php echo $product['title']; ?>" style="max-width: 100%; height: 160px;">
                                <h4><?php $product['title']; ?></h4>
                                <p>R$ <?php echo formatPrice($product['price']); ?></p>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </section>

        <?php require '../templates/pagination.php'; ?>
    </main>
    
</body>
</html>
