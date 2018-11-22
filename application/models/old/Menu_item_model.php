<?php
class Menu_item_model extends CI_Model {
    public $title;
    public $content;
    public $date;
    public $_table;
    private $_ci;
    
    public function __construct(){
        // Call the CI_Model constructor
        parent::__construct();
        $this->_table = 'menu_item';
        $this->_ci =& get_instance();
    }

  function getMenuItem($fields=null, $limit=null, $where=null, $orderby=null) {
    ($fields != null) ? $this->db->select($fields) : '';
    ($where != null) ? $this->db->where($where) : '';
    ($limit != null) ? $this->db->limit($limit['start'], $limit['end']) : '';
    ($orderby != null) ? $this->db->order_by($orderby) : '';
    return $this->db->get($this->_table);
  }

  function getMenuItemOnFilter($cond, $limit=null, $orderby=null) {
    $this->db->like($cond);
    ($limit != null) ? $this->db->limit($limit['start'], $limit['end']) : '';
    ($orderby != null) ? $this->db->order_by($orderby) : '';
    return $this->db->get($this->_table);
  }

  function insertMenuItem($data)
  {
    $this->db->insert($this->_table, $data);
  }

  function deleteMenuItem($id)
  {
    $this->db->where('id', $id);
    $this->db->delete($this->_table);
  }

  function getMenuItemById($id)
  {
    $this->db->where('id', $id);
    return $this->db->get($this->_table);
  }

  function updateMenuItem($where, $data)
  {
    $this->db->where($where);
    $this->db->update($this->_table, $data);
    return $this->db->affected_rows();
  }
  
  public function get_menuItem_flexigrid($menu_id)
  {
        /*//Select table name
        $table_name = "menu_item";

        //Build contents query
        $this->db->select('*')->from($table_name)->where("menu_id = $menu_id");
        $this->_ci->flexigrid->build_query();

        //Get contents
        $return['records'] = $this->db->get();

        //Build count query
        $this->db->select("count(id) as record_count")->from($table_name)->where("menu_id = $menu_id");
        $this->_ci->flexigrid->build_query(FALSE);
        $record_count = $this->db->get();
        $row = $record_count->row();

        //Get Record Count
        $return['record_count'] = $row->record_count;

        //Return all
        return $return;*/
        
        //Build contents query
	$this->db->select('*')->from($this->_table)->where("menu_id = $menu_id");
        $this->_ci->flexigrid->build_query();

	$return['records'] = $this->db->get();
        
        $this->db->select('*')->from($this->_table)->where("menu_id = $menu_id");
        $this->_ci->flexigrid->build_query();
        $query = $this->db->get();
        $return['record_count'] = count($query->result());

	return $return;
  }
  
  function getAllMenuItemList()
    {	
        $query = $this->db->get($this->_table);

        $menu_list = array();

        if($query->result()){
            foreach ($query->result() as $menu) {
                $menu_list[$menu->id] = $menu->menu_name;
            }
        }
        return $menu_list;
    }
}
?>