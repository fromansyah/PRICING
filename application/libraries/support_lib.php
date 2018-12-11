<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class support_lib
{
    function support_lib()
    {
        $this->CI=& get_instance();
        $this->CI->load->library('session');
        $this->CI->load->helper('form');
        $this->CI->load->helper('url');     
        $this->CI->load->library('aad_auth');
    }

    function check_login() {
//         if (!$this->CI->aad_auth->is_logged_in())
//         {
//             //$return_to = $this->input->get('return_to');
//             //$this->aad_auth->login($return_to === NULL ? site_url() : $return_to);
// 		    $this->CI->aad_auth->login();
//         }
//         else
//         {
            if ($this->CI->session->userdata('username')) {
                return true;
            } else {
                redirect('index.php/Menu_utama');
                //redirect('https://www.office.com/');
                return false;
            }
//         }
        
    }
  		
}
