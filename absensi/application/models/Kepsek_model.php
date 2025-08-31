<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Kepsek_model extends CI_Model
{
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
}
