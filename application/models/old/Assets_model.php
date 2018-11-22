<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Assets_model extends CI_Model {
 
    var $table = 'assets';
    var $column_order = array('asset_id', 'barcode', 'name','category', 'payment_status_name', 'currency', 'value', 'status' ,null); //set column field database for datatable orderable
    var $column_search = array('barcode','name','category', 'payment_status_name', 'currency'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $order = array('asset_id' => 'DESC'); // default order 
 
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
        $this->db->where('asset_id',$id);
        $query = $this->db->get();
 
        return $query->row();
    }
 
    public function get_by_id_for_dispose($id)
    {
//        $this->db->from($this->table);
//        $this->db->where('asset_id',$id);
        $query = $this->db->query("select assets.*, depreciation.balance
                          from assets left outer join depreciation on assets.asset_id= depreciation.asset_id
                                                                   and LEFT(CONVERT(varchar, DATEADD(month, -1, GETDATE()),112),6) = CONVERT(varchar(4), depreciation.year)+depreciation.month
                          where assets.asset_id = $id");
//        $query = $this->db->get();
 
        return $query->row();
    }
 
    public function get_by_id_for_installment($id)
    {
//        $this->db->from($this->table);
//        $this->db->where('asset_id',$id);
        $query = $this->db->query("select *,
                                        case
                                         when installment_status = 0 then 'No Installment'
                                         else (select master_data.[name]
                                              from master_data
                                              where installment_status = master_data.[value] 
                                                    and master_data.[type]= 'INSTALLMENT_STATUS')
                                        end as installment_status_name
                                 from(
                                 select assets.asset_id,
                                        assets.[name],
                                        assets.barcode, 
                                        assets.idr_value,
                                        assets.[value] as ori_value,
                                        assets.currency,
                                        assets.rate,
                                        isnull(max(installment.status), 0) as installment_status,
                                        isnull(sum(installment.amount), 0) as installment_amount
                                 from assets left outer join installment on assets.asset_id = installment.asset_id
                                 where assets.asset_id = $id
                                 group by assets.asset_id,
                                          assets.[name],
                                          assets.barcode, 
                                          assets.idr_value,
                                          assets.[value],
                                          assets.currency,
                                          assets.rate) as data_installment");
//        $query = $this->db->get();
 
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
        $this->db->where('asset_id', $id);
        $this->db->delete($this->table);
    }

    public function getAssetById($id)
    {
        $this->db->where('asset_id', $id);
        return $this->db->get($this->table);
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

    public function updateAsset($where, $data)
    {
        $this->db->where($where);
        $this->db->update($this->table, $data);
        return $this->db->affected_rows();
    }
 
    public function insertAsset($data)
    {
        $this->db->insert($this->table, $data);
    }
    
    public function getAllAsset()
    {
        return $this->db->get($this->table);
    }
    public function getAssetByCategory(){
        $query = $this->db->query("select category, sum(idr_value) as value, year(getdate()) year
                                   from assets
                                   where assets.asset_id not in (select disposal.asset_id
                                                                 from disposal
                                                                 where disposal.[year] < year(getdate()))
                                         and assets.payment_status = 2
                                   group by category")->result();
        return $query;
        
    }
    
    function getItAssetList()
    {	
        $this->db->select('asset_id, barcode, name');
        $this->db->where('category', 'IT');
        $this->db->where('status', 'A');
        $this->db->order_by('barcode', 'asc'); 
        $query = $this->db->get($this->table);

        $assets = array();
        if($query->result()){
            foreach ($query->result() as $asset) {
                $assets[$asset->asset_id] = $asset->barcode.' ['.$asset->name.']';
            }
        }
        return $assets;
    }
}