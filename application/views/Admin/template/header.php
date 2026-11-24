<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $title ?> | Wearify Admin</title>
  <link rel="stylesheet" href="<?= base_url('assets/adminlte/plugins/fontawesome-free/css/all.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/adminlte/dist/css/adminlte.min.css') ?>">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= base_url('assets/css/custom.css') ?>">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

<?php $user = $this->ion_auth->user()->row(); ?>
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#" role="button">
          <i class="fas fa-user-circle mr-1"></i>
          <?= htmlspecialchars($user->first_name ?: 'Admin') ?> <i class="fas fa-angle-down ml-1"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right">
          <span class="dropdown-item-text">
            <strong><?= htmlspecialchars($user->first_name ?: 'Admin') ?></strong><br>
            <small class="text-muted"><?= htmlspecialchars($user->email) ?></small>
          </span>
          <div class="dropdown-divider"></div>
          <a href="<?= base_url('index.php/login/logout') ?>" class="dropdown-item text-danger"
             onclick="return confirm('Keluar dari akun admin?')">
            <i class="fas fa-sign-out-alt mr-2"></i> Logout
          </a>
        </div>
      </li>
    </ul>
  </nav>