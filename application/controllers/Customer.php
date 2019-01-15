<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller {
    
    public function __construct()
    {
	parent::__construct();
        $this->support_lib->check_login();
        $this->load->library('Dynamic_menu');
        $this->load->helper('file');
        $this->load->helper(array('form', 'url'));
        $this->load->model('Customer_model', 'Customer_model');
        $this->load->model('Corporate_model', 'Corporate_model');
        $this->load->model('Master_data_model', 'Master_data_model');
        $this->load->model('Users_model', 'Users_model');
    }
    
    public function index(){
        $check = $this->Users_model->getRoleMenu('index.php/Customer');
        
        if(count($check) > 0){
            $this->load->helper('url');
        
            $data['page_name'] = 'Customer Management';
            $data['corporate_list'] = $this->Corporate_model->getCorporateList();
            $data['cust_type_list'] = $this->Master_data_model->getMasterDataList('CUST_TYPE');
            $data['bu_list'] = $this->Master_data_model->getMasterDataList('BU_TYPE');
            
            $data['content'] = $this->load->view('customer/list', $data, TRUE);
            $this->load->view($this->session->userdata("template"), $data);
        }else{
            $data['title'] = 'Error Page';
        	$data["content"] = $this->load->view('error',$data,true);
            $this->load->view("blank", $data);
        }
        
    }
 
    public function ajax_list()
    {
        $list = $this->Customer_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $customer) {

            $no++;
            $row = array();
            $row[] = $customer->cust_id;
            $row[] = $customer->cust_name;
            $row[] = $customer->cust_type;
            $row[] = $customer->corp_id;
            $row[] = $customer->bu;
 
            //add html for action
            $button = '<a href=\'#\' onclick="edit_customer(\''.$customer->cust_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'/images/file_edit.png\' title=\'Edit Customer\'></a>'.'&nbsp&nbsp&nbsp'.
                      '<a href=\'#\' onclick="view_sites(\''.$customer->cust_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'/images/locations.png\' title=\'View Sites\'></a>'.'&nbsp&nbsp&nbsp'.
                      '<a href=\'#\' onclick="delete_customer(\''.$customer->cust_id.'\''.',\''.$customer->cust_name.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'/images/file_delete.png\' title=\'Delete Customer\'></a>';
            
            $row[] = $button;

            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Customer_model->count_all(),
                        "recordsFiltered" => $this->Customer_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($id)
    {
        $id = str_replace('slash', '/', $id);
        $data = $this->Customer_model->get_by_id($id);
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        if($this->input->post('custId') == null || $this->input->post('custId') == ''){
            
            $error_message = 'Customer number can not empty.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }elseif($this->input->post('custName') == null || $this->input->post('custName') == ''){
            
            $error_message = 'Customer name can not empty.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }else{
            
            if($this->input->post('corpId') == 0){
                $corp_id = null;
            }else{
                $corp_id = $this->input->post('corpId');
            }
            
            $data = array(
                    'cust_id' => $this->input->post('custId'),
                    'cust_name' => $this->input->post('custName'),
                    'corp_id' => $corp_id,
                    'cust_type' => $this->input->post('custType'),
                    'bu' => $this->input->post('bu'),
                    'note' => $this->input->post('note'),
                    'created_by' => $this->session->userdata("username"),
                    'created_date' => date('Y-m-d H:i:s', strtotime('now')),
                    'last_update_by' => $this->session->userdata("username"),
                    'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
                );
            
            $this->Customer_model->save($data);
            echo json_encode(array("status" => TRUE));
//            echo json_encode(array("status" => FALSE, 'error' => $this->input->post('menuName')));
        }
    }
 
    public function ajax_update()
    {
        if($this->input->post('custId') == null || $this->input->post('custId') == ''){
            
            $error_message = 'Customer number can not empty.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }elseif($this->input->post('custName') == null || $this->input->post('custName') == ''){
            
            $error_message = 'Customer name can not empty.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }else{
            
            if($this->input->post('corpId') == 0){
                $corp_id = null;
            }else{
                $corp_id = $this->input->post('corpId');
            }
            
            $data = array(
                    'cust_id' => $this->input->post('custId'),
                    'cust_name' => $this->input->post('custName'),
                    'corp_id' => $corp_id,
                    'cust_type' => $this->input->post('custType'),
                    'bu' => $this->input->post('bu'),
                    'note' => $this->input->post('note'),
                    'last_update_by' => $this->session->userdata("username"),
                    'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
                );
            
            $this->Customer_model->update(array('cust_id' => $this->input->post('custId')), $data);
            
            echo json_encode(array("status" => TRUE));
        }
    }
 
    public function ajax_delete($id)
    {
        $id = str_replace('slash', '/', $id);
        $this->Customer_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
    
    public function upload_customer(){
        $data['page_title'] = 'Upload Customer';
        $data['content'] = $this->load->view('customer/upload_customer', $data, TRUE);
        $this->load->view('form_template', $data);
    }
    
    function getmenuList(){
        echo json_encode($this->Customer_model->getCustomerList());
    }
    
    public function download_template(){
        $data['title'] = 'Template Upload Customer';
        $data['content'] = $this->load->view('customer/template_customer', $data, TRUE);
        $this->load->view('blank_page', $data);
    }
    
    public function new_upload_customer(){
        $check = $this->Users_model->getRoleMenu('index.php/Customer');
        
        if(count($check) > 0){
            $data['page_title'] = 'Upload Customer';
            $data['content'] = $this->load->view('customer/new_upload_customer', $data, TRUE);
            $this->load->view('form_template', $data);
        }else{
            $data['title'] = 'Error Page';
        	$data["content"] = $this->load->view('error',$data,true);
            $this->load->view("blank", $data);
        }
        
    }
    
    public function ajax_upload()
    {
        $ViewData=read_file("./csv/log_customer.txt");
        write_file("./csv/log_customer.txt", $ViewData."\n\n".date('Y-m-d H:i:s', strtotime('now'))." by ".$this->session->userdata("username"));
 
        $data = $this->input->post('data');
        
        $row = 1;
        $num_success = 0;
        $num_fail = 0;
        $success = array();
        $fail = array();
        $success_cust = array();
        $fail_cust = array();
        $fail_note = array();
        foreach($data as $key=>$field){
            
            if($key > 0){
                
                $cust_id = trim($field[0]);
                $cust_name = $field[1];
                $cust_type = trim($field[2]);
                $corp_id = trim($field[3]);
                $bu = trim($field[4]);
                $note = $field[5];

                $data_cust = array(
                    'cust_id' => $cust_id,
                    'cust_name' => $cust_name,
                    'cust_type' => $cust_type,
                    'corp_id' => $corp_id,
                    'bu' => $bu,
                    'note' => $note,
                    'created_by' => $this->session->userdata("username"),
                    'created_date' => date('Y-m-d H:i:s', strtotime('now')),
                    'last_update_by' => $this->session->userdata("username"),
                    'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
                );

                $check = $this->Customer_model->getCustomerById($cust_id)->result();

                if(count($check) == 0){
                    $this->Customer_model->save($data_cust);
                    $success[$num_success] = $row;
                    $success_cust[$num_success] = $cust_id;
                    $num_success++;
                }else{
                    $fail[$num_fail] = $row;
                    $fail_cust[$num_fail] = $cust_id;
                    $fail_note[$num_fail] = 'Customer number already exist.';
                    $num_fail++;

                    $ViewData=read_file("./csv/log_customer.txt");
                    $text = $ViewData."\n Line ".$row.'. '.$cust_id.' Customer number already exist.';
                    write_file("./csv/log_customer.txt", $text);
                }

                $row++;
            }
        }
        
        if($num_fail == 0){
            $ViewData=read_file("./csv/log_customer.txt");
            write_file("./csv/log_customer.txt", $ViewData."\n Upload success.\n".$num_success." row(s) has been uploaded.\n");
        }else{
            $ViewData=read_file("./csv/log_customer.txt");
            write_file("./csv/log_customer.txt", $ViewData."\n".$num_success." row(s) has been uploaded.\n".$num_fail.' row(s) fail to upload.');
        }
        
        $text = $num_success." row(s) has been uploaded.\n".$num_fail." row(s) fail to upload.\nSee log file for detail.";
        
        echo json_encode(array("status" => TRUE, "text" => $text));
        
    }
    
    public function log_file(){
        $data['title'] = 'Log File Customer';
        $data['content'] = $this->load->view('customer/log_file', $data, TRUE);
        $this->load->view('form_template', $data);
    }
}
?>
