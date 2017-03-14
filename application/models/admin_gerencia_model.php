<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_gerencia_model extends CI_Model
{
    /**
     * Bloqueia ou desbloqueia o usuário.
     * $status = 1 (usuário ativo), $status = 0 (usuário inativo)
     */
    public function bloqueia_usuario($id_pessoa, $status)
    {
        if($id_pessoa != NULL && is_numeric($id_pessoa) && $status != NULL && ($status == 0 || $status == 1)):
            $this->db->select('fk_id_usuario');
            $this->db->from('pessoa');
            $this->db->where('id_pessoa', $id_pessoa);
            $id_usuario = $this->db->get()->row()->fk_id_usuario;

            if($id_usuario != NULL && is_numeric($id_usuario)):
                $usuario['ativo_usu'] = $status;
                $this->db->where('id_usuario', $id_usuario);
                $this->db->update('usuario', $usuario);
                return true;
            endif;
            return false;
        endif;
        return false;
    }

    public function deleta_usuario($id_usuario)
    {
        if($id_usuario != NULL && is_numeric($id_usuario)):
            $this->db->where('id_usuario', $id_usuario);
            $this->db->delete('usuario');
            return true;
        endif;
        return false;
    }


    public function gerenciar_permissao($id_usuario=NULL, $permissao=NULL, $status=NULL)
    {
        if($id_usuario!=NULL && is_numeric($id_usuario) && $status!=NULL && is_numeric($status) && ($status==0 || $status==1) && $permissao!=NULL && is_numeric($permissao) && ($permissao >= 1 && $permissao < 3)):

            if($status == 1 && !$this->tem_permissao($id_usuario, $permissao)):

                $usuario_has_permissao['fk_id_usuario']   = $id_usuario;
                $usuario_has_permissao['fk_id_permissao'] = $permissao;
                $this->db->insert('usuario_has_permissao', $usuario_has_permissao);
                return true;

            elseif($status == 0 && $this->tem_permissao($id_usuario, $permissao)):

                $this->db->where('fk_id_usuario', $id_usuario);
                $this->db->where('fk_id_permissao', $permissao);
                $this->db->delete('usuario_has_permissao');
                return true;

            else:

                return false;

            endif;
        endif;
        return false;
    }

    private function tem_permissao($id_usuario, $permissao)
    {
        $this->db->where('fk_id_usuario', $id_usuario);
        $this->db->where('fk_id_permissao', $permissao);
        $rs = $this->db->get('usuario_has_permissao');

        if($rs->num_rows() == 1):
            return true;
        else:
            return false;
        endif;
    }


}

/* End of file admin_gerencia_model.php */
/* Location: ./application/models/admin_gerencia_model.php */