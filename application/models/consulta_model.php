<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Consulta_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('funcoes');
	}

	public function busca($input)
	{
		$rs = $this->db->query
		("
			SELECT pessoa.id_pessoa as 'id', pessoa.nome_pes as 'name', 'p' as type, pessoa.email_pes as 'info1', pessoa.lattes_pes as 'info2', pessoa.website_pes as 'info3'
			FROM pessoa
			WHERE pessoa.nome_pes LIKE '%".$this->db->escape_like_str($input)."%'

			UNION ALL

			SELECT laboratorio.id_laboratorio as 'id', laboratorio.nome_lab as 'name', 'l' as type, laboratorio.descricao_lab as 'info1', laboratorio.atividades_lab as 'info2', laboratorio.areas_atendidas_lab as 'info3'
			FROM laboratorio
			WHERE laboratorio.nome_lab LIKE '%".$this->db->escape_like_str($input)."%'
			OR laboratorio.palavras_chave LIKE '%".$this->db->escape_like_str($input)."%'

			UNION ALL

			SELECT equipamento.id_equipamento as 'id', equipamento.nome_eqp as 'name', 'e' as type, equipamento.descricao_eqp as 'info1', equipamento.especificacao_eqp as 'info2', equipamento.fabricante_eqp as 'info3'
			FROM equipamento
			WHERE equipamento.nome_eqp LIKE '%".$this->db->escape_like_str($input)."%'
		");
		return $rs->result();
	}

	// // Lucas Braz Melo
	// public function busca_all($busca){
	// 	$rs = $this->db->query("select * from (select * from ((select '3' as tipo, id_pessoa as id, nome_pes as um, email_pes as dois, lattes_pes as tres, website_pes as quatro from pessoa as tres) union (select '2' as tipo, id_equipamento as id, nome_eqp as um, descricao_eqp as dois, especificacao_eqp as tres, fabricante_eqp as quatro from equipamento as dois) union (select '1' as tipo, id_laboratorio as id, nome_lab as um, descricao_lab as dois, atividades_lab as tres, areas_atendidas_lab as quatro from laboratorio as um)) as b ) as a WHERE MATCH(a.um, a.dois, a.tres, a.quatro) AGAINST ('*".$busca."*' IN BOOLEAN MODE)");
	// 	return $rs;
	// }

	// public function busca_pessoa($busca)
	// {
	// 	$this->db->select('*');
	// 	$this->db->from('pessoa');
	// 	$this->db->where('ativo_pes' , 1);
	// 	$this->db->like('nome_pes', $busca);
	// 	return $this->db->get();
	// }

	// public function busca_laboratorio($busca)
	// {
	// 	$this->db->select('*');
	// 	$this->db->from('laboratorio');
	// 	$this->db->where('ativo_lab', 1);
	// 	$this->db->like('nome_lab', $busca);
	// 	return $this->db->get();
	// }

	// public function busca_equipamento($busca)
	// {
	// 	$this->db->select('*');
	// 	$this->db->from('equipamento');
	// 	$this->db->where('ativo_eqp', 1);
	// 	$this->db->like('nome_eqp', $busca);
	// 	return $this->db->get();
	// }

	// public function busca_departamento($busca)
	// {
	// 	$this->db->select('*');
	// 	$this->db->from('departamento');
	// 	$this->db->like('nome_dpt', $busca);
	// 	return $this->db->get();
	// }

}