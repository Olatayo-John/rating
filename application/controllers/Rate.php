<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rate extends Ci_Controller
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
				if ($data['active']->active === "0" || $data['active']->sub === "0") {
					$this->session->set_flashdata("invalid", "Invalid User!");
					redirect("user/wtr/" . $k);
				} else {
					$this->load->view('templates/header');
					$this->load->view('rate/index');
					$this->load->view('templates/footer');
				}
			}
		}
	}
}
