<?php
class Pesanan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Pesanan_model');
    }

    private function tampil($view, $data) {
        $data['menu']         = 'pesanan';
        $data['pesanan_baru'] = $this->Pesanan_model->hitung_baru();
        $this->load->view('Admin/template/header', $data);
        $this->load->view('Admin/template/sidebar', $data);
        $this->load->view($view, $data);
        $this->load->view('Admin/template/footer', $data);
    }
    public function status($id, $status) {
    $status = urldecode($status);
    if ($this->Pesanan_model->ubah_status($id, $status)) {
        $this->session->set_flashdata('sukses', 'Status pesanan diubah menjadi ' . $status . '.');
    } else {
        $this->session->set_flashdata('error', 'Status tidak valid.');
    }
    redirect('admin/pesanan');
}
    public function index() {
        $data['title']   = 'Pesanan';
        $data['pesanan'] = $this->Pesanan_model->semua();
        $this->tampil('Admin/pesanan/index', $data);
    }

    public function input() {
        $data['title'] = 'Input Pesanan';
        $this->tampil('Admin/pesanan/input', $data);
    }

    public function simpan() {
        $pesan = trim($this->input->post('pesan'));
        if ($pesan == '') {
            $this->session->set_flashdata('error', 'Isi chat tidak boleh kosong.');
            redirect('admin/pesanan/input');
        }

        $hasil = $this->Pesanan_model->parsing($pesan);
        $valid = ($hasil['nama'] != '' && $hasil['produk'] != '');

        $hasil['no_wa']      = $this->input->post('no_wa');
        $hasil['pesan_asli'] = $pesan;
        $hasil['status']     = $valid ? 'Baru' : 'Gagal Parsing';

        $this->Pesanan_model->simpan($hasil);

        if ($valid) {
            $this->session->set_flashdata('sukses', 'Pesanan atas nama ' . $hasil['nama'] . ' berhasil disimpan.');
        } else {
            $this->session->set_flashdata('error', 'Format tidak terbaca, disimpan dengan status Gagal Parsing.');
        }
        redirect('admin/pesanan');
    }
}