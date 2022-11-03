<?php

function connection() 
{
    $server = "localhost";
    $username = "###";
    $password = "###";
    $dbname = "db_bookstore";

    $conn = new PDO("mysql:host={$server};dbname={$dbname}", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

    return $conn;
    
}

function clear($args) 
{
    return (htmlspecialchars(stripslashes(trim($args))));
}

function validationEmail($email = "") 
{
    if ($email == "") {
        return "OPS! É obrigatorio o preenchimento deste campo";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "Favor informar um email válido!";
    } else {
        return "";
    }
}

function formatPrice($priceDb) 
{
    $priceFormat = str_replace(".", ",", (string)$priceDb);
    $positionVirgula = strpos($priceFormat, ",");

    if ($positionVirgula === false) {
        $priceFormat .= ",00";
    } else {
        $priceFormat .= "00";
        $priceFormat = substr($priceFormat, 0, ($positionVirgula + 3));
    }

    return $priceFormat;
}

function searchUser($idUser) 
{
    $conn = connection();
    $queryResult = $conn->query("SELECT name FROM users WHERE id_user={$idUser};")->fetchAll();

    if (count($queryResult) === 0) {
        throw new Exception("OPS! este usuário não existe em nosso banco de dados. (function searchUser()->functions.php");
        exit;
    } else {
        return $queryResult[0]['name'];
    }
}

function checkUserIsLogged() 
{
    if (!isset($_SESSION['id_user'])) {
        session_unset();
        session_destroy();

        header('location: /views/view_login.php');
    }
}

