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
		if (!$this->session->userdata('mr_logged_in')) {
			$this->session->set_flashdata('loginfirst', 'Please login first');
			redirect('user/login');
		}
		if ($this->session->userdata('mr_admin') == "0") {
			$this->session->set_flashdata('acces_denied', 'Access Denied.');
			redirect('user/account');
		}
		if ($this->session->userdata('mr_admin') == "1") {
			$this->votes($offset = 0);
		}
	}

	public function users($offset = 0)
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->session->set_flashdata('loginfirst', 'Please login first');
			redirect('user/login');
		}
		if ($this->session->userdata('mr_admin') == "0") {
			$this->session->set_flashdata('acces_denied', 'Access Denied.');
			redirect('user/login');
		}
		$config['base_url'] = base_url() . "admin/users/";
		$config['total_rows'] = $this->db->count_all('users');
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

		$data['users'] = $this->Adminmodel->get_user_details($config["per_page"], $offset);
		$this->load->view('templates/header');
		$this->load->view('admin/users', $data);
		$this->load->view('templates/footer');
	}

	public function users_export_csv()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->session->set_flashdata('loginfirst', 'Please login first');
			redirect('user/login');
		}
		if ($this->session->userdata('mr_admin') == "0") {
			$this->session->set_flashdata('acces_denied', 'Access Denied.');
			redirect('user/login');
		}
		header("Content-Type: text/csv; charset=utf-8");
		header("Content-Disposition: attachment; filename=users.csv");
		$output = fopen("php://output", "w");
		fputcsv($output, array('ID', 'Status', 'Username', 'First Name', 'Last Name', 'E-mail', 'Mobile', 'Subscription'));
		$data = $this->Adminmodel->users_export_csv();
		foreach ($data as $row) {
			fputcsv($output, $row);
		}
		fclose($output);
	}

	public function reload_table()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->session->set_flashdata('loginfirst', 'Please login first');
			redirect('user/login');
		}
		if ($this->session->userdata('mr_admin') == "0") {
			$this->session->set_flashdata('acces_denied', 'Access Denied!');
			redirect('user/login');
		}
		$config['per_page'] = 10;
		$offset = 0;
		$output = "";

		$data = $this->Adminmodel->get_user_details($config["per_page"], $offset);
		$output .= '<tr class="font-weight-bolder text-light text-center" style="background: #141E30">
		<th>
			<span>Status</span>
		</th>
		<th>
			<div class="inh">
				<i class="fas fa-sort" name="uname" type="desc"></i>
				<span>User</span>
			</div>
		</th>
		<th>
			<div class="inh">
				<i class="fas fa-sort " name="fname" type="desc"></i>
				<span>Full Name</span>
			</div>
		</th>
		<th>
			<div class="cmp">
				<i class="fas fa-sort" name="mobile" type="desc"></i>
				<span>Mobile</span>
			</div>
		</th>
		<th>
			<div class="cmp">
				<i class="fas fa-sort" name="email" type="desc"></i>
				<span>E-Mail</span>
			</div>
		</th>
		<th>
			<div class="cmp">
				<i class="fas fa-sort" name="sub" type="desc"></i>
				<span>Subscribed?</span>
			</div>
		</th>
		<th class="text-danger text-center font-weight-bolder">
			Action
		</th>
		</tr>';
		if ($data->num_rows() == 0) {
			$output .= '<tr class="text-dark">
			<td colspan="7" class="font-weight-bolder text-light text-center">NO DATA FOUND</td>
			</tr>';
		} else {
			foreach ($data->result_array() as $info) {
				$output .= '<tr class="text-dark text-center">
				<td>';
				if ($info['active'] == 0) {
					$output .= '<i class="fas fa-circle text-danger"></i>';
				} elseif ($info['active'] == 1) {
					$output .= '<i class="fas fa-circle text-success"></i>';
				}
				$output .= '</td>
				<td class="text-uppercase">' . $info['uname'] . '</td>
				<td class="">' . $info['fname'] . " " . $info['lname'] . '</td>
				<td class="">' . $info['mobile'] . '</td>
				<td class="">' . $info['email'] . '</td>
				<td class="">';
				if ($info['sub'] == 0) {
					$output .= 'No';
				} elseif ($info['sub'] == 1) {
					$output .= 'Yes';
				}
				$output .= '</td>
				<td class="font-weight-bolder">
					<div class="d-flex" style="justify-content:space-around">
						<button class="btn text-light editbtn" id="' . $info['id'] . '" form_key="' . $info['form_key'] . '" style="background:#141E30">
							<i class="fas fa-user-alt text-light "></i>
						</button>
						<button class="btn text-light delbtn" id="' . $info['id'] . '" form_key="' . $info['form_key'] . '" style="background:#141E30">
							<i class="fas fa-trash-alt text-danger "></i>
						</button>
					</div>
				</td>
			</tr>';
			}
		}
		echo $output;
	}

	public function users_search_user()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->session->set_flashdata('loginfirst', 'Please login first');
			redirect('user/login');
		}
		if ($this->session->userdata('mr_admin') == "0") {
			$this->session->set_flashdata('acces_denied', 'Access Denied.');
			redirect('user/login');
		}
		$output = '';
		$query = '';
		if ($this->input->post('query')) {
			$query = $this->input->post('query');
		}
		$data = $this->Adminmodel->users_search_user($query);
		$output .= '<tr class="font-weight-bolder text-light text-center" style="background: #141E30">
		<th>
			<span>Status</span>
		</th>
		<th>
			User
		</th>
		<th>
			Full Name
		</th>
		<th>
			Mobile
		</th>
		<th>
			E-Mail
		</th>
		<th>
			Subscribed?
		</th>
		<th class="text-danger text-center font-weight-bolder">
			Action
		</th>
		</tr>';
		if ($data->num_rows() == 0) {
			$output .= '<tr class="text-dark">
			<td colspan="8" class="font-weight-bolder text-dark text-center">NO DATA FOUND</td>
			</tr>';
		} else {
			foreach ($data->result_array() as $info) {
				$output .= '<tr class="text-dark text-center">
				<td>';
				if ($info['active'] == 0) {
					$output .= '<i class="fas fa-circle text-danger"></i>';
				} elseif ($info['active'] == 1) {
					$output .= '<i class="fas fa-circle text-success"></i>';
				}
				$output .= '</td>
				<td class="text-uppercase">' . $info['uname'] . '</td>
				<td class="">' . $info['fname'] . " " . $info['lname'] . '</td>
				<td class="">' . $info['mobile'] . '</td>
				<td class="">' . $info['email'] . '</td>
				<td class="">';
				if ($info['sub'] == 0) {
					$output .= 'No';
				} elseif ($info['sub'] == 1) {
					$output .= 'Yes';
				}
				$output .= '</td>
				<td class="font-weight-bolder">
					<div class="d-flex" style="justify-content:space-around">
						<button class="btn text-light editbtn" id="' . $info['id'] . '" form_key="' . $info['form_key'] . '" style="background:#141E30">
							<i class="fas fa-user-alt text-light "></i>
						</button>
						<button class="btn text-light delbtn" id="' . $info['id'] . '" form_key="' . $info['form_key'] . '" style="background:#141E30">
							<i class="fas fa-trash-alt text-danger "></i>
						</button>
					</div>
				</td>
			</tr>';
			}
		}
		echo $output;
	}

	public function users_filter_param()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->session->set_flashdata('loginfirst', 'Please login first');
			redirect('user/login');
		}
		if ($this->session->userdata('mr_admin') == "0") {
			$this->session->set_flashdata('acces_denied', 'Access Denied.');
			redirect('user/login');
		}
		$data = $this->Adminmodel->users_filter_param($_POST['param'], $_POST['type']);
		$output = "";
		$output .= '<tr class="font-weight-bolder text-light text-center" style="background: #141E30">
		<th>
			<span>Status</span>
		</th>
		<th>
			<div class="inh">
				<i class="fas fa-sort" name="uname" type="desc"></i>
				<span>User</span>
			</div>
		</th>
		<th>
			<div class="inh">
				<i class="fas fa-sort " name="fname" type="desc"></i>
				<span>Full Name</span>
			</div>
		</th>
		<th>
			<div class="cmp">
				<i class="fas fa-sort" name="mobile" type="desc"></i>
				<span>Mobile</span>
			</div>
		</th>
		<th>
			<div class="cmp">
				<i class="fas fa-sort" name="email" type="desc"></i>
				<span>E-Mail</span>
			</div>
		</th>
		<th>
			<div class="cmp">
				<i class="fas fa-sort" name="sub" type="desc"></i>
				<span>Subscribed?</span>
			</div>
		</th>
		<th class="text-danger text-center font-weight-bolder">
			Action
		</th>
		</tr>';
		if ($data->num_rows() == 0) {
			$output .= '<tr class="text-dark">
			<td colspan="8" class="font-weight-bolder text-dark text-center">NO DATA FOUND</td>
			</tr>';
		} else {
			foreach ($data->result_array() as $info) {
				$output .= '<tr class="text-dark text-center">
				<td>';
				if ($info['active'] == 0) {
					$output .= '<i class="fas fa-circle text-danger"></i>';
				} elseif ($info['active'] == 1) {
					$output .= '<i class="fas fa-circle text-success"></i>';
				}
				$output .= '</td>
				<td class="text-uppercase">' . $info['uname'] . '</td>
				<td class="">' . $info['fname'] . " " . $info['lname'] . '</td>
				<td class="">' . $info['mobile'] . '</td>
				<td class="">' . $info['email'] . '</td>
				<td class="">';
				if ($info['sub'] == 0) {
					$output .= 'No';
				} elseif ($info['sub'] == 1) {
					$output .= 'Yes';
				}
				$output .= '</td>
				<td class="font-weight-bolder">
					<div class="d-flex" style="justify-content:space-around">
						<button class="btn text-light editbtn" id="' . $info['id'] . '" form_key="' . $info['form_key'] . '" style="background:#141E30">
							<i class="fas fa-user-alt text-light "></i>
						</button>
						<button class="btn text-light delbtn" id="' . $info['id'] . '" form_key="' . $info['form_key'] . '" style="background:#141E30">
							<i class="fas fa-trash-alt text-danger "></i>
						</button>
					</div>
				</td>
			</tr>';
			}
		}
		echo $output;
	}

	public function delete_user()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->session->set_flashdata('loginfirst', 'Please login first');
			redirect('user/login');
		}
		if ($this->session->userdata('mr_admin') == "0") {
			$this->session->set_flashdata('acces_denied', 'Access Denied.');
			redirect('user/login');
		} else {
			$res = $this->Adminmodel->delete_user($_POST['user_id'], $_POST['form_key']);
			$this->session->set_flashdata('user_deleted', 'User deleted!');
		}
	}

	public function get_user()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->session->set_flashdata('loginfirst', 'Please login first');
			redirect($_SERVER['HTTP_REFERER']);
		}
		if ($this->session->userdata('mr_admin') == "0") {
			$this->session->set_flashdata('acces_denied', 'Access Denied.');
			redirect($_SERVER['HTTP_REFERER']);
		} else {
			$output = array();
			$data['infos'] = $this->Adminmodel->get_user($_POST['user_id'], $_POST['form_key']);
			$data['webs'] = $this->Adminmodel->get_user_websites($_POST['user_id'], $_POST['form_key']);
			$data['token'] = $this->security->get_csrf_hash();
			// foreach ($data as $row) {
			// 	$output['id'] = $row->id;
			// 	$output['admin'] = $row->admin;
			// 	$output['uname'] = $row->uname;
			// 	$output['full_name'] = $row->full_name;
			// 	$output['email'] = $row->email;
			// 	$output['mobile'] = $row->mobile;
			// 	$output['c_name'] = $row->c_name;
			// 	$output['c_add'] = $row->c_add;
			// 	$output['c_email'] = $row->c_email;
			// 	$output['c_mobile'] = $row->c_mobile;
			// 	$output['c_web'] = $row->c_web;
			// 	$output['fb_link'] = $row->fb_link;
			// 	$output['google_link'] = $row->google_link;
			// 	$output['glassdoor_link'] = $row->glassdoor_link;
			// 	$output['trust_pilot_link'] = $row->trust_pilot_link;
			// 	$output['form_key'] =  $row->form_key;
			// 	$output['active'] = $row->active;
			// 	$output['sub'] = $row->sub;
			// 	$output['token'] = $this->security->get_csrf_hash();
			// }
			echo json_encode($data);
		}
	}

	public function update_user()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->session->set_flashdata('loginfirst', 'Please login first');
			redirect('user/login');
		}
		if ($this->session->userdata('mr_admin') == "0") {
			$this->session->set_flashdata('acces_denied', 'Access Denied.');
			redirect('user/login');
		} else {
			$data = $this->Adminmodel->update_user($_POST['u_user_id']);
			//echo json_encode($data);
			$this->session->set_flashdata('user_updated', 'User details updated');
		}
	}

	//commented for now
	/* public function add_user()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->session->set_flashdata('loginfirst', 'Please login first');
			redirect('user/login');
		}
		if ($this->session->userdata('mr_admin') == "0") {
			$this->session->set_flashdata('acces_denied', 'Access Denied.');
			redirect('user/login');
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
				$this->session->set_flashdata('reg_failed', 'Registration Failed');
				redirect('user/register');
				exit();
			} else {
				if (isset($_POST['mail_chkbox']) && isset($_POST['mobile_chkbox'])) {
					$fname = $this->input->post('full_name');
					$email = $this->input->post('email');
					$link = base_url() . "user/rate/" . $form_key;
					$mobile = $this->input->post('mobile');
					$login_link = base_url();
					$res = $this->send_email_code($fname, $randpwd, $email, $link, $login_link);
					$this->session->set_flashdata('adduser_emailndmobile_code', 'User added. Login credentials sent to user e-mail and mobile');
					redirect($_SERVER['HTTP_REFERER']);;
				} elseif (isset($_POST['mail_chkbox'])) {
					$fname = $this->input->post('full_name');
					$email = $this->input->post('email');
					$link = base_url() . "user/rate/" . $form_key;
					$mobile = $this->input->post('mobile');
					$login_link = base_url();
					$res = $this->send_email_code($fname, $randpwd, $email, $link, $login_link);
					$this->session->set_flashdata('adduser_email_code', 'User added. Login credentials sent to user e-mail');
					redirect($_SERVER['HTTP_REFERER']);
				} elseif (isset($_POST['mobile_chkbox'])) {
					require __DIR__ . '/twilosms.php';
					$this->session->set_flashdata('adduser_mobile_code', 'User added. Login credentials sent to user mobile');
					redirect($_SERVER['HTTP_REFERER']);
				}
			}
		}
	} */

	public function send_email_code($fname, $randpwd, $email, $link, $login_link)
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

		$data = array(
			'fname' => $fname,
			'randpwd' => $randpwd,
			'link' => $link,
			'login_link' => $login_link,
		);
		$body = "Hello " . $fname . "\n\nBelow are your login credentails:\nUsername: " . $fname . "\nPassword: " . $randpwd . "\nLink: " . $link . "\nShare the above link to get reviews.\nYou can login here " . $login_link . "\n\nIf you have any questions, send us an email at info@nktech.in.\n\nBest Regards,\nNKTECH\nhttps://nktech.in";

		$this->email->from('jvweedtest@gmail.com', 'Rating');
		$this->email->to($email);
		$this->email->subject("Login Credentials");
		$this->email->message($body);

		$this->email->send();
	}

	public function votes($offset = 0)
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->session->set_flashdata('loginfirst', 'Please login first');
			redirect('user/login');
		}
		if ($this->session->userdata('mr_admin') == "0") {
			$this->session->set_flashdata('acces_denied', 'Access Denied.');
			redirect('user/login');
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
		$this->load->view('templates/header');
		$this->load->view('admin/votes', $data);
		$this->load->view('templates/footer');
	}

	public function votes_export_csv()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->session->set_flashdata('loginfirst', 'Please login first');
			redirect('user/login');
		}
		if ($this->session->userdata('mr_admin') == "0") {
			$this->session->set_flashdata('acces_denied', 'Access Denied.');
			redirect('user/login');
		}
		header("Content-Type: text/csv; charset=utf-8");
		header("Content-Disposition: attachment; filename=users.csv");
		$output = fopen("php://output", "w");
		fputcsv($output, array('ID', 'Name', 'Total Ratings', 'SMS', 'Email', 'Official Website', 'Facebook', 'Google', 'Glassdoor', 'Trust Pilot', '5 Star', '4 Star', '3 Star', '2 Star', '1 Star'));
		$data = $this->Adminmodel->votes_export_csv();
		foreach ($data as $row) {
			fputcsv($output, $row);
		}
		fclose($output);
	}

	public function votes_reload_table()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->session->set_flashdata('loginfirst', 'Please login first');
			redirect('user/login');
		}
		if ($this->session->userdata('mr_admin') == "0") {
			$this->session->set_flashdata('acces_denied', 'Access Denied.');
			redirect('user/login');
		}
		$config['per_page'] = 10;
		$offset = 0;
		$output = "";

		$data = $this->Adminmodel->get_user_votes($config["per_page"], $offset);
		$output .= '<table class="table table-center table-hover table-md table-light" id="result">
		<tr class="font-weight-bolder text-light" style="background: linear-gradient(to right, #243B55, #141E30);">
		<th><div class="inh">
		<i class="fas fa-sort" name="name" type="desc"></i>
		<span>Name</span>
		</div></th>
		<th><div class="tr">
		<i class="fas fa-sort" name="total_links" type="desc"></i>
		<span>Feedbacks</span>
		</div class="icon"></th>
		<th><div class="inh">
		<i class="fas fa-sort" name="sms" type="desc"></i>
		<span>SMS</span>
		</div class="icon"></th>
		<th><div class="inh">
		<i class="fas fa-sort" name="email" type="desc"></i>
		<span>Email</span>
		</div class="icon"></th>
		<th><div class="tr">				
		<i class="fas fa-sort" name="ow_r" type="desc"></i>
		<span>Official Web</span>
		</div></th>
		<th><div class="tr">				
		<i class="fas fa-sort" name="fb_r" type="desc"></i>
		<span>Facebook</span>
		</div></th>
		<th><div class="tr">				
		<i class="fas fa-sort" name="g_r" type="desc"></i>
		<span>Google</span>
		</div></th>
		<th><div class="tr">			
		<i class="fas fa-sort" name="gb_r" type="desc"></i>
		<span>Glassdoor</span>
		</div></th>
		<th><div class="tr">				
		<i class="fas fa-sort" name="tp_r" type="desc"></i>
		<span>Trust Pilot</span>
		</div></th>
		<th class="text-danger text-center font-weight-bolder">
		View Feedbacks
		</th>
		</tr>';
		if ($data->num_rows() == 0) {
			$output .= '<tr class="text-dark">
			<td colspan="8" class="font-weight-bolder text-dark text-center">NO DATA FOUND</td>
			</tr>';
		} else {
			foreach ($data->result_array() as $info) {
				$output .= '<tr class="text-dark text-center">
				<td class="">' . $info["name"] . '</td>
				<td class="">' . $info["total_links"] . '</td>
				<td class="">' . $info["sms"] . '</td>
				<td class="">' . $info["email"] . '</td>
				<td class="">' . $info["ow_r"] . '</td>
				<td class="">' . $info["fb_r"] . '</td>
				<td class="">' . $info["g_r"] . '</td>
				<td class="">' . $info["gb_r"] . '</td>
				<td class="">' . $info["tp_r"] . '</td>
				<td class="">
				<button class="btn text-light vv_btn" form_key="' . $info['form_key'] . '" style="width: 100px;background: linear-gradient(to right, #243B55, #141E30);"><i class="fas fa-poll text-light mr-2"></i>Votes</button>
				</td>
				</tr>';
			}
		}
		echo $output;
	}

	public function votes_filter_param()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->session->set_flashdata('loginfirst', 'Please login first');
			redirect('user/login');
		}
		if ($this->session->userdata('mr_admin') == "0") {
			$this->session->set_flashdata('acces_denied', 'Access Denied.');
			redirect('user/login');
		}
		$data = $this->Adminmodel->votes_filter_param($_POST['param'], $_POST['type']);
		$output = "";
		$output .= '<table class="table table-center table-hover table-md table-light" id="result">
		<tr class="font-weight-bolder text-light" style="background: linear-gradient(to right, #243B55, #141E30);">
		<th><div class="inh">
		<i class="fas fa-sort" name="name" type="desc"></i>
		<span>Name</span>
		</div></th>
		<th><div class="tr">
		<i class="fas fa-sort" name="total_links" type="desc"></i>
		<span>Feedbacks</span>
		</div class="icon"></th>
		<th><div class="inh">
		<i class="fas fa-sort" name="sms" type="desc"></i>
		<span>SMS</span>
		</div class="icon"></th>
		<th><div class="inh">
		<i class="fas fa-sort" name="email" type="desc"></i>
		<span>Email</span>
		</div class="icon"></th>
		<th><div class="tr">				
		<i class="fas fa-sort" name="ow_r" type="desc"></i>
		<span>Official Web</span>
		</div></th>
		<th><div class="tr">				
		<i class="fas fa-sort" name="fb_r" type="desc"></i>
		<span>Facebook</span>
		</div></th>
		<th><div class="tr">				
		<i class="fas fa-sort" name="g_r" type="desc"></i>
		<span>Google</span>
		</div></th>
		<th><div class="tr">			
		<i class="fas fa-sort" name="gb_r" type="desc"></i>
		<span>Glassdoor</span>
		</div></th>
		<th><div class="tr">				
		<i class="fas fa-sort" name="tp_r" type="desc"></i>
		<span>Trust Pilot</span>
		</div></th>
		<th class="text-danger text-center font-weight-bolder">
		View Feedbacks
		</th>
		</tr>';
		if ($data->num_rows() == 0) {
			$output .= '<tr class="text-light">
			<td colspan="10" class="font-weight-bolder text-dark text-center">No data found</td>
			</tr>';
		} else {
			foreach ($data->result_array() as $info) {
				$output .= '<tr class="text-dark text-center">
				<td class="">' . $info["name"] . '</td>
				<td class="">' . $info["total_links"] . '</td>
				<td class="">' . $info["sms"] . '</td>
				<td class="">' . $info["email"] . '</td>
				<td class="">' . $info["ow_r"] . '</td>
				<td class="">' . $info["fb_r"] . '</td>
				<td class="">' . $info["g_r"] . '</td>
				<td class="">' . $info["gb_r"] . '</td>
				<td class="">' . $info["tp_r"] . '</td>
				<td class="">
				<button class="btn text-light vv_btn" form_key="' . $info['form_key'] . '" style="width: 100px;background: linear-gradient(to right, #243B55, #141E30);"><i class="fas fa-poll text-light mr-2"></i>Votes</button>
				</td>
				</tr>';
			}
		}
		echo $output;
	}

	public function votes_search_user()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->session->set_flashdata('loginfirst', 'Please login first');
			redirect('user/login');
		}
		if ($this->session->userdata('mr_admin') == "0") {
			$this->session->set_flashdata('acces_denied', 'Access Denied.');
			redirect('user/login');
		}
		$output = '';
		$query = '';
		if ($this->input->post('query')) {
			$query = $this->input->post('query');
		}
		$data = $this->Adminmodel->votes_search_user($query);
		$output .= '<table class="table table-center table-hover table-md table-light" id="result">
		<tr class="font-weight-bolder text-light" style="background: linear-gradient(to right, #243B55, #141E30);">
		<th><div class="inh">
		<span>Name</span>
		</div></th>
		<th><div class="tr">
		<span>Feedbacks</span>
		</div class="icon"></th>
		<th><div class="inh">
		<span>SMS</span>
		</div class="icon"></th>
		<th><div class="inh">
		<span>Email</span>
		</div class="icon"></th>
		<th><div class="tr">				
		<span>Official Web</span>
		</div></th>
		<th><div class="tr">				
		<span>Facebook</span>
		</div></th>
		<th><div class="tr">				
		<span>Google</span>
		</div></th>
		<th><div class="tr">			
		<span>Glassdoor</span>
		</div></th>
		<th><div class="tr">				
		<span>Trust Pilot</span>
		</div></th>
		<th class="text-danger text-center font-weight-bolder">
		View Feedbacks
		</th>
		</tr>';
		if ($data->num_rows() == 0) {
			$output .= '<tr class="text-light">
			<td colspan="10" class="font-weight-bolder text-dark text-center">No data found</td>
			</tr>';
		} else {
			foreach ($data->result_array() as $info) {
				$output .= '<tr class="text-dark text-center">
				<td class="">' . $info["name"] . '</td>
				<td class="">' . $info["total_links"] . '</td>
				<td class="">' . $info["sms"] . '</td>
				<td class="">' . $info["email"] . '</td>
				<td class="">' . $info["ow_r"] . '</td>
				<td class="">' . $info["fb_r"] . '</td>
				<td class="">' . $info["g_r"] . '</td>
				<td class="">' . $info["gb_r"] . '</td>
				<td class="">' . $info["tp_r"] . '</td>
				<td class="">
				<button class="btn text-light vv_btn" form_key="' . $info['form_key'] . '" style="width: 100px;background: linear-gradient(to right, #243B55, #141E30);"><i class="fas fa-poll text-light mr-2"></i>Votes</button>
				</td>
				</tr>';
			}
		}
		echo $output;
	}

	public function votes_get_user()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->session->set_flashdata('loginfirst', 'Please login first');
			redirect('user/login');
		}
		if ($this->session->userdata('mr_admin') == "0") {
			$this->session->set_flashdata('acces_denied', 'Access Denied.');
			redirect('user/login');
		} else {
			$data['users'] = $this->Adminmodel->get_ratings($_POST['key']);
			$data['token'] = $this->security->get_csrf_hash();
			echo json_encode($data);
		}
	}

	public function indiv_votes_export_csv($key)
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->session->set_flashdata('loginfirst', 'Please login first');
			redirect('user/login');
		}
		if ($this->session->userdata('mr_admin') == "0") {
			$this->session->set_flashdata('acces_denied', 'Access Denied.');
			redirect('user/login');
		}
		header("Content-Type: text/csv; charset=utf-8");
		header("Content-Disposition: attachment; filename=user_votes.csv");
		$output = fopen("php://output", "w");
		fputcsv($output, array('ID', 'Name', 'Message', 'Star', 'Mobile', 'IP', 'Date'));
		$data = $this->Adminmodel->indiv_votes_export_csv($key);
		foreach ($data as $row) {
			fputcsv($output, $row);
		}
		fclose($output);
	}

	public function search_ind_votes()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->session->set_flashdata('loginfirst', 'Please login first');
			redirect('user/login');
		}
		if ($this->session->userdata('mr_admin') == "0") {
			$this->session->set_flashdata('acces_denied', 'Access Denied.');
			redirect('user/login');
		}
		$output = '';
		$query = '';
		if ($this->input->post('query')) {
			$query = $this->input->post('query');
		}
		$data = $this->Adminmodel->search_ind_votes($query, $_POST['key']);
		$output .= '<table class="table table-bordered table-center table-hover tableuserreview"  id="tableuserreview">
		<tr class="font-weight-bolder thead-dark">
		<th><span class="icon">							
		Name
		</span></th>
		<th><span>
		Message
		</span class="icon"></th>
		<th><span>					
		Star Rated
		</span></th>
		<th><span>
		Mobile
		</span class="icon"></th>
		<th><span>				
		User IP
		</span></th>
		<th class="text-danger"><span>					
		Date
		</span></th>
		</tr>';
		if ($data->num_rows() == 0) {
			$output .= '<tr class="text-dark truserreview">
			<td colspan="6" class="font-weight-bolder text-dark text-center">No data found</td>
			</tr>';
		} else {
			foreach ($data->result_array() as $info) {
				$output .= '<tr class="text-dark text-center truserreview">
				<td class="font-weight-bolder">' . $info["name"] . '</td>
				<td class="font-weight-bolder">' . $info["review_msg"] . '</td>
				<td class="font-weight-bolder">' . $info["star"] . '</td>
				<td class="font-weight-bolder">' . $info["mobile"] . '</td>
				<td class="font-weight-bolder">' . $info["user_ip"] . '</td>
				<td class="font-weight-bolder text-danger">' . $info["rated_at"] . '</td>
				</tr>';
			}
		}
		echo $output;
	}

	public function pick_plan()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->session->set_flashdata('loginfirst', 'Please login first');
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
		//$MSISDN= "+917456034856";
		//$EMAIL= "olatayoefficient@gmail.com";

		$data["MID"] = PAYTM_MERCHANT_MID;
		$data["CUST_ID"] = $this->session->userdata('mr_id');
		$data["ORDER_ID"] = mt_rand(0, 10000000);
		$data["INDUSTRY_TYPE_ID"] = "Retail";
		$data["CHANNEL_ID"] = "WEB";
		$data["TXN_AMOUNT"] = $this->input->post('plan_amount');
		$data["WEBSITE"] = PAYTM_MERCHANT_WEBSITE;
		$data["CALLBACK_URL"] = base_url("admin/pgResponses");

		//$data["MSISDN"]= $MSISDN;
		//$data["EMAIL"]= $EMAIL;
		//$data["VERIFIED_BY"]= "EMAIL";
		//$data["IS_USER_VERIFIED"]=>"YES";

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
		$user_id = $this->session->userdata('mr_id');
		$form_key = $this->session->userdata('mr_form_key');

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
						'user_id' => $user_id,
						'user_form_key' => $form_key,
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
					$res = $this->Adminmodel->save_payment($userData);
					//$res= true;
					if ($res == true) {
						$this->session->set_flashdata('reg_succ', 'Payment Done.');
						//$this->payment_status($userData);
						$this->load->view('templates/header');
						$this->load->view('admin/pay_status', ['userData' => $userData]);
						$this->load->view('templates/footer');
					} else {
						$this->session->set_flashdata('payment_save_err', 'Error saving contacts to DATABASE.');
						$this->load->view('templates/header');
						$this->load->view('admin/pay_status', ['userData' => $userData]);
						$this->load->view('templates/footer');
					}
				} else {
					$this->session->set_flashdata('sub_failed', 'Payment Failed.');
					$this->load->view('templates/header');
					$this->load->view('admin/pay_status', ['userData' => $userData]);
					$this->load->view('templates/footer');
				}
			} else {
				$this->session->set_flashdata('sub_failed', 'Payment Failed.');
				$this->load->view('templates/header');
				$this->load->view('admin/pay_status', ['userData' => $userData]);
				$this->load->view('templates/footer');
			}
		} else {
			$this->logout();
		}
	}

	public function account_old()
	{
		if (!$this->session->userdata('mr_logged_in')) {
			$this->session->set_flashdata('loginfirst', 'Please login first');
			redirect('user');
		}
		if ($this->session->userdata('mr_admin') == "0") {
			$this->session->set_flashdata('acces_denied', 'Access Denied.');
			redirect('user/login');
		}
		$data['ratings'] = $this->Adminmodel->all_total_ratings();
		$data['tr5'] = $this->Adminmodel->tr5_total_ratings();
		$data['tr4'] = $this->Adminmodel->tr4_total_ratings();
		$data['tr3'] = $this->Adminmodel->tr3_total_ratings();
		$data['tr2'] = $this->Adminmodel->tr2_total_ratings();
		$data['tr1'] = $this->Adminmodel->tr1_total_ratings();
		$data['email'] = $this->Adminmodel->all_email();
		$data['sms'] = $this->Adminmodel->all_sms();
		//print_r($data);die;
		$this->load->view('templates/header');
		$this->load->view('admin/quota', $data);
		$this->load->view('templates/footer');
	}

	public function logout()
	{
		$this->session->unset_userdata('mr_id');
		$this->session->unset_userdata('mr_admin');
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
}
