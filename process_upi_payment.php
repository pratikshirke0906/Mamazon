<?php
session_start();
require_once 'database.php';
// Process UPI payment and handle payment response
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $orderId = $_POST['order_id'];
    $upiId = $_POST['upi_id'];

    // Update the payment status in the orders table
    $stmt = $conn->prepare("UPDATE orders SET payment_status = 'success' WHERE id = ?");
    $stmt->bind_param("i", $orderId);
    $stmt->execute();

    // Check if the update was successful
    if ($stmt->affected_rows > 0) {
        // Payment status updated successfully
        // Redirect to the order confirmation page
        header("Location: orderconfirmation.php?orderId=$orderId");
        exit();
    } else {
        // Redirect back to checkout page with an error message if the update failed
        header("Location: checkout.php?error=payment_failed");
        exit();
    }
}
?>