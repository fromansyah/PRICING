<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_price extends CI_Controller {
    
    public function __construct()
    {
	parent::__construct();
        $this->support_lib->check_login();
        $this->load->library('Dynamic_menu');
        $this->load->helper('file');
        $this->load->helper(array('form', 'url'));
        $this->load->model('Product_price_model', 'Product_price_model');
        $this->load->model('Product_model', 'Product_model');
        $this->load->model('Users_model', 'Users_model');
    }
    
    public function index(){
        $this->load->helper('url');
        
        $data['page_name'] = 'Product Price Management';
        $data['product_list'] = $this->Product_price_model->getProductPriceList();
        
        $data['content'] = $this->load->view('product_price/list', $data, TRUE);
        $this->load->view($this->session->userdata("template"), $data);
    }
    
    
    
    function lists($product_no) {
        $check = $this->Users_model->getRoleMenu('index.php/Product');
        
        if(count($check) > 0){
            $this->load->helper('url');
        
            $data['product_no'] = $product_no;
            
            $new_product_no = str_replace('slash', '/', $product_no);
            
            $result = $this->Product_model->getProductById($new_product_no)->result();
            $data['product_name'] = $result[0]->product_name;
            
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
            
            $data['page_title'] = 'Product Price';
            $data['content'] = $this->load->view('product_price/list', $data, TRUE);
            $this->load->view($this->session->userdata("template"), $data);
        }else{
            $data['title'] = 'Error Page';
        	$data["content"] = $this->load->view('error',$data,true);
            $this->load->view("blank", $data);
        }
    }
 
    public function ajax_list($product_no)
    {
        $product_no = str_replace('slash', '/', $product_no);
        $list = $this->Product_price_model->get_datatables($product_no);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $product) {

            $no++;
            $row = array();
            $row[] = $product->price_id;
            $row[] = $product->periode_year;
            $row[] = $product->periode_month;
            $row[] = $product->start_date;
            $row[] = $product->end_date;
            $row[] = '<div align="right">'.number_format($product->catalogue_price, 2).'</div>';
 
            //add html for action
            $button = '<a href=\'#\' onclick="edit_price(\''.$product->price_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'/images/file_edit.png\' title=\'Edit Price\'></a>'.'&nbsp&nbsp&nbsp'.
                      '<a href=\'#\' onclick="delete_price(\''.$product->price_id.'\''.',\''.$product->catalogue_price.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'/images/file_delete.png\' title=\'Delete Price\'></a>';
            
            $row[] = $button;

            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Product_price_model->count_all($product_no),
                        "recordsFiltered" => $this->Product_price_model->count_filtered($product_no),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($id)
    {
        $data = $this->Product_price_model->get_by_id($id);
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        if($this->input->post('year') == null || $this->input->post('year') == ''){
            
            $error_message = 'Year can not empty.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }elseif($this->input->post('startDate') == null || $this->input->post('startDate') == ''){
            
            $error_message = 'Start date can not empty or zero value.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }elseif($this->input->post('endDate') == null || $this->input->post('endDate') == ''){
            
            $error_message = 'End date can not empty or zero value.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }elseif($this->input->post('price') == null || $this->input->post('price') == '' || $this->input->post('price') == 0){
            
            $error_message = 'Catalogue price can not empty or zero value.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }else{
            $data = array(
                    'product_no' => $this->input->post('productNo'),
                    'periode_year' => $this->input->post('year'),
                    'periode_month' => $this->input->post('periode'),
                    'start_date' => $this->input->post('startDate'),
                    'end_date' => $this->input->post('endDate'),
                    'catalogue_price' => $this->input->post('price'),
                    'created_by' => $this->session->userdata("username"),
                    'created_date' => date('Y-m-d H:i:s', strtotime('now')),
                    'last_update_by' => $this->session->userdata("username"),
                    'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
                );
            
            $this->Product_price_model->save($data);
            echo json_encode(array("status" => TRUE));
//            echo json_encode(array("status" => FALSE, 'error' => $this->input->post('menuName')));
        }
    }
 
    public function ajax_update()
    {
        if($this->input->post('year') == null || $this->input->post('year') == ''){
            
            $error_message = 'Year can not empty.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }elseif($this->input->post('startDate') == null || $this->input->post('startDate') == ''){
            
            $error_message = 'Start date can not empty or zero value.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }elseif($this->input->post('endDate') == null || $this->input->post('endDate') == ''){
            
            $error_message = 'End date can not empty or zero value.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }elseif($this->input->post('price') == null || $this->input->post('price') == '' || $this->input->post('price') == 0){
            
            $error_message = 'Catalogue price can not empty or zero value.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }else{
            $data = array(
                    'product_no' => $this->input->post('productNo'),
                    'periode_year' => $this->input->post('year'),
                    'periode_month' => $this->input->post('periode'),
                    'start_date' => $this->input->post('startDate'),
                    'end_date' => $this->input->post('endDate'),
                    'catalogue_price' => $this->input->post('price'),
                    'last_update_by' => $this->session->userdata("username"),
                    'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
                );
            
            $this->Product_price_model->update(array('price_id' => $this->input->post('priceId')), $data);
            
            echo json_encode(array("status" => TRUE));
        }
    }
 
    public function ajax_delete($id)
    {
        $id = str_replace('slash', '/', $id);
        $this->Product_price_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
    
    public function upload_price(){
        $data['page_title'] = 'Upload Product Price';
        $data['content'] = $this->load->view('product_price/upload_price', $data, TRUE);
        $this->load->view('form_template', $data);
    }
    
    public function new_upload_price(){
        $data['page_title'] = 'Upload Product Price';
        $data['content'] = $this->load->view('product_price/new_upload_price', $data, TRUE);
        $this->load->view('form_template', $data);
    }
    
    function getmenuList(){
        echo json_encode($this->Product_price_model->getProductPriceList());
    }
    
    public function download_template(){
        $data['data'] = $this->Product_price_model->getTemplatePrice();
        $data['title'] = 'Template Upload Product Price';
        $data['content'] = $this->load->view('product_price/template_price', $data, TRUE);
        $this->load->view('blank_page', $data);
    }
    
    public function log_file(){
        $data['title'] = 'Log File Product Price';
        $data['content'] = $this->load->view('product_price/log_file', $data, TRUE);
        $this->load->view('form_template', $data);
    }
    
    public function ajax_upload()
    {
        $ViewData=read_file("./csv/log_product_price.txt");
        write_file("./csv/log_product_price.txt", $ViewData."\n\n".date('Y-m-d H:i:s', strtotime('now'))." by ".$this->session->userdata("username"));
 
        $data = $this->input->post('data');
        
        $row = 1;
        $num_success = 0;
        $num_fail = 0;
        $success = array();
        $fail = array(); 
        $success_prod = array();
        $fail_prod = array();
        $fail_note = array();
        foreach($data as $key=>$field){
            
            if($key > 0){
                $product_no = trim($field[0]);
                $year = trim($field[1]);
                $periode= trim($field[2]);
                $start_date = trim($field[3]);
                $end_date = trim($field[4]);
                $catalogue_price = trim($field[5]);

                $data_price = array(
                        'product_no' => $product_no,
                        'periode_year' => $year,
                        'periode_month' => $periode,
                        'start_date' => $start_date,
                        'end_date' => $end_date,
                        'catalogue_price' => $catalogue_price,
                        'created_by' => $this->session->userdata("username"),
                        'created_date' => date('Y-m-d H:i:s', strtotime('now')),
                        'last_update_by' => $this->session->userdata("username"),
                        'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
                );

                $check_product = $this->Product_model->getProductById($product_no)->result();

                if(count($check_product)==0){
                    $fail[$num_fail] = $row;
                    $fail_prod[$num_fail] = $product_no;
                    $fail_note[$num_fail] = 'Product Number does not exist.';
                    $num_fail++;

                    $ViewData=read_file("./csv/log_product_price.txt");
                    $text = $ViewData."\n Line ".$row.'. '.$product_no.' Product number does not exist.';
                    write_file("./csv/log_product_price.txt", $text);
                }else{
                    $check = $this->Product_price_model->checkProductPrice($product_no, $year, $periode);

                    if(count($check) == 0){
                        $this->Product_price_model->save($data_price);

                        $success[$num_success] = $row;
                        $success_prod[$num_success] = $product_no;
                        $num_success++;
                    }else{
                        $fail[$num_fail] = $row;
                        $fail_prod[$num_fail] = $product_no;
                        $fail_note[$num_fail] = 'Product price already exist.';
                        $num_fail++;

                        $ViewData=read_file("./csv/log_product_price.txt");
                        $text = $ViewData."\n Line ".$row.'. '.$product_no.' Product price already exist.';
                        write_file("./csv/log_product_price.txt", $text);
                    }
                }

                $row++;
            }
        }
        
        if($num_fail == 0){
            $ViewData=read_file("./csv/log_product_price.txt");
            write_file("./csv/log_product_price.txt", $ViewData."\n Upload success.\n".$num_success." row(s) has been uploaded.\n");
        }else{
            $ViewData=read_file("./csv/log_product_price.txt");
            write_file("./csv/log_product_price.txt", $ViewData."\n".$num_success." row(s) has been uploaded.\n".$num_fail.' row(s) fail to upload.');
        }
        
        $text = $num_success." row(s) has been uploaded.\n".$num_fail." row(s) fail to upload.\nSee log file for detail.";
        
        echo json_encode(array("status" => TRUE, "text" => $text));
        
    }
}
?>
