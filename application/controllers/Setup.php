<?php
class Setup extends CI_Controller {

    public function buat_admin() {
        // Hanya jalan kalau belum ada user sama sekali
        if ($this->db->count_all('users') > 0) {
            show_404();
        }

        $id = $this->ion_auth->register(
            'admin@wearify.com',     // identity (email)
            'GantiPasswordIni123',   // password
            'admin@wearify.com',     // email
            ['first_name' => 'Admin'],
            [1]                      // grup 1 = admin
        );

        echo $id ? 'Admin berhasil dibuat. HAPUS file Setup.php sekarang.'
                 : strip_tags($this->ion_auth->errors());
    }
}