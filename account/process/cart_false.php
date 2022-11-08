<style>
    input[type=submit] {
        padding: 1em 3em;
    }
</style>
<section class="container-fluid col-12 col-md-9 col-lg-10">
    <form id="products-list" method="POST" action="">
        <h1>Produtos adicionados ao carrinho: </h1>
        <?php foreach ($products as $key => $product) : ?>
            <div class="container-fluid row col-12">
                <div class="container-fluid col-12 col-md-8">
                    <h4><?php echo $product['title']; ?></h4>
                    <p>R$ <?php echo formatPrice($product['price']); ?></p>
                    <label>
                        Quantidade: 
                        <input type="number" name="<?php echo $product['id_product']; ?>" min="1" max="<?php echo $product['quantity']; ?>" required>
                        <p><a href="view_account.php?link=cart&remove_shop_cart=<?php echo $product['id_product']; ?>">Remover do Carrinho</a></p>
                    </label>
                </div>
                <div class="col-12 col-md-4">
                    <img src="image_product.php?id_product=<?php echo $product['id_product']; ?>" 
                    alt="<?php echo $product['title']; ?>"
                    style="max-width: 100%;"
                    >
                </div>
            </div>
        <?php endforeach; ?>

        <div class="container">
            <input class="btn btn-success" type="submit" value="Comprar">
        </div>
    </form>
</section>
