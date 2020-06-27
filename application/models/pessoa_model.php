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


    /*
     -------------- Importado do model :crud_model
    //  Tentando colocar tudo de cada controller em seu devido model..
    //  Exemplo tudo relacionado a pessoa , irei colocar em pessoa.
    //  Para excluir o crud_model mais a frente
     */
    public function get_allPessoa($value='')
    {
        $this->db->select('*');
        $this->db->from('pessoa');
        $retorno = $this->db->get();
        return $retorno->result();
    }

  public function get_pessoa($email)
  {
      $this->db->select('*');
      $this->db->from('pessoa');
      $this->db->where('email_pes',$email);
      return $this->db->get()->result_array();
  }

  public function getAllTipo_pessoa()
	{
		$this->db->order_by('tipo_tip', "asc");
		return $this->db->get('tipo_pessoa');
	}

  public function getForCoordinatorTipo_pessoa()
	{
    $this->db->order_by('tipo_tip', "asc");
    $this->db->where('id_tipo_pessoa !=', 2);
    $this->db->where('id_tipo_pessoa !=', 4);
    return $this->db->get('tipo_pessoa');
	}

	public function getPessoaWithoutUser()
	{
		$this->db->select('id_pessoa, nome_pes, email_pes');
		$this->db->from('pessoa');
		$this->db->where('fk_id_usuario is NULL');
		$this->db->where('ativo_pes', 1);
		$this->db->order_by('nome_pes', "asc");
		return $this->db->get();
	}

    public function getAllCoordenadores()
	{
		$this->db->select('id_pessoa, nome_pes, email_pes, lattes_pes');
		$this->db->from('pessoa');
		$this->db->join('usuario', 'pessoa.fk_id_usuario = usuario.id_usuario', 'left');
		$this->db->where('pessoa.ativo_pes', 1);
		$this->db->order_by('nome_pes', 'asc');
		return $this->db->get();
	}

	public function getUsername($id)
	{
		$this->db->select('nome_pes');
		$this->db->from('pessoa');
		$this->db->where('fk_id_usuario = '.$id);
		return $this->db->get();
	}

    public function insertPessoa($dados=NULL)
	{
		if ($dados!=NULL):
			$this->db->insert('pessoa', $dados);
		endif;
    }
    # Retrieve ---------------------------------------------------------------------------------

    public function getBasicInfoPessoa()
	{
		$this->db->select('pes.id_pessoa, pes.nome_pes');
		$this->db->from('pessoa as pes');
		$this->db->where('ativo_pes', 1);
		$this->db->where('fk_id_tipo_pessoa >', 1);
		$this->db->order_by('pes.nome_pes', "asc");
		return $this->db->get();
	}

	public function selectPessoa()
	{
		$this->db->select('pes.id_pessoa, pes.nome_pes, pes.email_pes, pes.ramal_pes, pes.lattes_pes, pes.website_pes, pes.status_pes, tip.tipo_tip, dep.nome_dpt');
		$this->db->from('pessoa as pes');
		$this->db->join('tipo_pessoa as tip', 'pes.fk_id_tipo_pessoa = tip.id_tipo_pessoa', 'inner');
		$this->db->join('departamento as dep', 'pes.fk_id_departamento = dep.id_departamento', 'inner');
		$this->db->where('ativo_pes', 1);
		$this->db->order_by('pes.id_pessoa', "asc");
		return $this->db->get();
	}

	public function selectPessoaByID($id=NULL)
	{
		if($id!=NULL):
			$this->db->select('pes.nome_pes, pes.email_pes, pes.ramal_pes, pes.lattes_pes,
							   pes.website_pes, pes.fk_id_departamento, pes.fk_id_tipo_pessoa, tip.tipo_tip, dep.nome_dpt');
			$this->db->join('tipo_pessoa as tip', 'pes.fk_id_tipo_pessoa = tip.id_tipo_pessoa', 'inner');
			$this->db->join('departamento as dep', 'pes.fk_id_departamento = dep.id_departamento', 'inner');
			$this->db->from('pessoa as pes');
			$this->db->where('pes.id_pessoa', $id);
			$this->db->where('pes.ativo_pes', 1);
			return $this->db->get();
		else:
			die ('Erro ao tentar recuperar dados! :(');
		endif;
    }
    # Update -----------------------------------------------------------------------------------

	public function updateUsuario($id_usuario, $dados)
	{
		$this->db->where('id_usuario', $id_usuario);
		$this->db->update('usuario', $dados);
	}

	public function updatePessoa($id, $dados)
	{
		$this->db->where('id_pessoa', $id);
		$this->db->update('pessoa', $dados);
	}

	# Delete -----------------------------------------------------------------------------------
	//Na verdade é um update de status
	public function deletePessoa($id, $dados)
	{
		$this->db->where('id_pessoa', $id);
		$this->db->update('pessoa', $dados);
	}


    //Importado de consulta_generica_model
    //verificar quem chama e direcionar para pessoa
    public function consulta_pessoa_by_id($id_pessoa)
    {
        // $this->db->select('pes.id_pessoa, pes.nome_pes, pes.email_pes, tip.tipo_tip');
        $this->db->select('*');
        $this->db->from('pessoa as pes');
        $this->db->join('usuario as usu', 'pes.fk_id_usuario = usu.id_usuario', 'left');
        $this->db->join('tipo_pessoa as tip', 'pes.fk_id_tipo_pessoa = tip.id_tipo_pessoa', 'left');
        $this->db->join('departamento as dpt', 'pes.fk_id_departamento = dpt.id_departamento', 'left');
        $this->db->where('pes.ativo_pes', 1);
        $this->db->where('pes.id_pessoa', $id_pessoa);
        return $this->db->get()->result();
    }

    public function listar_pessoas()
    {

        $this->db->select('pes.id_pessoa, pes.nome_pes, pes.email_pes, tip.tipo_tip');
        $this->db->from('pessoa as pes');
        $this->db->join('tipo_pessoa as tip', 'pes.fk_id_tipo_pessoa = tip.id_tipo_pessoa', 'inner');
        $this->db->where('ativo_pes', 1);
        $this->db->order_by('pes.nome_pes', "asc");
        return $this->db->get()->result();
    }


}

/* End of file pessoa_model.php */
/* Location: ./application/models/pessoa_model.php */
