<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vendor_type extends CI_Controller {
    
    public function __construct()
    {
	parent::__construct();
        $this->support_lib->check_login();
        $this->load->library('Dynamic_menu');
        $this->load->model('Vendor_type_model', 'Vendor_type_model');
    }
    
    public function index(){
        $this->lists();
    }
    
    function lists() {
        $this->load->helper('url');
        $data['test'] = '';
        
        $data['content'] = $this->load->view('vendor_type/list', $data, TRUE);
        $this->load->view($this->session->userdata("template"), $data);
    }

    public function ajax_list()
    {
        $list = $this->Vendor_type_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $vendor) {

            $no++;
            $row = array();
            $row[] = $vendor->vendor_type_name;
            $row[] = $vendor->desc;
 
            //add html for action
            $button = '<a href=\'#\' onclick="edit_vendor_type(\''.$vendor->vendor_type_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/file_edit.png\'></a>'.'&nbsp&nbsp&nbsp'.
                      '<a href=\'#\' onclick="delete_vendor_type(\''.$vendor->vendor_type_id.'\''.',\''.$vendor->vendor_type_name.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/file_delete.png\'></a>';
            
            $row[] = $button;

            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Vendor_type_model->count_all(),
                        "recordsFiltered" => $this->Vendor_type_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($id)
    {
        $data = $this->Vendor_type_model->get_by_id($id);
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        if($this->input->post('vendorTypeName') == null || $this->input->post('vendorTypeName') == ''){
            $error_message = 'Vendor type name can not empty.';
            
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
        }else{
            $data = array(
                    'vendor_type_name' => $this->input->post('vendorTypeName'),
                    'desc' => $this->input->post('desc'),
                    'created_by' => $this->session->userdata("username"),
                    'created_date' => date('Y-m-d H:i:s', strtotime('now')),
                    'last_update_by' => $this->session->userdata("username"),
                    'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
                );
            
            $insert = $this->Vendor_type_model->save($data);
            echo json_encode(array("status" => TRUE));
        }
    }
 
    public function ajax_update()
    {
        if($this->input->post('vendorTypeName') == null || $this->input->post('vendorTypeName') == ''){
            $error_message = 'Vendor type name can not empty.';
            
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
        }else{
            $data = array(
                    'vendor_type_name' => $this->input->post('vendorTypeName'),
                    'desc' => $this->input->post('desc'),
                    'last_update_by' => $this->session->userdata("username"),
                    'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
                );
            
            $this->Vendor_type_model->update(array('vendor_type_id' => $this->input->post('vendorTypeId')), $data);
            
            echo json_encode(array("status" => TRUE));
        }
    }
 
    public function ajax_delete($id)
    {
        $this->Vendor_type_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
}
?>
