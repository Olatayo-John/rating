<?php
defined('BASEPATH') or exit('No direct script access allowed');
header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");
require_once(APPPATH . "libraries/paytm/config_paytm.php");
require_once(APPPATH . "libraries/paytm/encdec_paytm.php");

class Admin extends Admin_Controller
{
	public function index()
	{
		$this->is_sadmin();

		redirect('users');
	}

	public function users()
	{
		$this->is_bothadmin();

		$this->setTabUrl($mod = 'users');

		$data['title'] = "users";

		$data['allusers'] = $this->Adminmodel->get_allusers();

		$data['adminusers'] = $this->Adminmodel->get_adminusers();

		$this->load->view('templates/header', $data);
		$this->load->view('admin/users', $data);
		$this->load->view('templates/footer');
	}

	//create new user
	public function add()
	{
		$this->is_bothadmin();

		$this->setTabUrl($mod = 'users');

		$data['title'] = "new User";

		$data['allusers'] = $this->Adminmodel->get_allusers();

		$data['adminusers'] = $this->Adminmodel->get_adminusers();

		$this->load->view('templates/header', $data);
		if ($this->session->userdata('mr_sadmin') === "1") {
			$this->load->view('admin/users/adduser_sadmin', $data);
		}
		if ($this->session->userdata('mr_admin') === "1") {
			$this->load->view('admin/users/adduser_cmpy', $data);
		}
		$this->load->view('templates/footer');
	}

	//create a new user by a companyAdmin
	public function adduser_admin()
	{
		$this->is_admin();

		$this->setTabUrl($mod = 'users');

		$data['title'] = "new user";

		$this->form_validation->set_rules('fname', 'First Name', 'trim|html_escape');
		$this->form_validation->set_rules('lname', 'Last Name', 'trim|html_escape');
		$this->form_validation->set_rules('email', 'E-mail', 'required|trim|valid_email|html_escape');
		$this->form_validation->set_rules('mobile', 'Mobile', 'required|exact_length[10]|trim|html_escape');
		$this->form_validation->set_rules('uname', 'Username', 'required|trim|html_escape|is_unique[users.uname]', array('is_unique' => 'This username is taken'));
		$this->form_validation->set_rules('pwd', 'Password', 'required|trim|html_escape');

		if ($this->form_validation->run() === FALSE) {
			$this->setFlashMsg('error', validation_errors());
			redirect('add');
		} else {
			$fullname = htmlentities($this->input->post('fname')) . " " . htmlentities($this->input->post('lname'));
			$uname = htmlentities($this->input->post('uname'));
			$uname_form = str_replace([" ", ".", ",", "?", "&"], "_", strtolower(substr($uname, 0, 5)));
			$pwd = htmlentities($this->input->post('pwd'));
			$email = htmlentities($this->input->post('email'));

			if (isset($fullname) && !empty($fullname) && $fullname !== "") {
				$fulln = $fullname;
			} else {
				$fulln = $uname;
			}

			$cmpy = $this->session->userdata("mr_cmpy");
			$act_key =  mt_rand(0, 1000000);
			$form_key =  $uname_form . mt_rand(0, 100000);
			$link = base_url() . "emailverify/" . $form_key;

			//try sending email before inserting to DB
			if (isset($_POST['logincred'])) {
				$this->load->library('emailconfig');
				$mail_res = $this->emailconfig->new_companyuser($email, $fulln, $cmpy, $act_key, $link, $uname, $pwd);
			}
			// $mail_res = true;

			if ($mail_res !== TRUE) {
				$this->Logmodel->log_act($type = "mail_err");
				$this->setFlashMsg('error', $mail_res);
			} else {
				$db_res = $this->Adminmodel->adminadduser($act_key, $form_key);
				if ($db_res !== TRUE) {
					$this->Logmodel->log_act($type = "db_err");
					$this->setFlashMsg('error', 'Error saving user details. Please try again');
				} else {
					$this->Logmodel->log_act($type = "newuser");
					$this->setFlashMsg('success', 'User created.');
					redirect('users');
				}
			}
		}

		redirect('add');
	}

