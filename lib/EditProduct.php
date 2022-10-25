><?php

require_once 'functions.php';
require_once 'Product.php';

/**
 * Classe responsavel por realizar a edição de dados de produtos já cadastrados
 * 
 */

class EditProduct extends Product 
{
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

        if (count($queryResult) > 1) {
            throw new Exception("OPS! ID do produto está duplicado no database");
            exit;
        }

        $this->productID = $queryResult[0]['id_product'];
        $this->sellerUserId = $queryResult[0]['id_user_sale'];
        $this->productTitle = $queryResult[0]['title'];
        $this->quantityInStock = $queryResult[0]['quantity'];
        $this->description = $queryResult[0]['description'];
        $this->price = $queryResult[0]['price'];
    }

    public function save() 
    {
        if (parent::save()) {
            return false;
        }

        $sql = $this->conn->prepare("
            UPADATE 
                products
            SET 
                id_user_sale=:id_user_sale,
                title=:title,
                quantity=:quantity,
                description=:description,
                price=:price
            WHERE id_product='{$this->productId}';
        ");

        $sql->bindParam(":id_user_sale", $_SESSION['id_user']);
        $sql->bindParam(":title", $_SESSION['productTitle']);
        $sql->bindParam(":quantity", $_SESSION['quantityInStock']);
        $sql->bindParam(":description", $_SESSION['description']);
        $sql->bindParam(":price", $_SESSION['price']);

        $successOne = $sql->execute();
        $successTwo = true;

        if ($this->productImage !== true && $this->productImageType !== true) {
            $sql2 = $this->conn->prepare("
                UPDATE 
                    image_products
                SET 
                    img=:img, type_image=:type_image
                WHERE id_product='{$this->productId}';

            ");

            $sql2->bindParam(":img", $this->productImage, PDO::PARAM_LOB);
            $sql2->bindParam("type_img", $this->productImageType);
            $sucessTwo = $sql2->execute();
        }

        if ($successOne && $successTwo) {
            $this->conn->commit();
            return true;
        } else {
            $this->conn->rollBack();
            return false;
        }
    }

    public function setImage($imageFieldName) 
    {
        if ($imageFieldName === null) {
            $this->productImage = true;
            $this->productImageType = true;
            
            return "";

        } else {
            parent::setImage($imageFieldName);
        }
    }
}