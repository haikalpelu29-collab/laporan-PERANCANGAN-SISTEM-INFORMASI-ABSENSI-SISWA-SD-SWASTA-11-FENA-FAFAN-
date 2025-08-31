<?php
defined('BASEPATH') or exit('No direct script access allowed');
#[\AllowDynamicProperties]
class Mapel extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		// is_logged_in();
		$this->load->model('Mapel_model');
		$this->load->model('User_model'); // Untuk ambil siswa berdasarkan guru atau kelas
	}

	public function index()
{
	$data['title'] = 'Mata Pelajaran';
	$data['user'] = $this->db->get_where('user', [
		'email' => $this->session->userdata('email')
	])->row_array();

	$role_id = $this->session->userdata('role_id');
	$user_id = $data['user']['id'];

	if ($role_id == 3) {
		// Jika guru, ambil mapel yang diajarkan saja
		$data['mapel'] = $this->Mapel_model->getMapelByGuru($user_id);
	} else {
		// Admin atau role lain, ambil semua mapel
		$data['mapel'] = $this->Mapel_model->getAllMapel();
	}

	$this->form_validation->set_rules('nama_mapel', 'Nama Mata Pelajaran', 'required|trim');

	if ($this->form_validation->run() == false) {
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('mapel/index', $data);
		$this->load->view('templates/footer');
	} else {
		$this->Mapel_model->insertMapel($this->input->post('nama_mapel'));
		$this->session->set_flashdata('success', 'Mata pelajaran berhasil ditambahkan!');
		redirect('mapel');
	}
}


	public function lihat($id_mapel)
	{
		$data['title'] = 'Absensi Siswa';
		$data['user'] = $this->db->get_where('user', [
			'email' => $this->session->userdata('email')
		])->row_array();

		$data['mapel'] = $this->Mapel_model->getMapelById($id_mapel);

		// Ambil data siswa
		$data['kelas_filter'] = $this->input->get('kelas'); // jika ingin filter berdasarkan kelas
		if ($data['kelas_filter']) {
			$this->db->order_by('nama', 'ASC');
			$data['siswa'] = $this->db->get_where('siswa', ['kelas' => $data['kelas_filter']])->result_array();
		} else {
			$this->db->order_by('nama', 'ASC');
			$data['siswa'] = $this->db->get('siswa')->result_array();
		}		

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('mapel/lihat', $data);
		$this->load->view('templates/footer');
	}

	public function simpan_absensi()
	{
		$id_mapel     = $this->input->post('id_mapel');
		$tanggal      = $this->input->post('tanggal');
		$id_users     = $this->input->post('id_user');
		$statuses     = $this->input->post('status');
		$keterangans  = $this->input->post('keterangan');

		$files = $_FILES['surat_sakit_izin'];

		$this->load->library('upload');

		foreach ($id_users as $key => $id_user) {
			$file_surat = null;

			if (!empty($files['name'][$key])) {
				$_FILES['file']['name']     = $files['name'][$key];
				$_FILES['file']['type']     = $files['type'][$key];
				$_FILES['file']['tmp_name'] = $files['tmp_name'][$key];
				$_FILES['file']['error']    = $files['error'][$key];
				$_FILES['file']['size']     = $files['size'][$key];

				$config['upload_path']   = './assets/surat/';
				$config['allowed_types'] = 'pdf|jpg|jpeg|png';
				$config['file_name']     = 'surat_' . time() . '_' . $id_user;
				$config['max_size']      = 2048;

				$this->upload->initialize($config);

				if ($this->upload->do_upload('file')) {
					$upload_data = $this->upload->data();
					$file_surat = $upload_data['file_name'];
				} else {
					$this->session->set_flashdata('message', '<div class="alert alert-danger">Upload gagal untuk siswa ID ' . $id_user . ': ' . $this->upload->display_errors('', '') . '</div>');
					redirect('mapel/lihat/' . $id_mapel);
					return;
				}
			}

			$data = [
				'id_user'     => $id_user,
				'id_mapel'    => $id_mapel,
				'tanggal'     => $tanggal,
				'status'      => $statuses[$key],
				'keterangan'  => $keterangans[$key],
				'file_surat'  => $file_surat
			];
			$this->db->insert('absensi', $data);
		}

		$this->session->set_flashdata('message', '<div class="alert alert-success">Absensi berhasil disimpan!</div>');
		redirect('mapel/lihat/' . $id_mapel);
	}

	public function edit_absensi($id_absensi)
	{
		$data['title'] = 'Edit Absensi';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['absensi'] = $this->db->get_where('absensi', ['id_absensi' => $id_absensi])->row_array();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('mapel/edit_absensi', $data);
		$this->load->view('templates/footer');
	}

	public function update_absensi()
{
	$id = $this->input->post('id_absensi');
	$id_mapel = $this->input->post('id_mapel');
	$tanggal = $this->input->post('tanggal');

	$data = [
		'status' => $this->input->post('status'),
		'keterangan' => $this->input->post('keterangan')
	];

	$this->db->update('absensi', $data, ['id_absensi' => $id]);

	$this->session->set_flashdata('message', '<div class="alert alert-success">Absensi berhasil diupdate!</div>');

	// Redirect ke laporan dengan filter tanggal dan mapel
	redirect('absensi/laporan/' . $id_mapel . '/' . $tanggal);
}



	public function riwayat()
	{
		$data['title'] = 'Daftar Absensi';
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

		$this->load->model('Mapel_model');
		$data['riwayat'] = $this->Mapel_model->getRiwayatAbsensi();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('mapel/riwayat', $data);
		$this->load->view('templates/footer');
	}

	public function export_pdf()
	{
		$this->load->model('Mapel_model');
		$data['riwayat'] = $this->Mapel_model->getRiwayatAbsensi();

		$this->load->library('pdf');
		$this->pdf->load_view('mapel/print_pdf', $data);
		$this->pdf->render();
		$this->pdf->stream("riwayat_absensi.pdf", array("Attachment" => 0));
	}

}
