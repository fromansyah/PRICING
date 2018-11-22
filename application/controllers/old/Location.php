<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Location extends CI_Controller {
    
    public function __construct()
    {
	parent::__construct();
        $this->support_lib->check_login();
        $this->load->helper('flexigrid');
        $this->load->library('flexigrid');
        $this->load->library('Dynamic_menu');
        $this->load->model('Locations_model', 'Locations_model');
        $this->load->model('Asset_location_model', 'Asset_location_model');
    }
    
    public function index(){
        $this->load->helper('url');
        $data['test'] = '';
        $data['content'] = $this->load->view('Location/list', $data, TRUE);
        $this->load->view($this->session->userdata("template"), $data);
    }
 
    public function ajax_list()
    {
        $list = $this->Locations_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $location) {

            $no++;
            $row = array();
            $row[] = $location->location_id;
            $row[] = $location->location;
            $row[] = $location->desc;
 
            //add html for action
            $button = '<a href=\'#\' onclick="edit_location(\''.$location->location_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/file_edit.png\'></a>'.'&nbsp&nbsp&nbsp'.
                      '<a href=\'#\' onclick="delete_location(\''.$location->location_id.'\''.',\''.$location->location.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/file_delete.png\'></a>';
            
            $row[] = $button;

            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Locations_model->count_all(),
                        "recordsFiltered" => $this->Locations_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($id)
    {
        $data = $this->Locations_model->get_by_id($id);
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        if($this->input->post('location') == null || $this->input->post('location') == ''){
            $error_message = 'Location name can not empty.';
            
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
        }else{
            $data = array(
                    'location' => $this->input->post('location'),
                    'desc' => $this->input->post('desc'),
                    'created_by' => $this->session->userdata("username"),
                    'created_date' => date('Y-m-d H:i:s', strtotime('now')),
                    'last_update_by' => $this->session->userdata("username"),
                    'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
                );
            
            $insert = $this->Locations_model->save($data);
            echo json_encode(array("status" => TRUE));
        }
    }
 
    public function ajax_update()
    {
        if($this->input->post('location') == null || $this->input->post('location') == ''){
            $error_message = 'Location name can not empty.';
            
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
        }else{
            $data = array(
                    'location' => $this->input->post('location'),
                    'desc' => $this->input->post('desc'),
                    'last_update_by' => $this->session->userdata("username"),
                    'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
                );
            
            $this->Locations_model->update(array('location_id' => $this->input->post('locationId')), $data);
            
            $data_asset_location = array(
                    'location_name' => $this->input->post('location')
                );
            
            $this->Asset_location_model->update(array('location_id' => $this->input->post('locationId')), $data_asset_location);
            
            echo json_encode(array("status" => TRUE));
        }
    }
 
    public function ajax_delete($id)
    {
        $this->Locations_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
    
    function lists() {
        $colModel['location_id'] = array('ID',20,TRUE,'left',2);
        $colModel['location'] = array('Location',200,TRUE,'left',2);
        $colModel['desc'] = array('Description',450,TRUE,'left',2);
        $colModel['action'] = array('Action',70,FALSE,'center',0);

        $gridParams = array(
            'width' => 1031,
            'height' => 420,
            'rp' => 50,
            'rpOptions' => '[10,25,50,100,250]',
            'pagestat' => 'Displaying: {from} to {to} of {total} items.',
            'blockOpacity' => 0.5,
            'title' => 'Location Management',
            'showTableToggleBtn' => true
	);
        
        $buttons[] = array('Add', 'add', 'doCommand');
        $buttons[] = array('separator');
        $buttons[] = array('Select All', 'selectAll', 'doCommand');
        $buttons[] = array('DeSelect All', 'unselectAll', 'doCommand');
        
        $grid_js = build_grid_js('flex1',site_url("Location/load_data"),$colModel,'location_id','asc',$gridParams, $buttons);

	$data['js_grid'] = $grid_js;

        $data['page_title'] = 'Location Management';
        $data['content'] = $this->load->view('location/list', $data, TRUE);
        $this->load->view($this->session->userdata("template"), $data);
    }

    function load_data() {
        $valid_fields = array('location_id', 'location', 'desc');

	$this->flexigrid->validate_post('location_id','ASC',$valid_fields);
        
	$records = $this->Locations_model->get_location_flexigrid();

	$this->output->set_header($this->config->item('json_header'));

        $record_items = array();

	foreach ($records['records']->result() as $row)
	{
            $button = '<a href=\'#\' onclick="edit_location(\''.$row->location_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/b_edit.png\'></a>'.'&nbsp&nbsp&nbsp'.
                      '<a href=\'#\' onclick="delete_location(\''.$row->location_id.'\''.',\''.$row->location.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/Delete.png\'></a>';
            
            $record_items[] = array(
                $row->location_id,
                $row->location_id,
                $row->location,
                $row->desc,
                $button
			);
        }
	//Print please
	$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
    }    
    
    function add()
    {
        $data['page_title'] = 'Add Location';
        $data['content'] = $this->load->view('location/add', $data, TRUE);
        $this->load->view($this->session->userdata("template"), $data);
    }

    function save_location_ajax() {
        $location = $this->input->post('location', TRUE);
        $desc = $this->input->post('desc', TRUE);
        
        $error_message = '';
        if($location == null || $location == ''){
            $error_message = 'Location name can not empty.';
            
            echo json_encode(array('result' => 'false', 'error' => $error_message));
        }else{
            $data = array(
                'location' => $location,
                'desc' => $desc,
                'created_by' => $this->session->userdata("username"),
                'created_date' => date('Y-m-d H:i:s', strtotime('now')),
                'last_update_by' => $this->session->userdata("username"),
                'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
            );

            $this->Locations_model->insertLocation($data);
            echo json_encode(array('result' => 'true'));
        }

        
    }

    function edit($id = '')
    {
        $hasil = $this->Locations_model->getLocationById($id)->result();
        
        $data['location_id'] = $hasil[0]->location_id;
        $data['location'] = $hasil[0]->location;
        $data['desc'] = $hasil[0]->desc;
        
        $data['page_title'] = 'Edit Location';
        $data['content'] = $this->load->view('location/edit', $data, TRUE);
        $this->load->view($this->session->userdata("template"), $data);
    }
    
    function update_location_ajax() {
        $id = $this->input->post('id', TRUE);
        $location = $this->input->post('location', TRUE);
        $desc = $this->input->post('desc', TRUE);

        $data = array(
            'location' => $location,
            'desc' => $desc,
            'last_update_by' => $this->session->userdata("username"),
            'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
        );


        $result = $this->Locations_model->updateLocation(array('location_id' => $id), $data);
        if ($result > 0) {
          echo json_encode(array('result' => 'true'));
        } else {
          echo json_encode(array('result' => 'false'));
        }
    }

    function delete($id)
    {
        $this->Locations_model->deleteLocation($id);
        redirect("Location", 'refresh');
    }
    
    function getlocationList(){
        echo json_encode($this->Locations_model->getLocationList());
    }
}
?>
