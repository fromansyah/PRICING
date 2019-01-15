<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cust_site extends CI_Controller {
    
    public function __construct()
    {
	parent::__construct();
        $this->support_lib->check_login();
        $this->load->library('Dynamic_menu');
        $this->load->helper('file');
        $this->load->helper(array('form', 'url'));
        $this->load->model('Cust_site_model', 'Cust_site_model');
        $this->load->model('Customer_model', 'Customer_model');
        $this->load->model('Users_model', 'Users_model');
    }
    
    public function index(){
        $check = $this->Users_model->getRoleMenu('index.php/Customer');
        
        if(count($check) > 0){
            $this->load->helper('url');
        
            $data['page_name'] = 'Customer Site Management';
            
            $data['content'] = $this->load->view('cust_site/list', $data, TRUE);
            $this->load->view($this->session->userdata("template"), $data);
        }else{
            $data['title'] = 'Error Page';
        	$data["content"] = $this->load->view('error',$data,true);
            $this->load->view("blank", $data);
        }
        
    }
    
    
    
    function lists($cust_id) {
        $this->load->helper('url');
        
        $data['cust_id'] = $cust_id;
        
        $new_cust_id = str_replace('slash', '/', $cust_id);
        
        $result = $this->Customer_model->getCustomerById($new_cust_id)->result();
        $data['cust_name'] = $result[0]->cust_name;
        
        $data['page_title'] = 'Customer Site';
        $data['content'] = $this->load->view('cust_site/list', $data, TRUE);
        $this->load->view($this->session->userdata("template"), $data);
    }
 
    public function ajax_list($cust_id)
    {
        $cust_id = str_replace('slash', '/', $cust_id);
        $list = $this->Cust_site_model->get_datatables($cust_id);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $site) {

            $no++;
            $row = array();
            $row[] = $site->site_id;
            $row[] = $site->note;
 
            //add html for action
            $button = '<a href=\'#\' onclick="edit_site(\''.$site->site_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'/images/file_edit.png\' title=\'Edit Price\'></a>'.'&nbsp&nbsp&nbsp'.
                      '<a href=\'#\' onclick="delete_site(\''.$site->site_id.'\''.',\''.$site->site_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'/images/file_delete.png\' title=\'Delete Price\'></a>';
            
            $row[] = $button;

            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Cust_site_model->count_all($cust_id),
                        "recordsFiltered" => $this->Cust_site_model->count_filtered($cust_id),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($id)
    {
        $data = $this->Cust_site_model->get_by_id($id);
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        if($this->input->post('siteId') == null || $this->input->post('siteId') == ''){
            
            $error_message = 'ID can not empty.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }elseif($this->input->post('note') == null || $this->input->post('note') == ''){
            
            $error_message = 'Note can not empty or zero value.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }else{
            $data = array(
                    'cust_id' => $this->input->post('custId'),
                    'site_id' => $this->input->post('siteId'),
                    'note' => $this->input->post('note'),
                    'created_by' => $this->session->userdata("username"),
                    'created_date' => date('Y-m-d H:i:s', strtotime('now')),
                    'last_update_by' => $this->session->userdata("username"),
                    'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
                );
            
            $this->Cust_site_model->save($data);
            echo json_encode(array("status" => TRUE));
//            echo json_encode(array("status" => FALSE, 'error' => $this->input->post('menuName')));
        }
    }
 
    public function ajax_update()
    {
        if($this->input->post('siteId') == null || $this->input->post('siteId') == ''){
            
            $error_message = 'ID can not empty.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }elseif($this->input->post('note') == null || $this->input->post('note') == ''){
            
            $error_message = 'Note can not empty or zero value.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }else{
            $data = array(
                    'site_id' => $this->input->post('siteId'),
                    'note' => $this->input->post('note'),
                    'last_update_by' => $this->session->userdata("username"),
                    'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
                );
            
            $this->Cust_site_model->update(array('site_id' => $this->input->post('siteId')), $data);
            
            echo json_encode(array("status" => TRUE));
        }
    }
 
    public function ajax_delete($id)
    {
        $id = str_replace('slash', '/', $id);
        $this->Cust_site_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
    
    public function upload_site(){
        $data['page_title'] = 'Upload Customer Site';
        $data['content'] = $this->load->view('cust_site/upload_site', $data, TRUE);
        $this->load->view('form_template', $data);
    }
    
    function getmenuList(){
        echo json_encode($this->Cust_site_model->getCustSiteList());
    }
    
    public function download_template(){
        $data['title'] = 'Template Upload Customer Price';
        $data['content'] = $this->load->view('cust_site/template_site', $data, TRUE);
        $this->load->view('blank_page', $data);
    }
    
    public function getCustSiteList($cust_id){
        echo json_encode($this->Cust_site_model->getCustSiteList($cust_id));
    }
    
    public function new_upload_site(){
        $check = $this->Users_model->getRoleMenu('index.php/Customer');
        
        if(count($check) > 0){
            $data['page_title'] = 'Upload Customer Site';
            $data['content'] = $this->load->view('cust_site/new_upload_site', $data, TRUE);
            $this->load->view('form_template', $data);
        }else{
            $data['title'] = 'Error Page';
        	$data["content"] = $this->load->view('error',$data,true);
            $this->load->view("blank", $data);
        }
        
    }
    
    public function ajax_upload()
    {
        $ViewData=read_file("./csv/log_customer_site.txt");
        write_file("./csv/log_customer_site.txt", $ViewData."\n\n".date('Y-m-d H:i:s', strtotime('now'))." by ".$this->session->userdata("username"));
 
        $data = $this->input->post('data');
        
        $row = 1;
        $num_success = 0;
        $num_fail = 0;
        $success = array();
        $fail = array();
        $success_site = array();
        $fail_site = array();
        $fail_note = array();
        foreach($data as $key=>$field){
            
            if($key > 0){
                
                $cust_id = trim($field[0]);
                $site_id = trim($field[1]);
                $note = $field[2];

                $data_site = array(
                        'cust_id' => $cust_id,
                        'site_id' => $site_id,
                        'note' => $note,
                        'created_by' => $this->session->userdata("username"),
                        'created_date' => date('Y-m-d H:i:s', strtotime('now')),
                        'last_update_by' => $this->session->userdata("username"),
                        'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
                );

                $check_cust = $this->Customer_model->getCustomerById($cust_id)->result();

                if(count($check_cust)==0){
                    $fail[$num_fail] = $row;
                    $fail_site[$num_fail] = $site_id;
                    $fail_note[$num_fail] = 'Customer ID does not exist.';
                    $num_fail++;

                    $ViewData=read_file("./csv/log_customer_site.txt");
                    $text = $ViewData."\n Line ".$row.'. '.$cust_id.' Customer ID does not exist.';
                    write_file("./csv/log_customer_site.txt", $text);
                }else{
                    $check = $this->Cust_site_model->getCustSiteById($site_id)->result();

                    if(count($check) == 0){
                        $this->Cust_site_model->save($data_site);

                        $success[$num_success] = $row;
                        $success_site[$num_success] = $site_id;
                        $num_success++;
                    }else{
                        $fail[$num_fail] = $row;
                        $fail_site[$num_fail] = $site_id;
                        $fail_note[$num_fail] = 'Customer site already exist.';
                        $num_fail++;

                        $ViewData=read_file("./csv/log_customer_site.txt");
                        $text = $ViewData."\n Line ".$row.'. '.$site_id.' Customer site already exist.';
                        write_file("./csv/log_customer_site.txt", $text);
                    }
                }

                $row++;
            }
        }
        
        if($num_fail == 0){
            $ViewData=read_file("./csv/log_customer_site.txt");
            write_file("./csv/log_customer_site.txt", $ViewData."\n Upload success.\n".$num_success." row(s) has been uploaded.\n");
        }else{
            $ViewData=read_file("./csv/log_customer_site.txt");
            write_file("./csv/log_customer_site.txt", $ViewData."\n".$num_success." row(s) has been uploaded.\n".$num_fail.' row(s) fail to upload.');
        }
        
        $text = $num_success." row(s) has been uploaded.\n".$num_fail." row(s) fail to upload.\nSee log file for detail.";
        
        echo json_encode(array("status" => TRUE, "text" => $text));
        
    }
    
    public function log_file(){
        $data['title'] = 'Log File Customer Site';
        $data['content'] = $this->load->view('cust_site/log_file', $data, TRUE);
        $this->load->view('form_template', $data);
    }
}
?>
