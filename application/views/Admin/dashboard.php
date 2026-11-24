<?php

$warna = ['Baru' => 'info', 'Diproses' => 'warning', 'Dikirim' => 'primary', 'Selesai' => 'success'];
?>
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6"><h1>Dashboard</h1></div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Admin</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">

      <!-- Kotak statistik -->
      <div class="row">
        <div class="col-lg-3 col-6">
          <div class="small-box bg-info">
            <div class="inner">
              <h3><?= $pesanan_baru ?></h3>
              <p>Pesanan Baru</p>
            </div>
            <div class="icon"><i class="fas fa-shopping-bag"></i></div>
            <a href="#" class="small-box-footer">Lihat detail <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-6">
          <div class="small-box bg-success">
            <div class="inner">
              <h3><?= $total_pesanan ?></h3>
              <p>Total Pesanan</p>
            </div>
            <div class="icon"><i class="fas fa-clipboard-list"></i></div>
            <a href="#" class="small-box-footer">Lihat detail <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-6">
          <div class="small-box bg-warning">
            <div class="inner">
              <h3><?= $total_produk ?></h3>
              <p>Total Produk</p>
            </div>
            <div class="icon"><i class="fas fa-box"></i></div>
            <a href="#" class="small-box-footer">Lihat detail <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-6">
          <div class="small-box bg-danger">
            <div class="inner">
              <h3><?= number_format($pendapatan / 1000000, 1, ',', '.') ?><sup style="font-size:20px"> jt</sup></h3>
              <p>Pendapatan (Rp)</p>
            </div>
            <div class="icon"><i class="fas fa-wallet"></i></div>
            <a href="#" class="small-box-footer">Lihat detail <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
      </div>

      <!-- Grafik + stok menipis -->
      <div class="row">
        <div class="col-lg-8">
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title"><i class="fas fa-chart-line mr-1"></i> Pesanan 7 Hari Terakhir</h3>
            </div>
            <div class="card-body">
              <div style="height:260px">
                <canvas id="grafikPesanan"></canvas>
              </div>
            </div>
          </div>
        </div>



    </div>
  </section>
</div>