<?php
session_start();
require 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | Community Portal</title>
    <link rel="stylesheet" href="dist/css/siqtheme.css">
    <link rel="stylesheet" href="dist/fonts/fontawesome.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/css/bootstrap.min.css">
</head>
<body class="theme-dark">

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark py-3">
    <div class="container d-flex justify-content-between align-items-center">

        <!-- Brand Left -->
        <a class="navbar-brand" href="index.php" style="font-size: 1.3rem; font-weight: bold;">
            <span style="color:#3498db;">Man</span>agementz
        </a>

        <!-- Center Navigation Links -->
        <div class="mx-auto">
            <ul class="navbar-nav flex-row">
                <li class="nav-item mx-3">
                    <a class="nav-link" href="index.php" style="font-size: 1rem;">Home</a>
                </li>
                <li class="nav-item mx-3">
                    <a class="nav-link" href="about.php" style="font-size: 1rem;">About</a>
                </li>
                   <li class="nav-item mx-3">
                    <a class="nav-link" href="products.php" style="font-size: 1rem;">Products</a>
                </li>
            </ul>
        </div>

        <!-- Right Logout Button -->
        <?php if (isset($_SESSION['role'])): ?>
            <form class="form-inline" action="logout.php" method="post">
                <button class="btn btn-outline-light" type="submit">Logout</button>
            </form>
        <?php endif; ?>

    </div>
</nav><!-- HERO SECTION -->
<div class="container text-center my-5">
    <h1 class="display-4 text-info">About Community Portal</h1>
    <p class="lead text-light">Connecting members, sharing announcements, and building a strong community.</p>
</div>

<!-- ABOUT CONTENT -->
<div class="container my-5">
    <div class="row align-items-center mb-5">
        <div class="col-md-6">
            <img src="assets/img/profile/360_F_418528804_xgyFvVsMSHeWk1UgDtR9aoccqSC7BrHy.jpg" alt="Our Team" class="img-fluid rounded shadow">
        </div>
        <div class="col-md-6 text-light">
            <h2>Our Mission</h2>
            <p>Our Community Portal is designed to bring together members, share important updates, and provide a platform where everyone can connect and collaborate. We aim to foster a friendly and engaging environment for all our members.</p>
            <ul>
                <li>Stay updated with latest announcements</li>
                <li>Connect with other members</li>
                <li>Engage in community discussions</li>
                <li>Receive support from admins quickly</li>
            </ul>
        </div>
    </div>

    <div class="row align-items-center mb-5">
        <div class="col-md-6 order-md-2">
            <img src="assets/img/profile/website-grow-your-business2-scaled.jpg" alt="Growth" class="img-fluid rounded shadow">
        </div>
        <div class="col-md-6 order-md-1 text-light">
            <h2>Our Vision</h2>
            <p>We envision a community that is informed, engaged, and connected. Our platform ensures that members can access all information, stay in touch with the latest news, and feel part of a collaborative network.</p>
        </div>
    </div>

    <div class="text-center text-light">
        <h2>Meet Our Admins</h2>
        <div class="row justify-content-center mt-4">
            <div class="col-md-3 mb-4">
                <div class="card bg-dark text-light text-center">
                    <img src="assets/img/profile/profile-02.jpg" alt="Admin 1" class="card-img-top rounded-circle mt-3" style="width:150px; margin:auto;">
                    <div class="card-body">
                        <h5 class="card-title">Arbaz Khan</h5>
                        <p class="card-text">Founder & Lead Admin</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card bg-dark text-light text-center">
                    <img src="assets/img/profile/profile-06.jpg" alt="Admin 2" class="card-img-top rounded-circle mt-3" style="width:150px; margin:auto;">
                    <div class="card-body">
                        <h5 class="card-title">Emily R.</h5>
                        <p class="card-text">Community Manager</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card bg-dark text-light text-center">
                    <img src="assets/img/profile/profile-05.jpg" alt="Admin 3" class="card-img-top rounded-circle mt-3" style="width:150px; margin:auto;">
                    <div class="card-body">
                        <h5 class="card-title">Michael B.</h5>
                        <p class="card-text">Tech & Support Lead</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FOOTER -->
<footer class="text-center mt-5 mb-3 text-muted">
    &copy; <?= date('Y') ?> Community Portal. All Rights Reserved.
    <div class="text-center mt-3">
        <a href="#" class="text-light mx-2"><i class="ti-facebook"></i></a>
        <a href="#" class="text-light mx-2"><i class="ti-twitter"></i></a>
        <a href="#" class="text-light mx-2"><i class="ti-instagram"></i></a>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.8/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/js/bootstrap.min.js"></script>
</body>
</html>
