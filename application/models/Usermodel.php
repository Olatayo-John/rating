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
		if ($user->active == "2") {
			return "inactive_access";
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

	public function user_latestact()
	{
		$this->db->set("latest_activity", date(DATE_COOKIE), TRUE);
		$this->db->where('id', $this->session->userdata('mr_id'));
		$this->db->update("users");
		return true;
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
			's_admin' => '0',
			'admin' => '0',
			'uname' => htmlentities($this->input->post('uname')),
			'fname' => htmlentities($this->input->post('fname')),
			'lname' => htmlentities($this->input->post('lname')),
			'email' => htmlentities($this->input->post('email')),
			'mobile' => htmlentities($this->input->post('mobile')),
			'active' => "0",
			'website_form' => "0",
			'sub' => "0",
			'sub_active' => "0",
			'web_quota' => "10",
			'form_key' => $form_key,
			'act_key' => password_hash($act_key, PASSWORD_DEFAULT),
			'password' => password_hash($this->input->post('pwd'), PASSWORD_DEFAULT),
		);
		$this->db->insert('users', $data);
		$lastid = $this->db->insert_id();
		$this->insert_user_details($lastid, $form_key);
		$this->insert_quota($lastid, $form_key);
		return TRUE;
	}

	public function insert_user_details($lastid, $form_key)
	{
		$data = array(
			'user_id' => $lastid,
			'form_key' => $form_key,
			'uname' => htmlentities($this->input->post('uname')),
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
			$new_info = $this->db->get_where('users', array('form_key' => $key))->row();
			return $new_info;
			// return TRUE;
			// exit();
		}
	}

	public function addwebsites($webname_arr, $weblink_arr)
	{
		$web_count = count($webname_arr);
		if ($web_count > $this->session->userdata('mr_web_quota')) {
			$web_count == $this->session->userdata('mr_web_quota');
		}
		for ($i = 0; $i < $web_count; $i++) {
			$data = array(
				'user_id' => $this->session->userdata('mr_id'),
				'form_key' => $this->session->userdata('mr_form_key'),
				'web_name' => htmlentities($webname_arr[$i]),
				'web_link' => htmlentities($weblink_arr[$i]),
				'active' => $this->session->userdata('mr_active'),
				'total_ratings' => "0",
				'five_star' => "0",
				'four_star' => "0",
				'three_star' => "0",
				'two_star' => "0",
				'one_star' => "0",
			);
			$this->db->insert('websites', $data);
		}
		$this->update_webform();
		return TRUE;
	}

	public function update_webform()
	{
		$user_id = $this->session->userdata("mr_id");
		$form_key = $this->session->userdata("mr_form_key");

		$this->db->set('website_form', '1');
		$this->db->where(array('form_key' => $form_key, 'id' => $user_id));
		$this->db->update("users");

		$this->session->set_userdata("mr_website_form", "1");
		return true;
		exit;
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

	public function check_user_websites()
	{
		$query = $this->db->get_where('websites', array('user_id' => $this->session->userdata('mr_id'), 'form_key' => $this->session->userdata('mr_form_key')));
		if (!$query) {
			return false;
			exit();
		} else {
			return $query->num_rows();
			exit;
		}
	}

	public function check_duplicate_webname($webname)
	{
		$data = $this->db->get_where('websites', array('user_id' => $this->session->userdata("mr_id"), 'form_key' => $this->session->userdata("mr_form_key"), 'web_name' => $webname));
		if (!$data) {
			return false;
			exit;
		} else {
			return $data->num_rows();
			exit;
		}
	}

	public function check_duplicate_weblink($weblink)
	{
		$data = $this->db->get_where('websites', array('user_id' => $this->session->userdata("mr_id"), 'form_key' => $this->session->userdata("mr_form_key"), 'web_link' => $weblink));
		if (!$data) {
			return false;
			exit;
		} else {
			return $data->num_rows();
			exit;
		}
	}

	public function checkduplicatewebname($form_key, $user_id, $web_name_add)
	{
		$data = $this->db->get_where('websites', array('user_id' => $user_id, 'form_key' => $form_key, 'web_name' => $web_name_add));
		if (!$data) {
			return false;
			exit;
		} else {
			return $data->num_rows();
			exit;
		}
	}

	public function checkduplicateweblink($form_key, $user_id, $web_link_add)
	{
		$data = $this->db->get_where('websites', array('user_id' => $user_id, 'form_key' => $form_key, 'web_link' => $web_link_add));
		if (!$data) {
			return false;
			exit;
		} else {
			return $data->num_rows();
			exit;
		}
	}

	public function user_new_website()
	{
		$res_web = $this->check_user_websites();
		if ($res_web > $this->session->userdata('mr_web_quota')) {
			return "Maximum quota reached. Contact Admin for more quota";
			exit;
		} else {
			$data = array(
				'user_id' => $this->session->userdata('mr_id'),
				'form_key' => $this->session->userdata('mr_form_key'),
				'web_name' => htmlentities($this->input->post('web_name_new')),
				'web_link' => htmlentities($this->input->post('web_link_new')),
				'active' => $this->session->userdata('mr_active'),
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
			// 'uname' => htmlentities($this->input->post('uname')),
			'fname' => htmlentities($this->input->post('fname')),
			'lname' => htmlentities($this->input->post('lname')),
			'email' => htmlentities($this->input->post('email')),
			'mobile' => htmlentities($this->input->post('mobile')),
		);
		$this->db->where('id', $this->session->userdata('mr_id'));
		$this->db->update('users', $data);
		return TRUE;
	}

	public function update_user_websiteform()
	{
		$user_id = $this->session->userdata("mr_id");
		$form_key = $this->session->userdata("mr_form_key");

		$this->db->where(array('id' => $user_id, 'form_key' => $form_key));
		$this->db->set('website_form', '1');
		$this->db->update('users');
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

	// public function search_website($search_data)
	// {
	// 	$this->db->select('*');
	// 	$this->db->from('websites');
	// 	if ($search_data != '') {
	// 		$this->db->like('web_name', $search_data);
	// 	}
	// 	$this->db->order_by('id', 'DESC');
	// 	return $this->db->get();
	// }

	public function user_total_ratings()
	{
		$query = $this->db->get_where('user_details', array('form_key' => $this->session->userdata('mr_form_key')))->row();
		if (!$query) {
			return false;
			exit;
		} else {
			return $query;
		}
	}

	public function user_total_quota()
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
		$this->db->order_by('id', 'desc');
		$query = $this->db->get('sent_links');
		return $query;
	}

	public function all_user_sent_links_sms()
	{
		$this->db->where('sent_to_email', null);
		$query = $this->db->get('sent_links');
		return $query;
	}

	public function all_user_sent_links_email()
	{
		$this->db->where('sent_to_sms', null);
		$query = $this->db->get('sent_links');
		return $query;
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
		$form_key = $this->session->userdata('mr_form_key');
		$id = $this->session->userdata('mr_id');

		$query = $this->db->get_where('quota', array('by_form_key' => $form_key, 'by_user_id' => $id))->row();
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
			'sent_to_email' => htmlentities($this->input->post('email')),
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
		$this->db->set('total_email', 'total_email+' . $num, FALSE);
		$this->db->where('form_key', $this->session->userdata('mr_form_key'));
		$this->db->update('user_details');
		return true;
	}

	public function multiplemail_save_info($emaildata, $subj, $bdy)
	{
		$data = array(
			'sent_to_email' => htmlentities(implode(",", $emaildata)),
			'subj' => htmlentities($subj),
			'body' => htmlentities($bdy),
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
			'sent_to_sms' => htmlentities($this->input->post('mobile')),
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
		$this->db->set('total_sms', 'total_sms+' . $num, FALSE);
		$this->db->where('form_key', $this->session->userdata('mr_form_key'));
		$this->db->update('user_details');
		return true;
	}

	public function multiplsms_save_info($mobiledata, $smsbdy)
	{
		$data = array(
			'sent_to_sms' => htmlentities(implode(",", $mobiledata)),
			'body' => htmlentities($smsbdy),
			'user_id' => $this->session->userdata('mr_id'),
		);
		$num = count($mobiledata);
		$this->db->insert('sent_links', $data);
		$this->userdetails_sms_update($num);
		return true;
	}

	public function get_key($key)
	{
		$query = $this->db->get_where('users', array("form_key" => $key))->row();
		return $query->form_key;
	}

	public function check_cred($w, $k)
	{
		$query = $this->db->get_where('websites', array("form_key" => $k, "web_name" => $w))->row();
		if ($query) {
			if ($query->active === "0") {
				return false;
				exit;
			} else if ($query->active === "1") {
				return true;
				exit;
			}
		} else {
			return false;
		}
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
		if ($query) {
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
		} else {
			return true;
			exit;
		}
	}

	public function rating_store($starv, $name, $mobile, $form_key, $for_link)
	{
		$data = array(
			'user_ip' => $_SERVER['REMOTE_ADDR'],
			'star' => htmlentities($starv),
			'web_name' => htmlentities($for_link),
			'name' => htmlentities($name),
			'mobile' => htmlentities($mobile),
			'form_key' => htmlentities($form_key),
		);
		$this->db->insert("all_ratings", $data);

		$this->userweb_update($form_key, $for_link, $starv);
		$this->user_details_save_rating($starv, $form_key);
		$this->rating_quota_update($form_key);
		$data = $this->get_user_weblink($form_key);
		return $data;
	}

	public function userweb_update($form_key, $for_link, $starv)
	{
		if ($starv == "5") {
			$db_star = "five_star";
		}
		if ($starv == "4") {
			$db_star = "four_star";
		}
		if ($starv == "3") {
			$db_star = "three_star";
		}
		if ($starv == "2") {
			$db_star = "two_star";
		}
		if ($starv == "1") {
			$db_star = "one_star";
		}

		$this->db->set($db_star, $db_star . '+1', FALSE);
		$this->db->set("total_ratings", 'total_ratings+1', FALSE);
		$this->db->where(array('web_name' => $for_link, 'form_key' => $form_key));
		$this->db->update('websites');
		return true;
	}

	public function user_details_save_rating($starv, $form_key)
	{
		if ($starv == "5") {
			$this->db->set('total_five', 'total_five+1', FALSE);
			$this->db->set('total_ratings', 'total_ratings+1', FALSE);
			$this->db->where('form_key', $form_key);
			$this->db->update('user_details');
			return true;
			exit;
		}
		if ($starv == "4") {
			$this->db->set('total_four', 'total_four+1', FALSE);
			$this->db->set('total_ratings', 'total_ratings+1', FALSE);
			$this->db->where('form_key', $form_key);
			$this->db->update('user_details');
			return true;
			exit;
		}
		if ($starv == "3") {
			$this->db->set('total_three', 'total_three+1', FALSE);
			$this->db->set('total_ratings', 'total_ratings+1', FALSE);
			$this->db->where('form_key', $form_key);
			$this->db->update('user_details');
			return true;
			exit;
		}
		if ($starv == "2") {
			$this->db->set('total_two', 'total_two+1', FALSE);
			$this->db->set('total_ratings', 'total_ratings+1', FALSE);
			$this->db->where('form_key', $form_key);
			$this->db->update('user_details');
			return true;
			exit;
		}
		if ($starv == "1") {
			$this->db->set('total_one', 'total_one+1', FALSE);
			$this->db->set('total_ratings', 'total_ratings+1', FALSE);
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

	public function get_user_weblink($form_key)
	{
		$this->db->where('form_key', $form_key);
		$query = $this->db->get('websites')->row();
		return $query;
	}

	public function get_user_email($form_key)
	{
		$this->db->where('form_key', $form_key);
		$query = $this->db->get('users')->row();
		return $query;
	}

	public function contact()
	{
		$data = array(
			'name' => htmlentities($this->input->post('name')),
			'user_mail' => htmlentities($this->input->post('email')),
			'bdy' => htmlentities($this->input->post('msg')),
		);
		$this->db->insert('contact', $data);
		return true;
	}

	public function get_feedbacks()
	{
		$this->db->order_by('id', 'desc');
		$query = $this->db->get('contact');
		return $query;
	}

	public function export_feedbacks()
	{
		$this->db->order_by('id', 'desc');
		$this->db->select('id,name,user_mail,bdy');
		$query = $this->db->get('contact');
		return $query->result_array();
	}
}
