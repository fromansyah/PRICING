<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Corporate extends CI_Controller {
    
    public function __construct()
    {
	parent::__construct();
        $this->support_lib->check_login();
        $this->load->library('Dynamic_menu');
        $this->load->helper('file');
        $this->load->helper(array('form', 'url'));
        $this->load->model('Corporate_model', 'Corporate_model');
    }
    
    public function index(){
        $this->load->helper('url');
        
        $data['page_name'] = 'Corporate Management';
        $data['corporate_list'] = $this->Corporate_model->getCorporateList();
        
        $data['content'] = $this->load->view('corporate/list', $data, TRUE);
        $this->load->view($this->session->userdata("template"), $data);
    }
 
    public function ajax_list()
    {
        $list = $this->Corporate_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $corporate) {

            $no++;
            $row = array();
            $row[] = $corporate->corp_id;
            $row[] = $corporate->corp_name;
            $row[] = $corporate->note;
 
            //add html for action
            $button = '<a href=\'#\' onclick="edit_corporate(\''.$corporate->corp_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'/images/file_edit.png\' title=\'Edit Corporate\'></a>'.'&nbsp&nbsp&nbsp'.
//                      '<a href=\'#\' onclick="view_price(\''.$corporate->corp_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/view-details.png\' title=\'View Prices\'></a>'.'&nbsp&nbsp&nbsp'.
                      '<a href=\'#\' onclick="delete_corporate(\''.$corporate->corp_id.'\''.',\''.$corporate->corp_name.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'/images/file_delete.png\' title=\'Delete Corporate\'></a>';
            
            $row[] = $button;

            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Corporate_model->count_all(),
                        "recordsFiltered" => $this->Corporate_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($id)
    {
        $id = str_replace('slash', '/', $id);
        $data = $this->Corporate_model->get_by_id($id);
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        if($this->input->post('corpId') == null || $this->input->post('corpId') == ''){
            
            $error_message = 'Corporate number can not empty.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }elseif($this->input->post('corpName') == null || $this->input->post('corpName') == ''){
            
            $error_message = 'Corporate name can not empty.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }else{
            $data = array(
                    'corp_id' => $this->input->post('corpId'),
                    'corp_name' => $this->input->post('corpName'),
                    'note' => $this->input->post('note'),
                    'created_by' => $this->session->userdata("username"),
                    'created_date' => date('Y-m-d H:i:s', strtotime('now')),
                    'last_update_by' => $this->session->userdata("username"),
                    'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
                );
            
            $this->Corporate_model->save($data);
            echo json_encode(array("status" => TRUE));
//            echo json_encode(array("status" => FALSE, 'error' => $this->input->post('menuName')));
        }
    }
 
    public function ajax_update()
    {
        if($this->input->post('corpId') == null || $this->input->post('corpId') == ''){
            
            $error_message = 'Corporate number can not empty.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }elseif($this->input->post('corpName') == null || $this->input->post('corpName') == ''){
            
            $error_message = 'Corporate name can not empty.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }else{
            $data = array(
                    'corp_name' => $this->input->post('corpName'),
                    'note' => $this->input->post('note'),
                    'last_update_by' => $this->session->userdata("username"),
                    'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
                );
            
            $this->Corporate_model->update(array('corp_id' => $this->input->post('corpId')), $data);
            
            echo json_encode(array("status" => TRUE));
        }
    }
 
    public function ajax_delete($id)
    {
        $id = str_replace('slash', '/', $id);
        $this->Corporate_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
    
    public function upload_corporate(){
        $data['page_title'] = 'Upload Corporate';
        $data['content'] = $this->load->view('corporate/upload_corporate', $data, TRUE);
        $this->load->view('form_template', $data);
    }
    
    public function new_upload_corporate(){
        $data['page_title'] = 'Upload Corporate';
        $data['content'] = $this->load->view('corporate/new_upload_corporate', $data, TRUE);
        $this->load->view('form_template', $data);
    }
    
    function getmenuList(){
        echo json_encode($this->Corporate_model->getCorporateList());
    }
    
    public function download_template(){
        $data['title'] = 'Template Upload Corporate';
        $data['content'] = $this->load->view('corporate/template_corporate', $data, TRUE);
        $this->load->view('blank_page', $data);
    }
    
    public function ajax_upload()
    {
        $ViewData=read_file("./csv/log_corporate.txt");
        write_file("./csv/log_corporate.txt", $ViewData."\n\n".date('Y-m-d H:i:s', strtotime('now'))." by ".$this->session->userdata("username"));
 
        $data = $this->input->post('data');
        
        $row = 1;
        $num_success = 0;
        $num_fail = 0;
        $success = array();
        $fail = array();
        $success_corp = array();
        $fail_corp = array();
        $fail_note = array();
        foreach($data as $key=>$field){
            
            if($key > 0){
                $corp_id = trim($field[0]);
                $corp_name = trim($field[1]);
                $note = $field[2];

                $data_corp = array(
                        'corp_id' => $corp_id,
                        'corp_name' => $corp_name,
                        'note' => $note,
                        'created_by' => $this->session->userdata("username"),
                        'created_date' => date('Y-m-d H:i:s', strtotime('now')),
                        'last_update_by' => $this->session->userdata("username"),
                        'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
                );

                $check = $this->Corporate_model->getCorporateById($corp_id)->result();

                if(count($check) == 0){
                    $this->Corporate_model->save($data_corp);
                    $success[$num_success] = $row;
                    $success_corp[$num_success] = $corp_id;
                    $num_success++;
                }else{
                    $fail[$num_fail] = $row;
                    $fail_corp[$num_fail] = $corp_id;
                    $fail_note[$num_fail] = 'Corporate number already exist.';
                    $num_fail++;

                    $ViewData=read_file("./csv/log_corporate.txt");
                    $text = $ViewData."\n Line ".$row.'. '.$corp_id.' Corporate number already exist.';
                    write_file("./csv/log_corporate.txt", $text);
                }

                $row++;
            }
        }
        
        if($num_fail == 0){
            $ViewData=read_file("./csv/log_corporate.txt");
            write_file("./csv/log_corporate.txt", $ViewData."\n Upload success.\n".$num_success." row(s) has been uploaded.\n");
        }else{
            $ViewData=read_file("./csv/log_corporate.txt");
            write_file("./csv/log_corporate.txt", $ViewData."\n".$num_success." row(s) has been uploaded.\n".$num_fail.' row(s) fail to upload.');
        }
        
        $text = $num_success." row(s) has been uploaded.\n".$num_fail." row(s) fail to upload.\nSee log file for detail.";
        
        echo json_encode(array("status" => TRUE, "text" => $text));
        
    }
    
    public function log_file(){
        $data['title'] = 'Log File Corporate';
        $data['content'] = $this->load->view('corporate/log_file', $data, TRUE);
        $this->load->view('form_template', $data);
    }
}
?>
