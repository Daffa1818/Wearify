<?php
class Webhook extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Pesanan_model');
    }

    public function terima() {

    
        // Gateway bisa kirim form-data atau JSON, dua-duanya dicek
        $pesan  = $this->input->post('message');
        $sender = $this->input->post('sender');

        if (!$pesan) {
            $json   = json_decode(file_get_contents('php://input'), true);
            $pesan  = $json['message'] ?? '';
            $sender = $json['sender'] ?? '';
        }

        if (!$pesan) {
            echo json_encode(['status' => 'kosong']);
            return;
        }

        $hasil = $this->parsing($pesan);

        // Kalau nama dan produk tidak terbaca, tandai gagal parsing
        $valid = ($hasil['nama'] != '' && $hasil['produk'] != '');

        $hasil['no_wa']      = $sender;
        $hasil['pesan_asli'] = $pesan;
        $hasil['status']     = $valid ? 'Baru' : 'Gagal Parsing';

        $id = $this->Pesanan_model->simpan($hasil);
        echo json_encode(['status' => 'ok', 'id' => $id]);
    }


    private function parsing($teks) {
        $kolom = [];
        foreach (preg_split('/\r\n|\r|\n/', $teks) as $baris) {
            $bagian = explode(':', $baris, 2);
            if (count($bagian) == 2) {
                $kunci = strtolower(trim($bagian[0]));
                $kolom[$kunci] = trim($bagian[1]);
            }
        }

        return [
            'nama'    => $kolom['nama']    ?? '',
            'produk'  => $kolom['produk']  ?? '',
            'ukuran'  => strtoupper($kolom['ukuran'] ?? ''),
            'jumlah'  => max(1, (int)($kolom['jumlah'] ?? 1)),
            'alamat'  => $kolom['alamat']  ?? '',
            'catatan' => $kolom['catatan'] ?? '',
        ];
    }
}