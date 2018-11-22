<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Depreciation extends CI_Controller {
    
    public function __construct()
    {
	parent::__construct();
        $this->support_lib->check_login();
        $this->load->helper('flexigrid');
        $this->load->library('flexigrid');
        $this->load->library('Dynamic_menu');
        $this->load->library('pagination');
        $this->load->model('Depreciation_model', 'Depreciation_model');
        $this->load->model('Assets_model', 'Assets_model');
    }
    
    public function index(){
        $this->lists();
    }
    
    function lists($asset_id) {
        $this->load->helper('url');
        
        $data['asset_id'] = $asset_id;
        
        $result = $this->Assets_model->getAssetById($asset_id)->result();
        $data['asset_name'] = $result[0]->name;
        $data['asset_barcode'] = $result[0]->barcode;
        
        $data['page_title'] = 'Depreciations';
        $data['content'] = $this->load->view('depreciation/list', $data, TRUE);
        $this->load->view($this->session->userdata("template"), $data);
    }
 
    public function ajax_list($asset_id = '')
    {
        $list = $this->Depreciation_model->get_datatables($asset_id);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $depreciation) {
            $status = '';
            if($depreciation->status == 'A'){
                $status = 'Active';
            }else{
                $status = 'Disposed Off';
            }
            
            $no++;
            $row = array();
            $row[] = $depreciation->month;
            $row[] = $depreciation->year;
            $row[] = '<div align="right">'.number_format($depreciation->original_value, 2).'</div>';
            $row[] = '<div align="right">'.number_format($depreciation->depreciation_value, 2).'</div>';
            $row[] = '<div align="right">'.number_format($depreciation->balance, 2).'</div>';
            $row[] = '['.$depreciation->status.'] '.$status;
            //add html for action
//            $button = '<a href=\'#\' onclick="edit_depreciation(\''.$depreciation->depreciation_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/file_edit.png\'></a>'.'&nbsp&nbsp&nbsp'.
//                      '<a href=\'#\' onclick="delete_depreciation(\''.$depreciation->depreciation_id.'\''.',\''.$depreciation->original_value.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/file_delete.png\'></a>';
//            
//            $row[] = $button;

            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Depreciation_model->count_all($asset_id),
                        "recordsFiltered" => $this->Depreciation_model->count_filtered($asset_id),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }

    function load_data($asset_id) {
        $valid_fields = array('depreciation_id', 'year', 'month', 'original_value', 'depreciation_value', 'balance', 'status');

	$this->flexigrid->validate_post('counter','ASC',$valid_fields);
        
	$records = $this->Depreciation_model->get_depreciation_flexigrid($asset_id);

	$this->output->set_header($this->config->item('json_header'));

        $record_items = array();

	foreach ($records['records']->result() as $row)
	{
            $button = '<a href=\'#\' onclick="view_depreciation(\''.$row->depreciation_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/046.png\'></a>'.'&nbsp&nbsp&nbsp';
            
            $record_items[] = array(
                $row->depreciation_id,
                $row->depreciation_id,
                $row->year,
                $row->month,
                number_format($row->original_value, 2),
                number_format($row->depreciation_value, 2),
                number_format($row->balance, 2),
                $row->status//,
                //$button
			);
        }
	//Print please
	$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
    }
}
?>
