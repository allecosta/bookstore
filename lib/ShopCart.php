<?php 

require_once 'functions.php';

class ShopCart 
{
    protected $shopCart;
    protected $list;
    protected $userId;

  
    public function __construct(int $user_id) 
    {
        checkUserIsLogged();

        $this->conn = connection();
        $this->userId = $user_id;
        $this->list = [];

        $queryResult = $this->conn->query("
            SELECT
                *
            FROM
                cart
            WHERE 
                id_user={$user_id};
        ")->fetchAll();

        if (count($queryResult) === 0) {
            $shopCartEncoded = json_encode(['products' => []]);
            $this->conn->exec("INSERT INTO cart (id_user, js_products) VALUES ({$this->userId}, '{$shopCartEncoded}');");
            $shopCartDecoded = ['products' => []];
        } elseif (count($queryResult) > 0) {
            $shopCartDecoded = json_decode($queryResult[0]['js_products'], true);
        }

        $this->shopCart = $shopCartDecoded;
    }

    public function getProductsIds() 
    {
        return $this->shopCart['products'];
    }

    public function getProducts() 
    {
        $pdoSql = $this->conn->prepare("
            SELECT 
                id_product, title, quantity, price
            FROM 
                products
            WHERE
                id_product=:id;
        ");

        $update = false;

        foreach ($this->shopCart['products'] as $key => $id) {
            $pdoSql->bindParam(":id", $id);
            $pdoSql->execute();

            $prod = $pdoSql->fetchAll();

            if (count($prod) === 0) {
                array_splice($this->shopCart['products'], $key, 1);
                $update = true;
            } else {
                array_push($this->list, $prod[0]);
            }
        }

        if ($update) {
            $shopCartEncoded = json_encode($this->shopCart);
            $this->conn->exec("
                UPDATE
                    cart
                SET
                    js_products='{$shopCartEncoded}'
                WHERE
                    id_user={$_SESSION['id_user']};
            ");
        }

        return $this->list;
    }

    protected function updateDb() 
    {
        $shopCartEncoded = json_encode($this->shopCart);
        $this->conn->exec("UPDATE cart SET id_user={$this->userId}, js_products='{$shopCartEncoded}';");
    }

    public function cleanAllProducts() 
    {
        $this->conn->exec("DELETE FROM cart WHERE id_user={$this->userId};");
        $this->shopCart = ['products' => []];
        $this->list = [];
    }

    public function addProducts(string $productId) 
    {
        $productId = clear($productId);

        if (array_search($productId, $this->shopCart['products'], true) === false) {
            array_push($this->shopCart['products'], $productId);

            $this->updateDb();
        }
    }

    public function removeProduct(string $productId) 
    {
        $key = array_search($productId, $this->shopCart['products'], true);

        if ($key !== false) {
            array_splice($this->shopCart['products'], $key, 1);

            $this->updateDb();
        }
    }
}