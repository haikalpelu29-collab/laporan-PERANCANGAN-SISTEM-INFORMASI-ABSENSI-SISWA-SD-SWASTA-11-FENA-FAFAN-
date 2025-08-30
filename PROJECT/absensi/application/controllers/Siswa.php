<?php
defined('BASEPATH') or exit('No direct script access allowed');
#[\AllowDynamicProperties]
class Siswa extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Siswa_model');
        $this->load->library('form_validation');
    }

    public function index() {
        $kelas = $this->input->get('kelas');
        $data['judul'] = 'Daftar Siswa';

        if ($kelas) {
            $data['siswa'] = $this->Siswa_model->get_siswa_by_kelas($kelas);
        } else {
            $data['siswa'] = $this->Siswa_model->get_all_siswa();
        }

        $this->load->view('siswa/index', $data);
    }

    public function tambah() {
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('nis', 'NIS', 'required|is_unique[siswa.nis]');
        $this->form_validation->set_rules('kelas', 'Kelas', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('siswa/tambah');
        } else {
            $data = [
                'nama' => $this->input->post('nama'),
                'nis' => $this->input->post('nis'),
                'kelas' => $this->input->post('kelas'),
                'is_active' => 1
            ];
            $this->Siswa_model->insert_siswa($data);
            redirect('siswa');
        }
    }

    public function edit($id) {
        $data['siswa'] = $this->Siswa_model->get_siswa($id);

        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('nis', 'NIS', 'required');
        $this->form_validation->set_rules('kelas', 'Kelas', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('siswa/edit', $data);
        } else {
            $update = [
                'nama' => $this->input->post('nama'),
                'nis' => $this->input->post('nis'),
                'kelas' => $this->input->post('kelas')
            ];
            $this->Siswa_model->update_siswa($id, $update);
            redirect('siswa');
        }
    }

    public function hapus($id) {
        $this->Siswa_model->nonaktifkan_siswa($id);
        redirect('siswa');
    }
}
