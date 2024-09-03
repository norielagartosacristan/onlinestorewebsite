<?php

class ProductModel extends Database
{
    public function getAllProducts()
    {
        $sql = "SELECT * FROM Products";
        $stmt = $this->connect()->query($sql);
        return $stmt->fetchAll();
    }

    public function getProductsByCategory($category)
    {
        $sql = "SELECT * FROM Products WHERE Category = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$category]);
        return $stmt->fetchAll();
    }
}

?>
