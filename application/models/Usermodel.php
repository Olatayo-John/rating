<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Usermodel extends CI_Model
{
	public function login()
	{
		$uname = htmlentities($this->input->post('uname'));
		$pwd = $this->input->post('pwd');

		$user = $this->db->get_where('users', array('uname' => $uname))->row();
		if (!$user) {
			return false;
			exit();
		}
		if ($user->active == "0") {
			return "inactive";
			exit();
		}
		if ($user->active == "1") {
			if (password_verify($pwd, $user->password)) {
				return $user;
				exit();
			} else {
				return false;
				exit();
			}
		}
	}

	public function login_get_key()
	{
		$uname = htmlentities($this->input->post('uname'));

		$user = $this->db->get_where('users', array('uname' => $uname))->row();
		if ($user->active == "0") {
			return $user->form_key;
			exit();
		}
	}

	public function check_duplicate_username($uname)
	{
		$user = $this->db->get_where('users', array('uname' => $uname));
		if (!$user) {
			return false;
			exit;
		} else {
			return $user->num_rows();
			exit;
		}
	}

	public function register($act_key, $form_key)
	{
		$data = array(
			'uname' => htmlentities($this->input->post('uname')),
			'fname' => htmlentities($this->input->post('fname')),
			'lname' => htmlentities($this->input->post('lname')),
			'email' => htmlentities($this->input->post('email')),
			'mobile' => htmlentities($this->input->post('mobile')),
			'active' => "0",
			'sub' => "0",
			'form_key' => $form_key,
			'act_key' => password_hash($act_key, PASSWORD_DEFAULT),
			'password' => password_hash($this->input->post('pwd'), PASSWORD_DEFAULT),
		);
		$this->db->insert('users', $data);
		return TRUE;
	}

	public function insert_user_details($lastid, $form_key)
	{
		$data = array(
			'user_id' => $lastid,
			'form_key' => $form_key,
			'web_name' => htmlentities($this->input->post('uname')),
			'total_ratings' => '0',
			'total_sms' => '0',
			'total_email' => '0',
			'total_one' => '0',
			'total_two' => '0',
			'total_three' => '0',
			'total_four' => '0',
			'total_five' => '0',
		);
		$this->db->insert('user_details', $data);
		return true;
	}

	public function insert_quota($lastid, $form_key)
	{
		$data = array(
			'by_user_id' => $lastid,
			'bought' => '0',
			'used' => '0',
			'bal' => '0',
			'by_form_key' => $form_key,
			'sub' => '0',
		);
		$this->db->insert('quota', $data);
		return true;
	}

	public function check_verification($key)
	{
		$query = $this->db->get_where('users', array('form_key' => $key))->row();
		if (!$query) {
			return false;
		} else if ($query) {
			return $query;
		}
	}

	public function emailverify($key)
	{
		$data = array(
			'sentcode' => htmlentities($this->input->post('sentcode')),
		);
		$info = $this->db->get_where('users', array('form_key' => $key))->row();
		$act_keyDB = password_verify($this->input->post('sentcode'), $info->act_key);
		if ($act_keyDB == 0) {
			return false;
			exit();
		} elseif ($act_keyDB == 1) {
			$this->db->set('active', '1');
			$this->db->where('form_key', $key);
			$this->db->update('users');
			return TRUE;
			exit();
		}
	}

	public function code_verify_update($act_key, $key)
	{
		$this->db->set('act_key', password_hash($act_key, PASSWORD_DEFAULT));
		$this->db->where('form_key', $key);
		$this->db->update("users");
		return true;
		exit;
	}

	public function get_info()
	{
		$query = $this->db->get_where('users', array('id' => $this->session->userdata('mr_id')))->row();
		if (!$query) {
			return false;
			exit();
		} else {
			return $query;
		}
	}

	public function personal_edit()
	{
		$data = array(
			'uname' => htmlentities($this->input->post('uname')),
			'fname' => htmlentities($this->input->post('fname')),
			'lname' => htmlentities($this->input->post('lname')),
			'email' => htmlentities($this->input->post('email')),
			'mobile' => htmlentities($this->input->post('mobile')),
		);
		$this->db->where('id', $this->session->userdata('mr_id'));
		$this->db->update('users', $data);
		return TRUE;
	}

	public function get_user_websites()
	{
		$query = $this->db->get_where('websites', array('user_id' => $this->session->userdata('mr_id'), 'form_key' => $this->session->userdata('mr_form_key')));
		if (!$query) {
			return false;
			exit();
		} else {
			return $query;
		}
	}

	public function add_website()
	{
		$data = array(
			'user_id' => $this->session->userdata('mr_id'),
			'form_key' => $this->session->userdata('mr_form_key'),
			'web_name' => htmlentities($this->input->post('web_name')),
			'web_link' => htmlentities($this->input->post('web_link')),
			// 'active' => htmlentities($this->input->post('active')),
			'active' => "1",
			'total_ratings' => "0",
			'five_star' => "0",
			'four_star' => "0",
			'three_star' => "0",
			'two_star' => "0",
			'one_star' => "0",
		);
		$this->db->insert('websites', $data);
		return TRUE;
	}

	public function delete_website($id)
	{
		$user_id = $this->session->userdata("mr_id");
		$form_key = $this->session->userdata("mr_form_key");

		$this->db->where(array('id' => $id, 'user_id' => $user_id, 'form_key' => $form_key));
		$this->db->delete('websites');
		return TRUE;
	}

	public function website_status($id, $status)
	{
		$user_id = $this->session->userdata("mr_id");
		$form_key = $this->session->userdata("mr_form_key");

		$this->db->where(array('id' => $id, 'user_id' => $user_id, 'form_key' => $form_key));
		$this->db->set('active', $status);
		$this->db->update('websites');
		return TRUE;
	}

	public function edit_website($id)
	{
		$user_id = $this->session->userdata("mr_id");
		$form_key = $this->session->userdata("mr_form_key");

		$this->db->where(array('id' => $id, 'user_id' => $user_id, 'form_key' => $form_key));
		$query = $this->db->get('websites')->row();
		if (!$query) {
			return false;
		} else {
			return $query;
		}
	}

	public function update_website()
	{
		$data = array(
			'web_name' => htmlentities($this->input->post('web_name_edit')),
			'web_link' => htmlentities($this->input->post('web_link_edit')),
		);
		$id = htmlentities($this->input->post('web_id'));
		$user_id = $this->session->userdata("mr_id");
		$form_key = $this->session->userdata("mr_form_key");

		$this->db->where(array('id' => $id, 'user_id' => $user_id, 'form_key' => $form_key));
		$this->db->update('websites', $data);
		return TRUE;
	}

	public function check_pwd()
	{
		$c_pwd = $this->input->post('c_pwd');
		$n_pwd = $this->input->post('n_pwd');
		$query = $this->db->get_where('users', array('id' => $this->session->userdata('mr_id')))->row();
		if (!$query) {
			return false;
			exit;
			//if user, crossheck password in DB with user input
		} else {
			if (password_verify($c_pwd, $query->password)) {
				//if crosscheck is true, hash and save the new password
				$this->db->set('password', password_hash($n_pwd, PASSWORD_DEFAULT));
				$this->db->where('id', $this->session->userdata('mr_id'));
				$this->db->update('users');
				return true;
				exit;
			} else {
				return false;
				exit;
			}
		}
	}

	public function deact_account()
	{
		$this->db->set('active', '0');
		$this->db->where('id', $this->session->userdata('mr_id'));
		$this->db->update('users');
		$this->session->set_userdata('mr_active', '0');
		return true;
	}

	public function user_total_ratings()
	{
		$query = $this->db->get_where('user_details', array('form_key' => $this->session->userdata('mr_form_key')));
		return $query->result_array();
	}

	public function user_quota()
	{
		$query = $this->db->get_where('quota', array('by_form_key' => $this->session->userdata('mr_form_key')))->row();
		if ($query) {
			return $query;
			exit;
		} else {
			return false;
			exit;
		}
	}

	public function all_user_sent_links()
	{
		$query = $this->db->get('sent_links');
		return $query->result();
	}

	public function get_link($id)
	{
		$query = $this->db->get_where('users', array('id' => $id))->row();
		if (!$query) {
			return false;
			exit();
		}
		if ($query->sub == "0") {
			return "inactive_sub";
			exit();
		} else {
			return $query;
		}
	}

	public function user_quota_details()
	{
		$query = $this->db->get_where('quota', array('by_form_key' => $this->session->userdata('mr_form_key'), 'by_user_id' => $this->session->userdata('mr_id')))->row();
		if ($query) {
			return $query;
			exit;
		} else {
			return false;
			exit;
		}
	}

	public function check_user_quota()
	{
		$query = $this->db->get_where('quota', array('by_form_key' => $this->session->userdata('mr_form_key'), 'by_user_id' => $this->session->userdata('mr_id')))->row();
		if ($query->bal == "0" || $query->bal < '0') {
			$this->db->set('bal', '0');
			$this->db->where('by_form_key', $form_key);
			$this->db->update('quota');

			$this->user_sub_update();
			return true;
			exit;
		} elseif ($query->bal > "0") {
			return false;
			exit;
		}
	}

	public function user_sub_update()
	{
		$this->db->set('sub', '0');
		$this->session->set_userdata('mr_sub', '0');
		$this->db->where('form_key', $this->session->userdata('mr_form_key'));
		$this->db->update('users');
		return true;
	}

	public function user_quota_update($length)
	{
		$this->db->set('used', 'used+' . $length, FALSE);
		$this->db->set('bal', 'bal-' . $length, FALSE);
		$this->db->where(array('by_form_key' => $this->session->userdata('mr_form_key'), 'by_user_id' => $this->session->userdata('mr_id')));
		$this->db->update('quota');
		return true;
		exit;
	}

	public function save_info()
	{
		$data = array(
			'link_for' => htmlentities($this->input->post('link_for')),
			'email' => htmlentities($this->input->post('email')),
			'subj' => htmlentities($this->input->post('subj')),
			'body' => htmlentities($this->input->post('bdy')),
			'user_id' => $this->session->userdata('mr_id'),
		);
		$this->db->insert('sent_links', $data);
		$num = '1';
		$length = '1';
		$this->userdetails_email_update($num);
		$this->user_quota_update($length);
		return true;
	}

	public function userdetails_email_update($num)
	{
		$this->db->set('email', 'email+' . $num, FALSE);
		$this->db->where('form_key', $this->session->userdata('mr_form_key'));
		$this->db->update('user_details');
		return true;
	}

	public function multiplemail_save_info($emaildata, $subj, $bdy, $link_for)
	{
		$data = array(
			'email' => htmlentities(implode(",", $emaildata)),
			'subj' => htmlentities($subj),
			'body' => htmlentities($bdy),
			'link_for' => htmlentities($link_for),
			'user_id' => $this->session->userdata('mr_id'),
		);
		$this->db->insert('sent_links', $data);
		$num = count($emaildata);
		$this->userdetails_email_update($num);
		return true;
	}

	public function sms_save_info()
	{
		$data = array(
			'link_for' => htmlentities($this->input->post('link_for')),
			'mobile' => htmlentities($this->input->post('mobile')),
			'body' => htmlentities($this->input->post('smsbdy')),
			'user_id' => $this->session->userdata('mr_id'),
		);
		$this->db->insert('sent_links', $data);
		$num = '1';
		$length = '1';
		$this->userdetails_sms_update($num);
		$this->user_quota_update($length);
		return true;
	}

	public function userdetails_sms_update($num)
	{
		$this->db->set('sms', 'sms+' . $num, FALSE);
		$this->db->where('form_key', $this->session->userdata('mr_form_key'));
		$this->db->update('user_details');
		return true;
	}

	public function multiplsms_save_info($mobiledata, $smsbdy, $link_for)
	{
		$data = array(
			'link_for' => htmlentities($link_for),
			'mobile' => htmlentities(implode(",", $mobiledata)),
			'body' => htmlentities($smsbdy),
			'user_id' => $this->session->userdata('mr_id'),
		);
		$num = count($mobiledata);
		$this->db->insert('sent_links', $data);
		$this->multiple_sms_update($num);
		return true;
	}

	public function multiple_sms_update($num)
	{
		$this->db->set('sms', 'sms+' . $num, FALSE);
		$this->db->where('form_key', $this->session->userdata('mr_form_key'));
		$this->db->update('user_details');
		return true;
	}

	public function fb_data()
	{
		$query = $this->db->get_where('fb_ratings', array('c_id' => $this->session->userdata('mr_form_key')));
		return $query->num_rows();
	}
	public function fb_data1()
	{
		$query = $this->db->get_where('fb_ratings', array("star" => "1", "c_id" => $this->session->userdata('mr_form_key')));
		return $query->num_rows();
	}
	public function fb_data2()
	{
		$query = $this->db->get_where('fb_ratings', array("star" => "2", "c_id" => $this->session->userdata('mr_form_key')));
		return $query->num_rows();
	}
	public function fb_data3()
	{
		$query = $this->db->get_where('fb_ratings', array("star" => "3", "c_id" => $this->session->userdata('mr_form_key')));
		return $query->num_rows();
	}
	public function fb_data4()
	{
		$query = $this->db->get_where('fb_ratings', array("star" => "4", "c_id" => $this->session->userdata('mr_form_key')));
		return $query->num_rows();
	}
	public function fb_data5()
	{
		$query = $this->db->get_where('fb_ratings', array("star" => "5", "c_id" => $this->session->userdata('mr_form_key')));
		return $query->num_rows();
	}

	public function g_data()
	{
		$query = $this->db->get_where('google_ratings', array("c_id" => $this->session->userdata('mr_form_key')));
		return $query->num_rows();
	}
	public function g_data1()
	{
		$query = $this->db->get_where('google_ratings', array("star" => "1", "c_id" => $this->session->userdata('mr_form_key')));
		return $query->num_rows();
	}
	public function g_data2()
	{
		$query = $this->db->get_where('google_ratings', array("star" => "2", "c_id" => $this->session->userdata('mr_form_key')));
		return $query->num_rows();
	}
	public function g_data3()
	{
		$query = $this->db->get_where('google_ratings', array("star" => "3", "c_id" => $this->session->userdata('mr_form_key')));
		return $query->num_rows();
	}
	public function g_data4()
	{
		$query = $this->db->get_where('google_ratings', array("star" => "4", "c_id" => $this->session->userdata('mr_form_key')));
		return $query->num_rows();
	}
	public function g_data5()
	{
		$query = $this->db->get_where('google_ratings', array("star" => "5", "c_id" => $this->session->userdata('mr_form_key')));
		return $query->num_rows();
	}

	public function ow_data()
	{
		$query = $this->db->get_where('mainweb_rating', array("c_id" => $this->session->userdata('mr_form_key')));
		return $query->num_rows();
	}
	public function ow_data1()
	{
		$query = $this->db->get_where('mainweb_rating', array("star" => "1", "c_id" => $this->session->userdata('mr_form_key')));
		return $query->num_rows();
	}
	public function ow_data2()
	{
		$query = $this->db->get_where('mainweb_rating', array("star" => "2", "c_id" => $this->session->userdata('mr_form_key')));
		return $query->num_rows();
	}
	public function ow_data3()
	{
		$query = $this->db->get_where('mainweb_rating', array("star" => "3", "c_id" => $this->session->userdata('mr_form_key')));
		return $query->num_rows();
	}
	public function ow_data4()
	{
		$query = $this->db->get_where('mainweb_rating', array("star" => "4", "c_id" => $this->session->userdata('mr_form_key')));
		return $query->num_rows();
	}
	public function ow_data5()
	{
		$query = $this->db->get_where('mainweb_rating', array("star" => "5", "c_id" => $this->session->userdata('mr_form_key')));
		return $query->num_rows();
	}

	public function tp_data()
	{
		$query = $this->db->get_where('trustpilot_ratings', array("c_id" => $this->session->userdata('mr_form_key')));
		return $query->num_rows();
	}
	public function tp_data1()
	{
		$query = $this->db->get_where('trustpilot_ratings', array("star" => "1", "c_id" => $this->session->userdata('mr_form_key')));
		return $query->num_rows();
	}
	public function tp_data2()
	{
		$query = $this->db->get_where('trustpilot_ratings', array("star" => "2", "c_id" => $this->session->userdata('mr_form_key')));
		return $query->num_rows();
	}
	public function tp_data3()
	{
		$query = $this->db->get_where('trustpilot_ratings', array("star" => "3", "c_id" => $this->session->userdata('mr_form_key')));
		return $query->num_rows();
	}
	public function tp_data4()
	{
		$query = $this->db->get_where('trustpilot_ratings', array("star" => "4", "c_id" => $this->session->userdata('mr_form_key')));
		return $query->num_rows();
	}
	public function tp_data5()
	{
		$query = $this->db->get_where('trustpilot_ratings', array("star" => "5", "c_id" => $this->session->userdata('mr_form_key')));
		return $query->num_rows();
	}

	public function gd_data()
	{
		$query = $this->db->get_where('glassdoor_ratings', array("c_id" => $this->session->userdata('mr_form_key')));
		return $query->num_rows();
	}
	public function gd_data1()
	{
		$query = $this->db->get_where('glassdoor_ratings', array("star" => "1", "c_id" => $this->session->userdata('mr_form_key')));
		return $query->num_rows();
	}
	public function gd_data2()
	{
		$query = $this->db->get_where('glassdoor_ratings', array("star" => "2", "c_id" => $this->session->userdata('mr_form_key')));
		return $query->num_rows();
	}
	public function gd_data3()
	{
		$query = $this->db->get_where('glassdoor_ratings', array("star" => "3", "c_id" => $this->session->userdata('mr_form_key')));
		return $query->num_rows();
	}
	public function gd_data4()
	{
		$query = $this->db->get_where('glassdoor_ratings', array("star" => "4", "c_id" => $this->session->userdata('mr_form_key')));
		return $query->num_rows();
	}
	public function gd_data5()
	{
		$query = $this->db->get_where('glassdoor_ratings', array("star" => "5", "c_id" => $this->session->userdata('mr_form_key')));
		return $query->num_rows();
	}

	public function get_key($key)
	{
		$query = $this->db->get_where('users', array("form_key" => $key))->row();
		return $query->form_key;
	}

	public function info($key)
	{
		$query = $this->db->get_where('users', array("form_key" => $key))->row();
		if (!$query) {
			return false;
			exit();
		} else {
			return $query;
		}
	}

	public function check_quota_expire($form_key)
	{
		$query = $this->db->get_where('quota', array('by_form_key' => $form_key))->row();
		if ($query->bal == "0" || $query->bal < "0") {
			$this->db->set('bal', '0');
			$this->db->where('by_form_key', $form_key);
			$this->db->update('quota');
			return true;
			exit;
		} elseif ($query->bal > "0") {
			return false;
			exit;
		}
	}

	public function rating_store($starv, $msg, $name, $mobile, $tbl_name, $form_key, $for_link)
	{
		$data = array(
			'user_ip' => $_SERVER['REMOTE_ADDR'],
			'star' => htmlentities($starv),
			'review_msg' => htmlentities($msg),
			'name' => htmlentities($name),
			'mobile' => htmlentities($mobile),
			'c_id' => $form_key,
		);
		$this->db->insert($tbl_name, $data);
		$this->db->insert('all_ratings', $data);
		$this->for_link_update($form_key, $for_link);
		$this->user_details_save_rating($starv, $form_key);
		$this->rating_quota_update($form_key);
		$data = $this->get_user_website($form_key);
		return $data;
	}

	public function for_link_update($form_key, $for_link)
	{
		$this->db->set($for_link, $for_link . '+1', FALSE);
		$this->db->where('form_key', $form_key);
		$this->db->update('user_details');
		return true;
	}

	public function user_details_save_rating($starv, $form_key)
	{
		if ($starv == "5") {
			$this->db->set('5_star', '5_star+1', FALSE);
			$this->db->set('total_links', 'total_links+1', FALSE);
			$this->db->where('form_key', $form_key);
			$this->db->update('user_details');
			return true;
			exit;
		}
		if ($starv == "4") {
			$this->db->set('4_star', '4_star+1', FALSE);
			$this->db->set('total_links', 'total_links+1', FALSE);
			$this->db->where('form_key', $form_key);
			$this->db->update('user_details');
			return true;
			exit;
		}
		if ($starv == "3") {
			$this->db->set('3_star', '3_star+1', FALSE);
			$this->db->set('total_links', 'total_links+1', FALSE);
			$this->db->where('form_key', $form_key);
			$this->db->update('user_details');
			return true;
			exit;
		}
		if ($starv == "2") {
			$this->db->set('2_star', '2_star+1', FALSE);
			$this->db->set('total_links', 'total_links+1', FALSE);
			$this->db->where('form_key', $form_key);
			$this->db->update('user_details');
			return true;
			exit;
		}
		if ($starv == "1") {
			$this->db->set('1_star', '1_star+1', FALSE);
			$this->db->set('total_links', 'total_links+1', FALSE);
			$this->db->where('form_key', $form_key);
			$this->db->update('user_details');
			return true;
			exit;
		}
	}

	public function rating_quota_update($form_key)
	{
		$this->db->set('used', 'used+1', FALSE);
		$this->db->set('bal', 'bal-1', FALSE);
		$this->db->where('by_form_key', $form_key);
		$this->db->update('quota');
		return true;
	}

	public function get_user_website($form_key)
	{
		$this->db->where('form_key', $form_key);
		$query = $this->db->get('users')->row();
		return $query;
	}

	public function sample()
	{
		return true;
	}
}
