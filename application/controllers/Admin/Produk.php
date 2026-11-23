<?php
class Produk extends CI_Controller {

private function tampil($view, $data) {
    $this->load->model('Pesanan_model');
    $data['menu']         = 'produk';
    $data['pesanan_baru'] = $this->Pesanan_model->hitung_baru();


        $this->load->view('Admin/template/header', $data);
        $this->load->view('Admin/template/sidebar', $data);
        $this->load->view($view, $data);
        $this->load->view('Admin/template/footer', $data);
    }

    public function index() {
        $data['title'] = 'Produk';

        // Data dummy, nanti diganti dari database
        $data['produk'] = [
            ['id' => 1, 'nama' => 'Kaos Polos Hitam', 'kategori' => 'Baju',   'harga' => 75000,  'stok' => 50, 'status' => 'Aktif'],
            ['id' => 2, 'nama' => 'Kemeja Flannel',   'kategori' => 'Baju',   'harga' => 150000, 'stok' => 7,  'status' => 'Aktif'],
            ['id' => 3, 'nama' => 'Hoodie Oversize',  'kategori' => 'Jaket',  'harga' => 220000, 'stok' => 5,  'status' => 'Aktif'],
            ['id' => 4, 'nama' => 'Jaket Bomber',     'kategori' => 'Jaket',  'harga' => 275000, 'stok' => 3,  'status' => 'Aktif'],
            ['id' => 5, 'nama' => 'Celana Chino',     'kategori' => 'Celana', 'harga' => 180000, 'stok' => 25, 'status' => 'Aktif'],
            ['id' => 6, 'nama' => 'Celana Jogger',    'kategori' => 'Celana', 'harga' => 130000, 'stok' => 0,  'status' => 'Nonaktif'],
        ];

        $this->tampil('Admin/produk/index', $data);
    }

    public function tambah() {
        $data['title']    = 'Tambah Produk';
        $data['kategori'] = ['Baju', 'Jaket', 'Celana', 'Aksesoris'];
        $data['ukuran']   = ['S', 'M', 'L', 'XL', 'XXL'];

        $this->tampil('Admin/produk/tambah', $data);
    }

    public function simpan() {
        // Sementara belum menyimpan apa-apa, balik ke daftar produk.
        // Nanti diisi insert ke database.
        redirect('admin/produk');
    }
}