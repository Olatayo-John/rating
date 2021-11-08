<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Usermodel extends CI_Model{
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

				$this->db->set('sub', '0');
				$this->db->set('sub_active', '0');
				$this->db->where('form_key', $form_key);
				$this->db->update('users');
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
		$data = $this->get_user_weblink($form_key, $for_link);
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

	public function get_user_weblink($form_key, $for_link)
	{
		$this->db->where(array('web_name' => $for_link, 'form_key' => $form_key));
		$query = $this->db->get('websites')->row();
		return $query;
	}

	public function get_user_email($form_key)
	{
		$this->db->where('form_key', $form_key);
		$query = $this->db->get('users')->row();
		return $query;
	}
}
