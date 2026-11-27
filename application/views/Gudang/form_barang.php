
<?php $this->load->view('Gudang/partials/header'); ?>

<!-- Notifikasi -->
<?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger">
        <?= $this->session->flashdata('error') ?>
    </div>
<?php endif; ?>


<div class="card">

    <div class="card-header">
        <h3 class="card-title"><?= $judul_form ?></h3>
    </div>

    <div class="card-body">

        <form action="<?= site_url($form_action) ?>" method="post">

            <div class="form-group">
                <label>Kode Barang</label>

                <input type="text"
                       name="kode_barang"
                       class="form-control"
                       value="<?= html_escape($barang['kode_barang']) ?>"
                       placeholder="Masukkan kode barang"
                       required>
            </div>

            <div class="form-group">
                <label>Nama Barang</label>

                <input type="text"
                       name="nama_barang"
                       class="form-control"
                       value="<?= html_escape($barang['nama_barang']) ?>"
                       placeholder="Masukkan nama barang"
                       required>
            </div>

            <div class="form-group">
                <label>Kategori</label>

                <input type="text"
                       name="kategori"
                       class="form-control"
                       value="<?= html_escape($barang['kategori']) ?>"
                       placeholder="Contoh: Baju, Jaket, Celana"
                       required>
            </div>

            <?php if (!$is_edit): ?>

                <div class="form-group">
                    <label>Stok Awal</label>

                    <input type="number"
                           name="stok"
                           class="form-control"
                           min="0"
                           value="0"
                           placeholder="Masukkan stok awal"
                           required>
                </div>
                <div class="form-group">
                <label>Harga</label>
                <input type="number" name="harga" class="form-control" min="0"
                        value="<?= isset($barang['harga']) ? $barang['harga'] : '' ?>" placeholder="Masukkan harga">
                </div>

            <?php else: ?>

                <div class="form-group">
                    <label>Stok Saat Ini</label>

                    <input type="number"
                           class="form-control"
                           value="<?= $barang['stok'] ?>"
                           readonly>

                    <small class="text-muted">
                        Perubahan stok dilakukan melalui transaksi Barang Masuk dan Barang Keluar.
                    </small>
                </div>

            <?php endif; ?>

            <div class="form-group">
                <label>Lokasi Rak</label>

                <input type="text"
                       name="lokasi"
                       class="form-control"
                       value="<?= html_escape($barang['lokasi']) ?>"
                       placeholder="Contoh: Rak A1"
                       required>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save mr-1"></i>
                <?= $is_edit ? 'Simpan Perubahan' : 'Simpan' ?>
            </button>

            <a href="<?= site_url('gudang/persediaan') ?>"
               class="btn btn-secondary">

                Kembali

            </a>

        </form>

    </div>
</div>

<?php $this->load->view('Gudang/partials/footer'); ?>
