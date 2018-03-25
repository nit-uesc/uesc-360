<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Departamento extends CI_Controller
{
	public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('funcoes');

        $this->form_validation->set_error_delimiters('<small class="red-text right">* ', '</small>');


        $this->load->model('admin_gerencia_model');
        $this->load->model('generica_consulta_model');

        //Novo Model em Contrução
        $this->load->model('departamento_model');

        // $this->load->model('email_model');
        // $this->load->model('pessoa_model');
        // $this->load->model('usuario_model');
        // $this->load->model('cadastro_model');
    }
	public function index()
	{
		$this->form_validation->set_rules('nome', 'NOME', 'trim|required|max_length[50]|mb_strtoupper');
		if($this->form_validation->run() == TRUE):
			$departamento['nome_departamento'] = $this->funcoes->antiInjection($this->input->post('nome'));

			if ($this->departamento_model->cadastrar_departamento($departamento, $coordenador)):
                $data['sucesso'] = 'Os dados do departamento foram cadastrados com sucesso! :)';
            else:
                $data['erro'] = 'Oops... Ocorreu algum problema! Os dados não foram salvos! :(';
            endif;

		endif;

		// if ($this->security_model->isCoord()):
        //     $data['coordenador'] = $this->generica_consulta_model->consulta_pessoa_by_id($this->session->userdata('id_pessoa'));
        // elseif ($this->security_model->isAdmin()):
        //     $data['coordenador'] = $this->generica_consulta_model->consulta_coordenadores();
        // endif;

		$data['main'] = 'departamento/cadastrar_departamento';
        $this->load->view('templates/template_admin2', $data);
       
	}
}