	//create a new user by sAdmin
	public function adduser_sadmin()
	{
		$this->is_sadmin();

		$this->setTabUrl($mod = 'users');

		$data['title'] = "new user";

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

		if (!$this->form_validation->run()) {
			$this->setFlashMsg('error', validation_errors());
			redirect('add');
		} else {
			$fullname = htmlentities($this->input->post('fname')) . " " . htmlentities($this->input->post('lname'));
			$uname = htmlentities($this->input->post('uname'));
			$uname_form = str_replace([" ", ".", ",", "?", "&"], "_", strtolower(substr($uname, 0, 5)));
			$pwd = htmlentities($this->input->post('pwd'));
			$email = htmlentities($this->input->post('email'));

			if (isset($fullname) && !empty($fullname) && $fullname !== "") {
				$fulln = $fullname;
			} else {
				$fulln = $uname;
			}

			$act_key =  mt_rand(0, 1000000);
			$form_key =  $uname_form . mt_rand(0, 100000);
			$link = base_url() . "emailverify/" . $form_key;

			if (isset($_POST['logincred'])) {
				$this->load->library('emailconfig');
				$mail_res = $this->emailconfig->new_user_by_sadmin($email, $fulln, $act_key, $link, $uname, $pwd);
			}
			// $mail_res = true;

			if ($mail_res !== true) {
				$this->Logmodel->log_act($type = "mail_err");
				$this->setFlashMsg('error', $mail_res);
			} else {
				//default for users not a company
				$admin = $iscmpy = 0;

				if (isset($_POST['cmpychkb'])) {
					$admin = $iscmpy = 1;
				}

				$db_res = $this->Adminmodel->sadminadduser($act_key, $form_key, $admin, $iscmpy);
				if ($db_res !== TRUE) {
					$this->Logmodel->log_act($type = "db_err");
					$this->setFlashMsg('error', 'Error saving user details. Please try again');
				} else {
					$this->Logmodel->log_act($type = "newuser");
					$this->setFlashMsg('success', 'User created.');
				}
			}
		}

		redirect('add');
	}

