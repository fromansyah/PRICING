<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_utama extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->support_lib->check_login();
        $this->load->helper('flexigrid_helper');
        $this->load->library('flexigrid');
        $this->load->library('aad_auth');
        $this->load->library('Dynamic_menu');
        $this->load->helper('url');
        $this->load->model('Plan_model', 'Plan_model');
    }
    
    public function index(){
        /*if (!$this->aad_auth->is_logged_in())
        {
            $this->aad_auth->login();
        }
        else
        {*/
            $data['title'] = 'Main Menu';
            $notification = $this->Plan_model->getPlanNotificationList();
            $data['notification'] = $notification;
            $data['content'] = $this->load->view('vmenu_utama',$data,true);
            $this->load->view($this->session->userdata("template"), $data);
        //}
        /*if ($this->session->userdata("username")):
            $data['title'] = 'Main Menu';
        
            $notification = $this->Plan_model->getPlanNotificationList();

            $data['notification'] = $notification;

            $data['content'] = $this->load->view('vmenu_utama',$data,true);
            $this->load->view($this->session->userdata("template"), $data);
        else:
            $data["title"] = "Login";
            $data["content"] = $this->load->view('vlogin',$data,true);
            $this->load->view("login", $data);
        endif;*/
        
    }
}
?>
