<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cam extends CI_Controller {
    
    public function __construct()
    {
	parent::__construct();
        $this->support_lib->check_login();
        $this->load->library('Dynamic_menu');
        $this->load->model('Cam_model', 'Cam_model');
    }
    
    public function index(){
        $this->load->helper('url');
        
        $data['page_name'] = 'Cam Management';
        $data['cam_list'] = $this->Cam_model->getCamList();
        
        $data['content'] = $this->load->view('cam/list', $data, TRUE);
        $this->load->view($this->session->userdata("template"), $data);
    }
 
    public function ajax_list()
    {
        $list = $this->Cam_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $cam) {

            $no++;
            $row = array();
            $row[] = $cam->cam_id;
            $row[] = $cam->cam_name;
            $row[] = $cam->note;
 
            //add html for action
            $button = '<a href=\'#\' onclick="edit_cam(\''.$cam->cam_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/file_edit.png\' title=\'Edit Cam\'></a>'.'&nbsp&nbsp&nbsp'.
//                      '<a href=\'#\' onclick="view_price(\''.$cam->cam_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/view-details.png\' title=\'View Prices\'></a>'.'&nbsp&nbsp&nbsp'.
                      '<a href=\'#\' onclick="delete_cam(\''.$cam->cam_id.'\''.',\''.$cam->cam_name.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/file_delete.png\' title=\'Delete Cam\'></a>';
            
            $row[] = $button;

            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Cam_model->count_all(),
                        "recordsFiltered" => $this->Cam_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($id)
    {
        $id = str_replace('slash', '/', $id);
        $data = $this->Cam_model->get_by_id($id);
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        if($this->input->post('camId') == null || $this->input->post('camId') == ''){
            
            $error_message = 'CAM ID can not empty.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }elseif($this->input->post('camName') == null || $this->input->post('camName') == ''){
            
            $error_message = 'CAM name can not empty.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }else{
            $data = array(
                    'cam_id' => $this->input->post('camId'),
                    'cam_name' => $this->input->post('camName'),
                    'note' => $this->input->post('note'),
                    'created_by' => $this->session->userdata("username"),
                    'created_date' => date('Y-m-d H:i:s', strtotime('now')),
                    'last_update_by' => $this->session->userdata("username"),
                    'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
                );
            
            $this->Cam_model->save($data);
            echo json_encode(array("status" => TRUE));
//            echo json_encode(array("status" => FALSE, 'error' => $this->input->post('menuName')));
        }
    }
 
    public function ajax_update()
    {
        if($this->input->post('camId') == null || $this->input->post('camId') == ''){
            
            $error_message = 'CAM ID can not empty.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }elseif($this->input->post('camName') == null || $this->input->post('camName') == ''){
            
            $error_message = 'CAM name can not empty.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }else{
            $data = array(
                    'cam_name' => $this->input->post('camName'),
                    'note' => $this->input->post('note'),
                    'last_update_by' => $this->session->userdata("username"),
                    'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
                );
            
            $this->Cam_model->update(array('cam_id' => $this->input->post('camId')), $data);
            
            echo json_encode(array("status" => TRUE));
        }
    }
 
    public function ajax_delete($id)
    {
        $id = str_replace('slash', '/', $id);
        $this->Cam_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
    
    public function upload_cam(){
        $data['page_title'] = 'Upload Cam';
        $data['content'] = $this->load->view('cam/upload_cam', $data, TRUE);
        $this->load->view('form_template', $data);
    }
    
    function getmenuList(){
        echo json_encode($this->Cam_model->getCamList());
    }
    
    public function download_template(){
        $data['title'] = 'Template Upload Cam';
        $data['content'] = $this->load->view('cam/template_cam', $data, TRUE);
        $this->load->view('blank_page', $data);
    }
}
?>
