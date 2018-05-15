<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pessoa extends CI_Controller
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

        $this->load->model('email_model');
        $this->load->model('pessoa_model');
        $this->load->model('usuario_model');
        $this->load->model('cadastro_model');
    }

/*Função usada para cadastrar pessoa externamente [auto cadastro]*/
    public function index()
    {
        $this->form_validation->set_rules('departamento', 'SELECIONE DEPARTAMENTO', 'callback_check_drop');
        $this->form_validation->set_rules('tipo_pessoa', 'SELECIONE TIPO PESSOA', 'callback_check_drop');
        $this->form_validation->set_rules('dia', 'DIA', 'greater_than[0]|less_than[32]|callback_check_drop_date');
        $this->form_validation->set_rules('mes', 'MÊS', 'greater_than[0]|less_than[13]|callback_check_drop_date');
        $this->form_validation->set_rules('ano', 'ANO', 'greater_than[1929]|less_than[1999]|callback_check_drop_date');
        $this->form_validation->set_rules('sexo', 'SEXO', 'required|exact_length[1]');
        $this->form_validation->set_rules('nome', 'NOME', 'trim|required|max_length[50]|mb_strtoupper');
        $this->form_validation->set_rules('email', 'EMAIL', 'trim|required|max_length[90]|strtolower|valid_email|is_unique[pessoa.email_pes]');
        $this->form_validation->set_rules('ramal', 'RAMAL', 'trim|required|max_length[15]|alphanumeric');
        $this->form_validation->set_rules('lattes', 'LATTES', 'trim|required|max_length[70]');
        $this->form_validation->set_rules('website', 'WEBSITE', 'trim|max_length[50]|strtolower');
        $this->form_validation->set_rules('senha', 'SENHA', 'trim|required');
        $this->form_validation->set_message('matches', 'O campo %s está diferente do campo %s!');
        $this->form_validation->set_rules('senha2', 'REPETIR SENHA', 'trim|required|matches[senha]');
        $this->form_validation->set_rules('cpf', 'CPF', 'required|trim|exact_length[14]|is_unique[pessoa.cpf_pes]|callback_check_cpf');


        if($this->form_validation->run() == TRUE):
            $dia = $this->input->post('dia');
            $mes = $this->input->post('mes');
            $ano = $this->input->post('ano');
            $dados2 = array('nome_pes' => $this->input->post('nome'),
                            'email_pes' => $this->input->post('email'),
                            'ramal_pes' => $this->input->post('ramal'),
                            'lattes_pes' => $this->input->post('lattes'),
                            'website_pes' => $this->input->post('website'),
                            'fk_id_tipo_pessoa' => $this->input->post('tipo_pessoa'),
                            'fk_id_departamento' => $this->input->post('departamento'),
                            'cpf_pes' => $this->input->post('cpf'),
                            'birthday_pes' => $ano.'-'.$mes.'-'.$dia,
                            'sexo_pes' => $this->input->post('sexo'),
            );

            $dados1 = array('login_usu' => $this->input->post('email'),
                            'senha_usu' => sha1($this->input->post('senha'))
            );

            $this->usuario_model->insertUsuario($dados1);
            $dados2['fk_id_usuario'] = $this->db->insert_id();
            $this->pessoa_model->insertPessoa($dados2);

            $dados3['fk_id_usuario'] = $dados2['fk_id_usuario'];
            $dados3['fk_id_permissao'] = 3;
            $this->usuario_model->insertPermissao($dados3);

            $this->cadastro_model->invalida_token($token, 'pedido_cadastro');/*Devemos mover de cadastro para um model alciliar*/

            $this->session->set_flashdata('sucesso', 'Cadastro efetuado com sucesso! :)');
            redirect('login');
        endif;

        $data['departamento'] = $this->departamento_model->getAllDepartamento()->result();
        // $data['tipo_pessoa'] = $this->pessoa_model->getAllTipo_pessoa()->result();
        $data['tipo_pessoa'] = $this->pessoa_model->getAllTipo_pessoa()->result();
        $data['main'] = 'telas/cadastro_finalizar';
        $this->load->view('templates/template_home', $data);
    }
