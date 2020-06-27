<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pavilhao extends CI_Controller
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
        $this->load->model('pavilhao_model');

        // $this->load->model('email_model');
        // $this->load->model('pessoa_model');
        // $this->load->model('usuario_model');
        // $this->load->model('cadastro_model');
    }
	public function index()
	{
		echo "There is nothing here... :X";
	}
	public function cadastrar_pavilhao() 
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
			$pavilhao['nome_pav'] = $this->funcoes->antiInjection($this->input->post('nome'));

			if ($this->pavilhao_model->cadastrar_pavilhao($pavilhao)):
				$data['sucesso'] = 'Os dados do pavilhao foram cadastrados com sucesso! :)';
			else:
				$data['erro'] = 'Oops... Ocorreu algum problema! Os dados não foram salvos! :(';
			endif;

		endif;

		// if ($this->security_model->isCoord()):
		//     $data['coordenador'] = $this->generica_consulta_model->consulta_pessoa_by_id($this->session->userdata('id_pessoa'));
		// elseif ($this->security_model->isAdmin()):
		//     $data['coordenador'] = $this->generica_consulta_model->consulta_coordenadores();
		// endif;

		$data['main'] = 'pavilhao/cadastrar_pavilhao';
		$this->load->view('templates/template_admin2', $data);
	}
	public function listar_pavilhao() {
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
            $data['pavilhao'] = $this->pavilhao_model->listar_pavilhao();
    	endif;

        $data['main'] = 'pavilhao/listar_pavilhao';
        $this->load->view('templates/template_admin2', $data);
	}
	
	public function deletar_pavilhao($id_pavilhao = NULL) {
         
        /* inicio de bloco responsavel para permissão de utilizar a função */
         if (!$this->session->userdata('logged_in')):
            redirect('login/logoff');
        endif;

        if(!$this->security_model->isAdmin() || $this->session->userdata('permissao_usu') != 1):
            $this->session->set_flashdata('erro', 'Você não possui permissão para acessar essa página! :X');
            redirect('painel', 'refresh');
        endif;
        /* inicio de bloco responsavel para permissão de utilizar a função */

        $id_pavilhao = $this->funcoes->antiInjection($id_pavilhao);
        // $this->security_model->youShallNotPass($id_pavilhao, 'LAB');

        if ($id_pavilhao != NULL && is_numeric($id_pavilhao)):
            // $this->load->model('equipamento_model');

            // $eqps = $this->generica_consulta_model->consulta_equipamento_pavilhao($id_pavilhao);
            // foreach ($eqps as $row):
            //     $this->equipamento_model->deletar_equipamento($id_pavilhao, $row->id_equipamento);
            // endforeach;

            if ($this->pavilhao_model->deletar_pavilhao($id_pavilhao)):
                $this->session->set_flashdata('sucesso', 'pavilhao removido com sucesso! :)');
                redirect('pavilhao/listar_pavilhao');
            else:
                $this->session->set_flashdata('erro', 'Oops... Ocorreu um erro ao remover o pavilhao! :(');
                redirect('pavilhao/listar_pavilhao');
            endif;
        endif;
	}
	
	public function editar_pavilhao($id_pavilhao = NULL) {
         /* inicio de bloco responsavel para permissão de utilizar a função */
         if (!$this->session->userdata('logged_in')):
            redirect('login/logoff');
        endif;

        if(!$this->security_model->isAdmin() || $this->session->userdata('permissao_usu') != 1):
            $this->session->set_flashdata('erro', 'Você não possui permissão para acessar essa página! :X');
            redirect('painel', 'refresh');
        endif;
        /* inicio de bloco responsavel para permissão de utilizar a função */

        $id_pavilhao = $this->funcoes->antiInjection($id_pavilhao);
        // $this->security_model->youShallNotPass($id_pavilhao, 'LAB');

        if ($id_pavilhao != NULL && is_numeric($id_pavilhao)):

            $this->form_validation->set_rules('nome', 'NOME', 'trim|required|max_length[200]');
            
            if ($this->form_validation->run() === TRUE):
                $pavilhao['nome_pav'] = $this->input->post('nome');

                if ($this->pavilhao_model->atualizar_dados_pavilhao($id_pavilhao, $pavilhao)):
                    $this->session->set_flashdata('sucesso', 'Dados atualizados com sucesso! :)');
                    redirect('pavilhao/listar_pavilhao/');
                else:
                    $this->session->set_flashdata('erro', 'Oops... Ocorreu um erro ao atualizar os dados! :(');
                    redirect('pavilhao/listar_pavilhao/');
                endif;
            endif;
            $data['pavilhao'] = $this->pavilhao_model->consulta_pavilhao_by_id($id_pavilhao);
            $data['main'] = 'pavilhao/editar_pavilhao';
            $this->load->view('templates/template_admin2', $data);
        endif;
    }

    public function visualizar_pavilhao($id_pavilhao = NULL) {
         /* inicio de bloco responsavel para permissão de utilizar a função */
         if (!$this->session->userdata('logged_in')):
            redirect('login/logoff');
        endif;

        if(!$this->security_model->isAdmin() || $this->session->userdata('permissao_usu') != 1):
            $this->session->set_flashdata('erro', 'Você não possui permissão para acessar essa página! :X');
            redirect('painel', 'refresh');
        endif;
        /* inicio de bloco responsavel para permissão de utilizar a função */

        $id_pavilhao = $this->funcoes->antiInjection($id_pavilhao);
        // $this->security_model->youShallNotPass($id_pavilhao, 'LAB');

        if ($id_pavilhao != NULL && is_numeric($id_pavilhao)):
            $data['pavilhao'] = $this->pavilhao_model->consulta_pavilhao_by_id($id_pavilhao);
            $data['pavilhao_lab'] = $this->pavilhao_model->consulta_pavilhao_laboratorio($id_pavilhao);
        endif;

        $data['main'] = 'pavilhao/visualizacao_pavilhao';
        $this->load->view('templates/template_admin2', $data);
    }


}