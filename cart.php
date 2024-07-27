<?php
session_start();
require_once 'database.php';

$totalAmount = 0.00;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    // Fetch cart items
    $stmt = $conn->prepare("SELECT products.*, cart_items.quantity AS cart_quantity FROM cart_items INNER JOIN products ON cart_items.product_id = products.id WHERE cart_items.user_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $cartItems = $result->fetch_all(MYSQLI_ASSOC);

    // Calculate total amount
    foreach ($cartItems as $item) {
        $totalAmount += $item['price'] * $item['cart_quantity'];
    }

    // Store total amount in session
    $_SESSION['total_amount'] = $totalAmount;

    // Redirect to checkout page
    header("Location: checkout.php");
    exit();
}

// Display cart items
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
    <title>Cart</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" crossorigin="anonymous" />
    <style>
        body {
            padding-top: 70px; /* Adjust this value as needed */
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
    <h2>Your Shopping Cart</h2>
    <?php if(!empty($cartItems)): ?>
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
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" style="text-align:center;margin-top:50px;">
            <button type="submit" class="btn btn-primary">Proceed to Checkout</button>
        </form>
    <?php else: ?>
        <div class="alert alert-info" role="alert">
            Your cart is empty.
        </div>
    <?php endif; ?>
</div>

<div class="footer">
    <p>&copy;2024 mamazon.com All rights reserved.</p>
</div> 

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
