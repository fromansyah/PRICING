<?php
class main extends CI_Controller {
public function __construct()
    {
	parent::__construct();
	$this->load->library('aad_auth');
//        $this->load->model('Assets_model', 'Assets_model');
//        $this->load->model('Users_model', 'Users_model');
        
    }

    function index()
    {
	if (!$this->aad_auth->is_logged_in())
        {
            //$return_to = $this->input->get('return_to');
            //$this->aad_auth->login($return_to === NULL ? site_url() : $return_to);
		$this->aad_auth->login();
        }
        else
        {
            $data = array(
                'user_info' => $this->aad_auth->user_info(),
                'id_token'  => $this->aad_auth->id_token(),
            );
            $data["content"] = $this->load->view('vlogin',$data,true);
            $this->load->view("login", $data);
        }
	    
        /*if ($this->session->userdata("username")):
            redirect("index.php/Menu_utama","refresh");
        else:
            $data["title"] = "Login";
            $data["content"] = $this->load->view('vlogin',$data,true);
            $this->load->view("login", $data);
        endif;*/
    }

    function login(/*$username, $password*/)
    {
        $username = $this->input->post("id_user");
        $password = md5($this->input->post("password"));

        if (!($username && $password)) {
            $this->session->set_flashdata('err_message', 'ID. User dan Password harus diisi.');
            redirect('index.php/Welcome', 'refresh');
        } else {
            if ($this->Users_model->login($username, $password)) {
                redirect('index.php/Menu_utama');
            } else {
                $this->session->set_flashdata('err_message', 'ID. User dan Password yang anda masukkan salah.');
                redirect('index.php/Welcome', 'refresh');
            }
        }
    }

    function check_login() {
        $username = $this->input->post('id_user', TRUE);
        $password = $this->input->post('password', TRUE);

        if ($this->Users_model->login($username, md5($password))) {
            $result = 'true';
        } else {
            $result = 'false';
        }

        $arr = array("result" => $result);
        echo json_encode($arr);
    }

    function logout()
    {
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('password');
        $this->session->unset_userdata('user_group');
        $this->session->unset_userdata('mode');
        $this->session->unset_userdata('nik');
        $this->session->unset_userdata('emp_id');
        
        
        $this->session->unset_userdata('admin_menu');
        $this->session->unset_userdata('menu_item_admin');
        $this->session->unset_userdata('user_menu');
        $this->session->unset_userdata('menu_name');
        $this->session->unset_userdata('menu_link');

        $this->session->unset_userdata('role');
        $this->session->unset_userdata('mode');
        $this->session->unset_userdata('template');
        $this->session->unset_userdata('edit_template');
        
        redirect('index.php/Welcome', 'refresh');
    }
}
