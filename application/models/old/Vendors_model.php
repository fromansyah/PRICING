<?php
class Vendors_model extends CI_Model {
    public $title;
    public $content;
    public $date;
    private $_ci;
    var $table = 'vendors';
    var $column_order = array('vendor_name', 'address', 'phone' ,'vendor_type', 'desc', null); //set column field database for datatable orderable
    var $column_search = array('vendor_name', 'address', 'phone'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $order = array('vendor_name' => 'ASC');
    
    public function __construct(){
        // Call the CI_Model constructor
        parent::__construct();
        $this->_ci =& get_instance();
        $this->load->database();
    }
    
    public function getVendor($fields=null, $limit=null, $where=null, $orderby=null) {
        ($fields != null) ? $this->db->select($fields) : '';
        ($where != null) ? $this->db->where($where) : '';
        ($limit != null) ? $this->db->limit($limit['start'], $limit['end']) : '';
        ($orderby != null) ? $this->db->order_by($orderby) : '';
        return $this->db->get($this->table);
    }

    public function getVendorOnFilter($cond, $limit=null, $orderby=null) {
        $this->db->like($cond);
        ($limit != null) ? $this->db->limit($limit['start'], $limit['end']) : '';
        ($orderby != null) ? $this->db->order_by($orderby) : '';
        return $this->db->get($this->table);
    }

    public function insertVendor($data)
    {
        $this->db->insert($this->table, $data);
    }

    public function deleteVendor($id)
    {
        $this->db->where('vendor_id', $id);
        $this->db->delete($this->table);
    }

    public function getVendorById($id)
    {
        $this->db->where('vendor_id', $id);
        return $this->db->get($this->table);
    }

    public function updateVendor($where, $data)
    {
        $this->db->where($where);
        $this->db->update($this->table, $data);
        return $this->db->affected_rows();
    }

    public function idexists($id) {
        $opt = array('vendor_id'=>$id);
        $q = $this->db->getwhere($this->table, $opt);
        $result = false;
        if ($q->num_rows() > 0) {
          $result = true;
        }
        $q->free_result();
        return $result;
    }

    public function get_vendor_flexigrid()
    {
        //Build contents query
	$this->db->select('*')->from($this->table);
        $this->_ci->flexigrid->build_query();

	$return['records'] = $this->db->get();
        
        $this->db->select('*')->from($this->table);
        $this->_ci->flexigrid->build_query();
        $query = $this->db->get();
        $return['record_count'] = count($query->result());

	return $return;
    }
    
    function getAllVendorList()
    {	
        $query = $this->db->get($this->table);

        $vendor_list = array();
        $vendor_list[0] = 'Null Value';
                
        if($query->result()){
            foreach ($query->result() as $vendor) {
                $vendor_list[$vendor->vendor_id] = $vendor->vendor_name;
            }
        }
        return $vendor_list;
    }
    
    function getVendorName($vendor_id){
        $query = $this->db->query("select vendor_name
                                   from vendors
                                   where vendor_id = $vendor_id")->result();
        return $query[0]->vendor_name;
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
        $this->db->where('vendor_id',$id);
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
        $this->db->where('vendor_id', $id);
        $this->db->delete($this->table);
    }
}
?>