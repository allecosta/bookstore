<?php require_once '../controllers/account.php'; ?>

<!DOCTYPE html>
<html lang="pt-br">

<?php require_once '../templates/head.php'; ?>

<body>

<?php require 'header.php'; ?>

    <main>
        <section class="container row col-12">
            <?php require '../account/navigation.php'; 

                switch ($page) {
                    case "home":
                        require '../account/home.php';
                        break;
                    case "my_products":
                        require '../account/my_products.php';
                        break;
                    case "edit":
                    case "sell":
                        require '../account/sell.php';
                        break;
                    case "delete":
                        require '../account/delete_product.php';
                        break;
                    case "buy":
                        require '../account/my_buy.php';
                        break;
                    case "sold":
                        require '../account/sold.php';
                        break;
                    case "cart":
                        require '../account/cart.php';
                        break;
                    default:
                        require '../views/404.html';
                }

            ?>
        </section>
    </main>  
</body>
</html>