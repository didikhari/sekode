<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {


    public function __construct(){
        parent ::__construct();
        $this->load->model('loginDao');
        $this->load->library('encryption');
    }
	
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
        if(isset($result)){
            $storedPwd = $result[0]->PASSWORD;
            $decryptedPwd = $this->encryption->decrypt($storedPwd);
            if($decryptedPwd == $pwd){
                
                $this->session->set_userdata('user_data', $result);
                $this->session->set_userdata('is_log_in', true);
                
                $data = array(
                    'title' => 'DidikH'
                );
                $this->template->load('dashboard', 'welcome_message', $data);
            }else{
                $this->index();
            }
        }else{
            $this->index();
        }        
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
