<?php

require_once 'functions.php';
require_once 'User.php';

/**
 * Classe responsavel pela criação de novas contas de usuarios 
 * Visualiza e insere os dados no database
 * 
 */

class CreateUser extends User 
{
    public function __construct(string $name, string $email, string $pass) 
    {
        parent::__construct();

        $result = $this->conn->query("SELECT email FROM users WHERE email='{$email}'")->fetchAll();

        if (count($result) > 0) {
            $this->success = false;
            $this->errorMessage = "OPS! Já existe um cadastro com este email! Tente outro!";
        } else {
            $this->conn->beginTransaction();
            $pdoSQL = $this->conn->prepare("INSERT INTO users (name, email, pass) VALUES (?, ?, ?)");
            $success = $pdoSQL->execute([$name, $email, $pass]);

            if ($success) {
                $this->conn->commit();
                $this->success = true;
            } else {
                $pdoSQL->rollBack();
                $this->success = false;

                throw new Exception("OPS! Erro no sistema! Comunique ao administrador para resolução");
            }
        }
    }
    
}