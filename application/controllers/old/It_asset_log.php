<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class It_asset_log extends CI_Controller {
    
    public function __construct()
    {
	parent::__construct();
        $this->support_lib->check_login();
        $this->load->library('Dynamic_menu');
        $this->load->model('It_asset_log_model', 'It_asset_log');
        $this->load->model('Assets_model','Assets');
        $this->load->model('Employee_model', 'Employee');
        $this->load->model('Master_data_model', 'Master_data');
    }
    
    public function index(){
        $this->load->helper('url');
        
        $data['page_name'] = 'IT Asset Log';
        $data['employee_list'] = $this->Employee->getAllEmployeeActiveList();
        $data['it_employee_list'] = $this->Employee->getItEmployeeActiveList();
        $data['asset_list'] = $this->Assets->getItAssetList();
        $data['log_type_list'] = $this->Master_data->getMasterDataList('LOG_TYPE');
        $data['log_status_list'] = $this->Master_data->getMasterDataList('LOG_STATUS');
        
        $data['content'] = $this->load->view('it_asset_log/list', $data, TRUE);
        $this->load->view($this->session->userdata("template"), $data);
    }
 
    public function ajax_list()
    {
        $list = $this->It_asset_log->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $log) {

            $no++;
            $row = array();
            $row[] = $log->id;
            $row[] = $log->asset_barcode;
            $row[] = $log->asset_name;
            $row[] = $log->type_name;
            $row[] = $log->desc;
            $row[] = $log->date;
            $row[] = $log->status_name;
 
            //add html for action
            $button = '<a href=\'#\' onclick="edit_log(\''.$log->id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/file_edit.png\'></a>'.'&nbsp&nbsp&nbsp'.
                      '<a href=\'#\' onclick="done_log(\''.$log->id.'\''.',\''.$log->asset_barcode.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/approved_2.png\'></a>'.'&nbsp&nbsp&nbsp'.
                      '<a href=\'#\' onclick="delete_log(\''.$log->id.'\''.',\''.$log->asset_barcode.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/file_delete.png\'></a>';
            
            if($log->status==3){
                $button = '<a href=\'#\' onclick="edit_log(\''.$log->id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/file_edit.png\'></a>'.'&nbsp&nbsp&nbsp'.
                      '<a href=\'#\' onclick="delete_log(\''.$log->id.'\''.',\''.$log->asset_barcode.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/file_delete.png\'></a>';
            }
            
            $row[] = $button;

            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->It_asset_log->count_all(),
                        "recordsFiltered" => $this->It_asset_log->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($id)
    {
        $data = $this->It_asset_log->get_by_id($id);
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        if($this->input->post('date') == null || $this->input->post('date') == ''){
            
            $error_message = 'Date can not empty.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }elseif($this->input->post('desc') == null || $this->input->post('desc') == ''){
            
            $error_message = 'Description can not empty.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }else{
            $asset_result = $this->Assets->getAssetById($this->input->post('assetId'))->result();
            $asset_barcode = $asset_result[0]->barcode;
            $asset_name = $asset_result[0]->name;
            
            $type_name = $this->Master_data->getMasterDataName($this->input->post('type'), 'LOG_TYPE');
            $status_name = $this->Master_data->getMasterDataName($this->input->post('status'), 'LOG_STATUS');
            
            $data = array(
                    'type' => $this->input->post('type'),
                    'type_name' => $type_name,
                    'asset_id' => $this->input->post('assetId'),
                    'asset_barcode' => $asset_barcode,
                    'asset_name' => $asset_name,
                    'requestor' => $this->input->post('requestor'),
                    'pic' => $this->input->post('pic'),
                    'desc' => $this->input->post('desc'),
                    'date' => $this->input->post('date'),
                    'note' => $this->input->post('note'),
                    'status' => $this->input->post('status'),
                    'status_name' => $status_name,
                    'created_by' => $this->session->userdata("username"),
                    'created_date' => date('Y-m-d H:i:s', strtotime('now')),
                    'last_update_by' => $this->session->userdata("username"),
                    'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
                );
            
            $this->It_asset_log->save($data);
            echo json_encode(array("status" => TRUE));
//            echo json_encode(array("status" => FALSE, 'error' => $status_name));
        }
    }
 
    public function ajax_update()
    {
        if($this->input->post('date') == null || $this->input->post('date') == ''){
            
            $error_message = 'Date can not empty.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }elseif($this->input->post('desc') == null || $this->input->post('desc') == ''){
            
            $error_message = 'Description can not empty.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }else{
            $asset_result = $this->Assets->getAssetById($this->input->post('assetId'))->result();
            $asset_barcode = $asset_result[0]->barcode;
            $asset_name = $asset_result[0]->name;
            
            $type_name = $this->Master_data->getMasterDataName($this->input->post('type'), 'LOG_TYPE');
            $status_name = $this->Master_data->getMasterDataName($this->input->post('status'), 'LOG_STATUS');
            
            $data = array(
                    'type' => $this->input->post('type'),
                    'type_name' => $type_name,
                    'asset_id' => $this->input->post('assetId'),
                    'asset_barcode' => $asset_barcode,
                    'asset_name' => $asset_name,
                    'requestor' => $this->input->post('requestor'),
                    'pic' => $this->input->post('pic'),
                    'desc' => $this->input->post('desc'),
                    'date' => $this->input->post('date'),
                    'note' => $this->input->post('note'),
                    'status' => $this->input->post('status'),
                    'status_name' => $status_name,
                    'created_by' => $this->session->userdata("username"),
                    'created_date' => date('Y-m-d H:i:s', strtotime('now')),
                    'last_update_by' => $this->session->userdata("username"),
                    'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
                );
            
            $this->It_asset_log->update(array('id' => $this->input->post('logId')), $data);
            
            echo json_encode(array("status" => TRUE));
        }
    }
 
    public function ajax_delete($id)
    {
        $this->It_asset_log->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_done($id)
    {
        $data = array(
                    'status' => 3,
                    'status_name' => 'Done',
                    'last_update_by' => $this->session->userdata("username"),
                    'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
                );
            
            $this->It_asset_log->update(array('id' => $id), $data);
            
            echo json_encode(array("status" => TRUE));
    }
    
    function getmenuList(){
        echo json_encode($this->It_asset_log->getMenuList());
    }
}
?>
