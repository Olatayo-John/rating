<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
	public function index()
	{
		if ($this->session->userdata('mr_logged_in')) {
			redirect('user/profile');
		}
		if (!$this->session->userdata('mr_logged_in')) {
			$this->load->view('templates/header');
			$this->load->view('users/login');
			$this->load->view('templates/footer');
		}
	}

	public function login()
	{
		if ($this->session->userdata('mr_logged_in')) {
			redirect('user/rating');
		}
		$this->form_validation->set_rules('uname', 'Username', 'required|trim|html_escape');
		$this->form_validation->set_rules('pwd', 'Password', 'required|trim|html_escape');

		if ($this->form_validation->run() === FALSE) {
			$this->index();
		} else {
			$validate = $this->Usermodel->login();
			if ($validate == FALSE) {
				$this->session->set_flashdata('invalid_login', 'Username/Password is wrong');
				redirect('user');
			}
			if ($validate == "inactive") {
				$res_login = $this->Usermodel->login_get_key();
				if ($res_login) {
					$this->session->set_flashdata('inacc_acc', 'Your account is not verified');
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
				$sub = $validate->sub;
				$form_key = $validate->form_key;

				$user_sess = array(
					'mr_id' => $id,
					'mr_admin' => $admin,
					'mr_uname' => $uname,
					'mr_email' => $email,
					'mr_mobile' => $mobile,
					'mr_active' => $active,
					'mr_sub' => $sub,
					'mr_form_key' => $form_key,
					'mr_logged_in' => TRUE,
				);
				$this->session->set_userdata($user_sess);
				if ($this->session->userdata('mr_sub') == "0") {
					$this->session->set_flashdata('inacc_sub', 'You have no active subscription.');
					redirect('admin/pick_plan');
					exit();
				} elseif ($this->session->userdata('mr_sub') == "1") {
					// redirect('user/account');
					redirect('user/profile');
				}
			}
		}
	}

	public function logout()
	{
		$this->session->unset_userdata('mr_id');
		$this->session->unset_userdata('mr_mobile');
		$this->session->unset_userdata('mr_uname');
		$this->session->unset_userdata('mr_email');
		$this->session->unset_userdata('mr_active');
		$this->session->unset_userdata('mr_sub');
		$this->session->unset_userdata('mr_form_key');
		$this->session->unset_userdata('mr_logged_in');
		// $this->session->sess_destroy();

		$this->session->set_flashdata('log_out', 'Logged out');
		redirect('user');
	}

	public function check_duplicate_username()
	{
		$data['user_data'] = $this->Usermodel->check_duplicate_username($_POST['uname_val']);
		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	public function register()
	{
		if ($this->session->userdata('mr_logged_in')) {
			$this->session->set_flashdata('logout_first', 'Log out first.');
			redirect('user/rating');
		}
		$this->form_validation->set_rules('fname', 'First Name', 'trim|html_escape');
		$this->form_validation->set_rules('lname', 'Last Name', 'trim|html_escape');
		$this->form_validation->set_rules('email', 'E-mail', 'required|trim|valid_email|html_escape');
		$this->form_validation->set_rules('mobile', 'Mobile', 'required|trim|html_escape');
		$this->form_validation->set_rules('uname', 'Username', 'required|trim|html_escape');
		$this->form_validation->set_rules('pwd', 'Password', 'required|trim|html_escape');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('templates/header');
			$this->load->view('users/register');
			$this->load->view('templates/footer');
		} else {
			$act_key =  mt_rand(0, 1000000);
			$form_key =  htmlentities($this->input->post("uname")) . mt_rand(0, 100000);

			$email = htmlentities($this->input->post('email'));
			$uname = htmlentities($this->input->post('uname'));
			$link = base_url() . "user/emailverify/" . $form_key;

			$mail_res = $this->send_email_code($email, $uname, $act_key, $link);
			if ($mail_res !== TRUE) {
				$this->session->set_flashdata('email_code', $mail_res);
				redirect('user/register');
				exit();
			} else {
				$db_res = $this->Usermodel->register($act_key, $form_key);
				if ($db_res !== TRUE) {
					$this->session->set_flashdata('db_register_err', 'Error saving your details. Please try again');
					redirect('user/register');
					exit();
				} else {
					$this->session->set_flashdata('email_code', 'Verification code sent to you mail.');
					redirect('user/emailverify/' . $form_key);
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
			$this->session->set_flashdata('email_verify_err', 'Wrong credentials');
			redirect('user/login');
		} else {
			$active = $check_res->active;
			if ($active == '1') {
				$this->session->set_flashdata('email_verified', 'Your account is already verified.');
				redirect('user/login');
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
					$this->session->set_flashdata('email_verify_err', 'Invalid code');
					redirect('user/emailverify/' . $key);
				} elseif ($res == TRUE) {
					$this->session->set_flashdata('login_now', 'Your account is active. You can now log in');
					redirect('user/login');
				}
			}
		}
	}

	public function resendemailverify($key)
	{
		$check_res = $this->Usermodel->check_verification($key);
		if ($check_res == false) {
			$this->session->set_flashdata('email_verify_err', 'Wrong credentials');
			redirect($_SERVER['HTTP_REFERRER']);
		} else {
			$active = $check_res->active;
			if ($active == '1') {
				$this->session->set_flashdata('email_verified', 'Your account is already verified and active.');
				redirect('user/login');
			} else {
				$res = $this->Usermodel->check_verification($key);

				$email = $res->email;
				$uname = $res->uname;
				$link = base_url() . "user/emailverify/" . $res->form_key;
				$act_key =  mt_rand(0, 1000000);

				$res_update = $this->send_email_code($email, $uname, $act_key, $link);
				if ($res_update !== TRUE) {
					$this->session->set_flashdata('email_verify_resend_err', $res_update);
					redirect($link);
				} else {
					$this->Usermodel->code_verify_update($act_key, $key);
					$this->session->set_flashdata('email_verify_resend', 'Verification code sent to you mail.');
					redirect($_SERVER['HTTP_REFERER']);
				}
			}
		}
	}

	public function profile()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->session->set_flashdata('loginfirst', 'Please login first');
			redirect('user/login');
		}
		$data['user_info'] = $this->Usermodel->get_info();
		$data['websites'] = $this->Usermodel->get_user_websites();
		if (!$data) {
			$this->session->set_flashdata('loginfirst', 'Your account doesnt exist');
			$this->logout();
		} elseif ($data) {
			// print_r($data);
			// die;
			$this->load->view('templates/header');
			$this->load->view('users/edit', $data);
			$this->load->view('templates/footer');
		}
	}

	public function personal_edit()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->session->set_flashdata('loginfirst', 'Please login first');
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
				$this->session->set_flashdata('update_failed', 'Update Failed');
				redirect('user/profile');
			} else {
				$this->session->set_flashdata('update_succ', 'Updated');
				redirect('user/profile');
			}
		}
	}

	public function add_website()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->session->set_flashdata('loginfirst', 'Please login first');
			redirect('user/login');
		}
		$this->form_validation->set_rules('web_name', 'Website Name', 'required|trim|html_escape');
		$this->form_validation->set_rules('web_link', 'Website Link', 'required|trim|html_escape|valid_url');

		if ($this->form_validation->run() === FALSE) {
			$this->session->set_flashdata('update_failed', 'Invalid URL provided');
			redirect('user/profile');
		} else {
			$res = $this->Usermodel->add_website();
			if ($res !== TRUE) {
				$this->session->set_flashdata('update_failed', 'Failed to add website');
				redirect('user/profile');
			} else {
				$this->session->set_flashdata('update_succ', 'Website added!');
				redirect('user/profile');
			}
		}
	}

	public function edit_website()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->session->set_flashdata('loginfirst', 'Please login first');
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

	public function update_website()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->session->set_flashdata('loginfirst', 'Please login first');
			redirect('user/login');
		}
		$this->form_validation->set_rules('web_name_edit', 'Website Name', 'required|trim|html_escape');
		$this->form_validation->set_rules('web_link_edit', 'Website Link', 'required|trim|html_escape|valid_url');

		if ($this->form_validation->run() === FALSE) {
			$this->session->set_flashdata('update_failed', 'Invalid URL provided');
			redirect('user/profile');
		} else {
			$res = $this->Usermodel->update_website();
			if ($res !== TRUE) {
				$this->session->set_flashdata('update_failed', 'Failed to update');
				redirect('user/profile');
			} else {
				$this->session->set_flashdata('update_succ', 'Updated!');
				redirect('user/profile');
			}
		}
	}

	public function delete_website()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->session->set_flashdata('loginfirst', 'Please login first');
			redirect('user/login');
		}
		$act_res = $this->Usermodel->delete_website($_POST['id']);
		if ($act_res == false) {
			$this->session->set_flashdata('update_failed', 'Error deleting this data! Please try again');
		} else {
			$this->session->set_flashdata('update_succ', 'Data deleted successfully!');
		}
	}

	public function website_status()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->session->set_flashdata('loginfirst', 'Please login first');
			redirect('user/login');
		}
		$act_res = $this->Usermodel->website_status($_POST['id'], $_POST['status']);
		if ($act_res == false) {
			$this->session->set_flashdata('update_failed', 'Error changing website status');
		} else {
			$this->session->set_flashdata('update_succ', 'Status Updated!');
		}
	}

	public function account_edit()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->session->set_flashdata('loginfirst', 'Please login first');
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
				$this->session->set_flashdata('update_failed', 'Incorrect password provided');
				redirect($_SERVER['HTTP_REFERER']);
			} else {
				$this->session->set_flashdata('update_succ', 'Password changed');
				redirect($_SERVER['HTTP_REFERER']);
			}
		}
	}

	public function deact_account()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->session->set_flashdata('loginfirst', 'Please login first');
			redirect('user/login');
		}
		$act_res = $this->Usermodel->deact_account();
		if ($act_res == false) {
			$this->session->set_flashdata('update_failed', 'Error performing this operation');
		}
	}

	/* public function search_website()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->session->set_flashdata('loginfirst', 'Please login first');
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

	public function account()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->session->set_flashdata('loginfirst', 'Please login first');
			redirect('user');
		}
		$data['user'] = $this->Usermodel->user_total_ratings();
		$data['balance'] = $this->Usermodel->user_quota();
		//print_r($data['user']);die;
		//$data['all_sms']= $this->Usermodel->all_user_sms();
		//$data['all_email']= $this->Usermodel->all_user_email();
		//$data['sent_links']= $this->Usermodel->all_user_sent_links();
		$this->load->view('templates/header');
		$this->load->view('users/account', $data);
		$this->load->view('templates/footer');
	}

	public function rating()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->session->set_flashdata('loginfirst', 'Please login first');
			redirect('user');
		}
		if ($this->session->userdata('mr_sub') == "0") {
			$this->session->set_flashdata('inacc_sub', 'You have no active subscription.');
			redirect('admin/pick_plan');
		} else {
			$this->load->view('templates/header');
			$this->load->view('users/index');
			$this->load->view('templates/footer');
		}
	}

	public function get_link()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->session->set_flashdata('loginfirst', 'Please login first');
			redirect('user');
		}
		$res = $this->Usermodel->get_link($_POST['id']);
		if (!$res) {
			return FALSE;
			exit();
		}
		if ($res) {
			$output[] = array();
			$output['id'] = $res->id;
			$output['c_name'] = $res->c_name;
			$output['c_add'] = $res->c_add;
			$output['c_email'] = $res->c_email;
			$output['c_web'] = $res->c_web;
			$output['form_key'] = $res->form_key;
			$output['fb_link'] = $res->fb_link;
			$output['google_link'] = $res->google_link;
			$output['glassdoor_link'] = $res->glassdoor_link;
			$output['trust_pilot_link'] = $res->trust_pilot_link;
			$output['token'] = $this->security->get_csrf_hash();
			echo json_encode($output);
		}
		$myfile = fopen("body.txt", "w") or die("Unable to open file!");
		$txt = "Please find the link below to rate our website\n";
		fwrite($myfile, $txt);
		$link = $_POST['btnval'];
		if ($link == "mainweb") {
			$txt = base_url() . "user/official/" . $output['form_key'] . "\n\n";
			fwrite($myfile, $txt);
		}
		if ($link == "trust_pilot") {
			$txt = base_url() . "user/trustpilot/" . $output['form_key'] . "\n\n";
			fwrite($myfile, $txt);
		}
		if ($link == "glassdoor") {
			$txt = base_url() . "user/glassdoor/" . $output['form_key'] . "\n\n";
			fwrite($myfile, $txt);
		}
		if ($link == "facebook") {
			$txt = base_url() . "user/facebook/" . $output['form_key'] . "\n\n";
			fwrite($myfile, $txt);
		}
		if ($link == "google") {
			$txt = base_url() . "user/google/" . $output['form_key'] . "\n\n";
			fwrite($myfile, $txt);
		}
		$txt = $output['c_name'] . "\n";
		fwrite($myfile, $txt);
		$txt = $output['c_web'] . "\n";
		fwrite($myfile, $txt);
		$txt = $output['c_email'] . "\n";
		fwrite($myfile, $txt);
		$txt = $output['c_add'] . "\n";
		fwrite($myfile, $txt);
		$txt = "Regards";
		fwrite($myfile, $txt);
		fclose($myfile);
	}

	public function send_link()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->session->set_flashdata('loginfirst', 'Please login first');
			redirect('user');
		}
		if ($this->session->userdata('mr_sub') == "0") {
			$this->session->set_flashdata('inacc_sub', 'You have no active subscription.');
			redirect('admin/pick_plan');
		}
		$this->form_validation->set_rules('email', 'E-mail', 'required|trim|valid_email|html_escape');
		$this->form_validation->set_rules('subj', 'Subject', 'required|trim|html_escape');
		$this->form_validation->set_rules('bdy', 'Body', 'required|trim|html_escape');

		if ($this->form_validation->run() == FALSE) {
			$this->rating();
		} else {
			$cq_res = $this->Usermodel->check_user_quota();
			if ($cq_res == true) {
				$this->send_quota_expire_mail();
				$this->session->set_flashdata('quota_expired', 'Your Quota has expired. Please renew to continue using our services.');
				redirect('admin/pick_plan');
			} else {
				$email = $this->input->post('email');
				$subj = $this->input->post('subj');
				$bdy = $this->input->post('bdy');
				$mail_res = $this->link_send_mail($email, $subj, $bdy);
				if ($mail_res !== true) {
					$this->session->set_flashdata('link_send_err', $mail_res);
					redirect('user/rating');
				} else {
					$res = $this->Usermodel->save_info();
					if ($res !== true) {
						$this->session->set_flashdata('link_send_err', 'Error saving to DATABASE.');
						redirect('user/rating');
					} else {
						$this->session->set_flashdata('link_send_succ', 'Link sent successfully');
						redirect('user/rating');
					}
				}
			}
		}
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
			$this->session->set_flashdata('loginfirst', 'Please login first');
			redirect('user');
		}
		if ($this->session->userdata('mr_sub') == "0") {
			$this->session->set_flashdata('inacc_sub', 'You have no active subscription.');
			redirect('admin/pick_plan');
		}
		$cq_res = $this->Usermodel->check_user_quota();
		if ($cq_res == true) {
			$this->send_quota_expire_mail();
			$this->session->set_flashdata('quota_expired', 'Your Quota has expired. Please renew to continue using our services.');
			redirect('admin/pick_plan');
		} else {
			$emaildata = $_POST['emaildata'];
			$subj = $_POST['subj'];
			$bdy = $_POST['bdy'];
			$link_for = $_POST['link_for'];
			$num = count($emaildata);

			$qbl_res = $this->Usermodel->user_quota_details();
			if ($qbl_res->bal < $num) {
				$this->session->set_flashdata('small_bal_length', 'Number of emails to be sent exceeds your remaining quota point of ' . $qbl_res->bal . ' .');
			} else {
				$mail_res = $this->send_multiple_link_email($emaildata, $subj, $bdy);
				if ($mail_res !== true) {
					$this->session->set_flashdata('link_send_err', $mail_res);
				} else {
					$res = $this->Usermodel->multiplemail_save_info($_POST['emaildata'], $_POST['subj'], $_POST['bdy'], $_POST['link_for']);
					if ($res !== true) {
						$this->session->set_flashdata('link_send_err', 'Error saving to DATABASE.');
					} else {
						$length = count($emaildata);
						$cq_res = $this->Usermodel->user_quota_update($length);
						$this->session->set_flashdata('link_send_succ', 'Link sent successfully');
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

		$body = "Hello.\n\nThis email is to inform you that your Quota has expired.SMS, Emails and Future ratings woun't be recorded\nClick here to log into your account and get a new plan " . base_url('admin/pick_plan') . "\nIf you have any questions, send us an email at info@nktech.in.\n\nBest Regards,\nNKTECH\nhttps://nktech.in";
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

	public function total_bar_data()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->session->set_flashdata('login_first', 'Please login first');
			redirect('user');
			exit();
		}
		$data['atr'] = $this->Adminmodel->all_total_ratings();
		$data['tr5'] = $this->Adminmodel->tr5_total_ratings();
		$data['tr4'] = $this->Adminmodel->tr4_total_ratings();
		$data['tr3'] = $this->Adminmodel->tr3_total_ratings();
		$data['tr2'] = $this->Adminmodel->tr2_total_ratings();
		$data['tr1'] = $this->Adminmodel->tr1_total_ratings();
		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	public function bar_data()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->session->set_flashdata('login_first', 'Please login first');
			redirect('user');
			exit();
		}
		$data['utl'] = $this->Usermodel->user_total_ratings();
		$data['fb'] = $this->Usermodel->fb_data();
		$data['fb_1'] = $this->Usermodel->fb_data1();
		$data['fb_2'] = $this->Usermodel->fb_data2();
		$data['fb_3'] = $this->Usermodel->fb_data3();
		$data['fb_4'] = $this->Usermodel->fb_data4();
		$data['fb_5'] = $this->Usermodel->fb_data5();
		$data['g'] = $this->Usermodel->g_data();
		$data['g_1'] = $this->Usermodel->g_data1();
		$data['g_2'] = $this->Usermodel->g_data2();
		$data['g_3'] = $this->Usermodel->g_data3();
		$data['g_4'] = $this->Usermodel->g_data4();
		$data['g_5'] = $this->Usermodel->g_data5();
		$data['ow'] = $this->Usermodel->ow_data();
		$data['ow_1'] = $this->Usermodel->ow_data1();
		$data['ow_2'] = $this->Usermodel->ow_data2();
		$data['ow_3'] = $this->Usermodel->ow_data3();
		$data['ow_4'] = $this->Usermodel->ow_data4();
		$data['ow_5'] = $this->Usermodel->ow_data5();
		$data['tp'] = $this->Usermodel->tp_data();
		$data['tp_1'] = $this->Usermodel->tp_data1();
		$data['tp_2'] = $this->Usermodel->tp_data2();
		$data['tp_3'] = $this->Usermodel->tp_data3();
		$data['tp_4'] = $this->Usermodel->tp_data4();
		$data['tp_5'] = $this->Usermodel->tp_data5();
		$data['gd'] = $this->Usermodel->gd_data();
		$data['gd_1'] = $this->Usermodel->gd_data1();
		$data['gd_2'] = $this->Usermodel->gd_data2();
		$data['gd_3'] = $this->Usermodel->gd_data3();
		$data['gd_4'] = $this->Usermodel->gd_data4();
		$data['gd_5'] = $this->Usermodel->gd_data5();
		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
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

	public function official($key)
	{
		if (!$key) {
			redirect($_SERVER['HTTP_REFERER']);
			exit();
		} else {
			$form_key = $this->get_key($key);
			if ($form_key !== $key) {
				redirect($_SERVER['HTTP_REFERER']);
				exit();
			} elseif ($form_key == $key) {
				//$data['info']= $this->Usermodel->info($key);
				$data['form_key'] = $form_key;
				$this->load->view('pages/official', $data);
				$this->load->view('templates/footer');
			}
		}
	}

	public function facebook($key)
	{
		if (!$key) {
			redirect($_SERVER['HTTP_REFERER']);
			exit();
		} else {
			$form_key = $this->get_key($key);
			if ($form_key !== $key) {
				redirect($_SERVER['HTTP_REFERER']);
				exit();
			} elseif ($form_key == $key) {
				$data['info'] = $this->Usermodel->info($key);
				$data['form_key'] = $form_key;
				$this->load->view('pages/facebook', $data);
				$this->load->view('templates/footer');
			}
		}
	}

	public function google($key)
	{
		if (!$key) {
			redirect($_SERVER['HTTP_REFERER']);
			exit();
		} else {
			$form_key = $this->get_key($key);
			if ($form_key !== $key) {
				redirect($_SERVER['HTTP_REFERER']);
				exit();
			} elseif ($form_key == $key) {
				$data['info'] = $this->Usermodel->info($key);
				$data['form_key'] = $form_key;
				$this->load->view('pages/google', $data);
				$this->load->view('templates/footer');
			}
		}
	}

	public function glassdoor($key)
	{
		if (!$key) {
			redirect($_SERVER['HTTP_REFERER']);
			exit();
		} else {
			$form_key = $this->get_key($key);
			if ($form_key !== $key) {
				redirect($_SERVER['HTTP_REFERER']);
				exit();
			} elseif ($form_key == $key) {
				$data['info'] = $this->Usermodel->info($key);
				$data['form_key'] = $form_key;
				$this->load->view('pages/glassdoor', $data);
				$this->load->view('templates/footer');
			}
		}
	}

	public function trustpilot($key)
	{
		if (!$key) {
			redirect($_SERVER['HTTP_REFERER']);
			exit();
		} else {
			$form_key = $this->get_key($key);
			if ($form_key !== $key) {
				redirect($_SERVER['HTTP_REFERER']);
				exit();
			} elseif ($form_key == $key) {
				$data['info'] = $this->Usermodel->info($key);
				$data['form_key'] = $form_key;
				$this->load->view('pages/trustpilot', $data);
				$this->load->view('templates/footer');
			}
		}
	}

	public function rating_store()
	{
		$cq_res = $this->Usermodel->check_quota_expire($_POST['form_key']);
		if ($cq_res == true) {
			//$this->send_quota_expire_mail();
			return false;
		} else {
			$res = $this->Usermodel->rating_store($_POST['starv'], $_POST['msg'], $_POST['name'], $_POST['mobile'], $_POST['tbl_name'], $_POST['form_key'], $_POST['for_link']);
			if ($res) {
				$output = array(
					'official' => $res->c_web,
					'facebook' => $res->fb_link,
					'google' => $res->google_link,
					'gd' => $res->glassdoor_link,
					'tp' => $res->trust_pilot_link,
				);
				echo json_encode($output);
			} else {
				return true;
			}
		}
	}

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

		$body = "Hello.\n\nThis email is to inform you that your Quota Limit has expired.\nNew ratings woun't be recorded\nClick here to login to your account to renew for a new plan " . base_url() . "\nIf you have any questions, send us an email at info@nktech.in.\n\nBest Regards,\nNKTECH\nhttps://nktech.in";

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

	public function contact()
	{
		$this->form_validation->set_rules('name', 'Full Name', 'required|trim|html_escape');
		$this->form_validation->set_rules('email', 'E-mail', 'trim|valid_email|html_escape');
		$this->form_validation->set_rules('msg', 'Message', 'required|trim|html_escape');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('templates/header');
			$this->load->view('users/contact');
			$this->load->view('templates/footer');
		} else {
			$name = htmlentities($this->input->post('name'));
			$user_mail = htmlentities($this->input->post('email'));
			$bdy = htmlentities($this->input->post('msg'));
			$mail_res = $this->support_mail($name, $user_mail, $bdy);
			if ($mail_res !== true) {
				$this->session->set_flashdata('cntc_us_err', 'Error sending your message');
				redirect($_SERVER['HTTP_REFERER']);
			} else {
				$this->session->set_flashdata('cntc_us_succ', 'Message sent. We will get back to you as soon as possible');
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




	public function getlink()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->session->set_flashdata('loginfirst', 'Please login first');
			redirect('user');
		}
		$res = $this->Usermodel->get_link($_POST['id']);
		if (!$res) {
			return FALSE;
			exit();
		}
		if ($res) {
			$output[] = array();
			$output['id'] = $res->id;
			$output['c_name'] = $res->c_name;
			$output['c_add'] = $res->c_add;
			$output['c_email'] = $res->c_email;
			$output['c_web'] = $res->c_web;
			$output['form_key'] = $res->form_key;
			$output['fb_link'] = $res->fb_link;
			$output['google_link'] = $res->google_link;
			$output['glassdoor_link'] = $res->glassdoor_link;
			$output['trust_pilot_link'] = $res->trust_pilot_link;
			$output['token'] = $this->security->get_csrf_hash();
			echo json_encode($output);
		}
		$myfile = fopen("body.txt", "w") or die("Unable to open file!");
		$txt = "Click the link below, to rate any of our websites\n";
		fwrite($myfile, $txt);
		$txt = base_url() . "user/wtr/" . $output['form_key'] . "\n\n";
		fwrite($myfile, $txt);
		$txt = $output['c_name'] . "\n";
		fwrite($myfile, $txt);
		$txt = $output['c_email'] . "\n";
		fwrite($myfile, $txt);
		$txt = "Regards";
		fwrite($myfile, $txt);
		fclose($myfile);
	}

	public function sendlink()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->session->set_flashdata('loginfirst', 'Please login first');
			redirect('user');
		}
		if ($this->session->userdata('mr_sub') == "0") {
			$this->session->set_flashdata('inacc_sub', 'You have no active subscription.');
			redirect('admin/pick_plan');
		}
		$this->form_validation->set_rules('email', 'E-mail', 'required|trim|valid_email|html_escape');
		$this->form_validation->set_rules('subj', 'Subject', 'required|trim|html_escape');
		$this->form_validation->set_rules('bdy', 'Body', 'required|trim|html_escape');

		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header');
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
				$this->session->set_flashdata('quota_expired', 'Quota has expired');
				redirect('admin/pick_plan');
			} else {
				$email = $this->input->post('email');
				$subj = $this->input->post('subj');
				$bdy = $this->input->post('bdy');
				$mail_res = $this->link_send_mail($email, $subj, $bdy);
				if ($mail_res !== true) {
					$this->session->set_flashdata('link_send_err', $mail_res);
					redirect($_SERVER['HTTP_REFERER']);
					exit;
				} else {
					$res = $this->Usermodel->save_info();
					if ($res !== true) {
						$this->session->set_flashdata('link_send_err', 'Error saving contacts to DATABASE.');
						redirect($_SERVER['HTTP_REFERER']);
						exit;
					} else {
						$cq_res = $this->Adminmodel->check_quota_expire();
						if ($cq_res !== false) {
							$db_email = $cq_res->email;
							$this->quota_send_mail_expire($db_email);
							$this->session->set_flashdata('link_send_succ', 'Link sent successfully');
							redirect($_SERVER['HTTP_REFERER']);
							exit;
						} else {
							$this->session->set_flashdata('link_send_succ', 'Link sent successfully');
							redirect($_SERVER['HTTP_REFERER']);
							exit;
						}
					}
				}
			}
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

	public function sms_send_link()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->session->set_flashdata('loginfirst', 'Please login first');
			redirect('user');
		}
		if ($this->session->userdata('mr_sub') == "0") {
			$this->session->set_flashdata('inacc_sub', 'You have no active subscription.');
			redirect('admin/pick_plan');
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
				$this->session->set_flashdata('quota_expired', 'Quota has expired');
				redirect('admin/pick_plan');
			} else {
				$mobile = $this->input->post('mobile');
				$bdy = $this->input->post('smsbdy');

				$url = "http://onextelbulksms.in/shn/api/pushsms.php?usr=621665&key=010BrbJ20v1c2eCc8LGih6RlTIGqKN&sndr=KARUNJ&ph=+91" . $mobile . "&text=";
				$req = curl_init();
				$complete_url = $url . curl_escape($req, $bdy) . "&rpt=1";
				curl_setopt($req, CURLOPT_URL, $complete_url);
				$result = curl_exec($req);

				if ($result == false) {
					$this->session->set_flashdata('sms_link_send_err', 'Error sending SMS');
					redirect($_SERVER["HTTP_REFERER"]);
					exit;
				} else {
					$res = $this->Usermodel->sms_save_info();
					if ($res !== true) {
						$this->session->set_flashdata('link_send_err', 'Error saving contacts to DATABASE.');
						redirect($_SERVER["HTTP_REFERER"]);
						exit;
					} else {
						$cq_res = $this->Adminmodel->check_quota_expire();
						if ($cq_res !== false) {
							$db_email = $cq_res->email;
							$this->quota_send_mail_expire($db_email);
							$this->session->set_flashdata('sms_link_send_succ', 'SMS sent successfully');
							redirect($_SERVER["HTTP_REFERER"]);
							exit;
						} else {
							$this->session->set_flashdata('sms_link_send_succ', 'SMS sent successfully');
							redirect($_SERVER["HTTP_REFERER"]);
							exit;
						}
					}
				}
				curl_close($req);
			}
		}
	}

	public function multiple_sms_send_link()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->session->set_flashdata('loginfirst', 'Please login first');
			redirect('user');
		}
		if ($this->session->userdata('mr_sub') == "0") {
			$this->session->set_flashdata('inacc_sub', 'You have no active subscription.');
			redirect('admin/pick_plan');
		}
		$cq_res = $this->Adminmodel->check_quota_expire();
		if ($cq_res !== false) {
			$db_email = $cq_res->email;
			$this->send_quota_expire_mail();
			$this->session->set_flashdata('quota_expired', 'Your Quota has expired. Please renew to continue using our services.');
			redirect('admin/pick_plan');
		} else {
			$mobiledata = $_POST['mobiledata'];
			$smsbdy = $_POST['smsbdy'];
			$num = count($mobiledata);
			$qbl_res = $this->Usermodel->user_quota_details();
			if ($qbl_res->bal < $num) {
				$this->session->set_flashdata('small_bal_length', 'Number of sms to be sent exceeds your remaining quota point of ' . $qbl_res->bal . ' .');
			} else {
				$url = "http://onextelbulksms.in/shn/api/pushsms.php?usr=621665&key=010BrbJ20v1c2eCc8LGih6RlTIGqKN&sndr=KARUNJ&ph=" . implode(",", $mobiledata) . "&text=";
				$req = curl_init();
				$complete_url = $url . curl_escape($req, $smsbdy) . "&rpt=1";
				curl_setopt($req, CURLOPT_URL, $complete_url);
				$result = curl_exec($req);

				if ($result === false) {
					$this->session->set_flashdata('sms_link_send_err', 'Error sending SMS');
				} else {
					$res = $this->Usermodel->multiplsms_save_info($_POST['mobiledata'], $_POST['smsbdy'], $_POST['link_for']);
					if ($res !== true) {
						$this->session->set_flashdata('link_send_err', 'Error saving contacts to DATABASE.');
					} else {
						$cq_res = $this->Adminmodel->check_quota_expire();
						if ($cq_res !== false) {
							$usermail_expire = $cq_res->email;
							$this->quota_send_mail_expire($usermail_expire);
							$this->session->set_flashdata('sms_link_send_succ', 'SMS sent successfully');
						} else {
							$this->session->set_flashdata('sms_link_send_succ', 'SMS sent successfully');
						}
					}
				}
				curl_close($req);
			}
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
				redirect(base_url());
				exit();
			} elseif ($form_key == $key) {
				$data['form_key'] = $form_key;
				$this->load->view('users/rate_option', $data);
			}
		}
	}
}
