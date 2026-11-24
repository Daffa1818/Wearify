
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login Gudang | Wearify</title>

    <link rel="stylesheet" href="<?= base_url('assets/adminlte/plugins/fontawesome-free/css/all.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/adminlte/dist/css/adminlte.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/gudang.css') ?>">
</head>

<body class="login-gudang">

    <div class="login-card">

        <div class="login-icon">
            <i class="fas fa-boxes"></i>
        </div>

        <p class="brand-name">WEARIFY</p>

        <h3>Login Gudang</h3>

        <p class="login-desc">
            Masuk untuk mengelola persediaan barang toko.
        </p>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger py-2">
                <?= $this->session->flashdata('error') ?>
            </div>
        <?php endif; ?>

        <form action="<?= site_url('gudang/proses_login') ?>" method="post">

            <div class="form-group">
                <label>Username</label>

                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fas fa-user"></i>
                        </span>
                    </div>

                    <input type="text"
                        name="username"
                        class="form-control"
                        placeholder="Masukkan username"
                        required>
                </div>
            </div>

            <div class="form-group">
                <label>Password</label>

                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fas fa-lock"></i>
                        </span>
                    </div>

                    <input type="password"
                        name="password"
                        class="form-control"
                        placeholder="Masukkan password"
                        required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-block mt-4">
                Masuk ke Halaman Gudang
                <i class="fas fa-arrow-right ml-2"></i>
            </button>

        </form>

        <div class="login-footer">
            Wearify Inventory Management &copy; 2026
        </div>

    </div>

</body>
</html>
