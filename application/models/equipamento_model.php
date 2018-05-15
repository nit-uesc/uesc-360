<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Equipamento_model extends CI_Model
{
    /**
     * -------------------------------------------------------- CREATE
     */
    public function cadastrar_equipamento($equipamento=NULL, $laboratorio_has_equipamento=NULL)
    {
        if($equipamento!=NULL && $laboratorio_has_equipamento!=NULL):
            $this->db->trans_start();

            $this->db->insert('equipamento', $equipamento);
            $eqpID = $this->db->insert_id();
            $laboratorio_has_equipamento['fk_id_equipamento'] = $eqpID;
            $this->db->insert('laboratorio_has_equipamento', $laboratorio_has_equipamento);

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE):
                return false;
            else:
                return true;
            endif;
        endif;
    }

    public function inserir_imagem_equipamento($id_equipamento=NULL, $img_equipamento)
    {
        if($id_equipamento!=NULL && $img_equipamento!=NULL):

            $this->db->trans_begin();

            $this->db->insert('img_equipamento', $img_equipamento);

            $id_img_equipamento = $this->db->insert_id();

            $equipamento_has_img['fk_id_equipamento']     = $id_equipamento;
            $equipamento_has_img['fk_id_img_equipamento'] = $id_img_equipamento;

            $this->db->insert('equipamento_has_img', $equipamento_has_img);


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

    public function recuperar_imagens_equipamento_by_id($id_equipamento=NULL)
    {
    	if($id_equipamento!=NULL):
	        $this->db->select('ime.id_img_equipamento,ime.nome_ime');
	        $this->db->from('img_equipamento as ime');
	        $this->db->join('equipamento_has_img as ehi', 'ehi.fk_id_img_equipamento = ime.id_img_equipamento', 'left');
	        $this->db->where('ehi.fk_id_equipamento', $id_equipamento);
	        return $this->db->get()->result();
    	endif;
	    return false;
    }

    /**
     * -------------------------------------------------------- UPDATE
     */

    public function atualizar_dados_equipamento($id_equipamento=NULL, $equipamento=NULL)
    {
        if($id_equipamento!=NULL && $equipamento!=NULL):
            $this->db->trans_begin();
            $this->db->where('id_equipamento', $id_equipamento);
            $this->db->update('equipamento', $equipamento);

            if ($this->db->trans_status() === FALSE):
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

    public function atualizar_laboratorio_equipamento($id_equipamento=NULL, $laboratorio_has_equipamento=NULL)
    {
        if($id_equipamento!=NULL && $laboratorio_has_equipamento!=NULL):
            $this->db->trans_begin();

            $this->db->where('fk_id_equipamento', $id_equipamento);
            $this->db->update('laboratorio_has_equipamento', $laboratorio_has_equipamento);

            if ($this->db->trans_status() === FALSE):
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

    public function deletar_equipamento($id_laboratorio=NULL, $id_equipamento=NULL)
    {
    	if($id_laboratorio!=NULL && $id_equipamento!=NULL):

            $this->db->trans_begin();

        	$this->db->where('fk_id_equipamento', $id_equipamento);
        	$this->db->where('fk_id_laboratorio', $id_laboratorio);
        	$rs = $this->db->get('laboratorio_has_equipamento');

        	if($rs->num_rows() == 1):
        		$imgs_eqp = $this->recuperar_imagens_equipamento_by_id($id_equipamento);
        		if($imgs_eqp):
        			foreach ($imgs_eqp as $row):
        				$this->deletar_imagem_equipamento($row->id_img_equipamento);
        			endforeach;
        		endif;
    			$this->db->where('id_equipamento', $id_equipamento);
    			$this->db->delete('equipamento');
        	else:
                return false;
        	endif;

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

    public function deletar_imagem_equipamento($id_img_equipamento=NULL)
    {
        if($id_img_equipamento!=NULL):

            $this->db->select('nome_ime');
            $this->db->from('img_equipamento');
            $this->db->where('id_img_equipamento', $id_img_equipamento);
            $path = './uploads/equipamento/'.$this->db->get()->row()->nome_ime;

            if($path!=NULL && file_exists($path)):
                unlink($path);
                $this->db->where('id_img_equipamento', $id_img_equipamento);
                $this->db->delete('img_equipamento');
                return true;
            endif;
        endif;
        return false;
    }
    /* -------------------------------------------------------- Importado do model :crud_model
         Tentando colocar tudo de cada controller em seu devido model..
         Exemplo tudo relacionado a EQUIPAMENTO , irei colocar aqui.
         Para excluir o crud_model mais a frente
         */

    public function insertEquipamento($dados=NULL)
	{
		if ($dados!=NULL):
			$this->db->insert('equipamento', $dados);
		endif;
	}

    public function insertLaboratorio_has_equipamento($dados=NULL)
	{
		if ($dados!=NULL):
			$this->db->insert('laboratorio_has_equipamento', $dados);
		endif;
	}

	//Inserção dos metadados das imagens
	public function insertImg_equipamento($dados=NULL)
	{
		if ($dados!=NULL):
			$this->db->insert('img_equipamento', $dados);
		endif;
	}

    public function insertEquipamento_has_img($dados=NULL)
	{
		if ($dados!=NULL):
			$this->db->insert('equipamento_has_img', $dados);
		endif;
	}

    # Retrieve ---------------------------------------------------------------------------------

	public function getBasicInfoEquipamento()
	{
		$this->db->select('eqp.id_equipamento, eqp.nome_eqp');
		$this->db->from('equipamento as eqp');
		$this->db->where('ativo_eqp', 1);
		$this->db->order_by('eqp.nome_eqp', "asc");
		return $this->db->get();
	}

	public function selectEquipamento()
	{
		$this->db->select('lab.id_laboratorio, lab.nome_lab, eqp.id_equipamento, eqp.nome_eqp, eqp.fabricante_eqp,
						   eqp.quantidade_eqp, eqp.especificacao_eqp, eqp.descricao_eqp, eqp.status_eqp');
		$this->db->from('laboratorio_has_equipamento');
		$this->db->join('laboratorio as lab', 'fk_id_laboratorio = id_laboratorio', 'inner');
		$this->db->join('equipamento as eqp', 'fk_id_equipamento = id_equipamento', 'inner');
		$this->db->where('ativo_eqp', 1);
		return $this->db->get();
	}

	public function selectEquipamentoByID($id)
	{
		$this->db->select('lhe.id_laboratorio_equipamento, lab.id_laboratorio, lab.nome_lab, eqp.id_equipamento, eqp.nome_eqp,
							eqp.fabricante_eqp, eqp.quantidade_eqp, eqp.especificacao_eqp, eqp.descricao_eqp');
		$this->db->from('laboratorio_has_equipamento as lhe');
		$this->db->join('laboratorio as lab', 'lhe.fk_id_laboratorio = lab.id_laboratorio', 'inner');
		$this->db->join('equipamento as eqp', 'lhe.fk_id_equipamento = eqp.id_equipamento', 'inner');
		$this->db->where('eqp.id_equipamento = '.$id);
		$this->db->where('eqp.ativo_eqp', 1);
		return $this->db->get();
	}

	public function selectEquipamentoByLab($labID=NULL)
	{
		if($labID!=NULL):
			$this->db->select('eqp.id_equipamento, eqp.nome_eqp, eqp.fabricante_eqp,
							   eqp.quantidade_eqp, eqp.especificacao_eqp, eqp.descricao_eqp');
			$this->db->from('equipamento as eqp');
			$this->db->join('laboratorio_has_equipamento as lhe', 'lhe.fk_id_equipamento = eqp.id_equipamento', 'inner');
			$this->db->where('eqp.ativo_eqp', 1);
			$this->db->where('lhe.fk_id_laboratorio', $labID);
		return $this->db->get();

		else:
			die('Erro ao tentar recuperar informações! :(');
		endif;
	}

	public function selectLabEquipamento($id)
	{
		$this->db->select('nome_lab');
		$this->db->from('laboratorio, laboratorio_has_equipamento');
		$this->db->where('fk_id_laboratorio = id_laboratorio and fk_id_equipamento = '.$id);
		return $this->db->get();
	}

	public function selectImgEqp($id)
	{
		$this->db->select('nome_ime');
		$this->db->from('equipamento_has_img, img_equipamento');
		$this->db->where('fk_id_img_equipamento = id_img_equipamento and fk_id_equipamento = '.$id);
		$this->db->where('img_equipamento.ativo_ime', 1);
		return $this->db->get();
	}

	# Update -----------------------------------------------------------------------------------

	public function updateEquipamento($id, $dados)
	{
		$this->db->where('id_equipamento', $id);
		$this->db->update('equipamento', $dados);
	}

	public function updateLaboratorioHasEquipamento($id, $dados)
	{
		$this->db->where('id_laboratorio_equipamento', $id);
		$this->db->update('laboratorio_has_equipamento', $dados);
	}

	# Delete -----------------------------------------------------------------------------------

	public function deleteEquipamento($id, $dados)
	{
		$this->db->where('id_equipamento', $id);
		$this->db->update('equipamento', $dados);
	}
}

/* End of file equipamento_model.php */
/* Location: ./application/models/equipamento_model.php */