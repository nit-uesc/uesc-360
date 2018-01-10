<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pessoa_model extends CI_Model
{
    /**
     * -------------------------------------------------------- CREATE
     */
    public function cadastrar_pessoa($usuario=NULL, $pessoa=NULL, $permissao=NULL)
    {
        if($usuario!=NULL && $pessoa!=NULL && $permissao!=NULL):
            $this->db->trans_start();

            $this->db->insert('usuario', $usuario);

            $userID = $this->db->insert_id();
            $pessoa['fk_id_usuario'] = $userID;
            $this->db->insert('pessoa', $pessoa);

            $permissao_usuario['fk_id_usuario'] = $userID;
            $permissao_usuario['fk_id_permissao'] = $permissao;

            $this->db->insert('usuario_has_permissao', $permissao_usuario);

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE):
                return false;
            else:
                return true;
            endif;
        endif;
    }

    /**
     * -------------------------------------------------------- RETRIEVE
     */

    /**
     * -------------------------------------------------------- UPDATE
     */
    public function atualizar_pessoa($id_pessoa=NULL, $pessoa=NULL, $usuario=NULL)
    {
        if($id_pessoa!=NULL && $pessoa!=NULL && $usuario!=NULL):

            $this->db->trans_begin();

            $this->db->select('fk_id_usuario');
            $this->db->from('pessoa');
            $this->db->where('id_pessoa', $id_pessoa);
            $ID_USU = $this->db->get()->row()->fk_id_usuario;

            $this->db->where('id_usuario', $ID_USU);
            $this->db->update('usuario', $usuario);

            $this->db->where('id_pessoa', $id_pessoa);
            $this->db->update('pessoa', $pessoa);

            if($this->db->trans_status() === FALSE):
                $this->db->trans_rollback();
                return false;
            else:
                $this->db->trans_commit();
                return true;
            endif;


        else:
            return false;
        endif;
    }


    /**
     * -------------------------------------------------------- DELETE
     */



}

/* End of file pessoa_model.php */
/* Location: ./application/models/pessoa_model.php */
