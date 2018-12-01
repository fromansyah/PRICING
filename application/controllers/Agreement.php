<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Agreement extends CI_Controller {
    
    public function __construct()
    {
	parent::__construct();
        $this->support_lib->check_login();
        $this->load->library('Dynamic_menu');
        $this->load->helper('file');
        $this->load->helper(array('form', 'url'));
        $this->load->model('Agreement_model', 'Agreement_model');
        $this->load->model('Plan_model', 'Plan_model');
        $this->load->model('Product_model', 'Product_model');
        $this->load->model('Customer_model', 'Customer_model');
        $this->load->model('Cust_site_model', 'Cust_site_model');
        $this->load->model('Employee_model', 'Employee_model');
        $this->load->model('Product_price_model', 'Product_price_model');
        $this->load->model('Master_data_model', 'Master_data_model'); 
    }
    
    public function index(){
        $this->load->helper('url');
        
        $data['page_name'] = 'Agreement Management';
        $data['product_list'] = $this->Product_model->getProductList();
        $data['cust_list'] = $this->Customer_model->getCustomerList();
        $data['site_list'] = array();
        $data['sp_list'] = $this->Employee_model->getEmployeeListByPosition('SP');
        $data['cam_list'] = $this->Employee_model->getEmployeeListByPosition('CAM');
        $data['ba_list'] = $this->Master_data_model->getMasterDataList('BA_TYPE');
        
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
        
        $data['content'] = $this->load->view('agreement/list', $data, TRUE);
        $this->load->view($this->session->userdata("template"), $data);
    }
 
    public function ajax_list()
    {
        $list = $this->Agreement_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $agreement) {

            $no++;
            $row = array();
            $row[] = $agreement->agreement_id;
            $row[] = $agreement->offer_no;
            $row[] = $agreement->agreement_date;
            $row[] = $agreement->sp_id;
            $row[] = $agreement->cam_id;
            $row[] = $agreement->cust_no;
            $row[] = $agreement->site_id;
            $row[] = $agreement->product_no;
            $row[] = '<div align="right">'.number_format($agreement->price, 2).'</div>';
 
            //add html for action
            $button = '<a href=\'#\' onclick="edit_agreement(\''.$agreement->agreement_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'/images/file_edit.png\' title=\'Edit Agreement\'></a>'.'&nbsp&nbsp&nbsp'.
//                      '<a href=\'#\' onclick="view_price(\''.$agreement->agreement_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/view-details.png\' title=\'View Prices\'></a>'.'&nbsp&nbsp&nbsp'.
                      '<a href=\'#\' onclick="delete_agreement(\''.$agreement->agreement_id.'\''.',\''.$agreement->agreement_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'/images/file_delete.png\' title=\'Delete Agreement\'></a>';
            
            $row[] = $button;

            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Agreement_model->count_all(),
                        "recordsFiltered" => $this->Agreement_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($id)
    {
        $id = str_replace('slash', '/', $id);
        $data = $this->Agreement_model->get_by_id($id);
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        if($this->input->post('offerNo') == null || $this->input->post('offerNo') == ''){
            
            $error_message = 'Offer number can not empty.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }elseif($this->input->post('date') == null || $this->input->post('date') == ''){
            
            $error_message = 'Agreement date can not empty.';
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
            
        }elseif($this->input->post('cam') == null || $this->input->post('cam') == ''){
            
            $error_message = 'CAM can not empty.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }elseif($this->input->post('baType') == null || $this->input->post('baType') == ''){
            
            $error_message = 'BA type can not empty.';
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
            $cust = $this->input->post('cust');
            $site = $this->input->post('site');
            $start_date = $this->input->post('startDate');
            $ex_date = explode("-", $start_date);
            //$year = $ex_date[0];
            //$period = $ex_date[1]-1;
	    if($ex_date[1] == 12){
                $year = $ex_date[0]+1;
                $period = 1;
            }else{
                $year = $ex_date[0];
                $period = $ex_date[1]-1;
            }

            $plan_result = $this->Plan_model->getPlanForAgreement($product_no, $cust, $site, $year, $period);
            $plan_id = null;
            if(count($plan_result) > 0){
                $plan_id = $plan_result[0]->plan_id;
            }
            
            $data = array(
                    'offer_no' => $this->input->post('offerNo'),
                    'agreement_date' => $this->input->post('date'),
                    'product_no' => $this->input->post('product'),
                    'cust_no' => $this->input->post('cust'),
                    'site_id' => $this->input->post('site'),
                    'sp_id' => $this->input->post('sp'),
                    'cam_id' => $this->input->post('cam'),
                    'ba_type' => $this->input->post('baType'),
                    'start_date' => $this->input->post('startDate'),
                    'end_date' => $this->input->post('endDate'),
                    'currency' => $this->input->post('currency'),
                    'price' => $this->input->post('price'),
                    'rate' => $this->input->post('rate'),
                    'note' => $this->input->post('note'),
                    'plan_id' => $plan_id,
                    'created_by' => $this->session->userdata("username"),
                    'created_date' => date('Y-m-d H:i:s', strtotime('now')),
                    'last_update_by' => $this->session->userdata("username"),
                    'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
                );
            
            $this->Agreement_model->save($data);
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
            
            $this->Agreement_model->update(array('agreement_id' => $this->input->post('agreementId')), $data);
            
            echo json_encode(array("status" => TRUE));
        }
    }
 
    public function ajax_delete($id)
    {
        $id = str_replace('slash', '/', $id);
        $this->Agreement_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
    
    public function upload_agreement(){
        $data['page_title'] = 'Upload Agreement';
        $data['content'] = $this->load->view('agreement/upload_agreement', $data, TRUE);
        $this->load->view('form_template', $data);
    }
    
    function getmenuList(){
        echo json_encode($this->Agreement_model->getAgreementList());
    }
    
    public function download_template(){
        $data['title'] = 'Template Upload Agreement';
        $data['content'] = $this->load->view('agreement/template_agreement', $data, TRUE);
        $this->load->view('blank_page', $data);
    }
    
    public function new_upload_agreement(){
        $data['page_title'] = 'Upload Agreement';
        $data['content'] = $this->load->view('agreement/new_upload_agreement', $data, TRUE);
        $this->load->view('form_template', $data);
    }
    
    public function ajax_upload()
    {
        $ViewData=read_file("./csv/log_agreement.txt");
        write_file("./csv/log_agreement.txt", $ViewData."\n\n".date('Y-m-d H:i:s', strtotime('now'))." by ".$this->session->userdata("username"));
 
        $data = $this->input->post('data');
        
        $row = 1;
        $num_success = 0;
        $num_fail = 0;
        $success = array();
        $fail = array(); 
        $success_agreement = array();
        $fail_agreement = array();
        $fail_note = array();
        foreach($data as $key=>$field){
            
            if($key > 0){
                $offer_no = trim($field[0]);
                $date = trim($field[1]);
                $product_no = trim($field[2]);
                $customer = trim($field[3]);
                $site = trim($field[4]);
                $sp = trim($field[5]);
                $cam = trim($field[6]);
                $ba_type = trim($field[7]);
                $start_date = trim($field[8]);
                $end_date = trim($field[9]);
                $currency = trim($field[10]);
                $price = trim($field[11]);
                $rate = trim($field[12]);
                $note = trim($field[13]);
                
                $ex_date = explode("-", $start_date);
                $year = $ex_date[0];
                $period = $ex_date[1]-1;

                $plan_result = $this->Plan_model->getPlanForAgreement($product_no, $customer, $site, $year, $period);
                $plan_id = null;
                if(count($plan_result) > 0){
                    $plan_id = $plan_result[0]->plan_id;
                }

                $data_agreement = array(
                        'offer_no' => $offer_no,
                        'agreement_date' => $date,
                        'product_no' => $product_no,
                        'cust_no' => $customer,
                        'site_id' => $site,
                        'sp_id' => $sp,
                        'cam_id' => $cam,
                        'ba_type' => $ba_type,
                        'start_date' => $start_date,
                        'end_date' => $end_date,
                        'currency' => $currency,
                        'price' => $price,
                        'rate' => $rate,
                        'note' => $note,
                        'plan_id' => $plan_id,
                        'created_by' => $this->session->userdata("username"),
                        'created_date' => date('Y-m-d H:i:s', strtotime('now')),
                        'last_update_by' => $this->session->userdata("username"),
                        'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
                );
                
                $check_product = $this->Product_model->getProductById($product_no)->result();

                if(count($check_product) == 0){
                    $fail[$num_fail] = $row;
                    $fail_agreement[$num_fail] = $product_no;
                    $fail_note[$num_fail] = 'Product Number does not exist.';
                    $num_fail++;

                    $ViewData=read_file("./csv/log_agreement.txt");
                    $text = $ViewData."\n Line ".$row.'. '.$product_no.' Product number does not exist.';
                    write_file("./csv/log_agreement.txt", $text);
                }else{
                    $check_customer = $this->Customer_model->getCustomerById($customer)->result();
                    
                    if(count($check_customer) == 0){
                        $fail[$num_fail] = $row;
                        $fail_agreement[$num_fail] = $customer;
                        $fail_note[$num_fail] = 'Customer ID does not exist.';
                        $num_fail++;

                        $ViewData=read_file("./csv/log_agreement.txt");
                        $text = $ViewData."\n Line ".$row.'. '.$customer.' Customer ID does not exist.';
                        write_file("./csv/log_agreement.txt", $text);
                    }else{
                        $check_site = $this->Cust_site_model->getCustSiteById($site)->result();
                        
                        if(count($check_site) == 0){
                            $fail[$num_fail] = $row;
                            $fail_agreement[$num_fail] = $site;
                            $fail_note[$num_fail] = 'Customer site does not exist.';
                            $num_fail++;

                            $ViewData=read_file("./csv/log_agreement.txt");
                            $text = $ViewData."\n Line ".$row.'. '.$site.' Customer site does not exist.';
                            write_file("./csv/log_agreement.txt", $text);
                        }else{
                            $check_sp = $this->Employee_model->getEmployeeById($sp)->result();
                            
                            if(count($check_sp) == 0){
                                $fail[$num_fail] = $row;
                                $fail_agreement[$num_fail] = $sp;
                                $fail_note[$num_fail] = 'Sales person ID does not exist.';
                                $num_fail++;

                                $ViewData=read_file("./csv/log_agreement.txt");
                                $text = $ViewData."\n Line ".$row.'. '.$sp.' Sales person ID does not exist.';
                                write_file("./csv/log_agreement.txt", $text);
                            }else{
                                $check_cam = $this->Employee_model->getEmployeeById($cam)->result();
                                
                                if(count($check_cam) == 0){
                                    $fail[$num_fail] = $row;
                                    $fail_agreement[$num_fail] = $sp;
                                    $fail_note[$num_fail] = 'CAM ID does not exist.';
                                    $num_fail++;

                                    $ViewData=read_file("./csv/log_agreement.txt");
                                    $text = $ViewData."\n Line ".$row.'. '.$sp.' CAM ID does not exist.';
                                    write_file("./csv/log_agreement.txt", $text);
                                }else{
                                    $check_agreement = $this->Agreement_model->getAgreementData($offer_no, $product_no, $customer, $site, $date, $price, $sp, $cam);

                                    if(count($check_agreement) == 0){
                                        $this->Agreement_model->save($data_agreement);

                                        $success[$num_success] = $row;
                                        $success_agreement[$num_success] = $product_no;
                                        $num_success++;
                                    }else{
                                        $fail[$num_fail] = $row;
                                        $fail_agreement[$num_fail] = $product_no;
                                        $fail_note[$num_fail] = 'Agreement already exist.';
                                        $num_fail++;

                                        $ViewData=read_file("./csv/log_agreement.txt");
                                        $text = $ViewData."\n Line ".$row.'. '.$product_no.' Agreement already exist.';
                                        write_file("./csv/log_agreement.txt", $text);
                                    }                                    
                                }
                            }
                        }
                    }
                }

                $row++;
            }
        }
        
        if($num_fail == 0){
            $ViewData=read_file("./csv/log_agreement.txt");
            write_file("./csv/log_agreement.txt", $ViewData."\n Upload success.\n".$num_success." row(s) has been uploaded.\n");
        }else{
            $ViewData=read_file("./csv/log_agreement.txt");
            write_file("./csv/log_agreement.txt", $ViewData."\n".$num_success." row(s) has been uploaded.\n".$num_fail.' row(s) fail to upload.');
        }
        
        $text = $num_success." row(s) has been uploaded.\n".$num_fail." row(s) fail to upload.\nSee log file for detail.";

        echo json_encode(array("status" => TRUE, "text" => $text));
        
    }
    
    public function log_file(){
        $data['title'] = 'Log File Agreement';
        $data['content'] = $this->load->view('agreement/log_file', $data, TRUE);
        $this->load->view('form_template', $data);
    }
    
    public function getAgreementListForSale($cust_no, $site_id, $product_no){
        
        $product_no = str_replace('slash', '/', $product_no);
        
        echo json_encode($this->Agreement_model->getAgreementListForSale($product_no, $cust_no, $site_id));
    }
    
}
?>
