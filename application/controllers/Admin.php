<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . "libraries/razorpay/Razorpay.php");

use Razorpay\Api\Api;

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

		$data['plans'] = $this->Usermodel->get_plans();

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
				// $mail_res = false;
			}

			if ($mail_res !== true) {
				$log = "Error sending mail - New user by Admin [ Admin: " . $this->session->userdata('mr_uname') . ", Username: " . htmlentities($this->input->post('uname')) . ", Email: " . htmlentities($this->input->post('email')) . ", MailError: " . $mail_res . " ]";
				$this->log_act($log);

				$this->setFlashMsg('error', 'Error sending mail');
			} else {
				$db_res = $this->Adminmodel->adminadduser($act_key, $form_key);

				if ($db_res !== TRUE) {
					$log = "Error saving to Database - New user by Admin [ Admin: " . $this->session->userdata('mr_uname') . ", Username: " . htmlentities($this->input->post('uname')) . " ]";
					$this->log_act($log);

					$this->setFlashMsg('error', 'Error saving to Database');
				} else {
					$log = "New user by Admin [ Admin: " . $this->session->userdata('mr_uname') . ", Username: " . htmlentities($this->input->post('uname')) . ", Email: " . htmlentities($this->input->post('email')) . " ]";
					$this->log_act($log);

					$this->setFlashMsg('success', 'User created');
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
		if (isset($_POST['cmpychkb'])) {
			$this->form_validation->set_rules('cmpy', 'Company Name', 'trim|html_escape|required|is_unique[users.cmpy]', array('is_unique' => 'This Company already exist'));
		} else {
			$this->form_validation->set_rules('cmpy', 'Company Name', 'trim|html_escape|is_unique[users.cmpy]', array('is_unique' => 'This Company already exist'));
		}

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
				// $mail_res = true;
			}

			if ($mail_res !== true) {
				$log = "Error sending mail - New user by Admin [ Admin: " . $this->session->userdata('mr_uname') . ", Username: " . htmlentities($this->input->post('uname')) . ", Email: " . htmlentities($this->input->post('email')) . ", MailError: " . $mail_res . " ]";
				$this->log_act($log);

				$this->setFlashMsg('error', 'Error sending mail');
			} else {
				//default for users not a company
				$admin = $iscmpy = 0;

				if (isset($_POST['cmpychkb'])) {
					$admin = $iscmpy = 1;
				}

				$db_res = $this->Adminmodel->sadminadduser($act_key, $form_key, $admin, $iscmpy);

				if ($db_res !== TRUE) {
					$log = "Error saving to Database - New user by Admin [ Admin: " . $this->session->userdata('mr_uname') . ", Username: " . htmlentities($this->input->post('uname')) . " ]";
					$this->log_act($log);

					$this->setFlashMsg('error', 'Error saving to Database');
				} else {
					$log = "New user by Admin [ Admin: " . $this->session->userdata('mr_uname') . ", Username: " . htmlentities($this->input->post('uname')) . ", Email: " . htmlentities($this->input->post('email')) . " ]";
					$this->log_act($log);

					$this->setFlashMsg('success', 'User created.');
				}
			}
		}

		redirect('add');
	}

	//activate, de-activate user subscription
	function user_sub()
	{
		if ($this->ajax_is_bothadmin() === false) {
			$data['status'] = false;
			$data['msg'] = lang('acc_denied');
		} else {
			$sub = $_POST['user_sub'];
			($sub === '0') ? $user_sub = '1' : $user_sub = '0';
			$user_id = $_POST['user_id'];
			$user_formKey = $_POST['user_formKey'];

			$res = $this->Adminmodel->user_sub($user_sub, $user_id, $user_formKey);

			if ($res !== true) {
				$smsg = ($sub === '1') ? 'Failed to de-activate subscription' : 'Failed to activate subscription';

				$log = $smsg . " [ Admin: " . $this->session->userdata('mr_uname') . ", UserID: " . $user_id .  " ]";
				$this->log_act($log);

				$data['status'] = false;
				$data['msg'] = $smsg;
			} else {
				$smsg = ($sub === '1') ? 'Subscription de-activated' : 'Subscription activated';

				$log = $smsg . " [ Admin: " . $this->session->userdata('mr_uname') . ", UserID: " . $user_id .  " ]";
				$this->log_act($log);

				$data['status'] = true;
				$data['msg'] = $smsg;
			}
		}

		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}


	//get user details [Sadmin,companyAdmin]
	public function viewuser_admin()
	{
		if ($this->ajax_is_admin() === false) {
			$data['status'] = false;
			$data['msg'] = lang('acc_denied');
		} else {
			$data['status'] = true;
			$data['uinfos'] = $this->Adminmodel->get_userinfo($_POST['user_id'], $_POST['form_key']);
			// $data['uquota'] = $this->Adminmodel->admin_get_userQuota($_POST['user_id'], $_POST['form_key'], $_POST['iscmpy'], $_POST['cmpyid']);
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
	public function updateprofile()
	{
		if ($this->ajax_is_bothadmin() === false) {
			$data['status'] = false;
			$data['msg'] = lang('acc_denied');
		} else {
			$profileData = array(
				'fname' => htmlentities($_POST['fname']),
				'lname' => htmlentities($_POST['lname']),
				'email' => htmlentities($_POST['email']),
				'mobile' => htmlentities($_POST['mobile']),
				'gender' => htmlentities($_POST['gender']),
				'dob' => htmlentities($_POST['dob']),
			);
			$user_id = $_POST['user_id'];
			$form_key = $_POST['form_key'];

			$res = $this->Adminmodel->updateprofile($user_id, $form_key, $profileData);

			if ($res !== true) {
				$log = "Error updating profile [ Admin: " . $this->session->userdata('mr_uname') . ", Username: " . htmlentities($_POST['uname']) .  " ]";
				$this->log_act($log);

				$data['status'] = false;
				$data['msg'] = "Error updating profile";
			} else {
				$log = "Profile Updated [ Admin: " . $this->session->userdata('mr_uname') . ", Username: " . htmlentities($_POST['uname']) .  " ]";
				$this->log_act($log);

				$data['status'] = true;
				$data['msg'] = "Profile updated";
				// $data['refdata'] = $this->Adminmodel->get_adminusers()->result();
			}
		}

		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	//de-activate user account
	function deactivateaccount()
	{
		if ($this->ajax_is_bothadmin() === false) {
			$data['status'] = false;
			$data['msg'] = lang('acc_denied');
		} else {
			$res = $this->Adminmodel->deactivateaccount($_POST['user_id'], $_POST['form_key']);
			
			if ($res !== true) {
				$log = "Failed to deactivate account [ Admin: " . $this->session->userdata('mr_uname') . ", Username: " . htmlentities($_POST['user_name']) .  " ]";
				$this->log_act($log);

				$data['status'] = false;
				$data['msg'] = "Failed to deactivate account";
			} else {
				$log = "Account deactivated [ Admin: " . $this->session->userdata('mr_uname') . ", Username: " . htmlentities($_POST['user_name']) .  " ]";
				$this->log_act($log);

				$data['status'] = true;
				$data['msg'] = "Account deactivated";
			}
		}

		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	//activate user account
	function activateaccount()
	{
		if ($this->ajax_is_bothadmin() === false) {
			$data['status'] = false;
			$data['msg'] = lang('acc_denied');
		} else {
			$res = $this->Adminmodel->activateaccount($_POST['user_id'], $_POST['form_key']);
			
			if ($res !== true) {
				$log = "Failed to activate account [ Admin: " . $this->session->userdata('mr_uname') . ", Username: " . htmlentities($_POST['user_name']) .  " ]";
				$this->log_act($log);

				$data['status'] = false;
				$data['msg'] = "Failed to activate account";
			} else {
				$log = "Account activated [ Admin: " . $this->session->userdata('mr_uname') . ", Username: " . htmlentities($_POST['user_name']) .  " ]";
				$this->log_act($log);

				$data['status'] = true;
				$data['msg'] = "Account activated";
			}
		}

		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	//de-activate user sub
	function deactivatesub()
	{
		if ($this->ajax_is_bothadmin() === false) {
			$data['status'] = false;
			$data['msg'] = lang('acc_denied');
		} else {
			$res = $this->Adminmodel->deactivatesub($_POST['user_id'], $_POST['form_key']);
			
			if ($res !== true) {
				$log = "Failed to deactivate subscription [ Admin: " . $this->session->userdata('mr_uname') . ", Username: " . htmlentities($_POST['user_name']) .  " ]";
				$this->log_act($log);

				$data['status'] = false;
				$data['msg'] = "Failed to deactivate subscription";
			} else {
				$log = "Subscription deactivated [ Admin: " . $this->session->userdata('mr_uname') . ", Username: " . htmlentities($_POST['user_name']) .  " ]";
				$this->log_act($log);

				$data['status'] = true;
				$data['msg'] = "Subscription deactivated";
			}
		}

		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	//activate user sub
	function activatesub()
	{
		if ($this->ajax_is_bothadmin() === false) {
			$data['status'] = false;
			$data['msg'] = lang('acc_denied');
		} else {
			$res = $this->Adminmodel->activatesub($_POST['user_id'], $_POST['form_key']);
			
			if ($res !== true) {
				$log = "Failed to activate subscription [ Admin: " . $this->session->userdata('mr_uname') . ", Username: " . htmlentities($_POST['user_name']) .  " ]";
				$this->log_act($log);

				$data['status'] = false;
				$data['msg'] = "Failed to activate subscription";
			} else {
				$log = "Subscription activated [ Admin: " . $this->session->userdata('mr_uname') . ", Username: " . htmlentities($_POST['user_name']) .  " ]";
				$this->log_act($log);

				$data['status'] = true;
				$data['msg'] = "Subscription activated";
			}
		}

		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	//update user password
	function updatepassword()
	{
		if ($this->ajax_is_bothadmin() === false) {
			$data['status'] = false;
			$data['msg'] = lang('acc_denied');
		} else {
			if ($_POST['logincred'] === "true") {
				$this->load->library('emailconfig');
				$mail_res = $this->emailconfig->resetpassword($_POST['user_email'], $_POST['rspwd'], $_POST['user_name']);

				if ($mail_res === true) {
					$res = $this->Adminmodel->updatepassword($_POST['user_id'], $_POST['rspwd']);

					if ($res !== true) {
						$log = "Error updating password [ Admin: " . $this->session->userdata('mr_uname') . ", Username: " . htmlentities($_POST['user_name']) .  " ]";
						$this->log_act($log);

						$data['status'] = false;
						$data['msg'] = "Error updating password";
					} else {
						$log = "Password updated [ Admin: " . $this->session->userdata('mr_uname') . ", Username: " . htmlentities($_POST['user_name']) .  " ]";
						$this->log_act($log);

						$data['status'] = true;
						$data['msg'] = "Password updated";
					}
				} else {
					$log = "Error sending mail - Password Reset [ Admin: " . $this->session->userdata('mr_uname') . ", Username: " . htmlentities($_POST['user_name']) . ", Email: " . htmlentities($_POST['user_email']) . ", MailError: " . $mail_res . " ]";
					$this->log_act($log);

					$data['status'] = false;
					$data['msg'] = "Error sending mail";
				}
			} else {
				$data['status'] = false;
				$data['msg'] = "Please check the box";
			}
		}

		$data['mail_res'] = $mail_res;
		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	//get user details [companyAdmin]
	public function viewuser_sadmin()
	{
		if ($this->ajax_is_sadmin() === false) {
			$data['status'] = false;
			$data['msg'] = lang('acc_denied');
		} else {
			$user_id = $_POST['user_id'];
			$form_key = $_POST['form_key'];
			$iscmpy = $_POST['iscmpy'];
			$cmpyid = $_POST['cmpyid'];
			$isadmin = $_POST['isadmin'];

			$data['status'] = true;
			$data['uinfos'] = $this->Adminmodel->sadmin_get_userinfo($user_id, $form_key, $iscmpy, $isadmin);
			$data['uquota'] = $this->Adminmodel->sadmin_get_userQuota($user_id, $form_key, $iscmpy, $cmpyid);

			$data['uwebs'] = $this->Adminmodel->get_userwebsites($user_id, $form_key);
			$data['uratings'] = $this->Adminmodel->get_userratings($form_key);
			$data['ulinks'] = $this->Adminmodel->get_userlinks($user_id);
			$data['uusers'] = $this->Adminmodel->sadmin_get_adminusers($user_id, $form_key, $iscmpy, $cmpyid);

			$data['temail'] = $this->Adminmodel->get_usertotalemail($user_id);
			$data['tsms'] = $this->Adminmodel->get_usertotalsms($user_id);
			$data['twhp'] = $this->Adminmodel->get_usertotalwhp($user_id);
		}

		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	//update company details
	public function updatecompany()
	{ 
		if ($this->ajax_is_sadmin() === false) {
			$data['status'] = false;
			$data['msg'] = lang('acc_denied');
		} else {
			$cmpyLogo = htmlentities($_POST['h_cmpyLogoName']); //default

			if ($_FILES['cmpyLogo']['name']) {

				$file_name = strtolower(htmlentities($_POST['cmpyName']) . '_logo');

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

					$data['status'] = false;
					$data['msg'] = $this->upload->display_errors();
					echo json_encode($data);
					exit;
				} else {
					$logo_uploaded = $_FILES['cmpyLogo']['name'];
					$logo_ext = htmlentities(strtolower(pathinfo($logo_uploaded, PATHINFO_EXTENSION)));
					$upload_data = array('upload_data' => $this->upload->data());
					$cmpyLogo = $file_name . "." . $logo_ext;
				}
			}

			$cmpyData = array(
				'cmpyName' => htmlentities($_POST['cmpyName']),
				'cmpyEmail' => htmlentities($_POST['cmpyEmail']),
				'cmpyMobile' => htmlentities($_POST['cmpyMobile']),
				'cmpyLogo' => $cmpyLogo,
			);
			$user_id = $_POST['h_userid'];
			$form_key = $_POST['h_form_key'];
			$cmpyID = $_POST['h_cmpydetailID'];
			$cmpyName = htmlentities($_POST['cmpyName']);

			$res = $this->Adminmodel->updatecompany($user_id, $form_key, $cmpyID, $cmpyData);
			if ($res !== true) {
				$log = "Error updating company [ Admin: " . $this->session->userdata('mr_uname') . ", Company: " . $cmpyName .  " ]";
				$this->log_act($log);

				$data['status'] = false;
				$data['msg'] = "Error updating company";
			} else {
				$this->Adminmodel->updatecompany_users($cmpyName, $user_id);

				$log = "Company updated [ Admin: " . $this->session->userdata('mr_uname') . ", Company: " . $cmpyName .  " ]";
				$this->log_act($log);

				$data['status'] = true;
				$data['msg'] = "Company updated";
				$data['logopath'] = base_url('uploads/company/') . $cmpyLogo;
			}
		}

		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	//update quota details
	public function updatequota()
	{
		if ($this->ajax_is_sadmin() === false) {
			$data['status'] = false;
			$data['msg'] = lang('acc_denied');
		} else {
			$user_isadmin = $_POST['user_isadmin'];
			$user_iscmpy = $_POST['user_iscmpy'];

			if ($user_isadmin !== '1' || $user_iscmpy !== '1') {
				$data['status'] = false;
				$data['msg'] = lang('acc_denied');
			} elseif ($user_isadmin === '1' && $user_iscmpy === '1') {
				$qtData = array(
					'email_quota' => htmlentities($_POST['email_quota']),
					'sms_quota' => htmlentities($_POST['sms_quota']),
					'whatsapp_quota' => htmlentities($_POST['whatsapp_quota']),
					'web_quota' => htmlentities($_POST['web_quota']),
				);
				$user_id = $_POST['user_id'];
				$form_key = $_POST['form_key'];

				$res = $this->Adminmodel->updatequota($user_id, $form_key, $qtData);

				if ($res !== true) {
					$log = "Error updating quota [ Admin: " . $this->session->userdata('mr_uname') . ", Username: " . htmlentities($_POST['user_name']) .  " ]";
					$this->log_act($log);

					$data['status'] = false;
					$data['msg'] = "Error updating";
				} else {
					$log = "Quota updated [ Admin: " . $this->session->userdata('mr_uname') . ", Username: " . htmlentities($_POST['user_name']) .  " ]";
					$this->log_act($log);

					$data['status'] = true;
					$data['msg'] = "Quota updated";
				}
			}
		}

		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	//plans for new users
	public function plans()
	{
		$this->is_sadmin();

		$this->setTabUrl($mod = 'plans');

		$data['title'] = "plans";

		$data['plans'] = $this->Usermodel->get_plans();

		$this->load->view('templates/header', $data);
		$this->load->view('admin/plans');
		$this->load->view('templates/footer');
	}

	//get plan details
	public function getplan()
	{
		//check login
		if ($this->ajax_is_sadmin() === false) {
			$data['status'] = false;
			$data['msg'] = lang('acc_denied');
		} else {
			//check postdata
			if ($_POST['planid']) {
				$res = $this->Adminmodel->getplan($_POST['planid']);

				if ($res == false) {
					$data['status'] = false;
					$data['msg'] = "Error retrieving data";
				} else {
					$data['status'] = true;
					$data['details'] = $res;
				}
			} else {
				$data['status'] = false;
				$data['msg'] = "Missing parameters";
			}
		}

		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	//update plans details
	public function updateplan()
	{
		if ($this->ajax_is_sadmin() === false) {
			$data['status'] = false;
			$data['msg'] = lang('acc_denied');
		} else {
			$pData = array(
				'name' => htmlentities($_POST['name']),
				'amount' => htmlentities($_POST['amount']),
				'per' => htmlentities($_POST['per']),
				'sms_quota' => htmlentities($_POST['sms_quota']),
				'email_quota' => htmlentities($_POST['email_quota']),
				'whatsapp_quota' => htmlentities($_POST['whatsapp_quota']),
				'web_quota' => htmlentities($_POST['web_quota']),
				'orderBy' => htmlentities($_POST['orderBy']),
				'active' => htmlentities($_POST['active']),
			);
			$planid = $_POST['planid'];

			$res = $this->Adminmodel->updateplan($planid, $pData);

			if ($res !== true) {
				$log = "Error updating plan [ Admin: " . $this->session->userdata('mr_uname') . ", Plan: " . htmlentities($_POST['name']) .  " ]";
				$this->log_act($log);

				$data['status'] = false;
				$data['msg'] = "Error updating plan";
			} else {
				$log = "Plan updated [ Admin: " . $this->session->userdata('mr_uname') . ", Plan: " . htmlentities($_POST['name']) .  " ]";
				$this->log_act($log);

				$data['status'] = true;
				$data['msg'] = "Plan updated";
			}
		}

		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	//add new plan
	public function addplan()
	{
		if ($this->ajax_is_sadmin() === false) {
			$data['status'] = false;
			$data['msg'] = lang('acc_denied');
		} else {
			$pData = array(
				'name' => htmlentities($_POST['name']),
				'amount' => htmlentities($_POST['amount']),
				'per' => htmlentities($_POST['per']),
				'sms_quota' => htmlentities($_POST['sms_quota']),
				'email_quota' => htmlentities($_POST['email_quota']),
				'whatsapp_quota' => htmlentities($_POST['whatsapp_quota']),
				'web_quota' => htmlentities($_POST['web_quota']),
				'orderBy' => htmlentities($_POST['orderBy']),
				'active' => htmlentities($_POST['active']),
			);

			$res = $this->Adminmodel->addplan($pData);

			if ($res !== true) {
				$log = "Error creating plan [ Admin: " . $this->session->userdata('mr_uname') . ", Plan: " . htmlentities($_POST['name']) .  " ]";
				$this->log_act($log);

				$data['status'] = false;
				$data['msg'] = "Error creating plan";
			} else {
				$log = "Plan created [ Admin: " . $this->session->userdata('mr_uname') . ", Plan: " . htmlentities($_POST['name']) .  " ]";
				$this->log_act($log);

				$data['status'] = true;
				$data['msg'] = "Plan created";
			}
		}

		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	//redircet to receipt or show error message
	public function paymentResponse()
	{
		$this->setTabUrl($mod = 'account');

		$data['title'] = "payment response";

		if (count($_POST) > 0) {
			if ($_POST['razorpay_payment_id'] && $_POST['razorpay_order_id'] && $_POST['razorpay_signature']) {

				//use Testing keys if Live keys are empty from settings
				$key_id = $this->st->rz_live_key_id ? $this->st->rz_live_key_id : $this->st->rz_test_key_id;
				$key_secret = $this->st->rz_live_key_secret ? $this->st->rz_live_key_secret : $this->st->rz_test_key_secret;
				$api = new Api($key_id, $key_secret);

				//verify RZPostdata and signature
				try {
					$attributes  = array('razorpay_signature'  => $_POST['razorpay_signature'],  'razorpay_payment_id'  => $_POST['razorpay_payment_id'],  'razorpay_order_id' => $_POST['razorpay_order_id']);
					$order = $api->utility->verifyPaymentSignature($attributes); //return should be null

					//if signature is correct, fetch payment details and store in DB
					try {
						$PaymentInfo = $api->payment->fetch($_POST['razorpay_payment_id']);

						// store in DB
						$PaymentInfoData = array(
							'user_id' =>	$PaymentInfo['notes']['user_id'],
							'form_key' =>	$PaymentInfo['notes']['form_key'],
							'payment_id' =>	$PaymentInfo['id'],
							'order_id' =>	$PaymentInfo['order_id'],
							'entity' =>	$PaymentInfo['entity'],
							'amount' =>	$PaymentInfo['amount'] / 100,
							'currency' =>	$PaymentInfo['currency'],
							'status' =>	$PaymentInfo['status'],
							'captured' =>	$PaymentInfo['captured'],
							'mop' =>	$PaymentInfo['method'],
							'card_id' =>	$PaymentInfo['card_id'],
							'bank' =>	$PaymentInfo['bank'],
							'wallet' =>	$PaymentInfo['wallet'],
							'vpa' =>	$PaymentInfo['vpa'],
							'description' =>	$PaymentInfo['description'],
							'email' =>	$PaymentInfo['email'],
							'mobile' =>	$PaymentInfo['contact'],
							'date' =>	$PaymentInfo['created_at']
						);
						if ($PaymentInfo['bank']) {
							$PaymentInfoData['transaction_id'] = $PaymentInfo['acquirer_data']['bank_transaction_id'];
						} elseif ($PaymentInfo['card_id']) {
							// 
						} elseif ($PaymentInfo['wallet']) {
							//
						} elseif ($PaymentInfo['vpa']) {
							$PaymentInfoData['transaction_id'] = $PaymentInfo['acquirer_data']['upi_transaction_id'];
							$PaymentInfoData['rrn'] = $PaymentInfo['acquirer_data']['rrn'];
						}

						if (($this->Adminmodel->check_payID($pid = $PaymentInfo['id']) === false)) {
							$this->Adminmodel->savePaymentInfo($PaymentInfoData);

							$log = "Payment successfull [ Username: " . $this->session->userdata('mr_uname') .  ", Amount: " . $PaymentInfo['amount'] / 100 .  " ]";
							$this->log_act($log);
						}


						$data['PaymentInfo'] = $PaymentInfo;
						$data['PaymentInfoData'] = $PaymentInfoData;
						$data['error'] = false;
						$data['msg'] = "Payment Successfull";
					} catch (Exception $p) {
						$log = $p->getMessage() . " [ Username: " . $this->session->userdata('mr_uname') .  " ]";
						$this->log_act($log);

						$data['error'] = true;
						$data['msg'] = $p->getMessage();
					}
				} catch (Exception $e) {
					$log = "Razorpay verification Error : " . $e->getMessage() . " [ Username: " . $this->session->userdata('mr_uname') .  " ]";
					$this->log_act($log);

					$data['error'] = true;
					$data['msg'] = "Razorpay verification Error : " . $e->getMessage();
				}
			}
		} else {
			$data['error'] = true;
			$data['msg'] = "No data to process";
		}

		$this->load->view('templates/header', $data);
		$this->load->view('admin/payment_res');
		$this->load->view('templates/footer');
	}

	//activity logs
	public function logs()
	{
		$this->is_sadmin();

		$this->setTabUrl($mod = 'logs');

		$data['title'] = "logs";

		$data['logs'] = $this->Adminmodel->get_all_logs();
		$data['feedbacks'] = $this->Adminmodel->get_feedbacks();
		$data['transactions'] = $this->Adminmodel->get_all_transactions();

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

				$log = "Error clearing data - Activity Logs [ Username: " . $this->session->userdata('mr_uname') .  " ]";
				$this->log_act($log);
			} else {
				$this->setFlashMsg('success', 'Data cleared ');

				$log = "Data cleared - Activity Logs [ Username: " . $this->session->userdata('mr_uname') .  " ]";
				$this->log_act($log);
			}
		}

		redirect('logs');
	}

	public function clearfeedbacks()
	{
		if ($this->ajax_is_sadmin() === true) {

			$res = $this->Adminmodel->clear_feedbacks();

			if ($res !== true) {
				$log = "Error clearing data - Support [ Username: " . $this->session->userdata('mr_uname') .  " ]";
				$this->log_act($log);

				$this->setFlashMsg('error', 'Error clearing data');
			} else {
				$log = "Data cleared - Support [ Username: " . $this->session->userdata('mr_uname') .  " ]";
				$this->log_act($log);

				$this->setFlashMsg('success', 'Data cleared!');
			}
		}

		redirect('logs');
	}

	//get a payment info
	public function get_paymentsDetails()
	{
		if ($this->ajax_is_sadmin() === false) {
			$data['status'] = false;
			$data['msg'] = lang('acc_denied');
		} else {
			//check postdata
			if ($_POST['payID'] && $_POST['formkey'] && $_POST['userid']) {
				$res = $this->Adminmodel->get_paymentsDetails($_POST['payID'], $_POST['formkey'], $_POST['userid']);

				if ($res == false) {
					$data['status'] = false;
					$data['msg'] = "Error retrieving data";
				} else {
					$data['status'] = true;
					$data['details'] = $res;
				}
			} else {
				$data['status'] = false;
				$data['msg'] = "Missing parameters";
			}
		}

		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
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
			$secret = $this->st->captcha_secret_key;

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
					$log = "Error sending mail - Contact Us [ Name: " . htmlentities($this->input->post('name')) . ", Email: " . htmlentities($this->input->post('email')) . ", MailError: " . $mail_res . " ]";
					$this->log_act($log);

					$this->setFlashMsg('error', 'Error sending your message');
				} else {
					$res = $this->Adminmodel->contact();

					$log = "Mail sent - Contact Us [ Name: " . htmlentities($this->input->post('name')) . ", Email: " . htmlentities($this->input->post('email')) . " ]";
					$this->log_act($log);

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
