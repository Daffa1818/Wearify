<?php
$next = [
    'Baru'     => ['Diproses', 'Proses', 'warning'],
    'Diproses' => ['Dikirim',  'Kirim',  'primary'],
    'Dikirim'  => ['Selesai',  'Selesai','success'],
];
$warna = ['Baru'=>'info','Diproses'=>'warning','Dikirim'=>'primary','Selesai'=>'success','Gagal Parsing'=>'danger'];

$hitung = ['Baru'=>0,'Diproses'=>0,'Dikirim'=>0,'Selesai'=>0,'Gagal Parsing'=>0];
foreach ($pesanan as $p) { if (isset($hitung[$p->status])) $hitung[$p->status]++; }

function nomor_wa($no) {
    $no = preg_replace('/\D/', '', $no);
    if (substr($no, 0, 1) == '0') $no = '62' . substr($no, 1);
    return $no;
}
?>
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6"><h1>Pesanan</h1></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= base_url('index.php/admin/dashboard') ?>">Admin</a></li>
            <li class="breadcrumb-item active">Pesanan</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">

      <?php if ($this->session->flashdata('sukses')): ?>
        <div class="alert alert-success"><?= $this->session->flashdata('sukses') ?></div>
      <?php endif; ?>
      <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-warning"><?= $this->session->flashdata('error') ?></div>
      <?php endif; ?>

      <!-- Ringkasan -->
      <div class="row">
        <div class="col-lg-3 col-6 mb-3">
          <div class="card mini-stat mb-0">
            <div class="ico ico-biru"><i class="fas fa-inbox"></i></div>
            <div><p class="label">Pesanan Baru</p><p class="nilai"><?= $hitung['Baru'] ?></p></div>
          </div>
        </div>
        <div class="col-lg-3 col-6 mb-3">
          <div class="card mini-stat mb-0">
            <div class="ico ico-kuning"><i class="fas fa-box-open"></i></div>
            <div><p class="label">Diproses</p><p class="nilai"><?= $hitung['Diproses'] ?></p></div>
          </div>
        </div>
        <div class="col-lg-3 col-6 mb-3">
          <div class="card mini-stat mb-0">
            <div class="ico ico-ungu"><i class="fas fa-shipping-fast"></i></div>
            <div><p class="label">Dikirim</p><p class="nilai"><?= $hitung['Dikirim'] ?></p></div>
          </div>
        </div>
        <div class="col-lg-3 col-6 mb-3">
          <div class="card mini-stat mb-0">
            <div class="ico ico-hijau"><i class="fas fa-check-circle"></i></div>
            <div><p class="label">Selesai</p><p class="nilai"><?= $hitung['Selesai'] ?></p></div>
          </div>
        </div>
      </div>

      <!-- Tabel -->
      <div class="card">
        <div class="card-header">
          <div class="d-flex flex-wrap justify-content-between align-items-center">
            <div class="filter-bar mb-2 mb-md-0">
              <button class="btn btn-sm btn-outline-secondary aktif" data-filter="">Semua (<?= count($pesanan) ?>)</button>
              <?php foreach (['Baru','Diproses','Dikirim','Selesai'] as $s): ?>
                <button class="btn btn-sm btn-outline-secondary" data-filter="<?= $s ?>"><?= $s ?> (<?= $hitung[$s] ?>)</button>
              <?php endforeach; ?>
            </div>
            <div class="d-flex">
              <input type="text" id="cari" class="form-control form-control-sm mr-2" style="width:200px" placeholder="Cari nama / produk...">
              <a href="<?= base_url('index.php/admin/pesanan/input') ?>" class="btn btn-sm btn-primary text-nowrap">
                <i class="fas fa-plus mr-1"></i> Input Pesanan
              </a>
            </div>
          </div>
        </div>

        <div class="card-body table-responsive p-0">
          <table class="table table-hover text-nowrap mb-0" id="tabelPesanan">
            <thead>
              <tr>
                <th class="pl-4">Kode</th>
                <th>Pembeli</th>
                <th>Produk</th>
                <th>Alamat</th>
                <th>Status</th>
                <th>Waktu</th>
                <th class="text-right pr-4">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($pesanan as $p): ?>
                <tr data-status="<?= $p->status ?>">
                  <td class="pl-4 kode"><?= $p->kode ?></td>
                  <td class="cari-teks">
                    <div class="d-flex align-items-center">
                      <span class="avatar"><?= strtoupper(substr($p->nama ?: '?', 0, 1)) ?></span>
                      <div>
                        <div class="font-weight-bold"><?= htmlspecialchars($p->nama ?: '(tanpa nama)') ?></div>
                        <div class="sub"><?= htmlspecialchars($p->no_wa) ?></div>
                      </div>
                    </div>
                  </td>
                  <td class="cari-teks">
                    <div><?= htmlspecialchars($p->produk ?: '-') ?></div>
                    <div class="sub">Ukuran <?= $p->ukuran ?: '-' ?> &middot; <?= $p->jumlah ?> pcs</div>
                  </td>
                  <td style="max-width:220px;white-space:normal"><?= htmlspecialchars($p->alamat ?: '-') ?></td>
                  <td><span class="badge badge-soft-<?= $warna[$p->status] ?>"><?= $p->status ?></span></td>
                  <td>
                    <div><?= date('d M Y', strtotime($p->created_at)) ?></div>
                    <div class="sub"><?= date('H:i', strtotime($p->created_at)) ?></div>
                  </td>
                  <td class="text-right pr-4">
                    <?php if (isset($next[$p->status])): ?>
                      <a href="<?= base_url('index.php/admin/pesanan/status/' . $p->id . '/' . $next[$p->status][0]) ?>"
                         class="btn btn-sm btn-<?= $next[$p->status][2] ?>"
                         onclick="return confirm('Ubah status menjadi <?= $next[$p->status][0] ?>?')">
                        <?= $next[$p->status][1] ?> <i class="fas fa-arrow-right"></i>
                      </a>
                    <?php endif; ?>
                    <button class="btn btn-sm btn-light btn-detail"
                      data-kode="<?= $p->kode ?>"
                      data-nama="<?= htmlspecialchars($p->nama) ?>"
                      data-produk="<?= htmlspecialchars($p->produk) ?>"
                      data-ukuran="<?= $p->ukuran ?>"
                      data-jumlah="<?= $p->jumlah ?>"
                      data-alamat="<?= htmlspecialchars($p->alamat) ?>"
                      data-catatan="<?= htmlspecialchars($p->catatan) ?>"
                      data-pesan="<?= htmlspecialchars($p->pesan_asli) ?>">
                      <i class="fas fa-eye"></i> Detail
                    </button>
                    <?php if ($p->no_wa): ?>
                      <a href="https://wa.me/<?= nomor_wa($p->no_wa) ?>" target="_blank" class="btn btn-sm btn-success">
                        <i class="fab fa-whatsapp"></i>
                      </a>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
              <?php if (empty($pesanan)): ?>
                <tr><td colspan="7" class="text-center text-muted py-5">Belum ada pesanan masuk.</td></tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>

        <div class="card-footer bg-white">
          <small class="text-muted">Menampilkan <span id="jumlahTampil"><?= count($pesanan) ?></span> dari <?= count($pesanan) ?> pesanan</small>
        </div>
      </div>

    </div>
  </section>
