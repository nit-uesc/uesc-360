<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sobre extends CI_Controller
{
	public function index()
	{
		$dados = array(
			'main' => 'telas/quemsomos',
		);
        $this->load->view('templates/template_home', $dados);
	}
}