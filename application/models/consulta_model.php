
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
    $input = $this->db->escape_like_str($input);
		$rs = $this->db->query
		("
			SELECT pessoa.id_pessoa as 'id', pessoa.nome_pes as 'name', 'p' as type, pessoa.email_pes as 'info1', pessoa.lattes_pes as 'info2', pessoa.website_pes as 'info3'
			FROM pessoa
			WHERE pessoa.nome_pes LIKE '%".$input."%'

			UNION

			SELECT laboratorio.id_laboratorio as 'id', laboratorio.nome_lab as 'name', 'l' as type, laboratorio.descricao_lab as 'info1', laboratorio.atividades_lab as 'info2', laboratorio.sigla as 'info3'
			FROM laboratorio
      LEFT JOIN laboratorio_has_curso ON fk_id_laboratorio = laboratorio.id_laboratorio
      LEFT JOIN curso ON fk_id_curso = id_curso
			WHERE laboratorio.nome_lab LIKE '%".$input."%'
			OR laboratorio.palavras_chave LIKE '%".$input."%'
      OR nome_cur LIKE '%".$input."%'
			OR laboratorio.sigla LIKE '%".$input."%'

			UNION

			SELECT equipamento.id_equipamento as 'id', equipamento.nome_eqp as 'name', 'e' as type, equipamento.descricao_eqp as 'info1', equipamento.especificacao_eqp as 'info2', equipamento.fabricante_eqp as 'info3'
			FROM equipamento
			WHERE equipamento.nome_eqp LIKE '%".$input."%'
		");
		return $rs->result();
	}

	public function buscaTodos()
	{

		$rs = $this->db->query
		("
			SELECT pessoa.id_pessoa as 'id', pessoa.nome_pes as 'name', 'p' as type, pessoa.email_pes as 'info1', pessoa.lattes_pes as 'info2', pessoa.website_pes as 'info3'
			FROM pessoa

			UNION

			SELECT laboratorio.id_laboratorio as 'id', laboratorio.nome_lab as 'name', 'l' as type, laboratorio.descricao_lab as 'info1', laboratorio.atividades_lab as 'info2', laboratorio.sigla as 'info3'
			FROM laboratorio
      LEFT JOIN laboratorio_has_curso ON fk_id_laboratorio = laboratorio.id_laboratorio
      LEFT JOIN curso ON fk_id_curso = id_curso


			UNION

			SELECT equipamento.id_equipamento as 'id', equipamento.nome_eqp as 'name', 'e' as type, equipamento.descricao_eqp as 'info1', equipamento.especificacao_eqp as 'info2', equipamento.fabricante_eqp as 'info3'
			FROM equipamento

		");
		return $rs->result();
	}

}
