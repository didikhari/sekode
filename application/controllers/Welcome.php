<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {


    public function __construct(){
        parent ::__construct();
        $this->load->model('loginDao');
        $this->load->library('encryption');
    }
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index(){
        $data = array(
                'title' => 'DidikH'
            );
        $this->template->load('login', 'form-login', $data);
	}
    
    public function login(){
        $usr = $this->input->post('username');
        $pwd = $this->input->post('password');
        $result = $this->loginDao->getUserById($usr);
        print_r($result);
        if(isset($result)){
            $storedPwd = $result[0]->PASSWORD;
            echo $storedPwd;
            echo $this->encryption->decrypt($storedPwd);
            die;
            $this->session->set_userdata('user_data', $result);
            $this->session->set_userdata('is_log_in', true);
            
            $data = array(
                'title' => 'DidikH'
            );
            $this->template->load('dashboard', 'welcome_message', $data);
        }
        $this->index();
    }
    
    public function logout(){
        $this->session->sess_destroy();
        redirect('welcome/index', 'refresh');
    }
    
    public function forgot_password(){
        $data = array(
                'title' => 'Forgot Password'
            );
        $this->template->load('login', 'forgot-password', $data);
    }
    
    public function change_password(){
        
    }
}
