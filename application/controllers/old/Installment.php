<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Installment extends CI_Controller {
    
    public function __construct()
    {
	parent::__construct();
        $this->support_lib->check_login();
        $this->load->helper('flexigrid');
        $this->load->library('flexigrid');
        $this->load->library('Dynamic_menu');
        $this->load->library('pagination');
        $this->load->model('Installment_model', 'Installment_model');
        $this->load->model('Assets_model', 'Assets_model');
        $this->load->model('Master_data_model', 'Master_data_model');
        $this->load->model('Depreciation_model', 'Depreciation_model');
    }
    
    public function index(){
        $this->lists();
    }
    
    function lists($asset_id = '') {
        $this->load->helper('url');
        
        $data['asset_id'] = $asset_id;
        
        $result = $this->Assets_model->getAssetById($asset_id)->result();
        $data['asset_name'] = $result[0]->name;
        $data['asset_barcode'] = $result[0]->barcode;
        
        $data['page_title'] = 'Installments';
        $data['content'] = $this->load->view('installment/list', $data, TRUE);
        $this->load->view($this->session->userdata("template"), $data);
    }
    
    public function ajax_list($asset_id='')
    {
        $last_installment = $this->Installment_model->get_last_installment($asset_id);
        
        $list = $this->Installment_model->get_datatables($asset_id);
        
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $installment) {
            $button = '';
            if($installment->installment_id == $last_installment){
                $button = //'<a href=\'#\' onclick="edit_installment(\''.$installment->installment_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/file_edit.png\'></a>'.'&nbsp&nbsp&nbsp'.
                          '<a href=\'#\' onclick="delete_installment(\''.$installment->installment_id.'\''.',\''.$installment->status_name.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/file_delete.png\'></a>';
            }
            
            $no++;
            $row = array();
            $row[] = $installment->date;
            $row[] = $installment->status_name;
            $row[] = $installment->currency;
            $row[] = '<div align="right">'.number_format($installment->rate, 2).'</div>';
            $row[] = '<div align="right">'.number_format($installment->amount, 2).'</div>';
            $row[] = $installment->note;
            $row[] = '<div align="center">'.$button.'</div>';
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Installment_model->count_all($asset_id),
                        "recordsFiltered" => $this->Installment_model->count_filtered($asset_id),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }

    function load_data($asset_id) {
        $valid_fields = array('installment_id', 'year', 'month', 'original_value', 'installment_value', 'balance', 'status');

	$this->flexigrid->validate_post('counter','ASC',$valid_fields);
        
	$records = $this->Depreciation_model->get_installment_flexigrid($asset_id);

	$this->output->set_header($this->config->item('json_header'));

        $record_items = array();

	foreach ($records['records']->result() as $row)
	{
            $button = '<a href=\'#\' onclick="view_installment(\''.$row->installment_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/046.png\'></a>'.'&nbsp&nbsp&nbsp';
            
            $record_items[] = array(
                $row->installment_id,
                $row->installment_id,
                $row->year,
                $row->month,
                number_format($row->original_value, 2),
                number_format($row->installment_value, 2),
                number_format($row->balance, 2),
                $row->status//,
                //$button
			);
        }
	//Print please
	$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
    }
    
    public function ajax_add()
    {
        $asset_id = $this->input->post('installmentAssetId');
        $date = $this->input->post('installmentDate');
        $status = $this->input->post('installmentStatus');
        $currency = $this->input->post('installmentCurrency');
        $rate = $this->input->post('installmentRate');
//        $installment_amount = $this->input->post('installmentTotal');
//        $amount = $this->input->post('installmentAmount');
        $note = $this->input->post('installmentNote');
        
        $explode_price = explode(',', $this->input->post('installmentPrice'));
        $str_price = '';
        for($i=0;$i<count($explode_price);$i++){
            $str_price = $str_price.$explode_price[$i];
        }
        $price = (float)$str_price;
        
        $explode_amount = explode(',', $this->input->post('installmentAmount'));
        $str_amount = '';
        for($i=0;$i<count($explode_amount);$i++){
            $str_amount = $str_amount.$explode_amount[$i];
        }
        $amount = (float)$str_amount;
        
        $explode_isntallment = explode(',', $this->input->post('installmentTotal'));
        $str_installment = '';
        for($i=0;$i<count($explode_isntallment);$i++){
            $str_installment = $str_installment.$explode_isntallment[$i];
        }
        $installment_amount = (float)$str_installment;
        
        
        if($date == null || $date == ''){
            
            echo json_encode(array("status" => FALSE, 'error' => 'Date can not empty.'));
            
        }elseif($amount == null || $amount == '' || $amount <= 0){
            
            echo json_encode(array("status" => FALSE, 'error' => 'Amount can not empty or must be greater than 0.'));
            
        }elseif(($price == ($installment_amount + $amount) && $status != 21) || ($price != ($installment_amount + $amount) && $status == 21)){
            
            echo json_encode(array("status" => FALSE, 'error' => 'The installment status is wrong.'));
            
        }else{
            
            $check_installment = $this->Installment_model->checkInstallment($asset_id, $status);
            $status_name = $this->Master_data_model->getMasterDataName($status, 'INSTALLMENT_STATUS');
//            echo json_encode(array("status" => FALSE, 'error' => $status_name));
            
            if($check_installment == 0){
                $data = array(
                        'asset_id' => $asset_id,
                        'date' => $date,
                        'currency' => $currency,
                        'rate' => $rate,
                        'amount' => $amount,
                        'status' => $status,
                        'status_name' => $status_name,
                        'note' => $note,
                        'created_by' => $this->session->userdata("username"),
                        'created_date' => date('Y-m-d H:i:s', strtotime('now')),
                        'last_update_by' => $this->session->userdata("username"),
                        'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
                    );
                
                $insert = $this->Installment_model->save($data);
                
                if($status == 21){
                    $asset = $this->Assets_model->getAssetById($asset_id)->result();
                    
                    $barcode = $this->get_barcode($asset[0]->category, $asset[0]->department_id, $date);
                    
                    $data_asset = array(
                        'barcode' => $barcode,
                        'payment_status' => 2,
                        'payment_status_name' => 'Paid',
                        'last_update_by' => $this->session->userdata("username"),
                        'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
                    );

                    $this->Assets_model->updateAsset(array('asset_id' => $asset_id), $data_asset);
                    
                    $this->generate_depreciation($asset_id, $date);
                }
                
//                echo json_encode(array("status" => FALSE, 'error' => $barcode));
                echo json_encode(array("status" => TRUE));
            }else{
                echo json_encode(array("status" => FALSE, 'error' => 'Asset is unavailable.'));
            }
        }
    }
    
    function generate_depreciation($asset_id, $date){
        $asset_result = $this->Assets_model->getAssetById($asset_id)->result();
        
        $year_num = $asset_result[0]->year_num;
        $idr_value = $asset_result[0]->idr_value;
        $barcode = $asset_result[0]->barcode;
        $name = $asset_result[0]->name;
        
        $explode_purchase_date = explode('-', $date);
        $p_month = $explode_purchase_date[0];
        $p_year = $explode_purchase_date[2];
        
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
                
                $this->Depreciation_model->insertDepreciation($data_depreciation);
            }
        }
    }
 
    public function ajax_delete($id)
    {
        $installment = $this->Installment_model->getInstallmentById($id)->result();

        if($installment[0]->status == 21){
            $data_asset = array(
                'barcode' => '',
                'payment_status' => 1,
                'payment_status_name' => 'Installment',
                'last_update_by' => $this->session->userdata("username"),
                'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
                );
            
            $this->Assets_model->updateAsset(array('asset_id' => $installment[0]->asset_id), $data_asset);
                    
            $this->Depreciation_model->deleteDepreciationByAssetId($installment[0]->asset_id);
        }
        
        $this->Installment_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
    
    function get_barcode($category, $dept, $date){
        $explode_purchase_date = explode('-', $date);
        $p_date = $explode_purchase_date[1];
        $p_month = $explode_purchase_date[0];
        $p_year = $explode_purchase_date[2];
        
        $counter_result = $this->Assets_model->getCounter($category, $dept, $p_year);
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
        
        header('Content-Type: application/x-json; charset=utf-8');
        return $barcode;
    }
}
?>
