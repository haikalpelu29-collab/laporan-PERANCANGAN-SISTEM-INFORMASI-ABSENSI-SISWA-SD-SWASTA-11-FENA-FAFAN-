<?php
defined('BASEPATH') or exit('No direct script access allowed');
#[\AllowDynamicProperties]
class Absensi extends CI_Controller
{
	public function laporan($id_mapel = null, $tanggal = null)
	{
		$data['title'] = 'Laporan Absensi';
		$data['user'] = $this->db->get_where('user', [
			'email' => $this->session->userdata('email')
		])->row_array();

		$this->load->model('Absensi_model');

		if ($id_mapel && $tanggal) {
			// Jika ada ID mapel dan tanggal
			$data['absensi'] = $this->Absensi_model->get_absensi_by_mapel_and_date($id_mapel, $tanggal);
			$data['mapel'] = $this->db->get_where('mapel', ['id_mapel' => $id_mapel])->row();
			$data['tanggal'] = $tanggal;
		} elseif ($id_mapel) {
			// Jika hanya mapel
			$data['absensi'] = $this->Absensi_model->get_absensi_by_mapel($id_mapel);
			$data['mapel'] = $this->db->get_where('mapel', ['id_mapel' => $id_mapel])->row();
			$data['tanggal'] = null;
		} else {
			// Semua data
			$data['absensi'] = $this->Absensi_model->get_absensi_grouped();
			$data['mapel'] = null;
			$data['tanggal'] = null;
		}

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('absensi/laporan_grouped', $data);
		$this->load->view('templates/footer');
	}

	public function kepsek($id_mapel = null)
	{
		$data['title'] = 'Laporan Absensi';
		$data['user'] = $this->db->get_where('user', [
			'email' => $this->session->userdata('email')
		])->row_array();

		$this->load->model('Absensi_model');

		if ($id_mapel) {
			// Jika ada ID mapel, filter data absensi berdasarkan mapel
			$data['absensi'] = $this->Absensi_model->get_absensi_by_mapel($id_mapel);
			$data['mapel'] = $this->db->get_where('mapel', ['id_mapel' => $id_mapel])->row(); // untuk nama mapel di judul
		} else {
			// Jika tidak ada ID mapel, tampilkan semua
			$data['absensi'] = $this->Absensi_model->get_absensi_grouped();
			$data['mapel'] = null;
		}

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('absensi/kepsek', $data);
		$this->load->view('templates/footer');
	}

	public function kehadiran()
	{
		$data['title'] = 'Persentase Kehadiran Siswa';
		$data['user'] = $this->db->get_where('user', [
			'email' => $this->session->userdata('email')
		])->row_array();

		// Ambil filter dari GET
		$bulan = $this->input->get('bulan');
		$kelas = $this->input->get('kelas');
		$mapel = $this->input->get('mapel');
		$tahun_ajaran = $this->input->get('tahun_ajaran'); // ✅ Tambahan
		$semester = $this->input->get('semester'); // ✅ Tambahan

		$this->load->library('pagination');
		$this->load->model('Absensi_model');
		$this->load->model('Tahunajaran_model'); // ✅ Tambahan

		// Konfigurasi Pagination
		$config['base_url'] = base_url('absensi/kehadiran');
		$config['total_rows'] = $this->Absensi_model->countFilteredPersentase($bulan, $kelas, $mapel, $tahun_ajaran, $semester); // ✅ Tambahan filter
		$config['per_page'] = 15;
		$config['reuse_query_string'] = true;
		$config['page_query_string'] = true;
		$config['query_string_segment'] = 'start';

		// Styling Bootstrap 4 (seperti sebelumnya)
		$config['full_tag_open'] = '<nav><ul class="pagination">';
		$config['full_tag_close'] = '</ul></nav>';
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['first_tag_open'] = '<li class="page-item"><span class="page-link">';
		$config['first_tag_close'] = '</span></li>';
		$config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
		$config['prev_tag_close'] = '</span></li>';
		$config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
		$config['next_tag_close'] = '</span></li>';
		$config['last_tag_open'] = '<li class="page-item"><span class="page-link">';
		$config['last_tag_close'] = '</span></li>';
		$config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
		$config['cur_tag_close'] = '</span></li>';
		$config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
		$config['num_tag_close'] = '</span></li>';

		$this->pagination->initialize($config);
		$start = $this->input->get('start') ? (int)$this->input->get('start') : 0;

		// Ambil data paginasi dengan filter
		$data['persentase_mapel'] = $this->Absensi_model->getPersentaseKehadiranPerMapel(
			$bulan, $kelas, $mapel, $tahun_ajaran, $semester, $config['per_page'], $start
		);
		$data['start'] = $start;

		// Untuk dropdown filter
		$data['kelasList'] = $this->db->distinct()->select('kelas')->get('siswa')->result_array();
		$data['mapelList'] = $this->db->get('mapel')->result_array();
		$data['tahun_ajaran_list'] = $this->Tahunajaran_model->getAll(); // ✅ Tambahan

		// Untuk simpan pilihan filter agar tetap selected di view
		$data['filter_bulan'] = $bulan;
		$data['filter_kelas'] = $kelas;
		$data['filter_mapel'] = $mapel;
		$data['filter_tahun_ajaran'] = $tahun_ajaran; // ✅
		$data['filter_semester'] = $semester; // ✅

		// Pagination Link
		$data['pagination'] = $this->pagination->create_links();

		// Load view
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('absensi/kehadiran', $data);
		$this->load->view('templates/footer');
	}

