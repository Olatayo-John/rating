<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . "libraries/razorpay/Razorpay.php");
require_once(APPPATH . 'libraries/phpqrcode/qrlib.php');

use Razorpay\Api\Api;

class User extends User_Controller
{
	public function index()
	{
		if ($this->session->userdata('mr_logged_in')) {
			if ($this->session->userdata('mr_website_form') === "0") {
				redirect('platform');
			} else {
				redirect('dashboard');
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
				$log = "Failed Login Attempt - Wrong Credentials [ Username: " . htmlentities($this->input->post('uname')) . " ]";
				$this->log_act($log);

				$this->setFlashMsg('error', lang('wrong_pwd_uname'));
				redirect('user');
			}
			if ($validate == "inactive_access_by_cmpyAdmin") {
				$log = "Failed Login Attempt - Account deactivated by Company Admin [ Username: " . htmlentities($this->input->post('uname')) . " ]";
				$this->log_act($log);

				$this->setFlashMsg('error', lang('acct_deact_by_cmpy_admin'));
				redirect('/');
			}
			if ($validate == "inactive_access") {
				$log = "Failed Login Attempt - Account deactivated [ Username: " . htmlentities($this->input->post('uname')) . " ]";
				$this->log_act($log);

				$this->setFlashMsg('error', lang('acct_deact'));
				redirect('/');
			}
			if ($validate == "inactive") {
				$log = "Failed Login Attempt - Account unverified [ Username: " . htmlentities($this->input->post('uname')) . " ]";
				$this->log_act($log);

				$res_login = $this->Usermodel->login_get_key();
				if ($res_login) {
					$this->setFlashMsg('error', 'Your account is not verified');
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
				$cmpy_logo = $validate->cmpyLogo;
				$sub = $validate->sub;
				$uname = $validate->uname;
				$email = $validate->email;
				$mobile = $validate->mobile;
				$website_form = $validate->website_form;
				$form_key = $validate->form_key;
				$frame_id = $validate->frame_id;

				//sessionData
				$user_sess = array(
					'mr_id' => $id,
					'mr_sadmin' => $sadmin,
					'mr_admin' => $admin,
					'mr_iscmpy' => $iscmpy,
					'mr_cmpyid' => $cmpyid,
					'mr_cmpy' => $cmpy,
					'mr_cmpy_logo' => $cmpy_logo,
					'mr_sub' => $sub,
					'mr_uname' => $uname,
					'mr_email' => $email,
					'mr_mobile' => $mobile,
					'mr_website_form' => $website_form,
					'mr_form_key' => $form_key,
					'mr_frame_id' => $frame_id,
					'mr_logged_in' => TRUE,
				);
				$this->session->set_userdata($user_sess);

				$this->Usermodel->user_latestact();

				$log = "Logged In [ Username: " . $this->session->userdata('mr_uname') . " ]";
				$this->log_act($log);

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
		$data['plans'] = $this->Usermodel->get_plans();

		if ($this->session->userdata('mr_logged_in')) {
			$this->setFlashMsg('error', 'Log out first.');
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
		if (isset($_POST['cmpychkb'])) {
			$this->form_validation->set_rules('cmpy', 'Company Name', 'trim|html_escape|required|is_unique[users.cmpy]', array('is_unique' => 'This Company already exist'));
		} else {
			$this->form_validation->set_rules('cmpy', 'Company Name', 'trim|html_escape|is_unique[users.cmpy]', array('is_unique' => 'This Company already exist'));
		}

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
			// $mail_res = true;

			if ($mail_res !== TRUE) {
				$log = "Error sending mail - User Registration [ Username: " . htmlentities($this->input->post('uname')) . ", Email: " . htmlentities($this->input->post('email')) . ", MailError: " . $mail_res . " ]";
				$this->log_act($log);

				$this->setFlashMsg('error', 'Error sending mail');
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
					$log = "Error saving to Database - User Registration [ Username: " . htmlentities($this->input->post('uname')) . " ]";
					$this->log_act($log);

					$this->setFlashMsg('error', 'Error saving your details. Please try again');
					redirect('register');
					exit();
				} else {
					$log = "New user registration [ Username: " . htmlentities($this->input->post('uname')) . ", Email: " . htmlentities($this->input->post('email')) . " ]";
					$this->log_act($log);

					$this->setFlashMsg('success', 'Verification code sent to your mail.');
					redirect('emailverify/' . $form_key);
					exit();
				}
			}
		}
	}

	//email verification after registration
	public function emailverify($key)
	{
		$this->setTabUrl($mod = 'login');

		$data['title'] = "Email Verification";

		$check_res = $this->Usermodel->check_verification($key);
		if ($check_res == false) {
			$this->setFlashMsg('error', 'Wrong credentials');
			redirect('login');
		} else {
			$active = $check_res->active;
			if ($active == '1') {
				$this->setFlashMsg('success', 'Your account is verified.');
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
					$log = "Invalid verfication code provided [ Username: " . $check_res->uname . " ]";
					$this->log_act($log);

					$this->setFlashMsg('error', 'Invalid code');
					redirect('emailverify/' . $key);
				} else {
					if ($validate->active !== "1") {
						$log = "Error verifying account [ Username: " . $check_res->uname  . " ]";
						$this->log_act($log);

						$this->setFlashMsg('error', 'Error verifying account ');
						redirect('emailverify/' . $key);
					} else if ($validate->active == "1") {
						$log = "Account verified [ Username: " . $check_res->uname  . " ]";
						$this->log_act($log);

						$this->setFlashMsg('success', 'Account verified');
						redirect('login');
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
			$this->setFlashMsg('error', 'Wrong credentials');
			redirect($_SERVER['HTTP_REFERRER']);
		} else {
			$active = $check_res->active;
			if ($active == '1') {
				$this->setFlashMsg('success', 'Your account is already verified and active.');
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
					$log = "Error sending mail - Verification [ Username: " . $uname . ", Email: " . $email . ", MailError: " . $mail_res . " ]";
					$this->log_act($log);

					$this->setFlashMsg('error', 'Error sending mail');
					redirect($link);
				} else {
					$log = "Mail sent - Verification [ Username: " . $uname . ", Email: " . $email . " ]";
					$this->log_act($log);

					$this->Usermodel->code_verify_update($act_key, $key);

					$this->setFlashMsg('success', 'Verification mail sent');
					redirect($link);
				}
			}
		}
	}

	//user can creat n number of platform according to their packages
	//this is done after registration
	public function platform()
	{
		$data['title'] = "add platform";

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
			$this->load->view('users/platforms', $data);
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
			$log = "Error creating Platform [ Username: " . $this->session->userdata('mr_uname') . ", Platform: " . htmlentities($_POST['web_name']) . ", Link: " . htmlentities($_POST['web_link']) . ", Error: " . $res . " ]";
			$this->log_act($log);

			$data['status'] = false;
			$data['msg'] = $res;
		} else if (gettype($res) === "integer") {
			$log = "New Platform created [ Username: " . $this->session->userdata('mr_uname') . ", Platform: " . htmlentities($_POST['web_name']) . ", Link: " . htmlentities($_POST['web_link']) . " ]";
			$this->log_act($log);

			$data['status'] = true;
			$data['msg'] = "Platform created";
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
			$log = "Error deleting Platform [ Username: " . $this->session->userdata('mr_uname') . ", Platform: " . htmlentities($_POST['web_name']) . ", Link: " . htmlentities($_POST['web_link']) . " ]";
			$this->log_act($log);

			$data['status'] = "error";
			$data['redirect'] = "";
			$data['msg'] = 'Error removing this Platform';
		} else {
			$log = "Deleted Platform [ Username: " . $this->session->userdata('mr_uname') . ", Platform: " . htmlentities($_POST['web_name']) . ", Link: " . htmlentities($_POST['web_link']) . " ]";
			$this->log_act($log);

			$data['status'] = true;
			$data['redirect'] = "";
			$data['msg'] = 'Platform Removed';
		}

		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	// dashboard
	public function dashboard()
	{
		$this->checklogin();

		$this->setTabUrl($mod = 'dashboard');

		$data['title'] = "dashboard";

		$data['platforms'] = $this->Usermodel->get_user_websites();
		$this->load->view('templates/header', $data);
		$this->load->view('users/dashboard');
		$this->load->view('templates/footer');
	}

	public function fillChart()
	{
		if ($this->ajax_checklogin() === false) {
			$data['status'] = "error";
			$data['redirect'] = base_url("logout");
		} else {
			$res = array();

			$res['cp'] = $this->Usermodel->chartPlatforms()->result_array();
			$res['cm'] = $this->Usermodel->chartMonthly($_POST['datetime_Year']);
			$res['cr'] = $this->Usermodel->chartRatings();

			$data['status'] = true;
			$data['msg'] = '';
			$data['chartData'] = $res;
		}

		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	public function generateFrame()
	{
		if ($this->ajax_checklogin() === false) {
			$data['status'] = "error";
			$data['redirect'] = base_url("logout");
		} else {

			if (count($_POST) === 3) {
				$id = htmlentities($_POST['id']);
				$form_key = htmlentities($_POST['form_key']);
				$platforms = ($_POST['platforms']);

				$frame_id = md5(mt_rand(0, 1000000));

				//clear prev. selected frames
				$this->Usermodel->clearPrevFrame($id, $form_key);
				$this->Usermodel->updateFrameid($id, $form_key, $frame_id);

				foreach ($_POST['platforms'] as $key => $pid) {
					$this->Usermodel->generateFrame($id, $form_key, $pid, $frame_id);
				}

				$this->session->set_userdata('mr_frame_id', $frame_id);

				$log = "Frame created [ Username: " . $this->session->userdata('mr_uname') .  ", FrameID: " . $frame_id .  " ]";
				$this->log_act($log);

				$data['status'] = true;
				$data['msg'] = 'Generated';
				$data['frame_id'] = $frame_id;
				$data['frameLink'] = base_url('pf/') . $frame_id;
			} else {
				$data['status'] = false;
				$data['msg'] = 'Missing Parameters';
			}
		}

		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	//disabled
	public function createFrame()
	{
		if ($this->ajax_checklogin() === false) {
			$data['status'] = "error";
			$data['redirect'] = base_url("logout");
		} else {
			// print_r($_POST);
			// exit;

			if (count($_POST) > 0) {
				$id = htmlentities($_POST['frame_platformUserid']);
				$form_key = htmlentities($_POST['frame_platformFormkey']);

				//clear prev. selected frames
				$this->Usermodel->clearPrevFrame($id, $form_key);

				// $frame_id = password_hash(mt_rand(0, 1000000), PASSWORD_DEFAULT);
				$frame_id = md5(mt_rand(0, 1000000));
				foreach ($_POST['frame_platformId'] as $key => $pid) {
					$sdata = array(
						'frame_id' => $frame_id,
						'icon' => htmlentities($_POST['frame_icon'][$key])
					);
					$this->Usermodel->createFrame($id, $form_key, $pid, $sdata);
				}

				$data['status'] = true;
				$data['msg'] = 'Created';
				$data['frameLink'] = base_url('pf/') . $frame_id;
			} else {
				$data['status'] = false;
				$data['msg'] = 'Missing Parameters';
			}
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
		$data['cmpyInfo'] = $this->Usermodel->get_companyInfo();

		$this->load->view('templates/header', $data);
		$this->load->view('users/account_view', $data);
		$this->load->view('templates/footer');
	}

	public function account_edit()
	{
		$this->checklogin();

		$this->setTabUrl($mod = 'account');

		$data['title'] = "account";

		$data['user_info'] = $this->Usermodel->get_info();
		$data['websites'] = $this->Usermodel->get_user_websites();
		$data['quota'] = $this->Usermodel->get_userQuota();
		$data['cmpyInfo'] = $this->Usermodel->get_companyInfo();

		if ($data['quota']->balance !== '0' && $data['quota']->balance !== null) {

			//use Testing keys if Live keys are empty from settings
			$key_id = $this->st->rz_live_key_id ? $this->st->rz_live_key_id : $this->st->rz_test_key_id;
			$key_secret = $this->st->rz_live_key_secret ? $this->st->rz_live_key_secret : $this->st->rz_test_key_secret;

			if ($key_id && $key_secret) {
				//balance
				$balance = ($data['quota']->balance) * 100;
				$form_key = $data['quota']->by_form_key;
				$user_id = $data['quota']->by_user_id;

				try {
					$api = new Api($key_id, $key_secret);
					$order = $api->order->create(array('receipt' => 'OID' . mt_rand(0, 100000000) . '', 'amount' => $balance, 'currency' => 'INR', 'notes' => array('form_key' => $form_key, 'user_id' => $user_id)));

					$data['error'] = false;
					$data['order'] = $order;
					$data['key_id'] = $key_id;
					$data['key_secret'] = $key_secret;
				} catch (Exception $e) {
					$log = "Razorpay Error : " . $e->getMessage() . " [ Username: " . $this->session->userdata('mr_uname') .  " ]";
					$this->log_act($log);

					$data['error'] = true;
					$data['error_msg'] = "Razorpay Error : " . $e->getMessage();
				}
			} else {
				$log = "Missing Razorpay API Keys [ Username: " . $this->session->userdata('mr_uname') .  " ]";
				$this->log_act($log);

				$data['error'] = true;
				$data['error_msg'] = "Missing Razorpay API Keys";
			}
		}

		$this->load->view('templates/header', $data);
		$this->load->view('users/account_edit', $data);
		$this->load->view('templates/footer');
	}

	public function generateQrCode()
	{
		//check login
		if ($this->ajax_checklogin() === false) {
			$data['status'] = "error";
			$data['redirect'] = base_url("logout");
		} else {
			//check postdata
			if ($_POST['id'] && $_POST['form_key'] && $_POST['link']) {
				$id = $_POST['id'];
				$fk = $_POST['form_key'];
				$link = $_POST['link'];

				$folderPath = getcwd() . '/qr';
				$fileName = $folderPath . '/' . $fk . '_qr.png';
				$fileNamePath = base_url('qr/') . $fk . '_qr.png';

				if (!file_exists($folderPath)) {
					mkdir($folderPath);
				}

				if (!file_exists($fileName)) {
					$contents = $link;
					// $fileName = '005_file_' . md5($contents) . '.png';

					QRcode::png($contents, $fileName);
				}

				$log = "QR Code created [ Username: " . $this->session->userdata('mr_uname') .  " ]";
				$this->log_act($log);

				$data['status'] = true;
				$data['msg'] = '';
				$data['qr'] = $fileNamePath;
				$data['qrfileName'] = $fk . '_qr.png';
			} else {
				$data['status'] = false;
				$data['msg'] = "Missing parameters";
			}
		}

		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	public function downloadQrCode($fp = null, $fn = null)
	{
		$fp = htmlentities($_GET['fp']);
		$fn = htmlentities($_GET['fn']);

		header("Content-Type: image/jpeg");
		header("Content-Disposition: attachment; filename=" . $fn . "");

		echo file_get_contents($fp);
	}

	public function personal_edit()
	{
		$this->checklogin();

		$this->setTabUrl($mod = 'account');

		$this->form_validation->set_rules('fname', 'First Name', 'trim|html_escape');
		$this->form_validation->set_rules('lname', 'Last Name', 'trim|html_escape');
		$this->form_validation->set_rules('email', 'E-mail', 'required|trim|valid_email|html_escape');
		$this->form_validation->set_rules('mobile', 'Mobile', 'required|trim|exact_length[10]|html_escape');
		$this->form_validation->set_rules('gender', 'Gender', 'trim|html_escape');
		$this->form_validation->set_rules('dob', 'Date Of Birth', 'trim|html_escape');

		if ($this->form_validation->run() === FALSE) {
			$this->setFlashMsg('error', validation_errors());
		} else {
			$res = $this->Usermodel->personal_edit();
			if ($res !== TRUE) {
				$log = "Error updating profile [ Username: " . $this->session->userdata('mr_uname') .  " ]";
				$this->log_act($log);

				$this->setFlashMsg('error', lang('update_failed'));
			} else {
				$log = "Profile Updated [ Username: " . $this->session->userdata('mr_uname') .  " ]";
				$this->log_act($log);

				$this->setFlashMsg('success', lang('profile_updated'));

				$this->session->set_userdata('mr_email', htmlentities($this->input->post('email')));
				$this->session->set_userdata('mr_mobile', htmlentities($this->input->post('mobile')));
			}
		}

		redirect('account');
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
				$subject = $_POST['web_subject_new'];
				$description = $_POST['web_desc_new'];
				$icon = $_POST['web_icon_new'];

				$platLogo = '';
				if ($_FILES['web_file_new']['name']) {

					$file_name = strtolower($web_name_new . '_logo_' . $this->session->userdata('mr_id'));

					$config['upload_path'] = './uploads/platform';
					$config['allowed_types'] = 'jpg|jpeg|png';
					$config['max_size'] = '2048';
					$config['max_height'] = '3000';
					$config['max_width'] = '3000';
					$config['file_name'] = $file_name;
					$config['overwrite'] = true;
					$config['remove_spaces'] = false;

					$this->load->library('upload', $config);
					if (!$this->upload->do_upload('web_file_new')) {
						$upload_error = array('error' => $this->upload->display_errors());

						$data['status'] = false;
						$data['msg'] = $this->upload->display_errors();
						$data['token'] = $this->security->get_csrf_hash();
						echo json_encode($data);
						exit;
					} else {
						$logo_uploaded = $_FILES['web_file_new']['name'];
						$logo_ext = htmlentities(strtolower(pathinfo($logo_uploaded, PATHINFO_EXTENSION)));
						$upload_data = array('upload_data' => $this->upload->data());
						$platLogo = $file_name . "." . $logo_ext;
					}
				}

				$res = $this->Usermodel->createwebsite($web_name_new, $web_link_new, $subject, $description, $icon, $platLogo);

				if (gettype($res) === "string") {
					$log = "Error creating Platform [ Username: " . $this->session->userdata('mr_uname') . ", Platform: " . htmlentities($_POST['web_name_new']) . ", Link: " . htmlentities($_POST['web_link_new']) . ", Error: " . $res . "  ]";
					$this->log_act($log);

					$data['status'] = false;
					$data['msg'] = $res;
				} else if (gettype($res) === "integer") {
					$log = "New Platform created [ Username: " . $this->session->userdata('mr_uname') . ", Platform: " . htmlentities($_POST['web_name_new']) . ", Link: " . htmlentities($_POST['web_link_new']) . " ]";
					$this->log_act($log);

					$data['status'] = true;
					$data['msg'] = "Platform created";
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

	//
	// function not included
	public function delete_website()
	{
		$act_res = $this->Usermodel->delete_website($_POST['id']);
		if ($act_res == false) {
			$log = "Error deleting Platform [ Username: " . $this->session->userdata('mr_uname') . ", PlatformID: " . htmlentities($_POST['id']) . "]";
			$this->log_act($log);

			$this->setFlashMsg('error', 'Error deleting this data! Please try again');
		} else {
			$log = "Deleted Platform [ Username: " . $this->session->userdata('mr_uname') . ", PlatformID: " . htmlentities($_POST['id']) . " ]";
			$this->log_act($log);;

			$this->setFlashMsg('success', 'Data deleted successfully!');
		}
	}
	//
	//

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

	//change web details
	public function website_update()
	{
		if ($this->ajax_checklogin() === false) {
			$data['status'] = "error";
			$data['redirect'] = base_url("logout");
		} else {
			$webstatusArr = array('0', '1');
			if ($_POST['id'] && in_array($_POST['web_act'], $webstatusArr)) {
				$wb = $_POST['web_act'];

				$platLogo = '';
				if ($_FILES['web_file_edit']['name']) {

					$file_name = strtolower($_POST['web_name_edit'] . '_logo_' . $this->session->userdata('mr_id'));

					$config['upload_path'] = './uploads/platform';
					$config['allowed_types'] = 'jpg|jpeg|png';
					$config['max_size'] = '2048';
					$config['max_height'] = '3000';
					$config['max_width'] = '3000';
					$config['file_name'] = $file_name;
					$config['overwrite'] = true;
					$config['remove_spaces'] = false;

					$this->load->library('upload', $config);
					if (!$this->upload->do_upload('web_file_edit')) {
						$upload_error = array('error' => $this->upload->display_errors());

						$data['status'] = false;
						$data['msg'] = $this->upload->display_errors();
						$data['token'] = $this->security->get_csrf_hash();
						echo json_encode($data);
						exit;
					} else {
						$logo_uploaded = $_FILES['web_file_edit']['name'];
						$logo_ext = htmlentities(strtolower(pathinfo($logo_uploaded, PATHINFO_EXTENSION)));
						$upload_data = array('upload_data' => $this->upload->data());
						$platLogo = $file_name . "." . $logo_ext;
					}
				}

				$act_res = $this->Usermodel->website_update($_POST['id'], $_POST['web_act'], $_POST['web_subject_edit'], $_POST['web_desc_edit'], $_POST['web_icon_edit'], $platLogo);
				// $act_res = false;

				if ($act_res == false) {
					$log = "Error updating Platform [ Username: " . $this->session->userdata('mr_uname') . ", PlatformID: " . $_POST['id'] . "]";
					$this->log_act($log);

					$data['status'] = false;
					$data['msg'] =  "Error updating platform";
				} else {
					$log = "Platform Updated [ Username: " . $this->session->userdata('mr_uname') . ", PlatformID: " . $_POST['id'] . "]";
					$this->log_act($log);

					$data['status'] = true;
					$data['msg'] = "Platform updated";
				}
			} else {
				$data['status'] = false;
				$data['msg'] = "Missing parameters";
			}
		}

		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	//update company details
	//only [admin]
	public function company_edit()
	{
		$this->checklogin();

		$this->setTabUrl($mod = 'account');

		$this->form_validation->set_rules('cmpyName', 'Company Name', 'trim|required|html_escape');
		$this->form_validation->set_rules('cmpyEmail', 'Company Email', 'trim|valid_email|html_escape');
		$this->form_validation->set_rules('cmpyMobile', 'Company Mobile', 'trim|exact_length[10]|html_escape');
		$this->form_validation->set_rules('cmpyLogo', 'Company Logo', 'trim|html_escape');

		if ($this->form_validation->run() === FALSE) {
			$this->setFlashMsg('error', validation_errors());
		} else {
			$cmpyLogo = $this->session->userdata('mr_cmpy_logo');

			if ($_FILES['cmpyLogo']['name']) {

				$file_name = strtolower($this->session->userdata('mr_cmpy') . '_logo');

				$config['upload_path'] = './uploads/company';
				$config['allowed_types'] = 'jpg|jpeg|png';
				$config['max_size'] = '2048';
				$config['max_height'] = '3000';
				$config['max_width'] = '3000';
				$config['file_name'] = $file_name;
				$config['overwrite'] = true;
				$config['remove_spaces'] = false;

				$this->load->library('upload', $config);
				if (!$this->upload->do_upload('cmpyLogo')) {
					$upload_error = array('error' => $this->upload->display_errors());
					$this->setFlashMsg('error', $this->upload->display_errors());
					redirect('account');
				} else {
					$logo_uploaded = $_FILES['cmpyLogo']['name'];
					$logo_ext = htmlentities(strtolower(pathinfo($logo_uploaded, PATHINFO_EXTENSION)));
					$upload_data = array('upload_data' => $this->upload->data());
					$cmpyLogo = $file_name . "." . $logo_ext;
					$this->session->set_userdata('mr_cmpy_logo', $cmpyLogo);
				}
			}

			$data = array(
				'cmpyName' => htmlentities($this->input->post('cmpyName')),
				'cmpyMobile' => htmlentities($this->input->post('cmpyMobile')),
				'cmpyEmail' => htmlentities($this->input->post('cmpyEmail')),
				'cmpyLogo' => $cmpyLogo
			);
			$res = $this->Usermodel->company_edit($data);
			if ($res !== TRUE) {
				$log = "Error updating company [ Username: " . $this->session->userdata('mr_uname') .  " ]";
				$this->log_act($log);

				$this->setFlashMsg('error', lang('update_failed'));
			} else {
				$log = "Company Updated [ Username: " . $this->session->userdata('mr_uname') .  " ]";
				$this->log_act($log);

				$this->setFlashMsg('success', lang('cmpy_updated'));

				$this->session->set_userdata('mr_cmpy', htmlentities($this->input->post('cmpyName')));
			}
		}

		redirect('account');
	}

	public function password_update()
	{
		$this->checklogin();

		$this->form_validation->set_rules('c_pwd', 'Current Password', 'required|trim');
		$this->form_validation->set_rules('n_pwd', 'New Password', 'required|trim|min_length[6]');
		$this->form_validation->set_rules('rtn_pwd', 'Re-type Password', 'required|trim|min_length[6]|matches[n_pwd]');

		if ($this->form_validation->run() == false) {
			$this->setFlashMsg('error', validation_errors());
		} else {
			$pwd_res = $this->Usermodel->check_pwd();
			if ($pwd_res == false) {
				$log = "Error updating password [ Username: " . $this->session->userdata('mr_uname') . " ]";
				$this->log_act($log);

				$this->setFlashMsg('error', lang('incorrect_pwd_provided'));
			} else {
				$log = "Password updated [ Username: " . $this->session->userdata('mr_uname') . " ]";
				$this->log_act($log);

				$this->setFlashMsg('success', lang('pwd_updated'));
			}
		}

		redirect('account');
	}

	//send verification code to user email
	public function resetpassword_vcode()
	{
		$email = htmlentities($_POST['useremail']);
		$act_key = htmlentities($_POST['vcode_init']);
		$userid = htmlentities($_POST['userid']);

		$this->load->library('emailconfig');
		$eres = $this->emailconfig->resetpassword_vcode($email, $act_key, $userid);

		if ($eres !== true) {
			$log = "Error sending mail - Verification [ Username: " . htmlentities($this->input->post('uname')) . ", Email: " . htmlentities($this->input->post('useremail')) . ", MailError: " . $eres . " ]";
			$this->log_act($log);

			$data['status'] = false;
			$data['msg'] = "Error sending mail";
		} else {
			$log = "Mail sent - Verification [ Username: " . $this->session->userdata('mr_uname') . ", Email: " . htmlentities($this->input->post('useremail')) . " ]";
			$this->log_act($log);

			$res = $this->Usermodel->updateact_key($userid, $act_key, $email);
			if ($res === false) {
				$log = "Error saving to Database - Password Reset [ Username: " . $this->session->userdata('mr_uname') . " ]";
				$this->log_act($log);

				$data['status'] = true;
				$data['msg'] = "Error saving to Database";
			} else {
				$data['status'] = true;
				$data['msg'] = "Mail sent";
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
			$log = "Invalid verfication code provided - Password Reset [ Username: " . $this->session->userdata('mr_uname') . " ]";
			$this->log_act($log);

			$data['status'] = false;
			$data['msg'] = "Invalid verfication code provided";
		} else {
			$log = "Code verified - Password Reset [ Username: " . $this->session->userdata('mr_uname') . " ]";
			$this->log_act($log);

			$data['status'] = true;
			$data['msg'] = "Code Verified";
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

		if ($eres === true) {

			$res = $this->Usermodel->changepassword($userid, $newpwd);

			if ($res === false) {
				$log = "Error updating password [ Username: " . $this->session->userdata('mr_uname') . " ]";
				$this->log_act($log);

				$data['status'] = false;
				$data['msg'] = "Error updating password";
			} else {
				$log = "Password updated [ Username: " . $this->session->userdata('mr_uname') . " ]";
				$this->log_act($log);

				$data['status'] = true;
				$data['msg'] = "Password updated!";
			}
		} else {
			$log = "Error sending mail - New Password [ Username: " . htmlentities($this->input->post('uname')) . ", Email: " . htmlentities($this->input->post('useremail')) . ", MailError: " . $eres . " ]";
			$this->log_act($log);

			$data['status'] = false;
			$data['msg'] = "Error sending mail";
		}

		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	//deactivate user account by themselves
	public function deact_account()
	{
		$this->checklogin();

		$act_res = $this->Usermodel->deact_account();

		if ($act_res === true) {
			$log = "Account deactivated [ Username: " . $this->session->userdata('mr_uname') .  " ]";
			$this->log_act($log);

			$data['status'] = true;
			$data['msg'] = "Account deactivated";
			$data['redirect'] = base_url('logout');
		} else {
			$log = "Error deactivating account [ Username: " . $this->session->userdata('mr_uname') .  " ]";
			$this->log_act($log);

			$data['status'] = false;
			$data['msg'] = "Error deactivating account";
		}

		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	//rating report
	//shared links report
	public function report()
	{
		$this->checklogin();

		$this->setTabUrl($mod = 'report');

		$data['title'] = "report";

		$data['rr'] = $this->Usermodel->allrrbyuser();
		$data['ls'] = $this->Usermodel->allsentlinksbyuser();
		$data['web'] = $this->Usermodel->get_user_websites();

		$data['t_mail'] = $this->Usermodel->total_email();
		$data['t_sms'] = $this->Usermodel->total_sms();
		$data['t_wp'] = $this->Usermodel->total_wapp();

		if ($this->session->userdata('mr_sadmin') === '1' || $this->session->userdata('mr_admin') === '1') {
			$data['allrr'] = $this->Usermodel->allrr();
			$data['allls'] = $this->Usermodel->allsentlinks();
			$data['allweb'] = $this->Usermodel->allwebsites(); //platforms

			$data['allt_mail'] = $this->Usermodel->allemail();
			$data['allt_sms'] = $this->Usermodel->allsms();
			$data['allt_wp'] = $this->Usermodel->allwapp();
		}

		$this->load->view('templates/header', $data);
		$this->load->view('users/report', $data);
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
			$txt = "Click the link below, to rate any of my platforms\n";
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

	//message body to be shared asper plarform selected
	public function getPlatformLink()
	{
		if ($this->ajax_checklogin() === false) {
			$data['status'] = "error";
			$data['redirect'] = base_url("logout");
		} else {

			$id = htmlentities($_POST['platformid']);
			$res = $this->Usermodel->edit_website($id);

			if ($res == false) {

				$data['status'] = false;
				$data['msg'] = "Error retrieving data";
			} else {
				$myfile = fopen("body.txt", "w") or die("Unable to open file!");
				if (($res->description) && !empty($res->description)) {
					$txt = $res->description . "\n";
					fwrite($myfile, $txt);
				}
				$txt = base_url() . "wtr/" . $this->session->userdata("mr_form_key") . "/" . $res->id . "\n";
				fwrite($myfile, $txt);
				fclose($myfile);

				$data['status'] = true;
				$data['res'] = $res;
				$data['body'] = file_get_contents(base_url('body.txt'));
			}
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

		$data['platforms'] = $this->Usermodel->get_user_websites();

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

		$this->form_validation->set_rules('foremailplatform', 'Platform', 'required|trim|html_escape');
		$this->form_validation->set_rules('email', 'E-mail', 'required|trim|valid_email|html_escape');
		$this->form_validation->set_rules('subj', 'Subject', 'required|trim|html_escape');
		$this->form_validation->set_rules('emailbdy', 'Body', 'required|trim|html_escape');

		if ($this->form_validation->run() == false) {
			$data['platforms'] = $this->Usermodel->get_user_websites();

			$this->load->view('templates/header', $data);
			$this->load->view('users/share');
			$this->load->view('templates/footer');
		} else {
			$cq_res = $this->Usermodel->is_userquotaexpired($qType = 'email_quota');

			if ($cq_res === "not_Found") {
				$this->logout();
			} else if ($cq_res === 'pending_balance') { //check payment
				if ($this->session->userdata('mr_iscmpy') == '1' && $this->session->userdata('mr_sadmin') == '0') {
					$this->setFlashMsg('error', 'Pending Payment. Contact your company Admin');
				} else {
					$this->setFlashMsg('error', 'Pending Payment');
					redirect('account#plan');
				}

				$log = "Pending Payment [ Username: " . $this->session->userdata('mr_uname') . " ]";
				$this->log_act($log);
			} else if ($this->session->userdata('mr_sub') !== '1') { //check subscription
				if ($this->session->userdata('mr_iscmpy') == '1' && $this->session->userdata('mr_sadmin') == '0') {
					$sessmsg = 'Your subscriptiontion isn\'t active. Contact your company Admin';
				} else {
					$sessmsg = 'Your subscriptiontion isn\'t active. Contact us if you have a valid quota';
				}

				$log = "Inactive subscription [ Username: " . $this->session->userdata('mr_uname') . " ]";
				$this->log_act($log);

				$this->setFlashMsg('error', $sessmsg);
			} else if ($cq_res !== false) { //invalid quota (quota expired)
				$usermail_expire = $cq_res;
				if (filter_var($usermail_expire, FILTER_VALIDATE_EMAIL)) {
					$this->load->library('emailconfig');
					$this->emailconfig->quota_send_mail_expire($usermail_expire);
				}

				$log = "Quota Expired [ Username: " . $this->session->userdata('mr_uname') . " ]";
				$this->log_act($log);

				$this->setFlashMsg('error', 'Quota expired');
			} else if ($cq_res === false) { //valid quota

				//check given email is valid
				if (!filter_var($this->input->post('email'), FILTER_VALIDATE_EMAIL)) {
					$this->setFlashMsg('error', '(' . $this->input->post('email') . ') is an invalid email');
				} else {
					$email = htmlentities($this->input->post('email'));
					$subj = htmlentities($this->input->post('subj'));
					$bdy = htmlentities($this->input->post('emailbdy'));

					$this->load->library('emailconfig');
					$mail_res = $this->emailconfig->link_send_mail($email, $subj, $bdy);
					// $mail_res = true;

					if ($mail_res !== true) {
						$log = "Error sharing - Email share [ Username: " . $this->session->userdata('mr_uname') . ", Email: " . htmlentities($this->input->post('email')) . ", MailError: " . $mail_res . " ]";
						$this->log_act($log);

						$this->setFlashMsg('error', lang('mail_error'));
					} else {
						$log = "Shared - Email share [ Username: " . htmlentities($this->input->post('uname')) . ", Email: " . htmlentities($this->input->post('email')) . " ]";
						$this->log_act($log);

						//save to DB and deduct from quota
						$this->Usermodel->email_saveinfo();
						$this->setFlashMsg('success', 'Link sent successfully');
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

		$this->form_validation->set_rules('forsmsplatform', 'Platform', 'required|trim|html_escape');
		$this->form_validation->set_rules('mobile', 'Mobile', 'required|exact_length[10]|trim|html_escape');
		$this->form_validation->set_rules('smsbdy', 'Body', 'required|trim|html_escape');

		if ($this->form_validation->run() == FALSE) {
			$data['platforms'] = $this->Usermodel->get_user_websites();

			$this->load->view('templates/header', $data);
			$this->load->view('users/share');
			$this->load->view('templates/footer');
		} else {
			$cq_res = $this->Usermodel->is_userquotaexpired($qType = 'sms_quota');

			if ($cq_res === "not_Found") {
				$this->logout();
			} else if ($cq_res === 'pending_balance') { //check payment
				if ($this->session->userdata('mr_iscmpy') == '1' && $this->session->userdata('mr_sadmin') == '0') {
					$this->setFlashMsg('error', 'Pending Payment. Contact your company Admin');
				} else {
					$this->setFlashMsg('error', 'Pending Payment');
					redirect('account#plan');
				}

				$log = "Pending Payment [ Username: " . $this->session->userdata('mr_uname') . " ]";
				$this->log_act($log);
			} else if ($this->session->userdata('mr_sub') !== '1') { //check subscription
				if ($this->session->userdata('mr_iscmpy') == '1' && $this->session->userdata('mr_sadmin') == '0') {
					$sessmsg = 'Your subscriptiontion isn\'t active. Contact your company Admin!';
				} else {
					$sessmsg = 'Your subscriptiontion isn\'t active. Contact us if you have a valid quota';
				}

				$log = "Inactive subscription [ Username: " . $this->session->userdata('mr_uname') . " ]";
				$this->log_act($log);

				$this->setFlashMsg('error', $sessmsg);
			} else if ($cq_res !== false) { //invalid quota (expired)
				$usermail_expire = $cq_res;
				if (filter_var($usermail_expire, FILTER_VALIDATE_EMAIL)) {
					$this->load->library('emailconfig');
					$this->emailconfig->quota_send_mail_expire($usermail_expire);
				}

				$log = "Quota Expired [ Username: " . $this->session->userdata('mr_uname') . " ]";
				$this->log_act($log);

				$this->setFlashMsg('error', 'Quota expired');
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
					$log = "Error sharing - SMS share [ Username: " . $this->session->userdata('mr_uname') . ", Mobile: " . htmlentities($this->input->post('mobile')) . ", SMSError: " . $httpCode . " ]";
					$this->log_act($log);

					$this->setFlashMsg('error', $httpCode . " - SERVER ERROR");
				} else {
					if ($Jresult['STATUS'] == "ERROR") {
						$log = "Error sharing - SMS share [ Username: " . $this->session->userdata('mr_uname') . ", Mobile: " . htmlentities($this->input->post('mobile')) . ", SMSError: " . $Jresult['RESPONSE']['CODE'] . ' - ' . $Jresult['RESPONSE']['INFO'] . " ]";
						$this->log_act($log);

						$this->setFlashMsg('error', $Jresult['RESPONSE']['CODE'] . ' - ' . $Jresult['RESPONSE']['INFO']);
					} else {
						$log = "Shared - SMS share [ Username: " . $this->session->userdata('mr_uname') . ", Mobile: " . htmlentities($this->input->post('mobile')) . " ]";
						$this->log_act($log);

						$this->Usermodel->sms_saveinfo();
						$this->setFlashMsg('success', 'SMS sent successfully');
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
			} else if ($cq_res === 'pending_balance') { //check payment
				if ($this->session->userdata('mr_iscmpy') == '1' && $this->session->userdata('mr_sadmin') == '0') {
					$data['status'] = false;
					$data['msg'] = 'Pending Payment. Contact your company Admin';
				} else {
					$data['status'] = "error";
					$data['redirect'] = base_url("account#plan");
				}

				$log = "Pending Payment [ Username: " . $this->session->userdata('mr_uname') . " ]";
				$this->log_act($log);
			} else if ($this->session->userdata('mr_sub') !== '1') {
				if ($this->session->userdata('mr_iscmpy') == '1' && $this->session->userdata('mr_sadmin') == '0') {
					$sessmsg = 'Your subscriptiontion isn\'t active. Contact your company Admin!';
				} else {
					$sessmsg = 'Your subscriptiontion isn\'t active. Contact us if you have a valid quota';
				}

				$log = "Inactive subscription [ Username: " . $this->session->userdata('mr_uname') . " ]";
				$this->log_act($log);

				$data['status'] = false;
				$data['msg'] = $sessmsg;
			} else if ($cq_res !== false) {
				$usermail_expire = $cq_res;
				if (filter_var($usermail_expire, FILTER_VALIDATE_EMAIL)) {
					$this->load->library('emailconfig');
					$this->emailconfig->quota_send_mail_expire($usermail_expire);
				}

				$log = "Quota Expired [ Username: " . $this->session->userdata('mr_uname') . " ]";
				$this->log_act($log);

				$data['status'] = false;
				$data['msg'] = 'Quota expired';
			} else if ($cq_res === false) {

				$mobile = $_POST['mobile'];
				$whpbdy = $_POST['whpbdy'];

				$this->Usermodel->whatsapp_saveinfo($mobile, $whpbdy);

				$data['status'] = true;
				$data['msg'] = 'Shared';

				$log = "Shared - Whatsapp share [ Username: " . $this->session->userdata('mr_uname') . ", Mobile: " . htmlentities($_POST['mobile']) . "]";
				$this->log_act($log);

				$this->setFlashMsg('success', $data['msg']);
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
			} else if ($cq_res === 'pending_balance') { //check payment
				if ($this->session->userdata('mr_iscmpy') == '1' && $this->session->userdata('mr_sadmin') == '0') {
					$data['status'] = false;
					$data['msg'] = 'Pending Payment. Contact your company Admin';
				} else {
					$data['status'] = "error";
					$data['redirect'] = base_url("account#plan");
				}

				$log = "Pending Payment [ Username: " . $this->session->userdata('mr_uname') . " ]";
				$this->log_act($log);
			} else if ($this->session->userdata('mr_sub') !== '1') {
				if ($this->session->userdata('mr_iscmpy') == '1' && $this->session->userdata('mr_sadmin') == '0') {
					$sessmsg = 'Your subscriptiontion isn\'t active. Contact your company Admin!';
				} else {
					$sessmsg = 'Your subscriptiontion isn\'t active. Contact us if you have a valid quota';
				}

				$log = "Inactive subscription [ Username: " . $this->session->userdata('mr_uname') . " ]";
				$this->log_act($log);

				$data['status'] = false;
				$data['msg'] = $sessmsg;
			} else if ($cq_res !== false) {
				$usermail_expire = $cq_res;
				if (filter_var($usermail_expire, FILTER_VALIDATE_EMAIL)) {
					$this->load->library('emailconfig');
					$this->emailconfig->quota_send_mail_expire($usermail_expire);
				}

				$log = "Quota Expired [ Username: " . $this->session->userdata('mr_uname') . " ]";
				$this->log_act($log);

				$data['status'] = false;
				$data['msg'] = 'Quota expired';
			} else if ($cq_res === false) {

				$emaildata = $_POST['emaildata'];
				$subj = $_POST['subj'];
				$bdy = $_POST['bdy'];
				$num = count($emaildata);

				$qbl_res = $this->Usermodel->get_userquota();

				if ($qbl_res->email_quota < $num) {
					$log = "Email quota not enough [ Username: " . $this->session->userdata('mr_uname') . " ]";
					$this->log_act($log);

					$data['status'] = false;
					$data['msg'] = 'Number of emails to be sent (' . $num . ') exceeds your quota (' . $qbl_res->email_quota . ').';
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

								$log = "Shared - Email share [ Username: " . $this->session->userdata('mr_uname') . ", Email: " . $mail . " ]";
								$this->log_act($log);
							} else {
								$log = "Error sharing - Email share [ Username: " . $this->session->userdata('mr_uname') . ", Email: " . $mail . ", MailError: " . $mailRes . " ]";
								$this->log_act($log);

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

							$this->setFlashMsg('success', $data['msg']);
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
			} else if ($cq_res === 'pending_balance') { //check payment
				if ($this->session->userdata('mr_iscmpy') == '1' && $this->session->userdata('mr_sadmin') == '0') {
					$data['status'] = false;
					$data['msg'] = 'Pending Payment. Contact your company Admin';
				} else {
					$data['status'] = "error";
					$data['redirect'] = base_url("account#plan");
				}

				$log = "Pending Payment [ Username: " . $this->session->userdata('mr_uname') . " ]";
				$this->log_act($log);
			} else if ($this->session->userdata('mr_sub') !== '1') {
				if ($this->session->userdata('mr_iscmpy') == '1' && $this->session->userdata('mr_sadmin') == '0') {
					$sessmsg = 'Your subscriptiontion isn\'t active. Contact your company Admin!';
				} else {
					$sessmsg = 'Your subscriptiontion isn\'t active. Contact us if you have a valid quota';
				}

				$log = "Inactive subscription [ Username: " . $this->session->userdata('mr_uname') . " ]";
				$this->log_act($log);

				$data['status'] = false;
				$data['msg'] = $sessmsg;
			} else if ($cq_res !== false) {
				$usermail_expire = $cq_res;
				if (filter_var($usermail_expire, FILTER_VALIDATE_EMAIL)) {
					$this->load->library('emailconfig');
					$this->emailconfig->quota_send_mail_expire($usermail_expire);
				}

				$log = "Quota Expired [ Username: " . $this->session->userdata('mr_uname') . " ]";
				$this->log_act($log);

				$data['status'] = false;
				$data['msg'] = 'Quota expired';
			} else if ($cq_res === false) {

				$mobiledata = $_POST['mobiledata'];
				$smsbdy = $_POST['smsbdy'];
				$num = count($mobiledata);

				$qbl_res = $this->Usermodel->get_userquota();

				if ($qbl_res->sms_quota < $num) {
					$log = "SMS quota not enough [ Username: " . $this->session->userdata('mr_uname') . " ]";
					$this->log_act($log);

					$data['status'] = false;
					$data['msg'] = 'Number of SMS to be sent (' . $num . ') exceeds your quota (' . $qbl_res->sms_quota . ').';
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

								$log = "Error sharing - SMS share [ Username: " . $this->session->userdata('mr_uname') . ", Mobile: " . $mobile . ", SMSError: " . $httpCode . " ]";
								$this->log_act($log);
							} else {
								if ($Jresult['STATUS'] == "ERROR") {
									array_push($mobilenotsentarr, array('mobile' => $mobile, 'errorCode' => $Jresult['RESPONSE']['CODE'], 'errorInfo' => $Jresult['RESPONSE']['INFO']));

									$log = "Error sharing - SMS share [ Username: " . $this->session->userdata('mr_uname') . ", Mobile: " . $mobile . ", SMSError: " . $Jresult['RESPONSE']['CODE'] . ' - ' . $Jresult['RESPONSE']['INFO'] . " ]";
									$this->log_act($log);
								} else {
									$this->Usermodel->multiplsms_saveinfo($mobile, $smsbdy);

									$log = "Shared - SMS share [ Username: " . $this->session->userdata('mr_uname') . ", Mobile: " . $mobile . "]";
									$this->log_act($log);
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

							$this->setFlashMsg('success', $data['msg']);
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
