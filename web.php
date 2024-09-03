<?php

// Example routes file

$router->get('', 'ProductController@index');
$router->get('products', 'ProductController@index');
$router->get('products/category/{category}', 'ProductController@category');

?>
