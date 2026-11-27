<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gudang extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Barang_model');
    }

    // Mengecek login petugas gudang
    private function cek_login()
    {
        if (!$this->session->userdata('gudang_login')) {
            redirect('gudang');
        }
    }

    // Mengambil data barang dari database
    private function data_barang()
    {
        return $this->Barang_model->get_all();
    }

    // Halaman login
    public function index()
    {
        if ($this->session->userdata('gudang_login')) {
            redirect('gudang/dashboard');
        }

        $this->load->view('Gudang/login');
    }

    // Proses login
    public function proses_login()
    {
        $username = trim($this->input->post('username'));
        $password = $this->input->post('password');

        // Akun sementara
        if ($username == 'gudang' && $password == 'gudang123') {

            $this->session->set_userdata([
                'gudang_login' => TRUE,
                'gudang_nama' => 'Petugas Gudang'
            ]);

            redirect('gudang/dashboard');

        } else {

            $this->session->set_flashdata(
                'error',
                'Username atau password salah!'
            );

            redirect('gudang');
        }
    }

    // Dashboard gudang
    public function dashboard()
    {
        $this->cek_login();

        $data['title'] = 'Dashboard Gudang';
        $data['active_menu'] = 'dashboard';

        $data['barang'] = $this->data_barang();

        // Menghitung total jenis barang
        $data['total_barang'] = count($data['barang']);

        // Menghitung total seluruh stok
        $data['total_stok'] = array_sum(
            array_column($data['barang'], 'stok')
        );

        // Menghitung barang dengan stok 5 atau kurang
        $data['stok_menipis'] = count(array_filter(
            $data['barang'],
            function ($item) {
                return $item['stok'] <= 5;
            }
        ));

        $this->load->view('Gudang/dashboard', $data);
    }


// Halaman persediaan barang
public function persediaan()
{
    $this->cek_login();

    $data['title'] = 'Persediaan Barang';
    $data['active_menu'] = 'persediaan';

    $data['barang'] = $this->Barang_model->get_all();

    $this->load->view('Gudang/persediaan', $data);
}

// CRUD PERSEDIAAN BARANG
// Halaman tambah barang
public function tambah_barang()
{
    $this->cek_login();

    $data['title'] = 'Tambah Barang';
    $data['active_menu'] = 'persediaan';

    $data['judul_form'] = 'Form Tambah Barang';
    $data['form_action'] = 'gudang/simpan_barang';
    $data['is_edit'] = FALSE;

    // Data kosong untuk form
    $data['barang'] = [
        'kode_barang' => '',
        'nama_barang' => '',
        'kategori' => '',
        'stok' => 0,
        'lokasi' => ''
    ];

    $this->load->view('Gudang/form_barang', $data);
}


// CREATE: nyimpen barang baru
public function simpan_barang()
{
    $this->cek_login();

    $kode = trim($this->input->post('kode_barang', TRUE));
    $nama = trim($this->input->post('nama_barang', TRUE));
    $kategori = trim($this->input->post('kategori', TRUE));
    $lokasi = trim($this->input->post('lokasi', TRUE));

    $stok_input = $this->input->post('stok');
    $stok = filter_var($stok_input, FILTER_VALIDATE_INT);

    // Validasi data
    if (
        $kode == '' ||
        $nama == '' ||
        $kategori == '' ||
        $lokasi == '' ||
        $stok === FALSE ||
        $stok < 0
    ) {
        $this->session->set_flashdata(
            'error',
            'Lengkapi data barang dengan benar!'
        );

        redirect('gudang/tambah-barang');
    }

    // Memeriksa kode barang
    if ($this->Barang_model->kode_barang_ada($kode)) {

        $this->session->set_flashdata(
            'error',
            'Kode barang sudah digunakan!'
        );

        redirect('gudang/tambah-barang');
    }

    $data = [
        'kode_barang' => $kode,
        'nama_barang' => $nama,
        'kategori' => $kategori,
        'stok' => $stok,
        'lokasi' => $lokasi
    ];

    if ($this->Barang_model->tambah($data)) {

        $this->session->set_flashdata(
            'success',
            'Barang berhasil ditambahkan!'
        );

    } else {

        $this->session->set_flashdata(
            'error',
            'Gagal menambahkan barang!'
        );
    }
    $data['harga'] = (int)$this->input->post('harga');

    redirect('gudang/persediaan');
}

