<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Department extends CI_Controller {
    
    public function __construct()
    {
	parent::__construct();
        $this->support_lib->check_login();
        $this->load->helper('flexigrid');
        $this->load->library('flexigrid');
        $this->load->library('Dynamic_menu');
        $this->load->model('Departments_model', 'Departments_model');
    }
    
    public function index()
    {
        $this->load->helper('url');
        $data['department_list'] = $this->Departments_model->getAllDepartmentList();
        
        $data['content'] = $this->load->view('Department/list', $data, TRUE);
        $this->load->view($this->session->userdata("template"), $data);
    }
 
    public function ajax_list()
    {
        $list = $this->Departments_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $dept) {
            
            $dept_name = $this->Departments_model->getDeptName($dept->parent_dept_id);
            
            $no++;
            $row = array();
            $row[] = $dept->department_id;
            $row[] = $dept->department_name;
            $row[] = '['.$dept->parent_dept_id.'] '.$dept_name;
 
            //add html for action
            $row[] = '<a href=\'#\' onclick="view_department(\''.$dept->department_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/view_data.png\'></a>';

            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Departments_model->count_all(),
                        "recordsFiltered" => $this->Departments_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($id)
    {
        $data = $this->Departments_model->get_by_id($id);
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
        $insert = $this->Departments_model->save($data);
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
        $this->Departments_model->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete($id)
    {
        $this->Departments_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
    
    function lists() {
        $colModel['department_id'] = array('ID',20,TRUE,'left',2);
        $colModel['department_name'] = array('Department',200,TRUE,'left',2);
        $colModel['parent_dept_id'] = array('Parent Department',450,TRUE,'left',2);
        $colModel['action'] = array('Action',70,FALSE,'center',0);

        $gridParams = array(
            'width' => 1031,
            'height' => 450,
            'rp' => 50,
            'rpOptions' => '[10,25,50,100,250]',
            'pagestat' => 'Displaying: {from} to {to} of {total} items.',
            'blockOpacity' => 0.5,
            'title' => 'Department Management',
            'showTableToggleBtn' => true
	);
        
        /*$buttons[] = array('Add', 'add', 'doCommand');
        $buttons[] = array('separator');
        $buttons[] = array('Select All', 'selectAll', 'doCommand');
        $buttons[] = array('DeSelect All', 'unselectAll', 'doCommand');*/
        
        $grid_js = build_grid_js('flex1',site_url("Department/load_data"),$colModel,'department_id','asc',$gridParams);

	$data['js_grid'] = $grid_js;

        $data['page_title'] = 'Department Management';
        $data['content'] = $this->load->view('department/list', $data, TRUE);
        $this->load->view($this->session->userdata("template"), $data);
    }

    function load_data() {
        $valid_fields = array('department_id', 'department_name', 'parent_dept_id');

	$this->flexigrid->validate_post('department_id','ASC',$valid_fields);
        
	$records = $this->Departments_model->get_department_flexigrid();

	$this->output->set_header($this->config->item('json_header'));

        $record_items = array();

	foreach ($records['records']->result() as $row)
	{
            $button = '';
                      /*'<a href=\'#\' onclick="edit_department(\''.$row->department_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/b_edit.png\'></a>'.'&nbsp&nbsp&nbsp'.
                      '<a href=\'#\' onclick="delete_department(\''.$row->department_id.'\''.',\''.$row->department_name.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/Delete.png\'></a>';*/
            
            $hasil = $this->Departments_model->getDepartmentById($row->parent_dept_id)->result();
            
            $record_items[] = array(
                $row->department_id,
                $row->department_id,
                $row->department_name,
                '['.$row->parent_dept_id.'] '.$hasil[0]->department_name,
                $button
			);
        }
	//Print please
	$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
    }    
    
    function add()
    {
        $data['page_title'] = 'Add Department';
        $data['content'] = $this->load->view('department/add', $data, TRUE);
        $this->load->view($this->session->userdata("template"), $data);
    }

    function save_department_ajax() {
        $department = $this->input->post('department', TRUE);
        $desc = $this->input->post('desc', TRUE);

        $data = array(
            'department' => $department,
            'desc' => $desc,
            'created_by' => $this->session->userdata("username"),
            'created_date' => date('Y-m-d H:i:s', strtotime('now')),
            'last_update_by' => $this->session->userdata("username"),
            'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
        );

        $this->Departments_model->insertDepartment($data);
        echo json_encode(array('result' => 'true'));
    }

    function edit($id = '')
    {
        $hasil = $this->Departments_model->getDepartmentById($id)->result();
        
        $data['department_id'] = $hasil[0]->department_id;
        $data['department'] = $hasil[0]->department;
        $data['desc'] = $hasil[0]->desc;
        
        $data['page_title'] = 'Edit Department';
        $data['content'] = $this->load->view('department/edit', $data, TRUE);
        $this->load->view($this->session->userdata("template"), $data);
    }
    
    function update_department_ajax() {
        $id = $this->input->post('id', TRUE);
        $department = $this->input->post('department', TRUE);
        $desc = $this->input->post('desc', TRUE);

        $data = array(
            'department' => $department,
            'desc' => $desc,
            'last_update_by' => $this->session->userdata("username"),
            'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
        );


        $result = $this->Departments_model->updateDepartment(array('department_id' => $id), $data);
        if ($result > 0) {
          echo json_encode(array('result' => 'true'));
        } else {
          echo json_encode(array('result' => 'false'));
        }
    }

    function delete($id)
    {
        $this->Departments_model->deleteDepartment($id);
        redirect("Department", 'refresh');
    }
}
?>
