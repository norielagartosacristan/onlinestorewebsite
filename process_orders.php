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

// Order processing
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customerID = $conn->real_escape_string($_POST['customerID']);
    $shippingAddress = $conn->real_escape_string($_POST['shippingAddress']);
    $paymentMethod = $conn->real_escape_string($_POST['paymentMethod']);
    $cartItems = json_decode($_POST['cartItems'], true); // JSON string of cart items

    // Calculate total amount
    $totalAmount = 0;
    foreach ($cartItems as $item) {
        $totalAmount += $item['price'] * $item['quantity'];
    }

    // Insert order into Orders table
    $sql = "INSERT INTO Orders (CustomerID, TotalAmount, ShippingAddress, PaymentMethod)
            VALUES ('$customerID', '$totalAmount', '$shippingAddress', '$paymentMethod')";

    if ($conn->query($sql) === TRUE) {
        $orderID = $conn->insert_id;

        // Insert each item into OrderItems table
        foreach ($cartItems as $item) {
            $productID = $item['productID'];
            $quantity = $item['quantity'];
            $priceAtPurchase = $item['price'];

            $sql = "INSERT INTO OrderItems (OrderID, ProductID, Quantity, PriceAtPurchase)
                    VALUES ('$orderID', '$productID', '$quantity', '$priceAtPurchase')";

            if ($conn->query($sql) !== TRUE) {
                echo "Error inserting order item: " . $conn->error . "<br>";
            }
        }

        echo "Order placed successfully!<br>";
    } else {
        echo "Error placing order: " . $conn->error;
    }
}

$conn->close();
?>

<!-- HTML form for placing an order -->
<form action="process_order.php" method="post">
    <label for="customerID">Customer ID:</label>
    <input type="number" name="customerID" required><br>
    <label for="shippingAddress">Shipping Address:</label>
    <textarea name="shippingAddress" required></textarea><br>
    <label for="paymentMethod">Payment Method:</label>
    <input type="text" name="paymentMethod" required><br>
    <label for="cartItems">Cart Items (JSON):</label>
    <textarea name="cartItems" required></textarea><br>
    <input type="submit" value="Place Order">
</form>
