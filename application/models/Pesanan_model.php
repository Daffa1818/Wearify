<?php
class Pesanan_model extends CI_Model {

public function simpan($data) {
    $this->load->model('Barang_model');

    // Cari barang di gudang: nama persis dulu, lalu yang mirip
    $barang = null;
    if (!empty($data['produk'])) {
        $barang = $this->db->where('nama_barang', $data['produk'])->get('barang')->row_array();
        if (!$barang) {
            $barang = $this->db->like('nama_barang', $data['produk'])->get('barang')->row_array();
        }
    }

    $data['harga']     = $barang ? (int)$barang['harga'] : 0;
    $data['id_barang'] = $barang ? (int)$barang['id_barang'] : null;

    $this->db->insert('pesanan', $data);
    $id   = $this->db->insert_id();
    $kode = 'WF-' . date('Ymd') . '-' . str_pad($id, 4, '0', STR_PAD_LEFT);
    $this->db->where('id', $id)->update('pesanan', ['kode' => $kode]);

    // Kurangi stok gudang lewat Barang Keluar (hanya pesanan yang terbaca benar)
    $this->hasil_gudang = 'tidak_ditemukan';
    if ($barang && $data['status'] == 'Baru') {
        $hasil = $this->Barang_model->tambah_keluar([
            'id_barang'  => $barang['id_barang'],
            'jumlah'     => (int)$data['jumlah'],
            'tanggal'    => date('Y-m-d'),
            'keterangan' => 'Pesanan ' . $kode . ' a.n. ' . $data['nama'],
        ]);

        if ($hasil === true)                    $this->hasil_gudang = 'ok';
        elseif ($hasil === 'stok_tidak_cukup')  $this->hasil_gudang = 'stok_kurang';
        else                                    $this->hasil_gudang = 'gagal';
    }

    return $id;
}

    public function semua() {
        return $this->db->order_by('id', 'DESC')->get('pesanan')->result();
    }

    public function parsing($teks) {
    $kolom = [];
    foreach (preg_split('/\r\n|\r|\n/', $teks) as $baris) {
        $bagian = explode(':', $baris, 2);
        if (count($bagian) == 2) {
            $kolom[strtolower(trim($bagian[0]))] = trim($bagian[1]);
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

public function hitung_baru() {
    return $this->db->where('status', 'Baru')->count_all_results('pesanan');
}
public function ubah_status($id, $status) {
    $boleh = ['Baru', 'Diproses', 'Dikirim', 'Selesai'];
    if (!in_array($status, $boleh)) return false;
    return $this->db->where('id', $id)->update('pesanan', ['status' => $status]);
}

public function total() {
    return $this->db->count_all('pesanan');
}

public function per_hari($hari = 7) {
    $nama_hari = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];

    $rows = $this->db->query(
        "SELECT DATE(created_at) AS tgl, COUNT(*) AS jml
         FROM pesanan
         WHERE created_at >= CURDATE() - INTERVAL ? DAY
         GROUP BY DATE(created_at)",
        [$hari - 1]
    )->result();

    $jumlah = [];
    foreach ($rows as $r) { $jumlah[$r->tgl] = (int)$r->jml; }

    $label = [];
    $data  = [];
    for ($i = $hari - 1; $i >= 0; $i--) {
        $ts      = strtotime("-$i day");
        $tgl     = date('Y-m-d', $ts);
        $label[] = $nama_hari[date('w', $ts)];
        $data[]  = $jumlah[$tgl] ?? 0;
    }

    return ['label' => $label, 'data' => $data];
}
}