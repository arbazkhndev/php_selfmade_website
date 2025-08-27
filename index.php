<?php
session_start();
require 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community Portal</title>
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
</nav>


<!-- MAIN CONTENT -->
<div class="container mt-4">

    <!-- HERO SECTION -->
    <div class="text-center mb-5">
        <h1>Welcome to Our Community Portal</h1>
        <p>Sign up, join the community, and stay updated!</p>
        <?php if (!isset($_SESSION['role'])): ?>
            <a href="signup.php" class="btn btn-primary">Sign Up</a>
            <a href="login.php" class="btn btn-secondary">Login</a>
        <?php endif; ?>
    </div>

    <!-- WELCOME CARD FOR NORMAL USERS -->
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] !== 'admin'): ?>
        <div class="card mb-4">
            <div class="card-header"><i class="ti-user"></i> Welcome, <?= htmlspecialchars($_SESSION['username']) ?>!</div>
            <div class="card-body">
                <p>Thanks for joining our community portal! Connect with members and stay updated.</p>
            </div>
        </div>
    <?php endif; ?>

    <!-- ANNOUNCEMENTS -->
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="ti-announcement"></i> Latest Announcements</span>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <a href="create_announcement.php" class="btn btn-sm btn-primary">Create Announcement</a>
            <?php endif; ?>
        </div>
        <ul class="list-group list-group-flush">
            <?php
            $stmt = $conn->prepare("SELECT id, title, description FROM announcements ORDER BY id DESC LIMIT 5");
            $stmt->execute();
            $result = $stmt->get_result();
            while($row = $result->fetch_assoc()):
            ?>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div>
                        <strong><?= htmlspecialchars($row['title']) ?></strong>
                        <p><?= htmlspecialchars($row['description']) ?></p>
                    </div>
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <div class="btn-group-vertical">
                            <a href="edit_announcement.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-secondary mb-1">Edit</a>
                            <a href="delete_announcement.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-danger">Delete</a>
                        </div>
                    <?php endif; ?>
                </li>
            <?php endwhile; $stmt->close(); ?>
        </ul>
    </div>

    <!-- QUICK STATS -->
    <div class="row text-center mb-5">
        <div class="col-md-4">
            <div class="card bg-dark text-white mb-3">
                <div class="card-body">
                    <h3><?= $conn->query("SELECT COUNT(*) AS total FROM users")->fetch_assoc()['total']; ?></h3>
                    <p>Total Members</p>
                </div>
            </div>
        </div>

        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <div class="col-md-4">
                <div class="card bg-dark text-white mb-3">
                    <div class="card-body">
                        <h3><?= $conn->query("SELECT COUNT(*) AS total FROM announcements")->fetch_assoc()['total']; ?></h3>
                        <p>Total Announcements</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-dark text-white mb-3">
                    <div class="card-body">
                        <h3><?= $conn->query("SELECT COUNT(*) AS admins FROM users WHERE role='admin'")->fetch_assoc()['admins']; ?></h3>
                        <p>Total Admins</p>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="col-md-4">
                <div class="card bg-dark text-white mb-3">
                    <div class="card-body">
                        <p>Stay updated with the latest announcements.</p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- TESTIMONIALS -->
    <div class="container my-5">
        <h2 class="text-center mb-4 text-info">What Our Members Say</h2>
        <div id="testimonialCarousel" class="carousel slide" data-ride="carousel" data-interval="4000">
            <div class="carousel-inner">

                <!-- Slide 1 -->
                <div class="carousel-item active">
                    <div class="row justify-content-center">
                        <?php
                        $testimonials = [
                            ["This community portal is amazing! Easy to use and very helpful.", "Sarah J."],
                            ["I love the updates and announcements, everything is organized.", "Michael B."],
                            ["Admins are very responsive and helpful. Highly recommended.", "Emily R."],
                            ["The portal has everything I need to stay updated. Fantastic!", "John D."]
                        ];
                        for($i=0;$i<3;$i++):
                        ?>
                        <div class="col-md-4">
                            <div class="card text-dark">
                                <div class="card-body">
                                    <p>"<?= $testimonials[$i][0] ?>"</p>
                                    <h6>- <?= $testimonials[$i][1] ?></h6>
                                </div>
                            </div>
                        </div>
                        <?php endfor; ?>
                    </div>
                </div>

                <!-- Slide 2 -->
                <div class="carousel-item">
                    <div class="row justify-content-center">
                        <?php for($i=1;$i<=3;$i++): ?>
                        <div class="col-md-4">
                            <div class="card text-dark">
                                <div class="card-body">
                                    <p>"<?= $testimonials[$i][0] ?>"</p>
                                    <h6>- <?= $testimonials[$i][1] ?></h6>
                                </div>
                            </div>
                        </div>
                        <?php endfor; ?>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <style>
        #testimonialCarousel .card {
            min-height: 200px;
            font-size: 1.1rem;
            margin-bottom: 15px;
            background-color: #2c2f33; 
            border: none; 
            text-align: center; 
        }
        #testimonialCarousel h6 { margin-top: 10px; font-weight: 600; color: #3498db; }
        #testimonialCarousel p { color: #fff; }
    </style>

    <!-- CONDITIONAL ADMIN / USER CARDS -->
    <?php if(isset($_SESSION['role'])): ?>
        <?php if($_SESSION['role'] === 'admin'): ?>
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                    <h4>Admin Quick Links</h4>
                    <a href="user_show.php" class="btn btn-light btn-sm">Manage Users</a>
                    <a href="announcements_add.php" class="btn btn-light btn-sm">Add Announcement</a>
                </div>
            </div>
        <?php else: ?>
            <div class="card bg-secondary text-white mb-4">
                <div class="card-body">
                    <h4>Member Section</h4>
                    <a href="view_profile.php?id=<?= $_SESSION['user_id'] ?>" class="btn btn-light btn-sm">View Profile</a>
                    <a href="announcements.php" class="btn btn-light btn-sm">All Announcements</a>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>

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
<script>
$(document).ready(function(){
    $('#testimonialCarousel').carousel({ interval: 4000 });
});
</script>

</body>
</html>
