<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class checar_validacao extends CI_Controller
{
public function pedido_falso($value='')
    {
        $token = $this->uri->segment(3);
        if ($this->cadastro_model->verifica_token($token, 'pedido_cadastro')) {
            $this->cadastro_model->pedido_falso($token, 'pedido_cadastro');
        }

        $dados = array(
            'tela' => 'telas/home'
        );
        $this->load->view('template', $dados);
    }

// -----------------------------------------------------------------------------------------------

    

// -----------------------------------------------------------------------------------------------



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
    public function test()
    {
        echo "OK OK";
    }
    public function check_drop_date($str)
    {
        if(empty($str)):
            $this->form_validation->set_message('check_drop_date', 'Por favor, selecione um item!');
            return FALSE;
        else:
            return true;
        endif;
    }

    public function check_cpf($cpf)
    {
        $this->form_validation->set_message('check_cpf', 'O %s informado não é válido.');
        if($cpf == ''):
            return true;
        endif;
        $cpf = preg_replace('/[^0-9]/','',$cpf);
        if(strlen($cpf) != 11 || preg_match('/^([0-9])\1+$/', $cpf)){
            return false;
        }
        $digit = substr($cpf, 0, 9);
        for($j=10; $j <= 11; $j++){
            $sum = 0;
            for($i=0; $i< $j-1; $i++){
                $sum += ($j-$i) * ((int) $digit[$i]);
            }
            $summod11 = $sum % 11;
            $digit[$j-1] = $summod11 < 2 ? 0 : 11 - $summod11;
        }
        return $digit[9] == ((int)$cpf[9]) && $digit[10] == ((int)$cpf[10]);
    }

}