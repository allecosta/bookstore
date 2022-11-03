<?php require_once '../controllers/app.php'; ?>

<!DOCTYPE html>
<html lang="pt-br">

<?php require_once '../templates/head.php'; ?>

<body>

<?php require 'header.php'; ?>

    <main class="container-fluid">
        <h1 id="welcome">Bem vindo à Book Store</h1>
        <section class="row container col-12">
            
            <?php if ($products !== false) {
                foreach ($$products as $key => $value) {
                    $price = formatPrice($value['price']);
                ?>
                <div class="css-container-product col-12 col-sm-6 col-md-4 col-lg-3">
                    <a href="view_product.php?id_product=<?php echo $value['id_product']; ?>">
                        <div>
                            <img src="image_product.php?id_product=<?php echo $value['id_product']; ?>" 
                            alt="<?php echo $value['title']; ?>"
                            style="max-width: 100%; height: 150px;"
                            >
                            <h4><?php echo $value['title']; ?></h4>
                            <p>R$ <?php echo $price; ?></p>
                        </div>     
                    </a>
                </div>
            <?php

                }
            } 
            
            ?>

        </section>

        <?php require '../templates/pagination.php'; ?>
    </main>
    
</body>
</html>

