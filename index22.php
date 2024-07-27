<?php
session_start();
require_once 'database.php';

$stmt = $conn->prepare("SELECT * FROM products");
$stmt->execute();
$result = $stmt->get_result();
$products = $result->fetch_all(MYSQLI_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Shopping Portal</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" crossorigin="anonymous" />

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            padding-top: 60px;
        }
        .product-card {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            margin-bottom: 20px;
            overflow: hidden;
        }
        .product-img {
            height: 200px;
            background-color: #f1f1f1;
            background-size: cover;
            background-position: center;
        }
        .product-details {
            padding: 15px;
        }
        .product-title {
            font-weight: bold;
        }
        .product-price {
            color: #007bff;
        }
        .welcomemsg {
            color: white;
            position: absolute;
            top: 60%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .nav-link{
            margin-right:12px;
        }
        /* Footer Styles */
/* Footer Styles */
.footer {
    background-color: #343a40;
    color: #fff;
}

.footer h5 {
    color: #fff;
    font-weight: bold;
    margin-bottom: 15px;
}

.footer ul {
    list-style: none;
    padding-left: 0;
}

.footer ul li {
    margin-bottom: 8px;
}

.social-icons a {
    display: inline-block;
    width: 30px;
    height: 30px;
    line-height: 30px;
    text-align: center;
    border-radius: 50%;
    background-color: #555;
    margin-right: 5px;
    transition: background-color 0.3s ease;
}

.social-icons a:hover {
    background-color: #007bff;
}

.social-icons a i {
    color: #fff;
}

.footer a {
    color: #fff;
    text-decoration: none;
    transition: color 0.3s ease;
}

.footer a:hover {
    color: #007bff;
}

    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="#">Online Shopping</a>
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

<div class="container">
    <h2 class="mb-4">Featured Products</h2>
    <div class="row" id="product-container"></div>
</div>
<footer class="footer mt-auto py-3 bg-dark text-white">
    <div class="container">
        <div class="row" style="margin-top:0px;">
            <div class="col-md-6">
                <h5>Contact Us</h5>
                <ul class="list-unstyled">
                    <li>Email: contact@example.com</li>
                    <li>Phone: +1234567890</li>
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
            <span>&copy; 2024 Online Shopping Portal</span>
        </div>
    </div>
</footer>

<script>
// Function to fetch products and generate product cards
function fetchAndGenerateProductCards() {
    const container = document.getElementById('product-container');
    container.innerHTML = '';

    // Fetch products from server
    fetch('get_products.php')
        .then(response => response.json())
        .then(products => {
            products.forEach(product => {
                const card = document.createElement('div');
                card.classList.add('col-md-3');

                const cardHtml = `
                    <div class="product-card">
                        <div class="product-img" style="background-image: url('${product.image_url}')"></div>
                        <div class="product-details p-3">
                            <h5 class="product-title">${product.name}</h5>
                            <p class="product-price">Rs ${product.price}</p>
                            <button class="btn btn-primary btn-sm" onclick="addToCart(${product.id})">Add to Cart</button>
                        </div>
                    </div>
                `;
                card.innerHTML = cardHtml;
                container.appendChild(card);
            });
        })
        .catch(error => {
            console.error('Error fetching products:', error);
        });
}

// Call the function to fetch and generate product cards
fetchAndGenerateProductCards();


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
