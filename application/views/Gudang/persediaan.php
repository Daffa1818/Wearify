
<?php $this->load->view('Gudang/partials/header'); ?>

<!-- Notifikasi -->
<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success">
        <?= $this->session->flashdata('success') ?>
    </div>
<?php endif; ?>

<?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger">
        <?= $this->session->flashdata('error') ?>
    </div>
<?php endif; ?>


<!-- Data Persediaan Barang -->
<div class="card">

    <div class="card-header">
        <h3 class="card-title">Data Persediaan Barang</h3>

        <div class="card-tools">
            <a href="<?= site_url('gudang/tambah-barang') ?>"
               class="btn btn-primary btn-sm">

                <i class="fas fa-plus mr-1"></i>
                Tambah Barang

            </a>
        </div>
    </div>

    <div class="card-body table-responsive p-0">

        <table class="table table-hover mb-0">

            <thead>
                <tr>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th>Lokasi Rak</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

                <?php if (!empty($barang)): ?>

                    <?php foreach ($barang as $item): ?>

                    <tr>
                        <td><?= html_escape($item['kode_barang']) ?></td>

                        <td><?= html_escape($item['nama_barang']) ?></td>

                        <td><?= html_escape($item['kategori']) ?></td>

                        <td>
                            <strong><?= $item['stok'] ?></strong>
                        </td>

                        <td><?= html_escape($item['lokasi']) ?></td>

                        <td>
                            <?php if ($item['stok'] <= 5): ?>
                                <span class="badge badge-danger">
                                    Stok Menipis
                                </span>
                            <?php else: ?>
                                <span class="badge badge-success">
                                    Tersedia
                                </span>
                            <?php endif; ?>
                        </td>

                        <td>
                            <a href="<?= site_url('gudang/edit-barang/' . $item['id_barang']) ?>"
                               class="btn btn-warning btn-sm">

                                <i class="fas fa-edit"></i>

                            </a>

                            <form action="<?= site_url('gudang/hapus-barang/' . $item['id_barang']) ?>"
                                  method="post"
                                  style="display:inline;"
                                  onsubmit="return confirm('Yakin ingin menghapus barang ini?')">

                                <button type="submit"
                                        class="btn btn-danger btn-sm">

                                    <i class="fas fa-trash"></i>

                                </button>

                            </form>
                        </td>
                    </tr>

                    <?php endforeach; ?>

                <?php else: ?>

                    <tr>
                        <td colspan="7" class="text-center">
                            Belum ada data barang.
                        </td>
                    </tr>

                <?php endif; ?>

            </tbody>

        </table>

    </div>
</div>

<?php $this->load->view('Gudang/partials/footer'); ?>
