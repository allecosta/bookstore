<?php

require_once 'Product.php';

/**
 * Classe repsonsavel por obter dados de um determinado produto
 * 
 */
class GetProduct extends Product 
{
    protected $errorMessage;

    public function __construct($productId)
    {
        parent::__construct();

        $queryResult = $this->conn->query("
            SELECT
                u.name,
                p.id_user_sale,
                p.id_product,
                p.title,
                p.quantity,
                p.description,
                p.price
            FROM 
                products as p
            INNER JOIN users as u on p.id_user_sale=u.id_user
            WHERE id_product='{$productId}';
        ")->fetchAll();

        if (count($queryResult) === 0) {
            $this->errorMessage = "OPS! Esse produto não existe em estoque";
        } elseif (count($queryResult) > 1) {
            throw new Exception("OPS! ID do produto está duplicado no database");
            exit;
        } else {
            $this->productId = $queryResult[0]['id_product'];
            $this->sellerUserId = $queryResult[0]['id_user_sale'];
            $this->productTitle = $queryResult[0]['title'];
            $this->quantityInstock = $queryResult[0]['quantity'];
            $this->description = $queryResult[0]['description'];
            $this->price = $queryResult[0]['price'];
            $this->sellerName = $queryResult[0]['name'];
        }
    }

    public function getSellerName() 
    {
        return $this->sellerName;
    } 
}