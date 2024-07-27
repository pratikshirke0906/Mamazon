<?php
session_start();
require_once 'database.php';

// Fetch products for each category
$stmt = $conn->prepare("SELECT * FROM products WHERE category = ?");
$categories = ['mobile phones', 'shoes', 'men\'s clothing', 'women\'s clothing', 'electronics'];
$productsByCategory = array();

foreach ($categories as $category) {
    $stmt->bind_param("s", $category);
    $stmt->execute();
    $result = $stmt->get_result();
    $productsByCategory[$category] = $result->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Shopping Portal</title>

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" crossorigin="anonymous" />
</head>
<body>

<nav class="navbar navbar-expand-lg custom-bg-color fixed-top">
    <img src="logo.png" style="height:5%;width:5%;">
    <a class="navbar-brand" href="#">Mamazon</a>
        <div class="welcomemsg">
        <?php if (isset($_SESSION['user_id'])): ?>
        <h2 class="mb-4">Welcome, <?php echo $_SESSION['username']; ?>!</h2>
    <?php endif; ?>
        </div>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto" style="justify-content: space-evenly;">
        <li class="nav-item active">
            <a class="nav-link" href="#">
                <i class="fas fa-home"></i> Home
            </a>
        </li>
        <?php if (isset($_SESSION['user_id'])): ?>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </li>
        <?php else: ?>
            <li class="nav-item">
                <a class="nav-link" href="login.php">
                    <i class="fas fa-sign-in-alt"></i> Login
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="register.php">
                    <i class="fas fa-user-plus"></i> Register
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

<div class="container" style="margin-top:50px;">
    <h2 class="mb-4">Featured Products</h2>
    <?php
    // Output products by category
    foreach ($productsByCategory as $category => $products) {
        $capitalizedCategory = ucfirst($category); // Capitalize the category name
        echo "<h3>$capitalizedCategory</h3>";
        echo "<div class='row'>";
        foreach ($products as $product) {
            echo "<div class='col-md-3'>";
            echo "<div class='product-card'>";
            echo "<div class='product-img' style='background-image: url(\"{$product['image_url']}\")'></div>";
            echo "<div class='product-details p-3'>";
            echo "<h5 class='product-title'>{$product['name']}</h5>";
            echo "<p class='product-price'>Rs {$product['price']}</p>";
            echo "<button class='btn btn-primary btn-sm' onclick='addToCart({$product['id']})'>Add to Cart</button>";
            echo "</div></div></div>";
        }
        echo "</div>";
    }
    ?>
</div>

<footer class="footer mt-auto py-3 bg-dark text-white">
    <div class="container">
        <div class="row" style="margin-top:0px;">
            <div class="col-md-6">
                <h5>Contact Us</h5>
                <ul class="list-unstyled">
                    <li>Email: mamazon.com</li>
                    <li>Phone: +919970940032</li>
                </ul>
                <div class="social-icons">
                    <a href="#" class="text-white"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            <div class="col-md-6 text-right">
                <h5>Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Products</a></li>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">FAQ</a></li>
                </ul>
            </div>
        </div>
        <div class="text-center mt-4">
            <span>&copy; 2024 mamazon.com All rights reserved.</span>
        </div>
    </div>
</footer>

<script>
// Function to fetch products and generate product cards
function fetchAndGenerateProductCards() {
    // Fetch products from server
    fetch('get_products.php')
        .then(response => response.json())
        .then(products => {
            // Handle fetched products
        })
        .catch(error => {
            console.error('Error fetching products:', error);
        });
}

function addToCart(productId) {
    // Send AJAX request to addToCart.php
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "addToCart.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                // Handle successful response
                alert("Product added to cart!");
            } else {
                // Handle error response
                alert("Error: Unable to add product to cart.");
            }
        }
    };
    xhr.send("productId=" + productId);
}
</script>

</body>
</html>
.