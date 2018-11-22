<?php
class Vendor_type_model extends CI_Model {
    public $title;
    public $content;
    public $date;
    private $_ci;
    var $table = 'vendor_type';
    var $column_order = array('vendor_type_name', 'desc', null); //set column field database for datatable orderable
    var $column_search = array('vendor_type_name', 'desc'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $order = array('vendor_type_name' => 'ASC'); // default order 
    
    public function __construct(){
        // Call the CI_Model constructor
        parent::__construct();
        $this->_ci =& get_instance();
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
        $this->db->where('vendor_type_id',$id);
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
        $this->db->where('vendor_type_id', $id);
        $this->db->delete($this->table);
    }
    

    public function insertVendorType($data)
    {
        $this->db->insert($this->table, $data);
    }

    public function deleteVendorType($id)
    {
        $this->db->where('vendor_type_id', $id);
        $this->db->delete($this->table);
    }

    public function getVendorTypeById($id)
    {
        $this->db->where('vendor_type_id', $id);
        return $this->db->get($this->table);
    }

    public function updateVendorType($where, $data)
    {
        $this->db->where($where);
        $this->db->update($this->table, $data);
        return $this->db->affected_rows();
    }

    public function getVendorTypeList(){
        $query = $this->db->get($this->table);

        $list = array();
        $list['#'] = 'Please Select';
        if($query->result()){
            foreach ($query->result() as $menu) {
                $list[$menu->vendor_type_id] = $menu->vendor_type_name;
            }
        }
        
        return $list;
    }
}
?>