	//get user details [companyAdmin]
	public function viewuser_admin()
	{
		if ($this->ajax_is_admin() === false) {
			$data['status'] = false;
			$data['msg'] = lang('acc_denied');
		} else {
			$data['status'] = true;
			$data['uinfos'] = $this->Adminmodel->get_userinfo($_POST['user_id'], $_POST['form_key']);
			$data['uquota'] = $this->Adminmodel->admin_get_userQuota($_POST['user_id'], $_POST['form_key'], $_POST['iscmpy'], $_POST['cmpyid']);
			$data['uwebs'] = $this->Adminmodel->get_userwebsites($_POST['user_id'], $_POST['form_key']);
			$data['uratings'] = $this->Adminmodel->get_userratings($_POST['form_key']);
			$data['ulinks'] = $this->Adminmodel->get_userlinks($_POST['user_id']);

			$data['temail'] = $this->Adminmodel->get_usertotalemail($_POST['user_id']);
			$data['tsms'] = $this->Adminmodel->get_usertotalsms($_POST['user_id']);
			$data['twhp'] = $this->Adminmodel->get_usertotalwhp($_POST['user_id']);
		}

		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	//update profile details
	public function updateprofile_admin()
	{
		if ($this->ajax_is_admin() === false) {
			$data['status'] = false;
			$data['msg'] = lang('acc_denied');
		} else {
			$res = $this->Adminmodel->updateprofile_admin($_POST['user_id'], $_POST['form_key'], $_POST['fname'], $_POST['lname'], $_POST['email'], $_POST['mobile'], $_POST['gender'], $_POST['dob']);
			// $res = true;
			if ($res !== true) {
				$this->Logmodel->log_act($type = "admin_upuerr");
				$data['status'] = false;
				$data['msg'] = "Error updating user details!";
			} else {
				$this->Logmodel->log_act($type = "admin_upu");
				$data['status'] = true;
				$data['msg'] = "User profile updated!";
				// $data['refdata'] = $this->Adminmodel->get_adminusers()->result();
			}
		}

		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	//de-activate user account
	function deactivateaccount_admin()
	{
		if ($this->ajax_is_admin() === false) {
			$data['status'] = false;
			$data['msg'] = lang('acc_denied');
		} else {
			$res = $this->Adminmodel->deactivateaccount_admin($_POST['user_id'], $_POST['form_key']);
			// $res = true;
			if ($res !== true) {
				$this->Logmodel->log_act($type = "admin_deauerr");
				$data['status'] = false;
				$data['msg'] = "Failed to de-activate user account!!";
			} else {
				$this->Logmodel->log_act($type = "admin_deau");
				$data['status'] = true;
				$data['msg'] = "User account de-activated!";
			}
		}

		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	//activate user account
	function activateaccount_admin()
	{
		if ($this->ajax_is_admin() === false) {
			$data['status'] = false;
			$data['msg'] = lang('acc_denied');
		} else {
			$res = $this->Adminmodel->activateaccount_admin($_POST['user_id'], $_POST['form_key']);
			// $res = true;
			if ($res !== true) {
				$this->Logmodel->log_act($type = "admin_auerr");
				$data['status'] = false;
				$data['msg'] = "Failed to activate user account!!";
			} else {
				$this->Logmodel->log_act($type = "admin_au");
				$data['status'] = true;
				$data['msg'] = "User account activated!";
			}
		}

		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	//de-activate user sub
	function deactivatesub_admin()
	{
		if ($this->ajax_is_admin() === false) {
			$data['status'] = false;
			$data['msg'] = lang('acc_denied');
		} else {
			$res = $this->Adminmodel->deactivatesub_admin($_POST['user_id'], $_POST['form_key']);
			// $res = true;
			if ($res !== true) {
				$this->Logmodel->log_act($type = "admin_unvusuberr");
				$data['status'] = false;
				$data['msg'] = "Unable to de-activate user subscription!";
			} else {
				$this->Logmodel->log_act($type = "admin_unvusub");
				$data['status'] = true;
				$data['msg'] = "User subscription de-activated!";
			}
		}

		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	//activate user sub
	function activatesub_admin()
	{
		if ($this->ajax_is_admin() === false) {
			$data['status'] = false;
			$data['msg'] = lang('acc_denied');
		} else {
			$res = $this->Adminmodel->activatesub_admin($_POST['user_id'], $_POST['form_key']);
			// $res = true;
			if ($res !== true) {
				$this->Logmodel->log_act($type = "admin_vusuberr");
				$data['status'] = false;
				$data['msg'] = "Unable to activate user subscription!";
			} else {
				$this->Logmodel->log_act($type = "admin_vusub");
				$data['status'] = true;
				$data['msg'] = "User subscription activated";
			}
		}

		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	//update user password
	function updatepassword_admin()
	{
		if ($this->ajax_is_admin() === false) {
			$data['status'] = false;
			$data['msg'] = lang('acc_denied');
		} else {
			if ($_POST['logincred'] === "true") {
				$this->load->library('emailconfig');
				$mail_res = $this->emailconfig->resetpassword($_POST['user_email'], $_POST['rspwd'], $_POST['user_name']);
				// $mail_res = true;

				if ($mail_res == true) {
					$res = $this->Adminmodel->updatepassword_admin($_POST['user_id'], $_POST['rspwd']);
					// $res = true;
					if ($res !== true) {
						$this->Logmodel->log_act($type = "admin_upassuerr");
						$data['status'] = false;
						$data['msg'] = "Error updating user password";
					} else {
						$this->Logmodel->log_act($type = "admin_upassu");
						$data['status'] = true;
						$data['msg'] = "User password updated";
					}
				} else {
					$this->Logmodel->log_act($type = "mail_err");
					$data['status'] = false;
					$data['msg'] = "Error sending mail";
				}
			} else {
				$data['status'] = false;
				$data['msg'] = "Please check the box";
			}
		}

		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}


	public function payments()
	{
		$data['title'] = "payments";

		if (!$this->session->userdata('mr_logged_in')) {
			$this->setFlashMsg('error', lang('login_first'));
			redirect('/');
		}
		if ($this->session->userdata('mr_sadmin') == "0") {
			$this->setFlashMsg('error', lang('acc_denied'));
			redirect('/');
		}

		$data['pays'] = $this->Adminmodel->get_all_payments();
		$this->load->view('templates/header', $data);
		$this->load->view('admin/payments');
		$this->load->view('templates/footer');
	}

	public function pick_plan()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->setFlashMsg('error', lang('login_first'));
			redirect('user');
		}
		$this->load->view('templates/header');
		$this->load->view('admin/pick_plan');
		$this->load->view('templates/footer');
	}

	public function save_plan()
	{
		$checkSum = "";
		$data = array();

		$data["MID"] = PAYTM_MERCHANT_MID;
		$data["CUST_ID"] = $this->session->userdata('mr_id');
		$data["ORDER_ID"] = mt_rand(0, 10000000);
		$data["INDUSTRY_TYPE_ID"] = "Retail";
		$data["CHANNEL_ID"] = "WEB";
		$data["TXN_AMOUNT"] = $this->input->post('plan_amount');
		$data["WEBSITE"] = PAYTM_MERCHANT_WEBSITE;
		$data["CALLBACK_URL"] = base_url("admin/pgResponses");

		$checkSum = getChecksumFromArray($data, PAYTM_MERCHANT_KEY);

		$this->load->view('templates/header');
		$this->load->view('admin/pgresponse', ['paytm_info' => $data, 'checkSum' => $checkSum]);
		$this->load->view('templates/footer');
	}

	public function pgResponses()
	{
		$paytmChecksum = "";
		$paramList = array();
		$isValidChecksum = "FALSE";
		$paramList = $_POST;

		$paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : "";
		$isValidChecksum = verifychecksum_e($paramList, PAYTM_MERCHANT_KEY, $paytmChecksum);
		$userData = array(
			'm_id' => $_POST['MID'],
			'txn_id' => "",
			'order_id' => $_POST['ORDERID'],
			'currency' => $_POST['CURRENCY'],
			'paid_amt' => $_POST['TXNAMOUNT'],
			'payment_mode' => "",
			'gateway_name' => "",
			'bank_txn_id' => "",
			'bank_name' => "",
			'status' => $_POST['STATUS'],
		);
		if ($isValidChecksum == "TRUE") {
			if ($_POST["STATUS"] == "TXN_SUCCESS") {
				if (isset($_POST) && count($_POST) > 0) {

					$userData = array(
						'm_id' => $_POST['MID'],
						'txn_id' => $_POST['TXNID'],
						'order_id' => $_POST['ORDERID'],
						'currency' => $_POST['CURRENCY'],
						'paid_amt' => $_POST['TXNAMOUNT'],
						'payment_mode' => $_POST['PAYMENTMODE'],
						'gateway_name' => $_POST['GATEWAYNAME'],
						'bank_txn_id' => $_POST['BANKTXNID'],
						'bank_name' => $_POST['BANKNAME'],
						'check_sum_hash' => $_POST['CHECKSUMHASH'],
						'status' => $_POST['STATUS'],
					);

					$this->Adminmodel->save_payment($userData);
					$admin_res = $this->Adminmodel->getsadmin();

					$admin_mail = $admin_res->email;
					$m_id = $_POST['MID'];
					$txn_id = $_POST['TXNID'];
					$order_id = $_POST['ORDERID'];
					$user_amt = $_POST['TXNAMOUNT'];
					$payment_mode = $_POST['PAYMENTMODE'];
					$bank_name = $_POST['BANKNAME'];
					$status = $_POST['STATUS'];

					if (isset($admin_mail)) {
						$this->notifyadmin($admin_mail, $m_id, $txn_id, $order_id, $user_amt, $payment_mode, $bank_name, $status);
					}

					$this->setFlashMsg('success', 'Payment Done. Please wait while we verify your payment');
					$this->load->view('templates/header');
					$this->load->view('admin/pay_status', ['userData' => $userData]);
					$this->load->view('templates/footer');
				} else {
					$this->setFlashMsg('error', 'Payment Failed.');
					$this->load->view('templates/header');
					$this->load->view('admin/pay_status', ['userData' => $userData]);
					$this->load->view('templates/footer');
				}
			} else {
				$this->setFlashMsg('error', 'Payment Failed.');
				$this->load->view('templates/header');
				$this->load->view('admin/pay_status', ['userData' => $userData]);
				$this->load->view('templates/footer');
			}
		} else {
			// $this->logout();
		}
	}

	public function notifyadmin($admin_mail, $m_id, $txn_id, $order_id, $user_amt, $payment_mode, $bank_name, $status)
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

		if ($user_amt == "500") {
			$quota = "500";
		} elseif ($user_amt == "1000") {
			$quota = "1000";
		} elseif ($user_amt == "1500") {
			$quota = "1500";
		} elseif ($user_amt == "2000") {
			$quota = "2000";
		}

		$body = "Dear Admin.\n\n New user subscribtion for a new quota using PAYTM. Below are the payment details\n\nMerchant ID: " . $m_id . "\nTax ID: " . $txn_id . "\nOrder ID: " . $order_id . "\nAmount Paid: " . $user_amt . "\Quota Paid For: " . $quota . "\nPayment Mode: " . $payment_mode . "\nBank:" . $bank_name . "\nPayment Status: " . $status . "\n\nLogin " . base_url("/users") . " to verify payment and activate user subscription\n\nBest Regards,\nNKTECH\nhttps://nktech.in";

		$this->email->from('jvweedtest@gmail.com', 'Rating');
		$this->email->to($admin_mail);
		$this->email->subject('New Subscription');
		$this->email->message($body);

		if ($this->email->send()) {
			return true;
		} else {
			return $this->email->print_debugger();
		}
	}

	public function logs()
	{
		$this->is_sadmin();

		$this->setTabUrl($mod = 'activity');

		$data['title'] = "activity logs";

		$data['logs'] = $this->Adminmodel->get_all_logs();

		$this->load->view('templates/header', $data);
		$this->load->view('admin/logs');
		$this->load->view('templates/footer');
	}

	public function clearlogs()
	{
		if ($this->ajax_is_sadmin() === true) {

			$res = $this->Adminmodel->clear_logs();

			if ($res !== true) {
				$this->setFlashMsg('error', 'Error clearing data');
			} else {
				$this->Logmodel->log_act($type = "logsclear");
				$this->setFlashMsg('success', 'Activity Logs Data cleared!');
			}
		}

		redirect('activity');
	}

	public function feedbacks()
	{
		$data['title'] = "feedbacks";

		$this->setTabUrl($mod = 'feedbacks');

		$this->is_sadmin();

		$data['feedbacks'] = $this->Adminmodel->get_feedbacks();

		$this->load->view('templates/header', $data);
		$this->load->view('admin/feedbacks', $data);
		$this->load->view('templates/footer');
	}

	public function clearfeedbacks()
	{
		if ($this->ajax_is_sadmin() === true) {

			$res = $this->Adminmodel->clear_feedbacks();

			if ($res !== true) {
				$this->setFlashMsg('error', 'Error clearing data');
			} else {
				$this->Logmodel->log_act($type = "feedbckclear");
				$this->setFlashMsg('success', 'Feedback Data cleared!');
			}
		}

		redirect('feedbacks');
	}

	public function support()
	{
		$data['title'] = "support";

		$this->setTabUrl($mod = 'support');

		$this->form_validation->set_rules('name', 'Full Name', 'required|trim|html_escape');
		$this->form_validation->set_rules('email', 'E-mail', 'required|trim|valid_email|html_escape');
		$this->form_validation->set_rules('msg', 'Message', 'required|trim|html_escape');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/contactus');
			$this->load->view('templates/footer');
		} else {
			$recaptchaResponse = trim($this->input->post('g-recaptcha-response'));
			$userIp = $this->input->ip_address();
			$secret = "6LdT_UIaAAAAAOM8F3GM2Koi4sTapfRwNMfYYAjS";

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

				$this->load->library('emailconfig');
				$mail_res = $this->emailconfig->support_mail($name, $user_mail, $bdy);
				// $mail_res = true;

				if ($mail_res !== true) {
					$this->Logmodel->log_act($type = "mail_err");
					$this->setFlashMsg('error', 'Error sending your message');
				} else {
					$res = $this->Adminmodel->contact();
					$this->Logmodel->log_act($type = "cnt_us");
					$this->setFlashMsg('success', 'Message sent. We will get back to you as soon as possible');
				}
			} else {
				$this->setFlashMsg('error', 'Google Recaptcha Unsuccessfull');
			}

			redirect('support');
		}
	}



	public function testCase()
	{
		$data['title'] = "test case";

		$this->setTabUrl($mod = 'test');

		// $this->is_sadmin();

		// $data['feedbacks'] = $this->Adminmodel->get_feedbacks();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/testCase', $data);
		$this->load->view('templates/footer');
	}
}
