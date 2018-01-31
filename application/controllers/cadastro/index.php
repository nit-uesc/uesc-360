<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require 'checar_validacao.php';
class Index extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<small class="red-text">* ', '</small>');

        $this->load->model('crud_model');
        $this->load->model('cadastro_model');
        $this->load->model('email_model');
    }
    public function index()
    {
        $checar = new checar_validacao();
        $checar->test();

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

            $this->crud_model->insertUsuario($dados1);
            $dados2['fk_id_usuario'] = $this->db->insert_id();
            $this->crud_model->insertPessoa($dados2);

            $dados3['fk_id_usuario'] = $dados2['fk_id_usuario'];
            $dados3['fk_id_permissao'] = 3;
            $this->crud_model->insertPermissao($dados3);

            $this->cadastro_model->invalida_token($token, 'pedido_cadastro');

            $this->session->set_flashdata('sucesso', 'Cadastro efetuado com sucesso! :)');
            redirect('login');
        endif;

        $data['departamento'] = $this->crud_model->getAllDepartamento()->result();
        $data['tipo_pessoa'] = $this->crud_model->getAllTipo_pessoa()->result();
        $data['main'] = 'telas/cadastro_finalizar';
        $this->load->view('templates/template_home', $data);
    }

}