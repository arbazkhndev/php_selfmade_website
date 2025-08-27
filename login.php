<?php
session_start();
require 'db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usernameOrEmail = trim($_POST['username_or_email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($usernameOrEmail === '' || $password === '') {
        $error = 'Please enter username/email and password.';
    } else {
        $stmt = $conn->prepare('SELECT id, username, email, password, role FROM users WHERE username = ? OR email = ? LIMIT 1');
        if (!$stmt) {
            die('DB error: ' . $conn->error);
        }
        $stmt->bind_param('ss', $usernameOrEmail, $usernameOrEmail);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res && $res->num_rows === 1) {
            $user = $res->fetch_assoc();
if (password_verify($password, $user['password'])) {
    // Set session variables
    $_SESSION['user_id'] = $user['id']; 
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $user['role'];

    // Redirect based on role
    if ($user['role'] === 'admin') {
        header('Location: sample.php');
    } else {
        header('Location: index.php');
    }
    exit;
}

            
            else {
                $error = 'Invalid password.';
            }
        } else {
            $error = 'User not found.';
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | siQtheme</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
    <!-- Themify Icons -->
    <link rel="stylesheet" href="dist/fonts/themify.css">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #232526 0%, #414345 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
        }
        .glass-card {
            background: rgba(34, 40, 49, 0.85);
            border-radius: 18px;
            box-shadow: 0 0 32px 0 #3498db, 0 0 64px 0 #8e44ad;
            animation: shadow-move 2.5s infinite alternate;
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border: 1px solid rgba(44, 62, 80, 0.18);
            padding: 3.5rem 2.5rem;
            width: 100%;
            max-width: 440px;
        }
        @keyframes shadow-move {
            0% {
                box-shadow: 0 0 32px 0 #3498db, 0 0 64px 0 #8e44ad;
            }
            50% {
                box-shadow: 0 0 64px 0 #8e44ad, 0 0 32px 0 #3498db;
            }
            100% {
                box-shadow: 0 0 32px 0 #8e44ad, 0 0 64px 0 #3498db;
            }
        }
        .glass-card .logo {
            font-size: 2.8rem; /* Bigger title */
            font-weight: bold;
            color: #3498db;
            letter-spacing: 2px;
            margin-bottom: 1.5rem;
            text-align: center;
        }
        .form-control {
            background: rgba(44, 62, 80, 0.7);
            border: none;
            border-radius: 8px;
            color: #fff;
        }
        .form-control:focus {
            background: rgba(44, 62, 80, 0.9);
            color: #fff;
            box-shadow: none;
        }
        .btn-login {
            background: linear-gradient(90deg, #3498db 0%, #2980b9 100%);
            color: #fff;
            border-radius: 8px;
            font-weight: 600;
            letter-spacing: 1px;
            border: none;
        }
        .btn-login:hover {
            background: linear-gradient(90deg, #2980b9 0%, #3498db 100%);
        }
        .input-group-text {
            background: transparent;
            border: none;
            color: #3498db;
        }
        .forgot-link {
            color: #3498db;
            font-size: 0.95rem;
        }
        .forgot-link:hover {
            text-decoration: underline;
            color: #fff;
        }
        .err {
            color: #e74c3c;
            text-align: center;
            margin-top: 1rem;
            margin-bottom: 0;
        }
        label {
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="glass-card">
        <div class="logo">
            <i class="ti-lock"></i> Login
        </div>
        <form method="post">
            <div class="form-group">
                <label for="username_or_email">Username or Email</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="ti-user"></i></span>
                    </div>
                    <input type="text" class="form-control" id="username_or_email" name="username_or_email" required autofocus placeholder="Enter username or email" value="<?= htmlspecialchars($_POST['username_or_email'] ?? '') ?>">
                </div>
            </div>
            <div class="form-group mt-3">
                <label for="password">Password</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="ti-key"></i></span>
                    </div>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
            </div>
            <?php if ($error): ?><p class="err"><?= htmlspecialchars($error) ?></p><?php endif; ?>
            <div class="form-group mt-4">
                <button type="submit" class="btn btn-login btn-block">Login</button>
            </div>
            <div class="text-center mt-2">
                <a href="signup.php" class="forgot-link">Create an account</a> | 
                <a href="#" class="forgot-link">Forgot password?</a>
            </div>
        </form>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
