<?php

session_start();

require '/lib/functions.php';

if (isset($_GET['id'])) {
    $product = searchProduct($_GET['id']);

    if (count($product) === 0) {
        header('location: /views/404.html');
    }
}

