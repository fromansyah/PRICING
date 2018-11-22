<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Plan extends CI_Controller {
    
    public function __construct()
    {
	parent::__construct();
        $this->support_lib->check_login();
        $this->load->library('Dynamic_menu');
        $this->load->helper('file');
        $this->load->helper(array('form', 'url'));
        $this->load->model('Plan_model', 'Plan_model');
        $this->load->model('Product_model', 'Product_model');
        $this->load->model('Customer_model', 'Customer_model');
        $this->load->model('Cust_site_model', 'Cust_site_model');
        $this->load->model('Employee_model', 'Employee_model');
        $this->load->model('Product_price_model', 'Product_price_model');
    }
    
    public function index(){
        $this->load->helper('url');
        
        $data['page_name'] = 'Plan Management';
        $data['product_list'] = $this->Product_model->getProductList();
        $data['cust_list'] = $this->Customer_model->getCustomerList();
        $data['site_list'] = array();
        $data['sp_list'] = $this->Employee_model->getEmployeeListByPosition('SP');
        $periode_list = array();
        $periode_list[1] = 1;
        $periode_list[2] = 2;
        $periode_list[3] = 3;
        $periode_list[4] = 4;
        $periode_list[5] = 5;
        $periode_list[6] = 6;
        $periode_list[7] = 7;
        $periode_list[8] = 8;
        $periode_list[9] = 9;
        $periode_list[10] = 10;
        $periode_list[11] = 11;
        $periode_list[12] = 12;
        $data['periode_list'] = $periode_list;
        
        $data['content'] = $this->load->view('plan/list', $data, TRUE);
        $this->load->view($this->session->userdata("template"), $data);
    }
 
    public function ajax_list()
    {
        $list = $this->Plan_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $plan) {

            $no++;
            $row = array();
            $row[] = $plan->plan_id;
            $row[] = $plan->implementation_periode_year;
            $row[] = $plan->implementation_periode_month;
            $row[] = $plan->product_no;
            $row[] = $plan->cust_no;
            $row[] = $plan->cust_site;
            $row[] = '<div align="right">'.number_format($plan->price, 2).'</div>';
            $row[] = $plan->sp_id;
 
            //add html for action
            $button = '<a href=\'#\' onclick="edit_plan(\''.$plan->plan_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/file_edit.png\' title=\'Edit Plan\'></a>'.'&nbsp&nbsp&nbsp'.
//                      '<a href=\'#\' onclick="view_price(\''.$plan->plan_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/view-details.png\' title=\'View Prices\'></a>'.'&nbsp&nbsp&nbsp'.
                      '<a href=\'#\' onclick="delete_plan(\''.$plan->plan_id.'\''.',\''.$plan->plan_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/file_delete.png\' title=\'Delete Plan\'></a>';
            
            $row[] = $button;

            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Plan_model->count_all(),
                        "recordsFiltered" => $this->Plan_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($id)
    {
        $id = str_replace('slash', '/', $id);
        $data = $this->Plan_model->get_by_id($id);
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        if($this->input->post('year') == null || $this->input->post('year') == ''){
            
            $error_message = 'Year can not empty.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }elseif($this->input->post('periode') == null || $this->input->post('periode') == ''){
            
            $error_message = 'Periode can not empty.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }elseif($this->input->post('product') == null || $this->input->post('product') == ''){
            
            $error_message = 'Product can not empty.'.$this->input->post('product');
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }elseif($this->input->post('cust') == null || $this->input->post('cust') == ''){
            
            $error_message = 'Customer can not empty.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }elseif($this->input->post('site') == null || $this->input->post('site') == '' || $this->input->post('site') == 0){
            
            $error_message = 'Site can not empty.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }elseif($this->input->post('sp') == null || $this->input->post('sp') == ''){
            
            $error_message = 'Sales person can not empty.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }elseif($this->input->post('startDate') == null || $this->input->post('startDate') == ''){
            
            $error_message = 'Start date can not empty.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }elseif($this->input->post('endDate') == null || $this->input->post('endDate') == ''){
            
            $error_message = 'End date can not empty.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }elseif($this->input->post('price') == null || $this->input->post('price') == '' || $this->input->post('price') <= 0){
            
            $error_message = 'Price can not empty or zero value.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }else{
            $product_no = $this->input->post('product');
            $year = $this->input->post('year');
            $period = $this->input->post('periode');

            $price_result = $this->Product_price_model->getProductPriceByPeriod($product_no, $year, $period);
            $price_id = null;
            if(count($price_result) > 0){
                $price_id = $price_result[0]->price_id;
            }
            
            $data = array(
                    'implementation_periode_year' => $this->input->post('year'),
                    'implementation_periode_month' => $this->input->post('periode'),
                    'product_no' => $this->input->post('product'),
                    'cust_no' => $this->input->post('cust'),
                    'cust_site' => $this->input->post('site'),
                    'sp_id' => $this->input->post('sp'),
                    'start_date' => $this->input->post('startDate'),
                    'end_date' => $this->input->post('endDate'),
                    'price' => $this->input->post('price'),
                    'price_id' => $price_id,
                    'created_by' => $this->session->userdata("username"),
                    'created_date' => date('Y-m-d H:i:s', strtotime('now')),
                    'last_update_by' => $this->session->userdata("username"),
                    'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
                );
            
            $this->Plan_model->save($data);
            echo json_encode(array("status" => TRUE));
        }
        
//        $product_no = $this->input->post('product');
//        $year = $this->input->post('year');
//        $period = $this->input->post('periode');
//        
//        $price_result = $this->Product_price_model->getProductPriceByPeriod($product_no, $year, $period);
//        echo json_encode(array("status" => FALSE, 'error' => $price_result[0]->price_id));
    }
 
    public function ajax_update()
    {
        if($this->input->post('year') == null || $this->input->post('year') == ''){
            
            $error_message = 'Year can not empty.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }elseif($this->input->post('periode') == null || $this->input->post('periode') == ''){
            
            $error_message = 'Periode can not empty.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }elseif($this->input->post('product') == null || $this->input->post('product') == ''){
            
            $error_message = 'Product can not empty.'.$this->input->post('product');
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }elseif($this->input->post('cust') == null || $this->input->post('cust') == ''){
            
            $error_message = 'Customer can not empty.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }elseif($this->input->post('site') == null || $this->input->post('site') == '' || $this->input->post('site') == 0){
            
            $error_message = 'Site can not empty.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }elseif($this->input->post('sp') == null || $this->input->post('sp') == ''){
            
            $error_message = 'Customer can not empty.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }elseif($this->input->post('startDate') == null || $this->input->post('startDate') == ''){
            
            $error_message = 'Start date can not empty.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }elseif($this->input->post('endDate') == null || $this->input->post('endDate') == ''){
            
            $error_message = 'End date can not empty.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }elseif($this->input->post('price') == null || $this->input->post('price') == '' || $this->input->post('price') <= 0){
            
            $error_message = 'Price can not empty or zero value.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }else{
            $product_no = $this->input->post('product');
            $year = $this->input->post('year');
            $period = $this->input->post('periode');

            $price_result = $this->Product_price_model->getProductPriceByPeriod($product_no, $year, $period);
            $price_id = null;
            if(count($price_result) > 0){
                $price_id = $price_result[0]->price_id;
            }
            
            $data = array(
                    'implementation_periode_year' => $this->input->post('year'),
                    'implementation_periode_month' => $this->input->post('periode'),
                    'product_no' => $this->input->post('product'),
                    'cust_no' => $this->input->post('cust'),
                    'cust_site' => $this->input->post('site'),
                    'sp_id' => $this->input->post('sp'),
                    'start_date' => $this->input->post('startDate'),
                    'end_date' => $this->input->post('endDate'),
                    'price' => $this->input->post('price'),
                    'price_id' => $price_id,
                    'last_update_by' => $this->session->userdata("username"),
                    'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
                );
            
            $this->Plan_model->update(array('plan_id' => $this->input->post('planId')), $data);
            
            echo json_encode(array("status" => TRUE));
        }
    }
 
    public function ajax_delete($id)
    {
        $id = str_replace('slash', '/', $id);
        $this->Plan_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
    
    public function upload_plan(){
        $data['page_title'] = 'Upload Plan';
        $data['content'] = $this->load->view('plan/upload_plan', $data, TRUE);
        $this->load->view('form_template', $data);
    }
    
    function getmenuList(){
        echo json_encode($this->Plan_model->getPlanList());
    }
    
    public function download_template(){
        $data['title'] = 'Template Upload Plan';
        $data['content'] = $this->load->view('plan/template_plan', $data, TRUE);
        $this->load->view('blank_page', $data);
    }
    
    public function new_upload_plan(){
        $data['page_title'] = 'Upload Plan';
        $data['content'] = $this->load->view('plan/new_upload_plan', $data, TRUE);
        $this->load->view('form_template', $data);
    }
    
    public function ajax_upload()
    {
        $ViewData=read_file("./csv/log_plan.txt");
        write_file("./csv/log_plan.txt", $ViewData."\n\n".date('Y-m-d H:i:s', strtotime('now'))." by ".$this->session->userdata("username"));
 
        $data = $this->input->post('data');
        
        $row = 1;
        $num_success = 0;
        $num_fail = 0;
        $success = array();
        $fail = array(); 
        $success_plan = array();
        $fail_plan = array();
        $fail_note = array();
        foreach($data as $key=>$field){
            
            if($key > 0){
                $year = trim($field[0]);
                $period = trim($field[1]);
                $product_no = trim($field[2]);
                $customer = trim($field[3]);
                $site = trim($field[4]);
                $start_date = trim($field[5]);
                $end_date = trim($field[6]);
                $price = trim($field[7]);
                $sp = trim($field[8]);
                
                $price_result = $this->Product_price_model->getProductPriceByPeriod($product_no, $year, $period);
                $price_id = null;
                if(count($price_result) > 0){
                    $price_id = $price_result[0]->price_id;
                }

                $data_plan = array(
                        'implementation_periode_year' => $year,
                        'implementation_periode_month' => $period,
                        'product_no' => $product_no,
                        'cust_no' => $customer,
                        'cust_site' => $site,
                        'sp_id' => $sp,
                        'start_date' => $start_date,
                        'end_date' => $end_date,
                        'price' => $price,
                        'price_id' => $price_id,
                        'created_by' => $this->session->userdata("username"),
                        'created_date' => date('Y-m-d H:i:s', strtotime('now')),
                        'last_update_by' => $this->session->userdata("username"),
                        'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
                );
                
                $check_product = $this->Product_model->getProductById($product_no)->result();

                if(count($check_product) == 0){
                    $fail[$num_fail] = $row;
                    $fail_plan[$num_fail] = $product_no;
                    $fail_note[$num_fail] = 'Product Number does not exist.';
                    $num_fail++;

                    $ViewData=read_file("./csv/log_plan.txt");
                    $text = $ViewData."\n Line ".$row.'. '.$product_no.' Product number does not exist.';
                    write_file("./csv/log_plan.txt", $text);
                }else{
                    $check_customer = $this->Customer_model->getCustomerById($customer)->result();
                    
                    if(count($check_customer) == 0){
                        $fail[$num_fail] = $row;
                        $fail_plan[$num_fail] = $customer;
                        $fail_note[$num_fail] = 'Customer ID does not exist.';
                        $num_fail++;

                        $ViewData=read_file("./csv/log_plan.txt");
                        $text = $ViewData."\n Line ".$row.'. '.$customer.' Customer ID does not exist.';
                        write_file("./csv/log_plan.txt", $text);
                    }else{
                        $check_site = $this->Cust_site_model->getCustSiteById($site)->result();
                        
                        if(count($check_site) == 0){
                            $fail[$num_fail] = $row;
                            $fail_plan[$num_fail] = $site;
                            $fail_note[$num_fail] = 'Customer site does not exist.';
                            $num_fail++;

                            $ViewData=read_file("./csv/log_plan.txt");
                            $text = $ViewData."\n Line ".$row.'. '.$site.' Customer site does not exist.';
                            write_file("./csv/log_plan.txt", $text);
                        }else{
                            $check_sp = $this->Employee_model->getEmployeeById($sp)->result();
                            
                            if(count($check_sp) == 0){
                                $fail[$num_fail] = $row;
                                $fail_plan[$num_fail] = $sp;
                                $fail_note[$num_fail] = 'Sales person ID does not exist.';
                                $num_fail++;

                                $ViewData=read_file("./csv/log_plan.txt");
                                $text = $ViewData."\n Line ".$row.'. '.$sp.' Sales person ID does not exist.';
                                write_file("./csv/log_plan.txt", $text);
                            }else{
                                $check_plan = $this->Plan_model->getPlanData($product_no, $customer, $site, $year, $period);
                                
                                if(count($check_plan) == 0){
                                    $this->Plan_model->save($data_plan);

                                    $success[$num_success] = $row;
                                    $success_plan[$num_success] = $product_no;
                                    $num_success++;
                                }else{
                                    $fail[$num_fail] = $row;
                                    $fail_plan[$num_fail] = $product_no;
                                    $fail_note[$num_fail] = 'Plan already exist.';
                                    $num_fail++;

                                    $ViewData=read_file("./csv/log_plan.txt");
                                    $text = $ViewData."\n Line ".$row.'. '.$product_no.' Plan already exist.';
                                    write_file("./csv/log_plan.txt", $text);
                                }
                            }
                        }
                    }
                }

                $row++;
            }
        }
        
        if($num_fail == 0){
            $ViewData=read_file("./csv/log_plan.txt");
            write_file("./csv/log_plan.txt", $ViewData."\n Upload success.\n".$num_success." row(s) has been uploaded.\n");
        }else{
            $ViewData=read_file("./csv/log_plan.txt");
            write_file("./csv/log_plan.txt", $ViewData."\n".$num_success." row(s) has been uploaded.\n".$num_fail.' row(s) fail to upload.');
        }
        
        $text = $num_success." row(s) has been uploaded.\n".$num_fail." row(s) fail to upload.\nSee log file for detail.";
        
        echo json_encode(array("status" => TRUE, "text" => $text));
        
    }
    
    public function log_file(){
        $data['title'] = 'Log File Plan';
        $data['content'] = $this->load->view('plan/log_file', $data, TRUE);
        $this->load->view('form_template', $data);
    }
    
}
?>
