<?php
session_start();
require_once 'database.php';

// Check if orderId is set
if(isset($_GET['orderId'])) {
    $orderId = $_GET['orderId'];

    // Fetch order details including payment status
    $stmt = $conn->prepare("SELECT * FROM orders WHERE id = ?");
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $result = $stmt->get_result();
    $order = $result->fetch_assoc();

    // Check payment status
    $paymentStatus = $order['payment_status'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" crossorigin="anonymous" />
    <style>
        body {
            padding-top: 70px; /* Adjust this value as needed */
        }
        .order-details {
            margin-bottom: 20px;
        }
        .print-btn {
            margin-top: 20px;
        }

        .footer {
            position: fixed;
            color:white;
            bottom: 0;
            width: 100%;
            background-color: #312f36;
            text-align: center;
            padding: 10px 0;
        }
        .custom-bg-color {
            background-color: #312f36;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg custom-bg-color fixed-top">
    <img src="logo.png" style="height:5%;width:5%;">
    <a class="navbar-brand" href="#">Mamazon</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto" style="justify-content: space-evenly;">
            <li class="nav-item active">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-home"></i> Home
                </a>
            </li>
            <?php if (isset($_SESSION['user_id'])): ?>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<div class="container mt-5">
    <div class="alert alert-success" role="alert">
        <h4 class="alert-heading">Thank you for your order!</h4>
        <p>Your order has been successfully placed.</p>
        <hr>
        <div class="order-details">
            <h5>Order Details</h5>
            <!-- Display order details here -->
            <p>Order ID: <?php echo isset($_GET['orderId']) ? $_GET['orderId'] : 'N/A'; ?></p>
            <!-- Add more order details as needed -->
            <?php if($paymentStatus === 'Success'): ?>
                <p>Payment status: Paid.</p>
            <?php else: ?>
                <p>Payment status: Pending</p>
            <?php endif; ?>
        </div>
        <div class="contact-info">
            <h5>Contact Information</h5>
            <!-- Include contact information or support details here -->
            <p>If you have any questions or need assistance, please contact us at support@example.com</p>
        </div>
        <div style="text-align:center;"> 
        <a href="#" class="btn btn-primary print-btn" onclick="window.print()">Print Order Confirmation</a>
        </div>
        
    </div>
</div>

<div class="footer">
    <p>&copy;2024 mamazon.com All rights reserved.</p>
</div> 
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
