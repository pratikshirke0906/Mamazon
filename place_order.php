<?php
session_start();
require_once 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    // Create an order in the database
    $stmt = $conn->prepare("INSERT INTO orders (user_id) VALUES (?)");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $orderId = $stmt->insert_id;

    // Deduct ordered quantities from the product inventory
    $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity) SELECT ?, product_id, quantity FROM cart_items WHERE user_id = ?");
    $stmt->bind_param("ii", $orderId, $userId);
    $stmt->execute();

    // Clear the user's cart
    $stmt = $conn->prepare("DELETE FROM cart_items WHERE user_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();

    // Redirect to a confirmation page
    header("Location: order_confirmation.php?orderId=$orderId");
    exit();
} else {
    header("Location: index.php");
    exit();
}
?>
