<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Employee_model extends CI_Model {
 
    var $table = 'employee';
    var $column_order = array('EMPLOYEE_ID', 'EMP_INITIAL', 'FIRST_NAME','MIDDLE_NAME' ,'LAST_NAME', 'EMAIL', 'RECORD_STATUS' ,null); //set column field database for datatable orderable
    var $column_search = array('FIRST_NAME','MIDDLE_NAME','LAST_NAME'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $order = array('EMPLOYEE_ID' => 'DESC'); // default order 
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
    private function _get_datatables_query()
    {
         
        $this->db->from($this->table);
 
        $i = 0;
     
        foreach ($this->column_search as $item) // loop column 
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {
                 
                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
         
        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
    function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
 
    public function get_by_id($id)
    {
        $this->db->from($this->table);
        $this->db->where('EMPLOYEE_ID',$id);
        $query = $this->db->get();
 
        return $query->row();
    }
 
    public function save($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
 
    public function update($where, $data)
    {
        $this->db->update($this->table, $data, $where);
        return $this->db->affected_rows();
    }
 
    public function delete_by_id($id)
    {
        $this->db->where('EMPLOYEE_ID', $id);
        $this->db->delete($this->table);
    }
    
    function getAllEmployeeActiveList()
    {	
        $this->db->select('EMPLOYEE_ID, FIRST_NAME, MIDDLE_NAME, LAST_NAME');
        $this->db->where("RECORD_STATUS = 'A' and EMPLOYEE_ID <> 256");
        $this->db->order_by('FIRST_NAME, MIDDLE_NAME, LAST_NAME', 'asc'); 
        $query = $this->db->get($this->table);

        $employees = array();
        
        $employees[0] = 'Null Value';
        if($query->result()){
            foreach ($query->result() as $employee) {
                $emp_name = '';
                if(trim($employee->MIDDLE_NAME) == '' || $employee->MIDDLE_NAME == null){
                    $emp_name = $employee->FIRST_NAME.' '.$employee->LAST_NAME;
                }else{
                    $emp_name = $employee->FIRST_NAME.' '.$employee->MIDDLE_NAME.' '.$employee->LAST_NAME;
                }
                $employees[$employee->EMPLOYEE_ID] = $emp_name;
            }
        }
        return $employees;
    }
    
    function getItEmployeeActiveList()
    {	
        $this->db->select('EMPLOYEE_ID, FIRST_NAME, MIDDLE_NAME, LAST_NAME');
        $this->db->where("RECORD_STATUS = 'A' and EMPLOYEE_ID <> 256 and DEPARTMENT_REF = 5");
        $this->db->order_by('FIRST_NAME, MIDDLE_NAME, LAST_NAME', 'asc'); 
        $query = $this->db->get($this->table);

        $employees = array();
        
        $employees[0] = 'Null Value';
        if($query->result()){
            foreach ($query->result() as $employee) {
                $emp_name = '';
                if(trim($employee->MIDDLE_NAME) == '' || $employee->MIDDLE_NAME == null){
                    $emp_name = $employee->FIRST_NAME.' '.$employee->LAST_NAME;
                }else{
                    $emp_name = $employee->FIRST_NAME.' '.$employee->MIDDLE_NAME.' '.$employee->LAST_NAME;
                }
                $employees[$employee->EMPLOYEE_ID] = $emp_name;
            }
        }
        return $employees;
    }
    
    function getEmpName($emp_id){
        $query = $this->db->query("select case
                                           when MIDDLE_NAME is null then FIRST_NAME+' '+isnull(LAST_NAME, '')
                                           else FIRST_NAME+' '+MIDDLE_NAME+' '+isnull(LAST_NAME, '')
                                          end as emp_name
                                   from employee
                                   where EMPLOYEE_ID = $emp_id")->result();
        return $query[0]->emp_name;
    }
 
 
}