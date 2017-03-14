<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<small class="error">* ', '</small>');

		if (!$this->session->userdata('logged_in')):
			redirect('login/logoff');
		endif;


	}

	public function index()
	{
		// verificação de formulário aqui
		$dados = array(
			'titulo' => 'Uesc360&ordm;',
			'tela' => 'user/profile',
		);
		$this->load->view('template2', $dados);
	}

	public function changePassword()
	{
		$this->load->model('acesso_model', 'acesso');

		$this->form_validation->set_rules('senha', 'SENHA ATUAL', 'trim|required|sha1');

		$this->form_validation->set_rules('senha2', 'NOVA SENHA', 'trim|required|sha1');
		$this->form_validation->set_message('matches', 'O campo %s está diferente do campo %s!');
		$this->form_validation->set_rules('senha3', 'REPETIR SENHA', 'trim|required|matches[senha2]|sha1');

			$userid = $this->session->userdata('id');
			$userpass = $this->acesso->getUserPassword($userid);

		if ($this->form_validation->run()==TRUE):

				// echo $userpass->senha_usu;

			if( $userpass->senha_usu == $this->input->post('senha') ):



				// echo $this->input->post('senha');
				// echo "<br>";
				// echo $this->input->post('senha2');
				// echo "<br>";
				// echo $this->input->post('senha3');

			else:
				$this->session->set_flashdata('passwordError', 'Senha <b>incorreta</b>!');
			endif;

			// $data = array('senha_usu' => $this->input->post('senha2'));


			//update senha em usuario
			// $this->usuario->updateUsuario($userid, $data);
		endif;

		$dados = array(
			'titulo' => 'Uesc360&ordm;',
			'tela' => 'user/password',
		);
		$this->load->view('template2', $dados);
	}

	public function changeEmail()
	{

	}

	public function changePersonalInfo()
	{

	}
}