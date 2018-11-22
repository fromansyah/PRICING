<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Employee extends CI_Controller {
 
    public function __construct()
    {
        parent::__construct();
        $this->support_lib->check_login();
        $this->load->library('Dynamic_menu');
        $this->load->model('Employee_model','Employee');
    }
 
    public function index()
    {
        $this->load->helper('url');
        $data['test'] = '';
        $data['content'] = $this->load->view('Employee/list', $data, TRUE);
        $this->load->view($this->session->userdata("template"), $data);
    }
 
    public function ajax_list()
    {
        $list = $this->Employee->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $employee) {
            $status = '';
            if($employee->RECORD_STATUS == 'A'){
                $status = 'Active';
            }else{
                $status = 'Non Active';
            }
            
            $no++;
            $row = array();
            $row[] = $employee->EMPLOYEE_ID;
            $row[] = $employee->EMP_INITIAL;
            $row[] = $employee->FIRST_NAME;
            $row[] = $employee->MIDDLE_NAME;
            $row[] = $employee->LAST_NAME;
            $row[] = $employee->EMAIL;
            $row[] = '['.$employee->RECORD_STATUS.'] '.$status;
 
            //add html for action
            $row[] = '<a href=\'#\' onclick="view_employee(\''.$employee->EMPLOYEE_ID.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/view_data.png\'></a>';
//            '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_employee('."'".$employee->EMPLOYEE_ID."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
//                  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_employee('."'".$employee->EMPLOYEE_ID."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Employee->count_all(),
                        "recordsFiltered" => $this->Employee->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($id)
    {
        $data = $this->Employee->get_by_id($id);
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
        $insert = $this->Employee->save($data);
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
        $this->Employee->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete($id)
    {
        $this->Employee->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
 
}