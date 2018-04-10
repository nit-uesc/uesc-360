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
    
    public function listar_departamento()
    {
        // $this->db->order_by('nome_dpt', "asc");
        return $this->db->get('departamento')->result();
    }

    public function deletar_departamento($id_departamento = NULL) {
        if ($id_departamento != NULL):
            $this->db->trans_begin();
            $this->db->where('id_departamento', $id_departamento);
            $this->db->delete('departamento');

            if ($this->db->trans_status() === FALSE):
                $this->db->trans_rollback();
                return false;
            else:
                $this->db->trans_commit();
                return true;
            endif;

        endif;
        return false;
    }
    public function consulta_departamento_by_id($id_departamento)
    {
        $this->db->select('*');
        $this->db->from('departamento as dpt');
        // $this->db->where('lhp.permissao_lhp', 2);
        $this->db->where('dpt.id_departamento', $id_departamento);
        // $this->db->where('dpt.ativo_dpt', 1);

        return $this->db->get()->result();
    }

    public function atualizar_dados_departamento($id_departamento = NULL, $departamento = NULL) {
        if ($id_departamento != NULL && $departamento != NULL):
            $this->db->where('id_departamento', $id_departamento);
            $this->db->update('departamento', $departamento);
            return true;
        endif;
        return false;
    }

    // Departamentos do laboratório por ID
    public function consulta_departamento_laboratorio($id_departamento)
    {
        // $this->db->select('lab.nome_lab');
        $this->db->select('*');
        $this->db->from('laboratorio_has_departamento as lhd');
        $this->db->join('laboratorio as lab', 'lab.id_laboratorio = lhd.fk_id_laboratorio', 'left');
        $this->db->where('lhd.fk_id_departamento', $id_departamento);
        return $this->db->get()->result();
    }
}