
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= $title ?> | Wearify</title>

    <link rel="stylesheet" href="<?= base_url('assets/adminlte/plugins/fontawesome-free/css/all.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/adminlte/dist/css/adminlte.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/gudang.css') ?>">
</head>

<body class="hold-transition sidebar-mini layout-fixed">

<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <span class="nav-link">
                    <i class="fas fa-user-circle mr-1"></i>
                    <?= $this->session->userdata('gudang_nama') ?>
                </span>
            </li>

            <li class="nav-item">
                <a class="nav-link text-danger"
                   href="<?= site_url('gudang/logout') ?>"
                   onclick="return confirm('Yakin ingin keluar?')">
                    <i class="fas fa-sign-out-alt mr-1"></i>
                    Keluar
                </a>
            </li>
        </ul>
    </nav>

    <!-- Sidebar -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">

        <a href="<?= site_url('gudang/dashboard') ?>" class="brand-link">
            <i class="fas fa-boxes ml-3 mr-2"></i>
            <span class="brand-text font-weight-bold">Wearify Gudang</span>
        </a>

        <div class="sidebar">
            <nav class="mt-3">
                <ul class="nav nav-pills nav-sidebar flex-column">

                    <li class="nav-header">MENU GUDANG</li>

                    <li class="nav-item">
                        <a href="<?= site_url('gudang/dashboard') ?>"
                           class="nav-link <?= $active_menu == 'dashboard' ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-th-large"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="<?= site_url('gudang/persediaan') ?>"
                           class="nav-link <?= $active_menu == 'persediaan' ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-box"></i>
                            <p>Persediaan Barang</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="<?= site_url('gudang/barang-masuk') ?>"
                           class="nav-link <?= $active_menu == 'masuk' ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-arrow-down"></i>
                            <p>Barang Masuk</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="<?= site_url('gudang/barang-keluar') ?>"
                           class="nav-link <?= $active_menu == 'keluar' ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-arrow-up"></i>
                            <p>Barang Keluar</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= site_url('Admin/dashboard') ?>"
                           class="nav-link <?= $active_menu == 'admin' ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-user-shield"></i>
                            <p>Admin</p>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>

    <!-- Content -->
    <div class="content-wrapper">

        <div class="content-header">
            <div class="container-fluid">
                <h1 class="m-0"><?= $title ?></h1>
                <p class="text-muted mt-1">
                    Kelola persediaan dan aktivitas stok barang Wearify.
                </p>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
