<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Emailconfig
{
    protected $CI;

    public function __construct()
    {
        $this->CI = &get_instance();

        $config['protocol']    = 'smtp';
        $config['smtp_host']    = 'ssl://smtp.gmail.com';
        $config['smtp_port']    = '465';
        $config['smtp_timeout'] = '7';
        $config['smtp_user']    = 'jvweedtest@gmail.com';
        $config['smtp_pass']    = 'Jvweedtest9!';
        $config['charset']    = 'iso-8859-1';
        $config['mailtype'] = 'text';
        $config['validation'] = TRUE;

        $this->CI->load->library('email', $config);
        $this->CI->email->set_newline("\r\n");
    }

    //contact us email
    public function support_mail($name, $user_mail, $bdy)
    {
        if ($user_mail) {
            $subj = "Support message from " . $user_mail;
        } else if (!$user_mail) {
            $subj = "Support Mail";
        }

        $this->CI->email->from('jvweedtest@gmail.com', 'Rating');
        $this->CI->email->to('john.nktech@gmail.com');
        $this->CI->email->subject($subj);
        $this->CI->email->message($bdy);

        if ($this->CI->email->send()) {
            return true;
        } else {
            return $this->CI->email->print_debugger();
        }
    }

    //verification code on registration
    public function send_email_code($email, $uname, $act_key, $link)
    {
        $body = "Hello " . $uname . "\n\nYour verification code is " . $act_key . "\nEnter the above code to verify your account.\nClick here " . $link . "\n\nIf you have any questions, send us an email at info@nktech.in.\n\nBest Regards,\nNKTECH\nhttps://nktech.in";

        $this->CI->email->from('jvweedtest@gmail.com', 'Rating');
        $this->CI->email->to($email);
        $this->CI->email->subject("Verification Code");
        $this->CI->email->message($body);

        if ($this->CI->email->send()) {
            return true;
        } else {
            return $this->CI->email->print_debugger();
        }
    }

    //verification code for resetting password
    public function resetpassword_vcode($email, $act_key, $userid)
    {
        $body = "Your verification code is " . $act_key . "\nEnter the above code to reset your password.\n\nSend us an email at info@nktech.in for any queries.\n\nBest Regards,\nNKTECH\nhttps://nktech.in";

        $this->CI->email->from('jvweedtest@gmail.com', 'Rating');
        $this->CI->email->to($email);
        $this->CI->email->subject("Password Reset - Verification Code");
        $this->CI->email->message($body);

        if ($this->CI->email->send()) {
            return true;
        } else {
            return $this->CI->email->print_debugger();
        }
    }

    //new password from resetting password
    public function resetpassword($user_email, $rspwd, $user_name)
    {
        $body = "Hello " . $user_name . ", Your new password is " . $rspwd . "\n\nSend us an email at info@nktech.in for any queries.\n\nBest Regards,\nNKTECH\nhttps://nktech.in";

        $this->CI->email->from('jvweedtest@gmail.com', 'Rating');
        $this->CI->email->to($user_email);
        $this->CI->email->subject("Password Reset");
        $this->CI->email->message($body);

        if ($this->CI->email->send()) {
            return true;
        } else {
            return $this->CI->email->print_debugger();
        }
    }

    //mail to admin or user for expired quota
    //triggered when sending any link
    public function quota_send_mail_expire($usermail_expire)
    {
        $body = "Hello.\n\nThis email is to inform you that your Quota has expired.Future ratings woun't be recorded. All servives are unavailable\n\nPlease Renew your package to continue using our services " . base_url() . "\nIf you have any query, send us an email at info@nktech.in.\n\nBest Regards,\nNKTECH\nhttps://nktech.in";

        $this->CI->email->from('jvweedtest@gmail.com', 'Rating');
        $this->CI->email->to($usermail_expire);
        $this->CI->email->subject("Quota Limit Reached");
        $this->CI->email->message($body);

        if ($this->CI->email->send()) {
            return true;
        } else {
            return $this->CI->email->print_debugger();
        }
    }

    //sending single mail from sharing page
    public function link_send_mail($email, $subj, $bdy)
    {
        $this->CI->email->from('jvweedtest@gmail.com', 'Rating');
        $this->CI->email->to($email);
        $this->CI->email->subject($subj);
        $this->CI->email->message($bdy);

        if ($this->CI->email->send()) {
            return true;
        } else {
            return $this->CI->email->print_debugger();
        }
    }

    //sending multiple mail from sharing page
    public function send_multiple_link_email($mail, $subj, $bdy)
    {
        $this->CI->email->from('jvweedtest@gmail.com', 'Rating');
        $this->CI->email->to($mail);
        $this->CI->email->subject($subj);
        $this->CI->email->message($bdy);

        if ($this->CI->email->send()) {
            return true;
        } else {
            return $this->CI->email->print_debugger();
        }
    }

    public function new_companyuser($email, $fulln, $cmpy, $act_key, $link, $uname, $pwd)
    {
        $body = "Hello " . $fulln . " of " . $cmpy . "\n\nYour verification code is " . $act_key . "\nEnter the above code to verify your account.Click here " . $link . "\n\nBelow are your login credentails.\nUsername:" . $uname . "\nPassword:" . $pwd . "\n\nIf you have any questions, send us an email at info@nktech.in.\n\nBest Regards,\nNKTECH\nhttps://nktech.in";

        $this->CI->email->from('jvweedtest@gmail.com', 'Rating');
        $this->CI->email->to($email);
        $this->CI->email->subject("Your Verification Code");
        $this->CI->email->message($body);

        if ($this->CI->email->send()) {
            return true;
        } else {
            return $this->CI->email->print_debugger();
        }
    }





    ////
    ///rating controller
    public function notifyuser_sendemail($uemail, $uname)
    {
        $body = "Hello " . $uname . ".\n\nThis email is to inform you that your Quota has expired.Future ratings woun't be recorded. All servives are unavailable\n\nRenew your plan to keep using our services. " . base_url('plan') . "\n\nIf you have any queries, send us an email at info@nktech.in.\n\nBest Regards,\nNKTECH\nhttps://nktech.in";
        $mail = $this->CI->session->userdata('mr_email');

        $this->CI->email->from('jvweedtest@gmail.com', 'Quota Limit');
        $this->CI->email->to($uemail);
        $this->CI->email->subject("Quota Limit");
        $this->CI->email->message($body);

        if ($this->CI->email->send()) {
            return true;
        } else {
            return $this->CI->email->print_debugger();
        }
    }

    public function send_quota_expire_mail()
    {
        $body = "Hello.\n\nThis email is to inform you that your Quota has expired.SMS, Emails and Future ratings woun't be recorded\nRenew your plan to keep using our services" . base_url('plan') . "\nIf you have any queries, send us an email at info@nktech.in.\n\nBest Regards,\nNKTECH\nhttps://nktech.in";
        $mail = $this->CI->session->userdata('mr_email');

        $this->CI->email->from('jvweedtest@gmail.com', 'Quota Limit');
        $this->CI->email->to($mail);
        $this->CI->email->subject("Quota Limit");
        $this->CI->email->message($body);

        if ($this->CI->email->send()) {
            return true;
        } else {
            return $this->CI->email->print_debugger();
        }
    }
    ////
}
