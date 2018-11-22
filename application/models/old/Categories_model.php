<?php
class Categories_model extends CI_Model {
    public $title;
    public $content;
    public $date;
    private $_ci;
    var $table = 'categories';
    var $column_order = array('category_id', 'category_name', 'num_of_year', 'depreciation_percentage', 'category_desc', null); //set column field database for datatable orderable
    var $column_search = array('category_id', 'category_name', 'num_of_year', 'depreciation_percentage', 'category_desc'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $order = array('category_id' => 'ASC'); // default order 
    
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
        $this->db->where('category_id',$id);
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
        $this->db->where('category_id', $id);
        $this->db->delete($this->table);
    }

    public function insertCategory($data)
    {
        $this->db->insert($this->table, $data);
    }

    public function deleteCategory($id)
    {
        $this->db->where('category_id', $id);
        $this->db->delete($this->table);
    }

    public function getCategoryById($id)
    {
        $this->db->where('category_id', $id);
        return $this->db->get($this->table);
    }

    public function updateCategory($where, $data)
    {
        $this->db->where($where);
        $this->db->update($this->table, $data);
        return $this->db->affected_rows();
    }

    function getAllCategoryList()
    {	
        $query = $this->db->get($this->table);

        $category_list = array();
        $category_list['#'] = 'Please Choose One';
                
        if($query->result()){
            foreach ($query->result() as $category) {
                $category_list[$category->category_id] = $category->category_name;
            }
        }
        return $category_list;
    }
}
?>