<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_utama extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        //$this->support_lib->check_login();
        $this->load->helper('flexigrid_helper');
        $this->load->library('flexigrid');
        $this->load->library('aad_auth');
        $this->load->library('Dynamic_menu');
        $this->load->helper('url');
//        $this->load->model('User_model', 'User_model');
//        $this->load->model('Product_model', 'Product_model');
//        $this->load->model('Customer_model', 'Customer_model');
//        $this->load->model('Cust_site_model', 'Cust_site_model');
        $this->load->model('Plan_model', 'Plan_model');
//        $this->load->library('fusioncharts');
    }
    
    public function index(){
       /*$this->load->library('session');
        $state = $this->input->get('state');
        $error = $this->input->get('error');
        $code = $this->input->get('code');
        // Regardless if authentication was successful or not, the state value MUST be the expected one.
        if ($this->session->aad_auth_nonce === NULL || $this->session->aad_auth_nonce !== $state)
        {
            die('State value returned (\'' . $state . '\') is not the value expected (\''
                 . $this->session->aad_auth_nonce . '\').');
        }
        else
        {
            if ($error !== NULL || $code === NULL)
            {
                // Error during authentication
                echo '<pre>' . $error . '</pre>';
                echo '<pre>' . $this->input->get('error_description') . '</pre>';
            }
            else
            {
                // Successful authentication, now use the authentication code to get an Access Token and ID Token
                echo '<pre>'; var_dump($this->input->get()); echo '</pre>';
                $this->aad_auth->request_tokens($this->input->get('code'), $this->session->aad_auth_nonce);
            }
        }*/
        
        $data['title'] = 'Main Menu';
        
        $notification = $this->Plan_model->getPlanNotificationList();
        
        $data['notification'] = $notification;
        
        $data['content'] = $this->load->view('vmenu_utama',$data,true);
        $this->load->view($this->session->userdata("template"), $data);
    }
}
?>
