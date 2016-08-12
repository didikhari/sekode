<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MY_Controller extends CI_Controller 
 { 

   //set the class variable.
   var $template  = array();
   var $data      = array();
   var $page      = '';
   var $model     = '';
   var $input     = array();
   public $userdata = array();
   

   public function __construct()
   {
        parent::__construct();
        $this->is_logged_in();
        $this->load->library('pagination');
        $this->load->library('form_validation');
   }
    public function is_logged_in()
    {
        $user = $this->session->userdata('username_admin');
        if (!$user) {
            redirect('admin');
        }
        $this->userdata =array(
            '_username' => $user,
        );
       
        
    }

   
   //Load layout    
   public function layout() {
      $path =  $this->uri->segment(1);

      $this->data['_username'] = $this->session->userdata('username_admin');
      $this->data['_akses'] = $this->session->userdata('akses');
      $this->data['list_role'] =  $this->session->userdata('list_role'); 
      
      //role
      $this->data['isview'] = isset(  $this->data['list_role'][$path]['isview'] ) ? ($this->data['list_role'][$path]['isview'] ==1 )?1:0  : 0   ;
      $this->data['iscreate'] = isset(  $this->data['list_role'][$path]['iscreate'] ) ? ($this->data['list_role'][$path]['iscreate'] ==1 )?1:0  : 0   ;
      $this->data['isupdate'] = isset(  $this->data['list_role'][$path]['isupdate'] ) ? ($this->data['list_role'][$path]['isupdate'] ==1 )?1:0  : 0   ;
      $this->data['isdelete'] = isset(  $this->data['list_role'][$path]['isdelete'] ) ? ($this->data['list_role'][$path]['isdelete'] ==1 )?1:0  : 0   ;
      //

      $this->template['sidebar']   = $this->load->view('template/admin/sidebar', $this->data, true);
      $this->template['top']   = $this->load->view('template/admin/top', $this->data, true);
      $this->template['content'] = $this->load->view($this->content, $this->data, true);
      $this->template['footer'] = $this->load->view('template/admin/footer', $this->data, true);
      $this->load->view('template/admin/layout', $this->template);




   }
   
  


}
class user_controller extends CI_Controller{
    public function __construct() {
       parent::__construct();
       $this->is_logged_in_user();
    }

    public function is_logged_in_user()
    {
        $user = $this->session->userdata('username_user');
        if (!$user) {
            redirect('login_user');
        }
        $this->userdata =array(
            '_username' => $user,
        );   
    }

    public function layout() {
      $this->data['_username'] = $this->session->userdata('username_user');
      $this->template['sidebar']   = $this->load->view('template/user/sidebar', $this->data, true);
      $this->template['top']   = $this->load->view('template/user/top', $this->data, true);
      $this->template['content'] = $this->load->view($this->content, $this->data, true);
      $this->template['footer'] = $this->load->view('template/user/footer', $this->data, true);
      $this->load->view('template/user/layout', $this->template);
   }


}