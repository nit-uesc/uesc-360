<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pavilhao_model extends CI_Model
{
    public function cadastrar_pavilhao($pavilhao = NULL) {
        if ($pavilhao != NULL):
            $this->db->trans_start();
            
            $this->db->insert('pavilhao', $pavilhao);

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE):
                return false;
            else:
                return true;
            endif;
        endif;
    }

    //Recuperação de dados das tabelas para preenchimento dos dropdowns
	public function getAllPavilhao()
	{
		$this->db->order_by('nome_pav', "asc");
		return $this->db->get('pavilhao');
    }
    
    public function listar_pavilhao()
    {
        // $this->db->order_by('nome_pav', "asc");
        return $this->db->get('pavilhao')->result();
    }

    public function deletar_pavilhao($id_pavilhao = NULL) {
        if ($id_pavilhao != NULL):
            $this->db->trans_begin();
            $this->db->where('id_pavilhao', $id_pavilhao);
            $this->db->delete('pavilhao');

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
    public function consulta_pavilhao_by_id($id_pavilhao)
    {
        $this->db->select('*');
        $this->db->from('pavilhao as dpt');
        // $this->db->where('lhp.permissao_lhp', 2);
        $this->db->where('dpt.id_pavilhao', $id_pavilhao);
        // $this->db->where('dpt.ativo_dpt', 1);

        return $this->db->get()->result();
    }

    public function atualizar_dados_pavilhao($id_pavilhao = NULL, $pavilhao = NULL) {
        if ($id_pavilhao != NULL && $pavilhao != NULL):
            $this->db->where('id_pavilhao', $id_pavilhao);
            $this->db->update('pavilhao', $pavilhao);
            return true;
        endif;
        return false;
    }

    // pavilhaos do laboratório por ID
    /* Necessário fazer diferente, Pois não existe uma tabela laboratorio_has_pavilhao */
    public function consulta_pavilhao_laboratorio($id_pavilhao)
    {
        // $this->db->select('lab.nome_lab');
        $this->db->select('*');
        $this->db->from('laboratorio as lab');
        // $this->db->join('laboratorio as lab', 'lab.id_laboratorio = lab.fk_id_laboratorio', 'left');
        $this->db->where('lab.fk_id_pavilhao', $id_pavilhao);
        return $this->db->get()->result();
    }
}