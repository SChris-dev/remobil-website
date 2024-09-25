<?php
session_start();
include "config.php"; // Include your database configuration

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = 'anggota'; // Default role

    // Hash the password for security
    $hashedPassword = md5($password);

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $hashedPassword, $role);

    if ($stmt->execute()) {
        // Redirect to login page after successful registration
        header("Location: login.php");
        exit();
    } else {
        echo "Error: " . $stmt->error; // Display error if registration fails
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Remobil | Register</title>
    <!-- Include AdminLTE CSS -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- Include FontAwesome for icons -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <style>
        :root {
            --main-color: #E4501D;
            --secondary-color: #892D0E;
            --text-color: #FFFFFF;
            --light-bg: #FFF5F2;
            --dark-bg: #2C1006;
        }
        body {
            background-color: var(--light-bg);
        }
        .login-box {
            background-color: var(--text-color);
        }
        .card-header {
            background-color: var(--main-color) !important;
            color: var(--text-color);
        }
        .btn-success {
            background-color: var(--main-color);
            border-color: var(--main-color);
        }
        .btn-success:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        .alert.alert-danger.small {
            font-size: 0.875em; /* Smaller font size */
            padding: 0.5em; /* Smaller padding */
            text-align: center; /* Center the text */
        }
    </style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="card">
        <div class="card-header login-logo bg-gray-dark">
            <a href="index.php"><b>Remobil</b></a>
        </div>
        <div class="card-body login-card-body">
            <!-- Display error message if there is one -->
            <?php if (isset($error)): ?>
                <div class="alert alert-danger small">
                    <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
                </div>
            <?php endif; ?>
            <!-- Registration Form -->
            <form action="register.php" method="POST">
                <div class="input-group mb-3">
                    <input type="text" name="username" class="form-control" placeholder="Username" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8"></div>
                    <div class="col-4">
                        <button type="submit" class="btn btn-success btn-block">Register</button>
                    </div>
                </div>
            </form>
            <br>
            <p>Already have an account? <a href="login.php">Login here</a></p>
        </div>
    </div>
</div>
<!-- Include jQuery and AdminLTE JS -->
<script src="plugins/jquery/jquery.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>