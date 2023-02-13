<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ratemodel extends CI_Model
{
	public function get_key($k)
	{
		$query = $this->db->get_where('users', array("form_key" => $k))->row();
		return $query->form_key;
	}

	public function get_platforms_by_key($k)
	{
		$this->db->order_by('id', 'desc');
		$q = $this->db->get_where('websites', array('form_key' => $k));
		if (!$q) {
			return false;
		} else {
			return $q;
		}
	}

	public function is_valid_platform($k, $w)
	{
		$q = $this->db->get_where('websites', array('form_key' => $k, 'id' => $w))->row();

		if (!$q) {
			return false;
		} else {
			return $q;
		}
	}

	public function get_userDetails($k)
	{
		$this->db->where('form_key', $k);
		$d = $this->db->get('users')->row();
		return $d;
	}


	public function is_userquotaexpired($k)
	{
		$ud = $this->get_userDetails($k);

		$user_id = $ud->id;
		$form_key = $k;
		$iscmpy = $ud->iscmpy;
		$cmpyid = $ud->cmpyid;

		if ($iscmpy == "1" && !empty($cmpyid) && $cmpyid !== "" && $cmpyid !== null) {
			$wherearray = array('by_user_id' => $cmpyid);
		} else {
			$wherearray = array('by_user_id' => $user_id, 'by_form_key' => $form_key);
		}

		$this->db->where($wherearray);
		$query = $this->db->get('quota')->row();

		if ($query) {
			if ($query->balance > '0'  || $query->balance !== '0') {
				return "pending_balance";
				exit;
			} else {
				return false;
				exit;
			}
		} else {
			return "not_found";
			exit;
		}
	}

	public function saveRating($rData, $k, $web_id)
	{
		$this->db->insert("all_ratings", $rData);

		$this->update_web($k, $web_id);
		return true;
	}

	public function update_web($k, $web_id)
	{
		$this->db->where(array('id' => $web_id, 'form_key' => $k));
		$this->db->set("total_ratings", "total_ratings+1", false);
		$this->db->update("websites");

		return true;
	}

	public function get_wtr_id($id)
	{
		$this->db->where(array('frame_id' => $id));
		$q = $this->db->get('websites');
		return $q;
	}
}
