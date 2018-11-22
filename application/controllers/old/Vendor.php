<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vendor extends CI_Controller {
    
    public function __construct()
    {
	parent::__construct();
        $this->support_lib->check_login();
        $this->load->helper('flexigrid');
        $this->load->library('flexigrid');
        $this->load->library('Dynamic_menu');
        $this->load->model('Vendors_model', 'Vendors_model');
        $this->load->model('Vendor_type_model', 'Vendor_type_model');
        $this->load->model('Assets_model', 'Assets_model');
    }
    
    public function index()
    {
        $this->load->helper('url');
        $data['type_list'] = $this->Vendor_type_model->getVendorTypeList();
        $data['content'] = $this->load->view('Vendor/list', $data, TRUE);
        $this->load->view($this->session->userdata("template"), $data);
    }
 
    public function ajax_list()
    {
        $list = $this->Vendors_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $vendor) {
            
            $v_type_result = $this->Vendor_type_model->getVendorTypeById($vendor->vendor_type)->result();
            $vendor_type = $v_type_result[0]->vendor_type_name;
            
            $no++;
            $row = array();
            $row[] = $vendor->vendor_name;
            $row[] = $vendor->address;
            $row[] = $vendor->phone;
            $row[] = '['.$vendor->vendor_type.'] '.$vendor_type;
            $row[] = $vendor->desc;
 
            //add html for action
            $button = '<a href=\'#\' onclick="edit_vendor(\''.$vendor->vendor_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/file_edit.png\'></a>'.'&nbsp&nbsp&nbsp'.
                      '<a href=\'#\' onclick="delete_vendor(\''.$vendor->vendor_id.'\''.',\''.$vendor->vendor_name.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/file_delete.png\'></a>';
            
            $row[] = $button;
            
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Vendors_model->count_all(),
                        "recordsFiltered" => $this->Vendors_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($id)
    {
        $data = $this->Vendors_model->get_by_id($id);
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        $data = array(
                'vendor_name' => $this->input->post('vendorName'),
                'address' => $this->input->post('address'),
                'phone' => $this->input->post('phone'),
                'vendor_type' => $this->input->post('vendorType'),
                'desc' => $this->input->post('desc'),
                'created_by' => $this->session->userdata("username"),
                'created_date' => date('Y-m-d H:i:s', strtotime('now')),
                'last_update_by' => $this->session->userdata("username"),
                'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
            );
        $insert = $this->Vendors_model->save($data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
    {
        $data = array(
                'vendor_name' => $this->input->post('vendorName'),
                'address' => $this->input->post('address'),
                'phone' => $this->input->post('phone'),
                'vendor_type' => $this->input->post('vendorType'),
                'desc' => $this->input->post('desc'),
                'last_update_by' => $this->session->userdata("username"),
                'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
            );
        
        $this->Vendors_model->update(array('vendor_id' => $this->input->post('vendorId')), $data);
        
        $data_asset = array(
                'vendor_name' => $this->input->post('vendorName')
            );
        
        $this->Assets_model->update(array('vendor_id' => $this->input->post('vendorId')), $data_asset);
        
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete($id)
    {
        $this->Vendors_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
    
    function lists() {
        $colModel['vendor_id'] = array('ID',20,TRUE,'left',2);
        $colModel['vendor_name'] = array('Vendor',200,TRUE,'left',2);
        $colModel['address'] = array('Address',450,TRUE,'left',2);
        $colModel['phone'] = array('Phone #',150,TRUE,'left',2);
        $colModel['action'] = array('Action',70,FALSE,'center',0);

        $gridParams = array(
            'width' => 1031,
            'height' => 420,
            'rp' => 50,
            'rpOptions' => '[10,25,50,100,250]',
            'pagestat' => 'Displaying: {from} to {to} of {total} items.',
            'blockOpacity' => 0.5,
            'title' => 'Vendor Management',
            'showTableToggleBtn' => true
	);
        
        $buttons[] = array('Add', 'add', 'doCommand');
        $buttons[] = array('separator');
        $buttons[] = array('Select All', 'selectAll', 'doCommand');
        $buttons[] = array('DeSelect All', 'unselectAll', 'doCommand');
        
        $grid_js = build_grid_js('flex1',site_url("Vendor/load_data"),$colModel,'vendor_id','asc',$gridParams, $buttons);

	$data['js_grid'] = $grid_js;

        $data['page_title'] = 'Vendor Management';
        $data['content'] = $this->load->view('vendor/list', $data, TRUE);
        $this->load->view($this->session->userdata("template"), $data);
    }

    function load_data() {
        $valid_fields = array('vendor_id', 'vendor_name', 'address', 'phone');

	$this->flexigrid->validate_post('vendor_id','ASC',$valid_fields);
        
	$records = $this->Vendors_model->get_vendor_flexigrid();

	$this->output->set_header($this->config->item('json_header'));

        $record_items = array();

	foreach ($records['records']->result() as $row)
	{
            $button = '<a href=\'#\' onclick="edit_vendor(\''.$row->vendor_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/b_edit.png\'></a>'.'&nbsp&nbsp&nbsp'.
                      '<a href=\'#\' onclick="delete_vendor(\''.$row->vendor_id.'\''.',\''.$row->vendor_name.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/Delete.png\'></a>';
            
            $record_items[] = array(
                $row->vendor_id,
                $row->vendor_id,
                $row->vendor_name,
                $row->address,
                $row-> phone,
                $button
			);
        }
	//Print please
	$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
    }    
    
    function add()
    {
        $data['type_list'] = $this->Vendor_type_model->getVendorTypeList();
        $data['page_title'] = 'Add Vendor';
        $data['content'] = $this->load->view('vendor/add', $data, TRUE);
        $this->load->view($this->session->userdata("template"), $data);
    }

    function save_vendor_ajax() {
        $name = $this->input->post('name', TRUE);
        $type = $this->input->post('type', TRUE);
        $address = $this->input->post('address', TRUE);
        $phone = $this->input->post('phone', TRUE);
        $desc = $this->input->post('desc', TRUE);

        $data = array(
            'vendor_name' => $name,
            'address' => $address,
            'phone' => $phone,
            'vendor_type' => $type,
            'desc' => $desc,
            'created_by' => $this->session->userdata("username"),
            'created_date' => date('Y-m-d H:i:s', strtotime('now')),
            'last_update_by' => $this->session->userdata("username"),
            'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
        );

        $this->Vendors_model->insertVendor($data);
        echo json_encode(array('result' => 'true'));
    }

    function edit($id = '')
    {
        $hasil = $this->Vendors_model->getVendorById($id)->result();
        
        $data['vendor_id'] = $hasil[0]->vendor_id;
        $data['vendor_name'] = $hasil[0]->vendor_name;
        $data['address'] = $hasil[0]->address;
        $data['phone'] = $hasil[0]->phone;
        $data['vendor_type'] = $hasil[0]->vendor_type;
        $data['desc'] = $hasil[0]->desc;
        
        $data['type_list'] = $this->Vendor_type_model->getVendorTypeList();
        
        $data['page_title'] = 'Edit Vendor';
        $data['content'] = $this->load->view('vendor/edit', $data, TRUE);
        $this->load->view($this->session->userdata("template"), $data);
    }
    
    function update_vendor_ajax() {
        $id = $this->input->post('id', TRUE);
        $name = $this->input->post('name', TRUE);
        $type = $this->input->post('type', TRUE);
        $address = $this->input->post('address', TRUE);
        $phone = $this->input->post('phone', TRUE);
        $desc = $this->input->post('desc', TRUE);

        $data = array(
            'vendor_name' => $name,
            'address' => $address,
            'phone' => $phone,
            'vendor_type' => $type,
            'desc' => $desc,
            'last_update_by' => $this->session->userdata("username"),
            'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
        );


        $result = $this->Vendors_model->updateVendor(array('vendor_id' => $id), $data);
        if ($result > 0) {
          echo json_encode(array('result' => 'true'));
        } else {
          echo json_encode(array('result' => 'false'));
        }
    }

    function delete($id)
    {
        $this->Vendors_model->deleteVendor($id);
        redirect("Vendor", 'refresh');
    }
}
?>
