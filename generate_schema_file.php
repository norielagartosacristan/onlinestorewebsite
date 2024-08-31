<?php
// File name for the SQL schema
$filename = 'ecommerce_schema.sql';

// SQL schema to be written to the file
$schema = "
CREATE DATABASE IF NOT EXISTS ecommerce;

USE ecommerce;

CREATE TABLE IF NOT EXISTS Products (
    ProductID INT AUTO_INCREMENT PRIMARY KEY,
    ProductName VARCHAR(255) NOT NULL,
    Description TEXT,
    Price DECIMAL(10, 2) NOT NULL,
    QuantityInStock INT NOT NULL,
    CategoryID INT,
    ImageURL VARCHAR(255),
    DateAdded TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    IsActive BOOLEAN DEFAULT TRUE
);

CREATE TABLE IF NOT EXISTS Categories (
    CategoryID INT AUTO_INCREMENT PRIMARY KEY,
    CategoryName VARCHAR(255) NOT NULL,
    Description TEXT
);

CREATE TABLE IF NOT EXISTS ProductImages (
    ImageID INT AUTO_INCREMENT PRIMARY KEY,
    ProductID INT,
    ImageURL VARCHAR(255),
    FOREIGN KEY (ProductID) REFERENCES Products(ProductID) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS Orders (
    OrderID INT AUTO_INCREMENT PRIMARY KEY,
    CustomerID INT,
    OrderDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    TotalAmount DECIMAL(10, 2) NOT NULL,
    Status VARCHAR(50) DEFAULT 'Pending',
    ShippingAddress TEXT,
    PaymentMethod VARCHAR(50)
);

CREATE TABLE IF NOT EXISTS OrderItems (
    OrderItemID INT AUTO_INCREMENT PRIMARY KEY,
    OrderID INT,
    ProductID INT,
    Quantity INT NOT NULL,
    PriceAtPurchase DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (OrderID) REFERENCES Orders(OrderID) ON DELETE CASCADE,
    FOREIGN KEY (ProductID) REFERENCES Products(ProductID) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS Customers (
    CustomerID INT AUTO_INCREMENT PRIMARY KEY,
    FirstName VARCHAR(255) NOT NULL,
    LastName VARCHAR(255) NOT NULL,
    Email VARCHAR(255) UNIQUE NOT NULL,
    PasswordHash VARCHAR(255) NOT NULL,
    PhoneNumber VARCHAR(20),
    Address TEXT,
    DateRegistered TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
";

// Write the SQL schema to a file
if (file_put_contents($filename, $schema)) {
    echo "SQL schema file '$filename' created successfully!";
} else {
    echo "Failed to create SQL schema file.";
}
?>
