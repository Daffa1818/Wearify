
<?php $this->load->view('Gudang/partials/header'); ?>

<!-- Statistik Gudang -->
<div class="row">

    <!-- Total Jenis Barang -->
    <div class="col-lg-4 col-md-6 col-12">
        <div class="small-box bg-white gudang-stat">

            <div class="inner">
                <p>Total Jenis Barang</p>
                <h3><?= $total_barang ?></h3>
            </div>

            <div class="icon">
                <i class="fas fa-boxes"></i>
            </div>

        </div>
    </div>

    <!-- Total Stok Barang -->
    <div class="col-lg-4 col-md-6 col-12">
        <div class="small-box bg-white gudang-stat">

            <div class="inner">
                <p>Total Stok Barang</p>
                <h3><?= $total_stok ?></h3>
            </div>

            <div class="icon">
                <i class="fas fa-cubes"></i>
            </div>

        </div>
    </div>

    <!-- Stok Menipis -->
    <div class="col-lg-4 col-md-6 col-12">
        <div class="small-box bg-white gudang-stat">

            <div class="inner">
                <p>Stok Menipis</p>
                <h3><?= $stok_menipis ?></h3>
            </div>

            <div class="icon text-warning">
                <i class="fas fa-exclamation-triangle"></i>
            </div>

        </div>
    </div>

</div>

<!-- Menu Cepat -->
<div class="row">

    <!-- Persediaan -->
    <div class="col-lg-4 col-md-6 col-12">

        <div class="card card-primary card-outline">

            <div class="card-body text-center">

                <i class="fas fa-boxes fa-3x text-primary mb-3"></i>

                <h5>Persediaan Barang</h5>

                <p class="text-muted">
                    Lihat dan pantau seluruh stok barang.
                </p>

                <a href="<?= site_url('gudang/persediaan') ?>"
                   class="btn btn-primary btn-sm">
                    Lihat Persediaan
                </a>

            </div>

        </div>

    </div>

    <!-- Barang Masuk -->
    <div class="col-lg-4 col-md-6 col-12">

        <div class="card card-success card-outline">

            <div class="card-body text-center">

                <i class="fas fa-arrow-down fa-3x text-success mb-3"></i>

                <h5>Barang Masuk</h5>

                <p class="text-muted">
                    Kelola pencatatan barang yang masuk.
                </p>

                <a href="<?= site_url('gudang/barang-masuk') ?>"
                   class="btn btn-success btn-sm">
                    Lihat Barang Masuk
                </a>

            </div>

        </div>

    </div>

    <!-- Barang Keluar -->
    <div class="col-lg-4 col-md-6 col-12">

        <div class="card card-danger card-outline">

            <div class="card-body text-center">

                <i class="fas fa-arrow-up fa-3x text-danger mb-3"></i>

                <h5>Barang Keluar</h5>

                <p class="text-muted">
                    Kelola pencatatan barang yang keluar.
                </p>

                <a href="<?= site_url('gudang/barang-keluar') ?>"
                   class="btn btn-danger btn-sm">
                    Lihat Barang Keluar
                </a>

            </div>

        </div>

    </div>

</div>

<?php $this->load->view('Gudang/partials/footer'); ?>