	public function export_pdf()
	{
		$bulan = $this->input->get('bulan');
		$kelas = $this->input->get('kelas');
		$mapel = $this->input->get('mapel');

		$this->load->model('Absensi_model');
		$data['persentase_mapel'] = $this->Absensi_model->getPersentaseKehadiranPerMapel($bulan, $kelas, $mapel);

		// Filter tambahan
		$data['tahun_ajaran'] = $this->input->get('tahun_ajaran') ?? 'Semua Tahun Ajaran';
		$data['semester']     = $this->input->get('semester') ?? 'Semua Semester';
		$data['kelas']        = $kelas ?? 'Semua Kelas';
		$data['mapel']        = $mapel ?? 'Semua Mapel';
		$data['bulan']        = $bulan ?? 'Semua Bulan';

		// Ambil view ke string HTML
		$html = $this->load->view('absensi/laporan_pdf', $data, true); // true = sebagai string

		// Load library PDF (Dompdf)
		$this->load->library('Pdf');
		$this->pdf->loadHtml($html);
		$this->pdf->setPaper('A4', 'landscape');
		$this->pdf->render();
		$this->pdf->stream('laporan_persentase_kehadiran.pdf', ['Attachment' => false]);
	}

	public function export_siswa()
	{
		$siswa_id = $this->input->get('siswa_id');
		$tahun_ajaran = $this->input->get('tahun_ajaran');
		$semester = $this->input->get('semester');

		// Ambil data dari model
		$this->load->model('Absensi_model');
		$data['siswa'] = $this->Absensi_model->get_siswa_by_id($siswa_id);
		$data['kehadiran'] = $this->Absensi_model->get_kehadiran($siswa_id, $tahun_ajaran, $semester);
		$data['tahun_ajaran_terpilih'] = $tahun_ajaran;
		$data['semester'] = $semester;
		$data['title'] = 'Laporan Kehadiran Siswa';

		// Load view ke string
		$html = $this->load->view('absensi/laporan_siswa', $data, true);

		// Panggil library PDF
		$this->load->library('pdf'); // pastikan sudah ada Pdf.php di libraries

		// Konversi ke PDF
		$this->pdf->loadHtml($html);
		$this->pdf->setPaper('A4', 'landscape'); // atau 'portrait'
		$this->pdf->render();

		// Tampilkan dengan tombol cetak/download
		$this->pdf->stream("laporan_kehadiran_siswa.pdf", array("Attachment" => false));
	}

