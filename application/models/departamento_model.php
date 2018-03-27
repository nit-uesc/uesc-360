<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Departamento_model extends CI_Model
{
    public function cadastrar_departamento($departamento = NULL) {
        if ($departamento != NULL):
            $this->db->trans_start();
            
            $this->db->insert('departamento', $departamento);

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE):
                return false;
            else:
                return true;
            endif;
        endif;
    }

    //Recuperação de dados das tabelas para preenchimento dos dropdowns
	public function getAllDepartamento()
	{
		$this->db->order_by('nome_dpt', "asc");
		return $this->db->get('departamento');
    }
    
    public function consulta_departamentos()
    {
        // $this->db->order_by('nome_dpt', "asc");
        return $this->db->get('departamento')->result();
    }
}