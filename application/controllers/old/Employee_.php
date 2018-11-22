<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends CI_Controller {
    
    public function __construct()
    {
	parent::__construct();
        $this->support_lib->check_login();
        $this->load->helper('flexigrid');
        $this->load->library('flexigrid');
        $this->load->library('Dynamic_menu');
        $this->load->library('pagination');
        $this->load->model('Assets_model', 'Assets_model');
        $this->load->model('Employee_model', 'Employee_model');
        $this->load->model('Departments_model', 'Departments_model');
    }
    
    public function index(){
        $this->lists();
    }
    
    function lists() {
        $keyword = '';
        
        $config['base_url'] = base_url() . 'Employee/index/';
        $config['total_rows'] = $this->Employee_model->total_rows();
        $config['per_page'] = 10;
        $config['uri_segment'] = 3;
        $config['suffix'] = '.html';
        $config['first_url'] = base_url() . 'Employee/index/0.html';
        $this->pagination->initialize($config);

        $start = $this->uri->segment(3, 0);
        $employee = $this->Employee_model->index_limit($config['per_page'], $start);

        $data = array(
            'employee_data' => $employee,
            'keyword' => $keyword,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        

        $data['content'] = $this->load->view('employee/list', $data, TRUE);
        $this->load->view($this->session->userdata("template"), $data);
    }

    function load_data() {
        $valid_fields = array('EMPLOYEE_ID', 'NIK', 'EMP_INITIAL', 'FIRST_NAME', 'DEPARTMENT_REF', 'EMAIL', 'RECORD_STATUS');

	$this->flexigrid->validate_post('RECORD_STATUS, FIRST_NAME','ASC',$valid_fields);
        
	$records = $this->Employee_model->get_employee_flexigrid();

	$this->output->set_header($this->config->item('json_header'));

        $record_items = array();

	foreach ($records['records']->result() as $row)
	{
            $button = '<a href=\'#\' onclick="view_employee(\''.$row->EMPLOYEE_ID.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/046.png\'></a>'.'&nbsp&nbsp&nbsp';
            
            $fullname = '';
            if($row->MIDDLE_NAME != "" || $row->MIDDLE_NAME != NULL){
                $fullname = $row->FIRST_NAME.' '.$row->MIDDLE_NAME.' '.$row->LAST_NAME;
            }else{
                $fullname = $row->FIRST_NAME.' '.$row->LAST_NAME;
            }
            
            if($row->RECORD_STATUS == 'A'){
                $record_status = 'Active';
            }else{
                $record_status = 'Non Active';
            }
            
            $dept = $this->Departments_model->getDepartmentById($row->DEPARTMENT_REF)->result();
            
            $record_items[] = array(
                $row->EMPLOYEE_ID,
                $row->EMPLOYEE_ID,
                $row->NIK,
                $row->EMP_INITIAL,
                $fullname,
                '['.$row->DEPARTMENT_REF.'] '.$dept[0]->department_name,
                $row->EMAIL,
                '['.$row->RECORD_STATUS.'] '.$record_status,
                ''
			);
        }
	//Print please
	$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
    }    

    function view($id = '')
    {
        $hasil = $this->Employee_model->getEmployeeById($id)->result();
        
        $data['employee_id'] = $hasil[0]->employee_id;
        $data['employee'] = $hasil[0]->employee;
        $data['desc'] = $hasil[0]->desc;
        
        $data['page_title'] = 'Edit Employee';
        $data['content'] = $this->load->view('employee/view', $data, TRUE);
        $this->load->view($this->session->userdata("template"), $data);
    }
    
    function getEmployeeActiveList(){
        echo json_encode($this->Employee_model->getAllEmployeeActiveList());
    }
    
    public function search() 
    {
        $keyword = $this->uri->segment(3, $this->input->post('keyword', TRUE));
        $this->load->library('pagination');
        
        if ($this->uri->segment(2)=='search') {
            $config['base_url'] = base_url() . 'Employee/search/' . $keyword;
        } else {
            $config['base_url'] = base_url() . 'Employee/index/';
        }

        $config['total_rows'] = $this->Employee_model->search_total_rows($keyword);
        $config['per_page'] = 10;
        $config['uri_segment'] = 4;
        $config['suffix'] = '.html';
        $config['first_url'] = base_url() . 'Employee/search/'.$keyword.'/0.html';
        $this->pagination->initialize($config);

        $start = $this->uri->segment(4, 0);
        $employee = $this->Employee_model->search_index_limit($config['per_page'], $start, $keyword);

        $data = array(
            'employee_data' => $employee,
            'keyword' => $keyword,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        
        $data['content'] = $this->load->view('employee/list', $data, TRUE);
        $this->load->view($this->session->userdata("template"), $data);
    }
}
?>
