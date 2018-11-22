<?php
class Installment_model extends CI_Model {
    
    public $title;
    public $content;
    public $date;
    private $_ci;
    var $table = 'installment';
    var $column_order = array('date', 'status', 'currency', 'rate', 'amount', 'note', null); //set column field database for datatable orderable
    var $column_search = array('date', 'status_name', 'currency', 'rate', 'amount', 'note'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $order = array('date' => 'ASC'); // default order 
    
    public function __construct(){
        // Call the CI_Model constructor
        parent::__construct();
        $this->_ci =& get_instance();
        $this->load->database();
    }
 
    private function _get_datatables_query($asset_id='')
    {
        $this->db->where('asset_id',$asset_id);
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
 
    function get_datatables($asset_id='')
    {
        $this->_get_datatables_query($asset_id);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered($asset_id = '')
    {
        $this->_get_datatables_query($asset_id);
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all($asset_id = '')
    {
        $this->db->where('asset_id',$asset_id);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
 
    public function get_by_id($id)
    {
        $this->db->from($this->table);
        $this->db->where('installment_id',$id);
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
        $this->db->where('installment_id', $id);
        $this->db->delete($this->table);
    }
    
    public function insertInstallment($data)
    {
        $this->db->insert($this->table, $data);
    }

    public function deleteInstallment($id)
    {
        $this->db->where('installment_id', $id);
        $this->db->delete($this->table);
    }

    public function getInstallmentById($id)
    {
        $this->db->where('installment_id', $id);
        return $this->db->get($this->table);
    }

    public function updateInstallment($where, $data)
    {
        $this->db->where($where);
        $this->db->update($this->table, $data);
        return $this->db->affected_rows();
    }
    
    function checkInstallment($asset_id, $status){
        $query = $this->db->query("select count(*) as data_count
                                   from installment
                                   where asset_id = $asset_id
                                         and status = $status")->result();
        return $query[0]->data_count;
    }
    
    function get_last_installment($asset_id){
        $query = $this->db->query("SELECT 
                                    installment_id,
                                    status,
                                    status_name
                                  FROM installment
                                  where asset_id = $asset_id
                                        and status = (select max(status) from installment where asset_id = $asset_id)")->result();
        return $query[0]->installment_id;
    }

    public function deleteInstallmentByAssetId($asset_id)
    {
        $this->db->where('asset_id', $asset_id);
        $this->db->delete($this->table);
    }
    
    function checkNumInstallment($asset_id){
        $query = $this->db->query("select count(*) as data_count
                                   from installment
                                   where asset_id = $asset_id")->result();
        return $query[0]->data_count;
    }
}
?>