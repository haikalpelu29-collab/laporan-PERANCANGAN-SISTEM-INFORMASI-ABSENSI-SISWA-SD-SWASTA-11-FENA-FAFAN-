<?php
class Notifikasi_model extends CI_Model
{
    public function getNotifikasiBelumDibaca()
    {
        return $this->db->get_where('notifikasi_alpha', ['sudah_dibaca' => 0])->result_array();
    }

    public function tandaiSemuaSudahDibaca()
    {
        $this->db->set('sudah_dibaca', 1);
        $this->db->where('sudah_dibaca', 0);
        return $this->db->update('notifikasi_alpha');
    }

    public function simpanNotifikasiAlpha($siswa_id, $jumlah_alpha, $tahun_ajaran, $semester)
    {
        // Cek apakah sudah ada notifikasi untuk siswa tersebut
        $this->db->where([
            'siswa_id' => $siswa_id,
            'tahun_ajaran' => $tahun_ajaran,
            'semester' => $semester,
        ]);
        $cek = $this->db->get('notifikasi_alpha')->row();

        if (!$cek) {
            $this->db->insert('notifikasi_alpha', [
                'siswa_id' => $siswa_id,
                'jumlah_alpha' => $jumlah_alpha,
                'tahun_ajaran' => $tahun_ajaran,
                'semester' => $semester
            ]);
        }
    }
}
