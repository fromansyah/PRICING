<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Periode extends CI_Controller {
    
    public function __construct()
    {
	parent::__construct();
        $this->support_lib->check_login();
        $this->load->library('Dynamic_menu');
        $this->load->model('Periode_model', 'Periode_model');
        $this->load->model('Users_model', 'Users_model'); 
    }
    
    public function index(){
        $check = $this->Users_model->getRoleMenu('index.php/Periode');
        
        if(count($check) > 0){
            $this->load->helper('url');
        
            $data['page_name'] = 'Periode Management';
            
            $data['content'] = $this->load->view('periode/list', $data, TRUE);
            $this->load->view($this->session->userdata("template"), $data);
        }else{
            $data['title'] = 'Error Page';
        	$data["content"] = $this->load->view('error',$data,true);
            $this->load->view("blank", $data);
        }
    }
 
    public function ajax_list()
    {
        $list = $this->Periode_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $periode) {

            $no++;
            $row = array();
            $row[] = $periode->periode_id;
            $row[] = $periode->start_date;
            $row[] = $periode->end_date;
 
            //add html for action
	    $button = '';
            if($this->session->userdata("role") == 1){
		    $button = '<a href=\'#\' onclick="edit_periode(\''.$periode->periode_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'/images/file_edit.png\' title=\'Edit Periode\'></a>'.'&nbsp&nbsp&nbsp'.
			      '<a href=\'#\' onclick="view_detail(\''.$periode->periode_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'/images/view-details.png\' title=\'View Detail\'></a>'.'&nbsp&nbsp&nbsp'.
			      '<a href=\'#\' onclick="delete_periode(\''.$periode->periode_id.'\''.',\''.$periode->periode_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'/images/file_delete.png\' title=\'Delete Periode\'></a>';
	    }
            $row[] = $button;

            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Periode_model->count_all(),
                        "recordsFiltered" => $this->Periode_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($id)
    {
        $id = str_replace('slash', '/', $id);
        $data = $this->Periode_model->get_by_id($id);
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        if($this->input->post('startDate') == null || $this->input->post('startDate') == ''){
            
            $error_message = 'Start date can not empty.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }elseif($this->input->post('endDate') == null || $this->input->post('endDate') == ''){
            
            $error_message = 'End date can not empty.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }else{
            $data = array(
                    'start_date' => $this->input->post('startDate'),
                    'end_date' => $this->input->post('endDate'),
                    'created_by' => $this->session->userdata("username"),
                    'created_date' => date('Y-m-d H:i:s', strtotime('now')),
                    'last_update_by' => $this->session->userdata("username"),
                    'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
                );
            
            $this->Periode_model->save($data);
            echo json_encode(array("status" => TRUE));
//            echo json_encode(array("status" => FALSE, 'error' => $this->input->post('menuName')));
        }
    }
 
    public function ajax_update()
    {
        if($this->input->post('startDate') == null || $this->input->post('startDate') == ''){
            
            $error_message = 'Start date can not empty.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }elseif($this->input->post('endDate') == null || $this->input->post('endDate') == ''){
            
            $error_message = 'End date can not empty.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }else{
            $data = array(
                    'start_date' => $this->input->post('startDate'),
                    'end_date' => $this->input->post('endDate'),
                    'last_update_by' => $this->session->userdata("username"),
                    'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
                );
            
            $this->Periode_model->update(array('periode_id' => $this->input->post('periodeId')), $data);
            
            echo json_encode(array("status" => TRUE));
        }
    }
 
    public function ajax_delete($id)
    {
        $id = str_replace('slash', '/', $id);
        $this->Periode_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
    
    public function upload_periode(){
        $data['page_title'] = 'Upload Periode';
        $data['content'] = $this->load->view('periode/upload_periode', $data, TRUE);
        $this->load->view('form_template', $data);
    }
    
    public function download_template(){
        $data['title'] = 'Template Upload Periode';
        $data['content'] = $this->load->view('periode/template_periode', $data, TRUE);
        $this->load->view('blank_page', $data);
    }
}
?>
