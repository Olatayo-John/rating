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
			$this->setFlashMsg('error', lang('login_first'));
			redirect('logout');
		} else {
			if ($this->session->userdata('mr_sadmin') === "1") {
				return true;
			} else if ($this->session->userdata('mr_admin') === "1") {
				return true;
			} else {
				$this->setFlashMsg('error', lang('acc_denied'));
				return false;
			}
		}
	}

	public function is_admin()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->setFlashMsg('error', lang('login_first'));
			redirect('logout');
		} else {
			if ($this->session->userdata('mr_admin') === "1") {
				return true;
			} else {
				$this->setFlashMsg('error', lang('acc_denied'));
				return false;
			}
		}
	}

	public function is_sadmin()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->setFlashMsg('error', lang('login_first'));
			redirect('logout');
		} else {
			if ($this->session->userdata('mr_sadmin') === "1") {
				return true;
			} else {
				$this->setFlashMsg('error', lang('acc_denied'));
				return false;
			}
		}
	}



	public function adduser()
	{
		$data['title'] = "add user";
		$data['adminusers'] = $this->Adminmodel->get_adminusers();

		if ($data['adminusers']->num_rows() >= $this->session->userdata("mr_userspace")) {
			$this->setFlashMsg('error', "You have reached the number of users you can create (" . $this->session->userdata("mr_userspace") . ")");
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
			$this->load->view('admin/users/adduser');
			$this->load->view('templates/footer');
		} else {
			$fullname = htmlentities($this->input->post('fname')) . " " . htmlentities($this->input->post('lname'));
			$uname = htmlentities($this->input->post('uname'));
			$uname_form = str_replace(" ", "_", strtolower(substr($uname, 0, 5)));
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
				$this->setFlashMsg('error', $mail_res);
				redirect('adduser');
				exit();
			} else {
				$db_res = $this->Adminmodel->adduser($act_key, $form_key);
				if ($db_res !== TRUE) {
					$this->Logmodel->log_act($type = "db_err");
					$this->setFlashMsg('error', 'Error saving user details. Please try again');
					redirect('adduser');
					exit();
				} else {
					$this->Logmodel->log_act($type = "newuser");
					$this->setFlashMsg('success', 'User created.');
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

		// print_r($data['adminusers']);die;
		$this->load->view('templates/header', $data);
		$this->load->view('admin/users', $data);
		$this->load->view('templates/footer');
	}

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
			$this->setFlashMsg('success', 'User data deleted!');
		}

		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	public function admin_viewuser()
	{
		if ($this->is_admin() === false) return false;

		$data['uinfos'] = $this->Adminmodel->get_userinfo($_POST['user_id'], $_POST['form_key']);
		$data['udetails'] = $this->Adminmodel->get_userdetails($_POST['user_id'], $_POST['form_key']);
		$data['uquota'] = $this->Adminmodel->get_userquota($_POST['user_id'], $_POST['form_key'], $_POST['iscmpy'], $_POST['cmpyid']);
		$data['uwebs'] = $this->Adminmodel->get_userwebsites($_POST['user_id'], $_POST['form_key']);
		$data['uratings'] = $this->Adminmodel->get_userratings($_POST['form_key']);
		$data['ulinks'] = $this->Adminmodel->get_userlinks($_POST['user_id']);

		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	function user_profupdate()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->setFlashMsg('error', lang('acc_denied'));
			return false;
		}
		if ($this->session->userdata('mr_admin') == "0") {
			$this->setFlashMsg('error', lang('acc_denied'));
			return false;
		}
		$res = $this->Adminmodel->user_profupdate($_POST['user_id'], $_POST['form_key'], $_POST['uname'], $_POST['fname'], $_POST['lname'], $_POST['email'], $_POST['mobile']);
		// $res = false;
		if ($res !== true) {
			$this->Logmodel->log_act($type = "admin_upuerr");
			$data['res'] = "failed";
			$data['res_msg'] = "Error updating user details!";
		} else {
			$this->Logmodel->log_act($type = "admin_upu");
			$data['res'] = "success";
			$data['res_msg'] = "User profile updated!";
		}

		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	function user_webupdate()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->setFlashMsg('error', lang('acc_denied'));
			return false;
		}
		if ($this->session->userdata('mr_admin') == "0") {
			$this->setFlashMsg('error', lang('acc_denied'));
			return false;
		}
		$res = $this->Adminmodel->user_webupdate($_POST['id'], $_POST['user_id'], $_POST['form_key'], $_POST['web_name_edit'], $_POST['web_link_edit']);
		// $res = false;
		if ($res !== true) {
			$this->Logmodel->log_act($type = "admin_uwuerr");
			$data['res'] = "failed";
			$data['res_msg'] = "Error updating website!";
		} else {
			$this->Logmodel->log_act($type = "admin_uwu");
			$data['res'] = "success";
			$data['res_msg'] = "Website updated!";
		}

		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	public function add_website()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->setFlashMsg('error', lang('login_first'));
			redirect('login');
		}
		$res = $this->Adminmodel->add_website($_POST['user_id'], $_POST['form_key'], $_POST['active'], $_POST['web_name_add'], $_POST['web_link_add']);
		// $res = true;
		if (!$res) {
			$this->Logmodel->log_act($type = "admin_addwuerr");
			$data['res'] = "failed";
			$data['res_msg'] = "Failed to add website!";
		} else {
			$this->Logmodel->log_act($type = "admin_addw");
			$data['res'] = "success";
			$data['insert_id'] = $res;
			$data['res_msg'] = "Website added!";
		}

		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	function delete_user_web()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->setFlashMsg('error', lang('acc_denied'));
			return false;
		}
		if ($this->session->userdata('mr_admin') == "0") {
			$this->setFlashMsg('error', lang('acc_denied'));
			return false;
		}
		$res = $this->Adminmodel->delete_user_web($_POST['web_id'], $_POST['user_id'], $_POST['form_key'], $_POST['web_name'], $_POST['web_link']);
		// $res = false;
		if ($res !== true) {
			$this->Logmodel->log_act($type = "admin_delwerr");
			$data['res'] = "failed";
			$data['res_msg'] = "Error deleting website data!";
		} else {
			$this->Logmodel->log_act($type = "admin_delw");
			$data['res'] = "success";
			$data['res_msg'] = "Website data deleted!";
		}

		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	function deactivateuser()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->setFlashMsg('error', lang('acc_denied'));
			return false;
		}
		if ($this->session->userdata('mr_admin') == "0") {
			$this->setFlashMsg('error', lang('acc_denied'));
			return false;
		}
		$res = $this->Adminmodel->deactivateuser($_POST['user_id'], $_POST['user_form_key']);
		// $res = false;
		if ($res !== true) {
			$this->Logmodel->log_act($type = "admin_deauerr");
			$data['res'] = "failed";
			$data['res_msg'] = "Failed to de-activate user account!!";
		} else {
			$this->Logmodel->log_act($type = "admin_deau");
			$data['res'] = "success";
			$data['res_msg'] = "User account de-activated!";
		}

		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	function activateuser()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->setFlashMsg('error', lang('acc_denied'));
			return false;
		}
		if ($this->session->userdata('mr_admin') == "0") {
			$this->setFlashMsg('error', lang('acc_denied'));
			return false;
		}
		$res = $this->Adminmodel->activateuser($_POST['user_id'], $_POST['user_form_key']);
		// $res = false;
		if ($res !== true) {
			$this->Logmodel->log_act($type = "admin_auerr");
			$data['res'] = "failed";
			$data['res_msg'] = "Failed to activate user account!!";
		} else {
			$this->Logmodel->log_act($type = "admin_au");
			$data['res'] = "success";
			$data['res_msg'] = "User account activated!";
		}
		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	public function verify_user_sub()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->setFlashMsg('error', lang('login_first'));
			return false;
		}
		if ($this->session->userdata('mr_admin') == "0") {
			$this->setFlashMsg('error', lang('acc_denied'));
			return false;
		} else {
			$res = $this->Adminmodel->verify_user_sub($_POST['user_id'], $_POST['form_key'], $_POST['web_quota']);
			// $res = false;
			if ($res !== true) {
				$this->Logmodel->log_act($type = "admin_vusuberr");
				$data['res'] = "failed";
				$data['res_msg'] = "Unable to activate user subscription!";
			} else {
				$this->Logmodel->log_act($type = "admin_vusub");
				$data['res'] = "success";
				$data['res_msg'] = "User subscription activated";
			}

			$data['token'] = $this->security->get_csrf_hash();
			echo json_encode($data);
		}
	}

	public function unverify_user_sub()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->setFlashMsg('error', lang('login_first'));
			return false;
		}
		if ($this->session->userdata('mr_admin') == "0") {
			$this->setFlashMsg('error', lang('acc_denied'));
			return false;
		} else {
			$res = $this->Adminmodel->unverify_user_sub($_POST['user_id'], $_POST['form_key']);
			// $res = false;
			if ($res !== true) {
				$this->Logmodel->log_act($type = "admin_unvusuberr");
				$data['res'] = "failed";
				$data['res_msg'] = "Unable to de-activate user subscription!";
			} else {
				$this->Logmodel->log_act($type = "admin_unvusub");
				$data['res'] = "success";
				$data['res_msg'] = "User subscription de-activated!";
			}

			$data['token'] = $this->security->get_csrf_hash();
			echo json_encode($data);
		}
	}

	public function updateuser_quota()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->setFlashMsg('error', lang('login_first'));
			return false;
		}
		if ($this->session->userdata('mr_admin') == "0") {
			$this->setFlashMsg('error', lang('acc_denied'));
			return false;
		} else {
			if ((!is_int(json_decode($_POST['web_quota']))) || (!is_int(json_decode($_POST['used']))) || (!is_int(json_decode($_POST['bought']))) || (!is_int(json_decode($_POST['balance'])))) {
				$data['res'] = "failed";
				$data['res_msg'] = "Invalid data type entered";
			} else {
				$wres = $this->Adminmodel->updateuser_webquota($_POST['user_id'], $_POST['form_key'], $_POST['web_quota']);
				$res = $this->Adminmodel->updateuser_quota($_POST['user_id'], $_POST['form_key'], $_POST['bought'], $_POST['used'], $_POST['balance']);

				// $res = true;
				if ($wres !== true || $res !== true) {
					$this->Logmodel->log_act($type = "admin_uuqerr");
					$data['res'] = "failed";
					$data['res_msg'] = "Failed to update quota details!";
				} else {
					$this->Logmodel->log_act($type = "admin_uuq");
					$data['res'] = "success";
					$data['res_msg'] = "Quota details updated!";
				}
			}

			$data['token'] = $this->security->get_csrf_hash();
			echo json_encode($data);
		}
	}

	function user_accupdate()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->setFlashMsg('error', lang('acc_denied'));
			return false;
		}
		if ($this->session->userdata('mr_admin') == "0") {
			$this->setFlashMsg('error', lang('acc_denied'));
			return false;
		}
		$res = $this->Adminmodel->user_accupdate($_POST['user_id'], $_POST['form_key'], $_POST['new_pwd']);
		// $res = false;
		if ($res !== true) {
			$data['res'] = "failed";
			$data['res_msg'] = 'Error changing user password!';
		} else {
			$uname = $_POST['uname'];
			$randpwd = $_POST['new_pwd'];
			$email = $_POST['email'];
			$login_link = base_url();

			$res = $this->send_email_code($uname, $randpwd, $email, $login_link);
			// $res = true;
			if ($res !== true) {
				$this->Logmodel->log_act($type = "admin_upassuerr");
				$data['res'] = "failed";
				$data['res_msg'] = $res;
			} else {
				$this->Logmodel->log_act($type = "admin_upassu");
				$data['res'] = "success";
				$data['res_msg'] = "User credentials updated and sent!";
			}
		}

		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	//commented for now
	/* public function add_user()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->setFlashMsg('error', lang('login_first'));
			redirect('login');
		}
		if ($this->session->userdata('mr_admin') == "0") {
			$this->setFlashMsg('error', lang('acc_denied'));
			redirect('login');
		}
		$this->form_validation->set_rules('full_name', 'Full Name', 'required|trim|html_escape');
		$this->form_validation->set_rules('email', 'E-mail', 'trim|valid_email|html_escape');
		$this->form_validation->set_rules('mobile', 'Mobile', 'required|trim|html_escape');
		$this->form_validation->set_rules('eid', 'Employee ID', 'trim|html_escape');
		$this->form_validation->set_rules('dept', 'Department', 'trim|html_escape');

		if ($this->form_validation->run() === FALSE) {
			$data['details'] = $this->Adminmodel->get_user_details();
			$this->load->view('templates/header');
			$this->load->view('admin/index', $data);
			$this->load->view('templates/footer');
		} else {
			$rand =  mt_rand(0, 10000000);
			$randpwd =  mt_rand(0, 10000000);
			$form_key = md5($rand);
			$pwd = password_hash($randpwd, PASSWORD_DEFAULT);
			//$res= $this->Usermodel->register($form_key,$pwd);
			$res = true;
			if ($res !== TRUE) {
				$this->setFlashMsg('error', 'Registration Failed');
				redirect('register');
				exit();
			} else {
				if (isset($_POST['mail_chkbox']) && isset($_POST['mobile_chkbox'])) {
					$fname = $this->input->post('full_name');
					$email = $this->input->post('email');
					$link = base_url() . "rate/" . $form_key;
					$mobile = $this->input->post('mobile');
					$login_link = base_url();
					$res = $this->send_email_code($fname, $randpwd, $email, $link, $login_link);
					$this->setFlashMsg('success', 'User added. Login credentials sent to user e-mail and mobile');
					redirect($_SERVER['HTTP_REFERER']);;
				} elseif (isset($_POST['mail_chkbox'])) {
					$fname = $this->input->post('full_name');
					$email = $this->input->post('email');
					$link = base_url() . "rate/" . $form_key;
					$mobile = $this->input->post('mobile');
					$login_link = base_url();
					$res = $this->send_email_code($fname, $randpwd, $email, $link, $login_link);
					$this->setFlashMsg('success', 'User added. Login credentials sent to user e-mail');
					redirect($_SERVER['HTTP_REFERER']);
				} elseif (isset($_POST['mobile_chkbox'])) {
					require __DIR__ . '/twilosms.php';
					$this->setFlashMsg('success', 'User added. Login credentials sent to user mobile');
					redirect($_SERVER['HTTP_REFERER']);
				}
			}
		}
	} */

	public function send_email_code($uname, $randpwd, $email, $login_link)
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

		$body = "Hello " . $uname . "\n\nBelow are your login credentails:\nUsername: " . $uname . "\nPassword: " . $randpwd . "\n\nYou can login here " . $login_link . "\n\nIf you have any questions, send us an email at info@nktech.in.\n\nBest Regards,\nNKTECH\nhttps://nktech.in";

		$this->email->from('jvweedtest@gmail.com', 'Rating');
		$this->email->to($email);
		$this->email->subject("Login Credentials");
		$this->email->message($body);

		if ($this->email->send()) {
			return true;
		} else {
			return $this->email->print_debugger();
		}
	}

	public function votes($offset = 0)
	{
		$data['title'] = "reviews";

		if (!$this->session->userdata('mr_logged_in')) {
			$this->setFlashMsg('error', lang('login_first'));
			redirect('login');
		}
		if ($this->session->userdata('mr_admin') == "0") {
			$this->setFlashMsg('error', lang('acc_denied'));
			redirect('login');
		}
		$config['base_url'] = base_url() . "admin/votes/";
		$config['total_rows'] = $this->db->count_all('user_details');
		$config['per_page'] = 10;
		$config["uri_segment"] = 3;
		$config['attributes'] = array('class' => 'page-link');
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['prev_link'] = 'Previous';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = 'Next';
		$config['next_tag_open'] = '<li class="page-item">';
		$config['next_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="#" class="page-link">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';

		$this->pagination->initialize($config);
		$data['links'] = $this->pagination->create_links();

		$data['details'] = $this->Adminmodel->get_user_votes($config["per_page"], $offset);
		$data['get_total_ratings'] = $this->Adminmodel->get_total_ratings();
		$data['get_total_official'] = $this->Adminmodel->get_total_official();
		$data['get_total_google'] = $this->Adminmodel->get_total_google();
		$data['get_total_facebook'] = $this->Adminmodel->get_total_facebook();
		$data['get_total_gd'] = $this->Adminmodel->get_total_gd();
		$data['get_total_tp'] = $this->Adminmodel->get_total_tp();
		$data['get_total_other'] = $this->Adminmodel->get_total_other();

		// print_r($data['details']->result_array());
		// die;
		$this->load->view('templates/header', $data);
		$this->load->view('admin/votes', $data);
		$this->load->view('templates/footer');
	}

	public function votes_export_csv()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->setFlashMsg('error', lang('login_first'));
			redirect('login');
		}
		if ($this->session->userdata('mr_admin') == "0") {
			$this->setFlashMsg('error', lang('acc_denied'));
			redirect('user');
		}
		header("Content-Type: text/csv; charset=utf-8");
		header("Content-Disposition: attachment; filename=users.csv");
		$output = fopen("php://output", "w");
		fputcsv($output, array('ID', 'User', 'Total Reviews', 'SMS Sent', 'Email Sent'));
		$data = $this->Adminmodel->votes_export_csv();
		foreach ($data as $row) {
			fputcsv($output, $row);
		}
		fclose($output);
		$this->Logmodel->log_act($type = "votesscsv");
	}

	public function votes_reload_table()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->setFlashMsg('error', lang('login_first'));
			redirect('login');
		}
		if ($this->session->userdata('mr_admin') == "0") {
			$this->setFlashMsg('error', lang('acc_denied'));
			redirect('login');
		}
		$config['per_page'] = 10;
		$offset = 0;
		$output = "";

		$data = $this->Adminmodel->get_user_votes($config["per_page"], $offset);
		$output .= '<tr class="font-weight-bolder text-light text-center" style="background:#294a63;">
		<th>
		<div class="inh">
		<i class="fas fa-sort" name="uname" type="desc"></i>
		<span>User</span>
		</div>
		</th>
		<th>
		<div class="tr">
		<i class="fas fa-sort" name="total_ratings" type="desc"></i>
		<span>Reviews</span>
		</div class="icon">
		</th>
		<th>
		<div class="inh">
		<i class="fas fa-sort" name="total_sms" type="desc"></i>
		<span>SMS</span>
		</div class="icon">
		</th>
		<th>
		<div class="inh">
		<i class="fas fa-sort" name="total_email" type="desc"></i>
		<span>Email</span>
		</div class="icon">
		</th>
		<th>
		<div class="tr">
		<i class="fas fa-sort" name="form_key" type="desc"></i>
		<span>User Link</span>
		</div>
		</th>
		<th class="text-danger text-center font-weight-bolder">
		Reviews
		</th>
		</tr>';
		if ($data->num_rows() == 0) {
			$output .= '<tr class="text-dark">
			<td colspan="6" class="font-weight-bolder text-dark text-center">NO DATA FOUND</td>
			</tr>';
		} else {
			foreach ($data->result_array() as $info) {
				$output .= '<tr class="text-dark text-center">
				<td class="">' . $info["uname"] . '</td>
				<td class="tv">' . $info["total_ratings"] . '</td>
				<td class="tv">' . $info["total_sms"] . '</td>
				<td class="tv">' . $info["total_email"] . '</td>
				<td class="text-lowercase">' . base_url() . 'wtr/' . $info['form_key'] . '</td>
				<td class="font-weight-bolder">
				<button class="btn text-light vv_btn" form_key="' . $info['form_key'] . '" style="background:#294a63">
				<i class="fas fa-poll text-light"></i></button>
				</td>
				</tr>';
			}
		}
		echo $output;
	}

	public function votes_filter_param()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->setFlashMsg('error', lang('login_first'));
			redirect('login');
		}
		if ($this->session->userdata('mr_admin') == "0") {
			$this->setFlashMsg('error', lang('acc_denied'));
			redirect('login');
		}
		$data = $this->Adminmodel->votes_filter_param($_POST['param'], $_POST['type']);
		$output = "";
		$output .= '<tr class="font-weight-bolder text-light text-center" style="background:#294a63;">
		<th>
		<div class="inh">
		<i class="fas fa-sort" name="uname" type="desc"></i>
		<span>User</span>
		</div>
		</th>
		<th>
		<div class="tr">
		<i class="fas fa-sort" name="total_ratings" type="desc"></i>
		<span>Reviews</span>
		</div class="icon">
		</th>
		<th>
		<div class="inh">
		<i class="fas fa-sort" name="total_sms" type="desc"></i>
		<span>SMS</span>
		</div class="icon">
		</th>
		<th>
		<div class="inh">
		<i class="fas fa-sort" name="total_email" type="desc"></i>
		<span>Email</span>
		</div class="icon">
		</th>
		<th>
		<div class="tr">
		<i class="fas fa-sort" name="form_key" type="desc"></i>
		<span>User Link</span>
		</div>
		</th>
		<th class="text-danger text-center font-weight-bolder">
		Reviews
		</th>
		</tr>';
		if ($data->num_rows() == 0) {
			$output .= '<tr class="text-light">
			<td colspan="6" class="font-weight-bolder text-dark text-center">No data found</td>
			</tr>';
		} else {
			foreach ($data->result_array() as $info) {
				$output .= '<tr class="text-dark text-center">
				<td class="">' . $info["uname"] . '</td>
				<td class="tv">' . $info["total_ratings"] . '</td>
				<td class="tv">' . $info["total_sms"] . '</td>
				<td class="tv">' . $info["total_email"] . '</td>
				<td class="text-lowercase">' . base_url() . 'wtr/' . $info['form_key'] . '</td>
				<td class="font-weight-bolder">
				<button class="btn text-light vv_btn" form_key="' . $info['form_key'] . '" style="background:#294a63">
				<i class="fas fa-poll text-light"></i></button>
				</td>
				</tr>';
			}
		}
		echo $output;
	}

	public function votes_search_user()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->setFlashMsg('error', lang('login_first'));
			redirect('login');
		}
		if ($this->session->userdata('mr_admin') == "0") {
			$this->setFlashMsg('error', lang('acc_denied'));
			redirect('login');
		}
		$output = '';
		$query = '';
		if ($this->input->post('query')) {
			$query = $this->input->post('query');
		}
		$data = $this->Adminmodel->votes_search_user($query);
		$output .= '<tr class="font-weight-bolder text-light text-center" style="background:#294a63;">
		<th>
		<div class="inh">
		<span>User</span>
		</div>
		</th>
		<th>
		<div class="tr">
		<span>Reviews</span>
		</div class="icon">
		</th>
		<th>
		<div class="inh">
		<span>SMS</span>
		</div class="icon">
		</th>
		<th>
		<div class="inh">
		<span>Email</span>
		</div class="icon">
		</th>
		<th>
		<div class="tr">
		<span>User Link</span>
		</div>
		</th>
		<th class="text-danger text-center font-weight-bolder">
		Reviews
		</th>
		</tr>';
		if ($data->num_rows() == 0) {
			$output .= '<tr class="text-light">
			<td colspan="6" class="font-weight-bolder text-dark text-center">No data found</td>
			</tr>';
		} else {
			foreach ($data->result_array() as $info) {
				$output .= '<tr class="text-dark text-center">
				<td class="">' . $info["uname"] . '</td>
				<td class="tv">' . $info["total_ratings"] . '</td>
				<td class="tv">' . $info["total_sms"] . '</td>
				<td class="tv">' . $info["total_email"] . '</td>
				<td class="text-lowercase">' . base_url() . 'wtr/' . $info['form_key'] . '</td>
				<td class="font-weight-bolder">
				<button class="btn text-light vv_btn" form_key="' . $info['form_key'] . '" style="background:#294a63">
				<i class="fas fa-poll text-light"></i></button>
				</td>
				</tr>';
			}
		}
		echo $output;
	}

	public function votes_get_user()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->setFlashMsg('error', lang('login_first'));
			redirect('login');
		}
		if ($this->session->userdata('mr_admin') == "0") {
			$this->setFlashMsg('error', lang('acc_denied'));
			redirect('login');
		} else {
			$data['users'] = $this->Adminmodel->get_ratings($_POST['key']);
			$data['user_webs'] = $this->Adminmodel->getuserwebsites($_POST['key']);
			// $data['user_other_web'] = $this->Adminmodel->getuserotherwebsites($_POST['key']);
			$data['user_web_total'] = $this->Adminmodel->user_web_total($_POST['key']);
			$data['token'] = $this->security->get_csrf_hash();
			echo json_encode($data);
		}
	}

	public function indiv_votes_export_csv($key)
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->setFlashMsg('error', lang('login_first'));
			redirect('login');
		}
		if ($this->session->userdata('mr_admin') == "0") {
			$this->setFlashMsg('error', lang('acc_denied'));
			redirect('login');
		}
		header("Content-Type: text/csv; charset=utf-8");
		header("Content-Disposition: attachment; filename=user_votes.csv");
		$output = fopen("php://output", "w");
		fputcsv($output, array('ID', 'Name', 'Mobile', 'Star', 'Website', 'IP', 'Date'));
		$data = $this->Adminmodel->indiv_votes_export_csv($key);
		foreach ($data as $row) {
			fputcsv($output, $row);
		}
		fclose($output);
	}

	public function search_ind_votes()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->setFlashMsg('error', lang('login_first'));
			redirect('login');
		}
		if ($this->session->userdata('mr_admin') == "0") {
			$this->setFlashMsg('error', lang('acc_denied'));
			redirect('login');
		}
		$output = '';
		$query = '';
		if ($this->input->post('query')) {
			$query = $this->input->post('query');
		}
		$data = $this->Adminmodel->search_ind_votes($query, $_POST['key']);
		// echo json_encode($data);
		$output .= '<table class="table table-bordered table-center table-hover tableuserreview" id="tableuserreview">
					<tr class="font-weight-bolder text-light text-center" style="background:#294a63;">
					<th><span class="icon">
					Name
					</span></th>
					<th><span>
					Mobile
					</span class="icon"></th>
					<th><span>
					Star
					</span></th>
					<th><span>
					Website
					</span class="icon"></th>
					<th><span>
					IP
					</span></th>
					<th class="text-danger"><span>
					Date
					</span></th>
					</tr>';
		if ($data == false) {
			$output .= '<tr class="text-dark truserreview">
			<td colspan="6" class="font-weight-bolder text-dark text-center">No data found</td>
			</tr>';
		} else {
			foreach ($data->result_array() as $info) {
				$output .= '<tr class="text-dark text-center truserreview">
				<td class=" text-lowercase">' . $info["name"] . '</td>
				<td class="">' . $info["mobile"] . '</td>
				<td class="">' . $info["star"] . '</td>
				<td class="">' . $info["web_name"] . '</td>
				<td class="">' . $info["user_ip"] . '</td>
				<td class="ftext-danger">' . $info["rated_at"] . '</td>
				</tr>';
			}
		}
		echo $output;
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

	public function reload_table_payments()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->setFlashMsg('error', lang('login_first'));
			redirect('login');
		}
		if ($this->session->userdata('mr_sadmin') == "0") {
			$this->setFlashMsg('error', lang('acc_denied'));
			redirect('login');
		}
		$output = '';
		$query = '';
		if ($this->input->post('query')) {
			$query = $this->input->post('query');
		}
		$data = $this->Adminmodel->get_all_payments($query);
		$output .= '<tr class="font-weight-bolder text-light text-center" style="background:#294a63;white-space: nowrap;">
						<th><span class="icon">
						Merchant ID
						</span></th>
						<th><span>
						Transaction ID
						</span class="icon"></th>
						<th><span>
						Order ID
						</span></th>
						<th><span>
						Payment Mode
						</span></th>
						<th><span>
						Gateway Mode
						</span></th>
						<th><span>
						Bank Name
						</span></th>
						<th><span>
						Bank ID
						</span></th>
						<th><span>
						Amount
						</span class="icon"></th>
						<th><span>
						Status
						</span></th>
						<th class="text-danger"><span>
						Date
						</span></th>
						</tr>';
		if ($data->num_rows() == 0) {
			$output .= '<tr class="text-light">
			<td colspan="10" class="font-weight-bolder text-dark text-center">No data found</td>
			</tr>';
		} else {
			foreach ($data->result_array() as $info) {
				$output .= ' <tr class="text-center">
				<td>' . $info["m_id"] . '</td>
				<td>' . $info["txn_id"] . '</td>
				<td>' . $info["order_id"] . '</td>
				<td>' . $info["payment_mode"] . '</td>
				<td>' . $info["gateway_name"] . '</td>
				<td>' . $info["bank_name"] . '</td>
				<td>' . $info["bank_txn_id"] . '</td>
				<td><i class="fas fa-rupee-sign"></i>' . $info["paid_amt"] . '</td>
				<td>' . $info["status"] . '</td>
				<td>' . $info["paid_at"] . '</td>
				</tr>';
			}
		}
		echo $output;
	}

	public function payments_export_csv()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->setFlashMsg('error', lang('login_first'));
			redirect('login');
		}
		if ($this->session->userdata('mr_sadmin') == "0") {
			$this->setFlashMsg('error', lang('acc_denied'));
			redirect('user');
		}
		header("Content-Type: text/csv; charset=utf-8");
		header("Content-Disposition: attachment; filename=payments.csv");
		$output = fopen("php://output", "w");
		fputcsv($output, array('ID', 'User ID', 'Merchant ID', 'Transaction ID', 'Order ID', 'Currency', 'Amount', 'Payment Mode', 'Gateway Mode', 'Bank Transaction ID', 'Bank Name', 'Status', 'Date'));
		$data = $this->Adminmodel->payments_export_csv();
		foreach ($data as $row) {
			fputcsv($output, $row);
		}
		fclose($output);
		$this->Logmodel->log_act($type = "paymentscsv");
	}

	public function payments_search()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->setFlashMsg('error', lang('login_first'));
			redirect('login');
		}
		if ($this->session->userdata('mr_sadmin') == "0") {
			$this->setFlashMsg('error', lang('acc_denied'));
			redirect('login');
		}
		$output = '';
		$query = '';
		if ($this->input->post('query')) {
			$query = $this->input->post('query');
		}
		$data = $this->Adminmodel->payments_search($query);
		$output .= '<tr class="font-weight-bolder text-light text-center" style="background:#294a63;white-space: nowrap;">
						<th><span class="icon">
						Merchant ID
						</span></th>
						<th><span>
						Transaction ID
						</span class="icon"></th>
						<th><span>
						Order ID
						</span></th>
						<th><span>
						Payment Mode
						</span></th>
						<th><span>
						Gateway Mode
						</span></th>
						<th><span>
						Bank Name
						</span></th>
						<th><span>
						Bank ID
						</span></th>
						<th><span>
						Amount
						</span class="icon"></th>
						<th><span>
						Status
						</span></th>
						<th class="text-danger"><span>
						Date
						</span></th>
						</tr>';
		if ($data->num_rows() == 0) {
			$output .= '<tr class="text-light">
			<td colspan="10" class="font-weight-bolder text-dark text-center">No data found</td>
			</tr>';
		} else {
			foreach ($data->result_array() as $info) {
				$output .= ' <tr class="text-center">
				<td>' . $info["m_id"] . '</td>
				<td>' . $info["txn_id"] . '</td>
				<td>' . $info["order_id"] . '</td>
				<td>' . $info["payment_mode"] . '</td>
				<td>' . $info["gateway_name"] . '</td>
				<td>' . $info["bank_name"] . '</td>
				<td>' . $info["bank_txn_id"] . '</td>
				<td><i class="fas fa-rupee-sign"></i>' . $info["paid_amt"] . '</td>
				<td>' . $info["status"] . '</td>
				<td>' . $info["paid_at"] . '</td>
				</tr>';
			}
		}
		echo $output;
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

		$body = "Dear Admin.\n\n New user Subscription for a new quota using PAYTM. Below are the payment details\n\nMerchant ID: " . $m_id . "\nTax ID: " . $txn_id . "\nOrder ID: " . $order_id . "\nAmount Paid: " . $user_amt . "\Quota Paid For: " . $quota . "\nPayment Mode: " . $payment_mode . "\nBank:" . $bank_name . "\nPayment Status: " . $status . "\n\nLogin " . base_url("/users") . " to verify payment and activate user subscription\n\nBest Regards,\nNKTECH\nhttps://nktech.in";

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
			$this->setFlashMsg('error', 'Error clearing data');
			redirect('activity');
		} else {
			$this->setFlashMsg('success', 'Activity Logs cleared!');
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
					$this->setFlashMsg('error', 'Error sending your message');
					redirect($_SERVER['HTTP_REFERER']);
				} else {
					$res = $this->Adminmodel->contact();
					$this->Logmodel->log_act($type = "cnt_us");
					$this->setFlashMsg('success', 'Message sent. We will get back to you as soon as possible');
					redirect($_SERVER['HTTP_REFERER']);
				}
			} else {
				$this->setFlashMsg('error', 'Google Recaptcha Unsuccessfull');
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
			$this->setFlashMsg('error', 'Error clearing data');
			redirect('feedbacks');
		} else {
			$this->setFlashMsg('success', 'Contacts cleared!');
			redirect('feedbacks');
		}
	}
}
