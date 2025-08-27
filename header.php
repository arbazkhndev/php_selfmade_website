<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <title>Admin Dashboard - Arbaz Khan</title>

  <link rel="stylesheet" href="siqtheme/css/app.css">

  <link rel="apple-touch-icon" sizes="76x76" href="siqtheme/assets/img/apple-icon.png">
  <link rel="icon" type="image/png" sizes="96x96" href="siqtheme/assets/img/favicon.png">
</head>
<body class="theme-dark">
<div class="grid-wrapper sidebar-bg bg1">

  <div class="header">
    <div class="header-bar">
      <div class="brand">
        <a href="sample.php" class="logo"><span class="text-carolina">siQ</span>theme</a>
        <a href="sample.php" class="logo-sm text-carolina" style="display:none;">siQ</a>
      </div>
      <div class="btn-toggle">
        <a href="#" class="slide-sidebar-btn"><i class="ti-menu"></i></a>
      </div>
      <div class="navigation d-flex">

        <div class="navbar-menu d-flex">
          <div class="menu-item">
            <a href="logout.php" class="btn"><i class="ti-power-off"></i> Logout</a>
          </div>
        </div>
      </div>
    </div>
  </div>
