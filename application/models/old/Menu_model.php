<?php
class Menu_model extends CI_Model {
    public $title;
    public $content;
    public $date;
    public $_table;
    private $_ci;
    
    public function __construct(){
        // Call the CI_Model constructor
        parent::__construct();
        $this->_table = 'menu';
        $this->_ci =& get_instance();
    }
    
    public function getMenu($fields=null, $limit=null, $where=null, $orderby=null) {
        ($fields != null) ? $this->db->select($fields) : '';
        ($where != null) ? $this->db->where($where) : '';
        ($limit != null) ? $this->db->limit($limit['start'], $limit['end']) : '';
        ($orderby != null) ? $this->db->order_by($orderby) : '';
        return $this->db->get($this->_table);
    }

    public function getMenuOnFilter($cond, $limit=null, $orderby=null) {
        $this->db->like($cond);
        ($limit != null) ? $this->db->limit($limit['start'], $limit['end']) : '';
        ($orderby != null) ? $this->db->order_by($orderby) : '';
        return $this->db->get($this->_table);
    }

    public function insertMenu($data)
    {
        $this->db->insert($this->_table, $data);
    }

    public function deleteMenu($id)
    {
        $this->db->where('id', $id);
        $this->db->delete($this->_table);
    }

    public function getMenuById($id)
    {
        $this->db->where('id', $id);
        return $this->db->get($this->_table);
    }

    public function updateMenu($where, $data)
    {
        $this->db->where($where);
        $this->db->update($this->_table, $data);
        return $this->db->affected_rows();
    }

    public function idexists($id) {
        $opt = array('id'=>$id);
        $q = $this->db->getwhere($this->_table, $opt);
        $result = false;
        if ($q->num_rows() > 0) {
          $result = true;
        }
        $q->free_result();
        return $result;
    }

    public function get_menu_flexigrid()
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
}
?>