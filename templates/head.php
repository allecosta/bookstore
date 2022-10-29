<head>
    <meta charset="UTF-8">
    <meta name="author" content="Alexandre Costa">
    <meta name="description" content="Book Store - venda e compra de livros">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Book Store</title>

    <link rel="stylesheet" href="/resources/css/header.css">
    <link rel="stylesheet" href="/resources/css/body.css">
    <link rel="stylesheet" href="/resources/bootstrap/bootstrap.min.css">

    <?php 

    $page = clear($_SERVER['PHP_SELF']);

    if ($page === "/views/view_account.php" && isset($_GET['link'])) {
        $link = clear($_GET['link']);

        switch ($link) {
            case "sell":
            case "edit":
                echo '<link rel="stylesheet" href="/resources/css/forms.css">';
                break;
            case "my_products":
            case "purchases":
            case "sold":
            case "cart":
                echo '<link rel="stylesheet" href="/resources/css/account_products_list.css">';
                break;
        }
    }

    switch ($page) {
        case "/views/view_search.php":
        case "/views/index.php":
            echo '<link rel="stylesheet" href="/resources/css/produtcs_list.css">';
            break;
        case "/views/view_create_account.php":
        case "/views/view_login.php":
            echo '<link rel="stylesheet" href="/resources/css/forms.css">';
            break;
    }

    ?>

    <script src="/resources/js/jquery-3.2.1.slim.min.js"></script>
    <script src="/resources/bootstrap/bootstrap.bundle.min.js"></script>

</head>