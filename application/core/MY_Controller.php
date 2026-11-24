<?php
class Admin_Controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('login');
        }
        if (!$this->ion_auth->is_admin()) {
            $this->ion_auth->logout();
            redirect('login');
        }
    }
}