// Halaman edit barang
public function edit_barang($id)
{
    $this->cek_login();

    $barang = $this->Barang_model->get_by_id($id);

    if (!$barang) {
        show_404();
    }

    $data['title'] = 'Edit Barang';
    $data['active_menu'] = 'persediaan';

    $data['judul_form'] = 'Form Edit Barang';
    $data['form_action'] = 'gudang/update_barang/' . $id;
    $data['is_edit'] = TRUE;
    $data['barang'] = $barang;

    $this->load->view('Gudang/form_barang', $data);
}

// UPDATE
public function update_barang($id)
{
    $this->cek_login();

    $barang_lama = $this->Barang_model->get_by_id($id);

    if (!$barang_lama) {
        show_404();
    }

    $kode = trim($this->input->post('kode_barang', TRUE));
    $nama = trim($this->input->post('nama_barang', TRUE));
    $kategori = trim($this->input->post('kategori', TRUE));
    $lokasi = trim($this->input->post('lokasi', TRUE));

    if (
        $kode == '' ||
        $nama == '' ||
        $kategori == '' ||
        $lokasi == ''
    ) {
        $this->session->set_flashdata(
            'error',
            'Lengkapi data barang dengan benar!'
        );

        redirect('gudang/edit-barang/' . $id);
    }

    // Memeriksa kode agar tidak sama dengan barang lain
    if ($this->Barang_model->kode_barang_ada($kode, $id)) {

        $this->session->set_flashdata(
            'error',
            'Kode barang sudah digunakan!'
        );

        redirect('gudang/edit-barang/' . $id);
    }

    $data = [
        'kode_barang' => $kode,
        'nama_barang' => $nama,
        'kategori' => $kategori,
        'lokasi' => $lokasi
    ];

    if ($this->Barang_model->ubah($id, $data)) {

        $this->session->set_flashdata(
            'success',
            'Data barang berhasil diperbarui!'
        );

    } else {

        $this->session->set_flashdata(
            'error',
            'Gagal memperbarui data barang!'
        );
    }

    redirect('gudang/persediaan');
}

