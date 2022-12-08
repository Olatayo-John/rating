<?php

define('BASE_URI', str_replace('index.php', '', $_SERVER['SCRIPT_NAME']));

class MY_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->helper('language');
        $this->lang->load('system');

        date_default_timezone_set("Asia/Kolkata");

        // error_reporting(0);

        $this->setTabUrl($mod = null);
        $this->st = $this->get_settings($s = null);
    }

    //get settings
    public function get_settings($s = null)
    {
        if ($s !== null) {
            // $this->db->where(array("id" => '1', '' => $s));
        } else {
            $this->db->where(array("id" => '1'));
            $q = $this->db->get('settings');
            return $q->row();
        }
    }

    //set tab_div
    public function setTabUrl($mod)
    {
        $this->session->set_userdata('url', $mod); //set
    }

    //set session_flash-message
    public function setFlashMsg($s, $m)
    {
        $this->session->set_userdata('FlashMsg', array('status' => $s, 'msg' => $m)); //set
    }

    //checks if user is loggedIn before accessing any page/function
    //via page refresh/on-load
    public function checklogin()
    {
        if (!$this->session->userdata('mr_logged_in')) {
            $this->setFlashMsg('error', lang('login_first'));
            redirect('logout');
        } else {
            return true;
        }
    }

    //checks if user is loggedIn before accessing any page/function
    //via ajax calls
    public function ajax_checklogin()
    {
        if (!$this->session->userdata('mr_logged_in')) {
            return false;
        } else {
            return true;
        }
    }

    //logout
    //clear all sessions and redirect to login page
    public function logout()
    {
        $this->Logmodel->log_act($type = "logout");

        $this->session->unset_userdata('mr_id');
        $this->session->unset_userdata('mr_sadmin');
        $this->session->unset_userdata('mr_admin');
        $this->session->unset_userdata('mr_iscmpy');
        $this->session->unset_userdata('mr_cmpyid');
        $this->session->unset_userdata('mr_cmpy');
        $this->session->unset_userdata('mr_sub');
        $this->session->unset_userdata('mr_uname');
        $this->session->unset_userdata('mr_email');
        $this->session->unset_userdata('mr_mobile');
        $this->session->unset_userdata('mr_website_form');
        $this->session->unset_userdata('mr_form_key');
        $this->session->unset_userdata('mr_logged_in');
        $this->session->unset_userdata('mr_cmpy_logo');
        // $this->session->sess_destroy();

        $this->setFlashMsg('error', 'Logged out');
        redirect('/');
    }
}


// class User_Controller extends MY_Controller
class User_Controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
}


class Admin_Controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Settingsmodel');
    }

    //checks if user is loggedIn and is superAdmin before accessing any page/function
    //via page refresh/on-load
    public function is_sadmin()
    {
        if (!$this->session->userdata('mr_logged_in')) {
            $this->setFlashMsg('error', lang('login_first'));
            redirect('logout');
        } else {
            if ($this->session->userdata('mr_sadmin') === "1") {
                return true;
            } else {
                $this->setFlashMsg('error', lang('acc_denied'));
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
    //via ajax calls
    public function ajax_is_sadmin()
    {
        if (!$this->session->userdata('mr_logged_in')) {
            // $this->setFlashMsg('error', lang('login_first'));
            return false;
        } else {
            if ($this->session->userdata('mr_sadmin') === "1") {
                return true;
            } else if ($this->session->userdata('mr_sadmin') === "0") {
                // $this->setFlashMsg('error', lang('acc_denied'));
                return false;
            }
        }
    }

    //checks if user is loggedIn and is a companyAdmin before accessing any page/function
    //via page refresh/on-load
    public function is_admin()
    {
        if (!$this->session->userdata('mr_logged_in')) {
            $this->setFlashMsg('error', lang('login_first'));
            redirect('logout');
        } else {
            if ($this->session->userdata('mr_admin') === "1") {
                return true;
            } else if ($this->session->userdata('mr_admin') === "0") {
                $this->setFlashMsg('error', lang('acc_denied'));
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
    //via ajax calls
    public function ajax_is_admin()
    {
        if (!$this->session->userdata('mr_logged_in')) {
            // $this->setFlashMsg('error', lang('login_first'));
            return false;
        } else {
            if ($this->session->userdata('mr_admin') === "1") {
                return true;
            } else if ($this->session->userdata('mr_admin') === "0") {
                // $this->setFlashMsg('error', lang('acc_denied'));
                return false;
            }
        }
    }

    //checks if user is loggedIn and is both companyAdmin and superAdmin before accessing any page/function
    //via page refresh/on-load
    public function is_bothadmin()
    {
        if (!$this->session->userdata('mr_logged_in')) {
            $this->setFlashMsg('error', lang('login_first'));
            redirect('logout');
        } else {
            if ($this->session->userdata('mr_sadmin') === "1" || $this->session->userdata('mr_admin') === "1") {
                return true;
            } else {
                $this->setFlashMsg('error', lang('acc_denied'));
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
    //via ajax calls
    public function ajax_is_bothadmin()
    {
        if (!$this->session->userdata('mr_logged_in')) {
            // $this->setFlashMsg('error', lang('login_first'));
            return false;
        } else {
            if ($this->session->userdata('mr_sadmin') === "1" || $this->session->userdata('mr_admin') === "1") {
                return true;
            } else {
                // $this->setFlashMsg('error', lang('acc_denied'));
                return false;
            }
        }
    }
}

class Rate_Controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Ratemodel');
    }
}
