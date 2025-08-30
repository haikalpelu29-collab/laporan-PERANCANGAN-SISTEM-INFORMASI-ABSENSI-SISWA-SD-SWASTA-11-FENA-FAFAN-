<?php
class Siswa_model extends CI_Model {

    public function get_all_siswa() {
        return $this->db->get_where('siswa', ['is_active' => 1])->result_array();
    }

    public function get_siswa_by_kelas($kelas) {
        return $this->db->get_where('siswa', ['kelas' => $kelas, 'is_active' => 1])->result_array();
    }

    public function insert_siswa($data) {
        return $this->db->insert('siswa', $data);
    }

    public function get_siswa($id) {
        return $this->db->get_where('siswa', ['id' => $id])->row_array();
    }

    public function update_siswa($id, $data) {
        return $this->db->where('id', $id)->update('siswa', $data);
    }

    public function nonaktifkan_siswa($id) {
        return $this->db->where('id', $id)->update('siswa', ['is_active' => 0]);
    }

	public function countAllSiswa($keyword = null)
    {
        if ($keyword) {
            $this->db->like('nama', $keyword);
            $this->db->or_like('nis', $keyword);
            $this->db->or_like('kelas', $keyword);
        }
        return $this->db->get('siswa')->num_rows();
    }

    public function getSiswa($limit, $start, $keyword = null)
    {
        if ($keyword) {
            $this->db->like('nama', $keyword);
            $this->db->or_like('nis', $keyword);
            $this->db->or_like('kelas', $keyword);
        }
        return $this->db->get('siswa', $limit, $start)->result_array();
    }

	public function getSiswaById($id)
	{
		return $this->db->get_where('siswa', ['id' => $id])->row_array();
	}

}
