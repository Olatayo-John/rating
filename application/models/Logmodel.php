<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Logmodel extends CI_Model
{
    public function log_act($type)
    {
        if ($type == "logout") {
            $msg = "Logged Out. [ID: " . $this->session->userdata('mr_id') . ", Name: " . $this->session->userdata('mr_uname') . "]";
        } elseif ($type == "newuser") {
            $msg = "New User Registration. Verification code sent to email | User. [Username: " . htmlentities($this->input->post('uname')) . ", User-mail: " . htmlentities($this->input->post('email')) . "]";
        } elseif ($type == "acctverified") {
            $msg = "User account activated and logged in | User. [ID: " . $this->session->userdata('mr_id') . ", Name: " . $this->session->userdata('mr_uname') . "]";
        } elseif ($type == "login") {
            $msg = "Logged In | User. [ID: " . $this->session->userdata('mr_id') . ", Name: " . $this->session->userdata('mr_uname') . "]";
        } elseif ($type == "login_false") {
            $msg = "Failed Login Attempt- Wrong Username/Password | User. [Name: " . htmlentities($this->input->post('uname')) . "]";
        } elseif ($type == "inactive_access") {
            $msg = "Failed Login Attempt- Inactive Access | User. [Name: " . htmlentities($this->input->post('uname')) . "]";
        } elseif ($type == "inactive") {
            $msg = "Failed Login Attempt- Inactive Account | User. [Name: " . htmlentities($this->input->post('uname')) . "]";
        } elseif ($type == "smail_sent") {
            $msg = "Sent single mail | User. [ID: " . $this->session->userdata('mr_id') . ", Name: " . $this->session->userdata('mr_uname') . "]";
        } elseif ($type == "mmail_sent") {
            $msg = "Sent multiple mails | User. [ID: " . $this->session->userdata('mr_id') . ", Name: " . $this->session->userdata('mr_uname') . "]";
        } elseif ($type == "ssms_sent") {
            $msg = "Sent single sms | User. [ID: " . $this->session->userdata('mr_id') . ", Name: " . $this->session->userdata('mr_uname') . "]";
        } elseif ($type == "msms_sent") {
            $msg = "Sent multiple sms | User. [ID: " . $this->session->userdata('mr_id') . ", Name: " . $this->session->userdata('mr_uname') . "]";
        } elseif ($type == "mail_err") {
            $msg = "Mail couldn't be sent | User. [ID: " . $this->session->userdata('mr_id') . ", Name: " . $this->session->userdata('mr_uname') . "]";
        } elseif ($type == "sms_err") {
            $msg = "SMS couldn't be sent | User. [ID: " . $this->session->userdata('mr_id') . ", Name: " . $this->session->userdata('mr_uname') . "]";
        } elseif ($type == "db_err") {
            $msg = "Couldn't save to Database. [ID: " . $this->session->userdata('mr_id') . ", Name: " . $this->session->userdata('mr_uname') . "]";
        } elseif ($type == "quota_expire") {
            $msg = "Quota Expired | User. [ID: " . $this->session->userdata('mr_id') . ", Name: " . $this->session->userdata('mr_uname') . "]";
        } elseif ($type == "quota_limit") {
            $msg = "Quota too small | User. [ID: " . $this->session->userdata('mr_id') . ", Name: " . $this->session->userdata('mr_uname') . "]";
        } elseif ($type == "userscsv") {
            $msg = "Users CSV Exported. [ID: " . $this->session->userdata('mr_id') . ", Name: " . $this->session->userdata('mr_uname') . "]";
        } elseif ($type == "votesscsv") {
            $msg = "Votes CSV Exported. [ID: " . $this->session->userdata('mr_id') . ", Name: " . $this->session->userdata('mr_uname') . "]";
        } elseif ($type == "feedbackscsv") {
            $msg = "Feedbacks CSV Exported. [ID: " . $this->session->userdata('mr_id') . ", Name: " . $this->session->userdata('mr_uname') . "]";
        } elseif ($type == "paymentscsv") {
            $msg = "Payments CSV Exported. [ID: " . $this->session->userdata('mr_id') . ", Name: " . $this->session->userdata('mr_uname') . "]";
        } elseif ($type == "logscsv") {
            $msg = "Logs CSV Exported. [ID: " . $this->session->userdata('mr_id') . ", Name: " . $this->session->userdata('mr_uname') . "]";
        } elseif ($type == "link_csv") {
            $msg = "Links CSV Exported. [ID: " . $this->session->userdata('mr_id') . ", Name: " . $this->session->userdata('mr_uname') . "]";
        } elseif ($type == "logsclear") {
            $msg = "Logs table cleared. [ID: " . $this->session->userdata('mr_id') . ", Name: " . $this->session->userdata('mr_uname') . "]";
        } elseif ($type == "cnt_us") {
            $msg = "Message from Contact Us.[Name: " . htmlentities($_POST['name']) . ", Email: " . htmlentities($_POST['email']) . "]";
        } elseif ($type == "ratingstore") {
            $msg = "New Rating stored | User. [User: " . htmlentities($_POST['form_key']) . ", Star: " . htmlentities($_POST['starv'] . ", Website: " . $_POST['for_link']) . "]";
        } elseif ($type == "invalidlink") {
            $msg = "Invalid rating Link | User. [Website: " . htmlentities($_GET['w']) . ", Key: " . htmlentities($_GET['k']) .  "]";
        } elseif ($type == "invalidkey") {
            $msg = "Invalid rating Link | User. [Key: " . htmlentities($_GET['k']) .  "]";
        } elseif ($type == "webstatuserr") {
            $msg = "Error changing Website status | User. [ID: " . $this->session->userdata('mr_id') . ", WebID: " . $_POST['id'] . ", Status: " . $_POST['status'] . "]";
        } elseif ($type == "webstatus") {
            $msg = "Website status changed | User. [ID: " . $this->session->userdata('mr_id') . ", WebID: " . $_POST['id'] . ", Status: " . $_POST['status'] . "]";
        } elseif ($type == "webnewerr") {
            $msg = "Error creatiing new Website | User. [ID: " . $this->session->userdata('mr_id') . ", WebName: " . htmlentities($this->input->post('web_name_new')) . ", WebLink: " . htmlentities($this->input->post('web_link_new')) . "]";
        } elseif ($type == "websitenew") {
            $msg = "New Websites created | User. [ID: " . $this->session->userdata('mr_id') . ", Web: " . count($_POST['webname_arr']) . "]";
        } elseif ($type == "websitenewerr") {
            $msg = "Error creating new Website | User. [ID: " . $this->session->userdata('mr_id') . ", Web: " . count($_POST['webname_arr']) . "]";
        } elseif ($type == "webnew") {
            $msg = "New Website created | User. [ID: " . $this->session->userdata('mr_id') . ", WebName: " . htmlentities($this->input->post('web_name_new')) . ", WebLink: " . htmlentities($this->input->post('web_link_new')) . "]";
        } elseif ($type == "webdelerr") {
            $msg = "Error deleting Website | User. [ID: " . $this->session->userdata('mr_id') . ", WebID: " . $_POST['id'] .  "]";
        } elseif ($type == "webdel") {
            $msg = "Website deleted | User. [ID: " . $this->session->userdata('mr_id') . ", WebID: " . $_POST['id'] . "]";
        } elseif ($type == "prfileerr") {
            $msg = "Failed to update profile | User. [ID: " . $this->session->userdata('mr_id') . "]";
        } elseif ($type == "prfile") {
            $msg = "Profile Updated | User. [ID: " . $this->session->userdata('mr_id') .  "]";
        } elseif ($type == "userpwderr") {
            $msg = "Failed to update password | User. [ID: " . $this->session->userdata('mr_id') . "]";
        } elseif ($type == "userpwd") {
            $msg = "Password changed | User. [ID: " . $this->session->userdata('mr_id') .  "]";
        } elseif ($type == "userdact") {
            $msg = "Error deactivating account | User. [ID: " . $this->session->userdata('mr_id') .  "]";
        } elseif ($type == "admin_deleteuser") {
            $msg = "User Deleted | Admin. [ID: " . $this->session->userdata('mr_id') . ", UserID: " . $_POST['user_id'] . "]";
        } elseif ($type == "admin_deleteusererr") {
            $msg = "Error deleting User | Admin. [ID: " . $this->session->userdata('mr_id') . ", UserID: " . $_POST['user_id'] . "]";
        } elseif ($type == "admin_upu") {
            $msg = "User profile updated | Admin. [ID: " . $this->session->userdata('mr_id') . ", UserID: " . $_POST['user_id'] . ", Username: " . $_POST['uname'] . "]";
        } elseif ($type == "admin_upuerr") {
            $msg = "Error updating user profile | Admin. [ID: " . $this->session->userdata('mr_id') . ", UserID: " . $_POST['user_id'] . ", Username: " . $_POST['uname'] . "]";
        } elseif ($type == "admin_uwu") {
            $msg = "User website updated | Admin. [ID: " . $this->session->userdata('mr_id') . ", UserID: " . $_POST['user_id'] . ", Webname: " . $_POST['web_name_edit'] . ", Weblink: " . $_POST['web_link_edit'] . "]";
        } elseif ($type == "admin_uwuerr") {
            $msg = "Error updating user website | Admin. [ID: " . $this->session->userdata('mr_id') . ", UserID: " . $_POST['user_id'] . ", Webname: " . $_POST['web_name_edit'] . ", Weblink: " . $_POST['web_link_edit'] . "]";
        } elseif ($type == "admin_addw") {
            $msg = "New website created | Admin. [ID: " . $this->session->userdata('mr_id') . ", WebName: " . $_POST['web_name_add'] . ", WebLink: " . $_POST['web_link_add'] . ", UserID: " . $_POST['user_id'] . "]";
        } elseif ($type == "admin_addwuerr") {
            $msg = "Error creating new website | Admin. [ID: " . $this->session->userdata('mr_id') . ", WebName: " . htmlentities($_POST['web_name_add']) . ", WebLink: " . $_POST['web_link_add'] . ", UserID: " . $_POST['user_id'] . "]";
        } elseif ($type == "admin_delw") {
            $msg = "Website deleted | Admin. [ID: " . $this->session->userdata('mr_id') . ", WebName: " . $_POST['web_name'] . ", WebLink: " . $_POST['web_link'] . ", WebID: " . $_POST['web_id'] . "]";
        } elseif ($type == "admin_delwerr") {
            $msg = "Error deleting user website | Admin. [ID: " . $this->session->userdata('mr_id') . ", WebName: " . $_POST['web_name'] . ", WebLink: " . $_POST['web_link'] . ", WebID: " . $_POST['web_id'] . "]";
        } elseif ($type == "admin_deau") {
            $msg = "User account Deactivated | Admin. [ID: " . $this->session->userdata('mr_id') . ", UserID: " . $_POST['user_id'] . "]";
        } elseif ($type == "admin_deauerr") {
            $msg = "Error deactivating user account | Admin. [ID: " . $this->session->userdata('mr_id') . ", UserID: " . $_POST['user_id'] . "]";
        } elseif ($type == "admin_au") {
            $msg = "User account Activated | Admin. [ID: " . $this->session->userdata('mr_id') . ", UserID: " . $_POST['user_id'] . "]";
        } elseif ($type == "admin_auerr") {
            $msg = "Error activating user account | Admin. [ID: " . $this->session->userdata('mr_id') . ", UserID: " . $_POST['user_id'] . "]";
        } elseif ($type == "admin_upassu") {
            $msg = "User password changed | Admin. [ID: " . $this->session->userdata('mr_id') . ", UserID: " . $_POST['user_id'] . "]";
        } elseif ($type == "admin_upassuerr") {
            $msg = "Error updating user password | Admin. [ID: " . $this->session->userdata('mr_id') . ", UserID: " . $_POST['user_id'] . "]";
        } elseif ($type == "admin_vusub") {
            $msg = "User subscription activated | Admin. [ID: " . $this->session->userdata('mr_id') . ", UserID: " . $_POST['user_id'] . "]";
        } elseif ($type == "admin_vusuberr") {
            $msg = "Error activating user subscription | Admin. [ID: " . $this->session->userdata('mr_id') . ", UserID: " . $_POST['user_id'] . "]";
        } elseif ($type == "admin_unvusub") {
            $msg = "User subscription Deactivated | Admin. [ID: " . $this->session->userdata('mr_id') . ", UserID: " . $_POST['user_id'] . "]";
        } elseif ($type == "admin_unvusuberr") {
            $msg = "Error deactivating user subscription | Admin. [ID: " . $this->session->userdata('mr_id') . ", UserID: " . $_POST['user_id'] . "]";
        } elseif ($type == "admin_uuq") {
            $msg = "User quota renewed | Admin. [ID: " . $this->session->userdata('mr_id') . ", UserID: " . $_POST['user_id'] . ", Bought: " . $_POST['bought'] . ", Used: " . $_POST['used'] . ", Balance: " . $_POST['balance'] . "]";
        } elseif ($type == "admin_uuqerr") {
            $msg = "Error renewing User quota | Admin. [ID: " . $this->session->userdata('mr_id') . ", UserID: " . $_POST['user_id'] . ", Bought: " . $_POST['bought'] . ", Used: " . $_POST['used'] . ", Balance: " . $_POST['balance'] . "]";
        }

        $data = array(
            'msg' => $msg,
            'act_time' => date(DATE_COOKIE),
        );
        $this->db->insert("activity", $data);
        return true;
    }
}
