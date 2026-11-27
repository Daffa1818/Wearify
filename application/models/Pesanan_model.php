<?php
class Pesanan_model extends CI_Model {

public function simpan($data) {
    // Cari harga di gudang berdasarkan nama produk
    $barang = $this->db->like('nama_barang', $data['produk'])->get('barang')->row();
    $data['harga'] = $barang ? (int)$barang->harga : 0;

    $this->db->insert('pesanan', $data);
    $id = $this->db->insert_id();

    $this->db->where('id', $id)->update('pesanan', [
        'kode' => 'WF-' . date('Ymd') . '-' . str_pad($id, 4, '0', STR_PAD_LEFT)
    ]);
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