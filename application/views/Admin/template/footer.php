  <footer class="main-footer">
    <strong>Wearify</strong> &copy; 2026
  </footer>
</div>

<script src="<?= base_url('assets/adminlte/plugins/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url('assets/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('assets/adminlte/plugins/chart.js/Chart.min.js') ?>"></script>
<script src="<?= base_url('assets/adminlte/dist/js/adminlte.min.js') ?>"></script>

<?php if (isset($grafik_label)): ?>
<script>
  new Chart(document.getElementById('grafikPesanan'), {
    type: 'line',
    data: {
      labels: <?= json_encode($grafik_label) ?>,
      datasets: [{
        label: 'Pesanan',
        data: <?= json_encode($grafik_data) ?>,
        borderColor: '#007bff',
        backgroundColor: 'rgba(0,123,255,.12)',
        pointBackgroundColor: '#007bff',
        lineTension: 0.3,
        fill: true
      }]
    },
    options: {
      maintainAspectRatio: false,
      legend: { display: false },
      scales: {
        yAxes: [{ ticks: { beginAtZero: true, stepSize: 2 } }]
      }
    }
  });
</script>
<?php endif; ?>
</body>
</html>