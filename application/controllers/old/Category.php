<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {
    
    public function __construct()
    {
	parent::__construct();
        $this->support_lib->check_login();
        $this->load->library('Dynamic_menu');
        $this->load->model('Categories_model', 'Categories_model');
    }
    
    public function index(){
        $this->lists();
    }
    
    function lists() {
        $this->load->helper('url');
        $data['test'] = '';
        
        $data['content'] = $this->load->view('Category/list', $data, TRUE);
        $this->load->view($this->session->userdata("template"), $data);
    }

    public function ajax_list()
    {
        $list = $this->Categories_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $category) {

            $no++;
            $row = array();
            $row[] = $category->category_id;
            $row[] = $category->category_name;
            $row[] = $category->num_of_year;
            $row[] = $category->depreciation_percentage;
            $row[] = $category->category_desc;
 
            //add html for action
            $button = '<a href=\'#\' onclick="edit_category(\''.$category->category_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/file_edit.png\'></a>'.'&nbsp&nbsp&nbsp'.
                      '<a href=\'#\' onclick="delete_category(\''.$category->category_id.'\''.',\''.$category->category_name.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/file_delete.png\'></a>';
            
            $row[] = $button;

            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Categories_model->count_all(),
                        "recordsFiltered" => $this->Categories_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($id)
    {
        $data = $this->Categories_model->get_by_id($id);
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        if($this->input->post('categoryId') == null || $this->input->post('categoryId') == ''){
            $error_message = 'Category ID can not empty.';
            
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
        }elseif($this->input->post('categoryName') == null || $this->input->post('categoryName') == ''){
            $error_message = 'Category name can not empty.';
            
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
        }elseif($this->input->post('numOfYear') == null || $this->input->post('numOfYear') == ''){
            $error_message = 'Num of year can not empty.';
            
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
        }elseif($this->input->post('depreciationPercentage') == null || $this->input->post('depreciationPercentage') == ''){
            $error_message = 'Depreciation percentage can not empty.';
            
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
        }else{
            $data = array(
                    'category_id' => $this->input->post('categoryId'),
                    'num_of_year' => $this->input->post('numOfYear'),
                    'depreciation_percentage' => $this->input->post('depreciationPercentage'),
                    'category_name' => $this->input->post('categoryName'),
                    'category_desc' => $this->input->post('desc'),
                    'created_by' => $this->session->userdata("username"),
                    'created_date' => date('Y-m-d H:i:s', strtotime('now')),
                    'last_update_by' => $this->session->userdata("username"),
                    'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
                );
            
            $insert = $this->Categories_model->save($data);
            echo json_encode(array("status" => TRUE));
        }
    }
 
    public function ajax_update()
    {
        if($this->input->post('categoryId') == null || $this->input->post('categoryId') == ''){
            $error_message = 'Category ID can not empty.';
            
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
        }elseif($this->input->post('categoryName') == null || $this->input->post('categoryName') == ''){
            $error_message = 'Category name can not empty.';
            
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
        }elseif($this->input->post('numOfYear') == null || $this->input->post('numOfYear') == ''){
            $error_message = 'Num of year can not empty.';
            
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
        }elseif($this->input->post('depreciationPercentage') == null || $this->input->post('depreciationPercentage') == ''){
            $error_message = 'Depreciation percentage can not empty.';
            
            echo json_encode(array("status" => FALSE, 'error' => $error_message));
        }else{
            $data = array(
                    'category_id' => $this->input->post('categoryId'),
                    'num_of_year' => $this->input->post('numOfYear'),
                    'depreciation_percentage' => $this->input->post('depreciationPercentage'),
                    'category_name' => $this->input->post('categoryName'),
                    'category_desc' => $this->input->post('desc'),
                    'last_update_by' => $this->session->userdata("username"),
                    'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
                );
            
            $this->Categories_model->update(array('category_id' => $this->input->post('categoryId')), $data);
            
            echo json_encode(array("status" => TRUE));
        }
    }
 
    public function ajax_delete($id)
    {
        $this->Categories_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
    
    function get_year_category($id){
        $hasil = $this->Categories_model->getCategoryById($id)->result();
        
        $result['#year_num'] = $hasil[0]->num_of_year;
        
        header('Content-Type: application/x-json; charset=utf-8');
        echo(json_encode($result));
    }
}
?>
