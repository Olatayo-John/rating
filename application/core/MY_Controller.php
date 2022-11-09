<?php

define('BASE_URI', str_replace('index.php', '', $_SERVER['SCRIPT_NAME']));

class MY_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        date_default_timezone_set("Asia/Kolkata");

        error_reporting(0);

        $this->setTabUrl($mod = null);
    }

    //set tab_div
    public function setTabUrl($mod)
    {
        $this->session->set_userdata('url', $mod);
    }

    //checks if user is loggedIn before accessing any page
    //via page refresh
    public function checklogin()
    {
        if (!$this->session->userdata('mr_logged_in')) {
            $this->session->set_flashdata('invalid', 'Please login first');
            redirect('logout');
        } else {
            return true;
        }
    }

    //checks if user is loggedIn before accessing any page
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
        // $this->session->sess_destroy();

        $this->session->set_flashdata('valid', 'Logged out');
        redirect('/');
    }
}

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
    }

    public function is_sadmin()
    {
        if (!$this->session->userdata('mr_logged_in')) {
            $this->session->set_flashdata('invalid', 'Please login first');
            redirect('logout');
        } else {
            if ($this->session->userdata('mr_sadmin') === "1") {
                return true;
            } else if ($this->session->userdata('mr_sadmin') === "0"){
                $this->session->set_flashdata('acces_denied', 'Access Denied.');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
    public function ajax_is_sadmin()
    {
        if (!$this->session->userdata('mr_logged_in')) {
            $this->session->set_flashdata('invalid', 'Please login first');
            return false;
        } else {
            if ($this->session->userdata('mr_sadmin') === "1") {
                return true;
            } else if ($this->session->userdata('mr_sadmin') === "0"){
                $this->session->set_flashdata('acces_denied', 'Access Denied.');
                return false;
            }
        }
    }

    public function is_admin()
    {
        if (!$this->session->userdata('mr_logged_in')) {
            $this->session->set_flashdata('invalid', 'Please login first');
            redirect('logout');
        } else {
            if ($this->session->userdata('mr_admin') === "1") {
                return true;
            } else if ($this->session->userdata('mr_admin') === "0"){
                $this->session->set_flashdata('acces_denied', 'Access Denied.');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
    public function ajax_is_admin()
    {
        if (!$this->session->userdata('mr_logged_in')) {
            $this->session->set_flashdata('invalid', 'Please login first');
            return false;
        } else {
            if ($this->session->userdata('mr_admin') === "1") {
                return true;
            } else if ($this->session->userdata('mr_admin') === "0"){
                $this->session->set_flashdata('acces_denied', 'Access Denied.');
                return false;
            }
        }
    }

    public function is_bothadmin()
    {
        if (!$this->session->userdata('mr_logged_in')) {
            $this->session->set_flashdata('invalid', 'Please login first');
            redirect('logout');
        } else {
            if ($this->session->userdata('mr_sadmin') === "1" || $this->session->userdata('mr_admin') === "1") {
                return true;
            } else {
                $this->session->set_flashdata('acces_denied', 'Access Denied.');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
    public function ajax_is_bothadmin()
    {
        if (!$this->session->userdata('mr_logged_in')) {
            $this->session->set_flashdata('invalid', 'Please login first');
            return false;
        } else {
            if ($this->session->userdata('mr_sadmin') === "1" || $this->session->userdata('mr_admin') === "1") {
                return true;
            } else {
                $this->session->set_flashdata('acces_denied', 'Access Denied.');
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
    }
}
