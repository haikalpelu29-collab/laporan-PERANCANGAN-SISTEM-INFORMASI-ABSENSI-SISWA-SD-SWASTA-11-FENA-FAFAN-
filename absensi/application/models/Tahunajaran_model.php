<?php
class Tahunajaran_model extends CI_Model
{
    public function getAll()
    {
        return $this->db->order_by('nama_tahun', 'DESC')->get('tahun_ajaran')->result_array();
    }

    public function getAktif()
    {
        return $this->db->get_where('tahun_ajaran', ['aktif' => 'Ya'])->row_array();
    }

}
