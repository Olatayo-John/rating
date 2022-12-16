<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rate extends Rate_Controller
{
	public function _index()
	{
		$w = $_GET['w'];
		$k = $_GET['k'];

		if (empty($w) || empty($k)) {
			redirect("user/wtr/" . $k);
			exit();
		} else {
			$res = $this->Usermodel->check_cred($w, $k);
			if ($res == false) {
				$this->setFlashMsg("error", "Invalid Link!");
				redirect("user/wtr/" . $k);
			} else if ($res == true) {
				$data['active'] = $this->Adminmodel->is_user_active($k);
				if ($data['active']->active === "0" || $data['active']->sub_active === "0") {
					$this->setFlashMsg("error", "User account is inactive or has no subscription");
					redirect("user/wtr/" . $k);
				} else {
					$this->load->view('templates/header');
					$this->load->view('rate/index');
					$this->load->view('templates/footer');
				}
			}
		}
	}

	public function get_key($k)
	{
		$form_key = $this->Ratemodel->get_key($k);
		if (!$form_key) {
			return false;
		} else {
			return $form_key;
		}
	}

	public function index($k, $w = null)
	{
		//if platform form_key exist in url
		if ($k) {
			$db_key = $this->get_key($k);

			if ($db_key === $k) {

				//if website exist in url
				if (empty($w) || $w == null) {
					$data['platforms'] = $this->Ratemodel->get_platforms_by_key($k);
					$data['k'] = $k;

					$data['title'] = "select platform";

					$this->load->view('templates/header', $data);
					$this->load->view('rate/pick_platform');
					$this->load->view('templates/footer');
				} else {
					$res = $this->Ratemodel->is_valid_platform($k, $w);

					if ($res === false) {
						$this->setFlashMsg("error", "Invalid Parameter!");
						redirect('wtr/' . $k);
					} else {
						//check if platform is active
						if ($res->active === '1') {
							$data['platform'] = $res;

							$data['title'] = "submit review";

							$this->load->view('templates/header', $data);
							$this->load->view('rate/index');
							$this->load->view('templates/footer');
						} else {
							$this->setFlashMsg("error", "Inactive Platform");
							redirect('/');
						}
					}
				}
			} else {
				$this->setFlashMsg("error", "Invalid Parameter!");
				redirect('/');
			}
		} else {
			$this->setFlashMsg("error", "Missing Parameter");
			redirect('/');
		}
	}


	public function saveRating()
	{
		if (count($_POST) > 0 && $_POST['form_key']) {

			$k = $_POST['form_key'];
			$web_id = $_POST['web_id'];
			$q_res = $this->Ratemodel->is_userquotaexpired($k); //check all credentials
			// $q_res = false;

			if ($q_res === 'not_found') { //invalid data (not found in DB)

				$data['status'] = false;
				$data['msg'] = "Invalid Platform";
			} else if ($q_res === 'pending_balance') { //pending balance

				$data['status'] = false;
				$data['msg'] = "Pending Balance";
			} else if ($q_res !== false) { //quota expired

				$data['status'] = false;
				$data['msg'] = "Quota limit reached";
			} else if ($q_res === false) { //all requirements are met //save to db

				$rData = array(
					'user_ip' => $_SERVER['REMOTE_ADDR'],
					'star' => htmlentities($_POST['starv']),
					'review' => htmlentities($_POST['review']),
					'name' => htmlentities($_POST['name']),
					'mobile' => htmlentities($_POST['mobile']),
					'web_name' => htmlentities($_POST['web_name']),
					'web_link' => htmlentities($_POST['web_link']),
					'form_key' => htmlentities($_POST['form_key'])
				);
				$res = $this->Ratemodel->saveRating($rData, $k, $web_id);
				// $res =false;

				if ($res === true) {
					$log = "Feedback recorded [ Platform: " . htmlentities($_POST['web_name']) . ", Form Key: " . htmlentities($_POST['form_key']) . " ]";
					$this->log_act($log);

					$pu = parse_url($_POST['web_link'], PHP_URL_SCHEME);
					if (($pu === 'https') || ($pu === 'http')) {
						$redirectLink = $_POST['web_link'];
					} else {
						$redirectLink = 'https://' . $_POST['web_link'];
					}

					$data['redirectLink'] = $redirectLink;
					$data['status'] = $res;
					$data['msg'] = "Thanks for your feedback!";
				} else {
					$log = "Failed to store feedback [ Platform: " . htmlentities($_POST['web_name']) . ", Form Key: " . htmlentities($_POST['form_key']) . " ]";
					$this->log_act($log);

					$data['status'] = false;
					$data['msg'] = "Failed to store feedback";
					$data['msg_notify'] = "User quota expired. <a href='" . base_url("user/notifyuser_email/" . $_POST['form_key'] . "") . "' class='text-info'>Notify User?</a>";
				}
			}
		} else {
			$data['status'] = false;
			$data['msg'] = 'No data';
		}

		$data['token'] = $this->security->get_csrf_hash();
		echo json_encode($data);
	}

	//
	//still in limbo.....
	public function notifyuser_email($form_key)
	{
		$data = $this->Usermodel->get_user_email($form_key);

		$uemail = $data->email;
		$uname = $data->uname;

		$this->load->library('emailconfig');
		$res = $this->emailconfig->notifyuser_sendemail($uemail, $uname);

		if ($res !== true) {
			$log = "Error sending mail - Quota expired [ Email: " . $uemail . ", MailError: " . $res . " ]";
			$this->log_act($log);

			$this->setFlashMsg('error', $res);
			redirect($_SERVER['HTTP_REFERER']);
		} else {
			$log = "Mail sent - Quota expired [ Email: " . $uemail . " ]";
			$this->log_act($log);

			$this->setFlashMsg('success', 'User has been notified');
			redirect($_SERVER['HTTP_REFERER']);
		}
	}
	//
	//
}
