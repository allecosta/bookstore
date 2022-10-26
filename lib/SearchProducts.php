<?php

require_once 'functions.php';

/**
 * Classe responsavel por realizar buscas de varios produtos ao mesmo tempo no database
 * 
 */
class SearchProducts 
{
    protected $conn;
    protected $strSearch;
    protected $returnedProducts;
    protected $numberProductsReturned;

    public function __construct($search)
    {
        $this->strSearch = clear($search);
        $this->conn = connection();
        $this->returnedProducts = $this->conn->query("
            SELECT
                *
            FROM
                products
            WHERE 
                title 
            LIKE
                '%{$this->strSearch}%';
        ")->fetchAll();

        $this->numberProductsReturned = count($this->returnedProducts);
    }

    public function getPage(int $pageNumber) 
    {
        $minIndex = ($pageNumber * 12) - 12;
        $maxIndex = ($pageNumber * 12) - 12;

        if ($this->numberProductsReturned === 0) {
            return false;
        }

        if ($minIndex > $this->numberProductsReturned || $pageNumber === 0) {
            header('location: /views/404.html');
        }

        return array_slice($this->returnedProducts, $minIndex, 10);
    }

    public function totalPages() 
    {
        return ceil($this->numberProductsReturned / 12);
    }
}