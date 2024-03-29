<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Adminmodel extends CI_Model
{
	public function get_allusers()
	{
		// $this->db->where('sadmin', '0');
		$this->db->where(array('sadmin' => '0', 'cmpyid' => null));
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
			'sub' => '0',
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
			'plan_id' => null,
			'amount' => null,
			'balance' => null,
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
			'sub' => (htmlentities($this->input->post('plan_id')) === '1') ? '1' :'0',
			'form_key' => $form_key,
			'act_key' => password_hash($act_key, PASSWORD_DEFAULT),
			'password' => password_hash($this->input->post('pwd'), PASSWORD_DEFAULT),
		);
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
			'userid' => $lastid,
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
			'plan_id' => htmlentities($this->input->post('plan_id')),
			'amount' => htmlentities($this->input->post('amount')),
			'balance' => htmlentities($this->input->post('amount')),
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

	public function user_sub($user_sub, $user_id, $user_formKey)
	{
		$this->db->where(array('id' => $user_id, 'form_key' => $user_formKey));
		$this->db->set('sub', $user_sub);
		$query = $this->db->update("users");
		return true;
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

	public function updateprofile($user_id, $form_key, $profileData)
	{
		$this->db->where(array('id' => $user_id, 'form_key' => $form_key));
		$this->db->update("users", $profileData);

		return true;
	}

	public function deactivateaccount($user_id, $form_key)
	{
		$this->db->where(array('id' => $user_id, 'form_key' => $form_key));
		$query = $this->db->set('active', "2");
		$query = $this->db->update("users");
		return true;
	}

	public function activateaccount($user_id, $form_key)
	{
		$this->db->where(array('id' => $user_id, 'form_key' => $form_key));
		$query = $this->db->set('active', "1");
		$query = $this->db->update("users");
		return true;
	}

	public function deactivatesub($user_id, $form_key)
	{
		$this->db->where(array('id' => $user_id, 'form_key' => $form_key));
		$this->db->set('sub', "0");
		$query = $this->db->update("users");
		return true;
	}

	public function activatesub($user_id, $form_key)
	{
		$this->db->where(array('id' => $user_id, 'form_key' => $form_key));
		$this->db->set('sub', "1");
		$query = $this->db->update("users");
		return true;
	}

	public function updatepassword($user_id, $rspwd)
	{
		$this->db->set('password', password_hash($rspwd, PASSWORD_DEFAULT));
		$this->db->where('id', $user_id);
		$this->db->update("users");
		return true;
	}

	public function sadmin_get_userinfo($id, $form_key, $iscmpy, $isadmin)
	{
		if ($iscmpy == '1') {
			$this->db->select('u.*,cd.id as cmpydetailID,cd.userid,cd.cmpyName,cd.cmpyEmail,cd.cmpyMobile,cd.cmpyLogo')->from('users u');

			if ($isadmin == '1') {
				$this->db->join('company_details cd', 'cd.userid = u.id');
			} elseif ($isadmin == '0') {
				$this->db->join('company_details cd', 'cd.userid = u.cmpyid');
			}

			$this->db->where(array('u.id' => $id, 'u.form_key' => $form_key));
			$userinfo = $this->db->get()->row();
		} else {
			$this->db->select('u.*')->from('users u');
			$this->db->where(array('u.id' => $id, 'u.form_key' => $form_key));
			$userinfo = $this->db->get()->row();
		}

		return $userinfo;
	}

	public function sadmin_get_userQuota($id, $form_key, $iscmpy, $cmpyid)
	{
		if ($iscmpy == "1" && !empty($cmpyid) && $cmpyid !== "" && $cmpyid !== null) {
			$wherearray = array('by_user_id' => $cmpyid);
		} else {
			$wherearray = array('by_user_id' => $id, 'by_form_key' => $form_key);
		}

		$this->db->where($wherearray);
		$quotaInfo = $this->db->get("quota")->row();
		return $quotaInfo;
	}

	public function sadmin_get_adminusers($user_id, $form_key, $iscmpy, $cmpyid)
	{
		$wherearray = array('cmpyid' => $user_id);

		$this->db->where($wherearray);
		$q = $this->db->get("users")->result_array();
		return $q;
	}

	public function updatecompany($user_id, $form_key, $cmpyID, $cmpyData)
	{
		$this->db->where(array('id' => $cmpyID, 'userid' => $user_id));
		$this->db->update("company_details", $cmpyData);
		return true;
	}

	public function updatecompany_users($cmpyName, $user_id)
	{
		$data = array(
			'cmpy' => $cmpyName
		);

		$this->db->where('id', $user_id);
		$this->db->or_where('cmpyid', $user_id);
		$this->db->update('users', $data);
	}

	public function updatequota($user_id, $form_key, $qtData)
	{
		$this->db->where(array('by_user_id' => $user_id, 'by_form_key' => $form_key));
		$this->db->update("quota", $qtData);

		return true;
	}

	public function getplan($planid)
	{
		$this->db->where(array('id' => $planid));
		$query = $this->db->get('plans');
		return $query->row();
	}

	public function updateplan($planid, $pData)
	{
		$this->db->where('id', $planid);
		$this->db->update("plans", $pData);

		return true;
	}

	public function addplan($pData)
	{
		$this->db->insert("plans", $pData);

		return true;
	}


	//
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


	public function check_payID($pid)
	{
		$query = $this->db->get_where('transactions', array('payment_id' => $pid));

		//avoid duplicate entry
		//occurs on page refresh after success on payment
		if ($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function savePaymentInfo($PaymentInfoData)
	{
		$this->db->insert('transactions', $PaymentInfoData);

		$amount = $PaymentInfoData['amount'];
		$user_id = $PaymentInfoData['user_id'];
		$form_key = $PaymentInfoData['form_key'];

		$this->update_user_quota($user_id, $form_key, $amount);
		$this->update_user_sub($user_id, $form_key, $amount);

		return true;
	}

	public function update_user_quota($user_id, $form_key, $amount)
	{
		$this->db->where(array('by_user_id' => $user_id, 'by_form_key' => $form_key));
		$this->db->set("balance", "balance-" . $amount . "");
		$this->db->update("quota");

		return true;
	}

	public function update_user_sub($user_id, $form_key, $amount)
	{
		$this->db->where(array('id' => $user_id, 'form_key' => $form_key));
		$this->db->set("sub", "1");
		$this->db->update("users");

		$this->session->set_userdata('mr_sub', '1');
		return true;
	}

	public function get_all_transactions()
	{
		$this->db->order_by('t.date', 'desc');

		$this->db->select('t.*,u.id,u.uname')->from('transactions t');
		$this->db->join('users u', 'u.id = t.user_id');
		$q = $this->db->get()->result_array();

		return $q;
	}

	public function get_paymentsDetails($payID, $formkey, $userid)
	{
		$this->db->select('t.*,u.id,u.uname')->from('transactions t');
		$this->db->where(array('t.payment_id' => $payID, 't.form_key' => $formkey, 't.user_id' => $userid));
		$this->db->join('users u', 'u.id = t.user_id');
		$q = $this->db->get()->row();

		return $q;
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
