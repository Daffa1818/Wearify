  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="<?= base_url('index.php/admin/dashboard') ?>" class="brand-link">
      <i class="fas fa-tshirt brand-image ml-3" style="opacity:.8;line-height:2"></i>
      <span class="brand-text font-weight-bold">Wearify Admin</span>
    </a>

    <div class="sidebar">
      <nav class="mt-3">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
          <li class="nav-header">UTAMA</li>
          <li class="nav-item">
            <a href="<?= base_url('index.php/admin/dashboard') ?>" class="nav-link <?= $menu == 'dashboard' ? 'active' : '' ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i><p>Dashboard</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('index.php/admin/pesanan') ?>" class="nav-link <?= $menu == 'pesanan' ? 'active' : '' ?>">
              <i class="nav-icon fas fa-shopping-cart"></i>
              <p>Pesanan <span class="badge badge-danger right"><?= $pesanan_baru ?></span></p>
            </a>
          </li>
      </nav>
    </div>
  </aside>