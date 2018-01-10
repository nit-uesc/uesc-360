<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Laboratorio_model extends CI_Model {

    /**
     * -------------------------------------------------------- CREATE
     */
    public function adicionar_coordenador_laboratorio($id_laboratorio = NULL, $coordenador = NULL) {
        if ($id_laboratorio != NULL && $coordenador != NULL):

            $laboratorio_has_pessoa['fk_id_laboratorio'] = $id_laboratorio;
            $laboratorio_has_pessoa['fk_id_pessoa'] = $coordenador;
            $laboratorio_has_pessoa['permissao_lhp'] = 2;
            $this->db->insert('laboratorio_has_pessoa', $laboratorio_has_pessoa);
            return true;
        endif;
        return false;
    }

    public function cadastrar_laboratorio($laboratorio = NULL, $coordenador = NULL, $cursos = NULL, $departamentos = NULL) {
        if ($laboratorio != NULL && $coordenador != NULL && $cursos != NULL && $departamentos != NULL):
            $this->db->trans_start();
            //
            $this->db->insert('laboratorio', $laboratorio);
            $labID = $this->db->insert_id();

            $laboratorio_has_pessoa['fk_id_laboratorio'] = $labID;
            $laboratorio_has_pessoa['fk_id_pessoa'] = $coordenador;
            $laboratorio_has_pessoa['permissao_lhp'] = 2;

            $i = 0;
            foreach ($cursos as $row):
                $laboratorio_has_curso[$i]['fk_id_laboratorio'] = $labID;
                $laboratorio_has_curso[$i]['fk_id_curso'] = $row;
                $i++;
            endforeach;

            $i = 0;
            foreach ($departamentos as $row):
                $laboratorio_has_departamento[$i]['fk_id_laboratorio'] = $labID;
                $laboratorio_has_departamento[$i]['fk_id_departamento'] = $row;
                $i++;
            endforeach;

            $this->db->insert('laboratorio_has_pessoa', $laboratorio_has_pessoa);
            $this->db->insert_batch('laboratorio_has_curso', $laboratorio_has_curso);
            $this->db->insert_batch('laboratorio_has_departamento', $laboratorio_has_departamento);
            //
            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE):
                return false;
            else:
                return true;
            endif;
        endif;
    }

    public function inserir_imagem_laboratorio($id_laboratorio = NULL, $img_laboratorio) {
        if ($id_laboratorio != NULL && $img_laboratorio != NULL):

            $this->db->trans_begin();

            $this->db->insert('img_laboratorio', $img_laboratorio);

            $id_img_laboratorio = $this->db->insert_id();

            $laboratorio_has_img['fk_id_laboratorio'] = $id_laboratorio;
            $laboratorio_has_img['fk_id_img_laboratorio'] = $id_img_laboratorio;

            $this->db->insert('laboratorio_has_img', $laboratorio_has_img);


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

    public function inserir_regulamento_laboratorio($id_laboratorio = NULL, $reg_laboratorio) {
        if ($id_laboratorio != NULL && $reg_laboratorio != NULL):

            $this->db->trans_begin();

            $this->db->insert('regulamento_laboratorio', $reg_laboratorio);

            $id_reg_laboratorio = $this->db->insert_id();

            $laboratorio_has_regulamento['fk_id_laboratorio'] = $id_laboratorio;
            $laboratorio_has_regulamento['fk_id_regulamento'] = $id_reg_laboratorio;

            $this->db->insert('laboratorio_has_regulamento', $laboratorio_has_regulamento);


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

    /**
     * -------------------------------------------------------- RETRIEVE
     */
    public function recuperar_laboratorio_by_id($id_laboratorio = NULL) {
        if ($id_laboratorio != NULL):
            $this->db->where('id_laboratorio', $id_laboratorio);
            return $this->db->get('laboratorio')->result();
        endif;
        return false;
    }

    public function recuperar_imagens_laboratorio_by_id($id_laboratorio = NULL) {
        if ($id_laboratorio != NULL):
            $this->db->select('iml.id_img_laboratorio, iml.nome_iml');
            $this->db->from('img_laboratorio as iml');
            $this->db->join('laboratorio_has_img as lhi', 'lhi.fk_id_img_laboratorio = iml.id_img_laboratorio', 'left');
            $this->db->where('lhi.fk_id_laboratorio', $id_laboratorio);
            return $this->db->get()->result();
        endif;
        return false;
    }

    /**
     * -------------------------------------------------------- UPDATE
     */
    public function atualizar_dados_laboratorio($id_laboratorio = NULL, $laboratorio = NULL) {
        if ($id_laboratorio != NULL && $laboratorio != NULL):
            $this->db->where('id_laboratorio', $id_laboratorio);
            $this->db->update('laboratorio', $laboratorio);
            return true;
        endif;
        return false;
    }

    //
    public function atualizar_coordenadores_laboratorio($id_laboratorio = NULL, $coordenadores = NULL) {
        if ($id_laboratorio != NULL && $coordenadores != NULL):
            $this->db->where('fk_id_laboratorio', $id_laboratorio);
            $this->db->update('laboratorio_has_pessoa', $coordenadores);
            return true;
        endif;
        return false;
    }

    public function atualizar_cursos_laboratorio($id_laboratorio = NULL, $cursos = NULL) {
        if ($id_laboratorio != NULL && $cursos != NULL):
            $iPos = 0;
            foreach ($cursos as $row):
                $laboratorio_has_curso[$iPos]['fk_id_laboratorio'] = $id_laboratorio;
                $laboratorio_has_curso[$iPos]['fk_id_curso'] = $row;
                $iPos++;
            endforeach;

            $this->db->trans_begin();
            // delete
            $this->db->where('fk_id_laboratorio', $id_laboratorio);
            $this->db->delete('laboratorio_has_curso');
            // insert
            $this->db->insert_batch('laboratorio_has_curso', $laboratorio_has_curso);

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

    public function atualizar_departamentos_laboratorio($id_laboratorio = NULL, $departamentos = NULL) {
        if ($id_laboratorio != NULL && $departamentos != NULL):
            $iPos = 0;
            foreach ($departamentos as $row):
                $laboratorio_has_departamento[$iPos]['fk_id_laboratorio'] = $id_laboratorio;
                $laboratorio_has_departamento[$iPos]['fk_id_departamento'] = $row;
                $iPos++;
            endforeach;

            $this->db->trans_begin();
            // delete
            $this->db->where('fk_id_laboratorio', $id_laboratorio);
            $this->db->delete('laboratorio_has_departamento');
            // insert
            $this->db->insert_batch('laboratorio_has_departamento', $laboratorio_has_departamento);

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

    /**
     * -------------------------------------------------------- DELETE
     */
    public function remover_coordenador_laboratorio($id_laboratorio = NULL, $id_pessoa = NULL) {
        if ($id_laboratorio != NULL && $id_pessoa != NULL):
            $this->db->where('fk_id_laboratorio', $id_laboratorio);
            $this->db->where('fk_id_pessoa', $id_pessoa);
            $this->db->where('permissao_lhp', 2);
            $this->db->delete('laboratorio_has_pessoa');
            return true;
        endif;
        return false;
    }

    public function deletar_laboratorio($id_laboratorio = NULL) {
        if ($id_laboratorio != NULL):
            $this->db->trans_begin();

            $imgs_lab = $this->recuperar_imagens_laboratorio_by_id($id_laboratorio);
            if ($imgs_lab):
                foreach ($imgs_lab as $row):
                    $this->deletar_imagem_laboratorio($row->id_img_laboratorio);
                endforeach;
            endif;

            $this->db->where('id_laboratorio', $id_laboratorio);
            $this->db->delete('laboratorio');

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

    public function deletar_imagem_laboratorio($id_img_laboratorio = NULL) {
        if ($id_img_laboratorio != NULL):
            $this->db->select('nome_iml');
            $this->db->from('img_laboratorio');
            $this->db->where('id_img_laboratorio', $id_img_laboratorio);
            $path = './uploads/laboratorio/' . $this->db->get()->row()->nome_iml;

            if ($path != NULL && file_exists($path)):
                unlink($path);
                $this->db->where('id_img_laboratorio', $id_img_laboratorio);
                $this->db->delete('img_laboratorio');
                return true;
            endif;
        endif;
        return false;
    }

    public function deletar_norma_regulamento_laboratorio($id_reg_laboratorio = NULL) {

        if ($id_reg_laboratorio != NULL):
            $this->db->select('nome_reg_lab');
            $this->db->from('regulamento_laboratorio');
            $this->db->where('id_reg_lab', $id_reg_laboratorio);
            $path = './uploads/normas_regulamentos/' . $this->db->get()->row()->nome_reg_lab;

            if ($path != NULL && file_exists($path)):
  
                unlink($path);

                $this->db->where('fk_id_regulamento', $id_reg_laboratorio);
                $this->db->delete('laboratorio_has_regulamento');

                $this->db->where('id_reg_lab', $id_reg_laboratorio);
                $this->db->delete('regulamento_laboratorio');

                return true;
            endif;
        endif;
        return false;
    }

}

/* End of file laboratorio_model.php */
/* Location: ./application/models/laboratorio_model.php */
