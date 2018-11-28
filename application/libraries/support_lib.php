<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class support_lib
{
    function support_lib()
    {
        $this->CI=& get_instance();
        $this->CI->load->library('session');
        $this->CI->load->helper('form');
        $this->CI->load->helper('url');        
    }

    function check_login() {
        if ($this->CI->session->userdata('username')) {
            return true;
        } else {
            redirect('index.php/Main');
            return false;
        }
    }
  		
}
