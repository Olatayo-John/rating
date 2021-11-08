<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Adminmodel extends CI_Model
{
	public function adduser($act_key, $form_key)
	{
		$data = array(
			'sadmin' => '0',
			'admin' => '0',
			'iscmpy' => $this->session->userdata("mr_iscmpy"),
			'cmpy' => $this->session->userdata("mr_cmpy"),
			'cmpyid' => $this->session->userdata("mr_id"),
			'uname' => htmlentities($this->input->post('uname')),
			'fname' => htmlentities($this->input->post('fname')),
			'lname' => htmlentities($this->input->post('lname')),
			'email' => htmlentities($this->input->post('email')),
			'mobile' => htmlentities($this->input->post('mobile')),
			'active' => "0",
			'website_form' => "0",
			'sub' => $this->session->userdata("mr_sub"),
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
			'webspace' => '0',
			'userspace' => '0',
			'by_form_key' => $form_key,
		);
		$this->db->insert('quota', $data);
		return true;
	}

	public function get_adminusers($limit = false, $offset = false)
	{
		$this->db->select("u.id as uid,u.iscmpy,u.cmpyid,u.uname,u.fname,u.lname,u.email,u.mobile,u.active,u.form_key,ud.id as udid,ud.total_ratings,ud.total_sms,ud.total_email,ud.total_one,ud.total_two,ud.total_three,ud.total_four,ud.total_five");
		$this->db->from('users u');
		$this->db->where(array('u.cmpyid' => $this->session->userdata("mr_id"), 'iscmpy' => '1', 'cmpy' => $this->session->userdata("mr_cmpy")));
		$this->db->join('user_details ud', 'u.form_key=ud.form_key', 'inner');
		$userinfo = $this->db->get();
		return $userinfo;
	}

	public function change_userstatus($uact, $uid, $formkey)
	{
		if ($uact == '0') {
			$uact_to = "1";
		} elseif ($uact == '1') {
			$uact_to = "2";
		} elseif ($uact == '2') {
			$uact_to = "1";
		}
		$this->db->where(array('id' => $uid, 'form_key' => $formkey));
		$this->db->set('active', $uact_to);
		$this->db->update('users');

		return true;
	}

	public function admin_deleteuser($user_id, $form_key)
	{
		$this->db->where(array('id' => $user_id, 'form_key' => $form_key));
		$this->db->delete('users');

		$this->delete_user_ratings($form_key);
		$this->delete_user_quota($user_id, $form_key);
		$this->delete_user_sentlinks($user_id);
		$this->delete_user_details($user_id, $form_key);
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

	public function delete_user_details($user_id, $form_key)
	{
		$this->db->where(array('user_id' => $user_id, 'form_key' => $form_key));
		$this->db->delete('user_details');
		return true;
	}

	public function delete_user_websites($user_id, $form_key)
	{
		$this->db->where(array('user_id' => $user_id, 'form_key' => $form_key));
		$this->db->delete('websites');
		return true;
	}

	public function get_userinfo($id, $form_key)
	{
		$this->db->select("id,iscmpy,cmpyid,cmpy,uname,fname,lname,email,mobile,active,website_form,sub,form_key");
		$this->db->where(array('id' => $id, 'form_key' => $form_key));
		$query = $this->db->get('users');
		return $query->row();
	}

	public function get_userdetails($id, $form_key)
	{
		$this->db->where(array('user_id' => $id, 'form_key' => $form_key));
		$query = $this->db->get('user_details');
		return $query->row();
	}

	public function get_userquota($id, $form_key,$iscmpy,$cmpyid)
	{
		if(!empty($iscmpy) && $iscmpy === "1" && isset($cmpyid) && !empty($cmpyid) && $cmpyid !== ""){
			$wherearray= array('by_user_id' => $cmpyid);
		}else{
			$wherearray= array('by_user_id' => $id, 'by_form_key' => $form_key);
		}

		$this->db->where($wherearray);
		$query = $this->db->get('quota');
		return $query->row();
	}

	public function get_userwebsites($id, $form_key)
	{
		$this->db->order_by('web_name','asc');
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

	public function admin_updateuserprofile($user_id, $form_key, $fname, $lname, $email, $mobile)
	{
		$data = array(
			'fname' => htmlentities($fname),
			'lname' => htmlentities($lname),
			'email' => htmlentities($email),
			'mobile' => strtolower(htmlentities($mobile)),
		);

		$this->db->where(array('id' => $user_id, 'form_key' => $form_key));
		$this->db->update("users", $data);

		return true;
	}

	public function admin_deactivateaccount($user_id, $form_key)
	{
		$this->db->where(array('id' => $user_id, 'form_key' => $form_key));
		$query = $this->db->set('active', "2");
		$query = $this->db->update("users");
		return true;
	}

	public function admin_activateaccount($user_id, $form_key)
	{
		$this->db->where(array('id' => $user_id, 'form_key' => $form_key));
		$query = $this->db->set('active', "1");
		$query = $this->db->update("users");
		return true;
	}

	public function admin_deactivatesub($user_id, $form_key)
	{
		$this->db->where(array('id' => $user_id, 'form_key' => $form_key));
		$query = $this->db->set('sub', "0");
		$query = $this->db->update("users");
		return true;
	}

	public function admin_activatesub($user_id, $form_key)
	{

		$this->db->where(array('id' => $user_id, 'form_key' => $form_key));
		$this->db->set('sub', "1");
		$query = $this->db->update("users");
		return true;
	}

	public function updateuser_webquota($user_id, $form_key, $web_quota)
	{
		$w = htmlentities($web_quota);

		$this->db->where(array('id' => $user_id, 'form_key' => $form_key));
		$this->db->set('web_quota', $w);
		$query = $this->db->update("users");
		return true;
	}

	public function updateuser_quota($user_id, $form_key, $bought, $used, $balance)
	{
		$b = htmlentities($bought);
		$u = htmlentities($used);
		$bal = htmlentities($balance);

		$this->db->set('bought',  $b);
		$this->db->set('used', $u);
		$this->db->set('bal', $bal);
		$this->db->where(array('by_user_id' => $user_id, 'by_form_key' => $form_key));
		$this->db->update("quota");
		return true;
	}

	public function admin_updateuserpwd($user_id, $rspwd)
	{
		$this->db->set('password', password_hash($rspwd, PASSWORD_DEFAULT));
		$this->db->where('id',$user_id);
		$this->db->update("users");
		return true;
	}

	public function get_allusers($limit = false, $offset = false)
	{
		$this->db->select("u.id as uid,u.cmpy,u.iscmpy,u.cmpyid,u.uname,u.fname,u.lname,u.email,u.mobile,u.active,u.form_key");
		$this->db->from('users u');
		$this->db->where('sadmin','0');
		// $this->db->join('user_details ud', 'u.form_key=ud.form_key', 'inner');
		$userinfo = $this->db->get();
		return $userinfo;
	}


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

	public function user_web_total($key)
	{
		$this->db->select('total_ratings');
		$this->db->from('user_details');
		$this->db->where('form_key', $key);
		$query = $this->db->get();
		if (!$query) {
			return false;
		} else {
			return $query->result();
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

	public function all_sms()
	{
		$this->db->select_sum('sms');
		$query = $this->db->get('user_details');
		return $query->result_array();
	}

	public function all_email()
	{
		$this->db->select_sum('email');
		$query = $this->db->get('user_details');
		return $query->result_array();
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

	public function logs_export_csv()
	{
		$this->db->order_by('id', 'desc');
		$this->db->select('id,msg,act_time');
		$query = $this->db->get('activity');
		return $query->result_array();
	}

	public function clear_logs()
	{
		$this->db->truncate('activity');
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

	public function clear_feedbacks()
	{
		$this->db->truncate('contact');
		return true;
	}
}
