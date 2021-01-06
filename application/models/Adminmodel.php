<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Adminmodel extends CI_Model{
	public function get_user_details($limit= false,$offset= false){
		$this->db->limit($limit,$offset);
		$query= $this->db->get('users');
		return $query;
	}

	public function users_export_csv(){
		$this->db->order_by('id','desc');
		$this->db->select('ID,uname,full_name,email,mobile,c_name,c_add,c_email,c_mobile,c_web,fb_link,google_link,glassdoor_link,trust_pilot_link,active,sub');
		$query= $this->db->get('users');
		return $query->result_array();
	}

	public function users_search_user($query){
		$this->db->select('*');
		$this->db->from('users');
		if ($query != '') {
			$this->db->like('uname',$query);
			$this->db->like('full_name',$query);
			$this->db->or_like('email',$query);
			$this->db->or_like('c_name',$query);
			$this->db->or_like('c_add',$query);
			$this->db->or_like('c_email',$query);
			$this->db->or_like('c_mobile',$query);
			$this->db->or_like('c_web',$query);
			$this->db->or_like('fb_link',$query);
			$this->db->or_like('glassdoor_link',$query);
			$this->db->or_like('google_link',$query);
			$this->db->or_like('trust_pilot_link',$query);
		}
		$this->db->order_by('id','DESC');
		return $this->db->get();
	}

	public function users_filter_param($param,$type){
		$this->db->order_by($param, $type);
		$query= $this->db->get('users');
		return $query;
	}

	public function delete_user($user_id,$form_key){
		$this->db->where(array('id'=>$user_id,'form_key'=>$form_key));
		$this->db->delete('users');
		$this->delete_user_details($user_id,$form_key);
		$this->delete_user_quota($user_id,$form_key);
		$this->delete_user_ratings($form_key);
		return true;
	}

	public function delete_user_details($user_id,$form_key){
		$this->db->where(array('user_id'=>$user_id,'form_key'=>$form_key));
		$this->db->delete('user_details');
		return true;
	}

	public function delete_user_quota($user_id,$form_key){
		$this->db->where(array('by_user_id'=>$user_id,'by_form_key'=>$form_key));
		$this->db->delete('quota');
		return true;
	}

	public function delete_user_ratings($form_key){
		$this->db->where('c_id',$form_key);
		$this->db->delete(array('all_ratings','fb_ratings','google_ratings','mainweb_rating','trustpilot_ratings','glassdoor_ratings'));
		return true;
	}

	public function get_user($id){
		$this->db->where('id',$id);
		$query= $this->db->get('users');
		return $query->result();
	}

	public function update_user($id){
		if ($this->input->post('u_pwd')) {
			$uname= htmlentities($this->input->post('uname'));
			$c_name= htmlentities($this->input->post('c_name'));
			$email= htmlentities($this->input->post('email'));
			$randpwd= $this->input->post('u_pwd');
			
			$this->update_user_password($uname,$c_name,$email,$randpwd);
			$data= array(
				'uname'=> htmlentities($this->input->post('uname')),
				'full_name'=> htmlentities($this->input->post('full_name')),
				'email'=> htmlentities($this->input->post('email')),
				'mobile'=> htmlentities($this->input->post('mobile')),
				'c_name'=> htmlentities($this->input->post('c_name')),
				'c_add'=> htmlentities($this->input->post('c_add')),
				'c_email'=> htmlentities($this->input->post('c_email')),
				'c_mobile'=> htmlentities($this->input->post('c_mobile')),
				'c_web'=> htmlentities($this->input->post('c_web')),
				'fb_link'=> htmlentities($this->input->post('fb_link')),
				'google_link'=> htmlentities($this->input->post('google_link')),
				'glassdoor_link'=> htmlentities($this->input->post('glassdoor_link')),
				'trust_pilot_link'=> htmlentities($this->input->post('trust_pilot_link')),
				'password'=> password_hash($this->input->post('u_pwd'), PASSWORD_DEFAULT)		
			);
			$this->db->where('id',$id);
			$this->db->update('users',$data);
			$uname= htmlentities($this->input->post('uname'));
			$this->update_user_details($id,$uname);
			return TRUE;
			exit;
		}else{
			$data= array(
				'uname'=> htmlentities($this->input->post('uname')),
				'full_name'=> htmlentities($this->input->post('full_name')),
				'email'=> htmlentities($this->input->post('email')),
				'mobile'=> htmlentities($this->input->post('mobile')),
				'c_name'=> htmlentities($this->input->post('c_name')),
				'c_add'=> htmlentities($this->input->post('c_add')),
				'c_email'=> htmlentities($this->input->post('c_email')),
				'c_mobile'=> htmlentities($this->input->post('c_mobile')),
				'c_web'=> htmlentities($this->input->post('c_web')),
				'fb_link'=> htmlentities($this->input->post('fb_link')),
				'google_link'=> htmlentities($this->input->post('google_link')),
				'glassdoor_link'=> htmlentities($this->input->post('glassdoor_link')),
				'trust_pilot_link'=> htmlentities($this->input->post('trust_pilot_link')),
			);
			$this->db->where('id',$id);
			$this->db->update('users',$data);
			$uname= htmlentities($this->input->post('uname'));
			$this->update_user_details($id,$uname);
			return TRUE;
			//return $this->db->last_query();
			exit;
		}
	}

	public function update_user_password($uname,$c_name,$email,$randpwd){
		$config['protocol']    = 'smtp';
		$config['smtp_host']    = 'ssl://smtp.gmail.com';
		$config['smtp_port']    = '465';
		$config['smtp_timeout'] = '7';
		$config['smtp_user']    = 'jvweedtest@gmail.com';
		$config['smtp_pass']    = 'Jvweedtest9!';
		$config['charset']    = 'iso-8859-1';
		$config['mailtype'] = 'text';
		$config['validation'] = TRUE; 

		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");

		$body= "Hello ".$uname." of ".$c_name."\n\nBelow are your new login credentails:\nUsername: ".$uname."\nPassword: ".$randpwd."\nYou can login here ".base_url()."\n\nIf you have any questions, send us an email at info@nktech.in.\n\nBest Regards,\nNKTECH\nhttps://nktech.in";

		$this->email->from('jvweedtest@gmail.com','Rating');
		$this->email->to($email);
		$this->email->subject("New Login credentails");
		$this->email->message($body);

		$this->email->send();
	}

	public function update_user_details($id,$uname){
		$data= array(
			'name'=> $uname
		);
		$this->db->where('user_id',$id);
		$this->db->update('user_details',$data);
		return true;
	}

	public function get_user_votes($limit= false,$offset= false){
		$this->db->limit($limit,$offset);
		$query= $this->db->get('user_details');
		return $query;
	}

	public function votes_export_csv(){
		$this->db->order_by('id','desc');
		$this->db->select('id,name,total_links,sms,email,ow_r,fb_r,g_r,gb_r,tp_r,5_star,4_star,3_star,2_star,1_star');
		$query= $this->db->get('user_details');
		return $query->result_array();
	}

	public function votes_filter_param($param,$type){
		$this->db->order_by($param, $type);
		$query= $this->db->get('user_details');
		return $query;
	}

	public function votes_search_user($query){
		$this->db->select('*');
		$this->db->from('user_details');
		if ($query != '') {
			$this->db->like('name',$query);
		}
		$this->db->order_by('id','DESC');
		return $this->db->get();
	}

	public function get_ratings($key){
		$this->db->order_by('id','desc');
		$this->db->where('c_id',$key);
		$query= $this->db->get('all_ratings');
		return $query->result_array();
	}

	public function indiv_votes_export_csv($key){
		$this->db->order_by('id','desc');
		$this->db->select('id,name,review_msg,star,mobile,user_ip,rated_at');
		$query= $this->db->get_where('all_ratings',array('c_id'=>$key));
		return $query->result_array();
	}

	public function search_ind_votes($query,$key){
		$this->db->select('*');
		$this->db->from('all_ratings');
		$this->db->where('c_id',$key);
		if ($query != '') {
			$this->db->like('name',$query);
		}
		$this->db->order_by('id','DESC');
		return $this->db->get();
	}

	public function save_payment($userData){
		$this->db->insert('payment',$userData);
		$quota_amount= round($userData['paid_amt']);
		$this->save_plan($quota_amount);
		$this->update_user_sub();
		$this->session->set_userdata('mr_sub','1');
		return true;
	}

	public function save_plan($quota_amount){
		$this->db->set('bought', 'bought+'.$quota_amount, FALSE);
		$this->db->set('bal', 'bal+'.$quota_amount, FALSE);
		$this->db->where('by_form_key', $this->session->userdata('mr_form_key'));
		$this->db->update("quota");
		return true;
	}

	public function update_user_sub(){
		$this->db->set('sub','1',FALSE);
		$this->db->where('form_key', $this->session->userdata('mr_form_key'));
		$this->db->update("users");
		return true;
	}

	public function all_total_ratings(){
		$query= $this->db->get_where('all_ratings');
		return $query->num_rows();
	}public function tr5_total_ratings(){
		$query= $this->db->get_where('all_ratings', array("star"=>"5"));
		return $query->num_rows();
	}public function tr4_total_ratings(){
		$query= $this->db->get_where('all_ratings', array("star"=>"4"));
		return $query->num_rows();
	}public function tr3_total_ratings(){
		$query= $this->db->get_where('all_ratings', array("star"=>"3"));
		return $query->num_rows();
	}public function tr2_total_ratings(){
		$query= $this->db->get_where('all_ratings', array("star"=>"2"));
		return $query->num_rows();
	}public function tr1_total_ratings(){
		$query= $this->db->get_where('all_ratings', array('star'=>'1'));
		return $query->num_rows();
	}

	public function all_sms(){
		$this->db->select_sum('sms');
		$query= $this->db->get('user_details');
		return $query->result_array();
	}

	public function all_email(){
		$this->db->select_sum('email');
		$query= $this->db->get('user_details');
		return $query->result_array();
	}





	public function check_quota_expire()
	{
		$form_key= $this->session->userdata('mr_form_key');
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
		}else{
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