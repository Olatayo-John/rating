<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends User_Controller
{
	public function index()
	{
		if ($this->session->userdata('mr_logged_in')) {
			if ($this->session->userdata('mr_website_form') === "0") {
				redirect('websites');
			} else {
				redirect('share');
			}
		} else {
			redirect('login');
		}
	}

	//login function
	public function login()
	{
		if ($this->session->userdata('mr_logged_in')) {
			redirect('/');
		}

		$this->setTabUrl($mod = 'login');

		$data['title'] = "login";

		$this->form_validation->set_rules('uname', 'Username', 'required|trim|html_escape');
		$this->form_validation->set_rules('pwd', 'Password', 'required|trim|html_escape');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/login');
			$this->load->view('templates/footer');
		} else {
			$validate = $this->Usermodel->login();
			if ($validate == FALSE) {
				$this->Logmodel->log_act($type = "login_false");
				$this->session->set_flashdata('invalid', 'Username or Password provided is wrong!');
				redirect('user');
			}
			if ($validate == "inactive_access_by_cmpyAdmin") {
				$this->Logmodel->log_act($type = "inactive_access");
				$this->session->set_flashdata('invalid', 'Your account has been de-activated. Please Contact your Company Admin');
				redirect('/');
			}
			if ($validate == "inactive_access") {
				$this->Logmodel->log_act($type = "inactive_access");
				$this->session->set_flashdata('invalid', 'Your account has been de-activated. Please Contact support');
				redirect('/');
			}
			if ($validate == "inactive") {
				$this->Logmodel->log_act($type = "inactive");
				$res_login = $this->Usermodel->login_get_key();
				if ($res_login) {
					$this->session->set_flashdata('invalid', 'Your account is not verified');
					redirect('user/emailverify/' . $res_login);
				}
			}
			//if valid, create sessions via user details
			if ($validate) {
				$id = $validate->id;
				$sadmin = $validate->sadmin;
				$admin = $validate->admin;
				$iscmpy = $validate->iscmpy;
				$cmpyid = $validate->cmpyid;
				$cmpy = $validate->cmpy;
				$sub = $validate->sub;
				$uname = $validate->uname;
				$email = $validate->email;
				$mobile = $validate->mobile;
				$website_form = $validate->website_form;
				$form_key = $validate->form_key;

				$user_sess = array(
					'mr_id' => $id,
					'mr_sadmin' => $sadmin,
					'mr_admin' => $admin,
					'mr_iscmpy' => $iscmpy,
					'mr_cmpyid' => $cmpyid,
					'mr_cmpy' => $cmpy,
					'mr_sub' => $sub,
					'mr_uname' => $uname,
					'mr_email' => $email,
					'mr_mobile' => $mobile,
					'mr_website_form' => $website_form,
					'mr_form_key' => $form_key,
					'mr_logged_in' => TRUE,
				);
				$this->session->set_userdata($user_sess);

				$this->Usermodel->user_latestact();
				$this->Logmodel->log_act($type = "login");

				redirect('/');
			}
		}
	}

	//check if username exist when registering
	public function check_duplicate_username()
	{
		$data['user_data'] = $this->Usermodel->check_duplicate_username(htmlentities($_POST['uname_val']));

		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	//check if company name exist when registering
	public function check_duplicatecmpy()
	{
		$data['user_data'] = $this->Usermodel->check_duplicatecmpy(htmlentities($_POST['cmpy_val']));

		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	//reister function
	public function register()
	{
		$data['title'] = "register";

		if ($this->session->userdata('mr_logged_in')) {
			$this->session->set_flashdata('invalid', 'Log out first.');
			redirect('/');
		}

		$this->setTabUrl($mod = 'register');

		//validate input forms
		$this->form_validation->set_rules('fname', 'First Name', 'trim|html_escape');
		$this->form_validation->set_rules('lname', 'Last Name', 'trim|html_escape');
		$this->form_validation->set_rules('email', 'E-mail', 'required|trim|valid_email|html_escape');
		$this->form_validation->set_rules('mobile', 'Mobile', 'required|trim|exact_length[10]|html_escape');
		$this->form_validation->set_rules('uname', 'Username', 'required|trim|html_escape|is_unique[users.uname]', array('is_unique' => 'This username is taken'));
		$this->form_validation->set_rules('pwd', 'Password', 'required|trim|html_escape');
		$this->form_validation->set_rules('sms_quota', 'Quota', 'required|trim|html_escape');
		$this->form_validation->set_rules('email_quota', 'Quota', 'required|trim|html_escape');
		$this->form_validation->set_rules('whatsapp_quota', 'Quota', 'trim|html_escape');
		$this->form_validation->set_rules('web_quota', 'Quota', 'trim|html_escape');
		$this->form_validation->set_rules('cmpy', 'Company Name', 'trim|html_escape|is_unique[users.cmpy]', array('is_unique' => 'This Company already exist'));

		if ($this->form_validation->run() === false) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/register');
			$this->load->view('templates/footer');
		} else {
			$uname = htmlentities($this->input->post('uname'));
			$uname_form = str_replace([" ", ".", ",", "?", "&"], "_", strtolower(substr($uname, 0, 5)));
			$pwd = $this->input->post('pwd');
			$email = htmlentities($this->input->post('email'));

			$act_key =  mt_rand(0, 1000000);
			$form_key =  $uname_form . mt_rand(0, 100000);
			$link = base_url() . "emailverify/" . $form_key;

			//try sending email before inserting to DB
			$this->load->library('emailconfig');
			$mail_res = $this->emailconfig->send_email_code($email, $uname, $act_key, $link);

			if ($mail_res !== TRUE) {
				$this->Logmodel->log_act($type = "newUser_verify_mail_err", $m = "User", $e = $mail_res);
				$this->session->set_flashdata('invalid', $mail_res);
				redirect('register');
				exit();
			} else {
				// for default users who are not a company
				$admin = $iscmpy = 0;

				if (isset($_POST['cmpychkb'])) {
					$admin = $iscmpy = 1;
				}

				//save in DB
				$db_res = $this->Usermodel->register($admin, $iscmpy, $act_key, $form_key);

				if ($db_res !== TRUE) {
					$this->Logmodel->log_act($type = "db_err");
					$this->session->set_flashdata('invalid', 'Error saving your details. Please try again');
					redirect('register');
					exit();
				} else {
					$this->Logmodel->log_act($type = "newuser");
					$this->session->set_flashdata('valid', 'Verification code sent to your mail.');
					redirect('emailverify/' . $form_key);
					exit();
				}
			}
		}
	}

	//email verification after registration
	public function emailverify($key)
	{
		$data['title'] = "Email Verification";

		$check_res = $this->Usermodel->check_verification($key);
		if ($check_res == false) {
			$this->session->set_flashdata('invalid', 'Wrong credentials');
			redirect('login');
		} else {
			$active = $check_res->active;
			if ($active == '1') {
				$this->session->set_flashdata('valid', 'Your account is verified.');
				redirect('login');
			}
			$this->form_validation->set_rules('sentcode', 'Verification Code', 'required|trim|html_escape');
			if ($this->form_validation->run() == false) {
				$data['key'] = $key;
				$data['email'] = $check_res->email;
				$this->load->view('templates/header', $data);
				$this->load->view('templates/emailverify', $data);
				$this->load->view('templates/footer');
			} else {
				$validate = $this->Usermodel->emailverify($key);
				if ($validate == false) {
					$this->session->set_flashdata('invalid', 'Invalid code');
					redirect('emailverify/' . $key);
				} else {
					if ($validate->active !== "1") {
						$this->session->set_flashdata('invalid', 'Error activating your account. Please try again');
						redirect('emailverify/' . $key);
					} else if ($validate->active == "1") {
						$id = $validate->id;
						$sadmin = $validate->sadmin;
						$admin = $validate->admin;
						$iscmpy = $validate->iscmpy;
						$cmpyid = $validate->cmpyid;
						$cmpy = $validate->cmpy;
						$sub = $validate->sub;
						$uname = $validate->uname;
						$email = $validate->email;
						$mobile = $validate->mobile;
						$website_form = $validate->website_form;
						$form_key = $validate->form_key;

						$user_sess = array(
							'mr_id' => $id,
							'mr_sadmin' => $sadmin,
							'mr_admin' => $admin,
							'mr_iscmpy' => $iscmpy,
							'mr_cmpyid' => $cmpyid,
							'mr_cmpy' => $cmpy,
							'mr_sub' => $sub,
							'mr_uname' => $uname,
							'mr_email' => $email,
							'mr_mobile' => $mobile,
							'mr_website_form' => $website_form,
							'mr_form_key' => $form_key,
							'mr_logged_in' => TRUE,
						);
						$this->session->set_userdata($user_sess);
						$this->Logmodel->log_act($type = "acctverified");
						$this->session->set_flashdata('valid', 'Your account is active');
						redirect('websites');
					}
				}
			}
		}
	}

	//resend verification email
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

				$this->load->library('emailconfig');
				$mail_res = $this->emailconfig->send_email_code($email, $uname, $act_key, $link);

				if ($mail_res !== TRUE) {
					$this->Logmodel->log_act($type = "newUser_verify_mail_err", $m = "User", $e = $mail_res);
					$this->session->set_flashdata('invalid', $mail_res);
					redirect($link);
				} else {
					$this->Usermodel->code_verify_update($act_key, $key);
					$this->session->set_flashdata('valid', 'Verification code sent to you mail.');
					redirect($_SERVER['HTTP_REFERER']);
				}
			}
		}
	}

	//user can creat n number of websites according to their packages
	//this is done after registration
	public function websites()
	{
		$data['title'] = "add websites";

		$this->checklogin();

		if ($this->session->userdata('mr_website_form') == "1") {
			redirect('/');
		}

		$data['webs'] = $this->Usermodel->get_user_websites();
		$webcount = $data['webs']->num_rows();

		if ($webcount > 0) {
			$this->Usermodel->update_webform();
			redirect("/");
		} else {
			$this->load->view('templates/header', $data);
			$this->load->view('users/websites', $data);
			$this->load->view('templates/footer');
		}
	}

	public function get_userQuota()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$data['status'] = false;
			$data['redirect'] = base_url("logout");
			echo json_encode($data);
			exit;
		}

		$res = $this->Usermodel->get_userQuota();
		// $res = false;
		if ($res) {
			$data['status'] = true;
			$data['userQuota'] = $res;
		}

		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	public function addwebsite()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$data['status'] = 'error';
			$data['redirect'] = base_url("logout");

			$data['token'] = $this->security->get_csrf_hash();
			echo json_encode($data);
			exit;
		}
		if ($this->session->userdata('mr_website_form') == "1") {
			$data['status'] = 'error';
			$data['redirect'] = base_url("/");

			$data['token'] = $this->security->get_csrf_hash();
			echo json_encode($data);
			exit;
		}

		$web_name_new = $_POST['web_name'];
		$web_link_new = $_POST['web_link'];

		$res = $this->Usermodel->createwebsite($web_name_new, $web_link_new);
		if (gettype($res) === "string") {
			$this->Logmodel->log_act($type = "websitenewerr");
			$data['status'] = false;
			$data['msg'] = $res;
		} else if (gettype($res) === "integer") {
			$this->Logmodel->log_act($type = "websitenew");
			$data['status'] = true;
			$data['msg'] = "Website created";
			$data['webID'] = $res;
		}

		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	public function removewebsite()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$data['status'] = false;
			$data['redirect'] = base_url("logout");
			echo json_encode($data);
			exit;
		}
		if ($this->session->userdata('mr_website_form') == "1") {
			$data['status'] = false;
			$data['redirect'] = base_url("/");
			echo json_encode($data);
			exit;
		}

		$res = $this->Usermodel->removewebsite($_POST['web_name'], $_POST['web_link'], $_POST['web_id']);

		if ($res !== true) {
			$this->Logmodel->log_act($type = "webdelerr");

			$data['status'] = "error";
			$data['redirect'] = "";
			$data['msg'] = 'Error removing this website';
		} else {
			$this->Logmodel->log_act($type = "webdel");

			$data['status'] = true;
			$data['redirect'] = "";
			$data['msg'] = 'Website Removed';
		}

		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	//
	public function account()
	{
		$this->checklogin();

		$this->setTabUrl($mod = 'account');

		$data['title'] = "account";

		$data['user_info'] = $this->Usermodel->get_info();
		$data['websites'] = $this->Usermodel->get_user_websites();
		$data['quota'] = $this->Usermodel->get_userQuota();

		$this->load->view('templates/header', $data);
		$this->load->view('users/account_view', $data);
		$this->load->view('templates/footer');
	}

	public function account_edit()
	{
		$this->checklogin();

		$this->setTabUrl($mod = 'account');

		$data['title'] = "edit account";

		$data['user_info'] = $this->Usermodel->get_info();
		$data['websites'] = $this->Usermodel->get_user_websites();
		$data['quota'] = $this->Usermodel->get_userQuota();

		$this->load->view('templates/header', $data);
		$this->load->view('users/account_edit', $data);
		$this->load->view('templates/footer');
	}

	public function personal_edit()
	{
		$this->checklogin();

		$this->setTabUrl($mod = 'account');

		$data['title'] = "edit account";

		$data['user_info'] = $this->Usermodel->get_info();
		$data['websites'] = $this->Usermodel->get_user_websites();
		$data['quota'] = $this->Usermodel->get_userQuota();

		// $this->form_validation->set_rules('uname', 'Username', 'required|trim|html_escape');
		$this->form_validation->set_rules('fname', 'First Name', 'trim|html_escape');
		$this->form_validation->set_rules('lname', 'Last Name', 'trim|html_escape');
		$this->form_validation->set_rules('email', 'E-mail', 'required|trim|valid_email|html_escape');
		$this->form_validation->set_rules('mobile', 'Mobile', 'required|trim|exact_length[10]|html_escape');
		$this->form_validation->set_rules('gender', 'Gender', 'trim|html_escape');
		$this->form_validation->set_rules('dob', 'Date Of Birth', 'trim|html_escape');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('templates/header', $data);
			$this->load->view('users/account_edit', $data);
			$this->load->view('templates/footer');
		} else {
			$res = $this->Usermodel->personal_edit();
			if ($res !== TRUE) {
				$this->Logmodel->log_act($type = "prfileerr");
				$this->session->set_flashdata('invalid', 'Update Failed');
			} else {
				$this->Logmodel->log_act($type = "prfile");
				$this->session->set_flashdata('valid', 'Profile Updated');

				$this->session->set_userdata('mr_email', htmlentities($this->input->post('email')));
			}

			redirect('account');
		}
	}

	//check duplicate webName
	public function check_duplicate_webname()
	{
		$data['webdata'] = $this->Usermodel->check_duplicate_webname($_POST['webname']);
		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	//check duplicate webLink
	public function check_duplicate_weblink()
	{
		$data['webdata'] = $this->Usermodel->check_duplicate_weblink($_POST['weblink']);
		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	//add new web
	public function createwebsite()
	{
		if ($this->ajax_checklogin() === false) {
			$data['status'] = "error";
			$data['redirect'] = base_url("logout");
		} else {
			//check postdata
			if ($_POST['web_name_new'] && $_POST['web_link_new']) {
				$web_name_new = $_POST['web_name_new'];
				$web_link_new = $_POST['web_link_new'];

				$res = $this->Usermodel->createwebsite($web_name_new, $web_link_new);
				if (gettype($res) === "string") {
					$this->Logmodel->log_act($type = "webnewerr");
					$data['status'] = false;
					$data['msg'] = $res;
				} else if (gettype($res) === "integer") {
					$this->Logmodel->log_act($type = "webnew");
					$data['status'] = true;
					$data['msg'] = "Website created";
					$data['insert_id'] = $res;
				}
			} else {
				$data['status'] = false;
				$data['msg'] = "Missing parameters";
			}
		}

		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	// function not included
	public function delete_website()
	{
		$act_res = $this->Usermodel->delete_website($_POST['id']);
		if ($act_res == false) {
			$this->Logmodel->log_act($type = "webdel");
			$this->session->set_flashdata('invalid', 'Error deleting this data! Please try again');
		} else {
			$this->Logmodel->log_act($type = "webdelerr");
			$this->session->set_flashdata('valid', 'Data deleted successfully!');
		}
	}
	////

	public function edit_website()
	{
		//check login
		if ($this->ajax_checklogin() === false) {
			$data['status'] = "error";
			$data['redirect'] = base_url("logout");
		} else {
			//check postdata
			if ($_POST['id']) {
				$act_res = $this->Usermodel->edit_website($_POST['id']);
				if ($act_res == false) {
					$this->Logmodel->log_act($type = "webstatuserr");
					$data['status'] = false;
					$data['msg'] = "Error retrieving data";
				} else {
					$data['status'] = true;
					$data['act_res'] = $act_res;
				}
			} else {
				$data['status'] = false;
				$data['msg'] = "Missing parameters";
			}
		}

		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	//change web status [true,false]
	public function website_update()
	{
		if ($this->ajax_checklogin() === false) {
			$data['status'] = "error";
			$data['redirect'] = base_url("logout");
		} else {
			$webstatusArr = array('0', '1');
			if ($_POST['id'] && in_array($_POST['webstatus'], $webstatusArr)) {
				$wb = $_POST['webstatus'];

				$act_res = $this->Usermodel->website_update($_POST['id'], $_POST['webstatus']);

				if ($act_res == false) {
					$this->Logmodel->log_act($type = "webstatuserr");
					$data['status'] = false;
					$data['msg'] = ($wb == 0) ? "Error de-activating this website" : "Error activating this website";
				} else {
					$this->Logmodel->log_act($type = "webstatus");
					$data['status'] = true;
					$data['msg'] = ($wb == 0) ? "Website de-activated!" : "Website is active!";
				}
			} else {
				$data['status'] = false;
				$data['msg'] = "Missing parameters";
			}
		}

		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	public function password_update()
	{
		$this->checklogin();

		$data['title'] = "edit account";
		$data['user_info'] = $this->Usermodel->get_info();
		$data['websites'] = $this->Usermodel->get_user_websites();
		$data['quota'] = $this->Usermodel->get_userQuota();

		$this->form_validation->set_rules('c_pwd', 'Current Password', 'required|trim');
		$this->form_validation->set_rules('n_pwd', 'New Password', 'required|trim|min_length[6]');
		$this->form_validation->set_rules('rtn_pwd', 'Re-type Password', 'required|trim|min_length[6]|matches[n_pwd]');

		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $data);
			$this->load->view('users/account_edit', $data);
			$this->load->view('templates/footer');
		} else {
			$pwd_res = $this->Usermodel->check_pwd();
			if ($pwd_res == false) {
				$this->Logmodel->log_act($type = "userpwderr");
				$this->session->set_flashdata('invalid', 'Incorrect password provided');
			} else {
				$this->Logmodel->log_act($type = "userpwd");
				$this->session->set_flashdata('valid', 'Password changed');
			}

			redirect('account');
		}
	}

	//send verification code to user email
	public function resetpassword_vcode()
	{
		$email = htmlentities($_POST['useremail']);
		$act_key = htmlentities($_POST['vcode_init']);
		$userid = htmlentities($_POST['userid']);

		$this->load->library('emailconfig');
		$eres = $this->emailconfig->resetpassword_vcode($email, $act_key, $userid);

		// $eres = true;

		if ($eres !== true) {
			$this->Logmodel->log_act($type = "mail_err");
			$data['status'] = false;
			$data['msg'] = "Error sending email";
		} else {
			$res = $this->Usermodel->updateact_key($userid, $act_key, $email);
			if ($res === false) {
				$this->Logmodel->log_act($type = "db_err");
				$data['status'] = true;
				$data['msg'] = "Error saving your Key. Please try again";
			} else {
				$data['status'] = true;
				$data['msg'] = "Check your email for your Verification Code";
			}
		}

		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	//verify verification code
	public function verifyvcode()
	{
		$vecode = $_POST['vecode'];
		$userid = $_POST['userid'];

		$res = $this->Usermodel->verifyvcode($userid, $vecode);

		if ($res === false) {
			$this->Logmodel->log_act($type = "vcodeerr");
			$data['status'] = false;
			$data['msg'] = "Invalid Code!!";
		} else {
			$this->Logmodel->log_act($type = "vcodesucc");
			$data['status'] = true;
			$data['msg'] = "Verification done!";
		}

		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	//after vcode is verified, change password
	public function changepassword()
	{
		$newpwd = $_POST['newpwd'];
		$userid = $_POST['userid'];

		$this->load->library('emailconfig');
		$eres = $this->emailconfig->resetpassword($userid, $newpwd, $user_name = $this->session->userdata('mr_uname'));

		if ($eres == true) {

			$res = $this->Usermodel->changepassword($userid, $newpwd);

			if ($res === false) {
				$this->Logmodel->log_act($type = "userpwderr");
				$data['status'] = false;
				$data['msg'] = "Failed to update password.";
			} else {
				$this->Logmodel->log_act($type = "userpwd");
				$data['status'] = true;
				$data['msg'] = "Password updated!";
			}
		} else {
			$this->Logmodel->log_act($type = "mail_err");
			$data['status'] = false;
			$data['msg'] = "Error sending email";
		}

		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	//deactivate user account by themselves
	public function deact_account()
	{
		$this->checklogin();

		$act_res = $this->Usermodel->deact_account();
		if ($act_res == false) {
			$this->Logmodel->log_act($type = "userdact");
			$this->session->set_flashdata('invalid', 'Error performing this operation');
		}
	}

	//rating logs
	//shared links logs
	public function logs()
	{
		$this->checklogin();

		$this->setTabUrl($mod = 'logs');

		$data['title'] = "logs";

		$data['rr'] = $this->Usermodel->allrrbyuser();
		$data['ls'] = $this->Usermodel->allsentlinksbyuser();
		$data['ud'] = $this->Usermodel->userdetails();

		$data['t_mail'] = $this->Usermodel->total_email();
		$data['t_sms'] = $this->Usermodel->total_sms();
		$data['t_wp'] = $this->Usermodel->total_wapp();

		// print_r($data['ud']->total_email);
		// die;
		$this->load->view('templates/header', $data);
		$this->load->view('users/logs', $data);
		$this->load->view('templates/footer');
	}

	//message body to be shared
	public function getlink()
	{
		if ($this->ajax_checklogin() === false) {
			$data['status'] = "error";
			$data['redirect'] = base_url("logout");
		} else {
			$myfile = fopen("body.txt", "w") or die("Unable to open file!");
			$txt = "Click the link below, to rate any of my websites\n";
			fwrite($myfile, $txt);
			$txt = base_url() . "wtr/" . $this->session->userdata("mr_form_key") . "\n\n";
			fwrite($myfile, $txt);
			$txt = $this->session->userdata("mr_uname") . "\n";
			fwrite($myfile, $txt);
			$txt = $this->session->userdata("mr_email") . "\n";
			fwrite($myfile, $txt);
			$txt = "Regards";
			fwrite($myfile, $txt);
			fclose($myfile);

			$data['status'] = true;
		}

		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	//share index page
	public function sendlink()
	{
		$this->checklogin();

		$this->setTabUrl($mod = 'share');

		$data['title'] = "share";

		$this->load->view('templates/header', $data);
		$this->load->view('users/share');
		$this->load->view('templates/footer');
	}

	public function emailsample_csv()
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

	public function smssample_csv()
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

	//import email in csv format
	public function importcsv_email()
	{
		if ($_FILES['email_csv_file']['size'] > 0) {
			$flag = null;
			$invalidData = array();
			$EmailArray = array();

			$file_data = fopen($_FILES['email_csv_file']['tmp_name'], 'r');
			fgetcsv($file_data);
			while ($row = fgetcsv($file_data)) {
				//Email
				if (empty($row[0]) || !isset($row[0]) || !filter_var($row[0], FILTER_VALIDATE_EMAIL) || $row[0] == '') {
					array_push($invalidData, $row[0]);
					$flag = true;
				}

				array_push($EmailArray, array("Email" => $row[0]));
			}

			//check for flag=true
			if ($flag !== null) {
				$data['status'] = false;
				$data['msg'] = "File contains empty or invalid email";
				$data['invalidData'] = $invalidData;
			} else {
				$data['status'] = true;
				$data['EmailArray'] = $EmailArray;
			}
		} else {
			$data['status'] = false;
			$data['msg'] = "No file uploaded";
			$data['email_csv_file'] = $_FILES['email_csv_file'];
		}

		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	//import sms in csv format
	public function importcsv_sms()
	{
		if ($_FILES['sms_csv_file']['size'] > 0) {
			$flag = null;
			$invalidData = array();
			$MobileArray = array();

			$file_data = fopen($_FILES['sms_csv_file']['tmp_name'], 'r');
			fgetcsv($file_data);
			while ($row = fgetcsv($file_data)) {
				//Phonenumber
				if (empty($row[0]) || !isset($row[0]) || $row[0] == '' || strlen($row[0]) !== 10) {
					array_push($invalidData, $row[0]);
					$flag = true;
				}

				array_push($MobileArray, array("Phonenumber" => $row[0]));
			}

			//check for flag=true
			if ($flag !== null) {
				$data['status'] = false;
				$data['msg'] = "File contains empty or invalid numbers";
				$data['invalidData'] = $invalidData;
			} else {
				$data['status'] = true;
				$data['MobileArray'] = $MobileArray;
			}
		} else {
			$data['status'] = false;
			$data['msg'] = "No file uploaded";
			$data['sms_csv_file'] = $_FILES['sms_csv_file'];
		}

		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	//share sinlge email
	public function email_share()
	{
		$this->checklogin();

		$this->setTabUrl($mod = 'share');

		$data['title'] = "share";

		$this->form_validation->set_rules('email', 'E-mail', 'required|trim|valid_email|html_escape');
		$this->form_validation->set_rules('subj', 'Subject', 'required|trim|html_escape');
		$this->form_validation->set_rules('emailbdy', 'Body', 'required|trim|html_escape');

		if ($this->form_validation->run() == false) {
			$this->load->view('templates/header', $data);
			$this->load->view('users/share');
			$this->load->view('templates/footer');
		} else {
			$cq_res = $this->Usermodel->is_userquotaexpired($qType = 'email_quota');

			if ($cq_res === "not_Found") {
				$this->logout();
			} else if ($this->session->userdata('mr_sub') == '0') { //check subscription
				if ($this->session->userdata('mr_iscmpy') == '1' && $this->session->userdata('mr_sadmin') == '0') {
					$sessmsg = 'Your subscriptiontion isn\'t active. Contact your company Admin!';
				} else {
					$sessmsg = 'Your subscriptiontion isn\'t active. Contact us if you have a valid quota';
				}

				$this->session->set_flashdata('invalid', $sessmsg);
			} else if ($cq_res !== false) { //invalid quota (quota expired)
				$usermail_expire = $cq_res;
				if (filter_var($usermail_expire, FILTER_VALIDATE_EMAIL)) {
					$this->load->library('emailconfig');
					$this->emailconfig->quota_send_mail_expire($usermail_expire);
				}

				$this->Logmodel->log_act($type = "quota_expire");
				$this->session->set_flashdata('invalid', 'Quota has expired');
			} else if ($cq_res === false) { //valid quota
				//check given email is valid
				if (!filter_var($this->input->post('email'), FILTER_VALIDATE_EMAIL)) {
					$this->session->set_flashdata('invalid', '(' . $this->input->post('email') . ') is an invalid email');
				} else {
					$email = htmlentities($this->input->post('email'));
					$subj = htmlentities($this->input->post('subj'));
					$bdy = htmlentities($this->input->post('emailbdy'));

					$this->load->library('emailconfig');
					$mail_res = $this->emailconfig->link_send_mail($email, $subj, $bdy);

					if ($mail_res !== true) {
						$this->Logmodel->log_act($type = "mail_err");

						$this->session->set_flashdata('invalid', $mail_res);
					} else {
						$this->Logmodel->log_act($type = "smail_sent");

						//save to DB and deduct from quota
						$this->Usermodel->email_saveinfo();
						$this->session->set_flashdata('valid', 'Link sent successfully');
					}
				}
			}

			redirect('share');
		}
	}

	//share single sms
	public function sms_share()
	{
		$this->checklogin();

		$this->setTabUrl($mod = 'share');

		$data['title'] = "share";

		$this->form_validation->set_rules('mobile', 'Mobile', 'required|exact_length[10]|trim|html_escape');
		$this->form_validation->set_rules('smsbdy', 'Body', 'required|trim|html_escape');

		if ($this->form_validation->run() == FALSE) {
			$this->load->view('templates/header', $data);
			$this->load->view('users/share');
			$this->load->view('templates/footer');
		} else {
			$cq_res = $this->Usermodel->is_userquotaexpired($qType = 'sms_quota');

			if ($cq_res === "not_Found") {
				$this->logout();
			} else if ($this->session->userdata('mr_sub') == '0') { //check subscription
				if ($this->session->userdata('mr_iscmpy') == '1' && $this->session->userdata('mr_sadmin') == '0') {
					$sessmsg = 'Your subscriptiontion isn\'t active. Contact your company Admin!';
				} else {
					$sessmsg = 'Your subscriptiontion isn\'t active. Contact us if you have a valid quota';
				}

				$this->session->set_flashdata('invalid', $sessmsg);
			} else if ($cq_res !== false) { //invalid quota (expired)
				$usermail_expire = $cq_res;
				if (filter_var($usermail_expire, FILTER_VALIDATE_EMAIL)) {
					$this->load->library('emailconfig');
					$this->emailconfig->quota_send_mail_expire($usermail_expire);
				}

				$this->Logmodel->log_act($type = "quota_expire");
				$this->session->set_flashdata('invalid', 'Quota has expired');
			} else if ($cq_res === false) { //valid quota
				$mobile = $this->input->post('mobile');
				$bdy = $this->input->post('smsbdy');

				$url = "http://savshka.in/api/pushsms?user=502893&authkey=926pJyyVe2aK&sender=SSURVE&mobile=" . $mobile . "&text=" . urlencode($bdy) . "&entityid=1001715674475461342&templateid=1007838850146399750&rpt=0";
				$req = curl_init();

				curl_setopt($req, CURLOPT_URL, $url);
				curl_setopt($req, CURLOPT_RETURNTRANSFER, TRUE);
				$result = curl_exec($req);

				$httpCode = curl_getinfo($req, CURLINFO_HTTP_CODE);
				$Jresult = json_decode($result, true);

				if ($httpCode !== 200) {
					$this->session->set_flashdata('invalid', $httpCode . " - SERVER ERROR");
				} else {
					if ($Jresult['STATUS'] == "ERROR") {
						$this->session->set_flashdata('invalid', $Jresult['RESPONSE']['CODE'] . ' - ' . $Jresult['RESPONSE']['INFO']);
					} else {
						$this->Usermodel->sms_saveinfo();
						$this->session->set_flashdata('valid', 'SMS sent successfully');
					}
				}

				curl_close($req);
			}

			redirect('share');
		}
	}

	//share sinlge whatsapp
	public function whatsapp_share()
	{
		if ($this->ajax_checklogin() === false) {
			$data['status'] = "error";
			$data['redirect'] = base_url("logout");
		} else {
			$cq_res = $this->Usermodel->is_userquotaexpired($qType = 'whatsapp_quota');

			if ($cq_res === "not_Found") {
				$data['status'] = "error";
				$data['redirect'] = base_url("logout");
			} else if ($this->session->userdata('mr_sub') == '0') {
				if ($this->session->userdata('mr_iscmpy') == '1' && $this->session->userdata('mr_sadmin') == '0') {
					$sessmsg = 'Your company subscriptiontion isn\'t active. Contact your company Admin!';
				} else {
					$sessmsg = 'Your subscriptiontion isn\'t active. Contact us if you have a valid quota';
				}

				$data['status'] = false;
				$data['msg'] = $sessmsg;
			} else if ($cq_res !== false) {
				$usermail_expire = $cq_res;
				if (filter_var($usermail_expire, FILTER_VALIDATE_EMAIL)) {
					$this->load->library('emailconfig');
					$this->emailconfig->quota_send_mail_expire($usermail_expire);
				}
				$this->Logmodel->log_act($type = "quota_expire");

				$data['status'] = false;
				$data['msg'] = 'Quota has expired';
			} else if ($cq_res === false) {

				$mobile = $_POST['mobile'];
				$whpbdy = $_POST['whpbdy'];

				$this->Usermodel->whatsapp_saveinfo($mobile, $whpbdy);

				$data['status'] = true;
				$data['msg'] = 'Shared';

				$this->session->set_flashdata('valid', $data['msg']);
			}
		}

		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	//share multiple email
	public function sendmultipleemail()
	{
		if ($this->ajax_checklogin() === false) {
			$data['status'] = "error";
			$data['redirect'] = base_url("logout");
		} else {
			$cq_res = $this->Usermodel->is_userquotaexpired($qType = 'email_quota');

			if ($cq_res === "not_Found") {
				$data['status'] = "error";
				$data['redirect'] = base_url("logout");
			} else if ($this->session->userdata('mr_sub') == '0') {
				if ($this->session->userdata('mr_iscmpy') == '1' && $this->session->userdata('mr_sadmin') == '0') {
					$sessmsg = 'Your company subscriptiontion isn\'t active. Contact your company Admin!';
				} else {
					$sessmsg = 'Your subscriptiontion isn\'t active. Contact us if you have a valid quota';
				}

				$data['status'] = false;
				$data['msg'] = $sessmsg;
			} else if ($cq_res !== false) {
				$usermail_expire = $cq_res;
				if (filter_var($usermail_expire, FILTER_VALIDATE_EMAIL)) {
					$this->load->library('emailconfig');
					$this->emailconfig->quota_send_mail_expire($usermail_expire);
				}
				$this->Logmodel->log_act($type = "quota_expire");

				$data['status'] = false;
				$data['msg'] = 'Quota has expired';
			} else if ($cq_res === false) {

				$emaildata = $_POST['emaildata'];
				$subj = $_POST['subj'];
				$bdy = $_POST['bdy'];
				$num = count($emaildata);

				$qbl_res = $this->Usermodel->get_userquota();

				if ($qbl_res->email_quota < $num) {
					$this->Logmodel->log_act($type = "quota_limit");

					$data['status'] = false;
					$data['msg'] = 'Number of emails to be sent (' . $num . ') exceeds your quota point of (' . $qbl_res->email_quota . ').';
				} else {
					$notvalidarr = array();
					$emailnotsentarr = array();

					//validate each email
					foreach ($emaildata as $mail) {
						if (empty($mail) || !isset($mail) || !filter_var($mail, FILTER_VALIDATE_EMAIL)) {
							array_push($notvalidarr, $mail);
						}
					}

					if (count($notvalidarr) > 0 || !empty($notvalidarr)) {
						$data['status'] = false;
						$data['notvalidarr'] = $notvalidarr;
						$data['msg'] = 'Invalid or empty emails found';
					} else if (count($notvalidarr) == 0 && empty($notvalidarr)) { //all emails are valid, send
						foreach ($emaildata as $mail) {
							$this->load->library('emailconfig');
							$mailRes = $this->emailconfig->send_multiple_link_email($mail, $subj, $bdy);
							// $mailRes = true;

							if ($mailRes === true) {
								$this->Usermodel->multiplemail_saveinfo($mail, $subj, $bdy);
							} else {
								array_push($emailnotsentarr, $mail);
							}
						}

						//check if some emails were not sent
						if (count($emailnotsentarr) > 0 || !empty($emailnotsentarr)) {
							$data['status'] = false;
							$data['emailnotsentarr'] = $emailnotsentarr;
							$data['msg'] = 'Some emails (' . count($emailnotsentarr) . ') could not be sent';
						} else if (count($emailnotsentarr) == 0 && empty($emailnotsentarr)) {
							$data['status'] = true;
							$data['msg'] = 'All emails sent successfully';

							$this->session->set_flashdata('valid', $data['msg']);
						}
					}
				}
			}
		}

		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	//share multiple sms
	public function sendmultiplesms()
	{
		if ($this->ajax_checklogin() === false) {
			$data['status'] = "error";
			$data['redirect'] = base_url("logout");
		} else {
			$cq_res = $this->Usermodel->is_userquotaexpired($qType = 'sms_quota');

			if ($cq_res === "not_Found") {
				$data['status'] = "error";
				$data['redirect'] = base_url("logout");
			} else if ($this->session->userdata('mr_sub') == '0') {
				if ($this->session->userdata('mr_iscmpy') == '1' && $this->session->userdata('mr_sadmin') == '0') {
					$sessmsg = 'Your company subscriptiontion isn\'t active. Contact your company Admin!';
				} else {
					$sessmsg = 'Your subscriptiontion isn\'t active. Contact us if you have a valid quota';
				}

				$data['status'] = false;
				$data['msg'] = $sessmsg;
			} else if ($cq_res !== false) {
				$usermail_expire = $cq_res;
				if (filter_var($usermail_expire, FILTER_VALIDATE_EMAIL)) {
					$this->load->library('emailconfig');
					$this->emailconfig->quota_send_mail_expire($usermail_expire);
				}
				$this->Logmodel->log_act($type = "quota_expire");

				$data['status'] = false;
				$data['msg'] = 'Quota has expired';
			} else if ($cq_res === false) {

				$mobiledata = $_POST['mobiledata'];
				$smsbdy = $_POST['smsbdy'];
				$num = count($mobiledata);

				$qbl_res = $this->Usermodel->get_userquota();

				if ($qbl_res->sms_quota < $num) {
					$this->Logmodel->log_act($type = "quota_limit");

					$data['status'] = false;
					$data['msg'] = 'Number of emails to be sent (' . $num . ') exceeds your quota point of (' . $qbl_res->sms_quota . ').';
				} else {
					$notvalidarr = array();
					$mobilenotsentarr = array();

					//validate each mobile
					foreach ($mobiledata as $mobile) {
						if (empty($mobile) || !isset($mobile) || strlen($mobile) !== 10) {
							array_push($notvalidarr, $mobile);
						}
					}

					if (count($notvalidarr) > 0 || !empty($notvalidarr)) {
						$data['status'] = false;
						$data['notvalidarr'] = $notvalidarr;
						$data['msg'] = 'Invalid or empty numbers found';
					} else if (count($notvalidarr) == 0 && empty($notvalidarr)) {
						foreach ($mobiledata as $mobile) {
							//API send
							$url = "http://savshka.in/api/pushsms?user=502893&authkey=926pJyyVe2aK&sender=SSURVE&mobile=" . $mobile . "&text=" . urlencode($smsbdy) . "&entityid=1001715674475461342&templateid=1007838850146399750&rpt=0";
							$req = curl_init();

							curl_setopt($req, CURLOPT_URL, $url);
							curl_setopt($req, CURLOPT_RETURNTRANSFER, TRUE);
							$result = curl_exec($req);

							$httpCode = curl_getinfo($req, CURLINFO_HTTP_CODE);
							$Jresult = json_decode($result, true);

							if ($httpCode !== 200) {
								$data['status'] = false;
								$data['msg'] = $httpCode . " - SERVER ERROR";

								array_push($mobilenotsentarr, array('mobile' => $mobile, 'errorCode' => $httpCode, 'errorInfo' => 'SERVER ERROR'));
							} else {
								if ($Jresult['STATUS'] == "ERROR") {
									array_push($mobilenotsentarr, array('mobile' => $mobile, 'errorCode' => $Jresult['RESPONSE']['CODE'], 'errorInfo' => $Jresult['RESPONSE']['INFO']));
								} else {
									$this->Usermodel->multiplsms_saveinfo($mobile, $smsbdy);
								}
							}

							curl_close($req);
						}

						//check if some numbers were not sent
						if (count($mobilenotsentarr) > 0 || !empty($mobilenotsentarr)) {
							$data['status'] = false;
							$data['mobilenotsentarr'] = $mobilenotsentarr;
							$data['msg'] = 'Some numbers (' . count($mobilenotsentarr) . ') failed to receive SMS';
						} else if (count($mobilenotsentarr) == 0 && empty($mobilenotsentarr)) {
							$data['status'] = true;
							$data['msg'] = 'All SMS sent successfully';

							$this->session->set_flashdata('valid', $data['msg']);
						}
					}
				}
			}
		}

		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	public function fof()
	{
		$data['title'] = "404 | Page Not Found";

		$this->load->view('templates/header', $data);
		$this->load->view('templates/fof');
		$this->load->view('templates/footer');
	}
}
