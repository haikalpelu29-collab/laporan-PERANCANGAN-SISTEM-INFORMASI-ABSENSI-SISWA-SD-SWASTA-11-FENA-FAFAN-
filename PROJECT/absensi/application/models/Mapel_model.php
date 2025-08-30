<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mapel_model extends CI_Model {

    public function getAllMapel()
    {
        return $this->db->get('mapel')->result_array();
    }

    public function insertMapel($nama_mapel)
    {
        $this->db->insert('mapel', ['nama_mapel' => $nama_mapel]);
    }

	public function getMapelById($id_mapel)
	{
		return $this->db->get_where('mapel', ['id_mapel' => $id_mapel])->row_array();
	}

	public function getRiwayatAbsensi()
	{
		$this->db->select('a.*, u.nama as nama_siswa, m.nama_mapel');
		$this->db->from('absensi a');
		$this->db->join('siswa u', 'a.id_user = u.id');
		$this->db->join('mapel m', 'a.id_mapel = m.id_mapel');
		$this->db->order_by('a.tanggal', 'ASC');
		return $this->db->get()->result_array();
	}

	public function getMapelByGuru($user_id)
	{
		$this->db->select('m.*');
		$this->db->from('mapel m');
		$this->db->join('user_access_mapel uam', 'm.id_mapel = uam.mapel_id');
		$this->db->where('uam.user_id', $user_id);
		return $this->db->get()->result_array();
	}

	public function getNamaMapelById($id) 
	{
		$result = $this->db->get_where('mapel', ['id_mapel' => $id])->row_array();
		return $result ? $result['nama_mapel'] : '-';
	}

}
