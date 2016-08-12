<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Master_admin extends MY_Controller
{
    private $option;
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('admin_model');
        $this->load->model('role_model');
        $this->option = $this->role_model->get_all_array();
        $this->load->library('form_validation');
        $this->load->library('encrypt');
    }

    public function index()//menampilkan data dari model ke view menjadi berupa tampilan pagination
    {
        
        $keyword = '';
        $this->load->library('pagination');// memamngil library pagination

        $config['base_url'] = base_url() . 'master_admin/index/';//menyambung base url dengan master_admin/index/ kemudian disimpan ke config base_url 
        $config['total_rows'] = $this->admin_model->total_rows();//memangil method total_rows di admin_model kemudian disimpan ke config total rows
        $config['per_page'] = 10;//menyimpan nilai 10 di config per_page yang difungsikan untuk pagination 10 data setiap pagenya
        $config['uri_segment'] = 3;//menyimpan nilai 3 pada config uri_segment yang akan digunakan url pada index data dalam bentuk pagination
        $config['suffix'] = '';//Menyimpan nilai string kosong di config sufix
        $config['first_url'] = base_url() . 'master_admin';//menyambung base url dengan master_admin kemudian disimpan ke config base_url 
        $this->pagination->initialize($config);//masukkan nilai config di method initialize yang ada di obyek pagination

        $start = $this->uri->segment(3, 0);//set nilai 3 dan 0 di method uri kemudian simpan nilai balikannya di start// start akan difungsikan sebagai penomeran di tabel
        $master_users = $this->admin_model->index_limit($config['per_page'], $start);//set nilai config per_page dan start ke method index limit di obyek admin_model kemudian simpan nilai balikannya di master_user
        // master_user akan di pake untuk penyimpanan data berupa index berbatas

        $this->data = array(
            'master_users_data' => $master_users,
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

        $this->content = 'admin/master_admin/admin_list';// menyimpan nilai admin/master_admin/admin_list ke content difungsikan untuk penetapan content di MY_Controller
        $this->layout();// memangil method layout
    }
    
    public function search() //pencarian
    {
        $keyword = $this->uri->segment(3, $this->input->post('keyword', TRUE));
        $this->load->library('pagination');
        
        if ($this->uri->segment(2)=='search') {
            $config['base_url'] = base_url() . 'master_admin/search/' . $keyword;
        } else {
            $config['base_url'] = base_url() . 'master_admin/index/';
        }

        $config['total_rows'] = $this->admin_model->search_total_rows($keyword);
        $config['per_page'] = 10;
        $config['uri_segment'] = 4;
        $config['suffix'] = '';
        $config['first_url'] = base_url() . 'master_admin/search/'.$keyword.'';
        $this->pagination->initialize($config);

        $start = $this->uri->segment(4, 0);
        $master_users = $this->admin_model->search_index_limit($config['per_page'], $start, $keyword);

        $this->data = array(
            'master_users_data' => $master_users,
            'keyword' => $keyword,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->content = 'admin/master_admin/admin_list';
        $this->layout();
    }

    public function read($id) //membaca data
    {
        $row = $this->admin_model->get_by_id($id);
        if ($row) {
            $this->data = array(
		      'id' => $row->id,
		      'name' => $row->name,
              'username' => $row->username,
		      'email' => $row->email,
		      'password' => $row->password,
	        );
            $this->content = 'admin/master_admin/admin_read';
            $this->layout();
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('master_admin'));
        }
    }
    
    public function create() //Masuk form create
    {
        $this->data = array(
            'button' => 'Create',
            'action' => site_url('master_admin/create_action'),
	        'id' => set_value('id'),
	        'username' => set_value('username'),
            'name' => set_value('name'),
	        'email' => set_value('email'),
	        'password' => set_value('password'),
            'option' => $this->option,
            'role'  => set_value('role'),
	    );
        $this->content = 'admin/master_admin/admin_form';
        $this->layout();
    }
    
    public function create_action() //Mensyimpan data create ke database melalui model
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
    		      'name' => $this->input->post('name',TRUE),
                  'username' => $this->input->post('username',TRUE),
    		      'email' => $this->input->post('email',TRUE),

    		      'password' => $this->encrypt->hash($this->input->post('password',TRUE)),
                  'role'    => $this->input->post('role',TRUE),
	        );

            $this->admin_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('master_admin'));
        }
    }
    
    public function update($id) //menuju ke form update
    {
        $row = $this->admin_model->get_by_id($id);

        if ($row) {
            $this->data = array(
                'button' => 'Update',
                'action' => site_url('master_admin/update_action'),
        		'id' => set_value('id', $row->id),
        		'name' => set_value('name', $row->name),
                'username' => set_value('username', $row->username),
        		'email' => set_value('email', $row->email),
        		'password' => set_value('password'),
                'option' => $this->option,
                'role'  =>  set_value('name', $row->role),
	        );
            $this->content = 'admin/master_admin/admin_form';
            $this->layout();
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('master_admin'));
        }
    }
    
    public function update_action() //melakukan update ke database melalui model
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'name' => $this->input->post('name',TRUE),
        'username' => $this->input->post('username',TRUE),
		'email' => $this->input->post('email',TRUE),
		'password' =>$this->encrypt->hash($this->input->post('password',TRUE)),
        'role' => $this->input->post('role',TRUE),
	    );

            $this->admin_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('master_admin'));
        }
    }
    
    public function delete($id) //melakukan delete data
    {
        $row = $this->admin_model->get_by_id($id);

        if ($row) {
            $this->admin_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('master_admin'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('master_admin'));
        }
    }

    public function _rules() //aturan validasi untuk form
    {
    	$this->form_validation->set_rules('name', ' ', 'trim|required');
        $this->form_validation->set_rules('username', ' ', 'trim|required');
    	$this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('passconf', 'Password Confirmation', 'required|matches[password]');
        // $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[admin.email]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
    	$this->form_validation->set_rules('id', 'id', 'trim');
    	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

};

/* End of file Master_users.php */
/* Location: ./application/controllers/Master_users.php */