// DELETE
public function hapus_barang($id)
{
    $this->cek_login();

    $barang = $this->Barang_model->get_by_id($id);

    if (!$barang) {
        show_404();
    }

    // Barang yang memiliki riwayat transaksi tidak boleh dihapus
    if ($this->Barang_model->ada_transaksi($id)) {

        $this->session->set_flashdata(
            'error',
            'Barang tidak bisa dihapus karena sudah memiliki riwayat transaksi!'
        );

        redirect('gudang/persediaan');
    }

    if ($this->Barang_model->hapus($id)) {

        $this->session->set_flashdata(
            'success',
            'Barang berhasil dihapus!'
        );

    } else {

        $this->session->set_flashdata(
            'error',
            'Gagal menghapus barang!'
        );
    }

    redirect('gudang/persediaan');
}


    // Halaman barang masuk
    public function barang_masuk()
    {
        $this->cek_login();

        $data['title'] = 'Barang Masuk';
        $data['active_menu'] = 'masuk';

        // Mengambil riwayat transaksi
        $data['transaksi'] = $this->Barang_model->get_barang_masuk();

        // Mengambil daftar barang untuk pilihan form
        $data['barang'] = $this->Barang_model->get_all();

        // Kondisi awal form
        $data['edit'] = NULL;
        $data['form_action'] = 'gudang/simpan_barang_masuk';

        $this->load->view('Gudang/barang_masuk', $data);
    }

    // Menyimpan barang masuk
    public function simpan_barang_masuk()
    {
        $this->cek_login();

        $data = [
            'id_barang' => (int) $this->input->post('id_barang'),
            'jumlah' => (int) $this->input->post('jumlah'),
            'tanggal' => $this->input->post('tanggal', TRUE),
            'keterangan' => $this->input->post('keterangan', TRUE)
        ];

        // Validasi data
        if (
            $data['id_barang'] <= 0 ||
            $data['jumlah'] < 1 ||
            empty($data['tanggal'])
        ) {
            $this->session->set_flashdata(
                'error',
                'Lengkapi data dengan benar!'
            );

            redirect('gudang/barang-masuk');
        }

        // Menyimpan transaksi dan menambah stok
        if ($this->Barang_model->tambah_masuk($data) === true) {

            $this->session->set_flashdata(
                'success',
                'Barang masuk berhasil disimpan!'
            );

        } else {

            $this->session->set_flashdata(
                'error',
                'Gagal menyimpan barang masuk!'
            );
        }

        redirect('gudang/barang-masuk');
    }

    // Menampilkan form edit barang masuk
    public function edit_barang_masuk($id)
    {
        $this->cek_login();

        $data['title'] = 'Edit Barang Masuk';
        $data['active_menu'] = 'masuk';

        $data['transaksi'] = $this->Barang_model->get_barang_masuk();
        $data['barang'] = $this->Barang_model->get_all();

        $data['edit'] = $this->Barang_model->get_masuk_by_id($id);

        $data['form_action'] = 'gudang/update_barang_masuk/' . $id;

        if (!$data['edit']) {
            show_404();
        }

        $this->load->view('Gudang/barang_masuk', $data);
    }

    // Memperbarui barang masuk
    public function update_barang_masuk($id)
    {
        $this->cek_login();

        $data = [
            'id_barang' => (int) $this->input->post('id_barang'),
            'jumlah' => (int) $this->input->post('jumlah'),
            'tanggal' => $this->input->post('tanggal', TRUE),
            'keterangan' => $this->input->post('keterangan', TRUE)
        ];

        // Validasi data
        if (
            $data['id_barang'] <= 0 ||
            $data['jumlah'] < 1 ||
            empty($data['tanggal'])
        ) {
            $this->session->set_flashdata(
                'error',
                'Lengkapi data dengan benar!'
            );

            redirect('gudang/edit_barang_masuk/' . $id);
        }

        // Memperbarui transaksi dan stok
        $hasil = $this->Barang_model->ubah_masuk($id, $data);

        if ($hasil === true) {

            $this->session->set_flashdata(
                'success',
                'Data barang masuk berhasil diperbarui!'
            );

        } elseif ($hasil === 'stok_tidak_cukup') {

            $this->session->set_flashdata(
                'error',
                'Stok tidak cukup untuk mengubah transaksi!'
            );

        } else {

            $this->session->set_flashdata(
                'error',
                'Gagal memperbarui data!'
            );
        }

        redirect('gudang/barang-masuk');
    }

    // Menghapus barang masuk
    public function hapus_barang_masuk($id)
    {
        $this->cek_login();

        // Menghapus transaksi dan menyesuaikan stok
        $hasil = $this->Barang_model->hapus_masuk($id);

        if ($hasil === true) {

            $this->session->set_flashdata(
                'success',
                'Transaksi barang masuk berhasil dihapus!'
            );

        } elseif ($hasil === 'stok_tidak_cukup') {

            $this->session->set_flashdata(
                'error',
                'Transaksi tidak bisa dihapus karena stok tidak mencukupi!'
            );

        } else {

            $this->session->set_flashdata(
                'error',
                'Gagal menghapus transaksi!'
            );
        }

        redirect('gudang/barang-masuk');
    }

// CRUD BARANG KELUAR
// Halaman barang keluar
public function barang_keluar()
{
    $this->cek_login();

    $data['title'] = 'Barang Keluar';
    $data['active_menu'] = 'keluar';

    // Mengambil riwayat transaksi
    $data['transaksi'] = $this->Barang_model->get_barang_keluar();

    // Mengambil daftar barang dari persediaan
    $data['barang'] = $this->Barang_model->get_all();

    $data['edit'] = NULL;
    $data['form_action'] = 'gudang/simpan_barang_keluar';

    $this->load->view('Gudang/barang_keluar', $data);
}

