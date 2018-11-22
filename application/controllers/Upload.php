<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload extends CI_Controller {
    
    public function __construct()
    {
	parent::__construct();
        $this->support_lib->check_login();
        $this->load->helper('flexigrid');
        $this->load->library('flexigrid');
        $this->load->library('Dynamic_menu');
        $this->load->library('pagination');
        $this->load->library('Zend');
        $this->zend->load('Zend/Barcode');
        $this->load->helper('file');
        $this->load->helper(array('form', 'url'));
        $this->load->model('Product_model', 'Product');
        $this->load->model('Product_price_model', 'Product_price');
        $this->load->model('Corporate_model', 'Corporate');
        $this->load->model('Customer_model', 'Customer');
        $this->load->model('Cust_site_model', 'Cust_site');
        $this->load->model('Sales_person_model', 'Sales_person');
        $this->load->model('Cam_model', 'Cam');
    }
    
    public function index()
    {
        $this->load->helper('url');
        $data['page_title'] = 'Upload Asset';
        
        $data['content'] = $this->load->view('Upload/upload_asset', $data, TRUE);
        $this->load->view($this->session->userdata("template"), $data);
    }

    public function do_upload_product($file){
        
        $ViewData=read_file("./csv/log_product.txt");
        write_file("./csv/log_product.txt", $ViewData."\n\n".date('Y-m-d H:i:s', strtotime('now'))." by ".$this->session->userdata("username"));
 
        $this->load->library('csvreader');
    
        $filePath = './csv/'.$file;
        
        $data = $this->csvreader->parse_file($filePath);
        $row = 1;
        $num_success = 0;
        $num_fail = 0;
        $success = array();
        $fail = array();
        $success_prod = array();
        $fail_prod = array();
        $fail_note = array();
        foreach($data as $field){
            
            $product_no = $field['PRODUCT_NO'];
            $product_name = $field['PRODUCT_NAME'];
            $desc = $field['DESC'];

            $data_product = array(
                    'product_no' => $product_no,
                    'product_name' => $product_name,
                    'desc' => $desc,
                    'created_by' => $this->session->userdata("username"),
                    'created_date' => date('Y-m-d H:i:s', strtotime('now')),
                    'last_update_by' => $this->session->userdata("username"),
                    'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
            );
            
            $check = $this->Product->getProductById($product_no)->result();

            if(count($check) == 0){
                $this->Product->save($data_product);
                //if($this->Product->save($data_product)){
                    $success[$num_success] = $row;
                    $success_prod[$num_success] = $product_no;
                    $num_success++;
                /*}else{
                    $fail[$num_fail] = $row;
                    $fail_prod[$num_fail] = $product_no;
                    $fail_note[$num_fail] = 'Error while saving.';
                    $num_fail++;
                    
                    $ViewData=read_file("./csv/log_product.txt");
                    $text = $ViewData."\n Line ".$row.'. '.$product_no.' Error while saving.';
                    write_file("./csv/log_product.txt", $text);
                }*/
            }else{
                $fail[$num_fail] = $row;
                $fail_prod[$num_fail] = $product_no;
                $fail_note[$num_fail] = 'Product number already exist.';
                $num_fail++;
                
                $ViewData=read_file("./csv/log_product.txt");
                $text = $ViewData."\n Line ".$row.'. '.$product_no.' Product number already exist.';
                write_file("./csv/log_product.txt", $text);
            }
            
            $row++;
        }
        
        if($num_fail == 0){
            $ViewData=read_file("./csv/log_product.txt");
            write_file("./csv/log_product.txt", $ViewData."\n Upload success.");
        }
        
        //$data4['csvData'] = $this->csvreader->parse_file($filePath);
        $data['num_success'] = $num_success;
        $data['num_fail'] = $num_fail;
        $data['success'] = $success;
        $data['fail'] = $fail;
        $data['success_prod'] = $success_prod;
        $data['fail_prod'] = $fail_prod;
        $data['fail_note'] = $fail_note;
        
        $this->load->view('Upload/csv_view_product', $data);
    }

    public function do_upload_price($file){
        
        $ViewData=read_file("./csv/log_product_price.txt");
        write_file("./csv/log_product_price.txt", $ViewData."\n\n".date('Y-m-d H:i:s', strtotime('now'))." by ".$this->session->userdata("username"));
 
        $this->load->library('csvreader');
    
        $filePath = './csv/'.$file;
        
        $data = $this->csvreader->parse_file($filePath);
        $row = 1;
        $num_success = 0;
        $num_fail = 0;
        $success = array();
        $fail = array();
        $success_prod = array();
        $fail_prod = array();
        $fail_note = array();
        foreach($data as $field){
            
            $product_no = $field['PRODUCT_NO'];
            $year = $field['YEAR'];
            $periode= $field['PERIODE'];
            $catalogue_price = $field['CATALOGUE_PRICE'];
            $sb_price = $field['SB_PRICE'];

            $data_price = array(
                    'product_no' => $product_no,
                    'periode_year' => $year,
                    'periode_month' => $periode,
                    'catalogue_price' => $catalogue_price,
                    'sb_price' => $sb_price,
                    'created_by' => $this->session->userdata("username"),
                    'created_date' => date('Y-m-d H:i:s', strtotime('now')),
                    'last_update_by' => $this->session->userdata("username"),
                    'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
            );
            
            $check_product = $this->Product->getProductById($product_no)->result();
            
            if(count($check_product)==0){
                $fail[$num_fail] = $row;
                $fail_prod[$num_fail] = $product_no;
                $fail_note[$num_fail] = 'Product Number does not exist.';
                $num_fail++;
                
                $ViewData=read_file("./csv/log_product_price.txt");
                $text = $ViewData."\n Line ".$row.'. '.$product_no.' Product number does not exist.';
                write_file("./csv/log_product_price.txt", $text);
            }else{
                $check = $this->Product_price->checkProductPrice($product_no, $year, $periode);

                if(count($check) == 0){
                    $this->Product_price->save($data_price);

                    $success[$num_success] = $row;
                    $success_prod[$num_success] = $product_no;
                    $num_success++;
                }else{
                    $fail[$num_fail] = $row;
                    $fail_prod[$num_fail] = $product_no;
                    $fail_note[$num_fail] = 'Product price already exist.';
                    $num_fail++;

                    $ViewData=read_file("./csv/log_product_price.txt");
                    $text = $ViewData."\n Line ".$row.'. '.$product_no.' Product price already exist.';
                    write_file("./csv/log_product_price.txt", $text);
                }
            }
            
            $row++;
        }
        
        if($num_fail == 0){
            $ViewData=read_file("./csv/log_product_price.txt");
            write_file("./csv/log_product_price.txt", $ViewData."\n Upload success.");
        }
        
        //$data4['csvData'] = $this->csvreader->parse_file($filePath);
        $data['num_success'] = $num_success;
        $data['num_fail'] = $num_fail;
        $data['success'] = $success;
        $data['fail'] = $fail;
        $data['success_prod'] = $success_prod;
        $data['fail_prod'] = $fail_prod;
        $data['fail_note'] = $fail_note;
        
        $this->load->view('Upload/csv_view_price', $data);
    }

    public function do_upload_corporate($file){
        
        $ViewData=read_file("./csv/log_corporate.txt");
        write_file("./csv/log_corporate.txt", $ViewData."\n\n".date('Y-m-d H:i:s', strtotime('now'))." by ".$this->session->userdata("username"));
 
        $this->load->library('csvreader');
    
        $filePath = './csv/'.$file;
        
        $data = $this->csvreader->parse_file($filePath);
        $row = 1;
        $num_success = 0;
        $num_fail = 0;
        $success = array();
        $fail = array();
        $success_corp = array();
        $fail_corp = array();
        $fail_note = array();
        foreach($data as $field){
            
            $corp_id = $field['CORP_NO'];
            $corp_name = $field['CORP_NAME'];
            $note = $field['NOTE'];

            $data_corp = array(
                    'corp_id' => $corp_id,
                    'corp_name' => $corp_name,
                    'note' => $note,
                    'created_by' => $this->session->userdata("username"),
                    'created_date' => date('Y-m-d H:i:s', strtotime('now')),
                    'last_update_by' => $this->session->userdata("username"),
                    'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
            );
            
            $check = $this->Corporate->getCorporateById($corp_id)->result();

            if(count($check) == 0){
                $this->Corporate->save($data_corp);
                $success[$num_success] = $row;
                $success_corp[$num_success] = $corp_id;
                $num_success++;
            }else{
                $fail[$num_fail] = $row;
                $fail_corp[$num_fail] = $corp_id;
                $fail_note[$num_fail] = 'Corporate number already exist.';
                $num_fail++;
                
                $ViewData=read_file("./csv/log_corporate.txt");
                $text = $ViewData."\n Line ".$row.'. '.$corp_id.' Corporate number already exist.';
                write_file("./csv/log_corporate.txt", $text);
            }
            
            $row++;
        }
        
        if($num_fail == 0){
            $ViewData=read_file("./csv/log_corporate.txt");
            write_file("./csv/log_corporate.txt", $ViewData."\n Upload success.");
        }
        
        $data['num_success'] = $num_success;
        $data['num_fail'] = $num_fail;
        $data['success'] = $success;
        $data['fail'] = $fail;
        $data['success_corp'] = $success_corp;
        $data['fail_corp'] = $fail_corp;
        $data['fail_note'] = $fail_note;
        
        $this->load->view('Upload/csv_view_corporate', $data);
    }

    public function do_upload_customer($file){
        
        $ViewData=read_file("./csv/log_customer.txt");
        write_file("./csv/log_customer.txt", $ViewData."\n\n".date('Y-m-d H:i:s', strtotime('now'))." by ".$this->session->userdata("username"));
 
        $this->load->library('csvreader');
    
        $filePath = './csv/'.$file;
        
        $data = $this->csvreader->parse_file($filePath);
        $row = 1;
        $num_success = 0;
        $num_fail = 0;
        $success = array();
        $fail = array();
        $success_cust = array();
        $fail_cust = array();
        $fail_note = array();
        foreach($data as $field){
            
            $cust_id = $field['CUST_NO'];
            $cust_name = $field['CUST_NAME'];
            $cust_type = $field['CUST_TYPE'];
            $corp_id = $field['CORP_ID'];
            $bu = $field['BU'];
            $note = $field['NOTE'];

            $data_cust = array(
                    'cust_id' => $cust_id,
                    'cust_name' => $cust_name,
                    'cust_type' => $cust_type,
                    'corp_id' => $corp_id,
                    'bu' => $bu,
                    'note' => $note,
                    'created_by' => $this->session->userdata("username"),
                    'created_date' => date('Y-m-d H:i:s', strtotime('now')),
                    'last_update_by' => $this->session->userdata("username"),
                    'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
            );
            
            $check = $this->Customer->getCustomerById($cust_id)->result();

            if(count($check) == 0){
                $this->Customer->save($data_cust);
                $success[$num_success] = $row;
                $success_cust[$num_success] = $cust_id;
                $num_success++;
            }else{
                $fail[$num_fail] = $row;
                $fail_cust[$num_fail] = $cust_id;
                $fail_note[$num_fail] = 'Customer number already exist.';
                $num_fail++;
                
                $ViewData=read_file("./csv/log_customer.txt");
                $text = $ViewData."\n Line ".$row.'. '.$cust_id.' Customer number already exist.';
                write_file("./csv/log_customer.txt", $text);
            }
            
            $row++;
        }
        
        if($num_fail == 0){
            $ViewData=read_file("./csv/log_customer.txt");
            write_file("./csv/log_customer.txt", $ViewData."\n Upload success.");
        }
        
        $data['num_success'] = $num_success;
        $data['num_fail'] = $num_fail;
        $data['success'] = $success;
        $data['fail'] = $fail;
        $data['success_cust'] = $success_cust;
        $data['fail_cust'] = $fail_cust;
        $data['fail_note'] = $fail_note;
        
        $this->load->view('Upload/csv_view_customer', $data);
    }

    public function do_upload_site($file){
        
        $ViewData=read_file("./csv/log_customer_site.txt");
        write_file("./csv/log_customer_site.txt", $ViewData."\n\n".date('Y-m-d H:i:s', strtotime('now'))." by ".$this->session->userdata("username"));
 
        $this->load->library('csvreader');
    
        $filePath = './csv/'.$file;
        
        $data = $this->csvreader->parse_file($filePath);
        $row = 1;
        $num_success = 0;
        $num_fail = 0;
        $success = array();
        $fail = array();
        $success_site = array();
        $fail_site = array();
        $fail_note = array();
        foreach($data as $field){
            
            $cust_id = $field['CUST_ID'];
            $site_id = $field['SITE_ID'];
            $note = $field['NOTE'];

            $data_site = array(
                    'cust_id' => $cust_id,
                    'site_id' => $site_id,
                    'note' => $note,
                    'created_by' => $this->session->userdata("username"),
                    'created_date' => date('Y-m-d H:i:s', strtotime('now')),
                    'last_update_by' => $this->session->userdata("username"),
                    'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
            );
            
            $check_cust = $this->Customer->getCustomerById($cust_id)->result();
            
            if(count($check_cust)==0){
                $fail[$num_fail] = $row;
                $fail_site[$num_fail] = $site_id;
                $fail_note[$num_fail] = 'Customer ID does not exist.';
                $num_fail++;
                
                $ViewData=read_file("./csv/log_customer_site.txt");
                $text = $ViewData."\n Line ".$row.'. '.$cust_id.' Customer ID does not exist.';
                write_file("./csv/log_customer_site.txt", $text);
            }else{
                $check = $this->Cust_site->getCustSiteById($site_id)->result();

                if(count($check) == 0){
                    $this->Cust_site->save($data_site);

                    $success[$num_success] = $row;
                    $success_site[$num_success] = $site_id;
                    $num_success++;
                }else{
                    $fail[$num_fail] = $row;
                    $fail_site[$num_fail] = $site_id;
                    $fail_note[$num_fail] = 'Customer site already exist.';
                    $num_fail++;

                    $ViewData=read_file("./csv/log_customer_site.txt");
                    $text = $ViewData."\n Line ".$row.'. '.$site_id.' Customer site already exist.';
                    write_file("./csv/log_customer_site.txt", $text);
                }
            }
            
            $row++;
        }
        
        if($num_fail == 0){
            $ViewData=read_file("./csv/log_customer_site.txt");
            write_file("./csv/log_customer_site.txt", $ViewData."\n Upload success.");
        }
        
        //$data4['csvData'] = $this->csvreader->parse_file($filePath);
        $data['num_success'] = $num_success;
        $data['num_fail'] = $num_fail;
        $data['success'] = $success;
        $data['fail'] = $fail;
        $data['success_site'] = $success_site;
        $data['fail_site'] = $fail_site;
        $data['fail_note'] = $fail_note;
        
        $this->load->view('Upload/csv_view_site', $data);
    }

    public function do_upload_sales_person($file){
        
        $ViewData=read_file("./csv/log_sales_person.txt");
        write_file("./csv/log_sales_person.txt", $ViewData."\n\n".date('Y-m-d H:i:s', strtotime('now'))." by ".$this->session->userdata("username"));
 
        $this->load->library('csvreader');
    
        $filePath = './csv/'.$file;
        
        $data = $this->csvreader->parse_file($filePath);
        $row = 1;
        $num_success = 0;
        $num_fail = 0;
        $success = array();
        $fail = array();
        $success_sp = array();
        $fail_sp = array();
        $fail_note = array();
        foreach($data as $field){
            
            $sp_id = $field['SP_ID'];
            $sp_name = $field['SP_NAME'];
            $note = $field['NOTE'];

            $data_sp = array(
                    'sp_id' => $sp_id,
                    'sp_name' => $sp_name,
                    'note' => $note,
                    'created_by' => $this->session->userdata("username"),
                    'created_date' => date('Y-m-d H:i:s', strtotime('now')),
                    'last_update_by' => $this->session->userdata("username"),
                    'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
            );
            
            $check = $this->Sales_person->getSalesPersonById($sp_id)->result();

            if(count($check) == 0){
                $this->Sales_person->save($data_sp);
                $success[$num_success] = $row;
                $success_sp[$num_success] = $sp_id;
                $num_success++;
            }else{
                $fail[$num_fail] = $row;
                $fail_sp[$num_fail] = $sp_id;
                $fail_note[$num_fail] = 'Sales person ID already exist.';
                $num_fail++;
                
                $ViewData=read_file("./csv/log_sales_person.txt");
                $text = $ViewData."\n Line ".$row.'. '.$sp_id.' Sales person ID already exist.';
                write_file("./csv/log_sales_person.txt", $text);
            }
            
            $row++;
        }
        
        if($num_fail == 0){
            $ViewData=read_file("./csv/log_sales_person.txt");
            write_file("./csv/log_sales_person.txt", $ViewData."\n Upload success.");
        }
        
        $data['num_success'] = $num_success;
        $data['num_fail'] = $num_fail;
        $data['success'] = $success;
        $data['fail'] = $fail;
        $data['success_sp'] = $success_sp;
        $data['fail_sp'] = $fail_sp;
        $data['fail_note'] = $fail_note;
        
        $this->load->view('Upload/csv_view_sales_person', $data);
    }

    public function do_upload_cam($file){
        
        $ViewData=read_file("./csv/log_cam.txt");
        write_file("./csv/log_cam.txt", $ViewData."\n\n".date('Y-m-d H:i:s', strtotime('now'))." by ".$this->session->userdata("username"));
 
        $this->load->library('csvreader');
    
        $filePath = './csv/'.$file;
        
        $data = $this->csvreader->parse_file($filePath);
        $row = 1;
        $num_success = 0;
        $num_fail = 0;
        $success = array();
        $fail = array();
        $success_cam = array();
        $fail_cam = array();
        $fail_note = array();
        foreach($data as $field){
            
            $cam_id = $field['CAM_ID'];
            $cam_name = $field['CAM_NAME'];
            $note = $field['NOTE'];

            $data_cam = array(
                    'cam_id' => $cam_id,
                    'cam_name' => $cam_name,
                    'note' => $note,
                    'created_by' => $this->session->userdata("username"),
                    'created_date' => date('Y-m-d H:i:s', strtotime('now')),
                    'last_update_by' => $this->session->userdata("username"),
                    'last_update_date' => date('Y-m-d H:i:s', strtotime('now'))
            );
            
            $check = $this->Cam->getCamById($cam_id)->result();

            if(count($check) == 0){
                $this->Cam->save($data_cam);
                $success[$num_success] = $row;
                $success_cam[$num_success] = $cam_id;
                $num_success++;
            }else{
                $fail[$num_fail] = $row;
                $fail_cam[$num_fail] = $cam_id;
                $fail_note[$num_fail] = 'CAM ID already exist.';
                $num_fail++;
                
                $ViewData=read_file("./csv/log_cam.txt");
                $text = $ViewData."\n Line ".$row.'. '.$cam_id.' CAM ID already exist.';
                write_file("./csv/log_cam.txt", $text);
            }
            
            $row++;
        }
        
        if($num_fail == 0){
            $ViewData=read_file("./csv/log_cam.txt");
            write_file("./csv/log_cam.txt", $ViewData."\n Upload success.");
        }
        
        $data['num_success'] = $num_success;
        $data['num_fail'] = $num_fail;
        $data['success'] = $success;
        $data['fail'] = $fail;
        $data['success_cam'] = $success_cam;
        $data['fail_cam'] = $fail_cam;
        $data['fail_note'] = $fail_note;
        
        $this->load->view('Upload/csv_view_cam', $data);
    }


}
?>
