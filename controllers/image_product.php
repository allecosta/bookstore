<?php 

require '/lib/functions.php';

if (isset($_GET['id']) && count($_GET) === 1) {
    $idProduct = clear($_GET['id']);

    try {
        $conn = connectionDB();
        $stat = $conn->query("SELECT img, type_img FROM image_products WHERE id='{$idProduct}'");
        $result = $stat->fetchAll();

        header("Content-type: image/{$result[0]['type_img']}");

        echo $result[0]['img'];

    } catch (PDOException $e) {
        dbError($e);
    }
} else {
    header('location: /views/index.php');
}