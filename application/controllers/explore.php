<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Explore extends CI_Controller
{
	public function index()
	{
		$this->load->model('generica_consulta_model');
		$data['pessoa'] = $this->generica_consulta_model->listar_pessoas();
		$data['laboratorio'] = $this->generica_consulta_model->listar_laboratorios();
		$data['equipamento'] = $this->generica_consulta_model->listar_equipamentos();
		$data['main'] = 'telas/explore';
		$this->load->view('templates/template_home', $data);
	}
}
