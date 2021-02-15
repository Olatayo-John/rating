<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
	public function index()
	{
		if ($this->session->userdata('mr_logged_in')) {
			if ($this->session->userdata('mr_admin') == "1") {
				redirect('admin');
			} else {
				if ($this->session->userdata('mr_website_form') == "1") {
					if ($this->session->userdata('mr_sub') == "1") {
						redirect('profile');
					} else {
						redirect('plan');
					}
				} else if ($this->session->userdata('mr_website_form') == "0") {
					redirect('websites');
				}
			}
		} else {
			$data['title'] = "login";
			$this->load->view('templates/header', $data);
			$this->load->view('users/login');
			$this->load->view('templates/footer');
		}
	}

	public function fof_error()
	{
		$data['title'] = '404 | Page not Found!';
		$this->load->view('errors/fof_error', $data);
	}

	public function login()
	{
		if ($this->session->userdata('mr_logged_in')) {
			redirect('/');
		}
		$this->form_validation->set_rules('uname', 'Username', 'required|trim|html_escape');
		$this->form_validation->set_rules('pwd', 'Password', 'required|trim|html_escape');

		if ($this->form_validation->run() === FALSE) {
			$this->index();
		} else {
			$validate = $this->Usermodel->login();
			if ($validate == FALSE) {
				$this->session->set_flashdata('invalid', 'Username/Password is wrong');
				redirect('user');
			}
			if ($validate == "inactive") {
				$res_login = $this->Usermodel->login_get_key();
				if ($res_login) {
					$this->session->set_flashdata('invalid', 'Your account is not verified');
					redirect('user/emailverify/' . $res_login);
				}
			}
			if ($validate) {
				$id = $validate->id;
				$admin = $validate->admin;
				$uname = $validate->uname;
				$email = $validate->email;
				$mobile = $validate->mobile;
				$active = $validate->active;
				$web_quota = $validate->web_quota;
				$sub = $validate->sub;
				$website_form = $validate->website_form;
				$form_key = $validate->form_key;

				$user_sess = array(
					'mr_id' => $id,
					'mr_admin' => $admin,
					'mr_uname' => $uname,
					'mr_email' => $email,
					'mr_mobile' => $mobile,
					'mr_active' => $active,
					'mr_sub' => $sub,
					'mr_web_quota' => $web_quota,
					'mr_website_form' => $website_form,
					'mr_form_key' => $form_key,
					'mr_logged_in' => TRUE,
				);
				$this->session->set_userdata($user_sess);
				if ($this->session->userdata('mr_website_form') == "1") {
					if ($this->session->userdata('mr_sub') == "0") {
						$this->session->set_flashdata('invalid', 'You have no active subscription.');
						redirect('plan');
						exit();
					} elseif ($this->session->userdata('mr_sub') == "1") {
						// redirect('user/account');
						redirect('user/profile');
					}
				} else {
					redirect('websites');
				}
			}
		}
	}

	public function logout()
	{
		$this->session->unset_userdata('mr_id');
		$this->session->unset_userdata('mr_admin');
		$this->session->unset_userdata('mr_uname');
		$this->session->unset_userdata('mr_email');
		$this->session->unset_userdata('mr_mobile');
		$this->session->unset_userdata('mr_active');
		$this->session->unset_userdata('mr_sub');
		$this->session->unset_userdata('mr_web_quota');
		$this->session->unset_userdata('mr_website_form');
		$this->session->unset_userdata('mr_form_key');
		$this->session->unset_userdata('mr_logged_in');
		// $this->session->sess_destroy();

		$this->session->set_flashdata('valid', 'Logged out');
		redirect('/');
	}

	public function check_duplicate_username()
	{
		$data['user_data'] = $this->Usermodel->check_duplicate_username($_POST['uname_val']);
		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	public function register()
	{
		$data['title'] = "register";

		if ($this->session->userdata('mr_logged_in')) {
			$this->session->set_flashdata('invalid', 'Log out first.');
			redirect('/');
		}
		$this->form_validation->set_rules('fname', 'First Name', 'trim|html_escape');
		$this->form_validation->set_rules('lname', 'Last Name', 'trim|html_escape');
		$this->form_validation->set_rules('email', 'E-mail', 'required|trim|valid_email|html_escape');
		$this->form_validation->set_rules('mobile', 'Mobile', 'required|trim|html_escape');
		$this->form_validation->set_rules('uname', 'Username', 'required|trim|html_escape');
		$this->form_validation->set_rules('pwd', 'Password', 'required|trim|html_escape');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('templates/header', $data);
			$this->load->view('users/register');
			$this->load->view('templates/footer');
		} else {
			$act_key =  mt_rand(0, 1000000);
			$form_key =  htmlentities($this->input->post("uname")) . mt_rand(0, 100000);

			$email = htmlentities($this->input->post('email'));
			$uname = htmlentities($this->input->post('uname'));
			$link = base_url() . "emailverify/" . $form_key;

			$mail_res = $this->send_email_code($email, $uname, $act_key, $link);
			if ($mail_res !== TRUE) {
				$this->session->set_flashdata('invalid', $mail_res);
				redirect('register');
				exit();
			} else {
				$db_res = $this->Usermodel->register($act_key, $form_key);
				if ($db_res !== TRUE) {
					$this->session->set_flashdata('invalid', 'Error saving your details. Please try again');
					redirect('register');
					exit();
				} else {
					$this->session->set_flashdata('valid', 'Verification code sent to you mail.');
					redirect('emailverify/' . $form_key);
					exit();
				}
			}
		}
	}

	public function send_email_code($email, $uname, $act_key, $link)
	{
		$config['protocol']    = 'smtp';
		$config['smtp_host']    = 'ssl://smtp.gmail.com';
		$config['smtp_port']    = '465';
		$config['smtp_timeout'] = '7';
		$config['smtp_user']    = 'jvweedtest@gmail.com';
		$config['smtp_pass']    = 'Jvweedtest9!';
		$config['charset']    = 'iso-8859-1';
		$config['mailtype'] = 'text';
		$config['validation'] = TRUE;

		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");

		$body = "Hello " . $uname . "\n\nYour verification code is " . $act_key . "\nEnter the above code in our website to activate your account.\nClick here " . $link . "\n\nIf you have any questions, send us an email at info@nktech.in.\n\nBest Regards,\nNKTECH\nhttps://nktech.in";

		$this->email->from('jvweedtest@gmail.com', 'Rating');
		$this->email->to($email);
		$this->email->subject("Verification Code");
		$this->email->message($body);

		if ($this->email->send()) {
			return true;
		} else {
			return $this->email->print_debugger();
		}
	}

	public function emailverify($key)
	{
		$check_res = $this->Usermodel->check_verification($key);
		if ($check_res == false) {
			$this->session->set_flashdata('invalid', 'Wrong credentials');
			redirect('login');
		} else {
			$active = $check_res->active;
			if ($active == '1') {
				$this->session->set_flashdata('valid', 'Your account is already verified.');
				redirect('login');
			}
			$this->form_validation->set_rules('sentcode', 'Verification Code', 'required|trim|html_escape');
			if ($this->form_validation->run() == false) {
				$data['key'] = $key;
				$this->load->view('templates/header');
				$this->load->view('users/email_verify', $data);
				$this->load->view('templates/footer');
			} else {
				$res = $this->Usermodel->emailverify($key);
				if ($res == false) {
					$this->session->set_flashdata('invalid', 'Invalid code');
					redirect('emailverify/' . $key);
				} else {
					if ($res->active !== "1") {
						$this->session->set_flashdata('invalid', 'Error activating. Please try again');
						redirect('emailverify/' . $key);
					} else if ($res->active == "1") {
						$id = $res->id;
						$admin = $res->admin;
						$uname = $res->uname;
						$email = $res->email;
						$mobile = $res->mobile;
						$active = $res->active;
						$sub = $res->sub;
						$web_quota = $res->web_quota;
						$website_form = $res->website_form;
						$form_key = $res->form_key;

						$user_sess = array(
							'mr_id' => $id,
							'mr_admin' => $admin,
							'mr_uname' => $uname,
							'mr_email' => $email,
							'mr_mobile' => $mobile,
							'mr_active' => $active,
							'mr_sub' => $sub,
							'mr_web_quota' => $web_quota,
							'mr_website_form' => $website_form,
							'mr_form_key' => $form_key,
							'mr_logged_in' => TRUE,
						);
						$this->session->set_userdata($user_sess);
						$this->session->set_flashdata('valid', 'Your account is active');
						redirect('websites');
					}
				}
			}
		}
	}

	public function resendemailverify($key)
	{
		$check_res = $this->Usermodel->check_verification($key);
		if ($check_res == false) {
			$this->session->set_flashdata('invalid', 'Wrong credentials');
			redirect($_SERVER['HTTP_REFERRER']);
		} else {
			$active = $check_res->active;
			if ($active == '1') {
				$this->session->set_flashdata('valid', 'Your account is already verified and active.');
				redirect('login');
			} else {
				$res = $this->Usermodel->check_verification($key);

				$email = $res->email;
				$uname = $res->uname;
				$link = base_url() . "emailverify/" . $res->form_key;
				$act_key =  mt_rand(0, 1000000);

				$res_update = $this->send_email_code($email, $uname, $act_key, $link);
				if ($res_update !== TRUE) {
					$this->session->set_flashdata('invalid', $res_update);
					redirect($link);
				} else {
					$this->Usermodel->code_verify_update($act_key, $key);
					$this->session->set_flashdata('valid', 'Verification code sent to you mail.');
					redirect($_SERVER['HTTP_REFERER']);
				}
			}
		}
	}

	public function websites()
	{
		$data['title'] = "websites";

		if (!$this->session->userdata('mr_logged_in')) {
			$this->session->set_flashdata('invalid', 'Please login first');
			redirect('login');
		}
		if ($this->session->userdata('mr_website_form') == "1") {
			redirect('/');
		}
		$this->load->view('templates/header', $data);
		$this->load->view('users/websites');
		$this->load->view('templates/footer');
	}

	public function addwebsites()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$data['status'] = false;
			$data['msg'] = base_url("login");
		}
		if ($this->session->userdata('mr_website_form') == "1") {
			$data['status'] = false;
			$data['msg'] = base_url("/");
		} else {
			$res = $this->Usermodel->addwebsites($_POST['webname_arr'], $_POST['weblink_arr']);
			// $res = false;
			if ($res !== true) {
				$data['status'] = "error";
				$data['msg'] = "Error adding your websites!";
			} else {
				$data['status'] = true;
				$data['msg'] = base_url("/");
			}
		}
		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	public function profile()
	{
		$data['title'] = "profile";

		if (!$this->session->userdata('mr_logged_in')) {
			$this->session->set_flashdata('invalid', 'Please login first');
			redirect('login');
		}
		$data['user_info'] = $this->Usermodel->get_info();
		$data['websites'] = $this->Usermodel->get_user_websites();
		if (!$data) {
			$this->session->set_flashdata('invalid', 'This account doesnt exist');
			$this->logout();
		} elseif ($data) {
			// print_r($data);
			// die;
			$this->load->view('templates/header', $data);
			$this->load->view('users/edit', $data);
			$this->load->view('templates/footer');
		}
	}

	public function personal_edit()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->session->set_flashdata('invalid', 'Please login first');
			redirect('user/login');
		}
		$this->form_validation->set_rules('uname', 'Username', 'required|trim|html_escape');
		$this->form_validation->set_rules('fname', 'First Name', 'trim|html_escape');
		$this->form_validation->set_rules('lname', 'Last Name', 'trim|html_escape');
		$this->form_validation->set_rules('email', 'E-mail', 'required|trim|valid_email|html_escape');
		$this->form_validation->set_rules('mobile', 'Mobile', 'required|trim|html_escape');

		if ($this->form_validation->run() === FALSE) {
			redirect('user/profile');
		} else {
			$res = $this->Usermodel->personal_edit();
			if ($res !== TRUE) {
				$this->session->set_flashdata('invalid', 'Update Failed');
				redirect('user/profile');
			} else {
				$this->session->set_flashdata('valid', 'Updated');
				redirect('user/profile');
			}
		}
	}

	public function edit_website()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->session->set_flashdata('invalid', 'Please login first');
			redirect('user/login');
		}
		$act_res = $this->Usermodel->edit_website($_POST['id']);
		if ($act_res == false) {
			return false;
		} else {
			$data['web_name'] = $act_res->web_name;
			$data['web_link'] = $act_res->web_link;
			$data['token'] = $this->security->get_csrf_hash();
			echo json_encode($data);
		}
	}

	public function check_user_websites()
	{
		$this->Usermodel->check_user_websites();
	}

	public function user_new_website()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->session->set_flashdata('invalid', 'Please login first');
			redirect('user/login');
		}
		$this->form_validation->set_rules('web_name_new', 'Name', 'required|trim|html_escape');
		$this->form_validation->set_rules('web_link_new', 'Link', 'required|trim|html_escape');

		if ($this->form_validation->run() === FALSE) {
			redirect('profile');
		} else {
			$res = $this->Usermodel->user_new_website();
			if ($res !== true) {
				$this->session->set_flashdata('invalid', $res);
				redirect("profile");
			} else {
				$this->session->set_flashdata('valid', 'Website addedd successfully!');
				redirect("profile");
			}
		}
	}

	public function delete_website()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->session->set_flashdata('invalid', 'Please login first');
			redirect('user/login');
		}
		$act_res = $this->Usermodel->delete_website($_POST['id']);
		if ($act_res == false) {
			$this->session->set_flashdata('invalid', 'Error deleting this data! Please try again');
		} else {
			$this->session->set_flashdata('valid', 'Data deleted successfully!');
		}
	}

	public function website_status()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->session->set_flashdata('invalid', 'Please login first');
			redirect('user/login');
		}
		$act_res = $this->Usermodel->website_status($_POST['id'], $_POST['status']);
		if ($act_res == false) {
			$this->session->set_flashdata('invalid', 'Error changing website status');
		} else {
			$this->session->set_flashdata('valid', 'Web Status Updated!');
		}
	}

	public function account_edit()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->session->set_flashdata('invalid', 'Please login first');
			redirect('user/login');
		}

		$this->form_validation->set_rules('c_pwd', 'Current Password', 'required|trim');
		$this->form_validation->set_rules('n_pwd', 'New Password', 'required|trim|min_length[6]');
		$this->form_validation->set_rules('rtn_pwd', 'Re-type Password', 'required|trim|min_length[6]|matches[n_pwd]');

		if ($this->form_validation->run() == false) {
			redirect('user/profile');
		} else {
			$pwd_res = $this->Usermodel->check_pwd();
			if ($pwd_res == false) {
				$this->session->set_flashdata('invalid', 'Incorrect password provided');
				redirect($_SERVER['HTTP_REFERER']);
			} else {
				$this->session->set_flashdata('valid', 'Password changed');
				redirect($_SERVER['HTTP_REFERER']);
			}
		}
	}

	public function deact_account()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->session->set_flashdata('invalid', 'Please login first');
			redirect('user/login');
		}
		$act_res = $this->Usermodel->deact_account();
		if ($act_res == false) {
			$this->session->set_flashdata('invalid', 'Error performing this operation');
		}
	}

	/* public function search_website()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->session->set_flashdata('invalid', 'Please login first');
			redirect('user/login');
		}
		$act_res = $this->Usermodel->search_website($_POST['search_data']);
		$output = '';
		if ($act_res->num_rows() == 0) {
			$output = '<h5 class="text-center text-uppercase pt-4 pb-3">No website present</h5>';
		} else {
			foreach ($act_res->result_array() as $web) {
				$output = '<div class="row col-md-12" style="padding-right:0">';
				if ($web['active'] == "1") {
					$output .= '<div class="col-md-1" style="margin:auto">
					<i class="fas fa-circle text-success" style="font-size: 20px;"></i>
				</div>';
				}
				if ($web['active'] == "0") {
					$output .= '<div class="col-md-1" style="margin:auto">
					<i class="fas fa-circle text-danger" style="font-size: 20px;"></i>
				</div>';
				}
				$output .= '<div class="form-group col">
				<input type="text" name="web_name" class="form-control web_input" value="' . $web['web_name'] . '" id="' . $web['id'] . '" placeholder="Website name" readonly>
				</div>';
				$output .= '<div class="col-md-4" style="padding:0">
				<div class="d-flex flex-row" style="justify-content:flex-end">
					<button type="button" class="btn btn-dark edit_web_btn " id="' . $web['id'] . '">
						Edit
					</button>
					<button type="button" class="btn btn-dark delete_web_btn ml-2" id="' . $web['id'] . '">
						Delete
					</button>';
				if ($web['active'] == "1") {
					$output .= '<button type="button" class="btn btn-danger status_web_btn ml-2" id="' . $web['id'] . '" status="0">
						Deactivate
					</button>';
				}
				if ($web['active'] == "0") {
					$output .= '<button type="button" class="btn btn-success status_web_btn ml-2" id="' . $web['id'] . '" status="1">
						Activate
					</button>';
				}
				$output .= '</div></div></div>';
			}
		}
		echo json_encode($output);
	} */

	public function quota_send_mail_expire($usermail_expire)
	{
		$config['protocol']    = 'smtp';
		$config['smtp_host']    = 'ssl://smtp.gmail.com';
		$config['smtp_port']    = '465';
		$config['smtp_timeout'] = '7';
		$config['smtp_user']    = 'jvweedtest@gmail.com';
		$config['smtp_pass']    = 'Jvweedtest9!';
		$config['charset']    = 'iso-8859-1';
		$config['mailtype'] = 'text';
		$config['validation'] = TRUE;

		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");

		$body = "Hello.\n\nThis email is to inform you that your Quota Limit has expired.\nNew ratings woun't be recorded\nRenew your package to continue using our services " . base_url() . "\nIf you have any query, send us an email at info@nktech.in.\n\nBest Regards,\nNKTECH\nhttps://nktech.in";

		$this->email->from('jvweedtest@gmail.com', 'Rating');
		$this->email->to($usermail_expire);
		$this->email->subject('Quota Limit');
		$this->email->message($body);

		if ($this->email->send()) {
			return true;
		} else {
			return $this->email->print_debugger();
		}
	}

	public function email_sample_csv()
	{
		header("Content-Type: text/csv; charset=utf-8");
		header("Content-Disposition: attachment; filename=email_csv_sample.csv");
		$output = fopen("php://output", "w");
		fputcsv($output, array('Email'));
		$data['email'] = array(
			'email' => "example@domain-name.com",
		);
		foreach ($data as $row) {
			fputcsv($output, $row);
		}
		fclose($output);
	}

	public function sms_sample_csv()
	{
		header("Content-Type: text/csv; charset=utf-8");
		header("Content-Disposition: attachment; filename=sms_csv_sample.csv");
		$output = fopen("php://output", "w");
		fputcsv($output, array('Phonenumber'));
		$data['Phonenumber'] = array(
			'Phonenumber' => "0123456789",
		);
		foreach ($data as $row) {
			fputcsv($output, $row);
		}
		fclose($output);
	}

	public function sendlink()
	{
		$data['title'] = "share";

		if (!$this->session->userdata('mr_logged_in')) {
			$this->session->set_flashdata('invalid', 'Please login first');
			redirect('user');
		}
		if ($this->session->userdata('mr_sub') == "0") {
			$this->session->set_flashdata('invalid', 'You have no active subscription.');
			redirect('plan');
		}
		$this->form_validation->set_rules('email', 'E-mail', 'required|trim|valid_email|html_escape');
		$this->form_validation->set_rules('subj', 'Subject', 'required|trim|html_escape');
		$this->form_validation->set_rules('bdy', 'Body', 'required|trim|html_escape');

		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $data);
			$this->load->view('users/sendlink');
			$this->load->view('templates/footer');
		} else {
			$cq_res = $this->Adminmodel->check_quota_expire();
			if ($cq_res === "not_Found") {
				$this->logout();
				exit;
			} else if ($cq_res !== false) {
				$usermail_expire = $cq_res->email;
				$this->quota_send_mail_expire($usermail_expire);
				$this->session->set_flashdata('invalid', 'Quota has expired');
				redirect('plan');
			} else {
				$email = htmlentities($this->input->post('email'));
				$subj = htmlentities($this->input->post('subj'));
				$bdy = htmlentities($this->input->post('bdy'));
				$mail_res = $this->link_send_mail($email, $subj, $bdy);
				if ($mail_res !== true) {
					$this->session->set_flashdata('invalid', $mail_res);
					redirect($_SERVER['HTTP_REFERER']);
					exit;
				} else {
					$res = $this->Usermodel->save_info();
					if ($res !== true) {
						$this->session->set_flashdata('invalid', 'Error saving contacts to DATABASE.');
						redirect($_SERVER['HTTP_REFERER']);
						exit;
					} else {
						$cq_res = $this->Adminmodel->check_quota_expire();
						if ($cq_res !== false) {
							$db_email = $cq_res->email;
							$this->quota_send_mail_expire($db_email);
							$this->session->set_flashdata('valid', 'Link sent successfully');
							redirect($_SERVER['HTTP_REFERER']);
							exit;
						} else {
							$this->session->set_flashdata('valid', 'Link sent successfully');
							redirect($_SERVER['HTTP_REFERER']);
							exit;
						}
					}
				}
			}
		}
	}

	public function getlink()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->session->set_flashdata('invalid', 'Please login first');
			redirect('user');
		}
		if ($this->session->userdata('mr_sub') == "0") {
			return FALSE;
			exit();
		}
		$myfile = fopen("body.txt", "w") or die("Unable to open file!");
		$txt = "Click the link below, to rate any of my websites\n";
		fwrite($myfile, $txt);
		$txt = base_url() . "user/wtr/" . $this->session->userdata("mr_form_key") . "\n\n";
		fwrite($myfile, $txt);
		$txt = $this->session->userdata("mr_uname") . "\n";
		fwrite($myfile, $txt);
		$txt = $this->session->userdata("mr_email") . "\n";
		fwrite($myfile, $txt);
		$txt = "Regards";
		fwrite($myfile, $txt);
		fclose($myfile);

		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	public function link_send_mail($email, $subj, $bdy)
	{
		$config['protocol']    = 'smtp';
		$config['smtp_host']    = 'ssl://smtp.gmail.com';
		$config['smtp_port']    = '465';
		$config['smtp_timeout'] = '7';
		$config['smtp_user']    = 'jvweedtest@gmail.com';
		$config['smtp_pass']    = 'Jvweedtest9!';
		$config['charset']    = 'iso-8859-1';
		$config['mailtype'] = 'text';
		$config['validation'] = TRUE;

		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");


		$this->email->from('jvweedtest@gmail.com', 'Rating');
		$this->email->to($email);
		$this->email->subject($subj);
		$this->email->message($bdy);

		if ($this->email->send()) {
			return true;
		} else {
			return $this->email->print_debugger();
		}
	}

	public function importcsv_email()
	{
		$file_data = fopen($_FILES['csv_file']['tmp_name'], 'r');
		fgetcsv($file_data);
		while ($row = fgetcsv($file_data)) {
			$data[] = array(
				'Email' => $row[0],
			);
		}
		echo json_encode($data);
	}

	public function send_multiple_email()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->session->set_flashdata('invalid', 'Please login first');
			redirect('user');
		}
		if ($this->session->userdata('mr_sub') == "0") {
			$this->session->set_flashdata('invalid', 'You have no active subscription.');
			redirect('plan');
		}
		$cq_res = $this->Usermodel->check_user_quota();
		if ($cq_res == true) {
			$this->send_quota_expire_mail();
			$this->session->set_flashdata('invalid', 'Your Quota has expired. Please renew to continue using our services.');
			redirect('plan');
		} else {
			$emaildata = $_POST['emaildata'];
			$subj = $_POST['subj'];
			$bdy = $_POST['bdy'];
			$num = count($emaildata);

			$qbl_res = $this->Usermodel->user_quota_details();
			if ($qbl_res->bal < $num) {
				$this->session->set_flashdata('invalid', 'Number of emails to be sent exceeds your remaining quota point of ' . $qbl_res->bal . ' .');
			} else {
				$mail_res = $this->send_multiple_link_email($emaildata, $subj, $bdy);
				if ($mail_res !== true) {
					$this->session->set_flashdata('invalid', $mail_res);
				} else {
					$res = $this->Usermodel->multiplemail_save_info($_POST['emaildata'], $_POST['subj'], $_POST['bdy']);
					if ($res !== true) {
						$this->session->set_flashdata('invalid', 'Error saving to DATABASE.');
					} else {
						$length = count($emaildata);
						$cq_res = $this->Usermodel->user_quota_update($length);
						$this->session->set_flashdata('valid', 'Link sent successfully');
					}
				}
			}
		}
	}

	public function send_multiple_link_email($emaildata, $subj, $bdy)
	{
		$config['protocol']    = 'smtp';
		$config['smtp_host']    = 'ssl://smtp.gmail.com';
		$config['smtp_port']    = '465';
		$config['smtp_timeout'] = '7';
		$config['smtp_user']    = 'jvweedtest@gmail.com';
		$config['smtp_pass']    = 'Jvweedtest9!';
		$config['charset']    = 'iso-8859-1';
		$config['mailtype'] = 'text';
		$config['validation'] = TRUE;

		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");

		$this->email->from('jvweedtest@gmail.com', 'Rating');
		$this->email->to(implode(",", $emaildata));
		$this->email->subject($subj);
		$this->email->message($bdy);

		if ($this->email->send()) {
			return true;
		} else {
			return $this->email->print_debugger();
		}
	}

	public function sms_send_link()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->session->set_flashdata('invalid', 'Please login first');
			redirect('user');
		}
		if ($this->session->userdata('mr_sub') == "0") {
			$this->session->set_flashdata('invalid', 'You have no active subscription.');
			redirect('plan');
		}
		$this->form_validation->set_rules('mobile', 'Mobile', 'required|trim|html_escape');
		$this->form_validation->set_rules('smsbdy', 'Body', 'required|trim|html_escape');

		if ($this->form_validation->run() == FALSE) {
			$this->load->view('templates/header');
			$this->load->view('users/sendlink');
			$this->load->view('templates/footer');
		} else {
			$cq_res = $this->Adminmodel->check_quota_expire();
			if ($cq_res !== false) {
				$db_email = $cq_res->email;
				$usermail_expire = $cq_res->email;
				$this->quota_send_mail_expire($usermail_expire);
				$this->session->set_flashdata('invalid', 'Quota has expired');
				redirect('plan');
			} else {
				$mobile = $this->input->post('mobile');
				$bdy = $this->input->post('smsbdy');

				$url = "http://onextelbulksms.in/shn/api/pushsms.php?usr=621665&key=010BrbJ20v1c2eCc8LGih6RlTIGqKN&sndr=KARUNJ&ph=+91" . $mobile . "&text=";
				$req = curl_init();
				$complete_url = $url . curl_escape($req, $bdy) . "&rpt=1";
				curl_setopt($req, CURLOPT_URL, $complete_url);
				$result = curl_exec($req);

				if ($result == false) {
					$this->session->set_flashdata('invalid', 'Error sending SMS');
					redirect($_SERVER["HTTP_REFERER"]);
					exit;
				} else {
					$res = $this->Usermodel->sms_save_info();
					if ($res !== true) {
						$this->session->set_flashdata('invalid', 'Error saving contacts to DATABASE.');
						redirect($_SERVER["HTTP_REFERER"]);
						exit;
					} else {
						$cq_res = $this->Adminmodel->check_quota_expire();
						if ($cq_res !== false) {
							$db_email = $cq_res->email;
							$this->quota_send_mail_expire($db_email);
							$this->session->set_flashdata('valid', 'SMS sent successfully');
							redirect($_SERVER["HTTP_REFERER"]);
							exit;
						} else {
							$this->session->set_flashdata('valid', 'SMS sent successfully');
							redirect($_SERVER["HTTP_REFERER"]);
							exit;
						}
					}
				}
				curl_close($req);
			}
		}
	}

	public function sms_importcsv()
	{
		$file_data = fopen($_FILES['sms_csv_file']['tmp_name'], 'r');
		fgetcsv($file_data);
		while ($row = fgetcsv($file_data)) {
			$data[] = array(
				'Phonenumber' => $row[0],
			);
		}
		echo json_encode($data);
	}

	public function multiple_sms_send_link()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->session->set_flashdata('invalid', 'Please login first');
			redirect('user');
		}
		if ($this->session->userdata('mr_sub') == "0") {
			$this->session->set_flashdata('invalid', 'You have no active subscription.');
			redirect('plan');
		}
		$cq_res = $this->Adminmodel->check_quota_expire();
		if ($cq_res !== false) {
			$db_email = $cq_res->email;
			$this->send_quota_expire_mail();
			$this->session->set_flashdata('invalid', 'Your Quota has expired. Please renew to continue using our services.');
			redirect('plan');
		} else {
			$mobiledata = $_POST['mobiledata'];
			$smsbdy = $_POST['smsbdy'];
			$num = count($mobiledata);
			$qbl_res = $this->Usermodel->user_quota_details();
			if ($qbl_res->bal < $num) {
				$this->session->set_flashdata('invalid', 'Number of sms to be sent exceeds your remaining quota point of ' . $qbl_res->bal . ' .');
			} else {
				$url = "http://onextelbulksms.in/shn/api/pushsms.php?usr=621665&key=010BrbJ20v1c2eCc8LGih6RlTIGqKN&sndr=KARUNJ&ph=" . implode(",", $mobiledata) . "&text=";
				$req = curl_init();
				$complete_url = $url . curl_escape($req, $smsbdy) . "&rpt=1";
				curl_setopt($req, CURLOPT_URL, $complete_url);
				$result = curl_exec($req);

				if ($result === false) {
					$this->session->set_flashdata('invalid', 'Error sending SMS');
				} else {
					$res = $this->Usermodel->multiplsms_save_info($_POST['mobiledata'], $_POST['smsbdy']);
					if ($res !== true) {
						$this->session->set_flashdata('invalid', 'Error saving contacts to DATABASE.');
					} else {
						$cq_res = $this->Adminmodel->check_quota_expire();
						if ($cq_res !== false) {
							$usermail_expire = $cq_res->email;
							$this->quota_send_mail_expire($usermail_expire);
							$this->session->set_flashdata('valid', 'SMS sent successfully');
						} else {
							$this->session->set_flashdata('valid', 'SMS sent successfully');
						}
					}
				}
				curl_close($req);
			}
		}
	}

	public function send_quota_expire_mail()
	{
		$config['protocol']    = 'smtp';
		$config['smtp_host']    = 'ssl://smtp.gmail.com';
		$config['smtp_port']    = '465';
		$config['smtp_timeout'] = '7';
		$config['smtp_user']    = 'jvweedtest@gmail.com';
		$config['smtp_pass']    = 'Jvweedtest9!';
		$config['charset']    = 'iso-8859-1';
		$config['mailtype'] = 'text';
		$config['validation'] = TRUE;

		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");

		$body = "Hello.\n\nThis email is to inform you that your Quota has expired.SMS, Emails and Future ratings woun't be recorded\nRenew your plan to keep using our services" . base_url('plan') . "\nIf you have any queries, send us an email at info@nktech.in.\n\nBest Regards,\nNKTECH\nhttps://nktech.in";
		$mail = $this->session->userdata('mr_email');

		$this->email->from('jvweedtest@gmail.com', 'Quota Limit');
		$this->email->to($mail);
		$this->email->subject('Quota Limit');
		$this->email->message($body);

		if ($this->email->send()) {
			return true;
		} else {
			return $this->email->print_debugger();
		}
	}

	public function account()
	{
		$data['title'] = "account";

		if (!$this->session->userdata('mr_logged_in')) {
			$this->session->set_flashdata('loginfirst', 'Please login first');
			redirect('user');
		}
		$data['user'] = $this->Usermodel->user_total_ratings();
		$data['balance'] = $this->Usermodel->user_total_quota();
		$data['user_web'] = $this->Usermodel->get_user_websites();

		$data['sent_links'] = $this->Usermodel->all_user_sent_links();
		$data['sent_links_sms'] = $this->Usermodel->all_user_sent_links_sms();
		$data['sent_links_email'] = $this->Usermodel->all_user_sent_links_email();

		$data['get_total_ratings'] = $this->Adminmodel->get_total_ratings();
		$data['get_total_official'] = $this->Adminmodel->get_total_official();
		$data['get_total_google'] = $this->Adminmodel->get_total_google();
		$data['get_total_facebook'] = $this->Adminmodel->get_total_facebook();
		$data['get_total_gd'] = $this->Adminmodel->get_total_gd();
		$data['get_total_tp'] = $this->Adminmodel->get_total_tp();
		$data['get_total_other'] = $this->Adminmodel->get_total_other();
		// print_r($data['sent_links_email']);
		// die;
		$this->load->view('templates/header', $data);
		$this->load->view('users/account', $data);
		$this->load->view('templates/footer');
	}

	public function get_key($key)
	{
		$form_key = $this->Usermodel->get_key($key);
		if (!$form_key) {
			return false;
		} else {
			return $form_key;
		}
	}

	public function wtr($key)
	{
		if (!$key) {
			redirect($_SERVER['HTTP_REFERER']);
			exit();
		} else {
			$form_key = $this->get_key($key);
			if ($form_key !== $key) {
				$this->session->set_flashdata("invalid", "Invalid Link!");
				$this->index();
			} else if ($form_key === $key) {
				$data['form_key'] = $form_key;
				$data['web_data'] = $this->Adminmodel->getuserwebsites_wtr($form_key);
				$data['active'] = $this->Adminmodel->is_user_active($form_key);

				$this->load->view('templates/header');
				$this->load->view('users/rate_option', $data);
				$this->load->view('templates/footer');
			}
		}
	}

	public function check_cred()
	{
		$w = $_GET['w'];
		$k = $_GET['k'];

		if (!isset($w) || !isset($k)) {
			// redirect($_SERVER['HTTP_REFERER']);
			redirect("user/wtr/" . $k);
			exit();
		} else {
			$res = $this->Usermodel->check_cred($w, $k);
			if ($res == false) {
				$this->session->set_flashdata("invalid", "Invalid Link!");
				redirect("user/wtr/" . $k);
			} elseif ($res == true) {
				redirect('rate?w=' . $w . '&k=' . $k);
			}
		}
	}

	public function rating_store()
	{
		$cq_res = $this->Usermodel->check_quota_expire($_POST['form_key']);
		// $cq_res = false;
		if ($cq_res == true) {
			//$this->send_quota_expire_mail();
			$data['res'] = "failed";
			$data['res_msg'] = "User quota expired. <a href='" . base_url("user/notifyuser_email/") . "' class='text-info'>Notify User!</a>";
		} else {
			$res = $this->Usermodel->rating_store($_POST['starv'], $_POST['name'], $_POST['mobile'], $_POST['form_key'], $_POST['for_link']);
			if ($res) {
				$data['web_link'] = $res->web_link;
				$data['res'] = "succ";
				$data['res_msg'] = "Thanks for your feedback!";
			} else {
				$data['res'] = "failed";
				$data['res_msg'] = "Failed to store rating.";
			}
		}

		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	public function notifyuser_email($form_key)
	{
		$data = $this->Usermodel->get_user_email($form_key);
		// print_r($data);
		$uemail = $data->email;
		$uname = $data->uname;

		$res = $this->notifyuser_sendemail($uemail, $uname);
		return true;
		//$res= ;
	}

	public function notifyuser_sendemail($uemail, $uname)
	{
		$config['protocol']    = 'smtp';
		$config['smtp_host']    = 'ssl://smtp.gmail.com';
		$config['smtp_port']    = '465';
		$config['smtp_timeout'] = '7';
		$config['smtp_user']    = 'jvweedtest@gmail.com';
		$config['smtp_pass']    = 'Jvweedtest9!';
		$config['charset']    = 'iso-8859-1';
		$config['mailtype'] = 'text';
		$config['validation'] = TRUE;

		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");

		$body = "Hello " . $uname . ".\n\nThis email is to inform you that your Quota has expired.Future ratings woun't be recorded. SMS and Email servives are unavailable\nRenew your plan to keep using our services" . base_url('plan') . "\nIf you have any queries, send us an email at info@nktech.in.\n\nBest Regards,\nNKTECH\nhttps://nktech.in";
		$mail = $this->session->userdata('mr_email');

		$this->email->from('jvweedtest@gmail.com', 'Quota Limit');
		$this->email->to($uemail);
		$this->email->subject('Quota Limit');
		$this->email->message($body);

		if ($this->email->send()) {
			return true;
		} else {
			// return $this->email->print_debugger();
			return "Unable to send mail";
		}
	}

	public function contact()
	{
		$data['title'] = "contact us";

		$this->form_validation->set_rules('name', 'Full Name', 'required|trim|html_escape');
		$this->form_validation->set_rules('email', 'E-mail', 'required|trim|valid_email|html_escape');
		$this->form_validation->set_rules('msg', 'Message', 'required|trim|html_escape');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('templates/header', $data);
			$this->load->view('users/contact');
			$this->load->view('templates/footer');
		} else {
			$recaptchaResponse = trim($this->input->post('g-recaptcha-response'));
			$userIp = $this->input->ip_address();
			$secret = "xxxxxxxxxx";

			$url = "https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $recaptchaResponse . "&remoteip=" . $userIp;

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$output = curl_exec($ch);
			curl_close($ch);

			$status = json_decode($output, true);

			if ($status['success']) {
				$name = htmlentities($this->input->post('name'));
				$user_mail = htmlentities($this->input->post('email'));
				$bdy = htmlentities($this->input->post('msg'));
				// $mail_res = $this->support_mail($name, $user_mail, $bdy);
				$mail_res = true;
				if ($mail_res !== true) {
					$this->session->set_flashdata('invalid', 'Error sending your message');
					redirect($_SERVER['HTTP_REFERER']);
				} else {
					$res = $this->Usermodel->contact();
					$this->session->set_flashdata('valid', 'Message sent. We will get back to you as soon as possible');
					redirect($_SERVER['HTTP_REFERER']);
				}
			} else {
				$this->session->set_flashdata('invalid', 'Google Recaptcha Unsuccessfull');
				redirect($_SERVER['HTTP_REFERER']);
			}
		}
	}

	public function support_mail($name, $user_mail, $bdy)
	{
		$config['protocol']    = 'smtp';
		$config['smtp_host']    = 'ssl://smtp.gmail.com';
		$config['smtp_port']    = '465';
		$config['smtp_timeout'] = '7';
		$config['smtp_user']    = 'jvweedtest@gmail.com';
		$config['smtp_pass']    = 'Jvweedtest9!';
		$config['charset']    = 'iso-8859-1';
		$config['mailtype'] = 'text';
		$config['validation'] = TRUE;

		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");
		if ($user_mail) {
			$subj = "Support mail from " . $user_mail;
		} else if (!$user_mail) {
			$subj = "Support mail";
		}

		$this->email->from('jvweedtest@gmail.com', 'Rating');
		$this->email->to('olatayoefficient@gmail.com');
		$this->email->subject($subj);
		$this->email->message($bdy);

		if ($this->email->send()) {
			return true;
		} else {
			return $this->email->print_debugger();
		}
	}

	public function feedbacks()
	{
		$data['title'] = "feedbacks";

		if (!$this->session->userdata('mr_logged_in')) {
			$this->session->set_flashdata('invalid', 'Please login first');
			redirect('user/login');
		}
		if ($this->session->userdata('mr_admin') == "0") {
			$this->session->set_flashdata('acces_denied', 'Access Denied.');
			redirect('user');
		}
		$data['feedbacks'] = $this->Usermodel->get_feedbacks();
		$this->load->view('templates/header', $data);
		$this->load->view('users/feedbacks', $data);
		$this->load->view('templates/footer');
	}

	public function export_feedbacks()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->session->set_flashdata('invalid', 'Please login first');
			redirect('user/login');
		}
		if ($this->session->userdata('mr_admin') == "0") {
			$this->session->set_flashdata('acces_denied', 'Access Denied.');
			redirect('user');
		}
		header("Content-Type: text/csv; charset=utf-8");
		header("Content-Disposition: attachment; filename=feedbacks.csv");
		$output = fopen("php://output", "w");
		fputcsv($output, array('ID', 'Name', 'E-mail', 'Message'));
		$data = $this->Usermodel->export_feedbacks();
		foreach ($data as $row) {
			fputcsv($output, $row);
		}
		fclose($output);
	}
}
