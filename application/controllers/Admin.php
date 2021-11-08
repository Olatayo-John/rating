<?php
defined('BASEPATH') or exit('No direct script access allowed');
header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");
require_once(APPPATH . "libraries/paytm/config_paytm.php");
require_once(APPPATH . "libraries/paytm/encdec_paytm.php");

class Admin extends CI_Controller
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
			$data['title'] = "login";
			$this->load->view('templates/header', $data);
			$this->load->view('users/login');
			$this->load->view('templates/footer');
		}
	}

	public function is_bothadmin()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->session->set_flashdata('invalid', 'Please login first');
			redirect('logout');
		} else {
			if ($this->session->userdata('mr_sadmin') === "1") {
				return true;
			} else if ($this->session->userdata('mr_admin') === "1") {
				return true;
			} else {
				$this->session->set_flashdata('acces_denied', 'Access Denied.');
				return false;
			}
		}
	}

	public function is_admin()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->session->set_flashdata('invalid', 'Please login first');
			redirect('logout');
		} else {
			if ($this->session->userdata('mr_admin') === "1") {
				return true;
			} else {
				$this->session->set_flashdata('acces_denied', 'Access Denied.');
				return false;
			}
		}
	}

	public function is_sadmin()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->session->set_flashdata('invalid', 'Please login first');
			redirect('logout');
		} else {
			if ($this->session->userdata('mr_sadmin') === "1") {
				return true;
			} else {
				$this->session->set_flashdata('acces_denied', 'Access Denied.');
				return false;
			}
		}
	}



	public function adduser_cmpy()
	{
		$data['title'] = "add user";
		$data['adminusers'] = $this->Adminmodel->get_adminusers();

		if ($data['adminusers']->num_rows() >= $this->session->userdata("mr_userspace")) {
			$this->session->set_flashdata('invalid', "You have reached the number of users you can create (" . $this->session->userdata("mr_userspace") . ")");
			redirect('users');
		}

		$this->is_admin() === false ? redirect('users') : '';

		$this->form_validation->set_rules('fname', 'First Name', 'trim|html_escape');
		$this->form_validation->set_rules('lname', 'Last Name', 'trim|html_escape');
		$this->form_validation->set_rules('email', 'E-mail', 'required|trim|valid_email|html_escape');
		$this->form_validation->set_rules('mobile', 'Mobile', 'required|trim|html_escape');
		$this->form_validation->set_rules('uname', 'Username', 'required|trim|html_escape|is_unique[users.uname]', array('is_unique' => 'This username is taken'));
		$this->form_validation->set_rules('pwd', 'Password', 'required|trim|html_escape');

		if (!$this->form_validation->run()) {
			$this->load->view('templates/header', $data);
			$this->load->view('admin/users/adduser_cmpy');
			$this->load->view('templates/footer');
		} else {
			$fullname = htmlentities($this->input->post('fname')) . " " . htmlentities($this->input->post('lname'));
			$uname = htmlentities($this->input->post('uname'));
			$uname_form = str_replace([" ", ".", ",", "?", "&"], "_", strtolower(substr($uname, 0, 5)));
			$form_key =  $uname_form . mt_rand(0, 100000);

			$email = htmlentities($this->input->post('email'));
			if (isset($fullname) && !empty($fullname) && $fullname !== "") {
				$fulln = $fullname;
			} else {
				$fulln = $uname;
			}
			$cmpy = $this->session->userdata("mr_cmpy");
			$act_key =  mt_rand(0, 1000000);
			$link = base_url() . "emailverify/" . $form_key;
			$pwd = htmlentities($this->input->post('pwd'));

			$mail_res = true;
			if (isset($_POST['logincred'])) {
				$this->load->library('emailconfig');
				$mail_res = $this->emailconfig->new_companyuser($email, $fulln, $cmpy, $act_key, $link, $uname, $pwd);
			}

			if ($mail_res !== TRUE) {
				$this->Logmodel->log_act($type = "mail_err");
				$this->session->set_flashdata('invalid', $mail_res);
				redirect('adduser');
				exit();
			} else {
				$db_res = $this->Adminmodel->adduser($act_key, $form_key);
				if ($db_res !== TRUE) {
					$this->Logmodel->log_act($type = "db_err");
					$this->session->set_flashdata('invalid', 'Error saving user details. Please try again');
					redirect('adduser');
					exit();
				} else {
					$this->Logmodel->log_act($type = "newuser");
					$this->session->set_flashdata('valid', 'User created.');
					redirect('users');
					exit();
				}
			}
		}
	}

	public function users($offset = 0)
	{
		$data['title'] = "users";

		$this->is_bothadmin() === false ? redirect('share') : '';

		$data['adminusers'] = $this->Adminmodel->get_adminusers();
		$data['allusers'] = $this->Adminmodel->get_allusers();

		// print_r($data['allusers']);die;
		$this->load->view('templates/header', $data);
		$this->load->view('admin/users', $data);
		$this->load->view('templates/footer');
	}

	//disabled
	public function change_userstatus()
	{

		if ($this->is_admin() === false) return false;

		$res = $this->Adminmodel->change_userstatus($_POST['uact'], $_POST['uid'], $_POST['formkey']);

		if ($res !== true) {
			$this->Logmodel->log_act($type = "admin_userstatuserr");
			$data['res'] = "failed";
			$data['msg'] = "Unable to activate user account!";
		} else {
			$this->Logmodel->log_act($type = "admin_userstatus");
			$data['res'] = "success";
			$data['msg'] = "User account changed!";
		}

		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	//disabled
	public function admin_deleteuser()
	{
		if ($this->is_admin() === false) return false;

		// $res = $this->Adminmodel->admin_deleteuser($_POST['uid'], $_POST['formkey']);
		$res = true;
		if ($res !== true) {
			$this->Logmodel->log_act($type = "admin_deleteusererr");
			$data['res'] = "error";
			$data['msg'] = "Error deleting this user data";
		} else {
			$this->Logmodel->log_act($type = "admin_deleteuser");
			$data['res'] = "success";
			$data['msg'] = "User data deleted!";
			$this->session->set_flashdata('valid', 'User data deleted!');
		}

		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	public function admin_viewuser()
	{
		if ($this->is_bothadmin() === false) return false;

		$data['uinfos'] = $this->Adminmodel->get_userinfo($_POST['user_id'], $_POST['form_key']);
		$data['udetails'] = $this->Adminmodel->get_userdetails($_POST['user_id'], $_POST['form_key']);
		$data['uquota'] = $this->Adminmodel->get_userquota($_POST['user_id'], $_POST['form_key'], $_POST['iscmpy'], $_POST['cmpyid']);
		$data['uwebs'] = $this->Adminmodel->get_userwebsites($_POST['user_id'], $_POST['form_key']);
		$data['uratings'] = $this->Adminmodel->get_userratings($_POST['form_key']);
		$data['ulinks'] = $this->Adminmodel->get_userlinks($_POST['user_id']);

		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	public function admin_updateuserprofile()
	{
		if ($this->is_admin() === false) return false;

		$res = $this->Adminmodel->admin_updateuserprofile($_POST['user_id'], $_POST['form_key'], $_POST['fname'], $_POST['lname'], $_POST['email'], $_POST['mobile']);
		// $res = true;
		if ($res !== true) {
			$this->Logmodel->log_act($type = "admin_upuerr");
			$data['status'] = false;
			$data['msg'] = "Error updating user details!";
		} else {
			$this->Logmodel->log_act($type = "admin_upu");
			$data['status'] = true;
			$data['msg'] = "User profile updated!";
			$data['refdata'] = $this->Adminmodel->get_adminusers()->result();
		}

		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	function admin_deactivateaccount()
	{
		if ($this->is_admin() === false) return false;

		$res = $this->Adminmodel->admin_deactivateaccount($_POST['user_id'], $_POST['form_key']);
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

		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	function admin_activateaccount()
	{
		if ($this->is_admin() === false) return false;

		$res = $this->Adminmodel->admin_activateaccount($_POST['user_id'], $_POST['form_key']);
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
		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	function admin_deactivatesub()
	{
		if ($this->is_admin() === false) return false;

		$res = $this->Adminmodel->admin_deactivatesub($_POST['user_id'], $_POST['form_key']);
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

		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	function admin_activatesub()
	{
		if ($this->is_admin() === false) return false;

		if ($this->session->userdata("mr_sub") === "0") {
			$data['status'] = false;
			$data['msg'] = "Unable to activate user subscription. You have an in-active subscription as all user quota & subscription are tied to your account";
		} else {
			$res = $this->Adminmodel->admin_activatesub($_POST['user_id'], $_POST['form_key']);
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

	function admin_updateuserpwd()
	{
		if ($this->is_admin() === false) return false;

		if ($_POST['logincred'] === "true") {
			$this->load->library('emailconfig');
			$mail_res = $this->emailconfig->resetpassword($_POST['user_email'], $_POST['rspwd'],$_POST['user_name']);
			// $mail_res = true;

			if ($mail_res == true) {
				$res = $this->Adminmodel->admin_updateuserpwd($_POST['user_id'], $_POST['rspwd']);
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

		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	public function adduser_sadmin()
	{
		$data['title'] = "new user";

		$this->is_sadmin() === false ? redirect('users') : '';

		$this->form_validation->set_rules('fname', 'First Name', 'trim|html_escape');
		$this->form_validation->set_rules('lname', 'Last Name', 'trim|html_escape');
		$this->form_validation->set_rules('email', 'E-mail', 'required|trim|valid_email|html_escape');
		$this->form_validation->set_rules('mobile', 'Mobile', 'required|trim|html_escape');
		$this->form_validation->set_rules('uname', 'Username', 'required|trim|html_escape|is_unique[users.uname]', array('is_unique' => 'This username is taken'));
		$this->form_validation->set_rules('pwd', 'Password', 'required|trim|html_escape');

		if (!$this->form_validation->run()) {
			$this->load->view('templates/header', $data);
			$this->load->view('admin/users/adduser_sadmin');
			$this->load->view('templates/footer');
		} else {
			$fullname = htmlentities($this->input->post('fname')) . " " . htmlentities($this->input->post('lname'));
			$uname = htmlentities($this->input->post('uname'));
			$uname_form = str_replace([" ", ".", ",", "?", "&"], "_", strtolower(substr($uname, 0, 5)));
			$form_key =  $uname_form . mt_rand(0, 100000);

			$email = htmlentities($this->input->post('email'));
			if (isset($fullname) && !empty($fullname) && $fullname !== "") {
				$fulln = $fullname;
			} else {
				$fulln = $uname;
			}
			$cmpy = $this->session->userdata("mr_cmpy");
			$act_key =  mt_rand(0, 1000000);
			$link = base_url() . "emailverify/" . $form_key;
			$pwd = htmlentities($this->input->post('pwd'));

			$mail_res = true;
			if (isset($_POST['logincred'])) {
				$this->load->library('emailconfig');
				$mail_res = $this->emailconfig->new_companyuser($email, $fulln, $cmpy, $act_key, $link, $uname, $pwd);
			}

			if ($mail_res !== TRUE) {
				$this->Logmodel->log_act($type = "mail_err");
				$this->session->set_flashdata('invalid', $mail_res);
				redirect('adduser');
				exit();
			} else {
				$db_res = $this->Adminmodel->adduser($act_key, $form_key);
				if ($db_res !== TRUE) {
					$this->Logmodel->log_act($type = "db_err");
					$this->session->set_flashdata('invalid', 'Error saving user details. Please try again');
					redirect('adduser');
					exit();
				} else {
					$this->Logmodel->log_act($type = "newuser");
					$this->session->set_flashdata('valid', 'User created.');
					redirect('users');
					exit();
				}
			}
		}
	}


	public function payments()
	{
		$data['title'] = "payments";

		if (!$this->session->userdata('mr_logged_in')) {
			$this->session->set_flashdata('invalid', 'Please login first');
			redirect('/');
		}
		if ($this->session->userdata('mr_sadmin') == "0") {
			$this->session->set_flashdata('acces_denied', 'Access Denied.');
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
			$this->session->set_flashdata('invalid', 'Please login first');
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

					$this->session->set_flashdata('valid', 'Payment Done. Please wait while we verify your payment');
					$this->load->view('templates/header');
					$this->load->view('admin/pay_status', ['userData' => $userData]);
					$this->load->view('templates/footer');
				} else {
					$this->session->set_flashdata('invalid', 'Payment Failed.');
					$this->load->view('templates/header');
					$this->load->view('admin/pay_status', ['userData' => $userData]);
					$this->load->view('templates/footer');
				}
			} else {
				$this->session->set_flashdata('invalid', 'Payment Failed.');
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
		$this->is_sadmin() === false ? redirect('share') : '';

		$data['title'] = "logs";
		$data['logs'] = $this->Adminmodel->get_all_logs();
		$this->load->view('templates/header', $data);
		$this->load->view('admin/logs');
		$this->load->view('templates/footer');
	}

	public function clearlogs()
	{
		$this->is_sadmin() === false ? redirect('share') : '';

		$res = $this->Adminmodel->clear_logs();
		$this->Logmodel->log_act($type = "logsclear");

		if ($res !== true) {
			$this->session->set_flashdata('invalid', 'Error clearing data');
			redirect('activity');
		} else {
			$this->session->set_flashdata('valid', 'Activity Logs cleared!');
			redirect('activity');
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
					$this->session->set_flashdata('invalid', 'Error sending your message');
					redirect($_SERVER['HTTP_REFERER']);
				} else {
					$res = $this->Adminmodel->contact();
					$this->Logmodel->log_act($type = "cnt_us");
					$this->session->set_flashdata('valid', 'Message sent. We will get back to you as soon as possible');
					redirect($_SERVER['HTTP_REFERER']);
				}
			} else {
				$this->session->set_flashdata('invalid', 'Google Recaptcha Unsuccessfull');
				redirect($_SERVER['HTTP_REFERER']);
			}
		}
	}

	public function feedbacks()
	{
		$data['title'] = "feedbacks";

		$this->is_sadmin() === false ? redirect('share') : '';

		$data['feedbacks'] = $this->Adminmodel->get_feedbacks();
		$this->load->view('templates/header', $data);
		$this->load->view('admin/feedbacks', $data);
		$this->load->view('templates/footer');
	}

	public function clearfeedbacks()
	{
		$this->is_sadmin() === false ? redirect('share') : '';

		$res = $this->Adminmodel->clear_feedbacks();
		$this->Logmodel->log_act($type = "feedbckclear");

		if ($res !== true) {
			$this->session->set_flashdata('invalid', 'Error clearing data');
			redirect('feedbacks');
		} else {
			$this->session->set_flashdata('valid', 'Contacts cleared!');
			redirect('feedbacks');
		}
	}
}