// CREATE: Menyimpan barang keluar
public function simpan_barang_keluar()
{
    $this->cek_login();

    $data = [
        'id_barang' => (int) $this->input->post('id_barang'),
        'jumlah' => (int) $this->input->post('jumlah'),
        'tanggal' => $this->input->post('tanggal', TRUE),
        'keterangan' => $this->input->post('keterangan', TRUE)
    ];

    if (
        $data['id_barang'] <= 0 ||
        $data['jumlah'] < 1 ||
        empty($data['tanggal'])
    ) {
        $this->session->set_flashdata(
            'error',
            'Lengkapi data dengan benar!'
        );

        redirect('gudang/barang-keluar');
    }

    $hasil = $this->Barang_model->tambah_keluar($data);

    if ($hasil === true) {

        $this->session->set_flashdata(
            'success',
            'Barang keluar berhasil disimpan!'
        );

    } elseif ($hasil === 'stok_tidak_cukup') {

        $this->session->set_flashdata(
            'error',
            'Stok barang tidak mencukupi!'
        );

    } else {

        $this->session->set_flashdata(
            'error',
            'Gagal menyimpan transaksi!'
        );
    }

    redirect('gudang/barang-keluar');
}

// Menampilkan form edit barang keluar
public function edit_barang_keluar($id)
{
    $this->cek_login();

    $data['title'] = 'Edit Barang Keluar';
    $data['active_menu'] = 'keluar';

    $data['transaksi'] = $this->Barang_model->get_barang_keluar();
    $data['barang'] = $this->Barang_model->get_all();
    $data['edit'] = $this->Barang_model->get_keluar_by_id($id);

    $data['form_action'] = 'gudang/update_barang_keluar/' . $id;

    if (!$data['edit']) {
        show_404();
    }

    $this->load->view('Gudang/barang_keluar', $data);
}

// UPDATE: Memperbarui transaksi barang keluar
public function update_barang_keluar($id)
{
    $this->cek_login();

    $data = [
        'id_barang' => (int) $this->input->post('id_barang'),
        'jumlah' => (int) $this->input->post('jumlah'),
        'tanggal' => $this->input->post('tanggal', TRUE),
        'keterangan' => $this->input->post('keterangan', TRUE)
    ];

    if (
        $data['id_barang'] <= 0 ||
        $data['jumlah'] < 1 ||
        empty($data['tanggal'])
    ) {
        $this->session->set_flashdata(
            'error',
            'Lengkapi data dengan benar!'
        );

        redirect('gudang/barang-keluar');
    }

    $hasil = $this->Barang_model->ubah_keluar($id, $data);

    if ($hasil === true) {

        $this->session->set_flashdata(
            'success',
            'Data barang keluar berhasil diperbarui!'
        );

    } elseif ($hasil === 'stok_tidak_cukup') {

        $this->session->set_flashdata(
            'error',
            'Stok barang tidak mencukupi untuk perubahan ini!'
        );

    } else {

        $this->session->set_flashdata(
            'error',
            'Gagal memperbarui transaksi!'
        );
    }

    redirect('gudang/barang-keluar');
}

// DELETE: Menghapus transaksi barang keluar
public function hapus_barang_keluar($id)
{
    $this->cek_login();

    if ($this->Barang_model->hapus_keluar($id) === true) {

        $this->session->set_flashdata(
            'success',
            'Transaksi barang keluar berhasil dihapus!'
        );

    } else {

        $this->session->set_flashdata(
            'error',
            'Gagal menghapus transaksi!'
        );
    }

    redirect('gudang/barang-keluar');
}

    // Logout petugas gudang
    public function logout()
    {
        $this->session->unset_userdata([
            'gudang_login',
            'gudang_nama'
        ]);

        redirect('gudang');
    }

}
