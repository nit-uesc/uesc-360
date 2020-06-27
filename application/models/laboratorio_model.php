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
    /*-------------------------------------------- Importado do model :crud_model
         Tentando colocar tudo de cada controller em seu devido model..
         Exemplo tudo relacionado a Laboratorio , irei colocar aqui.
         Para excluir o crud_model mais a frente
         */
    
        public function getAllLaboratorio()
        {
            $this->db->select('*');
            $this->db->from('laboratorio');
            $this->db->where('ativo_lab', 1);
            return $this->db->get();
        }
        
        public function insertLaboratorio($dados=NULL)
        {
            if ($dados!=NULL):
                $this->db->insert('laboratorio', $dados);
            endif;
        }

        public function insertImg_laboratorio($dados=NULL)
        {
            if ($dados!=NULL):
                $this->db->insert('img_laboratorio', $dados);
            endif;
        }
        
        public function insertLaboratorio_has_img($dados=NULL)
        {
            if ($dados!=NULL):
                $this->db->insert('laboratorio_has_img', $dados);
            endif;
        }
        # Retrieve ---------------------------------------------------------------------------------

        public function getBasicInfoLaboratorio()
        {
            $this->db->select('lab.id_laboratorio, lab.nome_lab');
            $this->db->from('laboratorio as lab');
            $this->db->where('ativo_lab', 1);
            $this->db->order_by('lab.nome_lab', "asc");
            return $this->db->get();
        }

        public function selectLaboratorio()
        {
            $this->db->select('lab.id_laboratorio, lab.nome_lab, lab.ramal_lab, lab.website_lab, lab.descricao_lab,
                            lab.atividades_lab, lab.areas_atendidas_lab, lab.multiusuario_lab, lab.usa_ensino_lab,
                            lab.usa_pesquisa_lab, lab.usa_extensao_lab, lab.last_modified_lab, lab.status_lab,
                            pav.nome_pav');
            $this->db->from('laboratorio as lab');
            $this->db->join('pavilhao as pav', 'lab.fk_id_pavilhao = pav.id_pavilhao', 'inner');
            $this->db->where('ativo_lab', 1);
            return $this->db->get();
        }

        public function selectLaboratorioByPessoa($id=NULL)
        {
            if($id!=NULL):
                $this->db->select('lab.id_laboratorio, lab.nome_lab');
                $this->db->from('laboratorio_has_pessoa as lhp');
                $this->db->join('laboratorio as lab', 'lab.id_laboratorio = lhp.fk_id_laboratorio', 'inner');
                $this->db->where('lhp.fk_id_pessoa', $id);
                $this->db->where('lab.ativo_lab', 1);

                return $this->db->get();
            else:
                die('Erro! Não foi possível listar os laboratórios. :(');
            endif;
        }

        public function selectLaboratorioByID($id)
        {
            $this->db->select('lhp.id_laboratorio_pessoa, pes.id_pessoa, lab.id_laboratorio, lab.nome_lab,
                                lab.ramal_lab, lab.website_lab, lab.descricao_lab, lab.atividades_lab,
                                lab.areas_atendidas_lab, lab.multiusuario_lab, lab.usa_ensino_lab,
                                lab.usa_pesquisa_lab, lab.usa_extensao_lab, lab.last_modified_lab,
                                lab.fk_id_pavilhao, pav.nome_pav');
            $this->db->from('laboratorio_has_pessoa as lhp');
            $this->db->join('pessoa as pes', 'pes.id_pessoa = lhp.fk_id_pessoa', 'inner');
            $this->db->join('laboratorio as lab', 'lab.id_laboratorio = lhp.fk_id_laboratorio', 'inner');
            $this->db->join('pavilhao as pav', 'lab.fk_id_pavilhao = pav.id_pavilhao', 'inner');
            $this->db->where('lab.id_laboratorio = '.$id);
            $this->db->where('lab.ativo_lab', 1);
            return $this->db->get();
        }

        public function selectCoordenadorByID($id)
        {
            $this->db->select('pes.id_pessoa');
            $this->db->from('laboratorio_has_pessoa as lhp');
            $this->db->join('laboratorio as lab', 'lab.id_laboratorio = lhp.fk_id_laboratorio', 'inner');
            $this->db->join('pessoa as pes', 'pes.id_pessoa = lhp.fk_id_pessoa', 'inner');
            $this->db->where('lab.id_laboratorio = '.$id);
            return $this->db->get();
        }

        public function selectCursoLab($id)
        {
            $this->db->select('id_curso, nome_cur');
            $this->db->from('curso, laboratorio_has_curso');
            $this->db->where('fk_id_curso = id_curso and fk_id_laboratorio = '.$id);
            return $this->db->get();
        }

        public function selectCoordenadorLab($id)
        {
            $this->db->select('id_pessoa, nome_pes');
            $this->db->from('pessoa, laboratorio_has_pessoa');
            $this->db->where('fk_id_pessoa = id_pessoa and fk_id_laboratorio = '.$id);
            return $this->db->get();
        }

        public function selectDepartamentoLab($id)
        {
            $this->db->select('id_departamento, nome_dpt');
            $this->db->from('departamento, laboratorio_has_departamento');
            $this->db->where('fk_id_departamento = id_departamento and fk_id_laboratorio = '.$id);
            return $this->db->get();
        }

        public function selectImgLab($id)
        {
            $this->db->select('nome_iml');
            $this->db->from('laboratorio_has_img, img_laboratorio');
            $this->db->where('fk_id_img_laboratorio = id_img_laboratorio and fk_id_laboratorio = '.$id);
            $this->db->where('img_laboratorio.ativo_iml', 1);
            return $this->db->get();
        }

        # Update -----------------------------------------------------------------------------------

	public function updateLaboratorio($id, $dados)
	{
		$this->db->where('id_laboratorio', $id);
		$this->db->update('laboratorio', $dados);
	}

	public function updateLaboratorioHasPessoa($id, $dados)
	{
		$this->db->where('id_laboratorio_pessoa', $id);
		$this->db->update('laboratorio_has_pessoa', $dados);
	}

	# Delete -----------------------------------------------------------------------------------

	public function deleteLaboratorio($id, $dados)
	{
		$this->db->where('id_laboratorio', $id);
		$this->db->update('laboratorio', $dados);
	}

	public function deleteEquipamentoDpt($id)
	{
		$this->db->where('fk_id_laboratorio', $id);
		$this->db->delete('laboratorio_has_departamento');
	}

	public function deleteEquipamentoCursos($id)
	{
		$this->db->where('fk_id_laboratorio', $id);
		$this->db->delete('laboratorio_has_curso');
	}

}
/* End of file laboratorio_model.php */
/* Location: ./application/models/laboratorio_model.php */