</div>


<!-- Pop-up detail -->
<div class="modal fade" id="modalDetail" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius:12px">
      <div class="modal-header">
        <h5 class="modal-title">Detail Pesanan <span id="dKode" class="text-muted"></span></h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <table class="table table-sm table-borderless mb-3">
          <tr><td class="text-muted" style="width:90px">Pembeli</td><td id="dNama"></td></tr>
          <tr><td class="text-muted">Produk</td><td id="dProduk"></td></tr>
          <tr><td class="text-muted">Ukuran</td><td id="dUkuran"></td></tr>
          <tr><td class="text-muted">Jumlah</td><td id="dJumlah"></td></tr>
          <tr><td class="text-muted">Alamat</td><td id="dAlamat"></td></tr>
          <tr><td class="text-muted">Catatan</td><td id="dCatatan"></td></tr>
        </table>
        <div class="text-muted mb-1" style="font-size:.8rem">PESAN ASLI DARI PEMBELI</div>
        <pre class="chat-asli" id="dPesan"></pre>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  var baris   = document.querySelectorAll('#tabelPesanan tbody tr[data-status]');
  var tombol  = document.querySelectorAll('.filter-bar .btn');
  var cari    = document.getElementById('cari');
  var statusAktif = '';

  function saring() {
    var kata = cari.value.toLowerCase(), tampil = 0;
    baris.forEach(function (tr) {
      var cocokStatus = statusAktif === '' || tr.dataset.status === statusAktif;
      var teks = Array.prototype.map.call(tr.querySelectorAll('.cari-teks'), function (e) { return e.textContent; }).join(' ').toLowerCase();
      var cocok = cocokStatus && teks.indexOf(kata) > -1;
      tr.style.display = cocok ? '' : 'none';
      if (cocok) tampil++;
    });
    document.getElementById('jumlahTampil').textContent = tampil;
  }

  tombol.forEach(function (b) {
    b.addEventListener('click', function () {
      tombol.forEach(function (x) { x.classList.remove('aktif'); });
      b.classList.add('aktif');
      statusAktif = b.dataset.filter;
      saring();
    });
  });
  cari.addEventListener('input', saring);

  document.querySelectorAll('.btn-detail').forEach(function (b) {
    b.addEventListener('click', function () {
      var d = b.dataset;
      document.getElementById('dKode').textContent    = d.kode;
      document.getElementById('dNama').textContent    = d.nama || '-';
      document.getElementById('dProduk').textContent  = d.produk || '-';
      document.getElementById('dUkuran').textContent  = d.ukuran || '-';
      document.getElementById('dJumlah').textContent  = d.jumlah + ' pcs';
      document.getElementById('dAlamat').textContent  = d.alamat || '-';
      document.getElementById('dCatatan').textContent = d.catatan || '-';
      document.getElementById('dPesan').textContent   = d.pesan || '-';
      $('#modalDetail').modal('show');
    });
  });
});
</script>