<?php

$conn = connection();
$buy = $conn->query("
    SELECT 
        * 
    FROM 
        history_buy_sale 
    WHERE id_buy={$_SESSION['id_user']} ORDER BY 
        data_negotiation DESC;
    ")->fetchAll();

if (count($buy) === 0) : ?>
    <h1>O sr(a) ainda não comprou nenhum produto.</h1>
<?php else : ?>
    <section id="product-list" class="container-fluid col-12 col-md-9 col-lg-10">
        <h1>Produtos que o sr(a) comprou: </h1>

        <?php foreach ($buy as $value) :
            $priceTotal = formatPrice($value['price'] * $value['quantity']);
            $data = date("d/m/Y às H:i:s", $value['data_negotiation']); ?>

            <div class="container-fluid row">
                <div class="container-fluid col-12 col-md-9">
                    <h4><?= $value['title']; ?></h4>
                    <p>Quantidade: <?= $value['quantity']; ?></p>
                    <p>Total: R$ <?= $priceTotal; ?></p> 
                </div>
                <div class="container-fluid col-12 col-md-3 css-image">
                    <img src="image_product.php?id_product=<?php echo $value['id_product']; ?>" 
                    alt="<?= $value['title']; ?>"
                    style="max-width: 100%; max-height: 100%;"
                    >
                </div>
                <div class="container-fluid col-12">Comprado em <?= $data; ?> do vendedor:
                    <?= searchUser($value['id_sale']); ?> 
                </div>
            </div>
        <?php endforeach; ?>
    </section>
<?php endif; ?>