<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Estatisticas_model extends CI_Model
{
    public function estatisticas_curso()
    {
        $this->db->select('count(*) as num_labs, cur.nome_cur as nome_curso');
        $this->db->from('laboratorio_has_curso as lhc');
        $this->db->join('laboratorio as lab', 'lab.id_laboratorio = lhc.fk_id_laboratorio', 'left');
        $this->db->join('curso as cur', 'cur.id_curso = lhc.fk_id_curso', 'left');
        $this->db->group_by('lhc.fk_id_curso');
        // $this->db->order_by('count(*)', 'desc');
        $this->db->order_by('count(*)', 'asc');
        return $this->db->get()->result();
    }

    public function estatisticas_departamento()
    {
        $this->db->select('count(*) as num_labs, dpt.nome_dpt as nome_departamento');
        $this->db->from('laboratorio_has_departamento as lhd');
        $this->db->join('laboratorio as lab', 'lab.id_laboratorio = lhd.fk_id_laboratorio', 'left');
        $this->db->join('departamento as dpt', 'dpt.id_departamento = lhd.fk_id_departamento', 'left');
        $this->db->group_by('lhd.fk_id_departamento');
        // $this->db->order_by('count(*)', 'desc');
        $this->db->order_by('count(*)', 'asc');
        return $this->db->get()->result();
    }
}

/* End of file estatisticas_model.php */
/* Location: ./application/models/estatisticas_model.php */
