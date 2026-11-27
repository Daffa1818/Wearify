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

<!-- Form Barang Masuk -->
<div class="card">

    <div class="card-header">
        <h3 class="card-title">
            <?= $edit ? 'Edit Barang Masuk' : 'Form Barang Masuk' ?>
        </h3>
    </div>

    <div class="card-body">

        <form action="<?= site_url($form_action) ?>" method="POST">

            <div class="form-group">
                <label>Nama Barang</label>
                <select name="id_barang" class="form-control" required>
                    <option value="">-- Pilih Barang --</option>

                    <?php foreach ($barang as $item): ?>
                        <option value="<?= $item['id_barang'] ?>"
                            <?= ($edit && $edit['id_barang'] == $item['id_barang']) ? 'selected' : '' ?>>

                            <?= html_escape($item['kode_barang']) ?>
                            - <?= html_escape($item['nama_barang']) ?>

                        </option>
                    <?php endforeach; ?>

                </select>
            </div>

            <div class="form-group">
                <label>Jumlah Barang</label>
                <input
                    type="number"
                    name="jumlah"
                    class="form-control"
                    min="1"
                    placeholder="Masukkan jumlah"
                    value="<?= $edit ? $edit['jumlah'] : '' ?>"
                    required>
            </div>

            <div class="form-group">
                <label>Tanggal Masuk</label>
                <input
                    type="date"
                    name="tanggal"
                    class="form-control"
                    value="<?= $edit ? $edit['tanggal'] : date('Y-m-d') ?>"
                    required>
            </div>

            <div class="form-group">
                <label>Keterangan</label>
                <textarea
                    name="keterangan"
                    class="form-control"
                    rows="3"
                    placeholder="Keterangan barang"><?= $edit ? html_escape($edit['keterangan']) : '' ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save mr-1"></i>
                <?= $edit ? 'Update' : 'Simpan' ?>
            </button>

            <?php if ($edit): ?>
                <a href="<?= site_url('gudang/barang-masuk') ?>"
                   class="btn btn-secondary">
                    Batal
                </a>
            <?php endif; ?>

        </form>

    </div>
</div>

<!-- Tabel Riwayat Barang Masuk -->
<div class="card">

    <div class="card-header">
        <h3 class="card-title">Riwayat Barang Masuk</h3>
    </div>

    <div class="card-body table-responsive">

        <table class="table table-bordered table-hover">

            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

                <?php if (!empty($transaksi)): ?>

                    <?php $no = 1; ?>

                    <?php foreach ($transaksi as $item): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= html_escape($item['tanggal']) ?></td>
                        <td><?= html_escape($item['kode_barang']) . '-' . date('Ymd', strtotime($item['tanggal'])) ?></td>
                        <td><?= html_escape($item['nama_barang']) ?></td>
                        <td>
                            <strong><?= $item['jumlah'] ?></strong>
                        </td>
                        <td>
                            <?php $harga = isset($item['harga']) ? (int)$item['harga'] : 0; ?>
                            Rp <?= number_format($harga * $item['jumlah'], 0, ',', '.') ?>
                            <div class="text-muted small">@ Rp <?= number_format($harga, 0, ',', '.') ?></div>
                        </td>
                        <td><?= html_escape($item['keterangan']) ?></td>

                        <td>
                            <a href="<?= site_url('gudang/edit_barang_masuk/' . $item['id_masuk']) ?>"
                               class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>

                            <a href="<?= site_url('gudang/hapus_barang_masuk/' . $item['id_masuk']) ?>"
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Yakin ingin menghapus data ini?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>

                <?php else: ?>

                    <tr>
                        <td colspan="8" class="text-center">
                            Belum ada riwayat barang masuk.
                        </td>
                    </tr>

                <?php endif; ?>

            </tbody>

        </table>

    </div>
</div>

<?php $this->load->view('Gudang/partials/footer'); ?>