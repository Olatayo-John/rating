<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Usermodel extends CI_Model
{
	// $this->db->select('u.id,u.sadmin,u.admin,u.iscmpy,u.cmpyid,u.cmpy,u.uname,u.email,u.mobile,u.active,u.sub,u.website_form,u.form_key,q.bought,q.webspace,q.webspace_left,q.userspace,q.userspace_left');
	// $this->db->from('users u');
	// $this->db->where('u.uname', $uname);
	// $this->db->join('quota q', 'u.cmpyid=q.by_user_id', 'inner');
	// $userinfo = $this->db->get()->row();
	// return $userinfo;

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
			if ($user->active == "2" && $user->iscmpy == "1") {
				return "inactive_access_by_cmpyAdmin";
			} elseif ($user->active == "2" && $user->iscmpy == "0") {
				return "inactive_access";
			}

			exit();
		}
		//verify passwords
		if (password_verify($pwd, $user->password)) {
			$this->db->select('u.id,u.sadmin,u.admin,u.iscmpy,u.cmpyid,u.cmpy,u.uname,u.email,u.mobile,u.active,u.sub,u.website_form,u.form_key');
			$this->db->from('users u');
			$this->db->where('uname', $uname);
			$userinfo = $this->db->get()->row();
			return $userinfo;
			exit();
		} else {
			return false;
			exit();
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

	public function check_duplicatecmpy($cmpy_val)
	{
		$user = $this->db->get_where('users', array('cmpy' => $cmpy_val));
		if (!$user) {
			return false;
			exit;
		} else {
			return $user->num_rows();
			exit;
		}
	}

	public function register($admin, $iscmpy, $act_key, $form_key)
	{
		$data = array(
			'sadmin' => '0',
			'admin' => $admin,
			'iscmpy' => $iscmpy,
			'cmpy' => htmlentities($this->input->post('cmpy')),
			'uname' => htmlentities($this->input->post('uname')),
			'fname' => htmlentities($this->input->post('fname')),
			'lname' => htmlentities($this->input->post('lname')),
			'email' => htmlentities($this->input->post('email')),
			'mobile' => htmlentities($this->input->post('mobile')),
			'active' => "0",
			'website_form' => "0",
			'sub' => "0",
			'form_key' => $form_key,
			'act_key' => password_hash($act_key, PASSWORD_DEFAULT),
			'password' => password_hash($this->input->post('pwd'), PASSWORD_DEFAULT),
		);
		$this->db->insert('users', $data);
		$lastid = $this->db->insert_id();

		$this->insert_user_details($lastid, $form_key);
		$this->insert_quota($lastid, $form_key);

		if (($iscmpy === 1) && ($admin === 1)) {
			$this->insert_company_details($lastid, $form_key);
		}
		return TRUE;
	}

	///
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
	///

	public function insert_quota($lastid, $form_key)
	{
		$data = array(
			'by_user_id' => $lastid,
			'sms_quota' => htmlentities($this->input->post('sms_quota')),
			'email_quota' => htmlentities($this->input->post('email_quota')),
			'whatsapp_quota' => htmlentities($this->input->post('whatsapp_quota')),
			'web_quota' => htmlentities($this->input->post('web_quota')),
			'by_form_key' => $form_key,
		);
		$this->db->insert('quota', $data);
		return true;
	}

	public function insert_company_details($lastid)
	{
		$data = array(
			'cmpyid' => $lastid,
			'cmpyName' => htmlentities($this->input->post('cmpy')),
			'cmpyMobile' => '',
			'cmpyEmail' => '',
			'cmpyLogo' => ''
		);
		$this->db->insert('company_details', $data);
		return true;
	}

	public function check_verification($key)
	{
		$this->db->select('active,email');
		$this->db->where(array('form_key' => $key));
		$query = $this->db->from('users');
		if (!$query) {
			return false;
		} else if ($query) {
			return $query->get()->row();
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

			$this->db->select('u.id,u.sadmin,u.admin,u.iscmpy,u.cmpyid,u.cmpy,u.uname,u.email,u.mobile,u.active,u.sub,u.website_form,u.form_key');
			$this->db->from('users u');
			$this->db->where('u.form_key', $key);
			$userinfo = $this->db->get()->row();
			return $userinfo;
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

	public function get_user_websites()
	{
		$this->db->order_by('id', 'desc');
		$query = $this->db->get_where('websites', array('user_id' => $this->session->userdata('mr_id'), 'form_key' => $this->session->userdata('mr_form_key')));
		if (!$query) {
			return false;
			exit();
		} else {
			return $query;
		}
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

	public function get_userQuota()
	{
		$id = $this->session->userdata("mr_id");
		$form_key = $this->session->userdata("mr_form_key");
		$iscmpy = $this->session->userdata("mr_iscmpy");
		$cmpyid = $this->session->userdata("mr_cmpyid");

		if ($iscmpy == "1" && !empty($cmpyid) && $cmpyid !== "" && $cmpyid !== null) {
			$wherearray = array('by_user_id' => $cmpyid);
		} else {
			$wherearray = array('by_user_id' => $id, 'by_form_key' => $form_key);
		}
		$this->db->where($wherearray);
		$quotaInfo = $this->db->get("quota")->row();
		return $quotaInfo;
	}

	public function addwebsite($web_name, $web_link)
	{

		$data = array(
			'user_id' => $this->session->userdata('mr_id'),
			'form_key' => $this->session->userdata('mr_form_key'),
			'web_name' => htmlentities($web_name),
			'web_link' => htmlentities($web_link),
			'active' => '1',
			'total_ratings' => "0",
			'star_rating' => "0"
		);
		$this->db->insert('websites', $data);
		$webID = $this->db->insert_id();

		$this->update_webquota($type = "web_quota-1");
		return $webID;
	}

	public function removewebsite($web_name, $web_link, $web_id)
	{
		$this->db->where(array('id' => $web_id, 'web_name' => $web_name, 'web_link' => $web_link));
		$this->db->delete('websites');

		$this->update_webquota($type = "web_quota+1");
		return true;
	}

	public function update_webquota($type)
	{
		$user_id = $this->session->userdata("mr_id");
		$form_key = $this->session->userdata("mr_form_key");
		$iscmpy = $this->session->userdata("mr_iscmpy");
		$cmpyid = $this->session->userdata("mr_cmpyid");

		if ($iscmpy == "1" && !empty($cmpyid) && $cmpyid !== "" && $cmpyid !== null) {
			$wherearray = array('by_user_id' => $cmpyid);
		} else {
			$wherearray = array('by_user_id' => $user_id, 'by_form_key' => $form_key);
		}
		$this->db->set('web_quota', $type, FALSE);
		$this->db->where($wherearray);
		$this->db->update("quota");
		return true;
		exit;
	}

	public function get_webspacequota($web_count)
	{
		$user_id = $this->session->userdata("mr_id");
		$form_key = $this->session->userdata("mr_form_key");
		$iscmpy = $this->session->userdata("mr_iscmpy");
		$cmpyid = $this->session->userdata("mr_cmpyid");

		if ($iscmpy == "1" && !empty($cmpyid) && $cmpyid !== "" && $cmpyid !== null) {
			$wherearray = array('by_user_id' => $cmpyid);
		} else {
			$wherearray = array('by_user_id' => $user_id, 'by_form_key' => $form_key);
		}
		$this->db->where($wherearray);
		$res = $this->db->get("quota")->row();

		if ($res->web_quota > 0) {
			return true;
			exit;
		} else {
			return false;
			exit;
		}
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
			'fname' => htmlentities($this->input->post('fname')),
			'lname' => htmlentities($this->input->post('lname')),
			'email' => htmlentities($this->input->post('email')),
			'mobile' => htmlentities($this->input->post('mobile')),
		);
		$this->db->where('id', $this->session->userdata('mr_id'));
		$this->db->update('users', $data);
		return TRUE;
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

	///
	public function noof_userwebites()
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
	///

	public function createwebsite($web_name_new, $web_link_new)
	{
		$web_count = 1;
		if ($this->get_webspacequota($web_count) === false) {
			return "Web Quota exceeded";
			exit;
		} else {
			$dupname = $this->check_duplicate_webname($web_name_new);
			if ($dupname > 0) {
				return "You have an existing website with the name '" . $web_name_new . "'";
				exit;
			} else {
				$duplink = $this->check_duplicate_weblink($web_link_new);
				if ($duplink > 0) {
					return "You have an existing website with the link '" . $web_link_new . "'";
					exit;
				} else {
					$this->update_webquota($type = "web_quota-1");

					$data = array(
						'user_id' => $this->session->userdata('mr_id'),
						'form_key' => $this->session->userdata('mr_form_key'),
						'web_name' => htmlentities($_POST['web_name_new']),
						'web_link' => htmlentities($_POST['web_link_new']),
						'active' => '1',
						'total_ratings' => "0",
						'star_rating' => "0"
					);
					$this->db->insert('websites', $data);
					return $this->db->insert_id();
				}
			}
		}
	}

	///
	public function delete_website($id)
	{
		$user_id = $this->session->userdata("mr_id");
		$form_key = $this->session->userdata("mr_form_key");

		$this->db->where(array('id' => $id, 'user_id' => $user_id, 'form_key' => $form_key));
		$this->db->delete('websites');
		return TRUE;
	}
	///

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

	public function website_update($id, $webstatus)
	{
		$data = array(
			'active' => $webstatus,
		);
		$id = $id;
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

	public function updateact_key($userid, $act_key, $email)
	{
		$hashkey = password_hash($act_key, PASSWORD_DEFAULT);
		$this->db->set('act_key', $hashkey);
		$this->db->where(array('id' => $userid, 'email' => $email));
		$q = $this->db->update('users');

		if ($q) {
			return true;
			exit;
		} else {
			return false;
			exit;
		}
	}

	public function verifyvcode($userid, $vecode)
	{
		$info = $this->db->get_where('users', array('id' => $userid))->row();
		if (password_verify($vecode, $info->act_key)) {
			return true;
			exit();
		} else {
			return false;
			exit();
		}
	}

	public function changepassword($userid, $newpwd)
	{
		$this->db->set('password', password_hash($newpwd, PASSWORD_DEFAULT));
		$this->db->where('id', $userid);
		$q = $this->db->update('users');

		if ($q) {
			return true;
			exit;
		} else {
			return false;
			exit;
		}
	}

	public function deact_account()
	{
		$this->db->set('active', '2');
		$this->db->where('id', $this->session->userdata('mr_id'));
		$this->db->update('users');
		$this->session->set_userdata('mr_active', '2');
		return true;
	}

	public function allrrbyuser()
	{
		$this->db->order_by('id', 'desc');
		$this->db->where('form_key', $this->session->userdata("mr_form_key"));
		$query = $this->db->get('all_ratings');
		return $query;
	}

	public function allsentlinksbyuser()
	{
		$this->db->order_by('id', 'desc');
		$this->db->where('user_id', $this->session->userdata("mr_id"));
		$query = $this->db->get('sent_links');
		return $query;
	}

	///
	public function userdetails()
	{
		$this->db->where(array('user_id' => $this->session->userdata("mr_id"), 'form_key' => $this->session->userdata("mr_form_key")));
		$query = $this->db->get('user_details')->row();
		return $query;
	}
	///

	public function is_userquotaexpired()
	{
		$user_id = $this->session->userdata("mr_id");
		$form_key = $this->session->userdata('mr_form_key');
		$iscmpy = $this->session->userdata('mr_iscmpy');
		$cmpyid = $this->session->userdata('mr_cmpyid');
		$sadmin = $this->session->userdata('mr_sadmin');
		$admin = $this->session->userdata('mr_admin');

		if ($iscmpy == "1" && !empty($cmpyid) && $cmpyid !== "" && $cmpyid !== null) {
			$wherearray = array('by_user_id' => $cmpyid);
			$mwherearray = array('id' => $cmpyid);
		} else {
			$wherearray = array('by_user_id' => $user_id, 'by_form_key' => $form_key);
			$mwherearray = array('id' => $user_id, 'form_key' => $form_key);
		}

		$this->db->where($wherearray);
		$query = $this->db->get('quota')->row();

		if ($query) {
			if ($query->bal == '0'  || $query->bal < '0' || $query->bought === $query->used) {
				$this->db->where($mwherearray);
				$mquery = $this->db->get('users')->row();
				if ($mquery) {
					$mailid = $mquery->email;
					return $mailid;
					exit;
				}
			} else {
				return false;
				exit;
			}
		} else {
			return "not_Found";
			exit;
		}
	}

	public function update_usersub($form_key)
	{
		$this->db->set('sub', '0');
		$this->db->where('form_key', $form_key);
		$this->db->update('users');
		$this->session->set_userdata('mr_sub', '0');
		return true;
	}

	public function email_saveinfo()
	{
		$data = array(
			'sent_to_email' => htmlentities($this->input->post('email')),
			'subj' => htmlentities($this->input->post('subj')),
			'body' => htmlentities($this->input->post('bdy')),
			'user_id' => $this->session->userdata('mr_id'),
		);
		$this->db->insert('sent_links', $data);
		$length = '1';
		$this->userdetails_emailupdate($length);
		$this->userquotaupdate($length);
		return true;
	}

	public function multiplemail_saveinfo($emaildata, $subj, $bdy)
	{
		$data = array(
			'sent_to_email' => htmlentities(implode(",", $emaildata)),
			'subj' => htmlentities($subj),
			'body' => htmlentities($bdy),
			'user_id' => $this->session->userdata('mr_id'),
		);
		$this->db->insert('sent_links', $data);
		$length = count($emaildata);
		$this->userdetails_emailupdate($length);
		$this->userquotaupdate($length);
		return true;
	}

	public function sms_saveinfo()
	{
		$data = array(
			'sent_to_sms' => htmlentities($this->input->post('mobile')),
			'body' => htmlentities($this->input->post('smsbdy')),
			'user_id' => $this->session->userdata('mr_id'),
		);
		$this->db->insert('sent_links', $data);
		$length = '1';
		$this->userdetails_smsupdate($length);
		$this->userquotaupdate($length);
		return true;
	}

	public function multiplsms_saveinfo($mobiledata, $smsbdy)
	{
		$data = array(
			'sent_to_sms' => htmlentities(implode(",", $mobiledata)),
			'body' => htmlentities($smsbdy),
			'user_id' => $this->session->userdata('mr_id'),
		);
		$length = count($mobiledata);
		$this->db->insert('sent_links', $data);
		$this->userdetails_smsupdate($length);
		$this->userquotaupdate($length);
		return true;
	}

	public function userquotaupdate($length)
	{
		$user_id = $this->session->userdata("mr_id");
		$form_key = $this->session->userdata('mr_form_key');
		$iscmpy = $this->session->userdata('mr_iscmpy');
		$cmpyid = $this->session->userdata('mr_cmpyid');

		if ($iscmpy == "1" && !empty($cmpyid) && $cmpyid !== "" && $cmpyid !== null) {
			$wherearray = array('by_user_id' => $cmpyid);
		} else {
			$wherearray = array('by_form_key' => $form_key, 'by_user_id' => $user_id);
		}

		$this->db->set('used', 'used+' . $length, FALSE);
		$this->db->set('bal', 'bal-' . $length, FALSE);
		$this->db->where($wherearray);
		$this->db->update('quota');
		return true;
		exit;
	}

	public function userdetails_emailupdate($length)
	{
		$this->db->set('total_email', 'total_email+' . $length, FALSE);
		$this->db->where('form_key', $this->session->userdata('mr_form_key'));
		$this->db->update('user_details');
		return true;
	}

	public function userdetails_smsupdate($length)
	{
		$this->db->set('total_sms', 'total_sms+' . $length, FALSE);
		$this->db->where('form_key', $this->session->userdata('mr_form_key'));
		$this->db->update('user_details');
		return true;
	}
}
