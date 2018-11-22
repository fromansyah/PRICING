<?php
class Plan_model extends CI_Model {
    
    public $title;
    public $content;
    public $date;
    private $_ci;
    var $table = 'plan';
    var $column_order = array('plan_id', 'implementation_periode_year', 'implementation_periode_month', 'product_no', 'cust_no', 'cust_site', 'price', 'sp_id', null); //set column field database for datatable orderable
    var $column_search = array('plan_id', 'implementation_periode_year', 'implementation_periode_month', 'product_no', 'cust_no', 'cust_site', 'price', 'sp_id'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $order = array('implementation_periode_year, implementation_periode_month' => 'desc'); // default order 
    
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
        $this->db->where('plan_id', $id);
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
        $this->db->where('plan_id', $id);
        $this->db->delete($this->table);
    }
    
    public function getPlan($fields=null, $limit=null, $where=null, $orderby=null) {
        ($fields != null) ? $this->db->select($fields) : '';
        ($where != null) ? $this->db->where($where) : '';
        ($limit != null) ? $this->db->limit($limit['start'], $limit['end']) : '';
        ($orderby != null) ? $this->db->order_by($orderby) : '';
        return $this->db->get($this->table);
    }

    public function getPlanOnFilter($cond, $limit=null, $orderby=null) {
        $this->db->like($cond);
        ($limit != null) ? $this->db->limit($limit['start'], $limit['end']) : '';
        ($orderby != null) ? $this->db->order_by($orderby) : '';
        return $this->db->get($this->table);
    }

    public function insertPlan($data)
    {
        $this->db->insert($this->table, $data);
    }

    public function deletePlan($id)
    {
        $this->db->where('plan_id', $id);
        $this->db->delete($this->table);
    }

    public function getPlanById($id)
    {
        $this->db->where('plan_id', $id);
        return $this->db->get($this->table);
    }

    public function updatePlan($where, $data)
    {
        $this->db->where($where);
        $this->db->update($this->table, $data);
        return $this->db->affected_rows();
    }

    public function idexists($id) {
        $opt = array('plan_id'=>$id);
        $q = $this->db->getwhere($this->table, $opt);
        $result = false;
        if ($q->num_rows() > 0) {
          $result = true;
        }
        $q->free_result();
        return $result;
    }

    public function get_plan_flexigrid()
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
    
    function getPlanList()
    {	
        $this->db->select('plan_id, product_no');
        $this->db->order_by('product_no', 'asc'); 
        $query = $this->db->get($this->table);

        $plans = array();
        $plans[0] = 'Null Value';
        if($query->result()){
            foreach ($query->result() as $plan) {
                $plans[$plan->plan_id] = $plan->product_no;
            }
        }
        return $plans;
    }
    
    public function getPlanData($product_no, $cust, $site, $year, $period){
        $query = $this->db->query("select *
                                   from plan
                                   where product_no = '$product_no'
                                         and cust_no = '$cust'
                                         and cust_site = '$site'
                                         and implementation_periode_year = $year
                                         and implementation_periode_month = $period");
        
        return $query->result();
    }
    
    public function getPlanForAgreement($product_no, $cust, $site, $year, $period){
        $query = $this->db->query("select *
                                   from plan
                                   where product_no = '$product_no'
                                         and cust_no = '$cust'
                                         and cust_site = '$site'
                                         and implementation_periode_year = $year
                                         and implementation_periode_month <= $period
                                   order by implementation_periode_year, implementation_periode_month desc");
        
        return $query->result();
        
    }
    
    public function getPlanNotificationList(){
        $query = $this->db->query("select concat('Plan notification(s) : ',count(*)) as notification, 
                                        'view_plan' as link, 
                                        'button_notif_warning' as class, 
                                        count(*) as notif_count,
                                        datediff(str_to_date(concat(plan.implementation_periode_year ,'-',plan.implementation_periode_month,'-01'), '%Y-%m-%d'), str_to_date(curdate(),'%Y-%m-%d')) - DAYOFMONTH(last_day(str_to_date(concat(plan.implementation_periode_year ,'-',plan.implementation_periode_month,'-01'),'%Y-%m-%d'))) as days
                                 from plan 
                                 where year(CURDATE()) >= plan.implementation_periode_year - 1
                                       and datediff(str_to_date(concat(plan.implementation_periode_year ,'-',plan.implementation_periode_month,'-01'), '%Y-%m-%d'), str_to_date(curdate(),'%Y-%m-%d')) - DAYOFMONTH(last_day(str_to_date(concat(plan.implementation_periode_year ,'-',plan.implementation_periode_month,'-01'),'%Y-%m-%d'))) <= 14
                                       and datediff(str_to_date(concat(plan.implementation_periode_year ,'-',plan.implementation_periode_month,'-01'), '%Y-%m-%d'), str_to_date(curdate(),'%Y-%m-%d')) - DAYOFMONTH(last_day(str_to_date(concat(plan.implementation_periode_year ,'-',plan.implementation_periode_month,'-01'),'%Y-%m-%d'))) >= -365
                                       and plan_id not in (select plan_id
                                                          from agreement
                                                          where agreement.agreement_date > curdate() - interval 1 year)");
        
        return $query->result();
    }
    
    public function getPlanNotification(){
        $query = $this->db->query("select plan.*,
                                        product.product_name,
                                        customer.cust_name,
                                        cust_site.note,
                                        employee.emp_name,
                                        employee.email,
                                        corporate.corp_id,
                                        corporate.corp_name,
                                        datediff(str_to_date(concat(plan.implementation_periode_year ,'-',plan.implementation_periode_month,'-01'), '%Y-%m-%d'), str_to_date(curdate(),'%Y-%m-%d')) - DAYOFMONTH(last_day(str_to_date(concat(plan.implementation_periode_year ,'-',plan.implementation_periode_month,'-01'),'%Y-%m-%d')))
                                 from plan left outer join customer on plan.cust_no = customer.cust_id
                                      left outer join cust_site on plan.cust_site = cust_site.site_id
                                      left outer join product on plan.product_no = product.product_no
                                      left outer join employee on plan.sp_id = employee.emp_id
                                      left outer join corporate on customer.corp_id = corporate.corp_id
                                 where datediff(str_to_date(concat(plan.implementation_periode_year ,'-',plan.implementation_periode_month,'-01'), '%Y-%m-%d'), str_to_date(curdate(),'%Y-%m-%d')) - DAYOFMONTH(last_day(str_to_date(concat(plan.implementation_periode_year ,'-',plan.implementation_periode_month,'-01'),'%Y-%m-%d'))) <= 500
                                       and datediff(str_to_date(concat(plan.implementation_periode_year ,'-',plan.implementation_periode_month,'-01'), '%Y-%m-%d'), str_to_date(curdate(),'%Y-%m-%d')) - DAYOFMONTH(last_day(str_to_date(concat(plan.implementation_periode_year ,'-',plan.implementation_periode_month,'-01'),'%Y-%m-%d'))) >= 0");
        
        return $query->result();
        
    }
}
?>