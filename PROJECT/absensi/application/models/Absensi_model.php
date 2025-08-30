<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Absensi_model extends CI_Model {

	public function get_absensi_grouped()
	{
		$this->db->select('
			absensi.id_absensi,
			absensi.id_user,
			siswa.nama as nama_siswa,
			siswa.kelas,
			absensi.id_mapel,
			mapel.nama_mapel,
			absensi.tanggal,
			absensi.status,
			absensi.keterangan,
			absensi.file_surat, -- tambahkan ini
			YEAR(absensi.tanggal) as tahun,
			MONTH(absensi.tanggal) as bulan,
			absensi.tanggal as tanggal
		');

		$this->db->from('absensi');
		$this->db->join('siswa', 'siswa.id = absensi.id_user');
		$this->db->join('mapel', 'mapel.id_mapel = absensi.id_mapel');
		$this->db->order_by('absensi.tanggal', 'ASC');

		return $this->db->get()->result();
	}


	public function get_absensi_by_mapel($id_mapel)
	{
		$this->db->select('
			absensi.id_absensi,
			absensi.id_user,
			siswa.nama as nama_siswa,
			siswa.kelas,
			absensi.id_mapel,
			mapel.nama_mapel,
			absensi.tanggal,
			absensi.status,
			absensi.keterangan,
			absensi.file_surat, -- tambahkan ini
			YEAR(absensi.tanggal) as tahun,
			MONTH(absensi.tanggal) as bulan,
			absensi.tanggal as tanggal
		');

		$this->db->from('absensi');
		$this->db->join('siswa', 'siswa.id = absensi.id_user');
		$this->db->join('mapel', 'mapel.id_mapel = absensi.id_mapel');
		$this->db->where('absensi.id_mapel', $id_mapel);
		$this->db->order_by('absensi.tanggal', 'ASC');

		return $this->db->get()->result();
	}

	public function get_absensi_by_mapel_and_date($id_mapel, $tanggal)
	{
		$this->db->select('
			absensi.id_absensi,
			absensi.id_user,
			siswa.nama as nama_siswa,
			siswa.kelas,
			absensi.id_mapel,
			mapel.nama_mapel,
			absensi.tanggal,
			absensi.status,
			absensi.keterangan,
			absensi.file_surat,
			YEAR(absensi.tanggal) as tahun,
			MONTH(absensi.tanggal) as bulan,
			absensi.tanggal as tanggal
		');

		$this->db->from('absensi');
		$this->db->join('siswa', 'siswa.id = absensi.id_user');
		$this->db->join('mapel', 'mapel.id_mapel = absensi.id_mapel');
		$this->db->where('absensi.id_mapel', $id_mapel);
		$this->db->where('absensi.tanggal', $tanggal);
		$this->db->order_by('absensi.tanggal', 'ASC');

		return $this->db->get()->result();
	}

	public function getPersentaseKehadiranPerMapel($bulan, $kelas, $mapel = null, $tahun_ajaran = null, $semester = null, $limit = null, $start = null)
	{
		$this->db->select('siswa.nama AS nama_siswa, siswa.kelas, mapel.nama_mapel');
		$this->db->select('SUM(CASE WHEN absensi.status = "Hadir" THEN 1 ELSE 0 END) as hadir');
		$this->db->select('SUM(CASE WHEN absensi.status = "Izin" THEN 1 ELSE 0 END) as izin');
		$this->db->select('SUM(CASE WHEN absensi.status = "Sakit" THEN 1 ELSE 0 END) as sakit');
		$this->db->select('SUM(CASE WHEN absensi.status = "Alpha" THEN 1 ELSE 0 END) as alpha');
		$this->db->select('COUNT(absensi.id_absensi) as total');
		$this->db->from('absensi');
		$this->db->join('siswa', 'siswa.id = absensi.id_user');
		$this->db->join('mapel', 'mapel.id_mapel = absensi.id_mapel');

		if ($bulan) {
			$this->db->where('MONTH(absensi.tanggal)', $bulan);
		}

		if ($kelas) {
			$this->db->where('siswa.kelas', $kelas);
		}

		if ($mapel) {
			$this->db->where('absensi.id_mapel', $mapel);
		}

		// ✅ Filter Tahun Ajaran dan Semester
		if ($tahun_ajaran && $semester) {
			$tahun = explode('/', $tahun_ajaran)[0];
			if ($semester == '1') {
				$this->db->where('absensi.tanggal >=', $tahun . '-01-01');
				$this->db->where('absensi.tanggal <=', $tahun . '-06-30');
			} elseif ($semester == '2') {
				$this->db->where('absensi.tanggal >=', $tahun . '-07-01');
				$this->db->where('absensi.tanggal <=', $tahun . '-12-31');
			}
		}

		$this->db->group_by(['siswa.id', 'mapel.id_mapel']);
		$this->db->order_by('siswa.nama', 'ASC');

		if ($limit !== null) {
			$this->db->limit($limit, $start);
		}

		return $this->db->get()->result_array();
	}

	public function countFilteredPersentase($bulan, $kelas, $mapel = null, $tahun_ajaran = null, $semester = null)
	{
		$this->db->select('siswa.id');
		$this->db->from('absensi');
		$this->db->join('siswa', 'siswa.id = absensi.id_user');
		$this->db->join('mapel', 'mapel.id_mapel = absensi.id_mapel');

		if ($bulan) {
			$this->db->where('MONTH(absensi.tanggal)', $bulan);
		}

		if ($kelas) {
			$this->db->where('siswa.kelas', $kelas);
		}

		if ($mapel) {
			$this->db->where('absensi.id_mapel', $mapel);
		}

		// ✅ Filter Tahun Ajaran dan Semester
		if ($tahun_ajaran && $semester) {
			$tahun = explode('/', $tahun_ajaran)[0];
			if ($semester == '1') {
				$this->db->where('absensi.tanggal >=', $tahun . '-01-01');
				$this->db->where('absensi.tanggal <=', $tahun . '-06-30');
			} elseif ($semester == '2') {
				$this->db->where('absensi.tanggal >=', $tahun . '-07-01');
				$this->db->where('absensi.tanggal <=', $tahun . '-12-31');
			}
		}

		$this->db->group_by(['siswa.id', 'mapel.id_mapel']);
		return $this->db->get()->num_rows();
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

	public function getPresentaseByMapel($siswa_id, $start_date = null, $end_date = null)
	{
		$this->db->select('mapel.id_mapel, mapel.nama_mapel');
		$mapelList = $this->db->get('mapel')->result_array();

		$result = [];

		foreach ($mapelList as $mapel) {
			$id_mapel = $mapel['id_mapel'];

			// Total
			$this->db->from('absensi');
			$this->db->where('id_user', $siswa_id);
			$this->db->where('id_mapel', $id_mapel);
			if ($start_date && $end_date) {
				$this->db->where('tanggal >=', $start_date);
				$this->db->where('tanggal <=', $end_date);
			}
			$total = $this->db->count_all_results();

			// Hadir
			$this->db->from('absensi');
			$this->db->where('id_user', $siswa_id);
			$this->db->where('id_mapel', $id_mapel);
			$this->db->where('status', 'Hadir');
			if ($start_date && $end_date) {
				$this->db->where('tanggal >=', $start_date);
				$this->db->where('tanggal <=', $end_date);
			}
			$hadir = $this->db->count_all_results();

			// Izin
			$this->db->from('absensi');
			$this->db->where('id_user', $siswa_id);
			$this->db->where('id_mapel', $id_mapel);
			$this->db->where('status', 'Izin');
			if ($start_date && $end_date) {
				$this->db->where('tanggal >=', $start_date);
				$this->db->where('tanggal <=', $end_date);
			}
			$izin = $this->db->count_all_results();

			// Sakit
			$this->db->from('absensi');
			$this->db->where('id_user', $siswa_id);
			$this->db->where('id_mapel', $id_mapel);
			$this->db->where('status', 'Sakit');
			if ($start_date && $end_date) {
				$this->db->where('tanggal >=', $start_date);
				$this->db->where('tanggal <=', $end_date);
			}
			$sakit = $this->db->count_all_results();

			// Alpha
			$this->db->from('absensi');
			$this->db->where('id_user', $siswa_id);
			$this->db->where('id_mapel', $id_mapel);
			$this->db->where('status', 'Alpha');
			if ($start_date && $end_date) {
				$this->db->where('tanggal >=', $start_date);
				$this->db->where('tanggal <=', $end_date);
			}
			$alpha = $this->db->count_all_results();

			$presentase = $total > 0 ? round(($hadir / $total) * 100, 2) : 0;

			$result[] = [
				'id_mapel' => $mapel['id_mapel'],
				'mapel' => $mapel['nama_mapel'],
				'hadir' => $hadir,
				'izin' => $izin,
				'sakit' => $sakit,
				'alpha' => $alpha,
				'total' => $total,
				'presentase' => $presentase
			];
		}

		return $result;
	}

	public function get_siswa_by_id($siswa_id)
    {
        return $this->db->get_where('siswa', ['id' => $siswa_id])->row_array();
    }

    // Ambil data kehadiran berdasarkan filter
	public function get_kehadiran($siswa_id, $tahun_ajaran, $semester)
	{
		$this->db->select('absensi.id_mapel, mapel.nama_mapel AS mapel');
		$this->db->select('SUM(CASE WHEN absensi.status = "Hadir" THEN 1 ELSE 0 END) as hadir');
		$this->db->select('SUM(CASE WHEN absensi.status = "Izin" THEN 1 ELSE 0 END) as izin');
		$this->db->select('SUM(CASE WHEN absensi.status = "Sakit" THEN 1 ELSE 0 END) as sakit');
		$this->db->select('SUM(CASE WHEN absensi.status = "Alpha" THEN 1 ELSE 0 END) as alpha');
		$this->db->select('COUNT(absensi.id_absensi) as total');
		$this->db->from('absensi');
		$this->db->join('mapel', 'mapel.id_mapel = absensi.id_mapel');
		$this->db->where('absensi.id_user', $siswa_id);

		// Filter berdasarkan Tahun Ajaran dan Semester
		if ($tahun_ajaran && $semester) {
			$tahun = explode('/', $tahun_ajaran)[0];
			if ($semester == '1') {
				$this->db->where('absensi.tanggal >=', $tahun . '-01-01');
				$this->db->where('absensi.tanggal <=', $tahun . '-06-30');
			} elseif ($semester == '2') {
				$this->db->where('absensi.tanggal >=', $tahun . '-07-01');
				$this->db->where('absensi.tanggal <=', $tahun . '-12-31');
			}
		}

		$this->db->group_by('absensi.id_mapel');
		return $this->db->get()->result_array();
	}

	public function get_detail_kehadiran_mapel($siswa_id, $mapel_id, $tahun_ajaran, $semester, $bulan = null, $limit = null, $offset = null)
	{
		$this->db->from('absensi');
		$this->db->where('id_user', $siswa_id);
		$this->db->where('id_mapel', $mapel_id);

		if ($tahun_ajaran && $semester) {
			$tahun = explode('/', $tahun_ajaran)[0];
			if ($semester == '1') {
				$this->db->where('tanggal >=', $tahun . '-01-01');
				$this->db->where('tanggal <=', $tahun . '-06-30');
			} else {
				$this->db->where('tanggal >=', $tahun . '-07-01');
				$this->db->where('tanggal <=', $tahun . '-12-31');
			}
		}

		if ($bulan) {
			$this->db->where('MONTH(tanggal)', $bulan);
		}

		if ($limit) {
			$this->db->limit($limit, $offset);
		}

		return $this->db->get()->result_array();
	}


	public function count_filtered_kehadiran($siswa_id, $mapel_id, $tahun_ajaran, $semester, $bulan = null)
	{
		$this->db->from('absensi');
		$this->db->where('id_user', $siswa_id);
		$this->db->where('id_mapel', $mapel_id);

		if ($tahun_ajaran && $semester) {
			$tahun = explode('/', $tahun_ajaran)[0];
			if ($semester == '1') {
				$this->db->where('tanggal >=', $tahun . '-01-01');
				$this->db->where('tanggal <=', $tahun . '-06-30');
			} else {
				$this->db->where('tanggal >=', $tahun . '-07-01');
				$this->db->where('tanggal <=', $tahun . '-12-31');
			}
		}

		if ($bulan) {
			$this->db->where('MONTH(tanggal)', $bulan);
		}

		return $this->db->count_all_results();
	}

	public function get_siswa_alpha($start_date = null, $end_date = null, $limit = null, $start = null)
	{
		$this->db->select('
			absensi.id_user,
			absensi.id_mapel,
			siswa.nama,
			siswa.kelas,
			mapel.nama_mapel,
			COUNT(absensi.status) as jumlah_alpha
		');
		$this->db->from('absensi');
		$this->db->join('siswa', 'absensi.id_user = siswa.id');
		$this->db->join('mapel', 'absensi.id_mapel = mapel.id_mapel');
		$this->db->where('absensi.status', 'Alpha');

		if ($start_date && $end_date) {
			$this->db->where('absensi.tanggal >=', $start_date);
			$this->db->where('absensi.tanggal <=', $end_date);
		}

		$this->db->group_by(['absensi.id_user', 'absensi.id_mapel']);
		$this->db->having('jumlah_alpha >', 3);

		if ($limit !== null && $start !== null) {
			$this->db->limit($limit, $start);
		}

		$result = $this->db->get()->result_array();

		// Tambahkan tanggal-tanggal alpha ke setiap siswa
		foreach ($result as &$row) {
			$this->db->select('tanggal');
			$this->db->from('absensi');
			$this->db->where('id_user', $row['id_user']);
			$this->db->where('id_mapel', $row['id_mapel']);
			$this->db->where('status', 'Alpha');

			if ($start_date && $end_date) {
				$this->db->where('tanggal >=', $start_date);
				$this->db->where('tanggal <=', $end_date);
			}

			$tanggal_result = $this->db->get()->result_array();
			$tanggal_array = array_column($tanggal_result, 'tanggal');

			// Format tanggal
			$formatted = array_map(function($tgl) {
				return date('d M Y', strtotime($tgl));
			}, $tanggal_array);

			$row['tanggal_alpha'] = implode('<br>', $formatted);
		}

		return $result;
	}

	public function count_siswa_alpha($start_date = null, $end_date = null)
	{
		$this->db->select('absensi.id_user, absensi.id_mapel');
		$this->db->from('absensi');
		$this->db->where('absensi.status', 'Alpha');

		if ($start_date && $end_date) {
			$this->db->where('absensi.tanggal >=', $start_date);
			$this->db->where('absensi.tanggal <=', $end_date);
		}

		$this->db->group_by(['absensi.id_user', 'absensi.id_mapel']);
		$this->db->having('COUNT(absensi.status) >', 3);

		return $this->db->get()->num_rows();
	}
	
}
