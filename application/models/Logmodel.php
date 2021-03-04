<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Logmodel extends CI_Model
{
    public function log_act($type)
    {
        if ($type == "logout") {
            $msg = "Logged Out. [ID: " . $this->session->userdata('mr_id') . ", Name: " . $this->session->userdata('mr_uname') . "]";
        } elseif ($type == "newuser") {
            $msg = "New User Registration. Verification code sent to email. [Username: " . htmlentities($this->input->post('uname')) . ", User-mail: " . htmlentities($this->input->post('email')) . "]";
        } elseif ($type == "acctverified") {
            $msg = "User account activated and logged in. [ID: " . $this->session->userdata('mr_id') . ", Name: " . $this->session->userdata('mr_uname') . "]";
        } elseif ($type == "login") {
            $msg = "Logged In. [ID: " . $this->session->userdata('mr_id') . ", Name: " . $this->session->userdata('mr_uname') . "]";
        } elseif ($type == "login_false") {
            $msg = "Failed Login Attempt- Wrong Username/Password. [Name: " . htmlentities($this->input->post('uname')) . "]";
        } elseif ($type == "inactive_access") {
            $msg = "Failed Login Attempt- Inactive Access. [Name: " . htmlentities($this->input->post('uname')) . "]";
        } elseif ($type == "inactive") {
            $msg = "Failed Login Attempt- Inactive Account. [Name: " . htmlentities($this->input->post('uname')) . "]";
        } elseif ($type == "smail_sent") {
            $msg = "Sent single mail. [ID: " . $this->session->userdata('mr_id') . ", Name: " . $this->session->userdata('mr_uname') . "]";
        } elseif ($type == "mmail_sent") {
            $msg = "Sent multiple mails. [ID: " . $this->session->userdata('mr_id') . ", Name: " . $this->session->userdata('mr_uname') . "]";
        } elseif ($type == "ssms_sent") {
            $msg = "Sent single sms. [ID: " . $this->session->userdata('mr_id') . ", Name: " . $this->session->userdata('mr_uname') . "]";
        } elseif ($type == "msms_sent") {
            $msg = "Sent multiple sms. [ID: " . $this->session->userdata('mr_id') . ", Name: " . $this->session->userdata('mr_uname') . "]";
        } elseif ($type == "mail_err") {
            $msg = "Mail couldn't be sent. [ID: " . $this->session->userdata('mr_id') . ", Name: " . $this->session->userdata('mr_uname') . "]";
        } elseif ($type == "sms_err") {
            $msg = "SMS couldn't be sent. [ID: " . $this->session->userdata('mr_id') . ", Name: " . $this->session->userdata('mr_uname') . "]";
        } elseif ($type == "db_err") {
            $msg = "Couldn't save to Database. [ID: " . $this->session->userdata('mr_id') . ", Name: " . $this->session->userdata('mr_uname') . "]";
        } elseif ($type == "quota_expire") {
            $msg = "Quota Expired. [ID: " . $this->session->userdata('mr_id') . ", Name: " . $this->session->userdata('mr_uname') . "]";
        } elseif ($type == "quota_limit") {
            $msg = "Quota too small. [ID: " . $this->session->userdata('mr_id') . ", Name: " . $this->session->userdata('mr_uname') . "]";
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
            $msg = "New Rating stored. [User: " . htmlentities($_POST['form_key']) . ", Star: " . htmlentities($_POST['starv'] . ", Website: " . $_POST['for_link']) . "]";
        } elseif ($type == "invalidlink") {
            $msg = "Invalid rating Link. [Website: " . htmlentities($_GET['w']) . ", Key: " . htmlentities($_GET['k']) .  "]";
        } elseif ($type == "invalidkey") {
            $msg = "Invalid rating Link. [Key: " . htmlentities($_GET['k']) .  "]";
        } elseif ($type == "webstatuserr") {
            $msg = "Error changing Website status. [ID: " . $this->session->userdata('mr_id') . ", WebID: " . $_POST['id'] . ", Status: " . $_POST['status'] . "]";
        } elseif ($type == "webstatus") {
            $msg = "Website status changed. [ID: " . $this->session->userdata('mr_id') . ", WebID: " . $_POST['id'] . ", Status: " . $_POST['status'] . "]";
        } elseif ($type == "webnewerr") {
            $msg = "Error creatiing new Website. [ID: " . $this->session->userdata('mr_id') . ", WebName: " . htmlentities($this->input->post('web_name_new')) . ", WebLink: " . htmlentities($this->input->post('web_link_new')) . "]";
        } elseif ($type == "websitenew") {
            $msg = "New Website created. [ID: " . $this->session->userdata('mr_id') . ", WebName: " . htmlentities($_POST['webname_arr']) . ", WebLink: " . htmlentities($_POST['weblink_arr']) . "]";
        } elseif ($type == "websitenewerr") {
            $msg = "Error creating new Website. [ID: " . $this->session->userdata('mr_id') . ", WebName: " . htmlentities($_POST['webname_arr']) . ", WebLink: " . htmlentities($_POST['weblink_arr']) . "]";
        } elseif ($type == "webnew") {
            $msg = "New Website created. [ID: " . $this->session->userdata('mr_id') . ", WebName: " . htmlentities($this->input->post('web_name_new')) . ", WebLink: " . htmlentities($this->input->post('web_link_new')) . "]";
        } elseif ($type == "webdelerr") {
            $msg = "Error deleting Website. [ID: " . $this->session->userdata('mr_id') . ", WebID: " . $_POST['id'] .  "]";
        } elseif ($type == "webdel") {
            $msg = "Website deleted. [ID: " . $this->session->userdata('mr_id') . ", WebID: " . $_POST['id'] . "]";
        } elseif ($type == "prfileerr") {
            $msg = "Failed to update profile. [ID: " . $this->session->userdata('mr_id') . "]";
        } elseif ($type == "prfile") {
            $msg = "Profile Updated. [ID: " . $this->session->userdata('mr_id') .  "]";
        } elseif ($type == "userpwderr") {
            $msg = "Failed to update password. [ID: " . $this->session->userdata('mr_id') . "]";
        } elseif ($type == "userpwd") {
            $msg = "Password changed. [ID: " . $this->session->userdata('mr_id') .  "]";
        } elseif ($type == "userdact") {
            $msg = "User deactivated account and was logged out. [ID: " . $this->session->userdata('mr_id') .  "]";
        } elseif ($type == "admin_deleteuser") {
            $msg = "User Deleted. [ID: " . $this->session->userdata('mr_id') . ", UserID: " . $_POST['user_id'] . ", UserKey: " . $_POST['form_key'] . "]";
        } elseif ($type == "admin_deleteusererr") {
            $msg = "Error deleting User. [ID: " . $this->session->userdata('mr_id') . ", UserID: " . $_POST['user_id'] . ", UserKey: " . $_POST['form_key'] . "]";
        } elseif ($type == "admin_upu") {
            $msg = "User profile updated. [ID: " . $this->session->userdata('mr_id') . ", UserID: " . $_POST['user_id'] . ", Name: " . $_POST['uname'] . "]";
        } elseif ($type == "admin_upuerr") {
            $msg = "Error updating user profile. [ID: " . $this->session->userdata('mr_id') . ", UserID: " . $_POST['user_id'] . ", Name: " . $_POST['uname'] . "]";
        } elseif ($type == "admin_uwu") {
            $msg = "User profile updated. [ID: " . $this->session->userdata('mr_id') . ", UserID: " . $_POST['user_id'] . ", Name: " . $_POST['uname'] . "]";
        } elseif ($type == "admin_uwuerr") {
            $msg = "Error updating user profile. [ID: " . $this->session->userdata('mr_id') . ", UserID: " . $_POST['user_id'] . ", Name: " . $_POST['uname'] . "]";
        }

        $data = array(
            'msg' => $msg,
            'act_time' => date(DATE_COOKIE),
        );
        $this->db->insert("activity", $data);
        return true;
    }
}
