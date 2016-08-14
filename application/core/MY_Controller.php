<?php 
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    
    /**
     * 
     * My Custom controller
     * have common methods, 
     * extends controller with this custom controller
     *     
     **/
     
    class MY_Controller extends CI_Controller {
        
        protected function is_logged_in(){
            $login = $this->session->userdata('is_log_in');
			$user = $this->session->userdata('user');
            
			if(!isset($login) || $login != TRUE){
				redirect('welcome/index', 'refresh');
			}
        }
        
        protected function welcome(){
            $data = array(
                'title' => 'Hijab Cantik',
                'user' => $this->session->userdata('user_data'),            
            );
            $this->load->library('template');
            $this->template->load('default', 'home', $data);
        }
        
        protected function load_template($template, $page, $data){            
            $this->load->library('template');
            $this->template->load($template, $page, $data);
        }
        
        protected function generate_file_download($file_name, $file_content){            
            $this->load->helper('download');
            force_download($file_name, $file_content);
        }
        
        protected function sendMail($from_mail, $name, $array_mail_dest, $message, 
                            $subject, $cc, $bcc, $array_attachment){
            $this->load->library('email');
            $this->email->clear(true);
            
            foreach($array_attachment as $att => $attch){
                $this->email->attach($attch);    
            }
            
            $this->email->from($from_mail, $name);
            // $array_mail_dest=array('one@example.com', 'two@example.com', 'three@example.com');
            $this->email->to($array_mail_dest); 
            $this->email->cc($cc);
            $this->email->bcc($bcc);
            
            $this->email->subject($subject);
            $this->email->message($message);
            
            $this->email->send();
        }
    }
?>