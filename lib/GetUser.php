<?php

require_once 'functions.php';
require_once 'User.php';

/**
 * Classe responsavel por buscar as informações de um usuario no database
 * 
 */
class GetUser extends User 
{
    public function __construct($emailId)
    {
        parent::__construct();

        $query = false;

        if (is_int($emailId)) {
            $query = $this->conn->query("
                SELECT
                    id_user, name, email, pass
                FROM
                    users
                WHERE 
                    id_user='{$emailId}';
            ")->fetchAll();

            if (count($query) === 0) {
                $this->errorMessage = "OPS! Esse ID de usuário não existe";
            }

        } elseif (is_string($query)) {
            $query = $this->conn->query("
                SELECT 
                    id_user, name, email, pass
                FROM 
                    users
                WHERE 
                    email='{$emailId}';
            ")->fetchAll();

            if (count($query) === 0) {
                $this->errorMessage = "OPS! Esse email não possui conta registrada";
            }

        } else {
            throw new Exception("Objeto GetUser recebeu argumentos inválidos");
        }

        if (count($query) > 1) {
            throw new Exception("OPS! Erro no sistema! Usuário duplicado. Comunique ao administrador para resolução");
            exit;
        } elseif (count($query) === 1) {
            $this->idUser = $query[0]['id_user'];
            $this->name = $query[0]['name'];
            $this->email = $query[0]['email'];
            $this->pass = $query[0]['pass'];
            $this->success = true;
        }
    } 
}