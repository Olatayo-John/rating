<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Logmodel extends CI_Model
{

    public function log_act($type)
    {
        switch ($type) {
            case 'logout':
                $msg = "Logged Out. [ID: " . $this->session->userdata('mr_id') . ", Name: " . $this->session->userdata('mr_uname') . "]";
                break;
            case 'newuser':
                $msg = "New User Registration. Verification code sent to email | User. [Username: " . htmlentities($this->input->post('uname')) . ", User-mail: " . htmlentities($this->input->post('email')) . "]";
                break;
            case 'acctverified':
                $msg = "User account activated and logged in | User. [ID: " . $this->session->userdata('mr_id') . ", Name: " . $this->session->userdata('mr_uname') . "]";
                break;
            case 'login':
                $msg = "Logged In | User. [ID: " . $this->session->userdata('mr_id') . ", Name: " . $this->session->userdata('mr_uname') . "]";
                break;
            case 'login_false':
                $msg = "Failed Login Attempt- Wrong Username/Password | User. [Name: " . htmlentities($this->input->post('uname')) . "]";
                break;
            case 'inactive_access':
                $msg = "Failed Login Attempt- Inactive Access | User. [Name: " . htmlentities($this->input->post('uname')) . "]";
                break;
            case 'inactive':
                $msg = "Failed Login Attempt- Inactive Account | User. [Name: " . htmlentities($this->input->post('uname')) . "]";
                break;
            case 'smail_sent':
                $msg = "Sent single mail | User. [ID: " . $this->session->userdata('mr_id') . ", Name: " . $this->session->userdata('mr_uname') . "]";
                break;
            case 'mmail_sent':
                $msg = "Sent multiple mails | User. [ID: " . $this->session->userdata('mr_id') . ", Name: " . $this->session->userdata('mr_uname') . "]";
                break;
            case 'ssms_sent':
                $msg = "Sent single sms | User. [ID: " . $this->session->userdata('mr_id') . ", Name: " . $this->session->userdata('mr_uname') . "]";
                break;
            case 'msms_sent':
                $msg = "Sent multiple sms | User. [ID: " . $this->session->userdata('mr_id') . ", Name: " . $this->session->userdata('mr_uname') . "]";
                break;
            case 'mail_err':
                $msg = "Mail couldn't be sent | User. [ID: " . $this->session->userdata('mr_id') . ", Name: " . $this->session->userdata('mr_uname') . "]";
                break;
            case 'sms_err':
                $msg = "SMS couldn't be sent | User. [ID: " . $this->session->userdata('mr_id') . ", Name: " . $this->session->userdata('mr_uname') . "]";
                break;
            case 'db_err':
                $msg = "Couldn't save to Database. [ID: " . $this->session->userdata('mr_id') . ", Name: " . $this->session->userdata('mr_uname') . "]";
                break;
            case 'quota_expire':
                $msg = "Quota Expired | User. [ID: " . $this->session->userdata('mr_id') . ", Name: " . $this->session->userdata('mr_uname') . "]";
                break;
            case 'quota_limit':
                $msg = "Quota too small | User. [ID: " . $this->session->userdata('mr_id') . ", Name: " . $this->session->userdata('mr_uname') . "]";
                break;
            case 'logsclear':
                $msg = "Logs table cleared. [ID: " . $this->session->userdata('mr_id') . ", Name: " . $this->session->userdata('mr_uname') . "]";
                break;
            case 'feedbckclear':
                $msg = "Feedbacks table cleared. [ID: " . $this->session->userdata('mr_id') . ", Name: " . $this->session->userdata('mr_uname') . "]";
                break;
            case 'cnt_us':
                $msg = "Message from Contact Us.[Name: " . htmlentities($_POST['name']) . ", Email: " . htmlentities($_POST['email']) . "]";
                break;
            case 'ratingstore':
                $msg = "New Rating stored | User. [User: " . htmlentities($_POST['form_key']) . ", Star: " . htmlentities($_POST['starv'] . ", Website: " . $_POST['for_link']) . "]";
                break;
            case 'invalidlink':
                $msg = "Invalid rating Link | User. [Website: " . htmlentities($_GET['w']) . ", Key: " . htmlentities($_GET['k']) .  "]";
                break;
            case 'invalidkey':
                $msg = "Invalid rating Link | User. [Key: " . htmlentities($_GET['k']) .  "]";
                break;
            case 'webstatuserr':
                $msg = "Error changing Website status | User. [ID: " . $this->session->userdata('mr_id') . ", WebID: " . $_POST['id'] . ", Status: " . $_POST['status'] . "]";
                break;
            case 'webstatus':
                $msg = "Website status changed | User. [ID: " . $this->session->userdata('mr_id') . ", WebID: " . $_POST['id'] . ", Status: " . $_POST['status'] . "]";
                break;
            case 'webnewerr':
                $msg = "Error creatiing new Website | User. [ID: " . $this->session->userdata('mr_id') . ", WebName: " . htmlentities($_POST['web_name_new']) . ", WebLink: " . htmlentities($_POST['web_link_new']) . "]";
                break;
            case 'websitenew':
                $msg = "New Websites created | User. [ID: " . $this->session->userdata('mr_id') . ", Web: " . count($_POST['webname_arr']) . "]";
                break;
            case 'websitenewerr':
                $msg = "Error creating new Website | User. [ID: " . $this->session->userdata('mr_id') . ", Web: " . count($_POST['webname_arr']) . "]";
                break;
            case 'webnew':
                $msg = "New Website created | User. [ID: " . $this->session->userdata('mr_id') . ", WebName: " . htmlentities($this->input->post('web_name_new')) . ", WebLink: " . htmlentities($this->input->post('web_link_new')) . "]";
                break;
            case 'webdelerr':
                $msg = "Error deleting Website | User. [ID: " . $this->session->userdata('mr_id') . ", WebID: " . $_POST['id'] .  "]";
                break;
            case 'webdel':
                $msg = "Website deleted | User. [ID: " . $this->session->userdata('mr_id') . ", WebID: " . $_POST['id'] . "]";
                break;
            case 'prfileerr':
                $msg = "Failed to update profile | User. [ID: " . $this->session->userdata('mr_id') . "]";
                break;
            case 'prfile':
                $msg = "Profile Updated | User. [ID: " . $this->session->userdata('mr_id') .  "]";
                break;
            case 'userpwderr':
                $msg = "Failed to update password | User. [ID: " . $this->session->userdata('mr_id') . "]";
                break;
            case 'userpwd':
                $msg = "Password changed | User. [ID: " . $this->session->userdata('mr_id') .  "]";
                break;
            case 'vcodeerr':
                $msg = "Failed to verify Verification Code | User. [ID: " . $this->session->userdata('mr_id') . "]";
                break;
            case 'vcodesucc':
                $msg = "Verfication Code verified | User. [ID: " . $this->session->userdata('mr_id') .  "]";
                break;
            case 'userdact':
                $msg = "Error deactivating account | User. [ID: " . $this->session->userdata('mr_id') .  "]";
                break;
            case 'admin_userstatus':
                $msg = "User account status changed | Admin. [ID: " . $this->session->userdata('mr_id') . ", UserID: " . $_POST['uid'] . ", status_from: " . $_POST['uact'] . "]";
                break;
            case 'admin_userstatuserr':
                $msg = "Error changing User account status | Admin. [ID: " . $this->session->userdata('mr_id') . ", UserID: " . $_POST['uid'] . ", status_from: " . $_POST['uact'] . "]";
                break;
            case 'admin_deleteuser':
                $msg = "User Deleted | Admin. [ID: " . $this->session->userdata('mr_id') . ", UserID: " . $_POST['uid'] . "]";
                break;
            case 'admin_deleteusererr':
                $msg = "Error deleting User | Admin. [ID: " . $this->session->userdata('mr_id') . ", UserID: " . $_POST['uid'] . "]";
                break;
            case 'admin_upu':
                $msg = "User profile updated | Admin. [ID: " . $this->session->userdata('mr_id') . ", UserID: " . $_POST['user_id'] . "]";
                break;
            case 'admin_upuerr':
                $msg = "Error updating user profile | Admin. [ID: " . $this->session->userdata('mr_id') . ", UserID: " . $_POST['user_id'] . "]";
                break;
            case 'admin_uwu':
                $msg = "User website updated | Admin. [ID: " . $this->session->userdata('mr_id') . ", UserID: " . $_POST['user_id'] . ", Webname: " . $_POST['web_name_edit'] . ", Weblink: " . $_POST['web_link_edit'] . "]";
                break;
            case 'admin_uwuerr':
                $msg = "Error updating user website | Admin. [ID: " . $this->session->userdata('mr_id') . ", UserID: " . $_POST['user_id'] . ", Webname: " . $_POST['web_name_edit'] . ", Weblink: " . $_POST['web_link_edit'] . "]";
                break;
            case 'admin_addw':
                $msg = "New website created | Admin. [ID: " . $this->session->userdata('mr_id') . ", WebName: " . $_POST['web_name_add'] . ", WebLink: " . $_POST['web_link_add'] . ", UserID: " . $_POST['user_id'] . "]";
                break;
            case 'admin_addwuerr':
                $msg = "Error creating new website | Admin. [ID: " . $this->session->userdata('mr_id') . ", WebName: " . htmlentities($_POST['web_name_add']) . ", WebLink: " . $_POST['web_link_add'] . ", UserID: " . $_POST['user_id'] . "]";
                break;
            case 'admin_delw':
                $msg = "Website deleted | Admin. [ID: " . $this->session->userdata('mr_id') . ", WebName: " . $_POST['web_name'] . ", WebLink: " . $_POST['web_link'] . ", WebID: " . $_POST['web_id'] . "]";
                break;
            case 'admin_delwerr':
                $msg = "Error deleting user website | Admin. [ID: " . $this->session->userdata('mr_id') . ", WebName: " . $_POST['web_name'] . ", WebLink: " . $_POST['web_link'] . ", WebID: " . $_POST['web_id'] . "]";
                break;
            case 'admin_deau':
                $msg = "User account Deactivated | Admin. [ID: " . $this->session->userdata('mr_id') . ", UserID: " . $_POST['user_id'] . "]";
                break;
            case 'admin_deauerr':
                $msg = "Error deactivating user account | Admin. [ID: " . $this->session->userdata('mr_id') . ", UserID: " . $_POST['user_id'] . "]";
                break;
            case 'admin_au':
                $msg = "User account Activated | Admin. [ID: " . $this->session->userdata('mr_id') . ", UserID: " . $_POST['user_id'] . "]";
                break;
            case 'admin_auerr':
                $msg = "Error activating user account | Admin. [ID: " . $this->session->userdata('mr_id') . ", UserID: " . $_POST['user_id'] . "]";
                break;
            case 'admin_upassu':
                $msg = "User password changed | Admin. [ID: " . $this->session->userdata('mr_id') . ", UserID: " . $_POST['user_id'] . "]";
                break;
            case 'admin_upassuerr':
                $msg = "Error updating user password | Admin. [ID: " . $this->session->userdata('mr_id') . ", UserID: " . $_POST['user_id'] . "]";
                break;
            case 'admin_vusub':
                $msg = "User subscription activated | Admin. [ID: " . $this->session->userdata('mr_id') . ", UserID: " . $_POST['user_id'] . "]";
                break;
            case 'admin_vusuberr':
                $msg = "Error activating user subscription | Admin. [ID: " . $this->session->userdata('mr_id') . ", UserID: " . $_POST['user_id'] . "]";
                break;
            case 'admin_unvusub':
                $msg = "User subscription Deactivated | Admin. [ID: " . $this->session->userdata('mr_id') . ", UserID: " . $_POST['user_id'] . "]";
                break;
            case 'admin_unvusuberr':
                $msg = "Error deactivating user subscription | Admin. [ID: " . $this->session->userdata('mr_id') . ", UserID: " . $_POST['user_id'] . "]";
                break;
            case 'admin_uuq':
                $msg = "User quota renewed | Admin. [ID: " . $this->session->userdata('mr_id') . ", UserID: " . $_POST['user_id'] . ", Bought: " . $_POST['bought'] . ", Used: " . $_POST['used'] . ", Balance: " . $_POST['balance'] . "]";
                break;
            case 'admin_uuqerr':
                $msg = "Error renewing User quota | Admin. [ID: " . $this->session->userdata('mr_id') . ", UserID: " . $_POST['user_id'] . ", Bought: " . $_POST['bought'] . ", Used: " . $_POST['used'] . ", Balance: " . $_POST['balance'] . "]";
                break;
        }

        $data = array(
            'msg' => $msg,
            'act_time' => date(DATE_COOKIE),
        );
        $this->db->insert("activity", $data);
        return true;
    }
}
