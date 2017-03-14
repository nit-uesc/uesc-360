<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Licenca extends CI_Controller {

    public function index()
    {
        $dados['main'] = 'telas/licenca';
        $this->load->view('templates/template_home', $dados);
    }

}

/* End of file licenca.php */
/* Location: ./application/controllers/licenca.php */