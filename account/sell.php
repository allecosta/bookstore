<?php

$dataProduct = [
    'title' => "",
    'quantity' => "",
    'price' => "",
    'description' => ""
];

$msgErrors = [
    'title' => "",
    'quantity' => "",
    'price' => "",
    'description' => "",
    'image' => ""
];

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['submit'])) {
    $image = "Imagem do Produto: ";
    $submit = clear($_POST['submit']);

    if ($submit === "Cadastrar Produto") {
        require 'process/register_new_product.php';
    } elseif ($submit === "Salvar") {
        require 'process/edit_product.php';
    }
} elseif ($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['link'])) {
    if ($_GET['link'] === "edit" && isset($_GET['id_product'])) {
        $image = "Trocar imagem do produto: ";

        require 'process/edit_product.php';
    }
} else {
    header("location: 404.html");
}

require 'process/form_product.php';

