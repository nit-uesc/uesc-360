<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class checar_validacao extends CI_Controller
{
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

    public function gravar_senha($token=NULL)
    {
        if($token==NULL || !ctype_alnum($token)){redirect('home','refresh');}

        $this->form_validation->set_rules('senha', 'NOVA SENHA', 'trim|required|min_length[5]');
        $this->form_validation->set_rules('confirmar_senha', 'CONFIRMAR SENHA', 'trim|required|min_length[5]|matches[senha]');
        $email = $this->cadastro_model->verifica_token($token, 'recuperar_senha');
        $data['main'] = 'telas/nova_senha';

        if($email != false)
        {
            if ($this->form_validation->run()==TRUE):
                $senha = $this->input->post('senha');
                $pessoa = $this->crud_model->get_pessoa($email);
                $this->cadastro_model->update_senha($pessoa[0]['fk_id_usuario'], $senha);
                $this->cadastro_model->invalida_token($token, 'recuperar_senha');
                $data['main'] = 'telas/login';
                $data['sucesso'] = 'Senha alterada com sucesso!';
            endif;
        }
        else
        {
            $data['main'] = 'telas/recuperar_senha';
            $data['erro'] = 'Token inválido! Solicite outro link de recuperação de senha.';
        }
        $this->load->view('templates/template_home', $data);
    }

}