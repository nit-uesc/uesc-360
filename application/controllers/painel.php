<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Painel extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		if (!$this->session->userdata('logged_in')):
			redirect('login/logoff');
		endif;
	}

	public function index()
	{
        $data['main'] = 'admin/painel';
        $this->load->view('templates/template_admin2', $data);
	}
}