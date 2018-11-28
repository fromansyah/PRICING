<?php

class backup_db extends CI_Controller {

    public function __construct()
    {
	parent::__construct();
        $this->support_lib->check_login();
        $this->load->library('Dynamic_menu');
        $this->load->helper('file');
    }
    
    function index()
    {
        $data['title'] = 'Backup Database';
        $data['content'] = $this->load->view('backup_db/backup_form', $data, TRUE);
        $this->load->view('form_template', $data);
    }
    
    function do_backup(){
        /*$filename='database_backup_'.date('Y-M-d_H.i.s', strtotime('+6 hours')).'.sql';

        $result=system("C:\\xampp\\mysql\\bin\\mysqldump --user=root --host=localhost pricing > ./backup/".$filename);

        $data['message'] = "Database Back Up Success!!";
        $data['message2'] = "Back Up file at C:\xampp\htdocs\PRICING\backup\ ".$filename;
        $data['content'] = $this->load->view('backup_db/result', $data, TRUE);
        $this->load->view('form_template', $data);*/
	
	$this->load->dbutil();

	$prefs = array(     
	    'format'      => 'zip',             
	    'filename'    => 'database_backup_'.date('Y-M-d_H.i.s', strtotime('+6 hours')).'.sql'
	    );


	$backup =& $this->dbutil->backup($prefs); 

	$db_name = 'backup-on-'. date("Y-m-d-H-i-s") .'.zip';
	$save = './backup/'.$db_name;

	$this->load->helper('file');
	write_file($save, $backup); 


	$this->load->helper('download');
	force_download($db_name, $backup);
    }
}
?>
