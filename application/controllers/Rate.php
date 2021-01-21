<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rate extends Ci_Controller{
    public function index(){
        $w = $_GET['w'];
		$k = $_GET['k'];

		if (empty($w) || empty($k)) {
			redirect($_SERVER['HTTP_REFERER']);
			exit();
		}else{
            $res = $this->Usermodel->check_cred($w, $k);
			if ($res == false) {
                $this->session->set_flashdata("invalid", "Invalid Link!");
				redirect("user");
			} else if ($res == true) {
				$this->load->view('rate/test');
			}
        }
        
    }
}