<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    
    class LoginDao extends CI_Model{
        
        public function getUserById($username){
            $this->db->where('id', $username);       
            $query = $this->db->get('s_user');
            return $query->result();
        }
    }

?>