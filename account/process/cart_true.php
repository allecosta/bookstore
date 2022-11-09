<section class="container-fluid col-12 col-md-9 col-lg-10">
    <form id="products-list" class="container-fluid col-12" action="account/process/confirm_buy_cart.php" method="POST">
        <h1>Confirme sua compra: </h1>
        <?php if (count($products) === 0) {
             header('location: account.php?link=cart');
        }

        $priceTotal = 0;

        foreach ($products as $key => $product) {
            if ($product['quantity'] === 0) {
                removeCart($product['id_product']);
                continue;
            }

            $price = $product['quantity'] * $product['price'];
            $priceTotal += $price;

            ?>

            <div class="container-fluid row col-12">
                <div class="container-fluid col-12 col-sm-8">
                    <h4><?php echo $product['title']; ?></h4>
                    <p><strong><?php echo $product['quantity']; ?></strong> unidade(s).</p>
                    <p><strong>R$ <?php echo formatPrice($price); ?></strong></p>
                </div>
                <div class="col-12 col-sm-4">
                    <img src="image_product.php?id_product=<?php echo $product['id_product']; ?>" 
                    alt="<?php echo $product['title']; ?>"
                    style="max-width: 100%;"
                    >
                </div>
                
                <input type="hidden" name="price_<?php echo $product['id_product']; ?>" value="<?php echo $price; ?>">
                <input type="hidden" name="quantity_<?php echo $product['id_product']; ?>" value="<?php echo $product['quantity']; ?>">
            </div>

        <?php } ?>
            
        <div class="container-fluid col-12">
            <p>Total <strong>R$ <?php echo formatPrice($priceTotal); ?></strong></p>
            <input class="btn btn-success" type="submit" name="submit" value="Confirmar Compra">
            <a href="">Cancelar Compra</a>
        </div>
    </form>
</section>

