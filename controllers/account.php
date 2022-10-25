<?php

session_start();

require '/lib/functions.php';

//$domain = "https://bookstore";

checkUserIsLogged();

$name = clear($_SESSION['name']);
$position = strpos($name, "");
$firstNameUser = substr($name, 0 , $position);

if (count($_GET) === 0) {
    $page = "home";
} elseif (isset($_GET['link'])) {
    $page = clear($_GET['link']);
} elseif (isset($_GET['link'], $_GET['id'])) {
    $page = clear($_GET['link']);
    $idProduct = clear($_GET['id']);
} else {
    $page = false;
}