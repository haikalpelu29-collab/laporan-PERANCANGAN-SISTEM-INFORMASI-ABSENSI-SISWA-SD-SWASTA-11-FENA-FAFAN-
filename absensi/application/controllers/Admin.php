<?php
defined('BASEPATH') or exit('No direct script access allowed');
#[\AllowDynamicProperties]
class Admin extends CI_Controller
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

		$data['total_siswa'] = $this->db->count_all('siswa');
		$data['total_mapel'] = $this->db->count_all('mapel');
		$data['total_guru'] = $this->db->where('role_id', 3)->count_all_results('user');

		// Data grafik siswa per kelas
		$siswa = $this->db->get('siswa')->result_array();
		$kelasData = [];
		foreach ($siswa as $s) {
			$kelas = $s['kelas'];
			if (!isset($kelasData[$kelas])) {
				$kelasData[$kelas] = 0;
			}
			$kelasData[$kelas]++;
		}
		$data['grafik_kelas'] = $kelasData;


		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('admin/index', $data);
		$this->load->view('templates/footer');
	}

	public function role()
	{
		$data['title'] = 'Role';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

		$data['role'] = $this->db->get('user_role')->result_array();

		$this->form_validation->set_rules('role', 'Role', 'required', ['required' => 'Role belum diisi !']);

		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('admin/role', $data);
			$this->load->view('templates/footer');
		} else {
			$data = [
				'role' => $this->input->post('role')
			];

			$this->db->insert('user_role', $data);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Role ditambahkan !</div>');
			redirect('admin/role');
		}
	}

	public function hapusRole($data)
	{

		$this->load->model('Akun_model');
		$this->load->library('form_validation');

		$this->Akun_model->hapusDataRole($data);
		$this->session->set_flashdata('flash', 'Dihapus');

		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Role dihapus.</div>');
		redirect('admin/role');
	}

	public function roleAccess($role_id)
	{
		$data['title'] = 'Role Access';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

		$data['role'] = $this->db->get_where('user_role', ['id' => $role_id])->row_array();

		$this->db->where('id !=', 1);
		$data['menu'] = $this->db->get('user_menu')->result_array();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('admin/role-access', $data);
		$this->load->view('templates/footer');
	}

	public function changeAccess()
	{
		$menu_id = $this->input->post('menuId');
		$role_id = $this->input->post('roleId');

		$data = [
			'role_id' => $role_id,
			'menu_id' => $menu_id
		];

		$result = $this->db->get_where('user_access_menu', $data);

		if ($result->num_rows() < 1) {
			$this->db->insert('user_access_menu', $data);
		} else {
			$this->db->delete('user_access_menu', $data);
		}

		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Akses diubah !</div>');
	}

	public function akun()
	{
		$data['title'] = 'Akun';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$this->load->model('User_model');
		$this->load->model('User_role_model');

		// Ambil data dari tabel user dan user_role
		$users = $this->User_model->get_users();
		$user_roles = $this->User_role_model->get_user_roles();

		// Lakukan proses penggabungan data
		$merged_data = array();
		foreach ($users as $user) {
			$user_id = $user['id'];
			foreach ($user_roles as $role) {
				if ($role['id'] == $user['role_id']) {
					$user['role'] = $role['role'];
					break;
				}
			}
			$merged_data[] = $user;
		}
		$data['users'] = $merged_data;
		if ($this->input->post('keyword')) {
			$data['users'] = $this->User_model->caridatauser();
		}
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('admin/akun', $data);
		$this->load->view('templates/footer');
	}
	public function registration()
	{

		$this->form_validation->set_rules('name', 'Name', 'required|trim');
		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
			'is_unique' => 'Email sudah terdaftar !'
		]);
		$this->form_validation->set_rules(
			'no_hp',
			'No_Hp',
			'required|trim|is_unique[user.no_hp]',
			['is_unique' => 'No Hp sudah ada !', 'required' => 'No Hp belum diisi !']
		);
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$this->form_validation->set_rules(
			'password1',
			'Password',
			'required|trim|min_length[6]|matches[password2]',
			['matches' => 'Password tidak sama !', 'min_length' => 'Password terlalu pendek !']
		);
		$this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');

		$data['user_roles'] = $this->db->get('user_role')->result_array();

		if ($this->form_validation->run() == false) {
			$data['title'] = 'User Registration';
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('admin/registration');
			$this->load->view('templates/footer');
		} else {
			$data = [
				'name' => htmlspecialchars($this->input->post('name', true)),
				'email' => htmlspecialchars($this->input->post('email', true)),
				'no_hp' => htmlspecialchars($this->input->post('no_hp', true)),
				'image' => 'default.png',
				'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
				'role_id' => $this->input->post('role', true),
				'is_active' => 1,
				'date_created' => time()
			];

			$this->db->insert('user', $data);

			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Selamat, Akun anda sudah dibuat.</div>');
			redirect('admin/akun');
		}
	}

	public function hapus($ua)
	{

		$this->load->model('Akun_model');
		$this->load->library('form_validation');

		$this->Akun_model->hapusDataUser($ua);
		$this->session->set_flashdata('flash', 'Dihapus');

		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Akun dihapus.</div>');
		redirect('admin/akun');
	}

	public function editakun($m)
	{
		$data['title'] = 'Edit Account';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

		// Load model Akun_model
		$this->load->model('Akun_model');
		// Mengambil data akun yang akan diubah berdasarkan ID yang diterima sebagai argumen
		$data['akun'] = $this->Akun_model->editAkun($m);

		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[user.email]');


		// Load model User_model dan User_role_model dilakukan di awal saja, karena tidak berkaitan langsung dengan edit akun
		$this->load->model('User_model');
		$this->load->model('User_role_model');

		// Ambil data dari tabel user dan user_role
		$data['users'] = $this->User_model->get_users();
		$data['user_roles'] = $this->User_role_model->get_user_roles();

		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('admin/editakun', $data);
			$this->load->view('templates/footer');
		} else {
			// Jika validasi sukses, proses update data akun
			$this->Akun_model->updateAkun($m);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Akun diubah.</div>');
			redirect('admin/akun');
		}
	}

	// Tampilkan semua siswa
	public function siswa()
	{
		$this->load->library('pagination');
		$data['title'] = 'Data Siswa';
		$data['user'] = $this->db->get_where('user', [
			'email' => $this->session->userdata('email')
		])->row_array();

		// Ambil keyword dari form pencarian
		$keyword = $this->input->get('keyword');
		if ($keyword) {
			$this->db->like('nama', $keyword);
			$this->db->or_like('nis', $keyword);
			$this->db->or_like('kelas', $keyword);
		}

		// Hitung total data untuk pagination
		$this->db->from('siswa');
		if ($keyword) {
			$this->db->like('nama', $keyword);
			$this->db->or_like('nis', $keyword);
			$this->db->or_like('kelas', $keyword);
		}
		$total_rows = $this->db->count_all_results();

		// Konfigurasi pagination
		$config['base_url'] = base_url('admin/siswa');
		$config['total_rows'] = $total_rows;
		$config['per_page'] = 15;
		$config['reuse_query_string'] = TRUE;

		// Tambahan style Bootstrap
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

		// Tentukan halaman aktif (offset)
		$start = $this->uri->segment(3);
		if (!$start)
			$start = 0;

		// Ambil data siswa dengan limit
		if ($keyword) {
			$this->db->like('nama', $keyword);
			$this->db->or_like('nis', $keyword);
			$this->db->or_like('kelas', $keyword);
		}
		$data['siswa'] = $this->db->get('siswa', $config['per_page'], $start)->result_array();

		// Tambahkan data start untuk penomoran
		$data['start'] = $start;

		// Load view
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('admin/siswa', $data);
		$this->load->view('templates/footer');
	}

	public function tambahSiswa()
	{
		$data['title'] = 'Tambah Siswa';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

		$this->form_validation->set_rules('nama', 'Nama', 'required');
		$this->form_validation->set_rules('nis', 'NIS', 'required|is_unique[siswa.nis]');
		$this->form_validation->set_rules('kelas', 'Kelas', 'required');
		$this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');

		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('admin/tambahsiswa', $data);
			$this->load->view('templates/footer');
		} else {
			$this->db->insert('siswa', [
				'nama' => $this->input->post('nama'),
				'nis' => $this->input->post('nis'),
				'kelas' => $this->input->post('kelas'),
				'jenis_kelamin' => $this->input->post('jenis_kelamin')
			]);
			$this->session->set_flashdata('message', '<div class="alert alert-success">Siswa berhasil ditambahkan.</div>');
			redirect('admin/siswa');
		}
	}
	public function editSiswa($id)
	{
		$data['title'] = 'Edit Siswa';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['siswa'] = $this->db->get_where('siswa', ['id' => $id])->row_array();

		$this->form_validation->set_rules('nama', 'Nama', 'required');
		$this->form_validation->set_rules('nis', 'NIS', 'required');
		$this->form_validation->set_rules('kelas', 'Kelas', 'required');
		$this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');

		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('admin/editsiswa', $data);
			$this->load->view('templates/footer');
		} else {
			$this->db->update('siswa', [
				'nama' => $this->input->post('nama'),
				'nis' => $this->input->post('nis'),
				'kelas' => $this->input->post('kelas'),
				'jenis_kelamin' => $this->input->post('jenis_kelamin')
			], ['id' => $id]);

			$this->session->set_flashdata('message', '<div class="alert alert-success">Data siswa berhasil diubah.</div>');
			redirect('admin/siswa');
		}
	}

	public function hapusSiswa($id)
	{
		$this->db->delete('siswa', ['id' => $id]);
		$this->session->set_flashdata('message', '<div class="alert alert-success">Data siswa berhasil dihapus.</div>');
		redirect('admin/siswa');
	}
	public function tahunajaran()
	{
		$data['title'] = 'Kelola Tahun Ajaran';
		$data['user'] = $this->db->get_where('user', [
			'email' => $this->session->userdata('email')
		])->row_array();

		$data['tahun_ajaran'] = $this->db->get('tahun_ajaran')->result_array();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('admin/tahunajaran', $data);
		$this->load->view('templates/footer');
	}

	public function setTahunAktif($id)
	{
		$this->db->set('aktif', 'Tidak')->update('tahun_ajaran');
		$this->db->set('aktif', 'Ya')->where('id', $id)->update('tahun_ajaran');

		$this->session->set_flashdata('message', '<div class="alert alert-success">Tahun ajaran berhasil dijadikan aktif.</div>');
		redirect('admin/tahunajaran');
	}

	public function editTahunAjaran($id)
	{
		$data['title'] = 'Edit Tahun Ajaran';
		$data['user'] = $this->db->get_where('user', [
			'email' => $this->session->userdata('email')
		])->row_array();

		$data['tahun'] = $this->db->get_where('tahun_ajaran', ['id' => $id])->row_array();

		if ($this->input->post()) {
			$nama_tahun = $this->input->post('nama_tahun');
			$aktif = $this->input->post('aktif') == 'Ya' ? 'Ya' : 'Tidak';

			if ($aktif == 'Ya') {
				$this->db->update('tahun_ajaran', ['aktif' => 'Tidak']);
			}

			$this->db->update('tahun_ajaran', [
				'nama_tahun' => $nama_tahun,
				'aktif' => $aktif
			], ['id' => $id]);

			$this->session->set_flashdata('message', '<div class="alert alert-success">Tahun ajaran berhasil diubah.</div>');
			redirect('admin/tahunajaran');
		}

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('admin/edit_tahunajaran', $data);
		$this->load->view('templates/footer');
	}

	public function hapusTahunAjaran($id)
	{
		$this->db->delete('tahun_ajaran', ['id' => $id]);
		$this->session->set_flashdata('message', '<div class="alert alert-success">Tahun ajaran berhasil dihapus.</div>');
		redirect('admin/tahunajaran');
	}

	public function daftar_alpha()
	{
		$this->load->model('Absensi_model');
		$this->load->model('Tahunajaran_model');
		$this->load->model('Notifikasi_model');
		$this->load->library('pagination');
		$this->Notifikasi_model->tandaiSemuaSudahDibaca();

		// Tandai notifikasi sudah dilihat
		$this->session->set_flashdata('notifikasi_alpha_dilihat', true);

		$data['title'] = 'Daftar Siswa Alpha Lebih dari 3 kali';
		$data['user'] = $this->db->get_where('user', [
			'email' => $this->session->userdata('email')
		])->row_array();

		// Ambil daftar tahun ajaran
		$data['tahun_ajaran_list'] = $this->Tahunajaran_model->getAll();

		// Input filter
		$tahun_ajaran = $this->input->get('tahun_ajaran');
		$semester = $this->input->get('semester');

		// Jika kosong, ambil tahun ajaran aktif
		if (!$tahun_ajaran) {
			$aktif = $this->Tahunajaran_model->getAktif();
			$tahun_ajaran = $aktif ? $aktif['nama_tahun'] : null;
		}

		// Hitung rentang semester
		$start_date = $end_date = null;
		if ($tahun_ajaran && $semester) {
			$tahun = explode('/', $tahun_ajaran)[0];
			if ($semester == '1') {
				$start_date = $tahun . '-01-01';
				$end_date = $tahun . '-06-30';
			} else {
				$start_date = $tahun . '-07-01';
				$end_date = $tahun . '-12-31';
			}
		}

		$data['tahun_ajaran_terpilih'] = $tahun_ajaran;
		$data['semester_terpilih'] = $semester;

		// ===== Pagination Start =====
		$config['base_url'] = base_url('admin/daftar_alpha?tahun_ajaran=' . urlencode($tahun_ajaran) . '&semester=' . $semester);
		$config['total_rows'] = $this->Absensi_model->count_siswa_alpha($start_date, $end_date);
		$config['per_page'] = 10;
		$config['page_query_string'] = TRUE;
		$config['query_string_segment'] = 'per_page';

		// Optional: Styling Bootstrap 4
		$config['full_tag_open'] = '<nav><ul class="pagination justify-content-center">';
		$config['full_tag_close'] = '</ul></nav>';
		$config['first_tag_open'] = '<li class="page-item">';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li class="page-item">';
		$config['last_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li class="page-item">';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="page-item active"><a class="page-link">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';
		$config['attributes'] = ['class' => 'page-link'];

		$this->pagination->initialize($config);

		$start = $this->input->get('per_page') ?? 0;

		// ===== Ambil data =====
		$data['siswa_alpha'] = $this->Absensi_model->get_siswa_alpha($start_date, $end_date, $config['per_page'], $start);
		$data['pagination'] = $this->pagination->create_links();

		// Load view
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('admin/daftar_alpha', $data);
		$this->load->view('templates/footer');
	}

	public function export_alpha_pdf()
	{
		$this->load->model('Absensi_model');
		$this->load->model('Tahunajaran_model');

		$tahun_ajaran = $this->input->get('tahun_ajaran');
		$semester = $this->input->get('semester');

		// Hitung rentang tanggal
		$start_date = null;
		$end_date = null;
		if ($tahun_ajaran && $semester) {
			$tahun = explode('/', $tahun_ajaran)[0];
			$start_date = ($semester == '1') ? $tahun . '-01-01' : $tahun . '-07-01';
			$end_date = ($semester == '1') ? $tahun . '-06-30' : $tahun . '-12-31';
		}

		$data['siswa_alpha'] = $this->Absensi_model->get_siswa_alpha($start_date, $end_date);
		$data['tahun_ajaran'] = $tahun_ajaran;
		$data['semester'] = $semester;

		$html = $this->load->view('admin/export_alpha_pdf', $data, TRUE);

		$this->load->library('pdf');
		$this->pdf->loadHtml($html);
		$this->pdf->setPaper('A4', 'landscape');
		$this->pdf->render();
		$this->pdf->stream("laporan_alpha.pdf", array("Attachment" => false));
	}
}
