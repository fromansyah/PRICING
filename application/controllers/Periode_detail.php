<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Periode_detail extends CI_Controller {
    
    public function __construct()
    {
	parent::__construct();
        $this->support_lib->check_login();
        $this->load->library('Dynamic_menu');
        $this->load->model('Periode_detail_model', 'Periode_detail_model');
        $this->load->model('Periode_model', 'Periode_model');
        $this->load->model('Users_model', 'Users_model'); 
    }
    
    public function index(){
        $check = $this->Users_model->getRoleMenu('index.php/Periode_detail');
        
        if(count($check) > 0){
            $this->load->helper('url');
        
            $data['page_name'] = 'Periode Detail Management';
            $data['product_list'] = $this->Periode_detail_model->getPeriodeDetailList();
            
            $data['content'] = $this->load->view('periode_detail/list', $data, TRUE);
            $this->load->view($this->session->userdata("template"), $data);
        }else{
            $data['title'] = 'Error Page';
        	$data["content"] = $this->load->view('error',$data,true);
            $this->load->view("blank", $data);
        }
    }
    
    
    
    function lists($periode_id) {
        $check = $this->Users_model->getRoleMenu('index.php/Periode');
        
        if(count($check) > 0){
            $this->load->helper('url');
        
            $data['periode_id'] = $periode_id;
            
            $new_periode_id = str_replace('slash', '/', $periode_id);
            
            $result = $this->Periode_model->getPeriodeById($new_periode_id)->result();
            $data['start_date'] = $result[0]->start_date;
            $data['end_date'] = $result[0]->end_date;
            
            $periode_list = array();
            $periode_list[1] = 1;
            $periode_list[2] = 2;
            $periode_list[3] = 3;
            $periode_list[4] = 4;
            $periode_list[5] = 5;
            $periode_list[6] = 6;
            $periode_list[7] = 7;
            $periode_list[8] = 8;
            $periode_list[9] = 9;
            $periode_list[10] = 10;
            $periode_list[11] = 11;
            $periode_list[12] = 12;
            $data['periode_list'] = $periode_list;
            
            $data['page_title'] = 'Periode Detail';
            $data['content'] = $this->load->view('periode_detail/list', $data, TRUE);
            $this->load->view($this->session->userdata("template"), $data);
        }else{
            $data['title'] = 'Error Page';
        	$data["content"] = $this->load->view('error',$data,true);
            $this->load->view("blank", $data);
        }
        
    }
 
    public function ajax_list($periode_id)
    {
        $periode_id = str_replace('slash', '/', $periode_id);
        $list = $this->Periode_detail_model->get_datatables($periode_id);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $product) {

            $no++;
            $row = array();
            $row[] = $product->periode_detail_id;
            $row[] = $product->periode_num;
            $row[] = $product->month;
 
            //add html for action
	    $button = '';
            if($this->session->userdata("role") == 1){
		    $button = '<a href=\'#\' onclick="edit_detail(\''.$product->periode_detail_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'/images/file_edit.png\' title=\'Edit Price\'></a>'.'&nbsp&nbsp&nbsp'.
			      '<a href=\'#\' onclick="delete_detail(\''.$product->periode_detail_id.'\''.',\''.$product->periode_detail_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'/images/file_delete.png\' title=\'Delete Price\'></a>';
	    }
            $row[] = $button;

            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Periode_detail_model->count_all($periode_id),
                        "recordsFiltered" => $this->Periode_detail_model->count_filtered($periode_id),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($id)
    {
        $data = $this->Periode_detail_model->get_by_id($id);
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        if($this->input->post('month') == null || $this->input->post('month') == ''){
            
            $error_message = 'Month can not empty.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }else{
            $data = array(
                    'periode_detail_id' => $this->input->post('productNo'),
                    'periode_id' => $this->input->post('periodeId'),
                    'periode_num' => $this->input->post('periode'),
                    'month' => $this->input->post('month'),
                    'created_by' => $this->session->userdata("username"),
                    'created_date' => date('Y-m-d H:i:s', strtotime('now')),
                    'last_update_by' => $this->session->userdata("username"),
                    'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
                );
            
            $this->Periode_detail_model->save($data);
            echo json_encode(array("status" => TRUE));
//            echo json_encode(array("status" => FALSE, 'error' => $this->input->post('menuName')));
        }
    }
 
    public function ajax_update()
    {
        if($this->input->post('month') == null || $this->input->post('month') == ''){
            
            $error_message = 'Month can not empty.';
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
            
        }else{
            $data = array(
                    'periode_detail_id' => $this->input->post('productNo'),
                    'periode_id' => $this->input->post('periodeId'),
                    'periode_num' => $this->input->post('periode'),
                    'month' => $this->input->post('month'),
                    'last_update_by' => $this->session->userdata("username"),
                    'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
                );
            
            $this->Periode_detail_model->update(array('periode_detail_id' => $this->input->post('detailId')), $data);
            
            echo json_encode(array("status" => TRUE));
        }
    }
 
    public function ajax_delete($id)
    {
        $id = str_replace('slash', '/', $id);
        $this->Periode_detail_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
    
    public function upload_detail(){
        $data['page_title'] = 'Upload Periode Detail';
        $data['content'] = $this->load->view('periode_detail/upload_detail', $data, TRUE);
        $this->load->view('form_template', $data);
    }
    
    function getmenuList(){
        echo json_encode($this->Periode_detail_model->getPeriodeDetailList());
    }
    
    public function download_template(){
        $data['data'] = $this->Periode_detail_model->getTemplatePrice();
        $data['title'] = 'Template Upload Periode Detail';
        $data['content'] = $this->load->view('periode_detail/template_detail', $data, TRUE);
        $this->load->view('blank_page', $data);
    }
}
?>
