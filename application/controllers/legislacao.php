<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Legislacao extends CI_Controller {

    public function index()
    {
        $dados['main'] = 'telas/legislacao';
        $this->load->view('templates/template_home', $dados);
    }

}

/* End of file legislacao.php */
/* Location: ./application/controllers/legislacao.php */