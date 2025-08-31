<?php
defined('BASEPATH') OR exit('No direct script access allowed');
#[\AllowDynamicProperties]
class Auth extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
	}
	public function login()
	{
		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email', [
			'required' => 'Email belum diisi!',
			'valid_email' => 'Email tidak valid!'
		]);

		$this->form_validation->set_rules('password', 'Password', 'required|trim', [
			'required' => 'Password belum diisi!'
		]);

		if ($this->form_validation->run() == false) {
			$data['title'] = 'Masuk';
			$this->load->view('auth/login', $data);
		} else {
			// Verifikasi Google reCAPTCHA
			$recaptcha_response = $this->input->post('g-recaptcha-response');

			if (!$recaptcha_response) {
				$this->session->set_flashdata('message', '<div class="alert alert-danger">Silakan centang reCAPTCHA terlebih dahulu.</div>');
				redirect('auth/login');
				return;
			}

			$secret_key = '6Ld_FoYrAAAAAFMrSzYD34FRuP_uTueeGdl5khe-';
			$verify_response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secret_key}&response={$recaptcha_response}");
			$response_data = json_decode($verify_response);

			if (!$response_data->success) {
				$this->session->set_flashdata('message', '<div class="alert alert-danger">Verifikasi reCAPTCHA gagal. Silakan coba lagi.</div>');
				redirect('auth/login');
				return;
			}

			// Jika berhasil lolos reCAPTCHA, lanjut ke login
			$this->_login();
		}
	}
	private function _login(){
		$email = $this->input->post('email');
		$password = $this->input->post('password');

		$user = $this->db->get_where('user',['email' => $email])->row_array();

		if($user){
			if($user['is_active'] == 1){
				if(password_verify($password,$user['password'])){	
					$data = [
						'email' => $user['email'],
						'role_id' => $user['role_id'],
						'user_id' => $user['id'] 
					];
					$this->session->set_userdata($data);
					if($user['role_id'] == 1){
						redirect('admin/index');
					}else{
						redirect('user/index');
					}
				}else{
					$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Password salah !</div>');
					redirect('auth/login');
				}
			}else{
				$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Email belum aktivasi !</div>');
				redirect('auth/login');
			}

		}else{
			$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Email belum terdaftar !</div>');
			redirect('auth/login');
		}
	}
	public function registrasi()
	{
		$this->form_validation->set_rules('name','Name','required|trim',['required' => 'Nama belum diisi !']);

		$this->form_validation->set_rules('no_hp','No_Hp','required|trim|is_unique[user.no_hp]',
		['is_unique' => 'No Hp sudah ada !','required' => 'No Hp belum diisi !']);

		$this->form_validation->set_rules('email','Email','required|trim|valid_email|is_unique[user.email]',
		['is_unique' => 'Email sudah ada !','required' => 'Email belum diisi !']);

		$this->form_validation->set_rules('password1','Password','required|trim|min_length[6]|matches[password2]',
		['matches' => 'Password tidak sama !','min_length' => 'Password terlalu pendek !','required' => 'Password belum diisi !']);

		$this->form_validation->set_rules('password2','Password','required|trim|matches[password1]');

		if($this->form_validation->run() == false){
			$data['title'] = 'Daftar Akun';
			$this->load->view('auth/registrasi',$data);
		}else{
			$data = [
				'name'=> htmlspecialchars($this->input->post('name',true)),
				'email'=> htmlspecialchars($this->input->post('email',true)),
				'no_hp'=> htmlspecialchars($this->input->post('no_hp',true)),
				'image'=> 'default.jpg',
				'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
				'role_id' => 3,
				'is_active' => 1,
				'date_created' => time()
			];
			$this->db->insert('user',$data);
			$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Akun anda berhasil dibuat, <strong>Silahkan Masuk</strong> !</div>');
			redirect('auth/login');
		}
	}

	public function logout(){
		$this->session->unset_userdata('email');
		$this->session->unset_userdata('role_id');

		$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">anda berhasil keluar !</strong> !</div>');
			redirect('auth/login');
	}

	public function blocked()
	{
		$this->load->view('auth/blocked');
	}
}
