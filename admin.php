<?php
// Database connection parameters
$servername = "localhost"; // Update if necessary
$username = "root";        // Update if necessary
$password = "";            // Update if necessary
$dbname = "ecommerce";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handling product upload
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productName = $conn->real_escape_string($_POST['productName']);
    $description = $conn->real_escape_string($_POST['description']);
    $price = $conn->real_escape_string($_POST['price']);
    $quantity = $conn->real_escape_string($_POST['quantity']);
    $categoryID = $conn->real_escape_string($_POST['categoryID']);
    $imageURL = ""; // Initialize as empty

    // Handling image upload
    if (isset($_FILES['image']['name']) && $_FILES['image']['error'] == 0) {
        $imageName = basename($_FILES['image']['name']);
        $imagePath = 'uploads/' . $imageName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
            $imageURL = $imagePath;
        } else {
            echo "Failed to upload image.<br>";
        }
    }

    // Insert product into database
    $sql = "INSERT INTO Products (ProductName, Description, Price, QuantityInStock, CategoryID, ImageURL)
            VALUES ('$productName', '$description', '$price', '$quantity', '$categoryID', '$imageURL')";

    if ($conn->query($sql) === TRUE) {
        echo "Product uploaded successfully!<br>";
    } else {
        echo "Error uploading product: " . $conn->error;
    }
}

// Fetching existing products
$sql = "SELECT * FROM Products";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>Admin Dashboard</h1>

    <!-- Product Upload Form -->
    <h2>Upload New Product</h2>
    <form action="admin_dashboard.php" method="post" enctype="multipart/form-data">
        <label for="productName">Product Name:</label>
        <input type="text" name="productName" required><br>
        <label for="description">Description:</label>
        <textarea name="description" required></textarea><br>
        <label for="price">Price:</label>
        <input type="number" name="price" step="0.01" required><br>
        <label for="quantity">Quantity In Stock:</label>
        <input type="number" name="quantity" required><br>
        <label for="categoryID">Category ID:</label>
        <input type="number" name="categoryID" required><br>
        <label for="image">Product Image:</label>
        <input type="file" name="image" accept="image/*"><br>
        <input type="submit" value="Upload Product">
    </form>

    <!-- List of Existing Products -->
    <h2>Existing Products</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Category ID</th>
                <th>Image</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['ProductID']; ?></td>
                        <td><?php echo $row['ProductName']; ?></td>
                        <td><?php echo $row['Description']; ?></td>
                        <td><?php echo $row['Price']; ?></td>
                        <td><?php echo $row['QuantityInStock']; ?></td>
                        <td><?php echo $row['CategoryID']; ?></td>
                        <td>
                            <?php if ($row['ImageURL']): ?>
                                <img src="<?php echo $row['ImageURL']; ?>" alt="Product Image" style="width: 100px;">
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">No products found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
