<?php
class Dashboard extends Admin_Controller {

    public function __construct() 
    {
        parent::__construct();
        $this->load->model('Pesanan_model');
    }

    public function index() 
    {
        $data['title'] = 'Dashboard';
        $data['menu']  = 'dashboard';

        // Dari database
        $data['pesanan_baru']  = $this->Pesanan_model->hitung_baru();
        $data['total_pesanan'] = $this->Pesanan_model->total();

        // Masih dummy (tabel produk belum dibuat, harga belum ada di pesanan)
        $data['total_produk'] = 24;
        $data['pendapatan']   = 18750000;

        // Grafik 7 hari terakhir
        $grafik = $this->Pesanan_model->per_hari(7);
        $data['grafik_label'] = $grafik['label'];
        $data['grafik_data']  = $grafik['data'];

        $this->load->view('Admin/template/header', $data);
        $this->load->view('Admin/template/sidebar', $data);
        $this->load->view('Admin/dashboard', $data);
        $this->load->view('Admin/template/footer', $data);
    }
}