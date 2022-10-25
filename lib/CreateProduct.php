<?php

require_once 'functions.php';
require_once 'Product.php';

/**
 * Classe responsavel por manipular a criação de novos produtos e inserir no database
 * 
 */

class CreateProdutct extends Product 
{
    public function __construct(int $idUser) 
    {
        parent::__construct();

        $this->sellerUserId = $idUser;
        $this->productId = $idUser . "_" . time();
    }

    public function save() 
    {
        if (!parent::save()) {
            return false;
        }

        $id = (clear($_SESSION['id_user']) . "_" . (time()));

        $sql = $this->conn->prepare("INSERT INTO products (id_user_sale, title, quantity, description, price, id_product)
                                        VALUES (:id_user_sale, :title, :quantity, :description, :price, :id_product)");

        $sql->bindParam(":id_user_sale", $_SESSION['id_user']);
        $sql->bindParam(":title", $this->productTitle);
        $sql->bindParam(":quantity", $this->quantityInStock);
        $sql->bindParam(":description", $this->description);
        $sql->bindParam(":price", $this->price);
        $sql->bindParam(":id_product", $this->productId);

        $successOne = $sql->execute();

        $sql2 = $this->conn->prepare("INSERT INTO image_products (id_product, img, type_img)
                                        VALUES (:id_product, :img, :type_img)");
        
        $sql2->bindParam(":id_product", $this->productId);
        $sql2->bindParam(":img", $this->productImage, PDO::PARAM_LOB);
        $sql2->bindParam(":type_img", $this->productImageType);

        $successTwo = $sql2->execute();

        if ($successOne && $successTwo) {
            $this->conn->commit();
            return true;
        } else {
            $this->conn->rollBack();
            return false;
        }
    }

}