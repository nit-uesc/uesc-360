<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Acesso_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('funcoes');
	}

	public function isValidLogin($username, $password)
	{
		$user = $this->funcoes->antiInjection($username);
		$pass = $this->funcoes->antiInjection($password);

		$this->db->select('usuario.id_usuario, usuario.login_usu, usuario.ativo_usu, usuario_has_permissao.fk_id_permissao, pessoa.id_pessoa, pessoa.nome_pes');
		$this->db->from('usuario');
		$this->db->join('pessoa', 'pessoa.fk_id_usuario = usuario.id_usuario', 'left');
		$this->db->join('usuario_has_permissao', 'usuario_has_permissao.fk_id_usuario = usuario.id_usuario', 'left');
		$this->db->where('usuario.login_usu', $username);
		$this->db->where('usuario.senha_usu', $password);
		$this->db->where('usuario.ativo_usu', 1);
		$this->db->order_by('usuario_has_permissao.fk_id_permissao', 'ASC');
		$this->db->limit(1);
		return $this->db->get()->result();
	}

	public function getPessoaID($userID)
	{
		$this->db->select('id_pessoa');
		$this->db->from('pessoa');
		$this->db->where('fk_id_usuario = '.$userID);
		return $this->db->get();
	}

	public function getUserPassword($userid=NULL)
	{
		if ($userid!=NULL):
			$this->db->select('senha_usu');
			$this->db->from('usuario');
			$this->db->where('id_usuario = '.$userid);
			return $this->db->get()->row();
		else:
			die('Erro ao tentar recuperar E.M.A de USUÁRIO! :(');
		endif;
	}

	public function accessLog($userID=NULL)
	{
		if($userID!=NULL):
			$log['id_usuario'] = $userID;
			$log['ip_usuario'] = $this->input->ip_address();
			$this->db->insert('access_log', $log);
		endif;
	}


}