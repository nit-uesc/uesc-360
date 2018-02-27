<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario_model extends CI_Model
{

  /*Insere a permissão do usuario*/
	public function insertPermissao($dados=NULL)
	{
		if ($dados!=NULL):
			$this->db->insert('usuario_has_permissao', $dados);
		endif;
	}

	public function updateUsuario($id_usuario, $dados)
	{
		$this->db->where('id_usuario', $id_usuario);
		$this->db->update('usuario', $dados);
	}
	//Realiza a inserção no banco de dados
	public function insertUsuario($dados=NULL)
	{
		if ($dados!=NULL):
			$this->db->insert('usuario', $dados);
		endif;
	}

	public function get_info_pessoa($ID=NULL)
	{
		if($ID != NULL):
			$this->db->select('*');
			$this->db->from('pessoa');
			$this->db->where('id_pessoa', $ID);
			$this->db->join('tipo_pessoa', 'pessoa.fk_id_tipo_pessoa = tipo_pessoa.id_tipo_pessoa');
			$this->db->join('departamento', 'pessoa.fk_id_departamento = departamento.id_departamento');
			return $this->db->get()->result();
		endif;
	}

	public function get_meus_laboratorios()
	{
		$this->db->select('id_laboratorio, nome_lab');
		$this->db->from('laboratorio_has_pessoa');
		$this->db->join('laboratorio', 'laboratorio_has_pessoa.fk_id_laboratorio = laboratorio.id_laboratorio', 'left');
		$this->db->where('fk_id_pessoa', $this->session->userdata('id_pessoa'));
		$rs = $this->db->get();

		if($rs->num_rows() > 0):
			return $rs->result();
		else:
			return false;
		endif;
	}

	public function senha_valida($id_usuario=NULL, $senha=NULL)
	{
		if($id_usuario!=NULL && $senha!=NULL):
			$this->db->select('*');
			$this->db->from('usuario');
			$this->db->where('id_usuario', $id_usuario);
			$this->db->where('senha_usu', $senha);
			$rs = $this->db->get();

			if($rs->num_rows() == 1):
				return true;
			else:
				return false;
			endif;
		else:
			return false;
		endif;
	}

	public function change_password($id_usuario=NULL, $senha=NULL)
	{
		if($id_usuario!=NULL && $senha!=NULL):
			$data = array('senha_usu' => $senha);

			$this->db->where('id_usuario', $id_usuario);
			$this->db->update('usuario', $data);
		endif;
	}

	// -------------------------------------------------------------------------------------------------------------------------------------------------------
	// Funções que relacionam as pessoas aos laboratórios ----------------------------------------------------------------------------------------------------
	// -------------------------------------------------------------------------------------------------------------------------------------------------------

	public function is_coordenador($pesID=NULL, $labID=NULL)
	{
		if($pesID!=NULL && $labID!=NULL):

			$this->db->select('*');
			$this->db->from('laboratorio_has_pessoa');
			$this->db->where('fk_id_pessoa', $pesID);
			$this->db->where('fk_id_laboratorio', $labID);
			$this->db->where('permissao_lhp', 2);
			$rs = $this->db->get();

			if($rs->num_rows() == 1):
				return true;
			else:
				return false;
			endif;
		endif;
	}

	public function ja_participa($pesID=NULL, $labID=NULL)
	{
		if($pesID!=NULL && $labID!=NULL):

			$this->db->select('*');
			$this->db->from('laboratorio_has_pessoa');
			$this->db->where('fk_id_pessoa', $pesID);
			$this->db->where('fk_id_laboratorio', $labID);
			$this->db->where('permissao_lhp', 3);
			// $this->db->or_where('permissao_lhp', 4);
			// $this->db->or_where('id >', $id);
			$rs = $this->db->get();

			if($rs->num_rows() == 1):
				return true;
			else:
				return false;
			endif;
		endif;
	}

	public function em_espera($pesID=NULL, $labID=NULL)
	{
		if($pesID!=NULL && $labID!=NULL):

			$this->db->select('*');
			$this->db->from('laboratorio_has_pessoa');
			$this->db->where('fk_id_pessoa', $pesID);
			$this->db->where('fk_id_laboratorio', $labID);
			$this->db->where('permissao_lhp', 4);
			$rs = $this->db->get();

			if($rs->num_rows() == 1):
				return true;
			else:
				return false;
			endif;
		endif;
	}

	public function remove_participante($labID=NULL, $pesID=NULL)
	{
		if($pesID!=NULL && $labID!=NULL):
			$this->db->where('fk_id_pessoa', $pesID);
			$this->db->where('fk_id_laboratorio', $labID);
			$this->db->delete('laboratorio_has_pessoa');
			return true;
		endif;
		return false;
	}

	public function add_participante($data=NULL)
	{
		if($data != NULL):
			$this->db->insert('laboratorio_has_pessoa', $data);
			return true;
		endif;
		return false;
	}

	// labs de participantes
	public function get_all_participantes_laboratorios($id=NULL)
	{
		if($id!=NULL):
			$this->db->select('lab.id_laboratorio, lab.nome_lab');
			$this->db->from('laboratorio_has_pessoa as lhp');
			$this->db->join('laboratorio as lab', 'lab.id_laboratorio = lhp.fk_id_laboratorio', 'inner');
			$this->db->where('lab.ativo_lab', 1);
			$this->db->where('lhp.fk_id_pessoa', $id);
			$this->db->where('lhp.permissao_lhp', 3);
			return $this->db->get();
		else:
			die('Erro! Não foi possível listar os laboratórios. :(');
		endif;
	}

	// labs de participantes de coordenadores
	public function get_all_coordenadores_laboratorios($id=NULL)
	{
		if($id!=NULL):
			$this->db->select('lab.id_laboratorio, lab.nome_lab');
			$this->db->from('laboratorio_has_pessoa as lhp');
			$this->db->join('laboratorio as lab', 'lab.id_laboratorio = lhp.fk_id_laboratorio', 'inner');
			$this->db->where('lab.ativo_lab', 1);
			$this->db->where('lhp.fk_id_pessoa', $id);
			$this->db->where('lhp.permissao_lhp', 2);
			return $this->db->get();
		else:
			die('Erro! Não foi possível listar os laboratórios. :(');
		endif;
	}

	// participantes de labs
	public function get_all_participantes($labID=NULL)
	{
		if($labID!=NULL):
			$this->db->select('*');
			$this->db->from('laboratorio_has_pessoa');
			$this->db->where('fk_id_laboratorio', $labID);
			$this->db->where('permissao_lhp', 3);
			$this->db->join('pessoa', 'pessoa.id_pessoa = laboratorio_has_pessoa.fk_id_pessoa', 'left');
			return $this->db->get()->result();
		endif;
	}

	public function get_all_possiveis_participantes($id_laboratorio=NULL)
	{
		if($id_laboratorio!=NULL):

            $rs = $this->db->query(
                "select *
                from pessoa
                where pessoa.id_pessoa not in
                (
                    select fk_id_pessoa
                    from laboratorio_has_pessoa
                    where fk_id_laboratorio = ".$id_laboratorio."

                )
				order by nome_pes ASC
                "
            );
            return $rs->result();
		endif;

	}

	// -------------------------------------------------------------------------------------------------------------------------------------------------------
	//  Fim das Funções que relacionam as pessoas aos laboratórios --------------------------------------------------------------------------------------------
	// -------------------------------------------------------------------------------------------------------------------------------------------------------


}

/* End of file usuario_model.php */
/* Location: ./application/models/usuario_model.php */
