<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {
    
    public function __construct()
    {
	parent::__construct();
        $this->support_lib->check_login();
        $this->load->library('Dynamic_menu');
        $this->load->helper('file');
        $this->load->helper(array('form', 'url'));
        $this->load->model('Product_model', 'Product_model');
    }
    
    public function index(){
        $this->load->helper('url');
        
        $data['page_name'] = 'Product Management';
        $data['product_list'] = $this->Product_model->getProductList();
        
        $data['content'] = $this->load->view('product/list', $data, TRUE);
        $this->load->view($this->session->userdata("template"), $data);
    }
 
    public function ajax_list()
    {
        $list = $this->Product_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $product) {

            $no++;
            $row = array();
            $row[] = $product->product_no;
            $row[] = $product->product_name;
            $row[] = $product->kg_pail;
            $row[] = $product->desc;
 
            //add html for action
            $button = '<a href=\'#\' onclick="edit_product(\''.$product->product_no.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/file_edit.png\' title=\'Edit Product\'></a>'.'&nbsp&nbsp&nbsp'.
                      '<a href=\'#\' onclick="view_price(\''.$product->product_no.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/view-details.png\' title=\'View Prices\'></a>'.'&nbsp&nbsp&nbsp'.
                      '<a href=\'#\' onclick="delete_product(\''.$product->product_no.'\''.',\''.$product->product_name.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/file_delete.png\' title=\'Delete Product\'></a>';
            
            $row[] = $button;

            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Product_model->count_all(),
                        "recordsFiltered" => $this->Product_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($id)
    {
        $id = str_replace('slash', '/', $id);
        $data = $this->Product_model->get_by_id($id);
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        if($this->input->post('productName') == null || $this->input->post('productName') == ''){
            
            $error_message = 'Product name can not empty.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }elseif($this->input->post('kgpail') == null || $this->input->post('kgpail') == '' || $this->input->post('kgpail') == 0){
            
            $error_message = 'Kg/Pail can not empty.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }else{
            $data = array(
                    'product_no' => $this->input->post('productNo'),
                    'product_name' => $this->input->post('productName'),
                    'kg_pail' => $this->input->post('kgpail'),
                    'desc' => $this->input->post('desc'),
                    'created_by' => $this->session->userdata("username"),
                    'created_date' => date('Y-m-d H:i:s', strtotime('now')),
                    'last_update_by' => $this->session->userdata("username"),
                    'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
                );
            
            $this->Product_model->save($data);
            echo json_encode(array("status" => TRUE));
//            echo json_encode(array("status" => FALSE, 'error' => $this->input->post('menuName')));
        }
    }
 
    public function ajax_update()
    {
        if($this->input->post('productName') == null || $this->input->post('productName') == ''){
            
            $error_message = 'Product name can not empty.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }else{
            $data = array(
                    'product_name' => $this->input->post('productName'),
                    'kg_pail' => $this->input->post('kgpail'),
                    'desc' => $this->input->post('desc')
                );
            
            $this->Product_model->update(array('product_no' => $this->input->post('productNo')), $data);
            
            echo json_encode(array("status" => TRUE));
        }
    }
 
    public function ajax_delete($id)
    {
        $id = str_replace('slash', '/', $id);
        $this->Product_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
    
    public function upload_product(){
        $data['page_title'] = 'Upload Product';
        $data['content'] = $this->load->view('product/upload_product', $data, TRUE);
        $this->load->view('form_template', $data);
    }
    
    public function new_upload_product(){
        $data['page_title'] = 'Upload Product';
        $data['content'] = $this->load->view('product/new_upload_product', $data, TRUE);
        $this->load->view('form_template', $data);
    }
    
    function getmenuList(){
        echo json_encode($this->Product_model->getProductList());
    }
    
    public function download_template(){
        $data['title'] = 'Template Upload Product';
        $data['content'] = $this->load->view('product/template_product', $data, TRUE);
        $this->load->view('blank_page', $data);
    }
    
    public function ajax_upload()
    {
        $ViewData=read_file("./csv/log_product.txt");
        write_file("./csv/log_product.txt", $ViewData."\n\n".date('Y-m-d H:i:s', strtotime('now'))." by ".$this->session->userdata("username"));
 
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
                $product_name = $field[1];
                $kg_pail = $field[2];
                $desc = $field[3];

                $data_product = array(
                        'product_no' => $product_no,
                        'product_name' => $product_name,
                        'kg_pail' => $kg_pail,
                        'desc' => $desc,
                        'created_by' => $this->session->userdata("username"),
                        'created_date' => date('Y-m-d H:i:s', strtotime('now')),
                        'last_update_by' => $this->session->userdata("username"),
                        'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
                );

                $check = $this->Product_model->getProductById($product_no)->result();

                if(count($check) == 0){
                    $this->Product_model->save($data_product);
                    $success[$num_success] = $row;
                    $success_prod[$num_success] = $product_no;
                    $num_success++;
                }else{
                    $fail[$num_fail] = $row;
                    $fail_prod[$num_fail] = $product_no;
                    $fail_note[$num_fail] = 'Product number already exist.';
                    $num_fail++;

                    $ViewData=read_file("./csv/log_product.txt");
                    $text = $ViewData."\n Line ".$row.'. '.$product_no.' Product number already exist.';
                    write_file("./csv/log_product.txt", $text);
                }

                $row++;
            }
        }
        
        if($num_fail == 0){
            $ViewData=read_file("./csv/log_product.txt");
            write_file("./csv/log_product.txt", $ViewData."\n Upload success.\n".$num_success." row(s) has been uploaded.\n");
        }else{
            $ViewData=read_file("./csv/log_product.txt");
            write_file("./csv/log_product.txt", $ViewData."\n".$num_success." row(s) has been uploaded.\n".$num_fail.' row(s) fail to upload.');
        }
        
        $text = $num_success." row(s) has been uploaded.\n".$num_fail." row(s) fail to upload.\nSee log file for detail.";
        
        echo json_encode(array("status" => TRUE, "text" => $text));
        
    }
    
    public function log_file(){
        $data['title'] = 'Log File Product';
        $data['content'] = $this->load->view('product/log_file', $data, TRUE);
        $this->load->view('form_template', $data);
    }
}
?>