/*--------------------------------------------------------------------------------------------------------------------*/

/*Função usada para cadastrar pessoa internamente [atraves de coordenador]*/
 public function cadastrar_pessoa()
{
      /* inicio de bloco responsavel para permissão de utilizar a função */
        if (!$this->session->userdata('logged_in')):
            redirect('login/logoff');
        endif;

        if(!$this->security_model->isAdmin() || $this->session->userdata('permissao_usu') != 1):
            $this->session->set_flashdata('erro', 'Você não possui permissão para acessar essa página! :X');
            redirect('painel', 'refresh');
        endif;
        /* inicio de bloco responsavel para permissão de utilizar a função */

    $this->form_validation->set_rules('departamento', 'SELECIONE DEPARTAMENTO', 'callback_check_drop');
    $this->form_validation->set_rules('tipo_pessoa', 'SELECIONE TIPO PESSOA', 'callback_check_drop');
    $this->form_validation->set_rules('nome', 'NOME', 'trim|required|max_length[50]');
    $this->form_validation->set_rules('email', 'EMAIL', 'trim|required|max_length[45]|strtolower|valid_email|is_unique[usuario.login_usu]');
    $this->form_validation->set_rules('ramal', 'RAMAL', 'trim|required|max_length[15]|alphanumeric');
    $this->form_validation->set_rules('lattes', 'LATTES', 'trim|max_length[70]');
    $this->form_validation->set_rules('website', 'WEBSITE', 'trim|max_length[50]');
    $this->form_validation->set_rules('permissao', 'SELECIONE A PERMISSÃO DO USUÁRIO', 'callback_check_drop');

    /*Novos campos adiconados ao cadas*/
    $this->form_validation->set_rules('cpf', 'CPF', 'required|trim|exact_length[14]|is_unique[pessoa.cpf_pes]|callback_check_cpf');
    $this->form_validation->set_rules('sexo', 'SEXO', 'required|exact_length[1]');
    $this->form_validation->set_rules('dia', 'DIA', 'greater_than[0]|less_than[32]|callback_check_drop_date');
    $this->form_validation->set_rules('mes', 'MÊS', 'greater_than[0]|less_than[13]|callback_check_drop_date');
    $this->form_validation->set_rules('ano', 'ANO', 'greater_than[1929]|less_than[1999]|callback_check_drop_date');

    if ($this->form_validation->run()==TRUE):
        $dia = $this->input->post('dia');
        $mes = $this->input->post('mes');
        $ano = $this->input->post('ano');

        $senha = random_string('alnum', 10);
        $usuario['login_usu'] = $this->input->post('email');
        $usuario['senha_usu'] = sha1($senha);

        $pessoa['nome_pes'] = $this->input->post('nome');
        $pessoa['email_pes'] = $this->input->post('email');
        $pessoa['ramal_pes'] = $this->input->post('ramal');
        $pessoa['lattes_pes'] = $this->input->post('lattes');
        $pessoa['website_pes'] = $this->input->post('website');
        $pessoa['fk_id_tipo_pessoa'] = $this->input->post('tipo_pessoa');
        $pessoa['fk_id_departamento'] = $this->input->post('departamento');
        $pessoa['cpf_pes'] = $this->input->post('cpf');
        $pessoa['birthday_pes'] = $ano.'-'.$mes.'-'.$dia;
        $pessoa['sexo_pes'] =  $this->input->post('sexo');


        $permissao = $this->input->post('permissao');

        if($this->pessoa_model->cadastrar_pessoa($usuario, $pessoa, $permissao)==true):
            $email = $pessoa['email_pes'];
            $assunto = "Seja bem-vindo ao UESC 360º!";
            $mensagem = "Você foi cadastrado na plataforma UESC 360º!<br> Usuário: ".$usuario['login_usu']."<br> Senha: ".$senha;

            if($this->email_model->enviar_email($email, $assunto, $mensagem)==true):
                $data['sucesso'] = 'Dados cadastrados com sucesso! (Email enviado ao usuário '.$usuario['login_usu'].')';
            else:
                $data['sucesso'] = 'Dados cadastrados com sucesso! (Email <b>NÃO</b> enviado ao usuário '.$usuario['login_usu'].')';
            endif;
        else:
            $data['erro'] = 'Oops... Os dados inseridos não foram cadastrados! :(';
        endif;

    endif;

    $data['main'] = 'pessoa/cadastrar_pessoa';
    $data['departamento'] = $this->departamento_model->getAllDepartamento()->result();
    $data['tipo_pessoa'] = $this->pessoa_model->getAllTipo_pessoa()->result();
    $this->load->view('templates/template_admin2', $data);
}

    public function visualizar_pessoa($id_pessoa=NULL)
    {
        /* inicio de bloco responsavel para permissão de utilizar a função */
        if (!$this->session->userdata('logged_in')):
            redirect('login/logoff');
        endif;

        if(!$this->security_model->isAdmin() || $this->session->userdata('permissao_usu') != 1):
            $this->session->set_flashdata('erro', 'Você não possui permissão para acessar essa página! :X');
            redirect('painel', 'refresh');
        endif;
        /* inicio de bloco responsavel para permissão de utilizar a função */

        if($id_pessoa != NULL && is_numeric($id_pessoa)):
            $data['pessoa']               = $this->pessoa_model->consulta_pessoa_by_id($this->funcoes->antiInjection($id_pessoa));
            $data['laboratorio_coordena'] = $this->generica_consulta_model->consulta_coordenador_laboratorio($this->funcoes->antiInjection($id_pessoa));
            $data['permissoes'] = $this->security_model->getPermissions($this->funcoes->antiInjection($id_pessoa));
        endif;
        $data['main'] = 'pessoa/visualizacao_pessoa';
        $this->load->view('templates/template_admin2', $data);
    }

    public function listar_pessoas()
    {
        /* inicio de bloco responsavel para permissão de utilizar a função */
        if (!$this->session->userdata('logged_in')):
            redirect('login/logoff');
        endif;

        if(!$this->security_model->isAdmin() || $this->session->userdata('permissao_usu') != 1):
            $this->session->set_flashdata('erro', 'Você não possui permissão para acessar essa página! :X');
            redirect('painel', 'refresh');
        endif;
        /* inicio de bloco responsavel para permissão de utilizar a função */

        $data['pessoa'] = $this->pessoa_model->listar_pessoas();
        $data['main'] = 'pessoa/listar_pessoas';
        $this->load->view('templates/template_admin2', $data);
    }


    public function editar_pessoa($id_pessoa=NULL)
    {
        /* inicio de bloco responsavel para permissão de utilizar a função */
        if (!$this->session->userdata('logged_in')):
            redirect('login/logoff');
        endif;

        if(!$this->security_model->isAdmin() || $this->session->userdata('permissao_usu') != 1):
            $this->session->set_flashdata('erro', 'Você não possui permissão para acessar essa página! :X');
            redirect('painel', 'refresh');
        endif;
        /* inicio de bloco responsavel para permissão de utilizar a função */

        $id_pessoa = $this->funcoes->antiInjection($id_pessoa);
        $this->form_validation->set_rules('nome', 'NOME', 'trim|required|max_length[50]');

        if($id_pessoa != NULL && is_numeric($id_pessoa)):

            $this->form_validation->set_rules('email', 'EMAIL', 'trim|required|max_length[45]|strtolower|valid_email');
            $this->form_validation->set_rules('ramal', 'RAMAL', 'trim|required|min_length[14]|max_length[15]|alpha_numeric_spaces');
            $this->form_validation->set_rules('lattes', 'LATTES', 'trim|max_length[70]');
            $this->form_validation->set_rules('website', 'WEBSITE', 'trim|max_length[50]');
            $this->form_validation->set_rules('departamento', 'SELECIONE DEPARTAMENTO', 'callback_check_drop');
            $this->form_validation->set_rules('tipo_pessoa', 'SELECIONE TIPO PESSOA', 'callback_check_drop');

            if($this->form_validation->run() == TRUE):
                $pessoa['nome_pes'] = $this->input->post('nome');
                $pessoa['email_pes'] = $this->input->post('email');
                $pessoa['ramal_pes'] = $this->input->post('ramal');
                $pessoa['lattes_pes'] = $this->input->post('lattes');
                $pessoa['website_pes'] = $this->input->post('website');
                $pessoa['fk_id_tipo_pessoa'] = $this->input->post('tipo_pessoa');
                $pessoa['fk_id_departamento'] = $this->input->post('departamento');

                $usuario['login_usu'] = $this->input->post('email');

                if($this->pessoa_model->atualizar_pessoa($id_pessoa, $pessoa, $usuario) == TRUE):
                    $this->session->set_flashdata('sucesso', 'Dados atualizados com sucesso! :)');
                    redirect('pessoa/visualizar_pessoa/'.$id_pessoa);
                else:
                    $this->session->set_flashdata('erro', 'Oops... Ocorreu um erro ao atualizar os dados! :(');
                    redirect('pessoa/visualizar_pessoa/'.$id_pessoa);
                endif;
            endif;
            $data['pessoa'] = $this->pessoa_model->consulta_pessoa_by_id($id_pessoa);
            $data['departamento'] = $this->departamento_model->consulta_departamentos();
            $data['tipo_pessoa'] = $this->pessoa_model->getAllTipo_pessoa()->result();
        endif;
        $data['main'] = 'pessoa/editar_pessoa';
        $this->load->view('templates/template_admin2', $data);
    }


    public function deletar_usuario($id_usuario=NULL)
    {
        /* inicio de bloco responsavel para permissão de utilizar a função */
        if (!$this->session->userdata('logged_in')):
            redirect('login/logoff');
        endif;

        if(!$this->security_model->isAdmin() || $this->session->userdata('permissao_usu') != 1):
            $this->session->set_flashdata('erro', 'Você não possui permissão para acessar essa página! :X');
            redirect('painel', 'refresh');
        endif;
        /* inicio de bloco responsavel para permissão de utilizar a função */

        $id_usuario = $this->funcoes->antiInjection($id_usuario);

        if($id_usuario!=NULL && is_numeric($id_usuario)):
            if($this->admin_gerencia_model->deleta_usuario($id_usuario)):
                $this->session->set_flashdata('sucesso', 'Usuário removido com sucesso! :)');
                redirect('pessoa/listar_pessoas');
            endif;
            $this->session->set_flashdata('erro', 'Erro! Usuário NÃO foi removido! :(');
            redirect('pessoa/listar_pessoas');
        endif;
        $this->session->set_flashdata('erro', 'Erro! Dado inválido. Usuário NÃO foi removido! :(');
        redirect('pessoa/listar_pessoas');
    }

    /**
     * Bloqueia ou desbloqueia o usuário.
     * $status = 1 (usuário ativo), $status = 0 (usuário inativo)
     */
    public function bloquear_usuario($id_pessoa=NULL, $status=NULL)
    {
        /* inicio de bloco responsavel para permissão de utilizar a função */
        if (!$this->session->userdata('logged_in')):
            redirect('login/logoff');
        endif;

        if(!$this->security_model->isAdmin() || $this->session->userdata('permissao_usu') != 1):
            $this->session->set_flashdata('erro', 'Você não possui permissão para acessar essa página! :X');
            redirect('painel', 'refresh');
        endif;
        /* inicio de bloco responsavel para permissão de utilizar a função */

        $id_pessoa = $this->funcoes->antiInjection($id_pessoa);

        if($id_pessoa!=NULL && is_numeric($id_pessoa) && $status!=NULL && is_numeric($status) && ($status==0 || $status==1)):

            if($this->admin_gerencia_model->bloqueia_usuario($id_pessoa, $status)):
                if($status==0):
                    $this->session->set_flashdata('sucesso', 'Usuário bloqueado com sucesso! :)');
                elseif($status==1):
                    $this->session->set_flashdata('sucesso', 'Usuário desbloqueado com sucesso! :)');
                endif;
            else:
                $this->session->set_flashdata('erro', 'Oops... Ocorreu algum erro! Tente novamente. :(');
            endif;
            redirect('pessoa/visualizar_pessoa/'.$id_pessoa);
        else:
            redirect('pessoa/listar_pessoas');
        endif;
    }

    public function gerenciar_permissao($id_pessoa=NULL, $id_usuario=NULL, $permissao=NULL, $status=NULL)
    {
        /* inicio de bloco responsavel para permissão de utilizar a função */
        if (!$this->session->userdata('logged_in')):
            redirect('login/logoff');
        endif;

        if(!$this->security_model->isAdmin() || $this->session->userdata('permissao_usu') != 1):
            $this->session->set_flashdata('erro', 'Você não possui permissão para acessar essa página! :X');
            redirect('painel', 'refresh');
        endif;
        /* inicio de bloco responsavel para permissão de utilizar a função */

        $id_pessoa = $this->funcoes->antiInjection($id_pessoa);
        $id_usuario = $this->funcoes->antiInjection($id_usuario);
        $permissao = $this->funcoes->antiInjection($permissao);

        if($id_pessoa!=NULL && is_numeric($id_pessoa) && $id_usuario!=NULL && is_numeric($id_usuario) && $status!=NULL && is_numeric($status) && ($status==0 || $status==1) && $permissao!=NULL && is_numeric($permissao) && ($permissao >= 1 && $permissao < 3)):

            if($this->admin_gerencia_model->gerenciar_permissao($id_usuario, $permissao, $status) == true):
                if($status==0):
                    $this->session->set_flashdata('sucesso', 'Permissão removida com sucesso! :)');
                elseif($status==1):
                    $this->session->set_flashdata('sucesso', 'Permissão adicionada com sucesso! :)');
                endif;
            else:
                $this->session->set_flashdata('erro', 'Oops... Ocorreu algum erro! Tente novamente. :(');
            endif;
            redirect('pessoa/visualizar_pessoa/'.$id_pessoa);

        else:
            redirect('login/logoff');
        endif;
    }

