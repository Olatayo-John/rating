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
		if ($user->active == "1" && $user->cmpyid == null) {
			if (password_verify($pwd, $user->password)) {
				$this->db->select('u.id,u.sadmin,u.admin,u.iscmpy,u.cmpyid,u.cmpy,u.uname,u.email,u.mobile,u.active,u.sub,u.website_form,u.form_key,q.bought,q.webspace,q.webspace_left,q.userspace,q.userspace_left');
				$this->db->from('users u');
				$this->db->where('u.uname', $uname);
				$this->db->join('quota q', 'u.id=q.by_user_id', 'inner');
				$userinfo = $this->db->get()->row();
				return $userinfo;
				exit();
			} else {
				return false;
				exit();
			}
		} elseif ($user->active == "1" && $user->iscmpy == "1" && !empty($user->cmpyid)) {
			if (password_verify($pwd, $user->password)) {
				$this->db->select('u.id,u.sadmin,u.admin,u.iscmpy,u.cmpyid,u.cmpy,u.uname,u.email,u.mobile,u.active,u.sub,u.website_form,u.form_key,q.bought,q.webspace,q.webspace_left,q.userspace,q.userspace_left');
				$this->db->from('users u');
				$this->db->where('u.uname', $uname);
				$this->db->join('quota q', 'u.cmpyid=q.by_user_id', 'inner');
				$userinfo = $this->db->get()->row();
				return $userinfo;
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

	public function register($admin, $iscmpy, $userspace, $act_key, $form_key)
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
		$this->insert_quota($lastid, $userspace, $form_key);
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

	public function insert_quota($lastid, $userspace, $form_key)
	{
		$data = array(
			'by_user_id' => $lastid,
			'bought' => htmlentities($this->input->post('quota')),
			'used' => '0',
			'bal' => htmlentities($this->input->post('quota')),
			'webspace' => htmlentities($this->input->post('webspace')),
			'userspace' => $userspace,
			'by_form_key' => $form_key,
		);
		$this->db->insert('quota', $data);
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

			$this->db->select('u.id,u.sadmin,u.admin,u.iscmpy,u.cmpyid,u.cmpy,u.uname,u.email,u.mobile,u.active,u.sub,u.website_form,u.form_key,q.bought,q.webspace,q.userspace');
			$this->db->from('users u');
			$this->db->where('u.form_key', $key);
			$this->db->join('quota q', 'u.id=q.by_user_id', 'inner');
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
		$this->db->order_by('total_ratings', 'desc');
		$query = $this->db->get_where('websites', array('user_id' => $this->session->userdata('mr_id'), 'form_key' => $this->session->userdata('mr_form_key')));
		if (!$query) {
			return false;
			exit();
		} else {
			return $query;
		}
	}

	public function addwebsites($webname_arr, $weblink_arr)
	{
		$web_count = count($webname_arr);

		if ($this->get_webspacequota($web_count) === false) return false;

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
		$this->update_webquota($web_count);
		return TRUE;
	}

	public function get_webspacequota($web_count)
	{
		$user_id = $this->session->userdata("mr_id");
		$form_key = $this->session->userdata("mr_form_key");
		$iscmpy = $this->session->userdata("mr_iscmpy");
		$cmpyid = $this->session->userdata("mr_cmpyid");
		$webspace = $this->session->userdata("mr_webspace");

		if ($iscmpy == "1" && !empty($cmpyid) && $cmpyid !== "" && $cmpyid !== null) {
			$wherearray = array('by_user_id' => $cmpyid);
		} else {
			$wherearray = array('by_user_id' => $user_id, 'by_form_key' => $form_key);
		}
		$this->db->where($wherearray);
		$webinfo = $this->db->get("quota")->row();

		if ($webinfo->webspace_left > 0 && $webinfo->webspace_left >= $web_count) {
			return true;
			exit;
		} else {
			$this->session->set_userdata("mr_webspace_left", $webinfo->webspace_left);
			return false;
			exit;
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

	public function update_webquota($web_count)
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
		$this->db->set('webspace_left', 'webspace_left-' . $web_count, FALSE);
		$this->db->where($wherearray);
		$this->db->update("quota");

		$webspaceupdate = $this->session->userdata("mr_webspace_left") - $web_count;

		$this->session->set_userdata("mr_webspace_left", $webspaceupdate);
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

	public function user_totalquota()
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

	public function user_alltotalratings()
	{
		$query = $this->db->get_where('user_details', array('form_key' => $this->session->userdata('mr_form_key')))->row();
		if (!$query) {
			return false;
			exit;
		} else {
			return $query;
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

	//not been used rn
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

	public function user_new_website($web_name_new, $web_link_new)
	{
		$web_count = 1;
		if ($this->get_webspacequota($web_count) === false) {
			return "Quota reached.";
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
					$this->update_webquota($web_count);

					$data = array(
						'user_id' => $this->session->userdata('mr_id'),
						'form_key' => $this->session->userdata('mr_form_key'),
						'web_name' => htmlentities($_POST['web_name_new']),
						'web_link' => htmlentities($_POST['web_link_new']),
						'active' => $this->session->userdata('mr_active'),
						'total_ratings' => "0",
						'five_star' => "0",
						'four_star' => "0",
						'three_star' => "0",
						'two_star' => "0",
						'one_star' => "0",
					);
					$this->db->insert('websites', $data);
					return $this->db->insert_id();
				}
			}
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

	public function delete_website($id)
	{
		$user_id = $this->session->userdata("mr_id");
		$form_key = $this->session->userdata("mr_form_key");

		$this->db->where(array('id' => $id, 'user_id' => $user_id, 'form_key' => $form_key));
		$this->db->delete('websites');
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

	public function website_status($id, $status)
	{
		$user_id = $this->session->userdata("mr_id");
		$form_key = $this->session->userdata("mr_form_key");

		$this->db->where(array('id' => $id, 'user_id' => $user_id, 'form_key' => $form_key));
		$this->db->set('active', $status);
		$this->db->update('websites');
		return TRUE;
	}


	//func not added in user controller- edit_website or something
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
		$this->db->set('active', '0');
		$this->db->where('id', $this->session->userdata('mr_id'));
		$this->db->update('users');
		$this->session->set_userdata('mr_active', '0');
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

	public function userdetails()
	{
		$this->db->where(array('user_id' => $this->session->userdata("mr_id"), 'form_key' => $this->session->userdata("mr_form_key")));
		$query = $this->db->get('user_details')->row();
		return $query;
	}

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

	public function get_userquota()
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

		$query = $this->db->get_where('quota', $wherearray)->row();
		if ($query) {
			return $query;
			exit;
		} else {
			return false;
			exit;
		}
	}
}
