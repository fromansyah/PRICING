<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Bukutelepon extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->support_lib->check_login();
        $this->load->model('bukutelepon_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $keyword = '';
        $this->load->library('pagination');

        $config['base_url'] = base_url() . 'bukutelepon/index/';
        $config['total_rows'] = $this->bukutelepon_model->total_rows();
        $config['per_page'] = 10;
        $config['uri_segment'] = 3;
        $config['suffix'] = '.html';
        $config['first_url'] = base_url() . 'bukutelepon.html';
        $this->pagination->initialize($config);

        $start = $this->uri->segment(3, 0);
        $bukutelepon = $this->bukutelepon_model->index_limit($config['per_page'], $start);

        $data = array(
            'bukutelepon_data' => $bukutelepon,
            'keyword' => $keyword,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );

        $this->load->view('bukutelepon_list', $data);
    }
    
    public function search() 
    {
        $keyword = $this->uri->segment(3, $this->input->post('keyword', TRUE));
        $this->load->library('pagination');
        
        if ($this->uri->segment(2)=='search') {
            $config['base_url'] = base_url() . 'bukutelepon/search/' . $keyword;
        } else {
            $config['base_url'] = base_url() . 'bukutelepon/index/';
        }

        $config['total_rows'] = $this->bukutelepon_model->search_total_rows($keyword);
        $config['per_page'] = 10;
        $config['uri_segment'] = 4;
        $config['suffix'] = '.html';
        $config['first_url'] = base_url() . 'bukutelepon/search/'.$keyword.'.html';
        $this->pagination->initialize($config);

        $start = $this->uri->segment(4, 0);
        $bukutelepon = $this->bukutelepon_model->search_index_limit($config['per_page'], $start, $keyword);

        $data = array(
            'bukutelepon_data' => $bukutelepon,
            'keyword' => $keyword,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->load->view('bukutelepon_list', $data);
    }

    public function read($id) 
    {
        $row = $this->bukutelepon_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'nama' => $row->nama,
		'alamat' => $row->alamat,
		'notelepon' => $row->notelepon,
	    );
            $this->load->view('bukutelepon_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('bukutelepon'));
        }
    }
    
    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('bukutelepon/create_action'),
	    'id' => set_value('id'),
	    'nama' => set_value('nama'),
	    'alamat' => set_value('alamat'),
	    'notelepon' => set_value('notelepon'),
	);
        $this->load->view('bukutelepon_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'nama' => $this->input->post('nama',TRUE),
		'alamat' => $this->input->post('alamat',TRUE),
		'notelepon' => $this->input->post('notelepon',TRUE),
	    );

            $this->bukutelepon_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('bukutelepon'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->bukutelepon_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('bukutelepon/update_action'),
		'id' => set_value('id', $row->id),
		'nama' => set_value('nama', $row->nama),
		'alamat' => set_value('alamat', $row->alamat),
		'notelepon' => set_value('notelepon', $row->notelepon),
	    );
            $this->load->view('bukutelepon_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('bukutelepon'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'nama' => $this->input->post('nama',TRUE),
		'alamat' => $this->input->post('alamat',TRUE),
		'notelepon' => $this->input->post('notelepon',TRUE),
	    );

            $this->bukutelepon_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('bukutelepon'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->bukutelepon_model->get_by_id($id);

        if ($row) {
            $this->bukutelepon_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('bukutelepon'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('bukutelepon'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nama', ' ', 'trim|required');
	$this->form_validation->set_rules('alamat', ' ', 'trim|required');
	$this->form_validation->set_rules('notelepon', ' ', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

};

/* End of file Bukutelepon.php */
/* Location: ./application/controllers/Bukutelepon.php */