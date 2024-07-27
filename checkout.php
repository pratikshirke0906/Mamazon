<?php
session_start();
require_once 'database.php';

// Initialize $totalAmount
$totalAmount = isset($_SESSION['total_amount']) ? $_SESSION['total_amount'] : 0;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    // Fetch cart items
    $stmt = $conn->prepare("SELECT products.*, cart_items.quantity AS cart_quantity FROM cart_items INNER JOIN products ON cart_items.product_id = products.id WHERE cart_items.user_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $cartItems = $result->fetch_all(MYSQLI_ASSOC);

    // Insert order into database
    $shippingAddress = $_POST['shipping_address'];
    $shippingPhone = $_POST['shipping_phone'];
    $paymentMethod = $_POST['payment_method'];

    $stmt = $conn->prepare("INSERT INTO orders (user_id, total_amount, shipping_address, shipping_phone, payment_method) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("idsss", $userId, $totalAmount, $shippingAddress, $shippingPhone, $paymentMethod);
    $stmt->execute();
    $orderId = $stmt->insert_id;

    // Clear user's cart
    $stmt = $conn->prepare("DELETE FROM cart_items WHERE user_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();

    // Redirect based on payment method
    if ($paymentMethod === 'cod') {
        header("Location: orderconfirmation.php?orderId=$orderId");
        exit();
    } elseif ($paymentMethod === 'upi') {
        header("Location: upi_payment_gateway.php?orderId=$orderId");
        exit();
    }
}

// Display checkout form
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT products.*, cart_items.quantity AS cart_quantity FROM cart_items INNER JOIN products ON cart_items.product_id = products.id WHERE cart_items.user_id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$cartItems = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" crossorigin="anonymous" />
    <style>
        body {
            padding-top: 50px; /* Adjust this value as needed */
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
            <li class="nav-item">
                <a class="nav-link" href="cart.php">
                    <i class="fas fa-shopping-cart"></i> Cart
                </a>
            </li>
        </ul>
    </div>
</nav>

<div class="container mt-5">
    <h2>Checkout</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cartItems as $item): ?>
                <tr>
                    <td><?php echo $item['name']; ?></td>
                    <td>Rs <?php echo $item['price']; ?></td>
                    <td><?php echo $item['cart_quantity']; ?></td>
                    <td>Rs <?php echo $item['price'] * $item['cart_quantity']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <p class="font-weight-bold">Total Amount: Rs <?php echo number_format($totalAmount, 2); ?></p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label for="shipping_address">Shipping Address</label>
            <input type="text" class="form-control" id="shipping_address" name="shipping_address" required>
        </div>
        <div class="form-group">
            <label for="shipping_phone">Shipping Phone</label>
            <input type="text" class="form-control" id="shipping_phone" name="shipping_phone" required>
        </div>
        <div class="form-group">
            <label>Select Payment Method:</label><br>
            <input type="radio" id="cod" name="payment_method" value="cod">
            <label for="cod">Cash on Delivery</label><br>
            <input type="radio" id="upi" name="payment_method" value="upi">
            <label for="upi">UPI Payment</label><br>
        </div>
        <div style="text-align:center;"> 
        <button type="submit" class="btn btn-primary">Place Order</button>
        </div>
    </form>
</div>

<div class="footer">
    <p>&copy;2024 mamazon.com All rights reserved.</p>
</div> 
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
