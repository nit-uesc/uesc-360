<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Departamento_model extends CI_Model
{
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