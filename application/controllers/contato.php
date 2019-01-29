<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contato extends CI_Controller
{
	public function index()
}
	{
        $data['main'] = 'telas/contato';
        $this->load->view('templates/template_home', $data);
	}
