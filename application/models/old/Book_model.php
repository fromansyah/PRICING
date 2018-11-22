<?php
class Book_model extends CI_Model {
    public $title;
    public $content;
    public $date;
    
    public function __construct(){
        // Call the CI_Model constructor
        parent::__construct();
        $this->_table='book';
    }
    
    public function get_last_ten_entries(){
        $query = $this->db->get($this->_table, 10);
        return $query->result();
    }
}
?>
