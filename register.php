<?php
session_start();
require_once 'database.php';

$username = $email = $address = $phone = $password = "";
$username_err = $email_err = $address_err = $phone_err = $password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
    } else {
        $sql = "SELECT id FROM users WHERE username = ?";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $param_username);
            $param_username = trim($_POST["username"]);

            if ($stmt->execute()) {
                $stmt->store_result();

                if ($stmt->num_rows == 1) {
                    $username_err = "This username is already taken.";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            $stmt->close();
        }
    }

    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter an email.";
    } else {
        $email = trim($_POST["email"]);
    }

    if (empty(trim($_POST["address"]))) {
        $address_err = "Please enter an address.";
    } else {
        $address = trim($_POST["address"]);
    }

    if (empty(trim($_POST["phone"]))) {
        $phone_err = "Please enter a phone number.";
    } else {
        $phone = trim($_POST["phone"]);
    }

    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have at least 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    if (empty($username_err) && empty($email_err) && empty($address_err) && empty($phone_err) && empty($password_err)) {
        $sql = "INSERT INTO users (username, email, address, phone, password) VALUES (?, ?, ?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("sssss", $param_username, $param_email, $param_address, $param_phone, $param_password);

            $param_username = $username;
            $param_email = $email;
            $param_address = $address;
            $param_phone = $phone;
            $param_password = password_hash($password, PASSWORD_DEFAULT);

            if ($stmt->execute()) {
                echo '<script>alert("Registration successful. Please log in."); window.location.href = "login.php";</script>';
            } else {
                echo '<script>alert("Oops something went wrong!! please try again."); window.location.href = "register.php";</script>';
            }

            $stmt->close();
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Online Shopping Portal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 110px;
            max-width: 400px;
        }
        .card {
            border: none;
            border-radius: 6px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 8px; 
        }
        .card-body h2 {
            font-size: 25px; 
            font-weight:bolder;
        }
        .form-group {
            margin-bottom: 6px; 
        }
        .form-group input {
            height: 28px; 
            font-size: 12px;
        }
        .form-group .help-block {
            font-size: 10px; 
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
            <li class="nav-item">
                <a class="nav-link" href="login.php">
                    <i class="fas fa-sign-in-alt"></i> Login
                </a>
            </li>
        </ul>
    </div>
</nav>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h2 class="text-center mb-4">Create an account</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                        <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?php echo $username; ?>" required>
                            <span class="help-block"><?php echo $username_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                            <label for="email">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" required>
                            <span class="help-block"><?php echo $email_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" id="address" name="address" value="<?php echo $address; ?>" required>
                            <span class="help-block"><?php echo $address_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($phone_err)) ? 'has-error' : ''; ?>">
                            <label for="phone">Phone Number</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $phone; ?>" required>
                            <span class="help-block"><?php echo $phone_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                            <span class="help-block"><?php echo $password_err; ?></span>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Register</button>
                    </form>
                    <p class="mt-3 text-center">Already have an account? <a href="login.php">Login here</a>.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="footer">
    <p>&copy; 2024 mamazon.com All rights reserved.</p>
</div>

</body>
</html>
