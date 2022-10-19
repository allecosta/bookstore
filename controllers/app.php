<?php

session_start();

require_once 'lib/functions.php';
require_once 'lib/SearchProducts.php';

$listProducts = new SearchProducts();

if (isset($_GET['page'])) {
    
    if (is_numeric($_GET['page'])) {
        $pageNumber = (int)clear($_GET['page']);
        $products = $listProducts->getPage($pageNumber);
    } else {
        header('location: /views/404.html');
    }
} else {
    $products = $listProducts->getPage(1);
}