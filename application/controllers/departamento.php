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
		echo "There is nothing here... :X";
	}
	public function cadastrar_departamento() 
	{
         /* inicio de bloco responsavel para permissão de utilizar a função */
         if (!$this->session->userdata('logged_in')):
            redirect('login/logoff');
        endif;

        if(!$this->security_model->isAdmin() || $this->session->userdata('permissao_usu') != 1):
            $this->session->set_flashdata('erro', 'Você não possui permissão para acessar essa página! :X');
            redirect('painel', 'refresh');
        endif;
        /* fim de bloco responsavel para permissão de utilizar a função */

		$this->form_validation->set_rules('nome', 'NOME', 'trim|required|max_length[50]|mb_strtoupper');
		if($this->form_validation->run() == TRUE):
			$departamento['nome_dpt'] = $this->funcoes->antiInjection($this->input->post('nome'));

			if ($this->departamento_model->cadastrar_departamento($departamento)):
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
	public function listar_departamento() {
         /* inicio de bloco responsavel para permissão de utilizar a função */
         if (!$this->session->userdata('logged_in')):
            redirect('login/logoff');
        endif;

        if(!$this->security_model->isAdmin() || $this->session->userdata('permissao_usu') != 1):
            $this->session->set_flashdata('erro', 'Você não possui permissão para acessar essa página! :X');
            redirect('painel', 'refresh');
        endif;
        /* inicio de bloco responsavel para permissão de utilizar a função */

        if ($this->security_model->isAdmin() && $this->session->userdata('permissao_usu') == 1):
            $data['departamento'] = $this->departamento_model->listar_departamento();
    	endif;

        $data['main'] = 'departamento/listar_departamento';
        $this->load->view('templates/template_admin2', $data);
	}
	
	public function deletar_departamento($id_departamento = NULL) {
         
        /* inicio de bloco responsavel para permissão de utilizar a função */
         if (!$this->session->userdata('logged_in')):
            redirect('login/logoff');
        endif;

        if(!$this->security_model->isAdmin() || $this->session->userdata('permissao_usu') != 1):
            $this->session->set_flashdata('erro', 'Você não possui permissão para acessar essa página! :X');
            redirect('painel', 'refresh');
        endif;
        /* inicio de bloco responsavel para permissão de utilizar a função */

        $id_departamento = $this->funcoes->antiInjection($id_departamento);
        // $this->security_model->youShallNotPass($id_departamento, 'LAB');

        if ($id_departamento != NULL && is_numeric($id_departamento)):
            // $this->load->model('equipamento_model');

            // $eqps = $this->generica_consulta_model->consulta_equipamento_departamento($id_departamento);
            // foreach ($eqps as $row):
            //     $this->equipamento_model->deletar_equipamento($id_departamento, $row->id_equipamento);
            // endforeach;

            if ($this->departamento_model->deletar_departamento($id_departamento)):
                $this->session->set_flashdata('sucesso', 'Departamento removido com sucesso! :)');
                redirect('departamento/listar_departamento');
            else:
                $this->session->set_flashdata('erro', 'Oops... Ocorreu um erro ao remover o Departamento! :(');
                redirect('departamento/listar_departamento');
            endif;
        endif;
	}
	
	public function editar_departamento($id_departamento = NULL) {
         /* inicio de bloco responsavel para permissão de utilizar a função */
         if (!$this->session->userdata('logged_in')):
            redirect('login/logoff');
        endif;

        if(!$this->security_model->isAdmin() || $this->session->userdata('permissao_usu') != 1):
            $this->session->set_flashdata('erro', 'Você não possui permissão para acessar essa página! :X');
            redirect('painel', 'refresh');
        endif;
        /* inicio de bloco responsavel para permissão de utilizar a função */

        $id_departamento = $this->funcoes->antiInjection($id_departamento);
        // $this->security_model->youShallNotPass($id_departamento, 'LAB');

        if ($id_departamento != NULL && is_numeric($id_departamento)):

            $this->form_validation->set_rules('nome', 'NOME', 'trim|required|max_length[200]');
            
            if ($this->form_validation->run() === TRUE):
                $departamento['nome_dpt'] = $this->input->post('nome');

                if ($this->departamento_model->atualizar_dados_departamento($id_departamento, $departamento)):
                    $this->session->set_flashdata('sucesso', 'Dados atualizados com sucesso! :)');
                    redirect('departamento/listar_departamento/');
                else:
                    $this->session->set_flashdata('erro', 'Oops... Ocorreu um erro ao atualizar os dados! :(');
                    redirect('departamento/listar_departamento/');
                endif;
            endif;
            $data['departamento'] = $this->departamento_model->consulta_departamento_by_id($id_departamento);
            $data['main'] = 'departamento/editar_departamento';
            $this->load->view('templates/template_admin2', $data);
        endif;
    }

    public function visualizar_departamento($id_departamento = NULL) {
         /* inicio de bloco responsavel para permissão de utilizar a função */
         if (!$this->session->userdata('logged_in')):
            redirect('login/logoff');
        endif;

        if(!$this->security_model->isAdmin() || $this->session->userdata('permissao_usu') != 1):
            $this->session->set_flashdata('erro', 'Você não possui permissão para acessar essa página! :X');
            redirect('painel', 'refresh');
        endif;
        /* inicio de bloco responsavel para permissão de utilizar a função */

        $id_departamento = $this->funcoes->antiInjection($id_departamento);
        // $this->security_model->youShallNotPass($id_departamento, 'LAB');

        if ($id_departamento != NULL && is_numeric($id_departamento)):
            $data['departamento'] = $this->departamento_model->consulta_departamento_by_id($id_departamento);
            $data['departamento_lab'] = $this->departamento_model->consulta_departamento_laboratorio($id_departamento);
        endif;

        $data['main'] = 'departamento/visualizacao_departamento';
        $this->load->view('templates/template_admin2', $data);
    }


}