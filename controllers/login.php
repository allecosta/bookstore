<?php

session_start();

if (isset($_SESSION['id'])) {
    header('location: account.php');
}

session_unset();
session_destroy();

require_once '../lib/functions.php';
require_once '../lib/GetUser.php';

$infos = [
    'email' => '',
    'pass' => ''
];

$msg_errors = [
    'email' => '',
    'pass' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (isset($_POST['email'])) {
        $infos['email'] = clear($_POST['email']);
    }

    if (isset($_POST['pass'])) {
        $infos['pass'] = clear($_POST['pass']);
    }

    $msg_errors['email'] = validationEmail($infos['email']);

    if ($msg_errors['email'] === '') {
        $user = new GetUser($infos['email']);

        if (!$user->success()) {
            $msg_errors['email'] = $user->getErrorMessage();
        } else {

            if ($user->getPassword() !== $infos['pass']) {
                $msg_errors['pass'] = "OPS! Senha incorreta";
            } else {
                $_SESSION['id'] = $user->getIdUser();
                $_SESSION['name'] =$user->getName();

                if (isset($_POST['buy'])) {
                    $idProduct = clear($_POST['buy']);

                    header('location: buy.php?id={$idProduct}');
                }

            }
        }
    }
}