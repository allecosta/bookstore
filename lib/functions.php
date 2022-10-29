<?php

function connection() 
{
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'db_bookstore');
    define('DB_CHARSET', 'utf8mb4');
    define('DB_USER', '###');
    define('DB_PASSWORD', '###');

    try {
        $conn = new PDO("mysql:host=DB_HOST;dbname=DB_NAME;charset=DB_CHARSET", DB_USER, DB_PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        echo "Connected successfully";

    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    
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

