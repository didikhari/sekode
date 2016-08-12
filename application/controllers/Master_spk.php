<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Master_spk extends MY_Controller
{
    private $option;
    function __construct()
    {
        parent::__construct();
        $this->load->model('spk_model');
        $this->load->model('vendor_model');
        $this->load->helper('uploading');
        $this->option = $this->vendor_model->get_all_array();
        $this->load->library('form_validation');
    }

    public function index()
    {
        $master_spk = $this->spk_model->get_all();

        $this->data = array(
            'master_spk_data' => $master_spk,
            'option'    => $this->option,
        );
        $this->content = 'admin/master_spk/spk_list';
        $this->layout();

    }

    public function read($id) 
    {
        $row = $this->spk_model->get_by_id($id);
        if ($row) {
            $this->data = array(
        		'id' => $row->id,
        		'nospk' => $row->nospk,
                'nilai' => $row->nilai,
        		'vendor' => $row->vendor,
        		'tgl_awal' => date_formater($row->tgl_awal),
        		'masa' => $row->masa,
        		'tgl_akhir' => date_formater($row->tgl_akhir),
        		'uraian' => $row->uraian,
        		'kode_skki' => $row->kode_skki,
        		'ket_skko' => $row->ket_skko,
        		'no_pa' => $row->no_pa,
        		'nilai_rab' => $row->nilai_rab,
        		'no_rks' => $row->no_rks,
        		'expired' => $row->expired,
                'option' =>$this->option,
	       );
            $this->content = 'admin/master_spk/spk_read';
            $this->layout();
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('master_spk'));
        }
    }
    
    public function create() 
    {
        $this->data = array(
            'button' => 'Create',
            'action' => site_url('master_spk/create_action'),
    	    'id' => set_value('id'),
    	    'nospk' => set_value('nospk'),
            'nilai' => set_value('nilai'),
            'vendor' => set_value('vendor'),
    	    'tgl_awal' => set_value('tgl_awal'),
    	    'masa' => set_value('masa'),
    	    'tgl_akhir' => set_value('tgl_akhir'),
    	    'uraian' => set_value('uraian'),
    	    'kode_skki' => set_value('kode_skki'),
    	    'ket_skko' => set_value('ket_skko'),
    	    'no_pa' => set_value('no_pa'),
    	    'nilai_rab' => set_value('nilai_rab'),
    	    'no_rks' => set_value('no_rks'),
    	    'expired' => set_value('expired'),
            'option' => $this->option,
    	);
        $this->content = 'admin/master_spk/spk_form';
        $this->layout();
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
        		'nospk' => $this->input->post('nospk',TRUE),
                'nilai' => $this->input->post('nilai',TRUE),
        		'vendor' => $this->input->post('vendor',TRUE),
        		'tgl_awal' => date_for_mysql($this->input->post('tgl_awal',TRUE)),
        		'masa' => $this->input->post('masa',TRUE),
        		'tgl_akhir' => date_for_mysql($this->input->post('tgl_akhir',TRUE)),
        		'uraian' => $this->input->post('uraian',TRUE),
        		'kode_skki' => $this->input->post('kode_skki',TRUE),
        		'ket_skko' => $this->input->post('ket_skko',TRUE),
        		'no_pa' => $this->input->post('no_pa',TRUE),
        		'nilai_rab' => $this->input->post('nilai_rab',TRUE),
        		'no_rks' => $this->input->post('no_rks',TRUE),
        		'expired' => $this->input->post('expired',TRUE),
        	    );

            $this->spk_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('master_spk'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->spk_model->get_by_id($id);

        if ($row) {
            $this->data = array(
                'button' => 'Update',
                'action' => site_url('master_spk/update_action'),
        		'id' => set_value('id', $row->id),
        		'nospk' => set_value('nospk', $row->nospk),
                'nilai' => set_value('nilai', $row->nilai),
        		'vendor' => set_value('vendor', $row->vendor),
        		'tgl_awal' => set_value('tgl_awal', date_for_form($row->tgl_awal) ),
        		'masa' => set_value('masa', $row->masa),
        		'tgl_akhir' => set_value('tgl_akhir', date_for_form( $row->tgl_akhir) ),
        		'uraian' => set_value('uraian', $row->uraian),
        		'kode_skki' => set_value('kode_skki', $row->kode_skki),
        		'ket_skko' => set_value('ket_skko', $row->ket_skko),
        		'no_pa' => set_value('no_pa', $row->no_pa),
        		'nilai_rab' => set_value('nilai_rab', $row->nilai_rab),
        		'no_rks' => set_value('no_rks', $row->no_rks),
        		'expired' => set_value('expired', $row->expired),
                'option' => $this->option,
        	    );
            $this->content = 'admin/master_spk/spk_form';
            $this->layout();
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('master_spk'));
        }
    }
    
    public function update_action() 
    {

        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
        		'nospk' => $this->input->post('nospk',TRUE),
        		'vendor' => $this->input->post('vendor',TRUE),
                'nilai'  => $this->input->post('nilai',TRUE),
        		'tgl_awal' => date_for_mysql($this->input->post('tgl_awal',TRUE)),
        		'masa' => $this->input->post('masa',TRUE),
        		'tgl_akhir' => date_for_mysql($this->input->post('tgl_akhir',TRUE)),
        		'uraian' => $this->input->post('uraian',TRUE),
        		'kode_skki' => $this->input->post('kode_skki',TRUE),
        		'ket_skko' => $this->input->post('ket_skko',TRUE),
        		'no_pa' => $this->input->post('no_pa',TRUE),
        		'nilai_rab' => $this->input->post('nilai_rab',TRUE),
        		'no_rks' => $this->input->post('no_rks',TRUE),
        		'expired' => $this->input->post('expired',TRUE),
	    );

            $this->spk_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('master_spk'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->spk_model->get_by_id($id);

        if ($row) {
            $this->spk_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('master_spk'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('master_spk'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nospk', ' ', 'trim|required');
	$this->form_validation->set_rules('vendor', ' ', 'trim|required|numeric');
	$this->form_validation->set_rules('tgl_awal', ' ', 'trim|required');
	$this->form_validation->set_rules('masa', ' ', 'trim|required|numeric');
	$this->form_validation->set_rules('tgl_akhir', ' ', 'trim|required');
	$this->form_validation->set_rules('uraian', ' ', 'trim|required');
	$this->form_validation->set_rules('kode_skki', ' ', 'trim|required');
	$this->form_validation->set_rules('ket_skko', ' ', 'trim|required');
	$this->form_validation->set_rules('no_pa', ' ', 'trim|required');
	$this->form_validation->set_rules('nilai_rab', ' ', 'trim|required|numeric');
	$this->form_validation->set_rules('no_rks', ' ', 'trim|required');
	$this->form_validation->set_rules('expired', ' ', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

};

/* End of file Master_spk.php */
/* Location: ./application/controllers/Master_spk.php */