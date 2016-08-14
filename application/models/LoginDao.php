<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    
    class LoginDao extends CI_Model{
        
        public function getLoginUser($username, $password){
            $this->db->distinct();
            $query = $this->db->get_where('s_user', array('id' => $username, 'password' => $password));
            return $query->result();
        }
    }

?>