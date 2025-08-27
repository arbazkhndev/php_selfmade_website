<?php
require 'db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? 'user';
    $email = trim($_POST['email'] ?? '');
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');

    if ($username === '' || $password === '') {
        $error = 'Please enter username and password.';
    } else {
        // Check if username exists
        $stmt = $conn->prepare('SELECT id FROM users WHERE username = ? LIMIT 1');
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res && $res->num_rows > 0) {
            $error = 'Username already exists.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare('INSERT INTO users (username, password, role, email, first_name, last_name) VALUES (?, ?, ?, ?, ?, ?)');
            $stmt->bind_param('ssssss', $username, $hash, $role, $email, $first_name, $last_name);
            if ($stmt->execute()) {
                $success = 'Account created! You can now <a href="login.php" class="forgot-link">login</a>.';
            } else {
                $error = 'Signup failed. Please try again.';
            }
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up | siQtheme</title>
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
            font-size: 2.8rem;
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
        .success {
            color: #2ecc71;
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
            <i class="ti-user"></i> Sign Up
        </div>
        <form method="post">
            <div class="form-group">
                <label for="first_name">First Name</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="ti-user"></i></span>
                    </div>
                    <input type="text" class="form-control" id="first_name" name="first_name" value="<?= htmlspecialchars($_POST['first_name'] ?? '') ?>" placeholder="Enter your first name">
                </div>
            </div>
            <div class="form-group mt-3">
                <label for="last_name">Last Name</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="ti-user"></i></span>
                    </div>
                    <input type="text" class="form-control" id="last_name" name="last_name" value="<?= htmlspecialchars($_POST['last_name'] ?? '') ?>" placeholder="Enter your last name">
                </div>
            </div>
            <div class="form-group mt-3">
                <label for="username">Username</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="ti-id-badge"></i></span>
                    </div>
                    <input type="text" class="form-control" id="username" name="username" required autofocus value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
                </div>
            </div>
            <div class="form-group mt-3">
                <label for="email">Email (optional)</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="ti-email"></i></span>
                    </div>
                    <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" placeholder="Enter your email">
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
            <div class="form-group mt-3">
                <label for="role">Role</label>
                <select class="form-control" id="role" name="role" required>
                    <option value="user" <?= (($_POST['role'] ?? '') === 'user') ? 'selected' : '' ?>>User</option>
                    <option value="admin" <?= (($_POST['role'] ?? '') === 'admin') ? 'selected' : '' ?>>Admin</option>
                </select>
            </div>
            <?php if ($error): ?><p class="err"><?= htmlspecialchars($error) ?></p><?php endif; ?>
            <?php if ($success): ?><p class="success"><?= $success ?></p><?php endif; ?>
            <div class="form-group mt-4">
                <button type="submit" class="btn btn-login btn-block">Sign Up</button>
            </div>
            <div class="text-center mt-2">
                <a href="login.php" class="forgot-link">Already have an account? Login</a>
            </div>
        </form>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
