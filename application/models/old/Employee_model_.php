<?php
class Employee_model extends CI_Model {
    public $title;
    public $content;
    public $date;
    public $_table;
    private $_ci;
    public $id = 'EMPLOYEE_ID';
    public $order = 'ASC';
    
    public function __construct(){
        // Call the CI_Model constructor
        parent::__construct();
        $this->_table = 'employee';
        $this->_ci =& get_instance();
    }
    
    public function getEmployee($fields=null, $limit=null, $where=null, $orderby=null) {
        ($fields != null) ? $this->db->select($fields) : '';
        ($where != null) ? $this->db->where($where) : '';
        ($limit != null) ? $this->db->limit($limit['start'], $limit['end']) : '';
        ($orderby != null) ? $this->db->order_by($orderby) : '';
        return $this->db->get($this->_table);
    }

    public function getEmployeeOnFilter($cond, $limit=null, $orderby=null) {
        $this->db->like($cond);
        ($limit != null) ? $this->db->limit($limit['start'], $limit['end']) : '';
        ($orderby != null) ? $this->db->order_by($orderby) : '';
        return $this->db->get($this->_table);
    }

    public function insertEmployee($data)
    {
        $this->db->insert($this->_table, $data);
    }

    public function deleteEmployee($id)
    {
        $this->db->where('employee_id', $id);
        $this->db->delete($this->_table);
    }

    public function getEmployeeById($id)
    {
        $this->db->where('employee_id', $id);
        return $this->db->get($this->_table);
    }

    public function updateEmployee($where, $data)
    {
        $this->db->where($where);
        $this->db->update($this->_table, $data);
        return $this->db->affected_rows();
    }

    public function idexists($id) {
        $opt = array('employee_id'=>$id);
        $q = $this->db->getwhere($this->_table, $opt);
        $result = false;
        if ($q->num_rows() > 0) {
          $result = true;
        }
        $q->free_result();
        return $result;
    }

    public function get_employee_flexigrid()
    {
        //Build contents query
	$this->db->select('*')->from($this->_table);
        $this->_ci->flexigrid->build_query();

	$return['records'] = $this->db->get();
        
        $this->db->select('*')->from($this->_table);
        $this->_ci->flexigrid->build_query();
        $query = $this->db->get();
        $return['record_count'] = count($query->result());

	return $return;
    }
    
    function getAllEmployeeActiveList()
    {	
        $this->db->select('EMPLOYEE_ID, FIRST_NAME, MIDDLE_NAME, LAST_NAME');
        $this->db->where("RECORD_STATUS = 'A' and EMPLOYEE_ID <> 256");
        $this->db->order_by('FIRST_NAME, MIDDLE_NAME, LAST_NAME', 'asc'); 
        $query = $this->db->get($this->_table);

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
    
    // get total rows
    function total_rows() {
        $this->db->from($this->_table);
        return $this->db->count_all_results();
    }
    
    // get data with limit
    function index_limit($limit, $start = 0) {
        $this->db->order_by($this->id, $this->order);
        $this->db->limit($limit, $start);
        return $this->db->get($this->_table)->result();
    }
    
    // get search total rows
    function search_total_rows($keyword = NULL) {
        $this->db->like('EMPLOYEE_ID', $keyword);
	$this->db->or_like('FIRST_NAME', $keyword);
	$this->db->or_like('MIDDLE_NAME', $keyword);
	$this->db->or_like('LAST_NAME', $keyword);
	$this->db->or_like('EMP_INITIAL', $keyword);
	$this->db->or_like('EMAIL', $keyword);
	$this->db->from($this->_table);
        return $this->db->count_all_results();
    }

    // get search data with limit
    function search_index_limit($limit, $start = 0, $keyword = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('EMPLOYEE_ID', $keyword);
	$this->db->or_like('FIRST_NAME', $keyword);
	$this->db->or_like('MIDDLE_NAME', $keyword);
	$this->db->or_like('LAST_NAME', $keyword);
	$this->db->or_like('EMP_INITIAL', $keyword);
	$this->db->or_like('EMAIL', $keyword);
	$this->db->limit($limit, $start);
        return $this->db->get($this->_table)->result();
    }
    
    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->_table)->row();
    }
}
?>