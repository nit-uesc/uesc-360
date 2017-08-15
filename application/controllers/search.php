<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Search extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('funcoes');
        $this->load->model('generica_consulta_model');
        $this->load->model('equipamento_model');
    }

    public function index() {
        echo "There is nothing here... :X";
    }

    public function pessoa($id_pessoa = NULL) {
        if ($id_pessoa != NULL && is_numeric($id_pessoa)):
            $data['pessoa'] = $this->generica_consulta_model->consulta_pessoa_by_id($this->funcoes->antiInjection($id_pessoa));
            $data['laboratorio_coordena'] = $this->generica_consulta_model->consulta_coordenador_laboratorio($this->funcoes->antiInjection($id_pessoa));
        endif;

        $data['main'] = 'search/pessoa2';
        $this->load->view('templates/template_publico', $data);
    }

    public function laboratorio($id_laboratorio = NULL) {
        $id_laboratorio = $this->funcoes->antiInjection($id_laboratorio);

        if ($id_laboratorio != NULL && is_numeric($id_laboratorio)):
            $data['laboratorio'] = $this->generica_consulta_model->consulta_laboratorio_by_id($id_laboratorio);
            $data['laboratorio_img'] = $this->generica_consulta_model->consulta_imagem_laboratorio($id_laboratorio);
            $data['laboratorio_pes'] = $this->generica_consulta_model->consulta_pessoa_laboratorio($id_laboratorio);
            $data['laboratorio_dpt'] = $this->generica_consulta_model->consulta_departamento_laboratorio($id_laboratorio);
            $data['laboratorio_cur'] = $this->generica_consulta_model->consulta_curso_laboratorio($id_laboratorio);
            $data['laboratorio_eqp'] = $this->generica_consulta_model->consulta_equipamento_laboratorio($id_laboratorio);
            $data['coordenadores_lab'] = $this->generica_consulta_model->consulta_coordenadores_laboratorio_by_id($id_laboratorio);
        endif;

        $data['main'] = 'search/laboratorio2';
        echo'<script>var dano = ' . JSON_encode($data) . '</script>';
        $this->load->view('templates/template_publico', $data);
    }

    public function equipamento($id_equipamento = NULL) {
        $id_equipamento = $this->funcoes->antiInjection($id_equipamento);

        if ($id_equipamento != NULL && is_numeric($id_equipamento)):
            $data['equipamento'] = $this->generica_consulta_model->consulta_equipamento_by_id($id_equipamento);
            $data['equipamento_img'] = $this->equipamento_model->recuperar_imagens_equipamento_by_id($id_equipamento);
        endif;

        $data['main'] = 'search/equipamento2';
        $this->load->view('templates/template_publico', $data);
    }

}
