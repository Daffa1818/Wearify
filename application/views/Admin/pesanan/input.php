<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6"><h1>Input Pesanan</h1></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= base_url('index.php/admin/dashboard') ?>">Admin</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('index.php/admin/pesanan') ?>">Pesanan</a></li>
            <li class="breadcrumb-item active">Input</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">

      <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
      <?php endif; ?>

      <div class="row">
        <!-- Form -->
        <div class="col-lg-7">
          <div class="card">
            <div class="card-header"><h3 class="card-title"><i class="fab fa-whatsapp text-success mr-2"></i>Paste Chat Pembeli</h3></div>
            <form action="<?= base_url('index.php/admin/pesanan/simpan') ?>" method="post">
              <div class="card-body">
                <div class="form-group">
                  <label>Nomor WhatsApp pembeli</label>
                  <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-phone"></i></span></div>
                    <input type="text" name="no_wa" class="form-control" placeholder="628123456789">
                  </div>
                </div>
                <div class="form-group mb-0">
                  <label>Isi chat (format yang sudah diisi pembeli)</label>
                  <textarea name="pesan" rows="9" class="form-control" required></textarea>
                </div>
              </div>
              <div class="card-footer bg-white">
                <button type="submit" class="btn btn-primary"><i class="fas fa-cogs mr-1"></i> Proses & Simpan</button>
                <a href="<?= base_url('index.php/admin/pesanan') ?>" class="btn btn-light">Batal</a>
              </div>
            </form>
          </div>
        </div>


          <div class="card">
            <div class="card-header"><h3 class="card-title">Format untuk pembeli</h3></div>
            <div class="card-body">
              <pre id="format" class="chat-asli mb-3">Halo! Silakan isi format pesanan berikut:

Nama:
Produk:
Ukuran:
Jumlah:
Harga:
Alamat:
Catatan:
            </pre>
              <button class="btn btn-sm btn-success" onclick="salinFormat(this)"><i class="fas fa-copy mr-1"></i> Salin format</button>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</div>

<script>
  function salinFormat(tombol) {
    navigator.clipboard.writeText(document.getElementById('format').innerText);
    tombol.innerHTML = '<i class="fas fa-check mr-1"></i> Tersalin';
    setTimeout(function () { tombol.innerHTML = '<i class="fas fa-copy mr-1"></i> Salin format'; }, 1500);
  }
</script>