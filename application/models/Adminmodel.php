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
		$this->delete_user_details($user_id, $form_key);
		$this->delete_user_quota($user_id, $form_key);
		$this->delete_user_ratings($form_key);
		$this->delete_user_sentlinks($user_id);
		$this->delete_user_websites($user_id, $form_key);
		return true;
	}

	public function delete_user_details($user_id, $form_key)
	{
		$this->db->where(array('user_id' => $user_id, 'form_key' => $form_key));
		$this->db->delete('user_details');
		return true;
	}

	public function delete_user_quota($user_id, $form_key)
	{
		$this->db->where(array('by_user_id' => $user_id, 'by_form_key' => $form_key));
		$this->db->delete('quota');
		return true;
	}

	public function delete_user_ratings($form_key)
	{
		$this->db->where('form_key', $form_key);
		$this->db->delete('all_ratings');
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

	public function get_user($id, $form_key)
	{
		$this->db->where(array('id' => $id, 'form_key' => $form_key));
		$query = $this->db->get('users');
		return $query->result();
	}

	public function get_user_websites($id, $form_key)
	{
		$this->db->where(array('user_id' => $id, 'form_key' => $form_key));
		$query = $this->db->get('websites');
		return $query->result();
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

	public function delete_user_web($web_id, $user_id, $form_key)
	{
		$this->db->where(array('id' => $web_id, 'user_id' => $user_id, 'form_key' => $form_key));
		$this->db->delete("websites");

		$this->delete_userratings($form_key);

		//function to also deduct total_ratngs from user_details
		//$this->update_userdetails_rating($user_id,$form_key);
		return true;
	}

	public function delete_userratings($form_key)
	{
		$this->db->where('form_key', $form_key);
		$this->db->delete("all_ratings");
		return true;
	}

	public function deactivateuser($user_id, $user_form_key)
	{
		$this->db->where(array('id' => $user_id, 'form_key' => $user_form_key));
		$query = $this->db->set('active', "0");
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
		$query = $this->db->get_where('websites', array('form_key' => $key));
		if (!$query) {
			return false;
		} else {
			return $query->result_array();
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
		$this->db->insert('payment', $userData);
		$quota_amount = round($userData['paid_amt']);
		$this->save_plan($quota_amount);
		$this->update_user_sub();
		$this->session->set_userdata('mr_sub', '1');
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
		$this->db->where('form_key', $this->session->userdata('mr_form_key'));
		$this->db->update("users");
		return true;
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
		$this->db->where('form_key', $form_key);
		$this->db->update('users');
		$this->session->set_userdata('mr_sub', '0');
		return true;
	}
}
