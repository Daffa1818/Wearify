<?php
class Login extends CI_Controller {

    public function index() {
        if ($this->ion_auth->logged_in()) {
            redirect('admin/dashboard');
        }
        $this->load->view('Admin/login');
    }

    public function proses() {
        $email    = $this->input->post('email');
        $password = $this->input->post('password');
        $ingat    = (bool) $this->input->post('ingat');

        if ($this->ion_auth->login($email, $password, $ingat)) {
            redirect('admin/dashboard');
        }

        $this->session->set_flashdata('error', strip_tags($this->ion_auth->errors()));
        redirect('login');
    }

    public function logout() {
        $this->ion_auth->logout();
        redirect('login');
    }
}