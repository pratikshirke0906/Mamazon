<?php
session_start();
require_once 'database.php';

if(isset($_SESSION['user_id']) && isset($_POST['productId'])) {
    $userId = $_SESSION['user_id'];
    $productId = $_POST['productId'];
    $quantity = 1; // Assuming quantity is always 1 when adding to cart
    
    // Check if the product already exists in the cart for the user
    $stmt_check = $conn->prepare("SELECT * FROM cart_items WHERE user_id = ? AND product_id = ?");
    $stmt_check->bind_param("ii", $userId, $productId);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    
    if ($result_check->num_rows > 0) {
        // If the product exists, update its quantity
        $stmt_update = $conn->prepare("UPDATE cart_items SET quantity = quantity + ? WHERE user_id = ? AND product_id = ?");
        $stmt_update->bind_param("iii", $quantity, $userId, $productId);
        if ($stmt_update->execute()) {
            // Return success response
            http_response_code(200);
        } else {
            // Return error response
            http_response_code(500);
        }
    } else {
        // If the product doesn't exist, insert it into the cart_items table
        $stmt_insert = $conn->prepare("INSERT INTO cart_items (user_id, product_id, quantity) VALUES (?, ?, ?)");
        $stmt_insert->bind_param("iii", $userId, $productId, $quantity);
        if ($stmt_insert->execute()) {
            // Return success response
            http_response_code(200);
        } else {
            // Return error response
            http_response_code(500);
        }
    }
} else {
    // Return error response if user is not logged in or productId is not provided
    http_response_code(400);
}
?>
