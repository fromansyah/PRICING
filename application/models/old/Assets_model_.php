<?php
class Assets_model extends CI_Model {
    public $title;
    public $content;
    public $date;
    public $_table;
    private $_ci;
    public $id = 'asset_id';
    public $order = 'ASC';
    
    public function __construct(){
        // Call the CI_Model constructor
        parent::__construct();
        $this->_table='assets';
        $this->_ci =& get_instance();
    }
    
    public function get_last_ten_entries(){
        $query = $this->db->get($this->_table, 10);
        return $query->result();
    }
    
    public function get_asset_flexigrid()
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

    public function insertAsset($data)
    {
        $this->db->insert($this->_table, $data);
    }

    public function deleteAsset($id)
    {
        $this->db->where('asset_id', $id);
        $this->db->delete($this->_table);
    }

    public function getAssetById($id)
    {
        $this->db->where('asset_id', $id);
        return $this->db->get($this->_table);
    }

    public function updateAsset($where, $data)
    {
        $this->db->where($where);
        $this->db->update($this->_table, $data);
        return $this->db->affected_rows();
    }
    
    function getCounter($category, $dept, $year){
        $query = $this->db->query("select isnull(max(counter), 0) as counter
                                   from assets
                                   where category = '$category'
                                         and department_id = $dept
                                         and year = $year");
        return $query->result();
    }
    
    function getLastAssetId(){
        $query = $this->db->query("select max(asset_id) as last_asset_id from assets")->result();
        return $query[0]->last_asset_id;
        
    }
    
    function checkAssetDate($asset_id, $start_date){
        $query = $this->db->query("select count(*) as data_count
                                   from assets
                                   where assets.date <= '$start_date'
                                         and asset_id = $asset_id")->result();
        return $query[0]->data_count;
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
        $this->db->like('asset_id', $keyword);
	$this->db->or_like('barcode', $keyword);
	$this->db->or_like('name', $keyword);
	$this->db->or_like('category', $keyword);
	$this->db->or_like('dept_name', $keyword);
	$this->db->or_like('emp_name', $keyword);
	$this->db->from($this->_table);
        return $this->db->count_all_results();
    }

    // get search data with limit
    function search_index_limit($limit, $start = 0, $keyword = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('asset_id', $keyword);
	$this->db->or_like('barcode', $keyword);
	$this->db->or_like('name', $keyword);
	$this->db->or_like('category', $keyword);
	$this->db->or_like('dept_name', $keyword);
	$this->db->or_like('emp_name', $keyword);
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
