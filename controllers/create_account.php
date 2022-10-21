<?php

require_once '/lib/functions.php';
require_once '/lib/CreateUser.php';

$pagSuccess = 'user_registered.php';
$validation = 4;

$infos = [
    'name' => '',
    'email' => '',
    'pass' => '',
    'confir_pass' => ''
];

$msg_errors = [
    'name' => '',
    'email' => '',
    'pass' => '',
    'confir_pass' => '',
    'email_exis' => ''
];

// validações de login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['email'])) {
        $infos['email'] = clear($_POST['email']);
    }
    
    if (isset($_POST['pass'])) {
        $infos['pass'] = clear($_POST['pass']);
    }
    
    if (isset($_POST['confir_pass'])) {
        $infos['confir_pass'] = clear($_POST['confir_pass']);
    }
    
    
    if ($infos['name'] == '') {
        $msg_errors['name'] = "Campo de preenchimento obrigatorio";
    } elseif (!preg_match("@(\s){1,}@", $infos['name'])) {
        $msg_errors['name'] = "Favor digite o seu nome completo";
    } elseif (preg_match("@[^a-zA-ZÀ-ú\s]@", $infos['name'])) {
        $msg_errors['name'] = "Favor digite somente letras e espaços";
    } else {
        $validation--;
    }
    
    $msg_errors['email'] = validationEmail($infos['email']);
    
    if ($msg_errors['email'] === '') {
        $validation--;
    }
    
    if (strlen($infos['pass']) !== 8) {
        $msg_errors['pass'] = "OPS! Sua senha precisa conter exatamente 8 caracteres.";
    } elseif (preg_match("![^a-zA-Z0-9@]!", $infos['pass'])) {
        $msg_errors['pass'] = "OPS! A senha devem conter somente letras, números e o sinal de (@)";
    } else {
        $validation--;
    }
    
    
    if ($infos['pass'] !== $infos['confir_pass']) {
        $msg_errors['confir_pass'] = "OPS! As senhas devem ser iguais";
    } else {
        $validation--;
    } 
    
    if ($validation === 0) {
        $user = new CreateUser(
            $infos['name'],
            $infos['email'],
            $infos['pass']
        );
    
        if ($user->success()) {
            header("location: {$pagSuccess}");
        } else {
            $msg_errors['email_exis'] = $user->getErrorMessage();
        }
    
    }
    
}



