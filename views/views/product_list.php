<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
</head>
<body>
    <h1>Products</h1>
    <ul>
        <?php foreach ($products as $product): ?>
            <li><?php echo $product['ProductName']; ?> - $<?php echo $product['Price']; ?></li>
        <?php endforeach; ?>
    </ul>
    <p>hello</p>
</body>
</html>
