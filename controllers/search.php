<?php 

require_once '../lib/functions.php';
require_once '../lib/SearchProducts.php';

if (isset($_GET['search'])) {
    $search = clear($_GET['search']);
    $listProducts = new SearchProducts($search);

    if (isset($_GET['page'])) {

        if (is_numeric($_GET['page'])) {
            $pageNumber = (int)clear($get['page']);
            $products = $listProducts->getPage($pageNumber);
        } else {
            header('location: /views/404.html');
        }
    } else {
        $products = $listProducts->getPage(1);
    }
}