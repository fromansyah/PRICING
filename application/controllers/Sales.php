<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales extends CI_Controller {
    
    public function __construct()
    {
	parent::__construct();
        $this->support_lib->check_login();
        $this->load->library('Dynamic_menu');
        $this->load->helper('file');
        $this->load->helper(array('form', 'url'));
        $this->load->model('Sales_model', 'Sales_model');
        $this->load->model('Agreement_model', 'Agreement_model');
        $this->load->model('Plan_model', 'Plan_model');
        $this->load->model('Product_model', 'Product_model');
        $this->load->model('Customer_model', 'Customer_model');
        $this->load->model('Cust_site_model', 'Cust_site_model');
        $this->load->model('Employee_model', 'Employee_model');
        $this->load->model('Product_price_model', 'Product_price_model');
        $this->load->model('Master_data_model', 'Master_data_model');
        $this->load->model('Users_model', 'Users_model'); 
    }
    
    public function index(){
        $check = $this->Users_model->getRoleMenu('index.php/Sales');
        
        if(count($check) > 0){
            $this->load->helper('url');
        
            $data['page_name'] = 'Sales Management';
            $data['product_list'] = $this->Product_model->getProductList();
            $data['cust_list'] = $this->Customer_model->getCustomerList();
            $data['site_list'] = array();
            $data['sp_list'] = $this->Employee_model->getEmployeeListByPosition('SP');
            $data['price_list'] = array();
            
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
            
            $currency = array();
            $currency['IDR'] = 'IDR';
            $currency['USD'] = 'USD';
            $data['currency_list'] = $currency;
            
            $data['content'] = $this->load->view('sales/list', $data, TRUE);
            $this->load->view($this->session->userdata("template"), $data);
        }else{
            $data['title'] = 'Error Page';
        	$data["content"] = $this->load->view('error',$data,true);
            $this->load->view("blank", $data);
        }
        
    }
 
    public function ajax_list()
    {
        $list = $this->Sales_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $sales) {

            $no++;
            $row = array();
            $row[] = $sales->sale_id;
            $row[] = $sales->date;
            $row[] = $sales->sp_id;
            $row[] = $sales->cust_no;
            $row[] = $sales->site_id;
            $row[] = $sales->product_no;
            $row[] = $sales->currency;
            $row[] = '<div align="right">'.number_format($sales->price, 2).'</div>';
            $row[] = $sales->quantity;
            $row[] = '<div align="right">'.number_format($sales->total, 2).'</div>';
 
            //add html for action
            $button = '<a href=\'#\' onclick="edit_sales(\''.$sales->sale_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'/images/file_edit.png\' title=\'Edit Sales\'></a>'.'&nbsp&nbsp&nbsp'.
//                      '<a href=\'#\' onclick="view_price(\''.$sales->sale_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/view-details.png\' title=\'View Prices\'></a>'.'&nbsp&nbsp&nbsp'.
                      '<a href=\'#\' onclick="delete_sales(\''.$sales->sale_id.'\''.',\''.$sales->sale_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'/images/file_delete.png\' title=\'Delete Sales\'></a>';
            
            $row[] = $button;

            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Sales_model->count_all(),
                        "recordsFiltered" => $this->Sales_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($id)
    {
        $id = str_replace('slash', '/', $id);
        $data = $this->Sales_model->get_by_id($id);
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        if($this->input->post('date') == null || $this->input->post('date') == ''){
            
            $error_message = 'Sale date can not empty.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }elseif($this->input->post('sp') == null || $this->input->post('sp') == ''){
            
            $error_message = 'Sales person can not empty.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }elseif($this->input->post('cust') == null || $this->input->post('cust') == ''){
            
            $error_message = 'Customer can not empty.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }elseif($this->input->post('site') == null || $this->input->post('site') == '' || $this->input->post('site') == 0){
            
            $error_message = 'Site can not empty.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }elseif($this->input->post('product') == null || $this->input->post('product') == ''){
            
            $error_message = 'Product can not empty.'.$this->input->post('product');
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }elseif($this->input->post('quantity') == null || $this->input->post('quantity') == '' || $this->input->post('quantity') <= 0){
            
            $error_message = 'Quantity can not empty or zero value.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }else{
            $product_no = $this->input->post('product');
            $cust = $this->input->post('cust');
            $site = $this->input->post('site');
            $agreement_id = $this->input->post('price');
            
            $agreement_result = $this->Agreement_model->getAgreementById($agreement_id)->result();
            $price = $agreement_result[0]->price;
            $currency = $agreement_result[0]->currency;
            $rate = $agreement_result[0]->rate;
            
            $data = array(
                    'date' => $this->input->post('date'),
                    'sp_id' => $this->input->post('sp'),
                    'cust_no' => $cust,
                    'site_id' => $site,
                    'product_no' => $product_no,
                    'agreement_id' => $agreement_id,
                    'currency' => $currency,
                    'rate' => $rate,
                    'price' => $price,
                    'quantity' => $this->input->post('quantity'),
                    'total' => $price * $this->input->post('quantity'),
                    'created_by' => $this->session->userdata("username"),
                    'created_date' => date('Y-m-d H:i:s', strtotime('now')),
                    'last_update_by' => $this->session->userdata("username"),
                    'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
                );
            
            $this->Sales_model->save($data);
            echo json_encode(array("status" => TRUE));
//            echo json_encode(array("status" => FALSE, 'error' => $plan_id));
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
        if($this->input->post('date') == null || $this->input->post('date') == ''){
            
            $error_message = 'Sale date can not empty.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }elseif($this->input->post('sp') == null || $this->input->post('sp') == ''){
            
            $error_message = 'Sales person can not empty.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }elseif($this->input->post('cust') == null || $this->input->post('cust') == ''){
            
            $error_message = 'Customer can not empty.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }elseif($this->input->post('site') == null || $this->input->post('site') == '' || $this->input->post('site') == 0){
            
            $error_message = 'Site can not empty.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }elseif($this->input->post('product') == null || $this->input->post('product') == ''){
            
            $error_message = 'Product can not empty.'.$this->input->post('product');
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }elseif($this->input->post('quantity') == null || $this->input->post('quantity') == '' || $this->input->post('quantity') <= 0){
            
            $error_message = 'Quantity can not empty or zero value.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }else{
            $product_no = $this->input->post('product');
            $cust = $this->input->post('cust');
            $site = $this->input->post('site');
            $agreement_id = $this->input->post('price');
            
            $agreement_result = $this->Agreement_model->getAgreementById($agreement_id)->result();
            $price = $agreement_result[0]->price;
            $currency = $agreement_result[0]->currency;
            $rate = $agreement_result[0]->rate;
            
            $data = array(
                    'date' => $this->input->post('date'),
                    'sp_id' => $this->input->post('sp'),
                    'cust_no' => $cust,
                    'site_id' => $site,
                    'product_no' => $product_no,
                    'agreement_id' => $agreement_id,
                    'currency' => $currency,
                    'rate' => $rate,
                    'price' => $price,
                    'quantity' => $this->input->post('quantity'),
                    'total' => $price * $this->input->post('quantity'),
                    'created_by' => $this->session->userdata("username"),
                    'created_date' => date('Y-m-d H:i:s', strtotime('now')),
                    'last_update_by' => $this->session->userdata("username"),
                    'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
                );
            
            $this->Sales_model->update(array('sale_id' => $this->input->post('salesId')), $data);
            
            echo json_encode(array("status" => TRUE));
        }
    }
 
    public function ajax_delete($id)
    {
        $id = str_replace('slash', '/', $id);
        $this->Sales_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
    
    public function upload_sales(){
        $data['page_title'] = 'Upload Sales';
        $data['content'] = $this->load->view('sales/upload_sales', $data, TRUE);
        $this->load->view('form_template', $data);
    }
    
    function getmenuList(){
        echo json_encode($this->Sales_model->getSalesList());
    }
    
    public function download_template(){
        $data['title'] = 'Template Upload Sales';
        $data['content'] = $this->load->view('sales/template_sales', $data, TRUE);
        $this->load->view('blank_page', $data);
    }
    
    public function new_upload_sales(){
        $check = $this->Users_model->getRoleMenu('index.php/Sales');
        
        if(count($check) > 0){
            $data['page_title'] = 'Upload Sales';
            $data['content'] = $this->load->view('sales/new_upload_sales', $data, TRUE);
            $this->load->view('form_template', $data);
        }else{
            $data['title'] = 'Error Page';
        	$data["content"] = $this->load->view('error',$data,true);
            $this->load->view("blank", $data);
        }
        
    }
    
    public function ajax_upload()
    {
        $ViewData=read_file("./csv/log_sales.txt");
        write_file("./csv/log_sales.txt", $ViewData."\n\n".date('Y-m-d H:i:s', strtotime('now'))." by ".$this->session->userdata("username"));
 
        $data = $this->input->post('data');
        
        $row = 1;
        $num_success = 0;
        $num_fail = 0;
        $success = array();
        $fail = array(); 
        $success_sales = array();
        $fail_sales = array();
        $fail_note = array();
        foreach($data as $key=>$field){
            
            if($key > 0){
                $date = trim($field[0]);
                $sp = trim($field[1]);
                $customer = trim($field[2]);
                $site = trim($field[3]);
                $product_no = trim($field[4]);
                $currency = trim($field[5]);
                $price = trim($field[6]);
                $quantity = trim($field[7]);
                $total = trim($field[8]);
                
                $agreement_result = $this->Agreement_model->getAgreementForSales($product_no, $customer, $site, $price, $date);
                $agreement_id = null;
                $rate = 0;
                if(count($agreement_result) > 0){
                    $agreement_id = $agreement_result[0]->agreement_id;
                    $rate = $agreement_result[0]->rate;
                }

                $data_sales = array(
                        'agreement_id' => $agreement_id,
                        'product_no' => $product_no,
                        'quantity' => $quantity,
                        'currency' => $currency,
                        'rate' => $rate,
                        'price' => $price,
                        'total' => $total,
                        'date' => $date,
                        'cust_no' => $customer,
                        'site_id' => $site,
                        'sp_id' => $sp,
                        'created_by' => $this->session->userdata("username"),
                        'created_date' => date('Y-m-d H:i:s', strtotime('now')),
                        'last_update_by' => $this->session->userdata("username"),
                        'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
                );
                
                $check_product = $this->Product_model->getProductById($product_no)->result();

                if(count($check_product) == 0){
                    $fail[$num_fail] = $row;
                    $fail_sales[$num_fail] = $product_no;
                    $fail_note[$num_fail] = 'Product Number does not exist.';
                    $num_fail++;

                    $ViewData=read_file("./csv/log_sales.txt");
                    $text = $ViewData."\n Line ".$row.'. '.$product_no.' Product number does not exist.';
                    write_file("./csv/log_sales.txt", $text);
                }else{
                    $check_customer = $this->Customer_model->getCustomerById($customer)->result();
                    
                    if(count($check_customer) == 0){
                        $fail[$num_fail] = $row;
                        $fail_sales[$num_fail] = $customer;
                        $fail_note[$num_fail] = 'Customer ID does not exist.';
                        $num_fail++;

                        $ViewData=read_file("./csv/log_sales.txt");
                        $text = $ViewData."\n Line ".$row.'. '.$customer.' Customer ID does not exist.';
                        write_file("./csv/log_sales.txt", $text);
                    }else{
                        $check_site = $this->Cust_site_model->getCustSiteById($site)->result();
                        
                        if(count($check_site) == 0){
                            $fail[$num_fail] = $row;
                            $fail_sales[$num_fail] = $site;
                            $fail_note[$num_fail] = 'Customer site does not exist.';
                            $num_fail++;

                            $ViewData=read_file("./csv/log_sales.txt");
                            $text = $ViewData."\n Line ".$row.'. '.$site.' Customer site does not exist.';
                            write_file("./csv/log_sales.txt", $text);
                        }else{
                            $check_sp = $this->Employee_model->getEmployeeById($sp)->result();
                            
                            if(count($check_sp) == 0){
                                $fail[$num_fail] = $row;
                                $fail_sales[$num_fail] = $sp;
                                $fail_note[$num_fail] = 'Sales person ID does not exist.';
                                $num_fail++;

                                $ViewData=read_file("./csv/log_sales.txt");
                                $text = $ViewData."\n Line ".$row.'. '.$sp.' Sales person ID does not exist.';
                                write_file("./csv/log_sales.txt", $text);
                            }else{
                                $check_sales = $this->Sales_model->getSalesData($product_no, $customer, $site, $date, $quantity, $price, $sp);

                                if(count($check_sales) == 0){
                                    $this->Sales_model->save($data_sales);

                                    $success[$num_success] = $row;
                                    $success_sales[$num_success] = $product_no;
                                    $num_success++;
                                }else{
                                    $fail[$num_fail] = $row;
                                    $fail_sales[$num_fail] = $product_no;
                                    $fail_note[$num_fail] = 'Sales already exist.';
                                    $num_fail++;

                                    $ViewData=read_file("./csv/log_sales.txt");
                                    $text = $ViewData."\n Line ".$row.'. '.$product_no.' Sales already exist.';
                                    write_file("./csv/log_sales.txt", $text);
                                }                                    
                            }
                        }
                    }
                }

                $row++;
            }
        }
        
        if($num_fail == 0){
            $ViewData=read_file("./csv/log_sales.txt");
            write_file("./csv/log_sales.txt", $ViewData."\n Upload success.\n".$num_success." row(s) has been uploaded.\n");
        }else{
            $ViewData=read_file("./csv/log_sales.txt");
            write_file("./csv/log_sales.txt", $ViewData."\n".$num_success." row(s) has been uploaded.\n".$num_fail.' row(s) fail to upload.');
        }
        
        $text = $num_success." row(s) has been uploaded.\n".$num_fail." row(s) fail to upload.\nSee log file for detail.";

        echo json_encode(array("status" => TRUE, "text" => $text));
        
    }
    
    public function log_file(){
        $data['title'] = 'Log File Sales';
        $data['content'] = $this->load->view('sales/log_file', $data, TRUE);
        $this->load->view('form_template', $data);
    }
    
}
?>
