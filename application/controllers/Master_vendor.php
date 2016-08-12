<?php

/**
 * Created by PhpStorm.
 * User: acer
 * Date: 5/31/2016
 * Time: 9:52 PM
 */
class Master_vendor extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('vendor_model');
        $this->load->library('form_validation');
    }
    public function index()//menampilkan data dari model ke view menjadi berupa tampilan pagination
    {
        $keyword = '';
        $this->load->library('pagination');// memamngil library pagination

        $config['base_url'] = base_url() . 'master_vendor/index/';//menyambung base url dengan master_admin/index/ kemudian disimpan ke config base_url
        $config['total_rows'] = $this->vendor_model->total_rows();//memangil method total_rows di admin_model kemudian disimpan ke config total rows
        $config['per_page'] = 10;//menyimpan nilai 10 di config per_page yang difungsikan untuk pagination 10 data setiap pagenya
        $config['uri_segment'] = 3;//menyimpan nilai 3 pada config uri_segment yang akan digunakan url pada index data dalam bentuk pagination
        $config['suffix'] = '';//Menyimpan nilai string kosong di config sufix
        $config['first_url'] = base_url() . 'master_vendor';//menyambung base url dengan master_admin kemudian disimpan ke config base_url
        $this->pagination->initialize($config);//masukkan nilai config di method initialize yang ada di obyek pagination

        $start = $this->uri->segment(3, 0);//set nilai 3 dan 0 di method uri kemudian simpan nilai balikannya di start// start akan difungsikan sebagai penomeran di tabel
        $master_vendor = $this->vendor_model->index_limit($config['per_page'], $start);//set nilai config per_page dan start ke method index limit di obyek admin_model kemudian simpan nilai balikannya di master_user
        // master_user akan di pake untuk penyimpanan data berupa index berbatas

        $this->data = array(
            'master_vendor_data' => $master_vendor,
            'keyword' => $keyword,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );  //menyimpan array dari
        //dari data master_users yang memiliki nama indeks master_users_data
        //keyword yang memiliki nama indeks keyword
        //create links di pagination yang memiliki nama indeks pagination
        //config total_row yang memiliki nilai nama indeks total rows
        //start yang memiliki nama indeks start
        // ke data

        $this->content = 'admin/master_vendor/vendor_list';// menyimpan nilai admin/master_admin/admin_list ke content difungsikan untuk penetapan content di MY_Controller
        $this->layout();// memangil method layout
    }

    public function search() //pencarian
    {
        $keyword = $this->uri->segment(3, $this->input->post('keyword', TRUE));
        $this->load->library('pagination');

        if ($this->uri->segment(2)=='search') {
            $config['base_url'] = base_url() . 'master_vendor/search/' . $keyword;
        } else {
            $config['base_url'] = base_url() . 'master_vendor/index/';
        }

        $config['total_rows'] = $this->vendor_model->search_total_rows($keyword);
        $config['per_page'] = 10;
        $config['uri_segment'] = 4;
        $config['suffix'] = '';
        $config['first_url'] = base_url() . 'master_vendor/search/'.$keyword.'';
        $this->pagination->initialize($config);

        $start = $this->uri->segment(4, 0);
        $master_vendor = $this->vendor_model->search_index_limit($config['per_page'], $start, $keyword);

        $this->data = array(
            'master_vendor_data' => $master_vendor,
            'keyword' => $keyword,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->content = 'admin/master_vendor/vendor_list';
        $this->layout();
    }

    public function read($id) //membaca data
    {
        $row = $this->vendor_model->get_by_id($id);
        if ($row) {
            $this->data = array(
                'venId' => $row->venId,
                'venKode' => $row->venKode,
                'venName' => $row->venName,
            );
            $this->content = 'admin/master_vendor/vendor_read';
            $this->layout();
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('master_vendor'));
        }
    }

    public function create() //Masuk form create
    {
        $this->data = array(
            'button' => 'Create',
            'action' => site_url('master_vendor/create_action'),
            'venId' => set_value('venId'),
            'venKode' => set_value('venKode'),
            'venName' => set_value('venName'),
        );
        $this->content = 'admin/master_vendor/vendor_form';
        $this->layout();
    }

    public function create_action() //Mensyimpan data create ke database melalui model
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'venKode' => $this->input->post('venKode',TRUE),
                'venName' => $this->input->post('venName',TRUE),
            );

            $this->vendor_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('master_vendor'));
        }
    }

    public function update($id) //menuju ke form update
    {
        $row = $this->vendor_model->get_by_id($id);

        if ($row) {
            $this->data = array(
                'button' => 'Update',
                'action' => site_url('master_vendor/update_action'),
                'venId' => set_value('venId', $row->venId),
                'venKode' => set_value('venKode', $row->venKode),
                'venName' => set_value('venName', $row->venName),
            );
            $this->content = 'admin/master_vendor/vendor_form';
            $this->layout();
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('master_vendor'));
        }
    }

    public function update_action() //melakukan update ke database melalui model
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('venId', TRUE));
        } else {
            $data = array(
                'venKode' => $this->input->post('venKode',TRUE),
                'venName' => $this->input->post('venName',TRUE),
            );

            $this->vendor_model->update($this->input->post('venId', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('master_vendor'));
        }
    }

    public function delete($id) //melakukan delete data
    {
        $row = $this->vendor_model->get_by_id($id);

        if ($row) {
            $this->vendor_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('master_vendor'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('master_vendor'));
        }
    }

    public function _rules() //aturan validasi untuk form
    {
        $this->form_validation->set_rules('venKode', ' ', 'trim|required');
        $this->form_validation->set_rules('venName', ' ', 'trim|required');
        $this->form_validation->set_rules('venId', 'venId', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}