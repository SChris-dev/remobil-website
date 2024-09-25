<?php
session_start();
include 'config.php';

function generateCaptcha() {
    $num1 = rand(1, 9);
    $num2 = rand(1, 9);
    $_SESSION['captcha_result'] = $num1 + $num2;
    return "$num1 + $num2";
}

function generateCSRFToken() {
    return bin2hex(random_bytes(32));
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = generateCSRFToken();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $csrf_token = $_POST['csrf_token'];
    if ($csrf_token !== $_SESSION['csrf_token']) {
        die("Invalid CSRF token");
    }

    $username = htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8');
    $password = htmlspecialchars(md5($_POST['password']), ENT_QUOTES, 'UTF-8');
    $captcha = intval($_POST['captcha']);

    if ($captcha === $_SESSION['captcha_result']) {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (md5($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['csrf_token'] = generateCSRFToken(); // regenerate CSRF token after login
                // header('Location: index.php');

                // Redirect user based on role
                switch($user['role']) {
                    case 'admin':
                        header("Location: dashboards/admin/admin_dashboard.php");
                        break;
                    case 'petugas':
                        header("Location: dashboards/petugas/petugas_dashboard.php");
                        break;
                    case 'anggota':
                        header("Location: index.php");
                        break;
                }
                exit();
            } else {
                $error = "Password salah!";
            }
        } else {
            $error = "Username tidak ditemukan!";
        }
    } else {
        $error = "Captcha salah!";
    }
}

$captcha_question = generateCaptcha();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Remobil | Login</title>
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
        /* Custom CSS to adjust the error box size and center the text */
        .alert.alert-danger.small {
            font-size: 0.875em; /* Smaller font size */
            padding: 0.5em; /* Smaller padding */
            text-align: center; /* Center the text */
        }
        /* Ensure input-group borders are visible */
        .input-group .form-control {
            border-right: 0;
        }
        .input-group .input-group-text {
            border-left: 0;
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
            <!-- Tampilkan pesan kesalahan jika ada -->
            <?php if (isset($error)): ?>
                <div class="alert alert-danger small">
                    <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
                </div>
            <?php endif; ?>
            <!-- Form login -->
            <form action="" method="post">
                <!-- Token CSRF tersembunyi untuk perlindungan -->
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">
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
                            <span class="fas fa-eye" id="togglePassword" style="cursor: pointer;"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="text" name="captcha" class="form-control" placeholder="Hitung <?= $captcha_question; ?> = " required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-question"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8"></div>
                    <div class="col-4">
                        <button type="submit" class="btn btn-success btn-block">Login</button>
                    </div>
                </div>
            </form>
            <br>
            <p>Don't have an account? <a href="register.php">Register here</a></p>
        </div>
    </div>
</div>
<!-- Include jQuery and AdminLTE JS -->
<script src="plugins/jquery/jquery.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>

<script>
    // JavaScript untuk toggle (show/hide) password ketika ikon mata diklik
    document.getElementById('togglePassword').addEventListener('click', function () {
        const passwordField = document.getElementById('password');
        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', type);
        this.classList.toggle('fa-eye-slash');
    });
</script>
</body>
</html>