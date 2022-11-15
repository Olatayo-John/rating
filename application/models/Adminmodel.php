<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Adminmodel extends CI_Model
{
	public function get_allusers()
	{
		$this->db->where('sadmin', '0');
		$userinfo = $this->db->get('users');
		return $userinfo;
	}

	public function get_adminusers()
	{
		$cmpyid = $this->session->userdata("mr_id");
		$cmpy = $this->session->userdata("mr_cmpy");

		$this->db->where(array('cmpyid' => $cmpyid, 'iscmpy' => '1', 'cmpy' => $cmpy));
		$userinfo = $this->db->get('users');
		return $userinfo;
	}

	public function adminadduser($act_key, $form_key)
	{
		$data = array(
			'sadmin' => '0',
			'admin' => '0',
			'iscmpy' => '1',
			'cmpy' => $this->session->userdata("mr_cmpy"),
			'cmpyid' => $this->session->userdata("mr_id"),
			'uname' => htmlentities($this->input->post('uname')),
			'fname' => htmlentities($this->input->post('fname')),
			'lname' => htmlentities($this->input->post('lname')),
			'email' => htmlentities($this->input->post('email')),
			'mobile' => htmlentities($this->input->post('mobile')),
			'active' => "0",
			'website_form' => "0",
			'sub' => '1',
			'form_key' => $form_key,
			'act_key' => password_hash($act_key, PASSWORD_DEFAULT),
			'password' => password_hash($this->input->post('pwd'), PASSWORD_DEFAULT),
		);
		$this->db->insert('users', $data);
		$lastid = $this->db->insert_id();

		$this->admin_insert_quota($lastid, $form_key);
		return TRUE;
	}

	public function admin_insert_quota($lastid, $form_key)
	{
		$data = array(
			'by_user_id' => $lastid,
			'sms_quota' => '0',
			'email_quota' => '0',
			'whatsapp_quota' => '0',
			'web_quota' => '0',
			'by_form_key' => $form_key,
		);
		$this->db->insert('quota', $data);
		return true;
	}

	public function sadminadduser($act_key, $form_key, $admin, $iscmpy)
	{
		$data = array(
			'sadmin' => '0',
			'admin' => $admin,
			'iscmpy' => $iscmpy,
			'cmpy' => htmlentities($this->input->post('cmpy')),
			'cmpyid' => null,
			'uname' => htmlentities($this->input->post('uname')),
			'fname' => htmlentities($this->input->post('fname')),
			'lname' => htmlentities($this->input->post('lname')),
			'email' => htmlentities($this->input->post('email')),
			'mobile' => htmlentities($this->input->post('mobile')),
			'active' => "0",
			'website_form' => "0",
			'sub' => '1',
			'form_key' => $form_key,
			'act_key' => password_hash($act_key, PASSWORD_DEFAULT),
			'password' => password_hash($this->input->post('pwd'), PASSWORD_DEFAULT),
		);
		print_r($data);
		die;
		$this->db->insert('users', $data);
		$lastid = $this->db->insert_id();

		$this->sadmin_insert_quota($lastid, $form_key);

		if (($iscmpy === 1) && ($admin === 1)) {
			$this->insert_company_details($lastid, $form_key);
		}

		return TRUE;
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

	public function sadmin_insert_quota($lastid, $form_key)
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

	public function get_userinfo($id, $form_key)
	{
		$this->db->where(array('id' => $id, 'form_key' => $form_key));
		$query = $this->db->get('users');
		return $query->row();
	}

	public function admin_get_userQuota($id, $form_key, $iscmpy, $cmpyid)
	{
		if ($iscmpy == "1" && !empty($cmpyid) && $cmpyid !== "" && $cmpyid !== null) {
			$wherearray = array('by_user_id' => $cmpyid);
		} else {
			// $wherearray = array('by_user_id' => $id, 'by_form_key' => $form_key);
		}
		$this->db->where($wherearray);
		$quotaInfo = $this->db->get("quota")->row();
		return $quotaInfo;
	}

	public function get_userwebsites($id, $form_key)
	{
		$this->db->order_by('web_name', 'asc');
		$this->db->where(array('user_id' => $id, 'form_key' => $form_key));
		$query = $this->db->get('websites');
		return $query->result();
	}

	public function get_userratings($form_key)
	{
		$this->db->order_by('id', 'desc');
		$this->db->where('form_key', $form_key);
		$query = $this->db->get('all_ratings');
		return $query->result();
	}

	public function get_userlinks($user_id)
	{
		$this->db->order_by('id', 'desc');
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('sent_links');
		return $query->result();
	}

	public function get_usertotalemail($user_id)
	{
		$this->db->where(array('user_id' => $user_id, 'link_for' => 'email'));
		$query = $this->db->get('sent_links');
		return $query->result_array();
	}
	public function get_usertotalsms($user_id)
	{
		$this->db->where(array('user_id' => $user_id, 'link_for' => 'sms'));
		$query = $this->db->get('sent_links');
		return $query->result_array();
	}
	public function get_usertotalwhp($user_id)
	{
		$this->db->where(array('user_id' => $user_id, 'link_for' => 'whatsapp'));
		$query = $this->db->get('sent_links');
		return $query->result_array();
	}

	public function updateprofile_admin($user_id, $form_key, $fname, $lname, $email, $mobile,$gender,$dob)
	{
		$data = array(
			'fname' => htmlentities($fname),
			'lname' => htmlentities($lname),
			'email' => htmlentities($email),
			'mobile' => htmlentities($mobile),
			'gender' => htmlentities($gender),
			'dob' => htmlentities($dob),
		);

		$this->db->where(array('id' => $user_id, 'form_key' => $form_key));
		$this->db->update("users", $data);

		return true;
	}

	public function deactivateaccount_admin($user_id, $form_key)
	{
		$this->db->where(array('id' => $user_id, 'form_key' => $form_key));
		$query = $this->db->set('active', "2");
		$query = $this->db->update("users");
		return true;
	}

	public function activateaccount_admin($user_id, $form_key)
	{
		$this->db->where(array('id' => $user_id, 'form_key' => $form_key));
		$query = $this->db->set('active', "1");
		$query = $this->db->update("users");
		return true;
	}

	public function deactivatesub_admin($user_id, $form_key)
	{
		$this->db->where(array('id' => $user_id, 'form_key' => $form_key));
		$query = $this->db->set('sub', "0");
		$query = $this->db->update("users");
		return true;
	}

	public function activatesub_admin($user_id, $form_key)
	{
		$this->db->where(array('id' => $user_id, 'form_key' => $form_key));
		$this->db->set('sub', "1");
		$query = $this->db->update("users");
		return true;
	}

	public function updatepassword_admin($user_id, $rspwd)
	{
		$this->db->set('password', password_hash($rspwd, PASSWORD_DEFAULT));
		$this->db->where('id', $user_id);
		$this->db->update("users");
		return true;
	}

	//disabled
	public function admin_deleteuser($user_id, $form_key)
	{
		$this->db->where(array('id' => $user_id, 'form_key' => $form_key));
		$this->db->delete('users');

		$this->delete_user_ratings($form_key);
		$this->delete_user_quota($user_id, $form_key);
		$this->delete_user_sentlinks($user_id);
		$this->delete_user_websites($user_id, $form_key);

		return true;
	}
	public function delete_user_ratings($form_key)
	{
		$this->db->where('form_key', $form_key);
		$this->db->delete('all_ratings');
		return true;
	}
	public function delete_user_quota($user_id, $form_key)
	{
		$this->db->where(array('by_user_id' => $user_id, 'by_form_key' => $form_key));
		$this->db->delete('quota');
		return true;
	}
	public function delete_user_sentlinks($user_id)
	{
		$this->db->where('user_id', $user_id);
		$this->db->delete('sent_links');
		return true;
	}
	public function delete_user_websites($user_id, $form_key)
	{
		$this->db->where(array('user_id' => $user_id, 'form_key' => $form_key));
		$this->db->delete('websites');
		return true;
	}
	//

	public function get_ratings($key)
	{
		$this->db->order_by('web_name', 'desc');
		$this->db->where('form_key', $key);
		$query = $this->db->get('all_ratings');
		return $query->result_array();
	}

	public function getuserwebsites($key)
	{
		$this->db->order_by("web_name", "ASC");
		$query = $this->db->get_where('websites', array('form_key' => $key));
		if (!$query) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	public function getuserotherwebsites($key)
	{
		$this->db->order_by("web_name", "ASC");
		$query = $this->db->get_where('websites', array('form_key' => $key));
		if (!$query) {
			return false;
		} else {
			return $query->result_array();
		}
	}

	public function getuserwebsites_wtr($key)
	{
		$this->db->order_by("web_name", "ASC");
		$query = $this->db->get_where('websites', array('form_key' => $key));
		if (!$query) {
			return false;
		} else {
			return $query;
		}
	}

	public function is_user_active($key)
	{
		$query = $this->db->get_where('users', array('form_key' => $key))->row();
		if (!$query) {
			return false;
		} else {
			// print_r($query);
			// die;
			return $query;
		}
	}


	public function save_payment($userData)
	{
		print_r($userData);
		die;
		$this->db->insert('payment', $userData);
		// $quota_amount = round($userData['paid_amt']);
		// $this->save_plan($quota_amount);
		// $this->update_user_sub();
		// $this->session->set_userdata('mr_sub', '1');
		return true;
	}

	public function save_plan($quota_amount)
	{
		$this->db->set('bought', 'bought+' . $quota_amount, FALSE);
		$this->db->set('bal', 'bal+' . $quota_amount, FALSE);
		$this->db->where('by_form_key', $this->session->userdata('mr_form_key'));
		$this->db->update("quota");
		return true;
	}

	public function update_user_sub()
	{
		$this->db->set('sub', '1', FALSE);
		$this->db->set('sub_active', '0', FALSE);
		$this->db->where('form_key', $this->session->userdata('mr_form_key'));
		$this->db->update("users");
		return true;
	}

	public function getsadmin()
	{
		$query = $this->db->get_where('users', array('s_admin' => '1'));
		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->row();
		}
	}

	public function getuserbykey($form_key)
	{
		$query = $this->db->get_where('users', array('form_key' => $form_key));
		if ($query->num_rows() <= 0) {
			return false;
		} else {
			return $query->row();
		}
	}

	public function all_total_ratings()
	{
		$query = $this->db->get_where('all_ratings');
		return $query->num_rows();
	}
	public function tr5_total_ratings()
	{
		$query = $this->db->get_where('all_ratings', array("star" => "5"));
		return $query->num_rows();
	}
	public function tr4_total_ratings()
	{
		$query = $this->db->get_where('all_ratings', array("star" => "4"));
		return $query->num_rows();
	}
	public function tr3_total_ratings()
	{
		$query = $this->db->get_where('all_ratings', array("star" => "3"));
		return $query->num_rows();
	}
	public function tr2_total_ratings()
	{
		$query = $this->db->get_where('all_ratings', array("star" => "2"));
		return $query->num_rows();
	}
	public function tr1_total_ratings()
	{
		$query = $this->db->get_where('all_ratings', array('star' => '1'));
		return $query->num_rows();
	}

	public function user_allsentlinks()
	{
		$this->db->order_by('id', 'desc');
		$query = $this->db->get('sent_links');
		return $query;
	}

	public function user_allsentlinkssms()
	{
		$this->db->where('sent_to_email', null);
		$query = $this->db->get('sent_links');
		return $query;
	}

	public function user_allsentlinksemail()
	{
		$this->db->where('sent_to_sms', null);
		$query = $this->db->get('sent_links');
		return $query;
	}

	public function emailsms_export_csv()
	{
		$this->db->order_by('id', 'desc');
		$this->db->select('id,sent_to_sms,sent_to_email,subj,body,user_id,sent_at');
		$query = $this->db->get('sent_links');
		return $query->result_array();
	}

	public function get_all_payments()
	{
		$this->db->order_by('id', 'desc');
		$query = $this->db->get('payment');
		return $query;
	}

	public function get_all_logs()
	{
		$this->db->order_by('id', 'desc');
		$query = $this->db->get('activity');
		return $query;
	}

	public function clear_logs()
	{
		$this->db->truncate('activity');
		return true;
	}

	public function get_feedbacks()
	{
		$this->db->order_by('id', 'desc');
		$query = $this->db->get('contact');
		return $query;
	}

	public function clear_feedbacks()
	{
		$this->db->truncate('contact');
		return true;
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
}
