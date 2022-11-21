<?php 

$product = searchProduct();

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (isset($_POST['delete_product'],$_POST['id_product'])) {
        if ($_POST['delete_product'] === "Excluir") {
            $idProduct = clear($_POST['id_product']);
            $idUser = $_SESSION['id_user'];

            try {
                $conn = connection();
                $conn->beginTransaction();
                $rows = $conn->exec("DELETE FROM product WHERE id_product='{$idProduct}' AND id_user_sale={$idUser};");

                if ($rows !== 1) {
                    header("location: 404.html");
                } else {
                    $stat = $conn->query("
                        SELECT 
                            id_products 
                        FROM 
                            history_buy_sale 
                        WHERE 
                            id_products='{$idProduct}'
                        ")->fetchAll();
                    
                    if (count($stat) === 0) {
                        $conn->exec("DELETE FROM image_products WHERE id_product='{$idProduct}';");
                    }

                    $conn->commit();

                    header("location: ?link=my_products");
                }

               
            } catch (PDOException $e) {
                dbError($e);
            } 
        }
    }
}

?>

<section class="container col-12 col-md-9 col-lg-10">
    <div class="col-12 text-center">
        <h1>Tem certeza que deseja excluir o produto abaixo?</h1>
    </div>
    <div class="container row col-12" style="padding-top: 2em;">
        <div class="col-12 col-md-8">
            <h1><?= $product['0']['title']; ?></h1>
            <div>
                <h4>R$ <?= formatPrice($product[0]['price']); ?></h4>
                <p>Quantidade Disponivel: <?= $product[0]['quantity']; ?></p>
            </div>
        </div>
        <figure class="col-12 col-md-4">
            <figcaption style="display: none;"><?= $product[0]['title']; ?></figcaption>
            <img src="image_product.php?-d_product=<?= $product[0]['id_product']; ?>" 
                alt="<?= $product[0]['title']; ?>" 
                width="200" height="150"
                >
        </figure>
        <div class="col-12">
            <h2>Descrição do Produto: </h2>
            <div><?= $product[0]['description']; ?></div>
        </div>
        <form class="col-12" method="POST" action="">
            <input class="btn btn-danger" type="submit" name="deletar_product" value="Excluir">
            <input type="hidden" name="id_product" value="<?= clear($_GET['id_product']); ?>">
            <a class="btn btn-info" href="?link=my_products">Cancelar</a>
        </form>
    </div>
</section>

