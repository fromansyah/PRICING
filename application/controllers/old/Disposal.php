<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Disposal extends CI_Controller {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('flexigrid');
        $this->load->library('flexigrid');
        $this->load->library('Dynamic_menu');
        $this->load->library('pagination');
        $this->load->model('Disposal_model', 'Disposal');
        $this->load->model('Assets_model','Assets');
        $this->load->model('Depreciation_model','Depreciation');
    }
 
    public function index()
    {
        $this->load->helper('url');
//        $this->load->view('Asset/list');
//        $data['employee_list'] = $this->Employee->getAllEmployeeActiveList();
//        $data['location_list'] = $this->Locations->getLocationList();
        $data['page_name'] = 'Disposal Management';
        
        $data['content'] = $this->load->view('disposal/list', $data, TRUE);
        $this->load->view($this->session->userdata("template"), $data);
    }
 
    public function ajax_list()
    {
        $list = $this->Disposal->get_datatables();
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
                $button = '<a href=\'#\' onclick="edit_asset(\''.$asset->asset_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/file_edit.png\'></a>'.'&nbsp&nbsp&nbsp'.
                      '<a href=\'#\' onclick="put_location(\''.$asset->asset_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/green-location-icons-17.png\'></a>'.'&nbsp&nbsp&nbsp'.
                      '<a href=\'#\' onclick="view_depreciation(\''.$asset->asset_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/081_a.png\'></a>'.'&nbsp&nbsp&nbsp'.
                      '<a href=\'#\' onclick="view_location(\''.$asset->asset_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/locations.png\'></a>'.'&nbsp&nbsp&nbsp'.
                      '<a href=\'#\' onclick="dispose(\''.$asset->asset_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/trash_icon_a.png\'></a>'.'&nbsp&nbsp&nbsp'.
                      '<a href=\'#\' onclick="delete_asset(\''.$asset->asset_id.'\''.',\''.$asset->name.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/file_delete.png\'></a>';
            }elseif($asset->status == 'N'){
                $button = '<a href=\'#\' onclick="edit_asset(\''.$asset->asset_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/file_edit.png\'></a>'.'&nbsp&nbsp&nbsp'.
                      '<a href=\'#\' onclick="return_asset(\''.$asset->asset_id.'\''.',\''.$asset->name.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/return_a.jpg\'></a>'.'&nbsp&nbsp&nbsp'.
                      '<a href=\'#\' onclick="view_depreciation(\''.$asset->asset_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/081_a.png\'></a>'.'&nbsp&nbsp&nbsp'.
                      '<a href=\'#\' onclick="view_location(\''.$asset->asset_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/locations.png\'></a>'.'&nbsp&nbsp&nbsp'.
                      '<a href=\'#\' onclick="delete_asset(\''.$asset->asset_id.'\''.',\''.$asset->name.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/file_delete.png\'></a>';
            }elseif($asset->status == 'D'){
                $button = '<a href=\'#\' onclick="edit_asset(\''.$asset->asset_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/file_edit.png\'></a>'.'&nbsp&nbsp&nbsp'.
                      '<a href=\'#\' onclick="view_depreciation(\''.$asset->asset_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/081_a.png\'></a>'.'&nbsp&nbsp&nbsp'.
                      '<a href=\'#\' onclick="view_location(\''.$asset->asset_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/locations.png\'></a>'.'&nbsp&nbsp&nbsp'.
                      '<a href=\'#\' onclick="delete_asset(\''.$asset->asset_id.'\''.',\''.$asset->name.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/file_delete.png\'></a>';
            }
            
            $no++;
            $row = array();
            $row[] = $asset->asset_id;
            $row[] = $asset->barcode;
            $row[] = $asset->name;
            $row[] = $asset->category;
            $row[] = $asset->dept_name;
            $row[] = $asset->emp_name;
            $row[] = '<div align="center">'.$asset->currency.'</div>';
            $row[] = '<div align="right">'.number_format($asset->value, 2).'</div>';
            $row[] = '['.$asset->status.'] '.$status;
 
            //add html for action
            $row[] = $button;
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Disposal->count_all(),
                        "recordsFiltered" => $this->Disposal->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($id)
    {
        $data = $this->Disposal->get_by_id($id);
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        if($this->input->post('disposeDate') == null || $this->input->post('disposeDate') == ''){
            
            echo json_encode(array("status" => FALSE, "error" => 'Date can not empty.'));
            
        }elseif($this->input->post('disposeRate') == null || $this->input->post('disposeRate') == ''){
            
            echo json_encode(array("status" => FALSE, "error" => 'Rate can not empty.'));
            
        }else{
            $asset_id = $this->input->post('disposeAssetId');
            
            $date_explode = explode('-', $this->input->post('disposeDate'));

            $data = array(
                    'asset_id' => $this->input->post('disposeAssetId'),
                    'asset_name' => $this->input->post('disposeAssetName'),
                    'asset_barcode' => $this->input->post('disposeAssetBarcode'),
                    'disposal_date' => $this->input->post('disposeDate'),
                    'month' => $date_explode[0],
                    'year' => $date_explode[2],
                    'currency' => $this->input->post('disposeCurrency'),
                    'rate' => $this->input->post('disposeRate'),
                    'cost_adjustment' => $this->input->post('disposeCostAdjustment'),
                    'reason' => $this->input->post('disposeReason'),
                    'created_by' => $this->session->userdata("username"),
                    'created_date' => date('Y-m-d H:i:s', strtotime('now')),
                    'last_update_by' => $this->session->userdata("username"),
                    'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
                );

            $insert = $this->Disposal->save($data);

            $data_asset = array(
                    'status' => 'D',
                    'last_update_by' => $this->session->userdata("username"),
                    'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
                );

            $this->Assets->update(array('asset_id' => $this->input->post('disposeAssetId')), $data_asset);
            
            $data_depreciation = array(
                    'status' => 'D',
                    'last_update_by' => $this->session->userdata("username"),
                    'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
            );
            
//            $this->Depreciation->updateByDispose(array('asset_id' => $this->input->post('disposeAssetId'), 'CONVERT(varchar(4), year)+month' => $date_explode[2].$date_explode[0]), $data_depreciation);
            $year_month = $date_explode[2].$date_explode[0];
            $this->Depreciation->updateByDispose("asset_id = $asset_id and CONVERT(varchar(4), year)+month >= '$year_month'", $data_depreciation);
            
            echo json_encode(array("status" => TRUE));
//            echo json_encode(array("status" => FALSE, "error" => $this->input->post('disposeAssetId')));
        }
        
//        echo json_encode(array("status" => FALSE, "error" => $this->input->post('disposeDate')));
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
        $this->Disposal->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete($id)
    {
        $result = $this->Disposal->getDisposalById($id)->result();
        
        $data_asset = array(
                'status' => 'A',
                'last_update_by' => $this->session->userdata("username"),
                'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
            );
        
        $this->Assets->update(array('asset_id' => $result[0]->asset_id), $data_asset);
        
        $this->Disposal->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
}
?>
