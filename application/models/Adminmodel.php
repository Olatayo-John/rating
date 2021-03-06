<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Adminmodel extends CI_Model
{
	public function get_user_details($limit = false, $offset = false)
	{
		$this->db->limit($limit, $offset);
		$query = $this->db->get('users');
		return $query;
	}

	public function users_export_csv()
	{
		$this->db->order_by('id', 'desc');
		$this->db->select('ID,active,uname,fname,lname,email,mobile,sub');
		$query = $this->db->get('users');
		return $query->result_array();
	}

	public function users_search_user($query)
	{
		$this->db->select('*');
		$this->db->from('users');
		if ($query != '') {
			$this->db->like('uname', $query);
			$this->db->or_like('fname', $query);
			$this->db->or_like('lname', $query);
			$this->db->or_like('email', $query);
			$this->db->or_like('mobile', $query);
		}
		$this->db->order_by('id', 'DESC');
		return $this->db->get();
	}

	public function users_filter_param($param, $type)
	{
		$this->db->order_by($param, $type);
		$query = $this->db->get('users');
		return $query;
	}

	public function delete_user($user_id, $form_key)
	{
		$this->db->where(array('id' => $user_id, 'form_key' => $form_key));
		$this->db->delete('users');

		$this->delete_user_ratings($form_key);
		$this->delete_user_payments($user_id, $form_key);
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

	public function delete_user_payments($user_id, $form_key)
	{
		$this->db->where(array('user_id' => $user_id, 'user_form_key' => $form_key));
		$this->db->delete('payment');
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

	public function get_user($id, $form_key)
	{
		$this->db->where(array('id' => $id, 'form_key' => $form_key));
		$query = $this->db->get('users');
		return $query->result();
	}

	public function getuserquota($id, $form_key)
	{
		$this->db->where(array('by_user_id' => $id, 'by_form_key' => $form_key));
		$query = $this->db->get('quota');
		return $query->result();
	}

	public function get_user_websites($id, $form_key)
	{
		$this->db->where(array('user_id' => $id, 'form_key' => $form_key));
		$query = $this->db->get('websites');
		return $query->result();
	}

	public function get_user_payments($id, $form_key)
	{
		$this->db->order_by('id', 'desc');
		$this->db->where(array('user_id' => $id, 'user_form_key' => $form_key));
		$query = $this->db->get('payment');
		return $query->result();
	}

	public function get_all_payments()
	{
		$this->db->order_by('id', 'desc');
		$query = $this->db->get('payment');
		return $query;
	}

	public function payments_export_csv()
	{
		$this->db->order_by('id', 'desc');
		$this->db->select('id,user_id,m_id,txn_id,order_id,currency,paid_amt,payment_mode,gateway_name,bank_txn_id,bank_name,status,paid_at');
		$query = $this->db->get('payment');
		return $query->result_array();
	}

	public function payments_search($query)
	{
		$this->db->select('*');
		$this->db->from('payment');
		if ($query != '') {
			$this->db->like('m_id', $query);
			$this->db->or_like('txn_id', $query);
			$this->db->or_like('order_id', $query);
			$this->db->or_like('paid_amt', $query);
			$this->db->or_like('payment_mode', $query);
			$this->db->or_like('gateway_name', $query);
			$this->db->or_like('bank_txn_id', $query);
			$this->db->or_like('bank_name', $query);
			$this->db->or_like('status', $query);
		}
		$this->db->order_by('id', 'DESC');
		return $this->db->get();
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

	public function user_profupdate($user_id, $form_key, $uname, $fname, $lname, $email, $mobile)
	{
		$data = array(
			'uname' => htmlentities($uname),
			'fname' => htmlentities($fname),
			'lname' => htmlentities($lname),
			'email' => strtolower(htmlentities($email)),
			'mobile' => strtolower(htmlentities($mobile)),
		);

		$this->db->where(array('id' => $user_id, 'form_key' => $form_key));
		$this->db->update("users", $data);

		$uname = htmlentities($uname);
		$this->userdetaild_name_update($uname, $user_id, $form_key);

		return true;
	}

	public function userdetaild_name_update($uname, $user_id, $form_key)
	{
		$this->db->set('uname', $uname);
		$this->db->where(array('user_id' => $user_id, 'form_key' => $form_key));
		$this->db->update("user_details");
		return true;
	}

	public function user_webupdate($id, $user_id, $form_key, $web_name_edit, $web_link_edit)
	{
		$data = array(
			'web_name' => strtolower(htmlentities($web_name_edit)),
			'web_link' => strtolower(htmlentities($web_link_edit)),
		);

		$this->db->where(array('id' => $id, 'user_id' => $user_id, 'form_key' => $form_key));
		$this->db->update("websites", $data);
		return true;
	}

	public function add_website($user_id, $form_key, $active, $web_name_add, $web_link_add)
	{
		$data = array(
			'user_id' => $user_id,
			'form_key' => $form_key,
			'web_name' => htmlentities($web_name_add),
			'web_link' => htmlentities($web_link_add),
			'active' => $active,
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

	public function delete_user_web($web_id, $user_id, $form_key, $web_name, $web_link)
	{
		$this->db->where(array('id' => $web_id, 'user_id' => $user_id, 'form_key' => $form_key, 'web_name' => $web_name, 'web_link' => $web_link));
		$this->db->delete("websites");

		$aff_rows = $this->delete_userratings($form_key, $web_name);

		$this->update_userdetails_rating($user_id, $form_key, $aff_rows);
		return true;
	}

	public function delete_userratings($form_key, $web_name)
	{
		$this->db->where(array('form_key' => $form_key, 'web_name' => $web_name));
		$this->db->delete("all_ratings");
		return $this->db->affected_rows();
	}

	public function update_userdetails_rating($user_id, $form_key, $aff_rows)
	{
		$this->db->set('total_ratings', 'total_ratings-' . $aff_rows);
		$this->db->where('form_key', $form_key);
		$this->db->update("user_details");
		return true;
	}

	public function deactivateuser($user_id, $user_form_key)
	{
		$this->db->where(array('id' => $user_id, 'form_key' => $user_form_key));
		$query = $this->db->set('active', "2");
		$query = $this->db->update("users");
		return true;
	}

	public function activateuser($user_id, $user_form_key)
	{
		$this->db->where(array('id' => $user_id, 'form_key' => $user_form_key));
		$query = $this->db->set('active', "1");
		$query = $this->db->update("users");
		return true;
	}

	public function verify_user_sub($user_id, $form_key)
	{

		$this->db->where(array('id' => $user_id, 'form_key' => $form_key));
		$this->db->set('sub', "1");
		$this->db->set('sub_active', "1");
		$query = $this->db->update("users");
		return true;
	}

	public function unverify_user_sub($user_id, $form_key)
	{
		$this->db->where(array('id' => $user_id, 'form_key' => $form_key));
		$query = $this->db->set('sub', "1");
		$query = $this->db->set('sub_active', "0");
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

	public function user_accupdate($user_id, $form_key, $new_pwd)
	{
		$this->db->set('password', password_hash($new_pwd, PASSWORD_DEFAULT));
		$this->db->where(array('id' => $user_id, 'form_key' => $form_key));
		$this->db->update("users");
		return true;
	}

	public function get_user_votes($limit = false, $offset = false)
	{
		$this->db->limit($limit, $offset);

		$query = $this->db->get('user_details');

		// $this->db->select('user_details.*,websites.id as web_id ,websites.web_name as web_name,websites.web_link as web_link');
		// $this->db->from('user_details');
		// $this->db->join('websites', 'user_details.form_key=websites.form_key', 'inner');
		// $query = $this->db->get();

		return $query;
	}

	public function get_total_ratings()
	{
		$query = $this->db->get('all_ratings');
		return $query;
	}
	public function get_total_official()
	{
		$this->db->where('web_name', 'official');
		$query = $this->db->get('all_ratings');
		return $query;
	}
	public function get_total_google()
	{
		$this->db->where('web_name', 'google');
		$query = $this->db->get('all_ratings');
		return $query;
	}
	public function get_total_facebook()
	{
		$this->db->where('web_name', 'facebook');
		$query = $this->db->get('all_ratings');
		return $query;
	}
	public function get_total_tp()
	{
		$this->db->where('web_name', 'trust pilot');
		$query = $this->db->get('all_ratings');
		return $query;
	}
	public function get_total_gd()
	{
		$this->db->where('web_name', 'glassdoor');
		$query = $this->db->get('all_ratings');
		return $query;
	}
	public function get_total_other()
	{
		$webs = array("official", "google", "facebook", "trust pilot", "glassdoor");
		$this->db->where_not_in('web_name', $webs);
		$query = $this->db->get('all_ratings');
		return $query;
	}

	public function votes_export_csv()
	{
		$this->db->order_by('id', 'desc');
		$this->db->select('id,uname,total_ratings,total_sms,total_email');
		$query = $this->db->get('user_details');
		return $query->result_array();
	}

	public function votes_filter_param($param, $type)
	{
		$this->db->order_by($param, $type);
		$query = $this->db->get('user_details');
		return $query;
	}

	public function votes_search_user($query)
	{
		$this->db->select('*');
		$this->db->from('user_details');
		if ($query != '') {
			$this->db->like('uname', $query);
		}
		$this->db->order_by('id', 'DESC');
		return $this->db->get();
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

	public function indiv_votes_export_csv($key)
	{
		$this->db->order_by('id', 'desc');
		$this->db->select('id,name,mobile,star,web_name,user_ip,rated_at');
		$query = $this->db->get_where('all_ratings', array('form_key' => $key));
		return $query->result_array();
	}

	public function search_ind_votes($query, $key)
	{
		if ($query !== '') {
			//  = $this->db->get_where('all_ratings',);
			$this->db->like('name', $query);
			$this->db->or_like('web_name', $query);
			$this->db->or_like('user_ip', $query);
			$query_search = $this->db->get_where('all_ratings', array('form_key' => $key));
			if ($query_search->num_rows() > 0) {
				return $query_search;
			} else {
				return false;
			}
			//return $this->db->last_query();
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

	public function check_quota_expire()
	{
		$form_key = $this->session->userdata('mr_form_key');
		$query = $this->db->get_where('quota', array('by_form_key' => $form_key))->row();
		if ($query) {
			if ($query->bal == '0'  || $query->bal < '0') {
				$this->db->set('bal', '0');
				$this->db->where('by_form_key', $form_key);
				$this->db->update('quota');

				$this->sub_update($form_key);

				$all_admin = $this->db->get_where('users', array('form_key' => $form_key))->row();
				return $all_admin;
				exit;
			} else {
				return false;
			}
		} else {
			return "not_Found";
		}
	}

	public function sub_update($form_key)
	{
		$this->db->set('sub', '0');
		$this->db->set('sub_active', '0');
		$this->db->where('form_key', $form_key);
		$this->db->update('users');
		$this->session->set_userdata('mr_sub', '0');
		return true;
	}

	public function emailsms_export_csv()
	{
		$this->db->order_by('id', 'desc');
		$this->db->select('id,sent_to_sms,sent_to_email,subj,body,user_id,sent_at');
		$query = $this->db->get('sent_links');
		return $query->result_array();
	}
}
