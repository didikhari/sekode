<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LoginController extends CI_Controller {


    public function __construct(){
        parent ::__construct();
        $this->load->model('loginDao');
        $this->load->library('encryption');
    }
	
	public function index(){
        $error = $this->uri->segment(2);
        $errorMsg = null;
        if($error == 'wrongpwd') $errorMsg = 'Incorect Password!';        
        else if($error == 'wrongid') $errorMsg = 'Incorect Username!';
        
        $data = array(
                'title' => 'DidikH',
                'error' => $errorMsg
            );
        $this->template->load('login', 'form-login', $data);
	}
    
    public function doLogin(){
        $usr = $this->input->post('username');
        $pwd = $this->input->post('password');
        $result = $this->loginDao->getUserById($usr);
        if(!empty($result)){
            $storedPwd = $result[0]->PASSWORD;
            $decryptedPwd = $this->encryption->decrypt($storedPwd);
            if($decryptedPwd == $pwd){
                
                $this->session->set_userdata('user_data', $result);
                $this->session->set_userdata('is_log_in', true);
                
                redirect('dashboard', 'refresh');
            }else{
                redirect('login/error/wrongpwd', 'refresh');
            }
        }else{
            redirect('login/error/wrongid', 'refresh');
        }        
    }
    
    public function doLogout(){
        $this->session->sess_destroy();
        redirect('login', 'refresh');
    }
    
    public function forgot_password(){
        $data = array(
                'title' => 'Forgot Password'
            );
        $this->template->load('login', 'forgot-password', $data);
    }
    
    public function send_mail_password(){
        $data = array(
                'title' => 'Forgot Password'
            );
        $this->template->load('login', 'forgot-password', $data);
    }
    
    public function change_password(){
        
    }
}
