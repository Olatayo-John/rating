<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rate extends CI_Controller
{
	public function index()
	{
		$w = $_GET['w'];
		$k = $_GET['k'];

		if (empty($w) || empty($k)) {
			redirect("user/wtr/" . $k);
			exit();
		} else {
			$res = $this->Usermodel->check_cred($w, $k);
			if ($res == false) {
				$this->session->set_flashdata("invalid", "Invalid Link!");
				redirect("user/wtr/" . $k);
			} else if ($res == true) {
				$data['active'] = $this->Adminmodel->is_user_active($k);
				if ($data['active']->active === "0" || $data['active']->sub_active === "0") {
					$this->session->set_flashdata("invalid", "User account is inactive or has no subscription");
					redirect("user/wtr/" . $k);
				} else {
					$this->load->view('templates/header');
					$this->load->view('rate/index');
					$this->load->view('templates/footer');
				}
			}
		}
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
			redirect("wtr/" . $k);
			exit();
		} else {
			$res = $this->Usermodel->check_cred($w, $k);
			if ($res == false) {
				// $this->Logmodel->log_act($type = "invalidlink");
				$this->session->set_flashdata("invalid", "Invalid Link!");
				redirect("wtr/" . $k);
			} elseif ($res == true) {
				redirect('rate?w=' . $w . '&k=' . $k);
			}
		}
	}

	public function rating_store()
	{
		$cq_res = $this->Usermodel->check_quota_expire($_POST['form_key']);
		if ($cq_res == true) {

			// $this->load->library('emailconfig');
			// $this->emailconfig->send_quota_expire_mail();
			//$this->send_quota_expire_mail();

			$this->Logmodel->log_act($type = "quota_expire");
			$data['res'] = "failed";
			$data['res_msg'] = "User quota expired. <a href='" . base_url("user/notifyuser_email/" . $_POST['form_key'] . "") . "' class='text-info'>Notify User?</a>";
		} else {
			$res = $this->Usermodel->rating_store($_POST['starv'], $_POST['name'], $_POST['mobile'], $_POST['form_key'], $_POST['for_link']);
			if ($res) {
				$this->Logmodel->log_act($type = "ratingstore");
				$data['web_link'] = $res->web_link;
				$data['res'] = "succ";
				$data['res_msg'] = "Thanks for your feedback!";
			} else {
				$this->Logmodel->log_act($type = "db_err");
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

		$uemail = $data->email;
		$uname = $data->uname;

		// $res = $this->notifyuser_sendemail($uemail, $uname);
		$this->load->library('emailconfig');
		$res = $this->emailconfig->notifyuser_sendemail($uemail, $uname);
		if ($res !== true) {
			$this->Logmodel->log_act($type = "mail_err");
			$this->session->set_flashdata('invalid', $res);
			redirect($_SERVER['HTTP_REFERER']);
		} else {
			$this->session->set_flashdata('valid', 'User has been notified');
			redirect($_SERVER['HTTP_REFERER']);
		}
	}
}
