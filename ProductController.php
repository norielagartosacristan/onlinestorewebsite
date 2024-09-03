<?php

class ProductController extends AppController
{
    public function __construct()
    {
        parent::__construct('Product');
    }

    public function index()
    {
        $products = $this->model->getAllProducts();
        $this->render('products/product_list', ['products' => $products]);
    }

    public function category($category)
    {
        $products = $this->model->getProductsByCategory($category);
        $this->render('products/product_list', ['products' => $products]);
    }
}

?>
