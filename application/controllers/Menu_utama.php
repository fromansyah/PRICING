<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_utama extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->support_lib->check_login();
        $this->load->helper('flexigrid_helper');
        $this->load->library('flexigrid');
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
        $data['title'] = 'Main Menu';
        
        $notification = $this->Plan_model->getPlanNotificationList();
        
        $data['notification'] = $notification;
        
        $data['content'] = $this->load->view('vmenu_utama',$data,true);
        $this->load->view($this->session->userdata("template"), $data);
    }
}
?>
