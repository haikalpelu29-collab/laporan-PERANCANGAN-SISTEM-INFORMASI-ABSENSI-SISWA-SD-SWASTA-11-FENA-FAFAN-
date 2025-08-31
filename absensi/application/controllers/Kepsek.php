<?php
defined('BASEPATH') or exit('No direct script access allowed');
#[\AllowDynamicProperties]
class Kepsek extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		is_logged_in();
	}

	public function index()
	{
		$data['title'] = 'Dashboard';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

		$data['total_siswa'] = $this->db->get('siswa')->num_rows();
		$data['total_guru'] = $this->db->where('role_id', 3)->count_all_results('user');
		$data['total_mapel'] = $this->db->get('mapel')->num_rows();

		// Hitung jumlah siswa laki-laki dan perempuan
		$data['jumlah_laki'] = $this->db->where('jenis_kelamin', 'Laki-laki')->count_all_results('siswa');
		$data['jumlah_perempuan'] = $this->db->where('jenis_kelamin', 'Perempuan')->count_all_results('siswa');

		 // Ambil siswa yang memiliki alpha >= 3
		 $data['notifikasi_alpha'] = $this->db->query("
		 SELECT siswa.nama, siswa.kelas, COUNT(absensi.status) as jumlah_alpha
		 FROM absensi
		 JOIN siswa ON siswa.id = absensi.id_user
		 WHERE absensi.status = 'Alpha'
		 GROUP BY absensi.id_user
		 HAVING jumlah_alpha >= 3 ")->result_array();
		 
		 $this->load->model('Notifikasi_model');
		 $data['notifikasi_alpha'] = $this->Notifikasi_model->getNotifikasiBelumDibaca();



		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('kepsek/index', $data);
		$this->load->view('templates/footer');
	}

	public function guru()
{
    $data['title'] = 'Guru';
    $data['user'] = $this->db->get_where('user', [
        'email' => $this->session->userdata('email')
    ])->row_array();

    $data['total_guru'] = $this->db->where('role_id', 3)->count_all_results('user');

    // Ambil data guru dan mapel yang diajarkan
    $this->db->select('user.name as nama_guru, mapel.nama_mapel');
    $this->db->from('user');
    $this->db->join('user_access_mapel', 'user.id = user_access_mapel.user_id');
    $this->db->join('mapel', 'user_access_mapel.mapel_id = mapel.id_mapel');
    $this->db->where('user.role_id', 3);
    $this->db->order_by('user.name', 'ASC');
    $query = $this->db->get();
    $data['guru_mapel'] = $query->result();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('kepsek/guru', $data);
    $this->load->view('templates/footer');
}


	public function mapel()
	{
		$data['title'] = 'Mata Pelajaran';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

		$data['total_mapel'] = $this->db->count_all('mapel');

		$this->load->model('Mapel_model');
		$data['mapel'] = $this->Mapel_model->getAllMapel(); // ✔ sudah cocok dengan model



		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('kepsek/mapel', $data);
		$this->load->view('templates/footer');
	}

	public function siswa()
	{
		$this->load->library('pagination');
		$this->load->model('Kepsek_model'); // Pastikan modelnya benar

		$data['title'] = 'Data Siswa';
		$data['user'] = $this->db->get_where('user', [
			'email' => $this->session->userdata('email')
		])->row_array();

		// Ambil keyword dari input GET
		$keyword = $this->input->get('keyword');

		// Konfigurasi pagination
		$config['base_url'] = base_url('kepsek/siswa');
		$config['total_rows'] = $this->Kepsek_model->countAllSiswa($keyword);
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
		if (!$start) $start = 0;

		// Ambil data siswa
		$data['siswa'] = $this->Kepsek_model->getSiswa($config['per_page'], $start, $keyword);
		$data['start'] = $start;

		// Load views
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('kepsek/siswa', $data); // Pastikan view ini ada
		$this->load->view('templates/footer');
	}

}
