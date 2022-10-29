<?php

require_once 'functions.php';

/**
 * Classe que obtem a manipula os dados de cada usuario
 * 
 */
abstract class User 
{
    protected $conn;
    protected $success;
    protected $errorMessage;
    protected $idUser;
    protected $name;
    protected $email;
    protected $pass;

    protected function __construct()
    {
        $this->conn = connection();
        $this->success = null;
        $this->idUser = null;
        $this->name = null;
        $this->email = null;
        $this->pass = null;
    }

    public function success() 
    {
        return $this->success;
    }

    public function getErrorMessage() 
    {
        return $this->errorMessage;
    }

    public function getIdUser() 
    {
        return $this->idUser;
    }

    public function getName() 
    {
        return $this->name;
    }

    public function getEmail() 
    {
        return $this->email;
    }

    public function getPassword() 
    {
        return $this->pass;
    }
}