<?php

require '../lib/functions.php';

$idUser = clear($_SESSION['id_user']);
$conn = connection();
$stat = $conn->query("SELECT id_product, title, price FROM products WHERE id_user_sale={$idUser}");

?>

<section id="products-list" class="container col-12 col-md-9 col-lg-10">  
    <?php if ($stat !== false) : ?>
            <?php $products = $stat->fetchAll(); ?>
        <?php if (count($products) === 0) : ?>
            <h1>O sr(a) não possui nenhum produto à venda</h1>
            <p class="text-center"><a href="account.php?link-sell">Quero vender um produto</a></p>

        <?php elseif (count($products) !== 0) : ?>
            <h1>Produtos que o sr(a) está vendendo:</h1>

            <?php foreach ($products as $key => $value) : ?>
                <?php $price = formatPrice($value['price']); ?>
                <div>
                    <div class="container-fluid row col-12">
                        <div class="container-fluid col-12 col-md-9">
                            <a 
                                href="product.php?id_product=<?php echo $value['id_product']; ?>">
                                <h4><?= $value['title']; ?></h4>
                            </a>
                            <p>R$ <?= $price; ?></p>
                        </div>
                        <div class="container-fluid col-12 col-md-3 css-image">
                            <img 
                                src="image_product.php?id_product=<?php echo $value['id_product']; ?>" 
                                alt="<?= $value['title']; ?>"
                                style="max-width: 100%; max-height: 100%;"
                                >
                        </div>
                    </div>
                    <div class="container-fluid col-12">
                        <a href="account.php?link=edit&id_product=<?php echo $value['id_product']; ?>">Editar</a>
                        <a href="account.php?link=delete&id_product=<?php echo $value['id_product']; ?>">Excluir</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>    
    <?php else : ?>
        <h1>O sr(a) não possui produtos cadastrados para vender.</h1>
        <p><a href="sell.php">Cadastre um produto agora</a></p>
    <?php endif; ?>
</section>