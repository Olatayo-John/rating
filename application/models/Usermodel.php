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
		//verify passwords
		if (password_verify($pwd, $user->password)) {

			//companyAdmin and companyUsers
			if ($user->iscmpy == '1') {
				$this->db->select('u.id,u.sadmin,u.admin,u.iscmpy,u.cmpyid,u.cmpy,u.uname,u.email,u.mobile,u.active,u.sub,u.website_form,u.form_key,u.frame_id,cd.cmpyLogo')->from('users u');

				if ($user->admin == '1') {
					$this->db->join('company_details cd', 'cd.userid = u.id');
				} elseif ($user->admin == '0') {
					$this->db->join('company_details cd', 'cd.userid = u.cmpyid');
				}

				$this->db->where('u.uname', $uname);
				$userinfo = $this->db->get()->row();
			} else {
				$this->db->select('u.id,u.sadmin,u.admin,u.iscmpy,u.cmpyid,u.cmpy,u.uname,u.email,u.mobile,u.active,u.sub,u.website_form,u.form_key,u.frame_id')->from('users u');
				$this->db->where('u.uname', $uname);
				$userinfo = $this->db->get()->row();
			}

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

	public function get_plans()
	{
		$this->db->order_by('orderBy', 'asc');
		$query = $this->db->get('plans');
		if (!$query) {
			return false;
			exit();
		} else {
			return $query;
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
			'sub' => (htmlentities($this->input->post('plan_id')) === '1') ? '1' : '0',
			'form_key' => $form_key,
			'act_key' => password_hash($act_key, PASSWORD_DEFAULT),
			'password' => password_hash($this->input->post('pwd'), PASSWORD_DEFAULT),
		);
		$this->db->insert('users', $data);
		$lastid = $this->db->insert_id();

		$this->insert_quota($lastid, $form_key);

		if (($iscmpy === 1) && ($admin === 1)) {
			$this->insert_company_details($lastid, $form_key);
		}
		return TRUE;
	}

	public function insert_quota($lastid, $form_key)
	{
		$data = array(
			'by_user_id' => $lastid,
			'sms_quota' => htmlentities($this->input->post('sms_quota')),
			'email_quota' => htmlentities($this->input->post('email_quota')),
			'whatsapp_quota' => htmlentities($this->input->post('whatsapp_quota')),
			'web_quota' => htmlentities($this->input->post('web_quota')),
			'by_form_key' => $form_key,
			'plan_id' => htmlentities($this->input->post('plan_id')),
			'amount' => htmlentities($this->input->post('amount')),
			'balance' => htmlentities($this->input->post('amount')),
		);
		$this->db->insert('quota', $data);
		return true;
	}

	public function insert_company_details($lastid)
	{
		$data = array(
			'userid' => $lastid,
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
		$this->db->select('active,email,form_key,uname');
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

	public function get_companyInfo()
	{
		$query = $this->db->get_where('company_details', array('userid' => $this->session->userdata('mr_id')));
		if (!$query) {
			return false;
			exit();
		} else {
			return $query->row();
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

	public function chartPlatforms()
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

	public function chartRatings()
	{
		$this->db->order_by('id', 'desc');
		$q = $this->db->get_where('websites', array('user_id' => $this->session->userdata('mr_id'), 'form_key' => $this->session->userdata('mr_form_key')));
		if (!$q) {
			return false;
			exit();
		} else {
			$resArr = array();
			$starArr = array();
			foreach ($q->result_array() as $p) {
				for ($i = 1; $i <= 5; $i++) {
					$qq = $this->db->get_where('all_ratings', array('web_name' => $p['web_name'], 'web_link' =>  $p['web_link'], 'form_key' =>  $p['form_key'], 'star' =>  $i))->num_rows();

					array_push($starArr, $qq);
				}

				array_push($resArr, array('web_name' => $p['web_name'], 'starArr' => $starArr));
				$starArr = array();
			}

			// foreach ($resArr as $w) {
			// 	print_r($w);
			// 	echo '<br><br>';
			// }
			// exit;

			return $resArr;
		}
	}

	public function chartMonthly($year)
	{
		$monthArr = array('Jan', 'Feb', 'Mar', 'April', 'May', 'June', 'July', 'August', 'Sep', 'Oct', 'Nov', 'Dec');
		$monthIndexArr = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
		$resArr = array();

		foreach ($monthArr as $key => $p) {
			// $date = $year . '-' . ($monthIndexArr[$key]) . '-'; //monthly regarding current year
			$date = '-' . ($monthIndexArr[$key]) . '-'; //monthly regardless of year

			$this->db->like('rated_at', $date);
			$this->db->where('form_key', $this->session->userdata('mr_form_key'));
			$qq = $this->db->get('all_ratings')->num_rows();

			array_push($resArr, array('month' => $p, 'monthInd' => ($monthIndexArr[$key]), 'rating' => $qq));
		}

		// foreach ($resArr as $w) {
		// 	print_r($w);
		// 	echo '<br><br>';
		// }
		// exit;
		return $resArr;
	}

	public function clearPrevFrame($id, $form_key)
	{
		$this->db->set("frame_id", '', TRUE);
		// $this->db->set("icon", '', TRUE);

		$this->db->where(array('user_id' => $id, 'form_key' => $form_key));
		$this->db->update("websites");
		return true;
	}

	public function updateFrameid($id, $form_key, $frame_id)
	{
		$this->db->set("frame_id", $frame_id, TRUE);

		$this->db->where(array('id' => $id, 'form_key' => $form_key));
		$this->db->update("users");
		return true;
	}

	public function generateFrame($id, $form_key, $pid, $frame_id)
	{
		$this->db->set("frame_id", $frame_id, TRUE);
		$this->db->where(array('id' => $pid, 'user_id' => $id, 'form_key' => $form_key));
		$this->db->update('websites');

		return true;
	}

	//disabled
	public function createFrame($id, $form_key, $pid, $sdata)
	{
		$this->db->where(array('id' => $pid, 'user_id' => $id, 'form_key' => $form_key));
		$this->db->update('websites', $sdata);
		return true;
	}
	//

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
			'gender' => htmlentities($this->input->post('gender')),
			'dob' => htmlentities($this->input->post('dob')),
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

	public function createwebsite($web_name_new, $web_link_new, $subject = null, $description = null, $icon = null, $platLogo = null)
	{
		$web_count = 1;
		if ($this->get_webspacequota($web_count) === false) {
			return "Web Quota exceeded";
			exit;
		} else {
			$dupname = $this->check_duplicate_webname($web_name_new);
			if ($dupname > 0) {
				return "You have an existing platform with the name [" . $web_name_new . "]";
				exit;
			} else {
				$duplink = $this->check_duplicate_weblink($web_link_new);
				if ($duplink > 0) {
					return "You have an existing platform with the link [" . $web_link_new . "]";
					exit;
				} else {
					$this->update_webquota($type = "web_quota-1");

					$data = array(
						'user_id' => $this->session->userdata('mr_id'),
						'form_key' => $this->session->userdata('mr_form_key'),
						'web_name' => htmlentities($web_name_new),
						'web_link' => htmlentities($web_link_new),
						'subject' => htmlentities($subject),
						'description' => htmlentities($description),
						'icon' => htmlentities($icon),
						'logo' => htmlentities($platLogo),
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

	public function website_update($id, $webstatus, $subject, $description, $icon, $platLogo)
	{
		$data = array(
			'active' => $webstatus,
			'subject' => htmlentities($subject),
			'description' => htmlentities($description),
			'icon' => htmlentities($icon),
			'logo' => htmlentities($platLogo),
		);

		$id = $id;
		$user_id = $this->session->userdata("mr_id");
		$form_key = $this->session->userdata("mr_form_key");

		$this->db->where(array('id' => $id, 'user_id' => $user_id, 'form_key' => $form_key));
		$this->db->update('websites', $data);
		return TRUE;
	}

	public function company_edit($data)
	{

		$this->db->where('userid', $this->session->userdata('mr_id'));
		$this->db->update('company_details', $data);

		$cmpyName = $data['cmpyName'];
		$this->update_company_users($cmpyName);
		return TRUE;
	}

	public function update_company_users($cmpyName)
	{
		$data = array(
			'cmpy' => $cmpyName
		);

		$this->db->where('id', $this->session->userdata('mr_id'));
		$this->db->or_where('cmpyid', $this->session->userdata('mr_id'));
		$this->db->update('users', $data);
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

	public function total_email()
	{
		$this->db->where(array('user_id' => $this->session->userdata("mr_id"), 'link_for' => 'email'));
		$query = $this->db->get('sent_links');
		return $query;
	}
	public function total_sms()
	{
		$this->db->where(array('user_id' => $this->session->userdata("mr_id"), 'link_for' => 'sms'));
		$query = $this->db->get('sent_links');
		return $query;
	}
	public function total_wapp()
	{
		$this->db->where(array('user_id' => $this->session->userdata("mr_id"), 'link_for' => 'whatsapp'));
		$query = $this->db->get('sent_links');
		return $query;
	}

	public function get_cmpyUsers_type($type)
	{
		$this->db->select($type);
		$this->db->where(array('cmpyid' => $this->session->userdata("mr_id")));
		$q = $this->db->get('users');
		return $q;
	}

	public function allrr()
	{
		if ($this->session->userdata('mr_admin') === '1') {
			$cmpy_users_fk = $this->get_cmpyUsers_type($type = 'form_key');

			$ufkArr = array($this->session->userdata('mr_form_key'));
			foreach ($cmpy_users_fk->result_array() as $ufk) {
				array_push($ufkArr, $ufk['form_key']);
			}
		}

		$this->db->select('ar.*,u.uname')->from('all_ratings ar');
		$this->db->join('users u', 'u.form_key = ar.form_key');

		if ($this->session->userdata('mr_sadmin') === '1') {
			$this->db->where('ar.form_key >', '0');
		}

		if ($this->session->userdata('mr_admin') === '1') {

			if (!empty($uidArr)) {
				$this->db->where_in('ar.form_key', $ufkArr);
			}
		}

		$query = $this->db->get();
		if (!$query) {
			return false;
			exit();
		} else {
			return $query;
		}
	}
	public function allsentlinks()
	{
		if ($this->session->userdata('mr_admin') === '1') {
			$cmpy_users_id = $this->get_cmpyUsers_type($type = 'id');

			$uidArr = array($this->session->userdata('mr_id'));
			foreach ($cmpy_users_id->result_array() as $uid) {
				array_push($uidArr, $uid['id']);
			}
		}

		$this->db->select('sl.*,u.uname')->from('sent_links sl');
		$this->db->join('users u', 'u.id = sl.user_id');

		if ($this->session->userdata('mr_sadmin') === '1') {
			$this->db->where('sl.user_id >', '0');
		}

		if ($this->session->userdata('mr_admin') === '1') {

			if (!empty($uidArr)) {
				$this->db->where_in('sl.user_id', $uidArr);
			}
		}

		$query = $this->db->get();
		if (!$query) {
			return false;
			exit();
		} else {
			return $query;
		}
	}
	public function allwebsites()
	{
		if ($this->session->userdata('mr_admin') === '1') {
			$cmpy_users_id = $this->get_cmpyUsers_type($type = 'id');

			$uidArr = array($this->session->userdata('mr_id'));
			foreach ($cmpy_users_id->result_array() as $uid) {
				array_push($uidArr, $uid['id']);
			}
		}

		// $this->db->order_by('id', 'desc');
		$this->db->select('w.*,u.uname')->from('websites w');
		$this->db->join('users u', 'u.id = w.user_id');

		if ($this->session->userdata('mr_sadmin') === '1') {
			$this->db->where('w.user_id >', '0');
		}

		if ($this->session->userdata('mr_admin') === '1') {

			if (!empty($uidArr)) {
				$this->db->where_in('w.user_id', $uidArr);
			}
		}

		$query = $this->db->get();
		if (!$query) {
			return false;
			exit();
		} else {
			return $query;
		}
	}

	public function allemail()
	{
		if ($this->session->userdata('mr_admin') === '1') {
			$cmpy_users_id = $this->get_cmpyUsers_type($type = 'id');

			$uidArr = array($this->session->userdata('mr_id'));
			foreach ($cmpy_users_id->result_array() as $uid) {
				array_push($uidArr, $uid['id']);
			}
		}

		$this->db->select('sl.*,u.uname')->from('sent_links sl');
		$this->db->join('users u', 'u.id = sl.user_id');

		if ($this->session->userdata('mr_sadmin') === '1') {
			$this->db->where(array('sl.user_id >' => '0', 'sl.link_for' => 'email'));
		}

		if ($this->session->userdata('mr_admin') === '1') {

			if (!empty($uidArr)) {
				$this->db->where_in('sl.user_id', $uidArr);
				$this->db->where(array('sl.link_for' => 'email'));
			}
		}

		$query = $this->db->get();
		if (!$query) {
			return false;
			exit();
		} else {
			return $query;
		}
	}
	public function allsms()
	{
		if ($this->session->userdata('mr_admin') === '1') {
			$cmpy_users_id = $this->get_cmpyUsers_type($type = 'id');

			$uidArr = array($this->session->userdata('mr_id'));
			foreach ($cmpy_users_id->result_array() as $uid) {
				array_push($uidArr, $uid['id']);
			}
		}

		$this->db->select('sl.*,u.uname')->from('sent_links sl');
		$this->db->join('users u', 'u.id = sl.user_id');

		if ($this->session->userdata('mr_sadmin') === '1') {
			$this->db->where(array('sl.user_id >' => '0', 'sl.link_for' => 'sms'));
		}

		if ($this->session->userdata('mr_admin') === '1') {

			if (!empty($uidArr)) {
				$this->db->where_in('sl.user_id', $uidArr);
				$this->db->where(array('sl.link_for' => 'sms'));
			}
		}

		$query = $this->db->get();
		if (!$query) {
			return false;
			exit();
		} else {
			return $query;
		}
	}
	public function allwapp()
	{
		if ($this->session->userdata('mr_admin') === '1') {
			$cmpy_users_id = $this->get_cmpyUsers_type($type = 'id');

			$uidArr = array($this->session->userdata('mr_id'));
			foreach ($cmpy_users_id->result_array() as $uid) {
				array_push($uidArr, $uid['id']);
			}
		}

		$this->db->select('sl.*,u.uname')->from('sent_links sl');
		$this->db->join('users u', 'u.id = sl.user_id');

		if ($this->session->userdata('mr_sadmin') === '1') {
			$this->db->where(array('sl.user_id >' => '0', 'sl.link_for' => 'whatsapp'));
		}

		if ($this->session->userdata('mr_admin') === '1') {

			if (!empty($uidArr)) {
				$this->db->where_in('sl.user_id', $uidArr);
				$this->db->where(array('sl.link_for' => 'whatsapp'));
			}
		}

		$query = $this->db->get();
		if (!$query) {
			return false;
			exit();
		} else {
			return $query;
		}
	}

	public function is_userquotaexpired($qType)
	{
		$user_id = $this->session->userdata("mr_id");
		$form_key = $this->session->userdata('mr_form_key');
		$iscmpy = $this->session->userdata('mr_iscmpy');
		$cmpyid = $this->session->userdata('mr_cmpyid');

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
			if ($query->balance > '0'  || $query->balance !== '0') {
				return "pending_balance";
				exit;
			}
			if ($query->$qType == '0'  || $query->$qType < '0') {
				$this->db->where($mwherearray);
				$mquery = $this->db->get('users')->row();
				if ($mquery) {
					$mailid = $mquery->email;
					return $mailid; //companyAdmin email or user Email
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

	public function email_saveinfo()
	{
		$data = array(
			'link_for' => 'email',
			'sent_to_sms' => '',
			'sent_to_email' => htmlentities($this->input->post('email')),
			'subj' => htmlentities($this->input->post('subj')),
			'body' => htmlentities($this->input->post('emailbdy')),
			'user_id' => $this->session->userdata('mr_id'),
		);
		$this->db->insert('sent_links', $data);

		$length = 'email_quota-1';
		$q = 'email_quota';

		$this->userquotaupdate($length, $q);
		return true;
	}

	public function multiplemail_saveinfo($mail, $subj, $bdy)
	{
		$data = array(
			'link_for' => 'email',
			'sent_to_sms' => '',
			'sent_to_email' => htmlentities($mail),
			'subj' => htmlentities($subj),
			'body' => htmlentities($bdy),
			'user_id' => $this->session->userdata('mr_id'),
		);
		$this->db->insert('sent_links', $data);

		$length = 'email_quota-1';
		$q = 'email_quota';

		$this->userquotaupdate($length, $q);
		return true;
	}

	public function sms_saveinfo()
	{
		$data = array(
			'link_for' => 'sms',
			'sent_to_sms' => htmlentities($this->input->post('mobile')),
			'sent_to_email' => '',
			'subj' => '',
			'body' => htmlentities($this->input->post('smsbdy')),
			'user_id' => $this->session->userdata('mr_id'),
		);
		$this->db->insert('sent_links', $data);

		$length = 'sms_quota-1';
		$q = 'sms_quota';

		$this->userquotaupdate($length, $q);
		return true;
	}

	public function multiplsms_saveinfo($mobile, $smsbdy)
	{
		$data = array(
			'link_for' => 'sms',
			'sent_to_sms' => $mobile,
			'sent_to_email' => '',
			'subj' => '',
			'body' => htmlentities($smsbdy),
			'user_id' => $this->session->userdata('mr_id'),
		);
		$this->db->insert('sent_links', $data);

		$length = 'sms_quota-1';
		$q = 'sms_quota';
		$this->userquotaupdate($length, $q);
		return true;
	}

	public function whatsapp_saveinfo($mobile, $whpbdy)
	{
		$data = array(
			'link_for' => 'whatsapp',
			'sent_to_sms' => $mobile,
			'sent_to_email' => '',
			'subj' => '',
			'body' => htmlentities($whpbdy),
			'user_id' => $this->session->userdata('mr_id'),
		);
		$this->db->insert('sent_links', $data);

		$length = 'whatsapp_quota-1';
		$q = 'whatsapp_quota';

		$this->userquotaupdate($length, $q);
		return true;
	}

	public function userquotaupdate($length, $q)
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

		$this->db->set($q, $length, FALSE);
		$this->db->where($wherearray);
		$this->db->update('quota');
		return true;
		exit;
	}
}
