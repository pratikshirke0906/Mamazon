<?php
session_start();
require_once 'database.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UPI Payment Gateway</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;

            padding-top: 70px;
        }
        .container {
            max-width: 400px;
            margin: auto;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 50px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 20px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button[type="submit"]:hover {
            background-color: #0056b3;
        }
        a {
            display: block;
            text-align: center;
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            color: #0056b3;
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
    <div class="container">
        <img src="upi.png" alt="" class="img-fluid mb-4">
        <!-- Add UPI payment form or integrate with UPI payment SDK -->
        <!-- Example form for UPI payment -->
        <form action="process_upi_payment.php" method="post">
            <label for="upi_id">Enter UPI ID:</label>
            <input type="text" id="upi_id" name="upi_id" required>
            <input type="hidden" name="order_id" value="<?php echo isset($_GET['orderId']) ? $_GET['orderId'] : ''; ?>">
            <button type="submit">Pay Now</button>
        </form>
        <!-- Optionally, provide a back button or link -->
        <a href="javascript:history.back()">Back to Checkout</a>
    </div>
    <div class="footer">
    <p>&copy;2024 mamazon.com All rights reserved.</p>
</div> 
    <!-- Bootstrap JS (optional) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