/*

    ----------------------------------------------
    Funções auxiliares de validação de formulário.
    ----------------------------------------------

*/
    public function check_drop($str)
    {
        if($str == 'blank'):
            $this->form_validation->set_message('check_drop', 'Por favor, selecione um item!');
            return FALSE;
        else:
            return true;
        endif;
    }

    /*

    ----------------------------------------------
    Funções auxiliares para recuperar senha.
    ----------------------------------------------

    */
    public function nova_senha($token=NULL)
    {
        if($token==NULL || !ctype_alnum($token)){redirect('home','refresh');}

        $retorno = $this->cadastro_model->verifica_token($token, 'recuperar_senha');
        if ($retorno) {
            $dados['token'] = $token;
            $dados['main'] = 'telas/nova_senha';
        } else {
            //Token já usado;
            $dados['main'] = 'telas/recuperar_senha';
        }
        $this->load->view('templates/template_home', $dados);
    }

    public function falso($token=NULL)
    {
        if($token==NULL || !ctype_alnum($token)){redirect('home','refresh');}

        $retorno = $this->cadastro_model->verifica_token($token, 'recuperar_senha');
        if ($retorno) {
            $this->cadastro_model->pedido_falso($token, 'recuperar_senha');
            $data['main'] = 'telas/login';
        } else {
            $data['main'] = 'telas/login';
        }
        $this->load->view('templates/template_home', $data);
    }

}
