<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Asset_location extends CI_Controller {
    
    public function __construct()
    {
	parent::__construct();
        $this->support_lib->check_login();
        $this->load->helper('flexigrid');
        $this->load->library('flexigrid');
        $this->load->library('Dynamic_menu');
        $this->load->library('pagination');
        $this->load->model('Asset_location_model', 'Asset_location_model');
        $this->load->model('Assets_model', 'Assets_model');
        $this->load->model('Employee_model', 'Employee_model');
        $this->load->model('Locations_model', 'Locations_model');
    }
    
    public function index(){
        $this->lists();
    }
    
    function lists($asset_id='') {
        $this->load->helper('url');
        
        $data['employee_list'] = $this->Employee_model->getAllEmployeeActiveList();
        $data['location_list'] = $this->Locations_model->getLocationList();
        
        $data['asset_id'] = $asset_id;
        
        $data['content'] = $this->load->view('asset_location/list', $data, TRUE);
        $this->load->view($this->session->userdata("template"), $data);
    }

    function load_data($asset_location_id) {
        $valid_fields = array('asset_location_id', 'location_name', 'emp_name', 'start_date', 'end_date');

	$this->flexigrid->validate_post('asset_location_id','ASC',$valid_fields);
        
	$records = $this->Asset_location_model->get_asset_location_flexigrid($asset_location_id);

	$this->output->set_header($this->config->item('json_header'));

        $record_items = array();

	foreach ($records['records']->result() as $row)
	{
            $button = '<a href=\'#\' onclick="edit_asset_location(\''.$row->asset_location_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/b_edit.png\'></a>'.'&nbsp&nbsp&nbsp'.
                      '<a href=\'#\' onclick="delete_asset_location(\''.$row->asset_location_id.'\''.',\''.$row->location_name.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/Delete.png\'></a>';
            
            $record_items[] = array(
                $row->asset_location_id,
                $row->asset_location_id,
                $row->location_name,
                $row->emp_name,
                $row->start_date,
                $row->end_date,
                $button
			);
        }
	//Print please
	$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
    }    
    
    function add($asset_location_id = '')
    {
        $data['page_title'] = 'Add Location';
        
        $result = array();
        $hasil = $this->Assets_model->getAssetById($asset_location_id)->result();
        
        $data['asset_id'] = $hasil[0]->asset_id;
        $data['asset_barcode'] = $hasil[0]->barcode;
        $data['asset_name'] = $hasil[0]->name;
        
        $data['employee_list'] = $this->Employee_model->getAllEmployeeActiveList();
        $data['location_list'] = $this->Locations_model->getLocationList();
        
        $data['content'] = $this->load->view('asset_location/put_asset_location', $data, TRUE);
        $this->load->view('form_template', $data);
    }

    function save_asset_location_ajax() {
        $asset_location_id = $this->input->post('asset_id', TRUE);
        $barcode = $this->input->post('barcode', TRUE);
        $name = $this->input->post('name', TRUE);
        $location = $this->input->post('location', TRUE);
        $employee = $this->input->post('employee', TRUE);
        $start_date = $this->input->post('start_date', TRUE);
        $end_date = $this->input->post('end_date', TRUE);
        $desc = $this->input->post('desc', TRUE);
        
        $check_location = $this->Asset_location_model->checkAssetLocation($asset_location_id, $start_date, $end_date);
        
        $check_asset_date = $this->Assets_model->checkAssetDate($asset_location_id, $start_date);
        
        if($check_location == 0 && $check_asset_date == 1){
        
            $location_result = $this->Locations_model->getLocationById($location)->result();
            $location_name = $location_result[0]->location;

            $emp_name = null;
            if($employee == 0){
                $employee = null;
            }else{
                $emp_name = $this->Employee_model->getEmpName($employee);
            }

            $data = array(
                'asset_id' => $asset_location_id,
                'asset_name' => $name,
                'asset_barcode' => $barcode,
                'location_id' => $location,
                'location_name' => $location_name,
                'employee_id' => $employee,
                'emp_name' => $emp_name,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'desc' => $desc,
                'created_by' => $this->session->userdata("username"),
                'created_date' => date('Y-m-d H:i:s', strtotime('now')),
                'last_update_by' => $this->session->userdata("username"),
                'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
            );

            $this->Asset_location_model->insertAssetLocation($data);
            
            $data_asset = array(
                'status' => 'N',
                'last_update_by' => $this->session->userdata("username"),
                'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
            );

            $this->Assets_model->updateAsset(array('asset_id' => $asset_location_id), $data_asset);
        
            echo json_encode(array('result' => 'true'));
            
        }  else {
            
            echo json_encode(array('result' => 'false', 'keterangan' => 'Asset is unavailable.'));
            
        }
    }

    function edit($id = '')
    {
        $hasil = $this->Asset_location_model->getAsset_locationById($id)->result();
        
        $data['asset_location_id'] = $hasil[0]->asset_location_id;
        $data['asset_location_name'] = $hasil[0]->asset_location_name;
        $data['num_of_year'] = $hasil[0]->num_of_year;
        $data['depreciation_percentage'] = $hasil[0]->depreciation_percentage;
        $data['asset_location_desc'] = $hasil[0]->asset_location_desc;
        
        $data['page_title'] = 'Edit Asset_location';
        $data['content'] = $this->load->view('asset_location/edit', $data, TRUE);
        $this->load->view($this->session->userdata("template"), $data);
    }
    
    function update_asset_location_ajax() {
        $id = $this->input->post('id', TRUE);
        $name = $this->input->post('name', TRUE);
        $year_num = $this->input->post('year_num', TRUE);
        $percentage = $this->input->post('percentage', TRUE);
        $desc = $this->input->post('desc', TRUE);

        $data = array(
            'asset_location_name' => $name,
            'num_of_year' => $year_num,
            'depreciation_percentage' => $percentage,
            'asset_location_desc' => $desc,
            'last_update_by' => $this->session->userdata("username"),
            'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
        );


        $result = $this->Asset_location_model->updateAsset_location(array('asset_location_id' => $id), $data);
        if ($result > 0) {
          echo json_encode(array('result' => 'true'));
        } else {
          echo json_encode(array('result' => 'false'));
        }
    }

    function delete($id)
    {
        $this->Asset_location_model->deleteAsset_location($id);
        redirect("Asset_location", 'refresh');
    }
    
    function get_year_asset_location($id){
        $hasil = $this->Asset_location_model->getAsset_locationById($id)->result();
        
        $result['#year_num'] = $hasil[0]->num_of_year;
        
        header('Content-Type: application/x-json; charset=utf-8');
        echo(json_encode($result));
    }
    
    function get_value_for_put_location($asset_location_id){
        $result = array();
        $hasil = $this->Assets_model->getAssetById($asset_location_id)->result();
        
        $result['#asset_id'] = $hasil[0]->asset_id;
        $result['#asset_barcode'] = $hasil[0]->barcode;
        $result['#asset_name'] = $hasil[0]->name;
        
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($result);
    }
    
    function get_value_for_return_asset($asset_location_id){
        $result = array();
//        $hasil = $this->Assets_model->getAssetById($asset_location_id)->result();
        
        $asset_location_loc_id = $this->Asset_location_model->getMaxAssetLocationId($asset_location_id);
        $hasil = $this->Asset_location_model->getAssetLocationById($asset_location_loc_id)->result();
        
        $result['#return_asset_location_id'] = $hasil[0]->asset_location_id;
        $result['#return_asset_id'] = $hasil[0]->asset_id;
        $result['#return_asset_barcode'] = $hasil[0]->asset_barcode;
        $result['#return_asset_name'] = $hasil[0]->asset_name;
        $result['#return_location'] = $hasil[0]->location_name;
        $result['#return_employee'] = $hasil[0]->emp_name;
        $result['#return_start_date'] = $hasil[0]->start_date;
        $result['#return_end_date'] = $hasil[0]->end_date;
        
        header('Content-Type: application/x-json; charset=utf-8');
        echo json_encode($result);
    }
    
    function get_return_asset($asset_location_id){
        $asset_location_loc_id = $this->Asset_location_model->getMaxAssetLocationId($asset_location_id);
        $hasil = $this->Asset_location_model->getAssetLocationById($asset_location_loc_id)->result();
        
        $data['return_asset_location_id'] = $hasil[0]->asset_location_id;
        $data['return_asset_id'] = $hasil[0]->asset_id;
        $data['return_asset_barcode'] = $hasil[0]->asset_barcode;
        $data['return_asset_name'] = $hasil[0]->asset_name;
        $data['return_location'] = $hasil[0]->location_name;
        $data['return_employee'] = $hasil[0]->emp_name;
        $explode_start_date = explode('-', $hasil[0]->start_date);
        $data['return_start_date'] = $explode_start_date[1].'-'.$explode_start_date[2].'-'.$explode_start_date[0];
        $explode_end_date = explode('-', $hasil[0]->end_date);
        $data['return_end_date'] = $explode_end_date[1].'-'.$explode_end_date[2].'-'.$explode_end_date[0];
        
        
        $data['employee_list'] = $this->Employee_model->getAllEmployeeActiveList();
        $data['location_list'] = $this->Locations_model->getLocationList();
        
        $data['content'] = $this->load->view('asset_location/return_asset', $data, TRUE);
        $this->load->view('form_template', $data);
    }
    
    function return_asset(){
        $asset_location_location_id = $this->input->post('asset_location_id', TRUE);
        $asset_location_id = $this->input->post('asset_id', TRUE);
        $end_date = $this->input->post('end_date', TRUE);
        $note = $this->input->post('note', TRUE);
        
        $data = array(
                'end_date' => $end_date,
                'note' => $note,
                'last_update_by' => $this->session->userdata("username"),
                'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
            );
        
        $result = $this->Asset_location_model->updateAssetLocation(array('asset_location_id' => $asset_location_location_id), $data);
        
        $data_asset = array(
                'status' => 'A',
                'last_update_by' => $this->session->userdata("username"),
                'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
            );

       $this->Assets_model->updateAsset(array('asset_id' => $asset_location_id), $data_asset);
        
        if ($result > 0) {
          echo json_encode(array('result' => 'true'));
        } else {
          echo json_encode(array('result' => 'false'));
        }
    }
    
    public function ajax_add()
    {
        $asset_location_id = $this->input->post('assetId', TRUE);
        $start_date = $this->input->post('startDate', TRUE);
        $end_date = $this->input->post('endDate', TRUE);
        
//        echo json_encode(array("status" => FALSE, 'error' => $this->input->post('assetBarcode')));
        
        if($start_date == null || $start_date == ''){
            
            echo json_encode(array("status" => FALSE, 'error' => 'Start date can not empty.'));
            
        }elseif($end_date == null || $end_date == ''){
            
            echo json_encode(array("status" => FALSE, 'error' => 'End date can not empty.'));
            
        }else{
            $check_location = $this->Asset_location_model->checkAssetLocation($asset_location_id, $start_date, $end_date);
        
            $check_asset_date = $this->Assets_model->checkAssetDate($asset_location_id, $start_date);

            if($check_location == 0 && $check_asset_date == 1){

                $location_result = $this->Locations_model->getLocationById($this->input->post('location'))->result();
                $location_name = $location_result[0]->location;

                $emp_name = null;
                $employee = $this->input->post('employeeId');
                if($employee == 0){
                    $employee = null;
                }else{
                    $emp_name = $this->Employee_model->getEmpName($employee);
                }

                $data = array(
                        'asset_id' => $this->input->post('assetId'),
                        'asset_name' => $this->input->post('assetName'),
                        'asset_barcode' => $this->input->post('assetBarcode'),
                        'location_id' => $this->input->post('location'),
                        'location_name' => $location_name,
                        'employee_id' => $this->input->post('employeeId'),
                        'emp_name' => $emp_name,
                        'start_date' => $this->input->post('startDate'),
                        'end_date' => $this->input->post('endDate'),
                        'desc' => $this->input->post('desc'),
                        'created_by' => $this->session->userdata("username"),
                        'created_date' => date('Y-m-d H:i:s', strtotime('now')),
                        'last_update_by' => $this->session->userdata("username"),
                        'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
                    );
                
                $insert = $this->Asset_location_model->save($data);
                
                $data_asset = array(
                    'status' => 'N',
                    'last_update_by' => $this->session->userdata("username"),
                    'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
                );

                $this->Assets_model->updateAsset(array('asset_id' => $asset_location_id), $data_asset);
            
                echo json_encode(array("status" => TRUE));
            }else{
                echo json_encode(array("status" => FALSE, 'error' => 'Asset is unavailable.'));
            }
        }
    }
    
    public function ajax_return()
    {
        $end_date = $this->input->post('returnEndDate', TRUE);
        
//        echo json_encode(array("status" => FALSE, 'error' => $this->input->post('assetBarcode')));
        
        if($end_date == null || $end_date == ''){
            
            echo json_encode(array("status" => FALSE, 'error' => 'End date can not empty.'));
            
        }else{
            $data = array(
                        'end_date' => $this->input->post('returnEndDate'),
                        'note' => $this->input->post('returnNote'),
                        'last_update_by' => $this->session->userdata("username"),
                        'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
                    );
                
            $this->Asset_location_model->update(array('asset_location_id' => $this->input->post('returnAssetLocationId')), $data);
                
            $data_asset = array(
                    'status' => 'A',
                    'last_update_by' => $this->session->userdata("username"),
                    'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
                );

            $this->Assets_model->updateAsset(array('asset_id' => $this->input->post('returnAssetId')), $data_asset);
            
            echo json_encode(array("status" => TRUE));

        }
    }
    
    public function ajax_update()
    {
        $data = array(
                'firstName' => $this->input->post('firstName'),
                'lastName' => $this->input->post('lastName'),
                'gender' => $this->input->post('gender'),
                'address' => $this->input->post('address'),
                'dob' => $this->input->post('dob'),
            );
        $this->Assets->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }
    
    public function ajax_edit($asset_location_id)
    {
        $asset_location_loc_id = $this->Asset_location_model->getMaxAssetLocationId($asset_location_id);
        
        $data = $this->Asset_location_model->get_by_id($asset_location_loc_id);
        echo json_encode($data);
    }
 
    public function ajax_edit_location($id)
    {
        $data = $this->Asset_location_model->get_by_id($id);
        echo json_encode($data);
    }
 
    public function ajax_list($asset_id='')
    {
        $result = $this->Assets_model->getAssetById($asset_id)->result();
        $asset_status = $result[0]->status;
        
        $list = $this->Asset_location_model->get_datatables($asset_id);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $asset_location) {
            $button = '';
            
            if($asset_status == 'A'){
                $button = '<a href=\'#\' onclick="edit_asset_location(\''.$asset_location->asset_location_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/file_edit.png\'></a>'.'&nbsp&nbsp&nbsp'.
                          '<a href=\'#\' onclick="delete_asset_location(\''.$asset_location->asset_location_id.'\''.',\''.$asset_location->location_name.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/file_delete.png\'></a>';
            }
            
            $no++;
            $row = array();
            $row[] = $asset_location->location_name;
            $row[] = $asset_location->emp_name;
            $row[] = $asset_location->start_date;
            $row[] = $asset_location->end_date;
            $row[] = $asset_location->desc;
            $row[] = $asset_location->note;
 
            //add html for action
            $row[] = $button;
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Asset_location_model->count_all($asset_id),
                        "recordsFiltered" => $this->Asset_location_model->count_filtered($asset_id),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
    
    public function ajax_delete($id)
    {
        $this->Asset_location_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
}
?>
