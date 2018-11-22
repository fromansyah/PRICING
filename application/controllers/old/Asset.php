<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Asset extends CI_Controller {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('flexigrid');
        $this->load->library('flexigrid');
        $this->load->library('Dynamic_menu');
        $this->load->library('pagination');
        $this->load->library('Zend');
        $this->zend->load('Zend/Barcode');
        $this->load->model('Assets_model','Assets');
        $this->load->model('Employee_model', 'Employee');
        $this->load->model('Vendors_model', 'Vendors');
        $this->load->model('Locations_model', 'Locations');
        $this->load->model('Departments_model', 'Departments');
        $this->load->model('Categories_model', 'Categories');
        $this->load->model('Depreciation_model', 'Depreciation');
        $this->load->model('Asset_location_model','AssetLocation');
        $this->load->model('Disposal_model', 'Disposal');
        $this->load->model('Master_data_model', 'Master_data');
        $this->load->model('Installment_model', 'Installment');
    }
 
    public function index()
    {
        $this->load->helper('url');
//        $this->load->view('Asset/list');
        $data['employee_list'] = $this->Employee->getAllEmployeeActiveList();
        $data['location_list'] = $this->Locations->getLocationList();
        $data['installment_status_list'] = $this->Master_data->getMasterDataList('INSTALLMENT_STATUS');
        
        $data['content'] = $this->load->view('asset/list', $data, TRUE);
        $this->load->view($this->session->userdata("template"), $data);
    }
 
    public function ajax_list()
    {
        $list = $this->Assets->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $asset) {
            $status = '';
            if($asset->status == 'A'){
                $status = 'Available';
            }elseif($asset->status == 'N'){
                $status = 'Unavailable';
            }elseif($asset->status == 'D'){
                $status = 'Disposed Off';
            }
            
            $button = '';
            if($asset->status == 'A'){
                if($asset->payment_type == 1){
                    if($asset->payment_status == 1){
                        $button = '<a href=\'#\' data-toggle="tooltip" title="Edit Asset" onclick="edit_asset(\''.$asset->asset_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/file_edit.png\'></a>'.'&nbsp&nbsp&nbsp'.
                          '<a href=\'#\' title="Add Payment" onclick="payment(\''.$asset->asset_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/payment_icon.jpg\'></a>'.'&nbsp&nbsp&nbsp'.
                          '<a href=\'#\' title="Add New Location" onclick="put_location(\''.$asset->asset_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/green-location-icons-17.png\'></a>'.'&nbsp&nbsp&nbsp'.
                          '<a href=\'#\' title="View Payment List" onclick="view_payment(\''.$asset->asset_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/payment_list.png\'></a>'.'&nbsp&nbsp&nbsp'.
                          '<a href=\'#\' title="View Location List" onclick="view_location(\''.$asset->asset_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/locations.png\'></a>'.'&nbsp&nbsp&nbsp'.
                          '<a href=\'#\' title="Disposal" onclick="dispose(\''.$asset->asset_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/trash_icon_a.png\'></a>'.'&nbsp&nbsp&nbsp'.
                          '<a href=\'#\' title="Delete Asset" onclick="delete_asset(\''.$asset->asset_id.'\''.',\''.$asset->name.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/file_delete.png\'></a>';
                    }else{
                        $button = '<a href=\'#\' data-toggle="tooltip" title="Edit Asset" onclick="edit_asset(\''.$asset->asset_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/file_edit.png\'></a>'.'&nbsp&nbsp&nbsp'.
                          '<a href=\'#\' title="Add New Location" onclick="put_location(\''.$asset->asset_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/green-location-icons-17.png\'></a>'.'&nbsp&nbsp&nbsp'.
                          '<a href=\'#\' title="View Payment List" onclick="view_payment(\''.$asset->asset_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/payment_list.png\'></a>'.'&nbsp&nbsp&nbsp'.
                          '<a href=\'#\' title="View Depreciation List" onclick="view_depreciation(\''.$asset->asset_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/081_a.png\'></a>'.'&nbsp&nbsp&nbsp'.
                          '<a href=\'#\' title="View Location List" onclick="view_location(\''.$asset->asset_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/locations.png\'></a>'.'&nbsp&nbsp&nbsp'.
                          '<a href=\'#\' title="Disposal" onclick="dispose(\''.$asset->asset_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/trash_icon_a.png\'></a>'.'&nbsp&nbsp&nbsp'.
                          '<a href=\'#\' title="Delete Asset" onclick="delete_asset(\''.$asset->asset_id.'\''.',\''.$asset->name.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/file_delete.png\'></a>';
                    }
                }else{
                    $button = '<a href=\'#\' data-toggle="tooltip" title="Edit Asset" onclick="edit_asset(\''.$asset->asset_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/file_edit.png\'></a>'.'&nbsp&nbsp&nbsp'.
                          '<a href=\'#\' title="Add New Location" onclick="put_location(\''.$asset->asset_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/green-location-icons-17.png\'></a>'.'&nbsp&nbsp&nbsp'.
                          '<a href=\'#\' title="View Depreciation List" onclick="view_depreciation(\''.$asset->asset_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/081_a.png\'></a>'.'&nbsp&nbsp&nbsp'.
                          '<a href=\'#\' title="View Location List" onclick="view_location(\''.$asset->asset_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/locations.png\'></a>'.'&nbsp&nbsp&nbsp'.
                          '<a href=\'#\' title="Disposal" onclick="dispose(\''.$asset->asset_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/trash_icon_a.png\'></a>'.'&nbsp&nbsp&nbsp'.
                          '<a href=\'#\' title="Delete Asset" onclick="delete_asset(\''.$asset->asset_id.'\''.',\''.$asset->name.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/file_delete.png\'></a>';
                }
                
                
            }elseif($asset->status == 'N'){
                if($asset->payment_type == 1){
                    if($asset->payment_status == 1){
                        $button = '<a href=\'#\' data-toggle="tooltip" title="Edit Asset" onclick="edit_asset(\''.$asset->asset_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/file_edit.png\'></a>'.'&nbsp&nbsp&nbsp'.
                              '<a href=\'#\' title="Add Payment" onclick="payment(\''.$asset->asset_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/payment_icon.jpg\'></a>'.'&nbsp&nbsp&nbsp'.
                              '<a href=\'#\' title="Return Asset" onclick="return_asset(\''.$asset->asset_id.'\''.',\''.$asset->name.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/return_a.jpg\'></a>'.'&nbsp&nbsp&nbsp'.
                              '<a href=\'#\' title="View Payment List" onclick="view_payment(\''.$asset->asset_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/payment_list.png\'></a>'.'&nbsp&nbsp&nbsp'.
                              '<a href=\'#\' title="View Depreciation List" onclick="view_depreciation(\''.$asset->asset_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/081_a.png\'></a>'.'&nbsp&nbsp&nbsp'.
                              '<a href=\'#\' title="View Location List" onclick="view_location(\''.$asset->asset_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/locations.png\'></a>'.'&nbsp&nbsp&nbsp'.
                              '<a href=\'#\' title="Delete Asset" onclick="delete_asset(\''.$asset->asset_id.'\''.',\''.$asset->name.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/file_delete.png\'></a>';
                    }else{
                        $button = '<a href=\'#\' data-toggle="tooltip" title="Edit Asset" onclick="edit_asset(\''.$asset->asset_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/file_edit.png\'></a>'.'&nbsp&nbsp&nbsp'.
                              '<a href=\'#\' title="Return Asset" onclick="return_asset(\''.$asset->asset_id.'\''.',\''.$asset->name.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/return_a.jpg\'></a>'.'&nbsp&nbsp&nbsp'.
                              '<a href=\'#\' title="View Payment List" onclick="view_payment(\''.$asset->asset_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/payment_list.png\'></a>'.'&nbsp&nbsp&nbsp'.
                              '<a href=\'#\' title="View Depreciation List" onclick="view_depreciation(\''.$asset->asset_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/081_a.png\'></a>'.'&nbsp&nbsp&nbsp'.
                              '<a href=\'#\' title="View Location List" onclick="view_location(\''.$asset->asset_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/locations.png\'></a>'.'&nbsp&nbsp&nbsp'.
                              '<a href=\'#\' title="Delete Asset" onclick="delete_asset(\''.$asset->asset_id.'\''.',\''.$asset->name.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/file_delete.png\'></a>';
                    }
                }else{
                    $button = '<a href=\'#\' data-toggle="tooltip" title="Edit Asset" onclick="edit_asset(\''.$asset->asset_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/file_edit.png\'></a>'.'&nbsp&nbsp&nbsp'.
                          '<a href=\'#\' title="Return Asset" onclick="return_asset(\''.$asset->asset_id.'\''.',\''.$asset->name.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/return_a.jpg\'></a>'.'&nbsp&nbsp&nbsp'.
                          '<a href=\'#\' title="View Depreciation List" onclick="view_depreciation(\''.$asset->asset_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/081_a.png\'></a>'.'&nbsp&nbsp&nbsp'.
                          '<a href=\'#\' title="View Location List" onclick="view_location(\''.$asset->asset_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/locations.png\'></a>'.'&nbsp&nbsp&nbsp'.
                          '<a href=\'#\' title="Delete Asset" onclick="delete_asset(\''.$asset->asset_id.'\''.',\''.$asset->name.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/file_delete.png\'></a>';
                }
                
            }elseif($asset->status == 'D'){
                if($asset->payment_type == 1){
                    if($asset->payment_status == 1){
                        $button = '<a href=\'#\' title="Add Payment" onclick="payment(\''.$asset->asset_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/payment_icon.jpg\'></a>'.'&nbsp&nbsp&nbsp'.
                              '<a href=\'#\' title="View Payment List" onclick="view_payment(\''.$asset->asset_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/payment_list.png\'></a>'.'&nbsp&nbsp&nbsp'.
                              '<a href=\'#\' title="View Depreciation List" onclick="view_depreciation(\''.$asset->asset_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/081_a.png\'></a>'.'&nbsp&nbsp&nbsp'.
                              '<a href=\'#\' title="View Location List" onclick="view_location(\''.$asset->asset_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/locations.png\'></a>'.'&nbsp&nbsp&nbsp'.
                              '<a href=\'#\' title="Cancel Disposal" onclick="cancel_dispose(\''.$asset->asset_id.'\''.',\''.$asset->name.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/reuse-icon.png\'></a>';
                    }else{
                        $button = '<a href=\'#\' title="View Payment List" onclick="view_payment(\''.$asset->asset_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/payment_list.png\'></a>'.'&nbsp&nbsp&nbsp'.
                              '<a href=\'#\' title="View Depreciation List" onclick="view_depreciation(\''.$asset->asset_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/081_a.png\'></a>'.'&nbsp&nbsp&nbsp'.
                              '<a href=\'#\' title="View Location List" onclick="view_location(\''.$asset->asset_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/locations.png\'></a>'.'&nbsp&nbsp&nbsp'.
                              '<a href=\'#\' title="Cancel Disposal" onclick="cancel_dispose(\''.$asset->asset_id.'\''.',\''.$asset->name.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/reuse-icon.png\'></a>';
                    }
                }else{
                    $button = '<a href=\'#\' title="View Depreciation List" onclick="view_depreciation(\''.$asset->asset_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/081_a.png\'></a>'.'&nbsp&nbsp&nbsp'.
                              '<a href=\'#\' title="View Location List" onclick="view_location(\''.$asset->asset_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/locations.png\'></a>'.'&nbsp&nbsp&nbsp'.
                              '<a href=\'#\' title="Cancel Disposal" onclick="cancel_dispose(\''.$asset->asset_id.'\''.',\''.$asset->name.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/reuse-icon.png\'></a>';
                }
                
            }
            
            $button = $button.'&nbsp&nbsp&nbsp'.
                      '<a href=\'#\' title="Print barcode" onclick="barcode(\''.$asset->barcode.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/barcode.png\'></a>';
                      
            
            $no++;
            $row = array();
            $row[] = $asset->asset_id;
            $row[] = $asset->barcode;
            $row[] = $asset->name;
            $row[] = $asset->category;
            $row[] = $asset->payment_status_name;
            $row[] = '<div align="center">'.$asset->currency.'</div>';
            $row[] = '<div align="right">'.number_format($asset->value, 2).'</div>';
            $row[] = '['.$asset->status.'] '.$status;
 
            //add html for action
            $row[] = $button;
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Assets->count_all(),
                        "recordsFiltered" => $this->Assets->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($id)
    {
        $data = $this->Assets->get_by_id($id);
        echo json_encode($data);
    }
 
    public function ajax_edit_for_dispose($id)
    {
        $data = $this->Assets->get_by_id_for_dispose($id);
        echo json_encode($data);
    }
 
    public function ajax_edit_for_installment($id)
    {
        $data = $this->Assets->get_by_id_for_installment($id);
        echo json_encode($data);
    }
    
 
    public function ajax_add()
    {
        $data = array(
                'EMP_ID' => $this->input->post('EMPLOYEE_ID'),
                'EMP_INITIAL' => $this->input->post('EMP_INITIAL'),
                'FIRST_NAME' => $this->input->post('firstName'),
                'MIDDLE_NAME' => $this->input->post('middleName'),
                'LAST_NAME' => $this->input->post('lastname'),
                'EMAIL' => $this->input->post('email'),
                'RECORD_STATUS' => $this->input->post('recordStatus'),
            );
        $insert = $this->Assets->save($data);
        echo json_encode(array("status" => TRUE));
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
 
    public function ajax_delete($id)
    {
        $this->Depreciation->deleteDepreciationByAssetId($id);
        $this->AssetLocation->deleteAssetLocationByAssetId($id);
        $this->Installment->deleteInstallmentByAssetId($id);
        $this->Assets->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
    
    public function ajax_cancel_disposal($asset_id){
        
        $data_asset = array(
                    'status' => 'A',
                    'last_update_by' => $this->session->userdata("username"),
                    'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
            );

        $this->Assets->update(array('asset_id' => $asset_id), $data_asset);
            
        $data_depreciation = array(
                    'status' => 'A',
                    'last_update_by' => $this->session->userdata("username"),
                    'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
            );

        $this->Depreciation->updateDepreciation(array('asset_id' => $asset_id), $data_depreciation);
        
        $this->Disposal->delete_by_asset_id($asset_id);
            
        echo json_encode(array("status" => TRUE));
    }
    
    function add()
    {
        $data['employee_list'] = $this->Employee->getAllEmployeeActiveList();
        $data['category_list'] = $this->Categories->getAllCategoryList();
        $data['vendor_list'] = $this->Vendors->getAllVendorList();
        $data['dept_list'] = $this->Departments->getAllDepartmentList();
        $data['payment_type_list'] = $this->Master_data->getMasterDataList('PAYMENT_TYPE');
        
        $data['page_title'] = 'Add Location';
        $data['content'] = $this->load->view('Asset/add', $data, TRUE);
        $this->load->view('form_template', $data);
    }
    function edit($id = ''){
        $data['employee_list'] = $this->Employee->getAllEmployeeActiveList();
        $data['category_list'] = $this->Categories->getAllCategoryList();
        $data['vendor_list'] = $this->Vendors->getAllVendorList();
        $data['dept_list'] = $this->Departments->getAllDepartmentList();
        $data['payment_type_list'] = $this->Master_data->getMasterDataList('PAYMENT_TYPE');
        
        $result = $this->Assets->getAssetById($id)->result();
        
        $data['asset_id'] = $result[0]->asset_id;
        $data['asset_barcode'] = $result[0]->barcode;
        $data['asset_name'] = $result[0]->name;
        $data['desc'] = $result[0]->description;
        $date_explode = explode('-', $result[0]->date);
        $data['date'] = $date_explode[1].'-'.$date_explode[2].'-'.$date_explode[0];
        $data['category'] = $result[0]->category;
        $data['employee_id'] = $result[0]->employee_id;
        $data['department_id'] = $result[0]->department_id;
        $data['vendor_id'] = $result[0]->vendor_id;
        $data['year_num'] = $result[0]->year_num;
        $data['currency'] = $result[0]->currency;
        $data['rate'] = $result[0]->rate;
        $data['idr_value'] = $result[0]->idr_value;
        $data['value'] = $result[0]->value;
        $data['note'] = $result[0]->note;
        $data['counter'] = $result[0]->counter;
        $data['payment_type'] = $result[0]->payment_type;
        $data['voucher_number'] = $result[0]->voucher_number;
        
        $data['num_installment'] = $this->Installment->checkNumInstallment($result[0]->asset_id);
        
        $data['page_title'] = 'Edit Asset';
        $data['content'] = $this->load->view('asset/edit', $data, TRUE);
        $this->load->view('form_template', $data);
    }
    
    function get_barcode($category, $dept, $date){
        $explode_purchase_date = explode('-', $date);
        $p_date = $explode_purchase_date[1];
        $p_month = $explode_purchase_date[0];
        $p_year = $explode_purchase_date[2];
        
        $counter_result = $this->Assets->getCounter($category, $dept, $p_year);
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
        
        $result['#barcode'] = $p_month.$p_date.substr($p_year,-2).'/'.$detp_str.'/'.$category.'/'.$str_counter;
        
        header('Content-Type: application/x-json; charset=utf-8');
        echo(json_encode($result));
    }
    
    function get_barcode_for_edit($asset_id, $category, $dept, $date){
        $result = $this->Assets->getAssetById($asset_id)->result();
        
        $date_explode = explode('-', $result[0]->date);
        $data['date'] = $date_explode[1].'-'.$date_explode[2].'-'.$date_explode[0];
        $data['category'] = $result[0]->category;
        $data['department_id'] = $result[0]->department_id;
        
        $explode_purchase_date = explode('-', $date);
        $p_date = $explode_purchase_date[1];
        $p_month = $explode_purchase_date[0];
        $p_year = $explode_purchase_date[2];
        
        if($category != $result[0]->category || $dept != $result[0]->department_id || $p_year != $date_explode[0]){
            $counter_result = $this->Assets->getCounter($category, $dept, $p_year);
            $counter = $counter_result[0]->counter + 1;
        }else{
            $counter = $result[0]->counter;
        }
        
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
        
        $result['#barcode'] = $p_month.$p_date.substr($p_year,-2).'/'.$detp_str.'/'.$category.'/'.$str_counter;
        
        header('Content-Type: application/x-json; charset=utf-8');
        echo(json_encode($result));
    }
    
    function save_asset(){
        $name = $this->input->post('name', TRUE);
        $barcode = $this->input->post('barcode', TRUE);
        $category = $this->input->post('category', TRUE);
        $year_num = $this->input->post('year_num', TRUE);
        $purchase_date = $this->input->post('purchase_date', TRUE);
        $currency = $this->input->post('currency', TRUE);
        $rate = $this->input->post('rate', TRUE);
        $value = $this->input->post('value', TRUE);
        $idr_value = $this->input->post('idr_value', TRUE);
        $vendor = $this->input->post('vendor', TRUE);
        $employee = $this->input->post('employee', TRUE);
        $department = $this->input->post('department', TRUE);
        $desc = $this->input->post('desc', TRUE);
        $note = $this->input->post('note', TRUE);
        $payment_type = $this->input->post('payment_type', TRUE);
        $voucher_number = $this->input->post('voucher_number', TRUE);
        
        $explode_purchase_date = explode('-', $purchase_date);
        $p_month = $explode_purchase_date[0];
        $p_year = $explode_purchase_date[2];
        
        $counter_result = $this->Assets->getCounter($category, $department, $p_year);
        $counter = $counter_result[0]->counter + 1;
        
        $emp_name = null;
        if($employee == 0){
            $employee = null;
        }else{
            $emp_name = $this->Employee->getEmpName($employee);
        }
        
        $dept_name = $this->Departments->getDeptName($department);
        
        $vendor_name = null;
        if($vendor == 0){
            $vendor = null;
        }else{
            $vendor_name = $this->Vendors->getVendorName($vendor);
        }
        
        if($payment_type == 2){
        
            $data_asset = array(
                'barcode' => $barcode,
                'name' => $name,
                'description' => $desc,
                'date' => $purchase_date,
                'category' => $category,
                'employee_id' => $employee,
                'emp_name' => $emp_name,
                'department_id' => $department,
                'dept_name' => $dept_name,
                'vendor_id' => $vendor,
                'vendor_name' => $vendor_name,
                'month' => $p_month,
                'year' => $p_year,
                'year_num' => $year_num,
                'currency' => $currency,
                'rate' => $rate,
                'idr_value' => $idr_value,
                'value' => $value,
                'note' => $note,
                'status' => 'A',
                'counter' => $counter,
                'payment_type' => $payment_type,
                'payment_type_name' => 'Cash',
                'payment_status' => 2,
                'payment_status_name' => 'Paid',
                'voucher_number' => $voucher_number,
                'created_by' => $this->session->userdata("username"),
                'created_date' => date('Y-m-d H:i:s', strtotime('now')),
                'last_update_by' => $this->session->userdata("username"),
                'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
            );

            $this->Assets->insertAsset($data_asset);

            $asset_id = $this->Assets->getLastAssetId();

            $this->generate_depreciation($asset_id);
            
        }else{
        
            $data_asset = array(
                'barcode' => $barcode,
                'name' => $name,
                'description' => $desc,
                'date' => $purchase_date,
                'category' => $category,
                'employee_id' => $employee,
                'emp_name' => $emp_name,
                'department_id' => $department,
                'dept_name' => $dept_name,
                'vendor_id' => $vendor,
                'vendor_name' => $vendor_name,
                'month' => $p_month,
                'year' => $p_year,
                'year_num' => $year_num,
                'currency' => $currency,
                'rate' => $rate,
                'idr_value' => $idr_value,
                'value' => $value,
                'note' => $note,
                'status' => 'A',
                'counter' => $counter,
                'payment_type' => $payment_type,
                'payment_type_name' => 'Installment',
                'payment_status' => 1,
                'payment_status_name' => 'Installment',
                'voucher_number' => $voucher_number,
                'created_by' => $this->session->userdata("username"),
                'created_date' => date('Y-m-d H:i:s', strtotime('now')),
                'last_update_by' => $this->session->userdata("username"),
                'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
            );

            $this->Assets->insertAsset($data_asset);
            
        }

        echo json_encode(array('result' => 'true'));
//        echo json_encode(array('result' => 'false', 'keterangan' => $vendor_name));
    }
    
    function generate_depreciation($asset_id){
        $asset_result = $this->Assets->getAssetById($asset_id)->result();
        
        $year_num = $asset_result[0]->year_num;
        $idr_value = $asset_result[0]->idr_value;
        $barcode = $asset_result[0]->barcode;
        $name = $asset_result[0]->name;
        
        $explode_purchase_date = explode('-', $asset_result[0]->date);
        $p_month = $explode_purchase_date[1];
        $p_year = $explode_purchase_date[0];
        
        $num_of_month = $year_num * 12;
        $start_month = intval($p_month);
        $temp = 1;
        $end_year = $p_year-1;
        $end_month = 1;
        $asset_year = array();
        $asset_month = array();
        $year_counter = 0;
        for($i=0;$i<=$year_num;$i++){
            $end_year++;
            if($i == 0){
                $j = $start_month;
            }else{
                $j = 1;
            }
            
            $asset_year[$year_counter] = $end_year;
            $year_counter++;
            
            $month_counter = 0;
            while($j<=12 && $temp<=$num_of_month){
                $end_month = $j;
                $j++;
                if($end_month < 10){
                    $asset_month[$end_year][$month_counter] = '0'.$end_month;
                }else{
                    $asset_month[$end_year][$month_counter] = $end_month;
                }
                
                $temp++;
                $month_counter++;
            }
        }
        
        $dep_counter = 0;
        for($m=0;$m<count($asset_year);$m++){
            if($m == 0){
                $original_value[$m] = $idr_value;
                $depreciation[$m] = $idr_value / 2 / 12 * count($asset_month[$asset_year[$m]]);
            }elseif($m < count($asset_year)-1){
                $original_value[$m] = $original_value[$m-1] - $depreciation[$m-1];
                $depreciation[$m] = $original_value[$m] / 2 / 12 * count($asset_month[$asset_year[$m]]);
            }else{
                $original_value[$m] = $original_value[$m-1] - $depreciation[$m-1];
                $depreciation[$m] = $original_value[$m];
            }
            
            $dep_ori_value[$m][0] = $original_value[$m];
            $dep_value[$m][0] = $depreciation[$m] / count($asset_month[$asset_year[$m]]);
            $dep_balance[$m][0] = $dep_ori_value[$m][0] - $dep_value[$m][0];
            for($n=0;$n<count($asset_month[$asset_year[$m]]);$n++){
                if($n > 0){
                    if($m == count($asset_year)-1 && $n == count($asset_month[$asset_year[$m]])-1){
                        $dep_ori_value[$m][$n] = $dep_ori_value[$m][$n-1] - $dep_value[$m][$n-1];
                        $dep_value[$m][$n] = $dep_ori_value[$m][$n];
                        $dep_balance[$m][$n] = $dep_ori_value[$m][$n] - $dep_value[$m][$n];
                    }else{
                        $dep_ori_value[$m][$n] = $dep_ori_value[$m][$n-1] - $dep_value[$m][$n-1];
                        $dep_value[$m][$n] = $depreciation[$m] / count($asset_month[$asset_year[$m]]);
                        $dep_balance[$m][$n] = $dep_ori_value[$m][$n] - $dep_value[$m][$n];
                    }
                }
                $dep_counter++;
                
                $data_depreciation = array(
                    'asset_id' => $asset_id,
                    'asset_barcode' => $barcode,
                    'asset_name' => $name,
                    'original_value' => $dep_ori_value[$m][$n],
                    'depreciation_value' => $dep_value[$m][$n],
                    'balance' => $dep_balance[$m][$n],
                    'month' => $asset_month[$asset_year[$m]][$n],
                    'year' => $asset_year[$m],
                    'counter' => $dep_counter,
                    'status' => 'A',
                    'created_by' => $this->session->userdata("username"),
                    'created_date' => date('Y-m-d H:i:s', strtotime('now')),
                    'last_update_by' => $this->session->userdata("username"),
                    'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
                    );
                
                $this->Depreciation->insertDepreciation($data_depreciation);
            }
        }
    }
    
    function update_asset(){
        $id = $this->input->post('id', TRUE);
        $name = $this->input->post('name', TRUE);
        $barcode = $this->input->post('barcode', TRUE);
        $category = $this->input->post('category', TRUE);
        $year_num = $this->input->post('year_num', TRUE);
        $purchase_date = $this->input->post('purchase_date', TRUE);
        $currency = $this->input->post('currency', TRUE);
        $rate = $this->input->post('rate', TRUE);
        $value = $this->input->post('value', TRUE);
        $idr_value = $this->input->post('idr_value', TRUE);
        $vendor = $this->input->post('vendor', TRUE);
        $employee = $this->input->post('employee', TRUE);
        $department = $this->input->post('department', TRUE);
        $desc = $this->input->post('desc', TRUE);
        $note = $this->input->post('note', TRUE);
        $voucher_number = $this->input->post('voucher_number', TRUE);
        
        $barcode_explode = explode('/', $barcode);
        $counter = intval($barcode_explode[3]);
        
        
        $explode_purchase_date = explode('-', $purchase_date);
        $p_month = $explode_purchase_date[0];
        $p_year = $explode_purchase_date[2];
        
        $emp_name = null;
        if($employee == 0){
            $employee = null;
        }else{
            $emp_name = $this->Employee->getEmpName($employee);
        }
        
        $dept_name = $this->Departments->getDeptName($department);
        
        $vendor_name = null;
        if($vendor == 0){
            $vendor = null;
        }else{
            $vendor_name = $this->Vendors->getVendorName($vendor);
        }
        
        $data_asset = array(
            'barcode' => $barcode,
            'name' => $name,
            'description' => $desc,
            'date' => $purchase_date,
            'category' => $category,
            'employee_id' => $employee,
            'emp_name' => $emp_name,
            'department_id' => $department,
            'dept_name' => $dept_name,
            'vendor_id' => $vendor,
            'vendor_name' => $vendor_name,
            'month' => $p_month,
            'year' => $p_year,
            'year_num' => $year_num,
            'currency' => $currency,
            'rate' => $rate,
            'idr_value' => $idr_value,
            'value' => $value,
            'note' => $note,
            'counter' => $counter,
            'voucher_number' => $voucher_number,
            'last_update_by' => $this->session->userdata("username"),
            'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
        );

        $result = $this->Assets->updateAsset(array('asset_id' => $id), $data_asset);
        
        $this->Depreciation->deleteDepreciationByAssetId($id);

        $this->generate_depreciation($id);
        
        $data_asset_location = array(
            'asset_barcode' => $barcode,
            'asset_name' => $name,
            'last_update_by' => $this->session->userdata("username"),
            'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
        );
        
        $this->AssetLocation->update(array('asset_id' => $id), $data_asset_location);
        
        if ($result > 0) {
          echo json_encode(array('result' => 'true'));
        } else {
          echo json_encode(array('result' => 'false'));
        }
//        echo json_encode(array('result' => 'false', 'keterangan' => $asset_id));
    }
    
    function generate_barcode($barcode){
        $new_barcode = str_replace(":","/",$barcode);
        $barcodeOptions = array('text' => $new_barcode);
        $rendererOptions = array('imageType'          =>'png', 
                                 'horizontalPosition' => 'center', 
                                 'verticalPosition'   => 'middle');
        $imageResource= Zend_Barcode::factory('code39', 'image', $barcodeOptions, $rendererOptions)->render();
        return $imageResource;  
//        echo json_encode(array("status" => FALSE, "error"=>$barcode));
    }
    
    function upload_asset(){
        $name = $this->input->post('name', TRUE);
        $barcode = $this->input->post('barcode', TRUE);
        $category = $this->input->post('category', TRUE);
        $year_num = $this->input->post('year_num', TRUE);
        $purchase_date = $this->input->post('purchase_date', TRUE);
        $currency = $this->input->post('currency', TRUE);
        $rate = $this->input->post('rate', TRUE);
        $value = $this->input->post('value', TRUE);
        $idr_value = $this->input->post('idr_value', TRUE);
        $vendor = $this->input->post('vendor', TRUE);
        $employee = $this->input->post('employee', TRUE);
        $department = $this->input->post('department', TRUE);
        $desc = $this->input->post('desc', TRUE);
        $note = $this->input->post('note', TRUE);
        $payment_type = $this->input->post('payment_type', TRUE);
        $voucher_number = $this->input->post('voucher_number', TRUE);
        
        $explode_purchase_date = explode('-', $purchase_date);
        $p_month = $explode_purchase_date[0];
        $p_year = $explode_purchase_date[2];
        
        $counter_result = $this->Assets->getCounter($category, $department, $p_year);
        $counter = $counter_result[0]->counter + 1;
        
        $emp_name = null;
        if($employee == 0){
            $employee = null;
        }else{
            $emp_name = $this->Employee->getEmpName($employee);
        }
        
        $dept_name = $this->Departments->getDeptName($department);
        
        $vendor_name = null;
        if($vendor == 0){
            $vendor = null;
        }else{
            $vendor_name = $this->Vendors->getVendorName($vendor);
        }
        
        if($payment_type == 2){
        
            $data_asset = array(
                'barcode' => $barcode,
                'name' => $name,
                'description' => $desc,
                'date' => $purchase_date,
                'category' => $category,
                'employee_id' => $employee,
                'emp_name' => $emp_name,
                'department_id' => $department,
                'dept_name' => $dept_name,
                'vendor_id' => $vendor,
                'vendor_name' => $vendor_name,
                'month' => $p_month,
                'year' => $p_year,
                'year_num' => $year_num,
                'currency' => $currency,
                'rate' => $rate,
                'idr_value' => $idr_value,
                'value' => $value,
                'note' => $note,
                'status' => 'A',
                'counter' => $counter,
                'payment_type' => $payment_type,
                'payment_type_name' => 'Cash',
                'payment_status' => 2,
                'payment_status_name' => 'Paid',
                'voucher_number' => $voucher_number,
                'created_by' => $this->session->userdata("username"),
                'created_date' => date('Y-m-d H:i:s', strtotime('now')),
                'last_update_by' => $this->session->userdata("username"),
                'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
            );

            $this->Assets->insertAsset($data_asset);

            $asset_id = $this->Assets->getLastAssetId();

            $this->generate_depreciation($asset_id);
            
        }else{
        
            $data_asset = array(
                'barcode' => $barcode,
                'name' => $name,
                'description' => $desc,
                'date' => $purchase_date,
                'category' => $category,
                'employee_id' => $employee,
                'emp_name' => $emp_name,
                'department_id' => $department,
                'dept_name' => $dept_name,
                'vendor_id' => $vendor,
                'vendor_name' => $vendor_name,
                'month' => $p_month,
                'year' => $p_year,
                'year_num' => $year_num,
                'currency' => $currency,
                'rate' => $rate,
                'idr_value' => $idr_value,
                'value' => $value,
                'note' => $note,
                'status' => 'A',
                'counter' => $counter,
                'payment_type' => $payment_type,
                'payment_type_name' => 'Installment',
                'payment_status' => 1,
                'payment_status_name' => 'Installment',
                'voucher_number' => $voucher_number,
                'created_by' => $this->session->userdata("username"),
                'created_date' => date('Y-m-d H:i:s', strtotime('now')),
                'last_update_by' => $this->session->userdata("username"),
                'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
            );

            $this->Assets->insertAsset($data_asset);
            
        }

        echo json_encode(array('result' => 'true'));
//        echo json_encode(array('result' => 'false', 'keterangan' => $vendor_name));
    }
}