	public function export_pdf_kehadiran()
	{
		$siswa_id      = $this->input->get('siswa_id');
		$mapel_id      = $this->input->get('mapel_id');
		$tahun_ajaran  = $this->input->get('tahun_ajaran');
		$semester      = $this->input->get('semester');
		$bulan         = $this->input->get('bulan');

		// Ambil data siswa
		$data['siswa'] = $this->db->get_where('siswa', ['id' => $siswa_id])->row_array();

		// Ambil nama mapel
		$mapel = $this->db->get_where('mapel', ['id_mapel' => $mapel_id])->row_array();
		$data['nama_mapel'] = $mapel['nama_mapel'];

		// Ambil kehadiran sesuai filter
		$this->db->where('id_user', $siswa_id);
		$this->db->where('id_mapel', $mapel_id);
		if ($tahun_ajaran) {
			$this->db->like('tanggal', substr($tahun_ajaran, 0, 4)); // Contoh: "2024"
		}
		if ($semester) {
			if ($semester == '1') {
				$this->db->where('MONTH(tanggal) >=', 1);
				$this->db->where('MONTH(tanggal) <=', 6);
			} else {
				$this->db->where('MONTH(tanggal) >=', 7);
				$this->db->where('MONTH(tanggal) <=', 12);
			}
		}
		if ($bulan) {
			$this->db->where('MONTH(tanggal)', $bulan);
		}
		$data['kehadiran'] = $this->db->get('absensi')->result_array();

		// Data tambahan
		$data['tahun_ajaran'] = $tahun_ajaran;
		$data['semester']     = $semester;
		$data['bulan']        = $bulan;

		// Load view ke PDF
		$html = $this->load->view('absensi/kehadiran_pdf', $data, true);
		$this->load->library('pdf'); // misalnya dompdf di-wrap sebagai pdf

		$this->pdf->loadHtml($html);
		$this->pdf->setPaper('A4', 'portrait');
		$this->pdf->render();
		$this->pdf->stream("laporan_kehadiran.pdf", array("Attachment" => false));
	}
	public function siswa()
	{
		$this->load->library('pagination');
		$this->load->model('Absensi_model'); // Pastikan modelnya benar

		$data['title'] = 'Data Siswa';
		$data['user'] = $this->db->get_where('user', [
			'email' => $this->session->userdata('email')
		])->row_array();

		// Ambil keyword dari input GET
		$keyword = $this->input->get('keyword');

		// Konfigurasi pagination
		$config['base_url'] = base_url('absensi/siswa');
		$config['total_rows'] = $this->Absensi_model->countAllSiswa($keyword);
		$config['per_page'] = 15;
		$config['reuse_query_string'] = TRUE;

		// Style pagination (opsional)
		$config['full_tag_open'] = '<nav><ul class="pagination">';
		$config['full_tag_close'] = '</ul></nav>';
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
		$config['cur_tag_close'] = '</span></li>';
		$config['next_link'] = '&raquo;';
		$config['prev_link'] = '&laquo;';
		$config['next_tag_open'] = '<li class="page-item">';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>';
		$config['attributes'] = ['class' => 'page-link'];

		$this->pagination->initialize($config);

		// Offset
		$start = $this->uri->segment(3);
		if (!$start)
			$start = 0;

		// Ambil data siswa
		$data['siswa'] = $this->Absensi_model->getSiswa($config['per_page'], $start, $keyword);
		$data['start'] = $start;

		// Load views
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('absensi/siswa', $data); // Pastikan view ini ada
		$this->load->view('templates/footer');
	}

	public function presentase_siswa($id)
	{
		$data['title'] = 'Presentase Kehadiran Siswa';
		$data['user'] = $this->db->get_where('user', [
			'email' => $this->session->userdata('email')
		])->row_array();

		// Load model
		$this->load->model('Absensi_model');
		$this->load->model('Siswa_model');
		$this->load->model('Tahunajaran_model');

		$siswa = $this->Siswa_model->getSiswaById($id);
		if (!$siswa) {
			show_404();
		}

		// Ambil semua tahun ajaran
		$data['tahun_ajaran_list'] = $this->Tahunajaran_model->getAll();

		// Ambil input filter
		$tahun_ajaran = $this->input->get('tahun_ajaran');
		$semester = $this->input->get('semester');

		// Jika tidak dipilih, ambil tahun aktif dari database
		if (!$tahun_ajaran) {
			$aktif = $this->Tahunajaran_model->getAktif();
			$tahun_ajaran = $aktif ? $aktif['nama_tahun'] : null;
		}

		// Simpan untuk view
		$data['tahun_ajaran_terpilih'] = $tahun_ajaran;
		$data['semester_terpilih'] = $semester;

		// Tentukan rentang tanggal semester
		$start_date = null;
		$end_date = null;
		if ($tahun_ajaran && $semester) {
			$tahun = explode('/', $tahun_ajaran)[0];

			if ($semester == '1') {
				$start_date = $tahun . '-01-01';
				$end_date = $tahun . '-06-30';
			} elseif ($semester == '2') {
				$start_date = $tahun . '-07-01';
				$end_date = $tahun . '-12-31';
			}
		}

		// Ambil data kehadiran
		$data['kehadiran'] = $this->Absensi_model->getPresentaseByMapel($id, $start_date, $end_date);
		$data['siswa'] = $siswa;

		// Load view
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('absensi/presentase_siswa', $data);
		$this->load->view('templates/footer');
	}

