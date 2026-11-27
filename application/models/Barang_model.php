<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barang_model extends CI_Model {

    // Mengambil semua data persediaan
    public function get_all() {
        return $this->db->get('barang')->result_array();
    }

    // Mengambil barang berdasarkan ID
    public function get_by_id($id) {
        return $this->db
                    ->where('id_barang', $id)
                    ->get('barang')
                    ->row_array();
    }

    // Menambahkan barang
    public function tambah($data) {
        return $this->db->insert('barang', $data);
    }

    // Mengubah barang
    public function ubah($id, $data) {
        return $this->db
                    ->where('id_barang', $id)
                    ->update('barang', $data);
    }

    // Menghapus barang
    public function hapus($id) {
        return $this->db
                    ->where('id_barang', $id)
                    ->delete('barang');
    }


    // =====================================
    // CRUD BARANG MASUK
    // =====================================

    // Mengambil seluruh riwayat barang masuk
    public function get_barang_masuk() {

        $this->db->select('barang_masuk.*, barang.kode_barang, barang.nama_barang, barang.harga');
        $this->db->from('barang_masuk');
        $this->db->join(
            'barang',
            'barang.id_barang = barang_masuk.id_barang'
        );
        $this->db->order_by('barang_masuk.id_masuk', 'DESC');

        return $this->db->get()->result_array();
    }

    // Mengambil transaksi berdasarkan ID
    public function get_masuk_by_id($id) {
        return $this->db
                    ->where('id_masuk', $id)
                    ->get('barang_masuk')
                    ->row_array();
    }

    // CREATE: Menambahkan transaksi barang masuk
    public function tambah_masuk($data) {

        $barang = $this->get_by_id($data['id_barang']);

        if (!$barang) {
            return false;
        }

        $this->db->trans_begin();

        // Menyimpan transaksi
        $this->db->insert('barang_masuk', $data);

        // Menambah stok persediaan
        $this->db->set(
            'stok',
            'stok + ' . (int) $data['jumlah'],
            FALSE
        );

        $this->db->where('id_barang', $data['id_barang']);
        $this->db->update('barang');

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        }

        $this->db->trans_commit();
        return true;
    }

    // UPDATE: Mengubah transaksi barang masuk
    public function ubah_masuk($id, $data) {

        $lama = $this->get_masuk_by_id($id);

        if (!$lama) {
            return false;
        }

        $barang_lama = $this->get_by_id($lama['id_barang']);
        $barang_baru = $this->get_by_id($data['id_barang']);

        if (!$barang_lama || !$barang_baru) {
            return false;
        }

        $id_lama = (int) $lama['id_barang'];
        $id_baru = (int) $data['id_barang'];

        $jumlah_lama = (int) $lama['jumlah'];
        $jumlah_baru = (int) $data['jumlah'];

        // Jika barang yang dipilih tetap sama
        if ($id_lama == $id_baru) {

            $selisih = $jumlah_baru - $jumlah_lama;

            // Memeriksa stok jika jumlah transaksi dikurangi
            if ($selisih < 0 && $barang_lama['stok'] < abs($selisih)) {
                return 'stok_tidak_cukup';
            }

        } else {

            // Memeriksa stok barang lama sebelum dikembalikan
            if ($barang_lama['stok'] < $jumlah_lama) {
                return 'stok_tidak_cukup';
            }
        }

        $this->db->trans_begin();

        if ($id_lama == $id_baru) {

            // Menyesuaikan stok berdasarkan selisih
            if ($selisih != 0) {

                $this->db->set(
                    'stok',
                    'stok + (' . (int) $selisih . ')',
                    FALSE
                );

                $this->db->where('id_barang', $id_baru);
                $this->db->update('barang');
            }

        } else {

            // Mengurangi kembali stok barang lama
            $this->db->set(
                'stok',
                'stok - ' . $jumlah_lama,
                FALSE
            );

            $this->db->where('id_barang', $id_lama);
            $this->db->update('barang');

            // Menambahkan stok barang baru
            $this->db->set(
                'stok',
                'stok + ' . $jumlah_baru,
                FALSE
            );

            $this->db->where('id_barang', $id_baru);
            $this->db->update('barang');
        }

        // Memperbarui data transaksi
        $this->db->where('id_masuk', $id);
        $this->db->update('barang_masuk', $data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        }

        $this->db->trans_commit();
        return true;
    }

    // DELETE: Menghapus transaksi barang masuk
    public function hapus_masuk($id) {

        $lama = $this->get_masuk_by_id($id);

        if (!$lama) {
            return false;
        }

        $barang = $this->get_by_id($lama['id_barang']);

        // Periksa stok sebelum transaksi dihapus
        if (!$barang || $barang['stok'] < $lama['jumlah']) {
            return 'stok_tidak_cukup';
        }

        $this->db->trans_begin();

        // Mengurangi stok sesuai transaksi yang dihapus
        $this->db->set(
            'stok',
            'stok - ' . (int) $lama['jumlah'],
            FALSE
        );

        $this->db->where('id_barang', $lama['id_barang']);
        $this->db->update('barang');

        // Menghapus riwayat transaksi
        $this->db->where('id_masuk', $id);
        $this->db->delete('barang_masuk');

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        }

        $this->db->trans_commit();
        return true;
    }

    // CRUD BARANG KELUAR
    // Mengambil seluruh riwayat barang keluar
    public function get_barang_keluar() {

        $this->db->select('barang_keluar.*, barang.kode_barang, barang.nama_barang, barang.harga');
        $this->db->from('barang_keluar');
        $this->db->join(
            'barang',
            'barang.id_barang = barang_keluar.id_barang'
        );
        $this->db->order_by('barang_keluar.id_keluar', 'DESC');

        return $this->db->get()->result_array();
    }

    // Mengambil transaksi berdasarkan ID
    public function get_keluar_by_id($id) {
        return $this->db
                    ->where('id_keluar', $id)
                    ->get('barang_keluar')
                    ->row_array();
    }

    // CREATE: Menyimpan transaksi barang keluar
    public function tambah_keluar($data) {

        $barang = $this->get_by_id($data['id_barang']);

        if (!$barang) {
            return false;
        }

        // Memeriksa ketersediaan stok
        if ($barang['stok'] < $data['jumlah']) {
            return 'stok_tidak_cukup';
        }

        $this->db->trans_begin();

        // Mengurangi stok barang
        $this->db->set(
            'stok',
            'stok - ' . (int) $data['jumlah'],
            FALSE
        );

        $this->db->where('id_barang', $data['id_barang']);
        $this->db->where('stok >=', (int) $data['jumlah']);
        $this->db->update('barang');

        if ($this->db->affected_rows() < 1) {
            $this->db->trans_rollback();
            return 'stok_tidak_cukup';
        }

        // Menyimpan riwayat transaksi
        $this->db->insert('barang_keluar', $data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        }

        $this->db->trans_commit();
        return true;
    }

    // UPDATE: Mengubah transaksi barang keluar
    public function ubah_keluar($id, $data) {

        $lama = $this->get_keluar_by_id($id);

        if (!$lama) {
            return false;
        }

        $barang_lama = $this->get_by_id($lama['id_barang']);
        $barang_baru = $this->get_by_id($data['id_barang']);

        if (!$barang_lama || !$barang_baru) {
            return false;
        }

        $id_lama = (int) $lama['id_barang'];
        $id_baru = (int) $data['id_barang'];

        $jumlah_lama = (int) $lama['jumlah'];
        $jumlah_baru = (int) $data['jumlah'];

        $this->db->trans_begin();

        if ($id_lama == $id_baru) {

            // Menghitung perubahan jumlah barang
            $selisih = $jumlah_baru - $jumlah_lama;

            if ($selisih > 0) {

                // Periksa stok tambahan yang dibutuhkan
                $this->db->set(
                    'stok',
                    'stok - ' . $selisih,
                    FALSE
                );

                $this->db->where('id_barang', $id_baru);
                $this->db->where('stok >=', $selisih);
                $this->db->update('barang');

                if ($this->db->affected_rows() < 1) {
                    $this->db->trans_rollback();
                    return 'stok_tidak_cukup';
                }

            } elseif ($selisih < 0) {

                // Kembalikan selisih stok
                $this->db->set(
                    'stok',
                    'stok + ' . abs($selisih),
                    FALSE
                );

                $this->db->where('id_barang', $id_baru);
                $this->db->update('barang');
            }

        } else {

            // Kembalikan stok ke barang sebelumnya
            $this->db->set(
                'stok',
                'stok + ' . $jumlah_lama,
                FALSE
            );

            $this->db->where('id_barang', $id_lama);
            $this->db->update('barang');

            // Kurangi stok barang yang baru dipilih
            $this->db->set(
                'stok',
                'stok - ' . $jumlah_baru,
                FALSE
            );

            $this->db->where('id_barang', $id_baru);
            $this->db->where('stok >=', $jumlah_baru);
            $this->db->update('barang');

            if ($this->db->affected_rows() < 1) {
                $this->db->trans_rollback();
                return 'stok_tidak_cukup';
            }
        }

        // Memperbarui data transaksi
        $this->db->where('id_keluar', $id);
        $this->db->update('barang_keluar', $data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        }

        $this->db->trans_commit();
        return true;
    }

    // DELETE: Menghapus transaksi barang keluar
    public function hapus_keluar($id) {

        $lama = $this->get_keluar_by_id($id);

        if (!$lama) {
            return false;
        }

        $this->db->trans_begin();

        // Mengembalikan stok yang sebelumnya dikeluarkan
        $this->db->set(
            'stok',
            'stok + ' . (int) $lama['jumlah'],
            FALSE
        );

        $this->db->where('id_barang', $lama['id_barang']);
        $this->db->update('barang');

        // Menghapus riwayat transaksi
        $this->db->where('id_keluar', $id);
        $this->db->delete('barang_keluar');

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        }

        $this->db->trans_commit();
        return true;
    }


    // Memeriksa apakah kode barang sudah digunakan
    public function kode_barang_ada($kode, $id = NULL) {

        $this->db->where('kode_barang', $kode);

        // Mengecualikan ID saat proses edit
        if ($id !== NULL) {
            $this->db->where('id_barang !=', $id);
        }

        return $this->db->count_all_results('barang') > 0;
    }

    // Memeriksa apakah barang memiliki riwayat transaksi
    public function ada_transaksi($id) {

        $masuk = $this->db
                      ->where('id_barang', $id)
                      ->count_all_results('barang_masuk');

        $keluar = $this->db
                       ->where('id_barang', $id)
                       ->count_all_results('barang_keluar');

        return ($masuk > 0 || $keluar > 0);
    }

}