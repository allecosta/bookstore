<?php

require_once 'functions.php';

/**
 * Classe que representa a estrutura básica de um produto
 * 
 */
abstract class Product 
{
    protected $conn;
    protected $productId = null;
    protected $sellerUserId = null;
    protected $productTitle = null;
    protected $quantityInStock = null;
    protected $price = null;
    protected $description = null;
    protected $productImage = null;
    protected $productImageType = null;

    protected function __construct()
    {
        $this->conn = connection();
    }

    protected function save() 
    {
        if ($this->checkAllData() == false || $this->productImage == false ||$this->productImageType = false) {
            return false;
        }

        $this->beginTransaction();
        return true;
    }

    protected function checkAllData() 
    {
        if (
            $this->productId &&
            $this->sellerUserId &&
            $this->productTitle &&
            $this->quantityInStock &&
            $this->price &&
            $this->description
        ) {
            return true;
        }
        else {
            return false;
        }
    }

    public function getProductId() 
    {
        return $this->productId;
    }

    public function getSellerUserId() 
    {
        return $this->sellerUserId;
    }

    public function getProductTitle() 
    {
        return $this->productTitle;
    }

    public function getQuantityInStock() 
    {
        return $this->quantityInStock;
    }

    public function getPrice() 
    {
        return $this->price;
    }

    public function getDescription() 
    {
        return $this->description;
    }

    public function setProductTitle($productTitle) 
    {
        if (strlen($productTitle) > 80) {
            return "O título do produto não poder ter mais que 80 caracteres!";
        } elseif (!empty($productTitle) && strlen($productTitle) <= 80) {
            $this->productTitle = $productTitle;

            return "";
        }
    }

    public function setQuantityInStock($quant) 
    {   
        $quant = (int)$quant;

        if (($quant != 0) && (!is_nan($quant)) && ($quant > 0) && ($quant <= 99)) {
            $this->quantityInStock = $quant;

            return "";

        } elseif (!empty($quant)) {
            return "A quantidade em estoque precisa ser um valor inteiro entre 1 e 99";
        }

        return "É obrigatorio o preechimento deste campo!";
    }

    public function setPrice($price) 
    {
        if (preg_match("@[^0-9,.]@", $price)) {
            return "Favor digitar somente números e virgula/ponto (para informar centavos)";
        } elseif (preg_match("@^[0-9]{1,5}[\.,][1-9]{1,2}$@", $price)) {
            $_price = str_replace(",", ".", $price);

            if (is_numeric($_price)) {
                $this->price = (float)$_price;

                return "";

            } else {
                return "OPS! Não é um preço valído";
            }

        } else {
            return "Preço inválido! Favor digitar um valor entre R$0,01 e R$99999,99! Use apenas uma virgula ou ponto";
        }

        return "OPS! Preço inválido";
    }

    public function setDescription($desc) 
    {
        if (!empty($desc) && (strlen($desc) <= 2000)) {
            $this->description = $desc;

            return "";

        } else {
            return "É obrigatório o preenchimento deste campo!";
        }
    }

    public function setImage($imageFieldName) 
    {
        $imageType = strtolower(pathinfo($_FILES[$imageFieldName]['name'], PATHINFO_EXTENSION));

        switch ($imageType) {
            case "png":
            case "jpg":
            case "jpeg":
            case "gif":
            case "webp":
                break;
            default:
                return "OPS! Formato de imagem inválido";
        }

        $imageFile = fopen($_FILES[$imageFieldName]['tmp_name'], "rb");

        if ($imageFile !== false) {

            if ($_FILES[$imageFieldName]['size'] < 800000 && $_FILES[$imageFieldName]['size'] > 0) {
                $this->productImage = $imageFile;
                $this->productImageType = $imageType;

                return "";

            } else {
                return " A imagem deve ter no máximo(tamanho) de 1mb";
            }
        } else {
            return "Um erro aconteceu enquanto tentavamos salvar a imagem. Tente novamente!";
        }

        return "OPS! algum erro ocorreu na validação da imagem! Entre em contato com o administrador do sistema";
    }

}