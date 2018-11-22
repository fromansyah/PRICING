<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Software extends CI_Controller {
    
    public function __construct()
    {
	parent::__construct();
        $this->support_lib->check_login();
        $this->load->library('Dynamic_menu');
        $this->load->model('Software_model', 'Software');
        $this->load->model('Assets_model','Assets');
        $this->load->model('Employee_model', 'Employee');
        $this->load->model('Master_data_model', 'Master_data');
    }
    
    public function index(){
        $this->load->helper('url');
        
        $data['page_name'] = 'IT Software';
        
        $data['content'] = $this->load->view('software/list', $data, TRUE);
        $this->load->view($this->session->userdata("template"), $data);
    }
 
    public function ajax_list()
    {
        $list = $this->Software->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $log) {

            $no++;
            $row = array();
            $row[] = $log->id;
            $row[] = $log->barcode;
            $row[] = $log->software_name;
            $row[] = $log->expire_date;
            $row[] = $log->desc;
 
            //add html for action
            $button = '<a href=\'#\' onclick="edit_sw(\''.$log->id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/file_edit.png\'></a>'.'&nbsp&nbsp&nbsp'.
                      '<a href=\'#\' onclick="delete_sw(\''.$log->id.'\''.',\''.$log->software_name.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/file_delete.png\'></a>';
            
            $row[] = $button;

            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Software->count_all(),
                        "recordsFiltered" => $this->Software->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($id)
    {
        $data = $this->Software->get_by_id($id);
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        if($this->input->post('softwareName') == null || $this->input->post('softwareName') == ''){
            
            $error_message = 'Software name can not empty.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }elseif($this->input->post('buyDate') == null || $this->input->post('buyDate') == ''){
            
            $error_message = 'Buy date can not empty.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }elseif($this->input->post('price') == null || $this->input->post('price') == ''){
            
            $error_message = 'Price can not empty.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }elseif($this->input->post('desc') == null || $this->input->post('desc') == ''){
            
            $error_message = 'Description can not empty.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }else{
            $barcode = $this->get_barcode('SW',5,$this->input->post('buyDate'));

            $counter_result = $this->Software->getCounter();
            $counter = $counter_result[0]->counter + 1;
            
            $data = array(
                    'barcode' => $barcode,
                    'software_name' => $this->input->post('softwareName'),
                    'price' => $this->input->post('price'),
                    'currency' => $this->input->post('currency'),
                    'rate' => $this->input->post('rate'),
                    'buy_date' => $this->input->post('buyDate'),
                    'expire_date' => $this->input->post('exipreDate'),
                    'desc' => $this->input->post('desc'),
                    'note' => $this->input->post('note'),
                    'counter' => $counter,
                    'created_by' => $this->session->userdata("username"),
                    'created_date' => date('Y-m-d H:i:s', strtotime('now')),
                    'last_update_by' => $this->session->userdata("username"),
                    'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
                );
            
            $this->Software->save($data);
            echo json_encode(array("status" => TRUE));
//            echo json_encode(array("status" => FALSE, 'error' => $barcode));
        }
    }
 
    public function ajax_update()
    {
        if($this->input->post('softwareName') == null || $this->input->post('softwareName') == ''){
            
            $error_message = 'Software name can not empty.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }elseif($this->input->post('buyDate') == null || $this->input->post('buyDate') == ''){
            
            $error_message = 'Buy date can not empty.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }elseif($this->input->post('price') == null || $this->input->post('price') == ''){
            
            $error_message = 'Price can not empty.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }elseif($this->input->post('desc') == null || $this->input->post('desc') == ''){
            
            $error_message = 'Description can not empty.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }else{
            $data = array(
                    'software_name' => $this->input->post('softwareName'),
                    'price' => $this->input->post('price'),
                    'currency' => $this->input->post('currency'),
                    'rate' => $this->input->post('rate'),
                    'buy_date' => $this->input->post('buyDate'),
                    'expire_date' => $this->input->post('exipreDate'),
                    'desc' => $this->input->post('desc'),
                    'note' => $this->input->post('note'),
                    'last_update_by' => $this->session->userdata("username"),
                    'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
                );
            
            $this->Software->update(array('id' => $this->input->post('softwareId')), $data);
            
            echo json_encode(array("status" => TRUE));
        }
    }
 
    public function ajax_delete($id)
    {
        $this->Software->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
    
    function getmenuList(){
        echo json_encode($this->Software->getMenuList());
    }
    
    function get_barcode($category, $dept, $date){
        $explode_purchase_date = explode('-', $date);
        $p_date = $explode_purchase_date[2];
        $p_month = $explode_purchase_date[1];
        $p_year = $explode_purchase_date[0];
        
        $counter_result = $this->Software->getCounter();
        $counter = $counter_result[0]->counter + 1;
        
        $str_counter = '0000';
        if($counter < 10){
            $str_counter = $str_counter.$counter;
        }elseif($counter >= 10 && $counter < 100){
            $str_counter = substr ($str_counter, 0, 3).$counter;
        }elseif($counter >= 100 && $counter < 1000){
            $str_counter = substr ($str_counter, 0, 2).$counter;
        }elseif($counter >= 1000 && $counter < 10000){
            $str_counter = substr ($str_counter, 0, 1).$counter;
        }else{
            $str_counter = $counter;
        }
        
        $detp_str = '0';
        if($dept < 10){
            $detp_str = $detp_str.$dept;
        }else{
            $detp_str = $dept;
        }
        
        $barcode = $p_month.$p_date.substr($p_year,-2).'/'.$detp_str.'/'.$category.'/'.$str_counter;
        
        return $barcode;
    }
}
?>
