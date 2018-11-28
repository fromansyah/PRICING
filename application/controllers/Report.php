<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {
    
    public function __construct()
    {
	parent::__construct();
        $this->support_lib->check_login();
        $this->load->library('Dynamic_menu');
        $this->load->model('Report_model', 'Report_model');
    }
    
    public function index(){
        $this->lists();
    }
    
    function lists() {
        $this->load->helper('url');
        $data['test'] = '';
        
        $data['content'] = $this->load->view('Report/list', $data, TRUE);
        $this->load->view($this->session->userdata("template"), $data);
    }

    public function ajax_list()
    {
        $base_url = base_url();
        $base_url_explode = explode('/', $base_url);
        $host = $base_url_explode[0].'//'.$base_url_explode[2];
        $list = $this->Report_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $report) {

            $no++;
            $row = array();
            $row[] = $report->name;
            $row[] = $report->group;
            
            $button='';
            //add html for action
            if($this->session->userdata("role") == 1){
                $button = '<a href=\'#\' onclick="edit_report(\''.$report->id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'/images/file_edit.png\'></a>'.'&nbsp&nbsp&nbsp'.
                          '<a target="_blank" href="'.$host.':8080/birt/frameset?__report='.$report->url.'"><img border=\'0\' src=\''.$this->config->item('base_url').'/images/Go.png\'></a>'.'&nbsp&nbsp&nbsp'.
                          '<a href=\'#\' onclick="delete_report(\''.$report->id.'\''.',\''.$report->name.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'/images/file_delete.png\'></a>';
            }else{
                $button = '<a target="_blank" href="'.$host.':8080/birt/frameset?__report=child_age.rptdesign"><img border=\'0\' src=\''.$this->config->item('base_url').'/images/Go.png\'></a>';
            }
            
            
            $row[] = $button;

            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Report_model->count_all(),
                        "recordsFiltered" => $this->Report_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($id)
    {
        $data = $this->Report_model->get_by_id($id);
        echo json_encode($data);
    }

    public function ajax_add()
    {
        if($this->input->post('name') == null || $this->input->post('name') == ''){
            $error_message = 'Report name can not empty.';
            
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
        }elseif($this->input->post('url') == null || $this->input->post('url') == ''){
            $error_message = 'Report URL can not empty.';
            
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
        }else{
            $data = array(
                    'name' => $this->input->post('name'),
                    'url' => $this->input->post('url'),
                    'group' => $this->input->post('group'),
                    'created_by' => $this->session->userdata("username"),
                    'created_date' => date('Y-m-d H:i:s', strtotime('now')),
                    'last_update_by' => $this->session->userdata("username"),
                    'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
                );
            
            $insert = $this->Report_model->save($data);
            echo json_encode(array("status" => TRUE));
        }
    }
 
    public function ajax_update()
    {
         if($this->input->post('name') == null || $this->input->post('name') == ''){
            $error_message = 'Report name can not empty.';
            
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
        }elseif($this->input->post('url') == null || $this->input->post('url') == ''){
            $error_message = 'Report URL can not empty.';
            
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
        }else{
            $data = array(
                    'name' => $this->input->post('name'),
                    'url' => $this->input->post('url'),
                    'group' => $this->input->post('group'),
                    'last_update_by' => $this->session->userdata("username"),
                    'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
                );
            
            $this->Report_model->update(array('id' => $this->input->post('id')), $data);
            
            echo json_encode(array("status" => TRUE));
        }
    }
 
    public function ajax_delete($id)
    {
        $this->Report_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
}
?>
