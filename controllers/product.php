<?php

session_start();

require_once '../lib/functions.php';
require_once '../lib/GetProduct.php';

if (isset($_GET['id_product'])) {
    $product = new GetProduct(clear('id_product'));

}