	public function tambah()
	{
		$this->load->model('Tahunajaran_model');

		$nama = $this->input->post('nama_tahun');
		$id = $this->input->post('siswa_id');

		$data = ['nama_tahun' => $nama, 'aktif' => 'Tidak'];

		$this->db->insert('tahun_ajaran', $data);
		$this->session->set_flashdata('message', '<div class="alert alert-success">Tahun ajaran berhasil ditambahkan.</div>');
		redirect('admin/tahunajaran/' . $id);
	}

	public function detail_kehadiran()
	{
		$data['title'] = 'Detail Kehadiran';
		$data['user'] = $this->db->get_where('user', [
			'email' => $this->session->userdata('email')
		])->row_array();

		$this->load->model('Absensi_model');
		$this->load->model('Siswa_model');
		$this->load->model('Tahunajaran_model');
		$this->load->model('Mapel_model');
		$this->load->library('pagination');

		// Ambil data dari parameter GET
		$siswa_id = $this->input->get('siswa_id');
		$mapel_id = $this->input->get('mapel_id');
		$tahun_ajaran = $this->input->get('tahun_ajaran');
		$semester = $this->input->get('semester');
		$bulan = $this->input->get('bulan');

		// Data siswa dan mata pelajaran
		$data['siswa'] = $this->Siswa_model->getSiswaById($siswa_id);
		$data['nama_mapel'] = $this->Mapel_model->getNamaMapelById($mapel_id);

		if (!$data['siswa']) {
			show_404();
		}

		// Daftar tahun ajaran untuk dropdown
		$data['tahun_ajaran_list'] = $this->Tahunajaran_model->getAll();

		// Untuk menyimpan selected filter
		$data['tahun_ajaran_terpilih'] = $tahun_ajaran;
		$data['semester_terpilih'] = $semester;
		$data['bulan_terpilih'] = $bulan;

		// Konfigurasi pagination
		$config['base_url'] = base_url('absensi/detail_kehadiran?siswa_id=' . $siswa_id . '&mapel_id=' . $mapel_id . '&tahun_ajaran=' . $tahun_ajaran . '&semester=' . $semester . '&bulan=' . $bulan);
		$config['total_rows'] = $this->Absensi_model->count_filtered_kehadiran($siswa_id, $mapel_id, $tahun_ajaran, $semester, $bulan);
		$config['per_page'] = 20;
		$config['page_query_string'] = TRUE;
		$config['query_string_segment'] = 'per_page';

		// Tambahan styling (opsional)
		$config['full_tag_open'] = '<nav><ul class="pagination justify-content-center">';
		$config['full_tag_close'] = '</ul></nav>';
		$config['attributes'] = ['class' => 'page-link'];
		$config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
		$config['cur_tag_close'] = '</span></li>';
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li class="page-item">';
		$config['next_tag_close'] = '</li>';

		$this->pagination->initialize($config);

		$start = $this->input->get('per_page') ? $this->input->get('per_page') : 0;

		// Ambil data kehadiran dengan limit dan offset
		$data['kehadiran'] = $this->Absensi_model->get_detail_kehadiran_mapel($siswa_id, $mapel_id, $tahun_ajaran, $semester, $bulan, $config['per_page'], $start);
		$data['pagination'] = $this->pagination->create_links();

		// Load view
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('absensi/detail_kehadiran', $data);
		$this->load->view('templates/footer');
	}

}
